<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 10.08.12
 * Time: 17:41
 * To change this template use File | Settings | File Templates.
 */
class File
{
    private $name;
    private $tmpName;
    private $size;

    public function __construct($name, $tmpName)
    {
        $this->name     = $name;
        $this->tmpName  = $tmpName;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getTmpName()
    {
        return $this->tmpName;
    }

    public function getSize()
    {
        return filesize($this->getTmpName());
    }

    public function getExtension()
    {
        $fileParts = pathinfo(trim($this->name));
        return strtolower($fileParts['extension']);
    }
}
