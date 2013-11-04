<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ragnar
 * Date: 4/25/12
 * Time: 6:30 PM
 * To change this template use File | Settings | File Templates.
 */
    class Setting
    {
        private $type;
        private $name;
        private $value;

        public function __construct($type, $name, $value)
        {
            $this->type  = $type;
            $this->name  = $name;
            $this->value = $value;
        }

        public function getName()
        {
            return $this->name;
        }

        public function getType()
        {
            return $this->type;
        }

        public function getValue()
        {
            return $this->value;
        }

        public function setValue($value)
        {
            $this->value = $value;
        }

    }