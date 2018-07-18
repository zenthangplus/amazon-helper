<?php

namespace ZenThangPlus\AmazonHelper;

use ZenThangPlus\AmazonHelper\Exceptions\ParserException;
use ZenThangPlus\AmazonHelper\Helpers\UnitConverter;

class ProductParser extends Parser {
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
     * Get product title
     *
     * @return string
     */
    public function get_title(): string {
        if ( isset( $this->title ) ) {
            return $this->title;
        }
        $element     = $this->doc->getElementById( 'productTitle' );
        $this->title = trim( $element->textContent );
        return $this->title;
    }

    /**
     * Get product price
     *
     * @return float
     * @throws ParserException
     */
    public function get_price(): float {
        if ( isset( $this->price ) ) {
            return $this->price;
        }

        /**
         * Demo for this case: https://www.amazon.com/Anker-Portable-Reader-RS-MMC-Micro/dp/B006T9B6R2/
         */
        $element = $this->doc->getElementById( 'price_inside_buybox' );

        /**
         * Demo for this case: https://www.amazon.com/Apple-Watch-Space-Aluminum-Black/dp/B00WP9NFUG
         */
        if ( ! $element ) {
            if ( $buy_new_non_cbb = $this->doc->getElementById( 'buyNew_noncbb' ) ) {
                $elements = $buy_new_non_cbb->getElementsByTagName( 'span' );
                $elements->length > 0 && $element = $elements->item( 0 );
            }
        }

        /**
         * Demo for this case: https://www.amazon.com/ViewSonic-PRO7827HD-Rec-709-Theater-Projector/dp/B01C92FE70/ref=gbps_img_s-4_7c93_92211d7c?smid=A1KWJVS57NX03I
         */
        ! $element && $element = $this->doc->getElementById( 'newBuyBoxPrice' );

        /**
         * Demo for this case: https://www.amazon.com/ViewSonic-PRO7827HD-Rec-709-Theater-Projector/dp/B01C92FE70/ref=gbps_img_s-4_7c93_92211d7c?smid=A1KWJVS57NX03I
         */
        ! $element && $element = $this->doc->getElementById( 'usedPrice' );

        if ( ! $element ) {
            throw new ParserException( "Product price not exists" );
        }

        $raw_price = trim( $element->textContent );
        $price     = preg_replace( '/^\$/is', '', $raw_price );
        if ( ! is_numeric( $price ) ) {
            throw new ParserException( "Cannot parse product price" );
        }
        $this->price = (float) $price;
        return $this->price;
    }

    /**
     * Get product weight
     *
     * @return float
     */
    public function get_weight(): float {
        $this->fetch_details();
        return $this->weight;
    }

    /**
     * Get product width
     *
     * @return float
     */
    public function get_width(): float {
        $this->fetch_details();
        return $this->width;
    }

    /**
     * Get product height
     *
     * @return float
     */
    public function get_height(): float {
        $this->fetch_details();
        return $this->height;
    }

    /**
     * Get product depth
     *
     * @return float
     */
    public function get_depth(): float {
        $this->fetch_details();
        return $this->depth;
    }

    /**
     * Fetch product details
     */
    private function fetch_details() {
        static $_fetch_details;
        //make sure this function execute once
        if ( isset( $_fetch_details ) ) {
            return;
        }

        $details_ele = $this->doc->getElementById( 'prodDetails' );
        $tables_list = $details_ele->getElementsByTagName( 'table' );

        //Loop all tables
        for ( $i = 0; $i < $tables_list->length; $i ++ ) {
            $table     = $tables_list->item( $i );
            $rows_list = $table->getElementsByTagName( 'tr' );

            //Loop all rows in current table
            for ( $j = 0; $j < $rows_list->length; $j ++ ) {
                $row = $rows_list->item( $j );

                $ths = $row->getElementsByTagName( 'th' );
                if ( $ths->length <= 0 ) {
                    continue;
                }

                $tds = $row->getElementsByTagName( 'td' );
                if ( $tds->length <= 0 ) {
                    continue;
                }

                $th = $ths->item( 0 );
                $td = $tds->item( 0 );

                $name  = trim( $th->textContent );
                $value = trim( $td->textContent );
                $this->sanitize( $name, $value );
            }
        }
        $_fetch_details = true;
    }

    /**
     * Convert detail string to property
     *
     * @param string $name
     * @param string $value
     */
    private function sanitize( $name, $value ) {
        switch ( $name ) {
            case 'Item Weight':
                preg_match( '/([0-9\.]+)\s*(pounds|ounces)$/is', $value, $matches );
                if ( isset( $matches[2] ) ) {
                    switch ( $matches[2] ) {
                        case 'pounds':
                            $this->weight = UnitConverter::pounds_to_kilograms( (float) $matches[1] );
                            break;
                        case 'ounces':
                            $this->weight = UnitConverter::ounces_to_kilograms( (float) $matches[1] );
                            break;
                    }
                }
                break;
            case 'Product Dimensions':
                $sizes_str    = preg_replace( '/\s*inches$/is', '', $value );
                $size         = explode( ' x ', $sizes_str );
                $this->width  = isset( $size[0] ) ? UnitConverter::inches_to_meters( (float) $size[0] ) : 0;
                $this->height = isset( $size[1] ) ? UnitConverter::inches_to_meters( (float) $size[1] ) : 0;
                $this->depth  = isset( $size[2] ) ? UnitConverter::inches_to_meters( (float) $size[2] ) : 0;
                break;
        }
    }

    /**
     * Transfer parse data to product detail
     *
     * @return ProductDetail
     * @throws ParserException
     */
    public function to_detail() {
        $detail = new ProductDetail();
        $detail->price = $this->get_price();
        $detail->title = $this->get_title();
        $detail->weight = $this->get_weight();
        $detail->width = $this->get_width();
        $detail->height = $this->get_height();
        $detail->depth = $this->get_depth();
        return $detail;
    }
}
