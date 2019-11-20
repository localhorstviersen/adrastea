<?php


namespace App\Controllers;


use App\Libraries\LDAP;
use Config\Services;

class Login extends CoreController
{
    public function index()
    {
        $this->global['title'] = 'Login';
        return view('layouts/login', $this->global);
    }

    public function submit()
    {
        $validation = Services::validation();
        $rules = [
            'mail' => [
                'label' => 'E-Mail',
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Du musst eine E-Mail Adresse angeben!',
                    'valid_email' => 'Bitte gebe eine korrekte E-Mail Adresse ein'
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
            $mail = $this->request->getPost('mail');
            $password = $this->request->getPost('password');

            $ldap = new LDAP();
            if ($ldap->checkCredentials($mail, $password)) {
                var_dump($ldap->getUserInfo($mail, $password));
            }
            $this->session->setFlashdata('errorForm', ['Die eingegebenen Daten stimmen nicht!']);
        } else {
            $this->session->setFlashdata('errorForm', $validation->getErrors());
        }
        //return redirect()->to(base_url('login'));
    }
}