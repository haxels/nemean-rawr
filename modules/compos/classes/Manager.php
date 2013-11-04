<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 28.06.12
 * Time: 14:17
 * To change this template use File | Settings | File Templates.
 */
class Manager
{
    private $id;
    private $name;

    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }
}
