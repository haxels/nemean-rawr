<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 11.10.12
 * Time: 09:37
 * To change this template use File | Settings | File Templates.
 */
require_once MODULEPATH . 'kiosk/classes/Order.php';

class OrderMapper extends DataMapper
{
    protected $entityTable = 'kos_orders';
    protected $primaryKey  = 'ordreID';

    public function insert(Order $o)
    {
        return $this->adapter->insert($this->entityTable, [ 'brukerID' => $o->getUserId(),
                                                            'dato' => $o->getDate(),
                                                            'levert' => $o->getDelivered(),
                                                            'pris' => $o->getPrice(),
                                                            'payType' => $o->getPayType()]);
    }

    public function insertRelation($order_id, $product_id)
    {
        $sql = sprintf('INSERT INTO `kos_orders_products` VALUES (%s, %s)', (int) $order_id, (int) $product_id);
        return $this->adapter->prepare($sql)->execute();
    }

    public function fetchRelate($orderBy, $levert)
    {
        $sql = sprintf('SELECT `o`.*, `u`.`firstname`, `u`.`lastname`, `r`.`seat_id` FROM `kos_orders` `o` LEFT JOIN `usr_users` `u` ON (`u`.`user_id` = `o`.`brukerID`) LEFT JOIN `rsv_reservations` `r` ON (`r`.`user_id` = `u`.`user_id`) WHERE `o`.`levert` = %s ORDER BY `o`.`ordreID` %s', (int) $levert, $orderBy);
        $this->adapter->prepare($sql)->execute();
        $rows = $this->adapter->fetchAll();
        $retVal = [];
        foreach ($rows as $row)
        {
            $retVal[] = $this->createEntity2($row);
        }
        return $retVal;
    }

    public function fetchRelate2($order_id)
    {
        $sql = sprintf('SELECT `p`.* FROM `kos_products` `p` LEFT JOIN `kos_orders_products` `op` ON (`op`.`vareID` = `p`.`id`) WHERE `op`.`ordreID` = %s ', (int) $order_id);
        $this->adapter->prepare($sql)->execute();
        $rows = $this->adapter->fetchAll();
        $retVal = [];
        foreach ($rows as $row)
        {
            $retVal[] = $this->createEntity3($row);
        }
        return $retVal;
    }

    public function deliverOrder($order_id)
    {
        $sql = sprintf('UPDATE `kos_orders` SET `levert` = 1 WHERE `ordreID` = %s', (int) $order_id);
        return $this->adapter->prepare($sql)->execute();
    }

    public function undeliverOrder($order_id)
    {
        $sql = sprintf('UPDATE `kos_orders` SET `levert` = 0 WHERE `ordreID` = %s', (int) $order_id);
        return $this->adapter->prepare($sql)->execute();
    }

    public function close()
    {
        $sql = sprintf('UPDATE `settings` SET `value` = 0 WHERE `name` = \'kiosk_open\'');
        return $this->adapter->prepare($sql)->execute();
    }

    public function open()
    {
        $sql = sprintf('UPDATE `settings` SET `value` = 1 WHERE `name` = \'kiosk_open\'');
        return $this->adapter->prepare($sql)->execute();
    }

    public function createEntity(array $row)
    {
        return new Order($row['ordreID'], $row['brukerID'], $row['dato'], $row['levert'], $row['pris'], $row['payType'], '', []);
    }

    public function createEntity2(array $row)
    {
        return new Order($row['ordreID'], $row['brukerID'], $row['dato'], $row['levert'], $row['pris'], $row['payType'], $row['firstname'] . ' ' . $row['lastname'], [], $row['seat_id']);
    }

    public function createEntity3(array $row)
    {
        return new Product($row['id'], $row['img'], $row['name'], $row['description'], $row['price'], $row['type']);
    }

}
