<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group extends CI_Controller
{

    public function index()
    {
        $this->load->view('groupCreate');
    }

    public function add()
    {
        $this->load->model('group');
        $this->group->setName($this->input->post('name'));

        $this->group->addRole($role);
        $this->group->save();
    }
}