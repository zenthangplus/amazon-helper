<?php

namespace ZenThangPlus\AmazonHelper\Helpers;

class UnitConverter {
    /**
     * Convert inches to meters
     *
     * @param float $value
     *
     * @return float
     */
    static function inches_to_meters( float $value ): float {
        return $value * 0.0254;
    }

    /**
     * Convert ounces to kilograms
     *
     * @param float $value
     *
     * @return float
     */
    static function ounces_to_kilograms( float $value ): float {
        return $value * 0.0283495231;
    }

    /**
     * Convert pounds to kilograms
     *
     * @param float $value
     *
     * @return float
     */
    static function pounds_to_kilograms( float $value ): float {
        return $value * 0.45359237;
    }
}
