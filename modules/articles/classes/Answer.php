<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Answers
 *
 * @author havardaxelsen
 */
class Answer {
    
    private $answers;
    private $poll_id;
    private $answer_id;
    
    public function getAnswers() {
        return $this->answers;
    }

    public function setAnswers($answers) {
        $this->answers = $answers;
    }

    public function getPoll_id() {
        return $this->poll_id;
    }

    public function setPoll_id($poll_id) {
        $this->poll_id = $poll_id;
    }

    public function getAnswer_id() {
        return $this->answer_id;
    }

    public function setAnswer_id($answer_id) {
        $this->answer_id = $answer_id;
    }



    
}

?>
