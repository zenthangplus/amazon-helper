<?php

namespace ZenThangPlus\AmazonHelper;

class CrawlerResponse {
    /**
     * Response from this url
     *
     * @var string
     */
    private $url;

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
     * @param string $url
     * @param int $http_code
     * @param string $data
     */
    public function __construct( string $url, int $http_code, string $data ) {
        $this->url       = $url;
        $this->http_code = $http_code;
        $this->data      = $data;
    }

    /**
     * Get remote url
     *
     * @return string
     */
    public function get_url() {
        return $this->url;
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
