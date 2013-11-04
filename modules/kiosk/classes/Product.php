<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 11.10.12
 * Time: 09:09
 * To change this template use File | Settings | File Templates.
 */
class Product
{
    private $product_id;
    private $image;
    private $name;
    private $description;
    private $price;
    private $type;

    public function __construct($product_id, $image, $name, $description, $price, $type)
    {
        $this->product_id = $product_id;
        $this->image = $image;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->type = $type;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getProductId()
    {
        return $this->product_id;
    }

    public function getType()
    {
        return $this->type;
    }
}
