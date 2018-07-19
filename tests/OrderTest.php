<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use ZenThangPlus\AmazonHelper\Order;
use ZenThangPlus\AmazonHelper\Product;

class OrderTest extends TestCase {

    /**
     * Test add new product to order
     */
    public function testAddProduct() {
        $order = new Order();

        $product1 = new Product();
        $product1->set_title( 'USB' );
        $order->add_product( $product1 );

        $product2 = new Product();
        $product2->set_title( 'IPHONE' );
        $order->add_product( $product2 );

        $this->assertEquals( 2, count( $order->products() ) );
    }

    /**
     * Test remove product
     *
     * @depends testAddProduct
     */
    public function testRemoveProduct() {
        $order = new Order();

        $product1 = new Product();
        $product1->set_title( 'USB' );
        $product1_id = $order->add_product( $product1 );

        $product2 = new Product();
        $product2->set_title( 'IPHONE' );
        $order->add_product( $product2 );

        $order->remove_product( $product1_id );
        $this->assertEquals( 1, count( $order->products() ) );
    }

    /**
     * Test list products
     *
     * @depends testAddProduct
     */
    public function testListProducts() {
        $order   = new Order();
        $product = new Product();
        $product->set_title( 'USB' );
        $order->add_product( $product );
        $this->assertEquals( 1, count( $order->products() ) );
    }

    /**
     * Test calculate gross price of order
     *
     * @depends testAddProduct
     */
    public function testCalculateGrossPrice() {
        $order = new Order();

        $product1 = new Product();
        $product1->set_title( 'USB' );
        $product1->set_price( 5.5 );
        $order->add_product( $product1 );

        $product2 = new Product();
        $product2->set_title( 'IPHONE' );
        $product2->set_price( 999 );
        $order->add_product( $product2 );

        $this->assertEquals( 1004.5, $order->gross_price() );
    }
}
