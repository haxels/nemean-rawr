<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 20.06.12
 * Time: 16:05
 * To change this template use File | Settings | File Templates.
 */
class Sponsor
{
    private $sponsor_id;
    private $name;
    private $image;
    private $link;

    public function __construct($sponsor_id, $name, $image, $link)
    {
        $this->sponsor_id = $sponsor_id;
        $this->name = $name;
        $this->image = $image;
        $this->link = $link;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getLink()
    {
        return $this->link;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSponsorId()
    {
        return $this->sponsor_id;
    }
}
