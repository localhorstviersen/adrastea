<?php

/**
 * Class DoMigration
 * @author elyday
 */
class DoMigration extends MY_Controller
{
    public function index()
    {
        $submit = $this->input->post("submit");
        $pin = $this->input->post("pin");

        if (isset($submit) && isset($pin)) {
            if ($pin == "1111") {
                $this->load->library('migration');

                if ($this->migration->current() === FALSE) {
                    $this->global["error"] = $this->migration->error_string();
                } else {
                    $this->global["successful"] = "true";
                }
            } else {
                $this->global["error"] = "Wrong Pin";
            }
        }
        $this->smarty->view("doMigration.tpl", $this->global);
    }
}