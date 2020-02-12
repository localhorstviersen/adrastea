<?php


namespace App\Controllers\Admin;


use App\Controllers\CoreController;
use App\Models\RolesRights;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\View\Table;
use Config\Services;
use ReflectionException;

/**
 * Class Roles
 *
 * @package App\Controllers\Admin\User
 * @author  Lars Riße <me@elyday.net>
 */
class Roles extends CoreController
{
    public function index()
    {
        $valid = $this->isRequestValid(null);

        if ($valid !== null) {
            return $valid;
        }

        $this->global['title'] = lang('roles.title');

        $customSettings = [
            'table_open' => '<table class="table table-bordered" id="roles" width="100%" cellspacing="0">'
        ];

        $rolesModel = new \App\Models\Roles();
        $roles = $rolesModel->findAll();

        $table = new Table($customSettings);
        $table->setHeading(
            [
                lang('roles.table.id'),
                lang('roles.table.name'),
                ''
            ]
        );

        /** @var \App\Models\Roles $role */
        foreach ($roles as $role) {
            $editUrl =
                '<a href="' . base_url('admin/roles/edit/' . $role->id) . '"><i class="fa fa-pencil-alt"></i></a>';
            $deleteUrl =
                '<a href="' . base_url('admin/roles/delete/' . $role->id) . '"><i class="fa fa-trash-alt"></i></a>';

            $table->addRow(
                [
                    $role->id,
                    $role->name,
                    $editUrl . ' ' . $deleteUrl
                ]
            );
        }

        $this->global['table'] = $table->generate();

        return view('pages/admin/roles/index', $this->global);
    }

    public function create()
    {
        $valid = $this->isRequestValid(null);

        if ($valid !== null) {
            return $valid;
        }

        if ($this->isPost()) {
            $validation = Services::validation();
            $rules = [
                'name' => [
                    'label' => lang('roles.form.name'),
                    'rules' => 'required|alpha_numeric_space',
                    'errors' => [
                        'required' => lang('form.name.validation.required'),
                        'alpha_numeric_space' => lang('form.name.validation.alpha_numeric_space'),
                    ]
                ]
            ];

            if (!$this->validate($rules)) {
                $errors = implode('<br>', $validation->getErrors());
                $this->session->setFlashdata('errorForm', $errors);
                return redirect()->to(base_url('admin/roles/create'));
            }

            $rolesModel = new \App\Models\Roles();
            $data = ['name' => $this->request->getPost('name')];
            $roleId = $rolesModel->insert($data);
            $this->updateGlobalRights($roleId);

            $this->session->setFlashdata('successForm', lang('roles.form.create.success'));
            return redirect()->to(base_url('admin/roles'));
        }

        $this->global['globalRights'] = RolesRights::getAllGlobalRights();
        $this->global['title'] = lang('roles.title.create');
        return view('pages/admin/roles/create', $this->global);
    }

    /**
     * @param int $roleId
     *
     * @return RedirectResponse|string|null
     * @throws ReflectionException
     */
    public function edit(int $roleId)
    {
        $rolesModel = new \App\Models\Roles();
        $rolesRightsModel = new RolesRights();
        $valid = $this->isRequestValid($roleId);

        if ($valid !== null) {
            return $valid;
        }

        if ($this->isPost()) {
            $validation = Services::validation();
            $rules = [
                'name' => [
                    'label' => lang('roles.form.name'),
                    'rules' => 'required|alpha_numeric_space',
                    'errors' => [
                        'required' => lang('form.name.validation.required'),
                        'alpha_numeric_space' => lang('form.name.validation.alpha_numeric_space'),
                    ]
                ]
            ];

            if (!$this->validate($rules)) {
                $errors = implode('<br>', $validation->getErrors());
                $this->session->setFlashdata('errorForm', $errors);
                return redirect()->to(base_url('admin/roles/edit/' . $roleId));
            }

            $data = ['name' => $this->request->getPost('name')];
            $rolesModel->update($roleId, $data);
            $this->updateGlobalRights($roleId);

            $this->session->setFlashdata('successForm', lang('roles.form.edit.success'));
            return redirect()->to(base_url('admin/roles'));
        }

        $this->global['globalRights'] = RolesRights::getAllGlobalRights();
        $this->global['globalRightActive'] = [];

        foreach ($this->global['globalRights'] as $key => $value) {
            $rolesRight = $rolesRightsModel->where('roleId', $roleId)->where('right', $key)->find();
            $this->global['globalRightActive'][$key] =
                count($rolesRight) === 1 && $rolesRight[0] instanceof RolesRights;
        }

        $this->global['title'] = lang('roles.title.edit', ['name' => $this->global['role']->name]);

        return view('pages/admin/roles/edit', $this->global);
    }

    public function delete(int $roleId)
    {
        $valid = $this->isRequestValid($roleId);

        if ($valid !== null) {
            return $valid;
        }

        if ($this->isPost()) {
            $rolesModel = new \App\Models\Roles();
            $rolesModel->delete($roleId);

            $this->session->setFlashdata('successForm', lang('roles.form.delete.success'));
            return redirect()->to(base_url('admin/roles'));
        }

        $this->global['title'] = lang('roles.title.delete', ['name' => $this->global['role']->name]);
        return view('pages/admin/roles/delete', $this->global);
    }

    /**
     * This method will check if the incoming Request is valid.
     *
     * @param int|null $roleId
     *
     * @return RedirectResponse|null
     */
    private function isRequestValid(?int $roleId): ?RedirectResponse
    {
        if (!$this->isLoggedIn()) {
            return redirect()->to(base_url('login'));
        }

        if (!$this->user->hasRight(RolesRights::RIGHT_GLOBAL_ADMIN_ROLE)) {
            $this->session->setFlashdata('errorForm', lang('general.noPermission'));
            return redirect()->to(base_url(''));
        }

        if ($roleId !== null) {
            $rolesModel = new \App\Models\Roles();
            $this->global['role'] = $rolesModel->find($roleId);

            if (!$this->global['role'] instanceof \App\Models\Roles) {
                $this->session->setFlashdata('errorForm', lang('roles.notFound'));
                return redirect()->to(base_url('admin/roles'));
            }
        }

        return null;
    }

    /**
     * This method will update the rights of the specified role.
     *
     * @param int $roleId
     *
     * @throws ReflectionException
     */
    private function updateGlobalRights(int $roleId): void
    {
        $rolesRightsModel = new RolesRights();
        $posts = $this->request->getPost();
        $globalRights = [];

        if (isset($posts['globalRight'])) {
            foreach ($posts['globalRight'] as $key => $value) {
                if ($value === 'on') {
                    $globalRights[] = $key;
                }
            }
        }

        $rolesRightsModel->where('roleId', $roleId)->delete();

        foreach ($globalRights as $globalRight) {
            $data = [
                'roleId' => $roleId,
                'right' => $globalRight
            ];
            $rolesRightsModel->save($data);
        }
    }
}