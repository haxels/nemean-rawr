<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 28.06.12
 * Time: 14:36
 * To change this template use File | Settings | File Templates.
 */
class Leader
{
    private $leader_id;
    private $name;

    public function __construct($leader_id, $name)
    {
        $this->leader_id = $leader_id;
        $this->name = $name;
    }

    public function getLeaderId()
    {
        return $this->leader_id;
    }

    public function getName()
    {
        return $this->name;
    }
}
