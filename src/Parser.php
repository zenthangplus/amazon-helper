<?php

namespace ZenThangPlus\AmazonHelper;

use DOMDocument;
use ZenThangPlus\AmazonHelper\Exceptions\ParserException;

class Parser {
	/**
	 * Response from Crawler
	 *
	 * @var CrawlerResponse
	 */
	protected $response;

	/**
	 * Dom document object
	 *
	 * @var DOMDocument
	 */
	protected $doc;

	/**
	 * Parser constructor.
	 *
	 * @param CrawlerResponse $response
	 *
	 * @throws ParserException
	 */
	public function __construct( CrawlerResponse $response ) {
		$this->response = $response;
		$this->parse();
	}

	/**
	 * Parse document
	 *
	 * @throws ParserException
	 */
	private function parse() {
		$this->doc = new DOMDocument();
		if ( ! @$this->doc->loadHTML( $this->response->get_data() ) ) {
			throw new ParserException( "Cannot parse this document" );
		}
	}
}
