<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Poll
 *
 * @author havardaxelsen
 */
class Poll {
    
    private $poll_id;
    private $question;
    private $duedate;
    
    public function getPoll_id() {
        return $this->poll_id;
    }

    public function setPoll_id($poll_id) {
        $this->poll_id = $poll_id;
    }

    public function getQuestion() {
        return $this->question;
    }

    public function setQuestion($question) {
        $this->question = $question;
    }

    public function getDuedate() {
        return $this->duedate;
    }

    public function setDuedate($duedate) {
        $this->duedate = $duedate;
    }


}

?>
