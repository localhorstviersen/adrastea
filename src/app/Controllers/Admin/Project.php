<?php


namespace App\Controllers\Admin;

use App\Controllers\CoreController;
use App\Libraries\Util;
use App\Models\Project\Ticket\Field;
use App\Models\ProjectRoleRights;
use App\Models\Roles\Rights;
use App\Models\Project\Ticket\Status;
use App\Models\Project\Ticket\Types;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\View\Table;
use Config\Services;

/**
 * Class Project
 *
 * @package App\Controllers\Admin
 * @author  Lars Riße <me@elyday.net>
 */
class Project extends CoreController
{
    public function index()
    {
        $projectModel = new \App\Models\Project();
        $valid = $this->isRequestValid();

        if ($valid !== null) {
            return $valid;
        }

        $this->global['title'] = lang('admin.project.title.title');

        $customSettings = [
            'table_open' => '<table class="table table-bordered" id="projects" width="100%" cellspacing="0">'
        ];

        $projects = $projectModel->findAll();

        $table = new Table($customSettings);
        $table->setHeading(
            [
                lang('admin.project.table.name'),
                lang('admin.project.table.description'),
                lang('admin.project.table.createdAt'),
                ''
            ]
        );

        /** @var \App\Models\Project $project */
        foreach ($projects as $project) {
            $managePermissionsUrl = '<a href="' . base_url('admin/project/managePermissions/' . $project->id) .
                '"><i class="fa fa-key"></i></a>';
            $editUrl =
                '<a href="' . base_url('admin/project/edit/' . $project->id) . '"><i class="fa fa-pencil-alt"></i></a>';
            $deleteUrl = '<a href="' . base_url('admin/project/delete/' . $project->id) .
                '"><i class="fa fa-trash-alt"></i></a>';

            $table->addRow(
                [
                    $project->name,
                    $project->description,
                    Util::formatDateTime($project->created_at),
                    $managePermissionsUrl . ' ' . $editUrl . ' ' . $deleteUrl
                ]
            );
        }

        $this->global['table'] = $table->generate();

        return view('pages/admin/project/index', $this->global);
    }

    public function create()
    {
        $valid = $this->isRequestValid();

        if ($valid !== null) {
            return $valid;
        }

        if ($this->isPost()) {
            $validation = Services::validation();
            $validation->setRuleGroup('projectRules');

            if (!$validation->withRequest($this->request)->run()) {
                $errors = implode('<br>', $validation->getErrors());
                $this->session->setFlashdata('errorForm', $errors);
                return redirect()->to(base_url('admin/project/create'));
            }

            $projectModel = new \App\Models\Project();
            $data = [
                'name' => $this->request->getPost('name'),
                'description' => $this->request->getPost('description')
            ];
            $projectId = $projectModel->insert($data);

            $ticketTypesModel = new Types();
            $ticketStatusModel = new Status();
            $ticketFieldModel = new Field();

            foreach (Types::$defaultTypes as $defaultType) {
                $ticketTypesModel->insert(['name' => $defaultType, 'projectId' => $projectId]);
            }

            foreach (Status::$defaultStatus as $defaultStatus) {
                $ticketStatusModel->insert(['name' => $defaultStatus, 'projectId' => $projectId]);
            }

            foreach (Field::$systemFields as $field) {
                $field['projectId'] = $projectId;
                $field['systemField'] = 1;
                $field['required'] = 1;
                $ticketFieldModel->insert($field);
            }

            $this->session->setFlashdata('successForm', lang('admin.project.form.createSuccess'));
            return redirect()->to(base_url('admin/project'));
        }

        $this->global['title'] = lang('admin.project.title.create');

        return view('pages/admin/project/create', $this->global);
    }

    public function edit(int $projectId)
    {
        $valid = $this->isRequestValid($projectId);

        if ($valid !== null) {
            return $valid;
        }

        if ($this->isPost()) {
            $validation = Services::validation();
            $validation->setRuleGroup('projectRules');

            if (!$validation->withRequest($this->request)->run()) {
                $errors = implode('<br>', $validation->getErrors());
                $this->session->setFlashdata('errorForm', $errors);
                return redirect()->to(base_url('admin/project/edit/' . $projectId));
            }

            $projectModel = new \App\Models\Project();
            $data = [
                'name' => $this->request->getPost('name'),
                'description' => $this->request->getPost('description')
            ];
            $projectModel->update($projectId, $data);

            $this->session->setFlashdata('successForm', lang('admin.project.form.editSuccess'));
            return redirect()->to(base_url('admin/project'));
        }

        $this->global['title'] = lang('admin.project.title.edit', ['name' => $this->global['project']->name]);

        return view('pages/admin/project/edit', $this->global);
    }

