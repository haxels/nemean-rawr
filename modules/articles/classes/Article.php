<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Article
 *
 * @author havardaxelsen
 */
class Article {
    
    private $article_id;
    private $poll;
    private $date_created;
    private $approved;
    private $approved_by;
    private $publish_date;
    private $title;
    private $ingress;
    private $text;
    private $user;
    private $category_id;
    private $picture;

    public function __construct($article_id, Poll $p = null, $date_created, $approved, User $aBy = null, $publish_date, $title, $ingress, $text, User $user, $caID, $img)
    {
        $this->article_id   = $article_id;
        $this->poll         = $p;
        $this->date_created = $date_created;
        $this->approved     = $approved;
        $this->approved_by  = $aBy;
        $this->publish_date = $publish_date;
        $this->title        = $title;
        $this->ingress      = $ingress;
        $this->text         = $text;
        $this->user         = $user;
        $this->category_id  = $caID;
        $this->picture      = $img;
    }


    
    public function getArticle_id() {
        return $this->article_id;
    }

    public function setArticle_id($article_id) {
        $this->article_id = $article_id;
    }

    public function getPoll_id() {
        return ($this->poll != null) ? $this->poll->getPoll_id() : 0;
    }

    public function setPoll_id($poll_id) {
        $this->poll_id = $poll_id;
    }

    public function getDate_created() {
        return $this->date_created;
    }

    public function setDate_created($date_created) {
        $this->date_created = $date_created;
    }

    public function getApproved() {
        return $this->approved;
    }

    public function setApproved($approved) {
        $this->approved = $approved;
    }

    public function getApproved_by() {
        return $this->approved_by;
    }

    public function setApproved_by($approved_by) {
        $this->approved_by = $approved_by;
    }

    public function getPublish_date() {
        //return date("d/m Y - H:i:s", strtotime($this->publish_date));
        return $this->publish_date;
    }

    public function isPublished()
    {
        return ($this->publish_date == '0000-00-00 00:00:00') ? false : true;
    }

    public function setPublish_date($publish_date) {
        $this->publish_date = $publish_date;
    }

    public function getTimeToPublish()
    {
        $now = time();
        $publish = strtotime($this->getPublish_date());

        if ($publish <= $now)
        {
            return 'Published';
        }
        else
        {
            $timeLeft = $publish - $now;
            $days = floor($timeLeft / (60*60*24));
            $hours = floor($timeLeft / (60*60));
            $minutes = floor($timeLeft / 60);
            if ($days >= 1)
            {
                if ($days > 1)
                {
                    return $days . ' days';
                }
                else
                {
                    return $days . ' day';
                }
            }
            elseif ($hours < 24 && $hours > 1)
            {
                return $hours . ' hours';
            }
            elseif ($minutes <= 60)
            {
                if ($minutes <= 1)
                {
                    return $minutes . ' minute';
                }
                else
                {
                    return $minutes . ' minutes';
                }
            }
        }

    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getIngress() {
        return $this->ingress;
    }

    public function setIngress($ingress) {
        $this->ingress = $ingress;
    }

    public function getText() {
        return $this->text;
    }

    public function setText($text) {
        $this->text = $text;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser(User $user) {
        $this->user = $user;
    }

    public function getAuthorId()
    {
        return $this->user->getUserId();
    }

    public function isOwnerOfArticle($user_id)
    {
        return ($this->user->getUserId() == $user_id) ? true : false;
    }

    public function getPicture()
    {
        return $this->picture;
    }

    public function getCategoryID()
    {
        return $this->category_id;
    }

}

?>