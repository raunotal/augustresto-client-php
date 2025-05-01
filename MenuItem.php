<?php


class MenuItem {

    public $name;
    public $description;
    public $price;

    /**
     * MenuItem constructor.
     * @param $name
     * @param $description
     * @param $price
     */
    public function __construct($name, $description, $price)
    {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
    }


    public function __toString()
    {
        return "Toit: $this->name, hind: $this->price";
    }


}