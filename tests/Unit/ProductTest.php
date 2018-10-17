<?php

use App\Product;
use Tests\TestCase;

class ProductTest extends TestCase
{
    protected $product;

    public function setUp()
    {
        parent::setUp();

        $this->product = new Product('fallout 4',59);
    }

    /** @test */
    public function a_product_has_a_name()
    {
        $this->assertEquals('fallout 4',$this->product->name());
    }

    /** @test */
    public function a_product_has_a_price()
    {
        $this->assertEquals(59,$this->product->price());
    }
}