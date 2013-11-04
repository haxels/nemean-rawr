<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserRoles
 *
 * @author havardaxelsen
 */
    class UserRoles {

        private $role_id;
        private $user_id;

        public function getRole_id() {
            return $this->role_id;
        }

        public function setRole_id($role_id) {
            $this->role_id = $role_id;
        }

        public function getUser_id() {
            return $this->user_id;
        }

        public function setUser_id($user_id) {
            $this->user_id = $user_id;
        }
    }

?>
