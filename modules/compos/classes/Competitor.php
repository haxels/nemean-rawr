<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 28.06.12
 * Time: 01:38
 * To change this template use File | Settings | File Templates.
 */
class Competitor
{
    private $competitor_id;
    private $name;

    public function __construct($competitor_id, $name)
    {
        $this->competitor_id = $competitor_id;
        $this->name = $name;
    }

    public function getCompetitorId()
    {
        return $this->competitor_id;
    }

    public function getName()
    {
        return $this->name;
    }
}
