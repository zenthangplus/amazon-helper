<?php

namespace ZenThangPlus\AmazonHelper;

class CrawlerResponse {
	/**
	 * Http code response from request
	 *
	 * @var int
	 */
	private $http_code;

	/**
	 * Data response from request
	 *
	 * @var string
	 */
	private $data;

	/**
	 * CrawlerResponse constructor.
	 *
	 * @param int $http_code
	 * @param string $data
	 */
	public function __construct( $http_code, $data ) {
		$this->http_code = $http_code;
		$this->data      = $data;
	}

	/**
	 * Get http code from request
	 *
	 * @return int
	 */
	public function get_http_code() {
		return $this->http_code;
	}

	/**
	 * Get data string from request
	 *
	 * @return string
	 */
	public function get_data() {
		return $this->data;
	}
}
