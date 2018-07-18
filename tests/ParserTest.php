<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use ZenThangPlus\AmazonHelper\Crawler;
use ZenThangPlus\AmazonHelper\Parser;
use ZenThangPlus\AmazonHelper\Exceptions\CrawlerException;
use ZenThangPlus\AmazonHelper\Exceptions\ParserException;

class ParserTest extends TestCase
{
	/**
	 * @throws CrawlerException
	 * @throws ParserException
	 * @throws ReflectionException
	 */
	public function testParseDocument() {
		$response = Crawler::init()->start( 'https://www.amazon.com/Anker-Portable-Reader-RS-MMC-Micro/dp/B006T9B6R2/ref=bbp_bb_a77114_st_8174_w_0?psc=1&smid=A294P4X9EWVXLJ' );
		$parser = new Parser($response);
		$reflector = new ReflectionClass( 'ZenThangPlus\AmazonHelper\Parser' );
		$property = $reflector->getProperty( 'doc' );
		$property->setAccessible( true );
		/**
		 * @var \DOMDocument $doc
		 */
		$doc = $property->getValue( $parser );
		$html = $doc->getElementsByTagName('html');
		$this->assertEquals(1, $html->length);
	}
}
