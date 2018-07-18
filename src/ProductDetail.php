<?php

namespace ZenThangPlus\AmazonHelper;

class ProductDetail {
    /**
     * Title of current product
     *
     * @var string
     */
    public $title;

    /**
     * Price of current product
     *
     * @var float
     */
    public $price;

    /**
     * Weight of current product
     *
     * @var float
     */
    public $weight = 0;

    /**
     * Width of current product
     *
     * @var float
     */
    public $width = 0;

    /**
     * Height of current product
     *
     * @var float
     */
    public $height = 0;

    /**
     * Depth of current product
     *
     * @var float
     */
    public $depth = 0;

    /**
     * Calculate product dimension
     *
     * @return float
     */
    public function dimension() {
        return $this->width * $this->height * $this->depth;
    }
}
