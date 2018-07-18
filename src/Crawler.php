<?php

namespace ZenThangPlus\AmazonHelper;

use ZenThangPlus\AmazonHelper\Exceptions\CrawlerException;

class Crawler {
    /**
     * Custom timeout for request
     *
     * @var int
     */
    private $timeout = 30;

    /**
     * Custom user agent for request
     *
     * @var string
     */
    private $user_agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36';

    /**
     * Custom headers for request
     *
     * @var array
     */
    private $headers = [];

    /**
     * Init crawler
     *
     * @return self
     */
    public static function init(): self {
        return new self();
    }

    /**
     * Set user agent for request
     *
     * @param string $user_agent
     *
     * @return self
     */
    public function set_user_agent( string $user_agent ): self {
        $this->user_agent = $user_agent;
        return $this;
    }

    /**
     * Set headers for request
     *
     * @param array $headers
     *
     * @return Crawler
     */
    public function set_headers( array $headers ): self {
        $this->headers = $headers;
        return $this;
    }

    /**
     * Set timeout for request
     *
     * @param int $timeout
     *
     * @return Crawler
     */
    public function set_timeout( int $timeout ): self {
        $this->timeout = $timeout;
        return $this;
    }

    /**
     * Start crawl data from special url
     *
     * @param $url
     *
     * @return CrawlerResponse
     * @throws CrawlerException
     */
    public function start( $url ): CrawlerResponse {
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $this->timeout );
        curl_setopt( $ch, CURLOPT_USERAGENT, $this->user_agent );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $this->headers );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
        $data     = curl_exec( $ch );
        $error_no = curl_errno( $ch );
        if ( $error_no ) {
            throw new CrawlerException( curl_error( $ch ), $error_no );
        }
        $http_code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
        curl_close( $ch );
        return new CrawlerResponse( $http_code, $data );
    }
}
