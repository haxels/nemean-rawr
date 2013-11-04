<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author havardaxelsen
 */
class User {
    
    private $user_id;
    private $lastLogin;
    private $regdate;
    private $firstname;
    private $lastname;
    private $birthdate;


    private $contactInfo;
    private $parent;
    private $roles;
    private $authy;

    public function __construct($user_id, $firstname, $lastname, $birthdate = null, ContactInfo $ci = null, Parents $p = null, array $roles = array(), Authy $a = null, $regdate = '', $lastLogin = '')
    {
        $this->user_id      = $user_id;
        $this->firstname    = $firstname;
        $this->lastname     = $lastname;
        $this->contactInfo  = $ci;
        $this->parent       = $p;
        $this->roles        = $roles;
        $this->birthdate    = $birthdate;
        $this->authy        = $a;
        $this->regdate      = $regdate;
        $this->lastLogin    = $lastLogin;
    }

    public function getActivated()
    {
        return ($this->authy != null) ? $this->authy->getActivated() : null;
    }

    /**
     * Return full name of user (Firstname Lastname)
     * @return string
     */
    public function getName()
    {
        return $this->getFirstname() .' '. $this->getLastname();
    }

    public function getBirthdate()
    {
        return date("Y-m-d", strtotime($this->birthdate));
    }

    public function getContactInfo()
    {
        return $this->contactInfo;
    }

    public function getFirstname()
    {
        return ucwords(strtolower($this->firstname));
    }

    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    public function getLastname()
    {
        return ucwords(strtolower($this->lastname));
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function getRegdate()
    {
        return $this->regdate;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function setRoles(array $roles = array())
    {
        $this->roles = $roles;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function isInRole(array $roles = array())
    {
        foreach ($this->roles as $role)
        {
            if (in_array($role->getRole(), $roles))
            {
                return true;
            }
        }
        return false;
    }

    public function getHighestRoleLevel()
    {
        $retVal = 0;
        foreach ($this->roles as $role)
        {
            $retVal = ($role->getRoleLevel() > $retVal) ? $role->getRoleLevel() : $retVal;
        }
        return $retVal;
    }

    public function setParent($parent)
    {
        $this->parent = $parent;
    }


}

?>