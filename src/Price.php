<?php

namespace ZenThangPlus\AmazonHelper;

abstract class Price
{
    /**
     * List of shipping fees
     *
     * @var array
     */
    private $shipping_fees = [];

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
     * Get product's price
     *
     * @return float
     */
    abstract public function price(): float;

    /**
     * Get product's weight
     *
     * @return float
     */
    abstract public function weight(): float;

    /**
     * Get product's dimension
     *
     * @return float
     */
    abstract public function dimension(): float;

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
     * Add custom shipping fee
     *
     * @param float $fee
     */
    public function custom_shipping_fee($fee) {
        $this->shipping_fees[] = $fee;
    }

    /**
     * Get shipping fee
     *
     * @return float
     */
    public function shipping_fee() {
        $this->shipping_fees[] = $this->weight() * $this->weight_coefficient;
        $this->shipping_fees[] = $this->dimension() * $this->dimension_coefficient;
        return max($this->shipping_fees);
    }

    /**
     * Get final price
     *
     * @return float
     */
    public function final_price() {
        return $this->price() + $this->shipping_fee();
    }
}
