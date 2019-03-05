<?php

class Group extends CI_Model {
    
    private $ID;
    private $name;
    private $roles = array();
    
    public function setName($name){
        $this->name = $name;
    }
    
    public function addRole($role) {
        $this->roles[] = $role;
    }

    public function save() {
        $this->db->insert("groups",$this);
    }
}
