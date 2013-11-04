<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 11.10.12
 * Time: 09:10
 * To change this template use File | Settings | File Templates.
 */
require_once MODULEPATH . 'kiosk/classes/Product.php';

class ProductMapper extends DataMapper
{
    protected $entityTable = 'kos_products';
    protected $primaryKey  = 'id';

    public function insert(Product $p)
    {
        return $this->adapter->insert($this->entityTable, [ 'img' => $p->getImage(),
                                                            'name' => $p->getName(),
                                                            'description' => $p->getDescription(),
                                                            'price' => $p->getPrice(),
                                                            'type' => $p->getType()]);
    }

    public function createEntity(array $row)
    {
        return new Product($row['id'], $row['img'], $row['name'], $row['description'], $row['price'], $row['type']);
    }
}
