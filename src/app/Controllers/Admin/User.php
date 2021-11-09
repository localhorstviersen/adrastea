<?php


namespace App\Controllers\Admin;


use App\Controllers\CoreController;
use App\Libraries\Util;
use App\Models\Roles\Rights;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\View\Table;

/**
 * Class User
 *
 * @package App\Controllers\Admin
 * @author  Lars Riße <me@elyday.net>
 */
class User extends CoreController
{
    /**
     * @throws \Exception
     */
    public function index()
    {
        $valid = $this->isRequestValid();

        if ($valid !== null) {
            return $valid;
        }

        $this->global['title'] = lang('user.title');

        $customSettings = [
            'table_open' => '<table class="table table-bordered" id="roles" width="100%" cellspacing="0">',
        ];

        $userModel = new \App\Models\User();
        $users = $userModel->findAll();

        $table = new Table($customSettings);
        $table->setHeading(
            [
                lang('user.table.name'),
                lang('user.table.mail'),
                lang('user.table.firstLogin'),
                lang('user.table.deactivatedAt'),
                '',
            ]
        );

        /** @var \App\Models\User $user */
        foreach ($users as $user) {
            $assignUrl = '<a href="' . site_url('admin/group?user=') . $user->sId .
                '"><i class="fas fa-user-plus"></i></a>';

            $table->addRow(
                [
                    $user->firstName . ' ' . $user->surname,
                    $user->mail,
                    Util::formatDateTime($user->created_at),
                    $user->deactivatedAt !== null ? Util::formatDateTime($user->deactivatedAt) : '-',
                    $assignUrl,
                ]
            );
        }

        $this->global['table'] = $table->generate();

        return view('pages/admin/user/index', $this->global);
    }

    protected function isRequestValid(?string $modelId = null): ?RedirectResponse
    {
        if (!$this->isLoggedIn()) {
            return redirect()->to(site_url('login'));
        }

        if (!$this->user->hasRight(Rights::RIGHT_GLOBAL_ADMIN_USER)) {
            $this->session->setFlashdata('errorForm', lang('general.noPermission'));

            return redirect()->to(site_url(''));
        }

        return null;
    }
}