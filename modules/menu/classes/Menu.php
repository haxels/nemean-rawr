<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ragnar
 * Date: 4/16/12
 * Time: 9:13 PM
 * To change this template use File | Settings | File Templates.
 */
class Menu
{
    private $menuItems;

    public function __construct(array $menuItems = array())
    {
        $this->menuItems = $menuItems;
    }

    public function addItem(MenuItem $item)
    {
        $this->menuItems[] = $item;
    }

    public function getMenu()
    {
        return $this->menuItems;
    }
}
