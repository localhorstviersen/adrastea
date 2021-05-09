<?php


namespace App\Controllers\Admin;


use App\Controllers\CoreController;
use App\Models\Roles\Rights;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\View\Table;
use Config\Services;
use ReflectionException;

/**
 * Class Role
 *
 * @package App\Controllers\Admin\User
 * @author  Lars Riße <me@elyday.net>
 */
class Role extends CoreController
{
    public function index()
    {
        $valid = $this->isRequestValid();

        if ($valid !== null) {
            return $valid;
        }

        $this->global['title'] = lang('role.title.title');

        $customSettings = [
            'table_open' => '<table class="table table-bordered" id="role" width="100%" cellspacing="0">'
        ];

        $roleModel = new \App\Models\Role();
        $roles = $roleModel->findAll();

        $table = new Table($customSettings);
        $table->setHeading(
            [
                lang('role.table.id'),
                lang('role.table.name'),
                ''
            ]
        );

        /** @var \App\Models\Role $role */
        foreach ($roles as $role) {
            $editUrl =
                '<a href="' . site_url('admin/role/edit/' . $role->id) . '"><i class="fa fa-pencil-alt"></i></a>';
            $deleteUrl =
                '<a href="' . site_url('admin/role/delete/' . $role->id) . '"><i class="fa fa-trash-alt"></i></a>';

            $table->addRow(
                [
                    $role->id,
                    $role->name,
                    $editUrl . ' ' . $deleteUrl
                ]
            );
        }

        $this->global['table'] = $table->generate();

        return view('pages/admin/role/index', $this->global);
    }

    public function create()
    {
        $valid = $this->isRequestValid();

        if ($valid !== null) {
            return $valid;
        }

        if ($this->isPost()) {
            $validation = Services::validation();
            $validation->setRuleGroup('roleRules');

            if (!$validation->withRequest($this->request)->run()) {
                $errors = implode('<br>', $validation->getErrors());
                $this->session->setFlashdata('errorForm', $errors);
                return redirect()->to(site_url('admin/role/create'));
            }

            $roleModel = new \App\Models\Role();
            $data = ['name' => $this->request->getPost('name')];
            $roleId = $roleModel->insert($data);
            $this->updateGlobalRights($roleId);

            $this->session->setFlashdata('successForm', lang('role.form.create.success'));
            return redirect()->to(site_url('admin/role'));
        }

        $this->global['globalRights'] = Rights::getAllGlobalRights();
        $this->global['title'] = lang('role.title.create');
        return view('pages/admin/role/create', $this->global);
    }

    /**
     * @param int $roleId
     *
     * @return RedirectResponse|string|null
     * @throws ReflectionException
     */
    public function edit(int $roleId)
    {
        $roleModel = new \App\Models\Role();
        $roleRightsModel = new Rights();
        $valid = $this->isRequestValid($roleId);

        if ($valid !== null) {
            return $valid;
        }

        if ($this->isPost()) {
            $validation = Services::validation();
            $validation->setRuleGroup('roleRules');

            if (!$validation->withRequest($this->request)->run()) {
                $errors = implode('<br>', $validation->getErrors());
                $this->session->setFlashdata('errorForm', $errors);
                return redirect()->to(site_url('admin/role/edit/' . $roleId));
            }

            $data = ['name' => $this->request->getPost('name')];
            $roleModel->update($roleId, $data);
            $this->updateGlobalRights($roleId);

            $this->session->setFlashdata('successForm', lang('role.form.edit.success'));
            return redirect()->to(site_url('admin/role'));
        }

        $this->global['globalRights'] = Rights::getAllGlobalRights();
        $this->global['globalRightActive'] = [];

        foreach ($this->global['globalRights'] as $key => $value) {
            $roleRight = $roleRightsModel->where('roleId', $roleId)->where('right', $key)->find();
            $this->global['globalRightActive'][$key] =
                count($roleRight) === 1 && $roleRight[0] instanceof Rights;
        }

        $this->global['title'] = lang('role.title.edit', ['name' => $this->global['role']->name]);

        return view('pages/admin/role/edit', $this->global);
    }

    public function delete(int $roleId)
    {
        $valid = $this->isRequestValid($roleId);

        if ($valid !== null) {
            return $valid;
        }

        if ($this->isPost()) {
            $roleModel = new \App\Models\Role();
            $roleModel->delete($roleId);

            $this->session->setFlashdata('successForm', lang('role.form.delete.success'));
            return redirect()->to(site_url('admin/role'));
        }

        $this->global['title'] = lang('role.title.delete', ['name' => $this->global['role']->name]);
        return view('pages/admin/role/delete', $this->global);
    }

    /**
     * @inheritDoc
     */
    protected function isRequestValid(?string $modelId = null): ?RedirectResponse
    {
        if (!$this->isLoggedIn()) {
            return redirect()->to(site_url('login'));
        }

        if (!$this->user->hasRight(Rights::RIGHT_GLOBAL_ADMIN_ROLE)) {
            $this->session->setFlashdata('errorForm', lang('general.noPermission'));
            return redirect()->to(site_url(''));
        }

        if ($modelId !== null) {
            $roleModel = new \App\Models\Role();
            $this->global['role'] = $roleModel->find($modelId);

            if (!$this->global['role'] instanceof \App\Models\Role) {
                $this->session->setFlashdata('errorForm', lang('role.notFound'));
                return redirect()->to(site_url('admin/role'));
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
        $roleRightsModel = new Rights();
        $posts = $this->request->getPost();
        $globalRights = [];

        if (isset($posts['globalRight'])) {
            foreach ($posts['globalRight'] as $key => $value) {
                if ($value === 'on') {
                    $globalRights[] = $key;
                }
            }
        }

        $roleRightsModel->where('roleId', $roleId)->delete();

        foreach ($globalRights as $globalRight) {
            $data = [
                'roleId' => $roleId,
                'right' => $globalRight
            ];
            $roleRightsModel->save($data);
        }
    }
}