    public function delete(int $projectId)
    {
        $valid = $this->isRequestValid($projectId);

        if ($valid !== null) {
            return $valid;
        }

        if ($this->isPost()) {
            $projectModel = new \App\Models\Project();
            $projectModel->delete($projectId);

            $this->session->setFlashdata('successForm', lang('admin.project.form.deleteSuccess'));
            return redirect()->to(base_url('admin/project'));
        }

        $this->global['title'] = lang('admin.project.title.delete', ['name' => $this->global['project']->name]);

        return view('pages/admin/project/delete', $this->global);
    }

    public function managePermissions(int $projectId)
    {
        $valid = $this->isRequestValid($projectId);

        if ($valid !== null) {
            return $valid;
        }

        $projectRoleRightsModel = new ProjectRoleRights();
        $roleModel = new \App\Models\Role();
        $roles = $roleModel->findAll();

        if ($this->isPost()) {
            $posts = $this->request->getPost();
            $rights = [];

            /** @var \App\Models\Role $role */
            foreach ($roles as $role) {
                if (isset($posts['right'][$role->id])) {
                    foreach ($posts['right'][$role->id] as $key => $value) {
                        if ($value === 'on') {
                            $rights[] = [
                                'role' => $role->id,
                                'right' => $key
                            ];
                        }
                    }
                }
            }

            $projectRoleRightsModel->where('projectId', $projectId)->delete();

            foreach ($rights as $right) {
                $data = [
                    'projectId' => $projectId,
                    'roleId' => $right['role'],
                    'right' => $right['right']
                ];
                $projectRoleRightsModel->save($data);
            }

            $this->session->setFlashdata('successForm', lang('admin.project.form.managePermissionsSuccess'));
            return redirect()->to(base_url('admin/project'));
        }

        $projectRoleRights = $projectRoleRightsModel->where('projectId', $projectId)->findAll();

        $customSettings = [
            'table_open' => '<table class="table table-bordered" width="100%" cellspacing="0">'
        ];

        $table = new Table($customSettings);

        $heading = [''];

        foreach (ProjectRoleRights::getAllProjectRights() as $projectRight) {
            $heading[] = $projectRight;
        }

        $table->setHeading($heading);

        /** @var \App\Models\Role $role */
        foreach ($roles as $role) {
            $item = [$role->name];
            /** @var string $key */
            foreach (ProjectRoleRights::getAllProjectRights() as $key => $value) {
                $active = $this->isRightForProjectAndRoleAssigned($projectRoleRights, $role->id, $key);

                if ($active) {
                    $item[] = '<input checked type="checkbox" name="right[' . $role->id . '][' . $key . ']">';
                } else {
                    $item[] = '<input type="checkbox" name="right[' . $role->id . '][' . $key . ']">';
                }
            }
            $table->addRow($item);
        }

        $this->global['title'] =
            lang('admin.project.title.managePermissions', ['name' => $this->global['project']->name]);
        $this->global['table'] = $table->generate();

        return view('pages/admin/project/managePermissions', $this->global);
    }

    /**
     * @inheritDoc
     */
    protected function isRequestValid(?string $modelId = null): ?RedirectResponse
    {
        if (!$this->isLoggedIn()) {
            return redirect()->to(base_url('login'));
        }

        if (!$this->user->hasRight(Rights::RIGHT_GLOBAL_ADMIN_PROJECT_MANAGE)) {
            $this->session->setFlashdata('errorForm', lang('general.noPermission'));
            return redirect()->to(base_url(''));
        }

        if ($modelId !== null) {
            $projectModel = new \App\Models\Project;
            $this->global['project'] = $projectModel->find($modelId);

            if (!$this->global['project'] instanceof \App\Models\Project) {
                $this->session->setFlashdata('errorForm', lang('admin.project.notFound'));
                return redirect()->to(base_url('admin/project'));
            }
        }

        return null;
    }

    /**
     * @param array  $projectRoleRights
     * @param int    $roleId
     * @param string $right
     *
     * @return bool
     */
    private function isRightForProjectAndRoleAssigned(
        array $projectRoleRights,
        int $roleId,
        string $right
    ): bool {
        $array = array_filter(
            $projectRoleRights,
            static function (ProjectRoleRights $value) use ($roleId, $right) {
                return (int)$value->roleId === $roleId && $value->right === $right;
            }
        );

        return count($array) === 1;
    }
}