<?php


namespace App\Controllers\Admin;


use App\Controllers\CoreController;
use App\Models\RolesRights;
use CodeIgniter\I18n\Time;
use CodeIgniter\View\Table;

/**
 * Class User
 *
 * @package App\Controllers\Admin
 * @author  Lars Riße <me@elyday.net>
 */
class User extends CoreController
{
    public function index()
    {
        if (!$this->isLoggedIn()) {
            return redirect()->to(base_url('login'));
        }

        if (!$this->user->hasRight(RolesRights::RIGHT_GLOBAL_ADMIN_USER)) {
            $this->session->setFlashdata('errorForm', lang('general.noPermission'));
            return redirect()->to(base_url(''));
        }

        $this->global['title'] = lang('user.title');

        $customSettings = [
            'table_open' => '<table class="table table-bordered" id="roles" width="100%" cellspacing="0">'
        ];

        $userModel = new \App\Models\User();
        $users = $userModel->findAll();

        $table = new Table($customSettings);
        $table->setHeading(
            [
                lang('user.table.name'),
                lang('user.table.mail'),
                lang('user.table.firstLogin'),
                ''
            ]
        );

        /** @var \App\Models\User $user */
        foreach ($users as $user) {
            $assignUrl = '<a href="' . base_url('admin/group?user=') . $user->sId .
                '"><i class="fas fa-user-plus"></i></a>';

            $createdAtTime = Time::createFromFormat('Y-m-d H:i:s', $user->created_at);

            $table->addRow(
                [
                    $user->firstName . ' ' . $user->surname,
                    $user->mail,
                    $createdAtTime->format('d.m.Y H:i:s'),
                    $assignUrl
                ]
            );
        }

        $this->global['table'] = $table->generate();

        return view('pages/admin/user/index', $this->global);
    }
}