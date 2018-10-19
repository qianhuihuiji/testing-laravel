<?php 

namespace App;

class Order 
{
    protected $products = [];
    protected $total = 0;

    public function add(Product $product)
    {
        $this->products[] = $product;
        $this->total += $product->price();
    }

    public function products()
    {
        return $this->products;
    }

    public function total()
    {
        return $this->total;
    }
}