<?php

namespace ZenThangPlus\AmazonHelper;

use ZenThangPlus\AmazonHelper\Exceptions\ParserException;
use ZenThangPlus\AmazonHelper\Helpers\UnitConverter;

class ProductParser extends Parser {

    /**
     * @var array
     */
    private $details;

    /**
     * Parse product title
     *
     * @return string
     */
    public function title(): string {
        $element = $this->doc->getElementById( 'productTitle' );
        return trim( $element->textContent );
    }

    /**
     * Parse product price
     *
     * @return float
     * @throws ParserException
     */
    public function price(): float {
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
        return (float) $price;
    }

    /**
     * Parse product weight
     *
     * @return float
     */
    public function weight(): float {
        $this->fetch_details();
        $weight = 0;
        if ( ! isset( $this->details['Item Weight'] ) ) {
            return $weight;
        }
        preg_match( '/([0-9\.]+)\s*(pounds|ounces)$/is', $this->details['Item Weight'], $matches );
        if ( isset( $matches[2] ) ) {
            switch ( $matches[2] ) {
                case 'pounds':
                    $weight = UnitConverter::pounds_to_kilograms( (float) $matches[1] );
                    break;
                case 'ounces':
                    $weight = UnitConverter::ounces_to_kilograms( (float) $matches[1] );
                    break;
            }
        }
        return $weight;
    }

    /**
     * Parse product width
     *
     * @return float
     */
    public function width(): float {
        $this->fetch_details();
        $size = $this->extract_dimensions( $this->details['Product Dimensions'] );
        return isset( $size[0] ) ? UnitConverter::inches_to_meters( (float) $size[0] ) : 0;
    }

    /**
     * Parse product height
     *
     * @return float
     */
    public function height(): float {
        $this->fetch_details();
        $size = $this->extract_dimensions( $this->details['Product Dimensions'] );
        return isset( $size[1] ) ? UnitConverter::inches_to_meters( (float) $size[1] ) : 0;
    }

    /**
     * Parse product depth
     *
     * @return float
     */
    public function depth(): float {
        $this->fetch_details();
        $size = $this->extract_dimensions( $this->details['Product Dimensions'] );
        return isset( $size[2] ) ? UnitConverter::inches_to_meters( (float) $size[2] ) : 0;
    }

    /**
     * Fetch product details
     */
    private function fetch_details() {
        //make sure this function execute once
        if ( isset( $this->details ) ) {
            return;
        }
        $this->details = [];

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

                $this->details[ $name ] = $value;
            }
        }
    }

    /**
     * Extract dimensions to array
     *
     * @param string $dimensions
     *
     * @return array
     */
    private function extract_dimensions( $dimensions ) {
        $sizes_str = preg_replace( '/\s*inches$/is', '', $dimensions );
        $size      = explode( ' x ', $sizes_str );
        return $size;
    }
}
