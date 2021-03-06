<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use ZenThangPlus\AmazonHelper\Crawler;
use ZenThangPlus\AmazonHelper\ProductParser;
use ZenThangPlus\AmazonHelper\Exceptions\CrawlerException;
use ZenThangPlus\AmazonHelper\Exceptions\ParserException;

class ProductParserTest extends TestCase
{
	/**
	 * @var ProductParser
	 */
	public $parser;

	/**
	 * @throws CrawlerException
	 * @throws ParserException
	 */
	protected function setUp() {
		$response = Crawler::init()->start( 'https://www.amazon.com/Anker-Portable-Reader-RS-MMC-Micro/dp/B006T9B6R2/ref=bbp_bb_a77114_st_8174_w_0?psc=1&smid=A294P4X9EWVXLJ' );
		$this->parser = new ProductParser($response);
	}

	/**
	 * Test get product title
	 */
	public function testGetProductTitle() {
		$this->assertEquals('Anker 8-in-1 USB 3.0 Portable Card Reader for SDXC, SDHC, SD, MMC, RS-MMC, Micro SDXC, Micro SD, Micro SDHC Card and UHS-I Cards', $this->parser->title());
	}

	/**
     * Test get product price
     *
	 * @throws ParserException
	 */
	public function testGetProductPrice() {
		$this->assertEquals(9.99, $this->parser->price());
	}

    /**
     * Test get product weight
     */
    public function testGetProductWeight() {
        $this->assertGreaterThan(0, $this->parser->weight());
    }

    /**
     * Test get product width
     */
    public function testGetProductWidth() {
        $this->assertGreaterThan(0, $this->parser->width());
    }

    /**
     * Test get product height
     */
    public function testGetProductHeight() {
        $this->assertGreaterThan(0, $this->parser->height());
    }

    /**
     * Test get product depth
     */
    public function testGetProductDepth() {
        $this->assertGreaterThan(0, $this->parser->depth());
    }
}
