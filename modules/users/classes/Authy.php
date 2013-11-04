<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Authy
 *
 * @author havardaxelsen
 */
class Authy {
    
    
    private $username;
    private $password;
    private $activated;
    private $user_id;
    private $hash;

    public function __construct($username, $password, $activated, $user_id, $hash)
    {
        $this->username     = $username;
        $this->password     = $password;
        $this->activated    = $activated;
        $this->user_id      = $user_id;
        $this->hash         = $hash;
    }
    
    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getActivated() {
        return (boolean) $this->activated;
    }

    public function setActivated($activated) {
        $this->activated = $activated;
    }

    public function getUser_id() {
        return $this->user_id;
    }

    public function setUser_id($user_id) {
        $this->user_id = $user_id;
    }

    public function getHash()
    {
        return $this->hash;
    }

    public function setHash($h)
    {
        $this->hash = $h;
    }
}
?>
