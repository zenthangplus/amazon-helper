<?php

namespace ZenThangPlus\AmazonHelper;

class PriceCalculator {
    /**
     * Product data
     *
     * @var ProductDetail
     */
    private $product;

    /**
     * Weight coefficient
     *
     * @var float
     */
    private $weight_coefficient = 0;

    /**
     * Dimension coefficient
     *
     * @var float
     */
    private $dimension_coefficient = 0;

    /**
     * Total price
     *
     * @var float
     */
    private $gross_price = 0;

    /**
     * Shipping fee
     *
     * @var float
     */
    private $shipping_fee = 0;

    /**
     * PriceCalculator constructor.
     *
     * @param ProductDetail $product
     */
    public function __construct( ProductDetail $product ) {
        $this->product = $product;
    }

    /**
     * Custom weight coefficient
     *
     * @param float $value
     */
    public function set_weight_coefficient( float $value ) {
        $this->weight_coefficient = $value;
    }

    /**
     * Custom dimension coefficient
     *
     * @param float $value
     */
    public function set_dimension_coefficient( float $value ) {
        $this->dimension_coefficient = $value;
    }

    /**
     * Calculate price and fees
     */
    public function calculate() {
        $price              = $this->product->price;
        $fee_by_weight      = $this->product->weight * $this->weight_coefficient;
        $fee_by_dimension   = $this->product->dimension() * $this->dimension_coefficient;
        $shipping_fee       = max( $fee_by_weight, $fee_by_dimension );
        $price              += $shipping_fee;
        $this->shipping_fee = $shipping_fee;
        $this->gross_price  = $price;
    }

    /**
     * Get gross price for current product
     *
     * @return float
     */
    public function get_gross_price(): float {
        return $this->gross_price;
    }

    /**
     * Get shipping fee for current product
     *
     * @return float
     */
    public function get_shipping_fee(): float {
        return $this->shipping_fee;
    }
}
