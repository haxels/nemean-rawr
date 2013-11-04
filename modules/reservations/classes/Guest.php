<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 1/27/13
 * Time: 1:42 PM
 * To change this template use File | Settings | File Templates.
 */
class Guest
{
    private $guest_id;
    private $name;
    private $date;

    public function __construct($guest_id, $name, $date)
    {
        $this->guest_id = $guest_id;
        $this->name = $name;
        $this->date = $date;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getGuestId()
    {
        return $this->guest_id;
    }

    public function getName()
    {
        return $this->name;
    }
}
