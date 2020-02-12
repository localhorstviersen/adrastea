<?php


namespace App\Controllers\Admin;


use App\Controllers\CoreController;
use App\Models\GroupRoles;
use App\Models\Roles;
use App\Models\RolesRights;
use CodeIgniter\View\Table;

/**
 * Class Group
 *
 * @package App\Controllers\Admin
 * @author  Lars Riße <me@elyday.net>
 */
class Group extends CoreController
{
    public function index()
    {
        $groupModel = new \App\Models\Group();
        $userModel = new \App\Models\User();

        if (!$this->isLoggedIn()) {
            return redirect()->to(base_url('login'));
        }

        if (!$this->user->hasRight(RolesRights::RIGHT_GLOBAL_ADMIN_GROUP)) {
            $this->session->setFlashdata('errorForm', lang('general.noPermission'));
            return redirect()->to(base_url(''));
        }

        $this->global['title'] = lang('group.title');

        $customSettings = [
            'table_open' => '<table class="table table-bordered" id="roles" width="100%" cellspacing="0">'
        ];


        $user = $this->request->getGet('user');
        $user = $userModel->find($user);

        if ($user instanceof \App\Models\User) {
            $groups = $user->getGroups();
            $expectedGroups = [];

            /** @var \App\Models\Group $group */
            foreach ($groups as $group) {
                $expectedGroups[] = $group->sId;
            }

            $groups = $groupModel->whereIn('sId', $expectedGroups)->findAll();
            $this->global['title'] = lang('group.title.user', ['name' => $user->firstName . ' ' . $user->surname]);
        } else {
            $groups = $groupModel->findAll();
        }

        $table = new Table($customSettings);
        $table->setHeading(
            [
                lang('group.table.name'),
                ''
            ]
        );

        /** @var \App\Models\Group $group */
        foreach ($groups as $group) {
            $assignUrl =
                '<a href="' . base_url('admin/group/assign/' . $group->sId) . '"><i class="fas fa-users-cog"></i></a>';


            $table->addRow(
                [
                    $group->name,
                    $assignUrl
                ]
            );
        }

        $this->global['table'] = $table->generate();

        return view('pages/admin/group/index', $this->global);
    }

    public function assign(string $sId)
    {
        if (!$this->isLoggedIn()) {
            return redirect()->to(base_url('login'));
        }

        if (!$this->user->hasRight(RolesRights::RIGHT_GLOBAL_ADMIN_GROUP)) {
            $this->session->setFlashdata('errorForm', lang('general.noPermission'));
            return redirect()->to(base_url(''));
        }

        $groupModel = new \App\Models\Group();
        $groupRolesModel = new GroupRoles();
        $rolesModel = new Roles();

        $this->global['group'] = $groupModel->find($sId);

        if (!$this->global['group'] instanceof \App\Models\Group) {
            $this->session->setFlashdata('errorForm', lang('group.notFound'));
            return redirect()->to(base_url('admin/group'));
        }

        if ($this->isPost()) {
            $posts = $this->request->getPost();
            $roles = [];

            if (isset($posts['role'])) {
                foreach ($posts['role'] as $key => $value) {
                    if ($value === 'on') {
                        $roles[] = $key;
                    }
                }
            }

            $groupRolesModel->where('groupSId', $sId)->delete();

            foreach ($roles as $role) {
                $data = [
                    'groupSId' => $sId,
                    'roleId' => $role
                ];
                $groupRolesModel->save($data);
            }

            $this->session->setFlashdata('successForm', lang('group.assign.success'));
            return redirect()->to(base_url('admin/group'));
        }

        $this->global['roles'] = $rolesModel->findAll();

        foreach ($this->global['roles'] as $role) {
            $count = $groupRolesModel->where('groupSId', $sId)->where('roleId', $role->id)->countAllResults();

            $role->active = $count === 1;
        }

        $this->global['title'] = lang(
            'group.assign.title',
            ['name' => $this->global['group']->name]
        );
        return view('pages/admin/group/assign', $this->global);
    }
}