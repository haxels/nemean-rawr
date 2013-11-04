<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Role
 *
 * @author havardaxelsen
 */
class Role {
    
    private $role_id;
    private $role;
    private $level;

    public function __construct($role_id, $role, $level)
    {
        $this->role_id = $role_id;
        $this->role = $role;
        $this->level = $level;
    }
    
    public function getRole_id() {
        return $this->role_id;
    }

    public function setRole_id($role_id) {
        $this->role_id = $role_id;
    }

    public function getRole() {
        return $this->role;
    }

    public function getRoleLevel()
    {
        return $this->level;
    }

    public function setRole($role) {
        $this->role = $role;
    }


}

?>
