<?php
/**
 * User: Ragnar
 * Date: 3/25/12
 * Time: 8:59 PM
 */
    class Location
    {
        private $zipcode;
        private $zipLocation;

        public function __construct($zipcode = '', $zipLocation = '')
        {
            $this->zipcode      = $zipcode;
            $this->zipLocation  = $zipLocation;
        }

        public function getZipLocation()
        {
            return $this->zipLocation;
        }

        public function getZipcode()
        {
            return $this->zipcode;
        }
    }
?>