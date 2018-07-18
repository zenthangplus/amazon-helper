<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use ZenThangPlus\AmazonHelper\Crawler;
use ZenThangPlus\AmazonHelper\Exceptions\CrawlerException;

class CrawlerTest extends TestCase
{
	/**
	 * @throws CrawlerException
	 */
	public function testCrawler() {
		$response = Crawler::init()->start( 'https://www.amazon.com/Anker-Portable-Reader-RS-MMC-Micro/dp/B006T9B6R2/ref=bbp_bb_a77114_st_8174_w_0?psc=1&smid=A294P4X9EWVXLJ' );
		$this->assertEquals(200, $response->get_http_code());
	}
}
