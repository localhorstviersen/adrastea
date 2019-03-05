<?php

class Role extends CI_Model {
    
    private $ID;
    private $name;
    
    public function setName($name){
        $this->name = $name;
    }

    public function save() {
        $this->db->insert("roles",$this);
    }
    
    public static function getRoleById($id) {
        $query = $this->db->get_where('roles',array('id' => $id));
        foreach($query->result() as $row) {
            $role = new Role();
            $role->ID = $row->id;
            $role->name = $row->name;
            return $role;
        }
    }
}
