<?php
/**
 * User: Ragnar
 * Date: 3/25/12
 * Time: 8:13 PM
 */
    class Address
    {
        private $streetaddress;
        private $zipLocation;

        public function __construct($streetAdr, Location $zipLoc)
        {
            $this->streetaddress = $streetAdr;
            $this->zipLocation = $zipLoc;
        }

        public function getStreetaddress()
        {
            return $this->streetaddress;
        }

        public function getZipLocation()
        {
            return $this->zipLocation;
        }
    }
?>