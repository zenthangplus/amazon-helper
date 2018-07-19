<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use ZenThangPlus\AmazonHelper\Product;

class ProductTest extends TestCase {

    /**
     * Test calculate dimension
     */
    public function testDimension() {
        $product = new Product;
        $product->set_width( 1.2 );
        $product->set_height( 1.2 );
        $product->set_depth( 1.2 );
        $this->assertEquals( 1.728, $product->dimension() );
    }

    /**
     * Test set weight coefficient
     */
    public function testSetWeightCoefficient() {
        $product = new Product;
        $product->set_weight( 1.5 );
        $product->set_weight_coefficient( 5 );
        $this->assertEquals( 7.5, $product->shipping_fee() );
    }

    /**
     * Test set dimension coefficient
     */
    public function testSetDimensionCoefficient() {
        $product = new Product;
        $product->set_width( 1.2 );
        $product->set_height( 1.2 );
        $product->set_depth( 1.2 );
        $product->set_dimension_coefficient( 5 );
        $this->assertEquals( 8.64, $product->shipping_fee() );
    }

    /**
     * Test set custom shipping fee
     */
    public function testCustomShippingFee() {
        $product = new Product;
        $product->set_weight( 1.5 );
        $product->set_width( 1.2 );
        $product->set_height( 1.2 );
        $product->set_depth( 1.2 );
        $product->set_weight_coefficient( 5 );
        $product->set_dimension_coefficient( 5 );
        $product->custom_shipping_fee( 11.11 );
        $this->assertEquals( 11.11, $product->shipping_fee() );
    }

    /**
     * Test calculate shipping fee
     */
    public function testShippingFee() {
        $product = new Product;
        $product->set_price( 10 );
        $product->set_weight( 1.5 );
        $product->set_width( 1.2 );
        $product->set_height( 1.2 );
        $product->set_depth( 1.2 );
        $product->set_weight_coefficient( 5 );
        $product->set_dimension_coefficient( 5 );
        $this->assertEquals( 8.64, $product->shipping_fee() );
    }

    /**
     * Test calculate final price
     */
    public function testFinalPrice() {
        $product = new Product;
        $product->set_price( 10 );
        $product->set_weight( 1.5 );
        $product->set_width( 1.2 );
        $product->set_height( 1.2 );
        $product->set_depth( 1.2 );
        $product->set_weight_coefficient( 5 );
        $product->set_dimension_coefficient( 5 );
        $this->assertEquals( 18.64, $product->final_price() );
    }
}
