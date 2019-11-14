<?php


namespace App\Controllers;


class Login extends CoreController
{
    public function index()
    {
        $this->data['title'] = 'Login';

        return view('layouts/login', $this->data);
    }
}