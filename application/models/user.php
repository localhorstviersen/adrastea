<?php

class User extends CI_Model {
    
    private $ID;
    private $username;
    private $password;
    private $email;
    
    public function setUsername($username) {
        $this->username = $username;
    }
    
    public function setClearPassword($password) {
        $this->password = hash("sha256",$password);
    }
    
    public function setHashPassword($password) {
        $this->password = $password;
    }
    
    public function setEmailAddress($email) {
        $this->email = $email;
    }

    public function save() {
        $this->db->insert("users",$this);
    }
}
