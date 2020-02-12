<?php


namespace App\Controllers;


use App\Libraries\LDAP;
use App\Models\User;
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
        if ($this->isLoggedIn()) {
            return redirect()->to(base_url(''));
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
                        return redirect()->to(base_url('home'));
                    }

                    $this->session->setFlashdata('errorForm', ['Beim Login ist ein Fehler aufgetreten!']);
                } else {
                    $this->session->setFlashdata('errorForm', ['Die eingegebenen Daten stimmen nicht!']);
                }
            } else {
                $this->session->setFlashdata('errorForm', $validation->getErrors());
            }
            return redirect()->to(base_url('login'));
        }

        $this->global['title'] = 'Login';
        return view('pages/login', $this->global);
    }
}