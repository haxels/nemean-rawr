<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ragnar
 * Date: 4/16/12
 * Time: 9:59 PM
 * To change this template use File | Settings | File Templates.
 */
require_once 'Menu.php';
require_once 'MenuItem.php';
class MenuMapper extends DataMapper
{
    protected $entityTable = 'menu';
    protected $primaryKey = 'menu_id';

    public function insert(MenuItem $item)
    {
        return $this->adapter->insert($this->entityTable, array('label' => $item->getLabel(), 'link' => $item->getLink(), 'parent_id' => $item->getParentId()));
    }

    public function update(MenuItem $item)
    {
        return $this->adapter->update($this->entityTable, array('label' => $item->getLabel(),
                                                                'link' => $item->getLink(),
                                                                'parent_id' => $item->getParentId(),
                                                                'sort' => $item->getOrder()),
                                      $this->primaryKey.' = '.$item->getMenuId());
    }

    public function deleteChildren($menu_id)
    {
        return $this->adapter->delete($this->entityTable, 'parent_id = '.$menu_id);
    }

    public function getMenu()
    {
        $sql = sprintf('SELECT * FROM `menu` WHERE `parent_id` = 0 ORDER BY `sort` ASC;');
        $rows = $this->adapter->prepare($sql)->execute()->fetchAll();
        $retVal = array();
        foreach ($rows as $row)
        {
            $retVal[$row['menu_id']] = $this->createEntity($row);
        }
        return $retVal;
    }


    protected function createEntity(array $row)
    {
        $children = $this->findAll(array('parent_id' => $row['menu_id']));
        return new MenuItem($row['menu_id'], $row['label'], $row['link'], $row['parent_id'], $row['sort'], $children);
    }

}
