<?php namespace App\Controllers;

class Home extends CoreController
{
    public function index()
    {
        if (!$this->isLoggedIn()) {
            return redirect()->to(base_url('login'));
        }
    }
}
