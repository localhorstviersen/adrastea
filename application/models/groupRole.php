<?php

class GroupRole extends CI_Model {
    
    private $groupId;
    private $roleId;
    
    public function setGroupId($groupId){
        $this->groupId = $groupId;
    }
    
    public function setRoleId($roleId) {
        $this->roleId = $roleId;
    }

    public function save() {
        $this->db->insert("groupRoles", $this);
    }
}
