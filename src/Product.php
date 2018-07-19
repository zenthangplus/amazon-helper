<?php

namespace ZenThangPlus\AmazonHelper;

class Product extends Price {
    /**
     * Product url on Amazon
     *
     * @var string
     */
    private $url;

    /**
     * Title of current product
     *
     * @var string
     */
    private $title;

    /**
     * Price of current product
     *
     * @var float
     */
    private $price;

    /**
     * Weight of current product
     *
     * @var float
     */
    private $weight = 0;

    /**
     * Width of current product
     *
     * @var float
     */
    private $width = 0;

    /**
     * Height of current product
     *
     * @var float
     */
    private $height = 0;

    /**
     * Depth of current product
     *
     * @var float
     */
    private $depth = 0;

    /**
     * Set product's url
     *
     * @param string $url
     */
    public function set_url(string $url) {
        $this->url = $url;
    }

    /**
     * Set product's title
     *
     * @param string $title
     */
    public function set_title(string $title) {
        $this->title = $title;
    }

    /**
     * Set product's price
     *
     * @param float $price
     */
    public function set_price(float $price) {
        $this->price = $price;
    }

    /**
     * Set product's weight
     *
     * @param float $weight
     */
    public function set_weight(float $weight) {
        $this->weight = $weight;
    }

    /**
     * Set product's width
     *
     * @param float $width
     */
    public function set_width(float $width) {
        $this->width = $width;
    }

    /**
     * Set product's height
     *
     * @param float $height
     */
    public function set_height(float $height) {
        $this->height = $height;
    }

    /**
     * Set product's depth
     *
     * @param float $depth
     */
    public function set_depth(float $depth) {
        $this->depth = $depth;
    }

    /**
     * Get product's url
     *
     * @return string
     */
    public function url(): string {
        return $this->url;
    }

    /**
     * Get product's title
     *
     * @return string
     */
    public function title(): string {
        return $this->title;
    }

    /**
     * Get product's price
     *
     * @return float
     */
    public function price(): float {
        return $this->price;
    }

    /**
     * Get product's weight
     *
     * @return float
     */
    public function weight(): float {
        return $this->weight;
    }

    /**
     * Get product's width
     *
     * @return float
     */
    public function width(): float {
        return $this->width;
    }

    /**
     * Get product's height
     *
     * @return float
     */
    public function height(): float {
        return $this->height;
    }

    /**
     * Get product's depth
     *
     * @return float
     */
    public function depth(): float {
        return $this->depth;
    }

    /**
     * Calculate product's dimension
     *
     * @return float
     */
    public function dimension(): float {
        return $this->width * $this->height * $this->depth;
    }
}
