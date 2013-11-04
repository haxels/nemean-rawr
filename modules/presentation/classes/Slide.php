<?php
/**
 * Created by JetBrains PhpStorm.
 * User: havardaxelsen
 * Date: 2/13/13
 * Time: 10:50 PM
 * To change this template use File | Settings | File Templates.
 */
class Slide
{
    private $slide_id;
    private $content;
    private $title;
    private $effects;

    public function __construct($id, $title="", $content="", $effects){

        $this->slide_id = $id;
        $this->content =  $content;
        $this->title = $title;
        $this->effects = $effects;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getEffects()
    {
        return $this->effects;
    }

    public function getSlideId()
    {
        return $this->slide_id;
    }

    public function printContent()
    {
        echo $this->content;
    }


}
