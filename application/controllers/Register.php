<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller
{

    public function index()
    {
        $this->load->view('register');
    }

    public function finish()
    {
        $this->load->model('user');
        $this->user->setUsername($this->input->post('username'));
        $this->user->setClearPassword($this->input->post('password'));
        $this->user->setEmailAddress($this->input->post('email'));
        $this->user->save();
    }
}