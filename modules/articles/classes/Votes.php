<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Vote
 *
 * @author havardaxelsen
 */
class Vote {
    
    private $answer_id;
    private $user_id;
    
    public function getAnswer_id() {
        return $this->answer_id;
    }

    public function setAnswer_id($answer_id) {
        $this->answer_id = $answer_id;
    }

    public function getUser_id() {
        return $this->user_id;
    }

    public function setUser_id($user_id) {
        $this->user_id = $user_id;
    }


}

?>
