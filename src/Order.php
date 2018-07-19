<?php

namespace ZenThangPlus\AmazonHelper;

class Order {
    /**
     * @var Product[]
     */
    private $products;

    /**
     * Add product to the order
     *
     * @param Product $product
     *
     * @return int
     */
    public function add_product( Product $product ) {
        $this->products[] = $product;
        end( $this->products );
        return key( $this->products );
    }

    /**
     * Remove product from order
     *
     * @param int $id
     *
     * @return bool
     */
    public function remove_product( int $id ) {
        if ( isset( $this->products[ $id ] ) ) {
            unset( $this->products[ $id ] );
            return true;
        }
        return false;
    }

    /**
     * Get list of products available on this order
     *
     * @return Product[]
     */
    public function products() {
        return $this->products;
    }

    /**
     * Get gross price for this order
     *
     * @return float
     */
    public function gross_price(): float {
        $gross_price = 0;
        foreach ( $this->products as $product ) {
            $gross_price += $product->final_price();
        }
        return $gross_price;
    }
}
