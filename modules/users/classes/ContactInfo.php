<?php
/**
 * User: Ragnar
 * Date: 3/25/12
 * Time: 8:16 PM
 */
    class ContactInfo
    {
        private $telephone;
        private $email;
        private $address;

        public function __construct($telephone = '', $email = '', Address $address = null)
        {
            $this->telephone    = $telephone;
            $this->email        = $email;
            $this->address      = $address;
        }

        public function getAddress()
        {
            return $this->address;
        }

        public function getEmail()
        {
            return $this->email;
        }

        public function getTelephone()
        {
            return $this->telephone;
        }
    }
?>