<?php


namespace App\Controllers;


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
        $validation->setRules(
            [
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
            ]
        );

        $this->global['title'] = 'Login';

        if ($validation->run()) {
            // TODO check if account exist
        } else {
            $this->global['errors'] = $validation->listErrors();
        }
        return view('layouts/login', $this->global);
    }
}