<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Field
 *
 * @author havardaxelsen
 */
class Field {
    
    
    private $name;
    private $value;
    private $rules;
    private $opts;
    
    public function __construct($name, $value, $rules, $opts) {
        
        $this->name     = $name;
        $this->value    = $value;
        $this->rules    = $rules;
        $this->opts     = $opts;
    }

    public function getOpts() {
        return $this->opts;
    }

    public function setOpts($opts) {
        $this->opts = $opts;
    }

        public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = $value;
    }

    public function getRules() {
        return $this->rules;
    }

    public function setRules($rules) {
        $this->rules = $rules;
    }

        //put your code here
}

?>
