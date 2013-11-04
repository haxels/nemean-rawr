<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 12.06.12
 * Time: 18:22
 * To change this template use File | Settings | File Templates.
 */
class Reservation
{
    private $seat_id;
    private $user_id;
    private $date;
    private $type;
    private $name;

    function __construct($seat_id, $user_id, $date, $type, $name)
    {
        $this->seat_id = $seat_id;
        $this->user_id = $user_id;
        $this->date = $date;
        $this->type = $type;
        $this->name = $name;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getSeatId()
    {
        return $this->seat_id;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getName()
    {
        return ucwords(strtolower($this->name));
    }

    public function setType($type)
    {
        $this->type = $type;
    }
}
