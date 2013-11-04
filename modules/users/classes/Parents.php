<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Parent
 *
 * @author havardaxelsen
 */
class Parents {
    
    private $parent_id;
    private $telephone;
    private $email;
    private $firstname;
    private $lastname;
    private $hash;
    private $activated;

    public function __construct($parent_id = 0, $telephone = '', $email = '', $firstname = '', $lastname = '', $hash = '', $activated = false)
    {
        $this->parent_id = $parent_id;
        $this->telephone = $telephone;
        $this->email     = $email;
        $this->firstname = $firstname;
        $this->lastname  = $lastname;
        $this->hash      = $hash;
        $this->activated = $activated;
    }

    public function getActivated()
    {
        return $this->activated;
    }

    public function getHash()
    {
        return $this->hash;
    }
    
    public function getParent_id() {
        return $this->parent_id;
    }

    public function setParent_id($parent_id) {
        $this->parent_id = $parent_id;
    }

    public function getTelephone() {
        return $this->telephone;
    }

    public function setActivated($a = true)
    {
        $this->activated = $a;
    }

    public function setTelephone($telephone) {
        $this->telephone = $telephone;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    public function getLastname()
    {
        return $this->lastname;
    }
    
    public function getName() {
    	return $this->firstname ." ". $this->lastname;
    }


}

?>
