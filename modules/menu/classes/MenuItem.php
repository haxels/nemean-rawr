<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ragnar
 * Date: 4/16/12
 * Time: 9:13 PM
 * To change this template use File | Settings | File Templates.
 */
class MenuItem
{
    private $menu_id;
    private $label;
    private $link;
    private $parent_id;
    private $order;
    private $menuItems;

    public function __construct($menu_id, $label, $link, $parentID = 0, $order, array $menuItems = array())
    {
        $this->menu_id = $menu_id;
        $this->label = $label;
        $this->link = $link;
        $this->parent_id = $parentID;
        $this->order = $order;
        $this->menuItems = $menuItems;
    }

    public function getMenuId()
    {
        return $this->menu_id;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function getLink()
    {
        return $this->link;
    }

    public function getParentId()
    {
        return $this->parent_id;
    }

    public function isParent()
    {
        return ($this->parent_id == 0) ? true : false;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function setOrder($order)
    {
        $this->order = $order;
    }

    public function addItem(MenuItem $item)
    {
        $this->menuItems[] = $item;
    }

    public function getChildren()
    {
        return $this->menuItems;
    }

    public function hasChildren()
    {
        return (count($this->menuItems) > 0) ? true : false;
    }


}
