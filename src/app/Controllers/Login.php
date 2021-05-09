<?php

namespace App\Controllers;

use App\Libraries\LDAP;
use App\Models\User;
use CodeIgniter\HTTP\RedirectResponse;
use Config\Services;

/**
 * Class Login
 *
 * @package App\Controllers
 * @author  Lars Riße <me@elyday.net>
 */
class Login extends CoreController
{
    public function index()
    {
        $valid = $this->isRequestValid();

        if ($valid !== null) {
            return $valid;
        }

        if ($this->isPost()) {
            $validation = Services::validation();
            $rules = [
                'username' => [
                    'label' => 'Benutzername',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Du musst einen Benutzernamen angeben!',
                    ]
                ],
                'password' => [
                    'label' => 'Passwort',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Du musst ein Passwort angeben!',
                    ]
                ]
            ];

            if ($this->validate($rules)) {
                $username = $this->request->getPost('username');
                $password = $this->request->getPost('password');

                $ldap = new LDAP();
                if ($ldap->checkCredentials($username, $password)) {
                    $userData = $ldap->getUserData($username);
                    $userModel = new User();

                    if ($userData !== null && $userModel->saveOrUpdateByUserData($userData)) {
                        $this->session->set('isLoggedIn', true);
                        $this->session->set('userSId', $userData->sId);
                        return redirect()->to(site_url('home'));
                    }

                    $this->session->setFlashdata('errorForm', ['Beim Login ist ein Fehler aufgetreten!']);
                } else {
                    $this->session->setFlashdata('errorForm', ['Die eingegebenen Daten stimmen nicht!']);
                }
            } else {
                $this->session->setFlashdata('errorForm', $validation->getErrors());
            }
            return redirect()->to(site_url('login'));
        }

        $this->global['title'] = 'Login';
        return view('pages/login', $this->global);
    }

    /**
     * @inheritDoc
     */
    protected function isRequestValid(?string $modelId = null): ?RedirectResponse
    {
        if ($this->isLoggedIn()) {
            return redirect()->to(site_url(''));
        }

        return null;
    }
}