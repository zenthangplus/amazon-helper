<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use ZenThangPlus\AmazonHelper\Helpers\UnitConverter;

class UnitConverterTest extends TestCase {

    /**
     * Test convert inches to meters
     */
    public function testInchesToMeters() {
        $this->assertEquals( 0.0254, UnitConverter::inches_to_meters( 1 ) );
    }

    /**
     * Test convert ounces to kilograms
     */
    public function testOuncesToKilograms() {
        $this->assertEquals( 0.0283495231, UnitConverter::ounces_to_kilograms( 1 ) );
    }

    /**
     * Test convert pounds to kilograms
     */
    public function testPoundsToKilograms() {
        $this->assertEquals( 0.45359237, UnitConverter::pounds_to_kilograms( 1 ) );
    }
}
