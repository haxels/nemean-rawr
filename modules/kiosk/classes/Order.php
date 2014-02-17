<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 11.10.12
 * Time: 09:38
 * To change this template use File | Settings | File Templates.
 */
class Order
{
    private $order_id;
    private $user_id;
    private $date;
    private $delivered;
    private $price;
    private $payType;
    private $name;
    private $products;
    private $seat_id;

    public function __construct($order_id, $user_id, $date, $delivered, $price, $payType, $name, array $products, $seat_id = 0)
    {
        $this->order_id = $order_id;
        $this->user_id = $user_id;
        $this->date = $date;
        $this->delivered = $delivered;
        $this->price = $price;
        $this->payType = $payType;
        $this->name = $name;
        $this->products = $products;
        $this->seat_id = $seat_id;
    }

    public function getDate()
    {
        return $this->date; //date("d/m H:m", $this->date);
    }

    public function getDelivered()
    {
        return $this->delivered;
    }

    public function getOrderId()
    {
        return $this->order_id;
    }

    public function getPayType()
    {
        return $this->payType;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getProducts()
    {
        return $this->products;
    }

    public function setProducts($products)
    {
        $this->products = $products;
    }

    public function getSeatId()
    {
        return $this->seat_id;
    }

    public function hasProduct($name) {
        $products = $this->getProducts();
        $hasProduct = false;
        foreach ($products as $product) :
            if($product->getName() == $name) {
                return true;
            }
        endforeach;
        return false;
    }

}
