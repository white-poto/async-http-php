<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/8/22
 * Time: 17:52
 */

namespace Jenner\Http;


class Async
{
    protected $curl;

    protected $works;

    const METHOD_POST = "post";

    const METHOD_GET = "GET";

    public function __construct()
    {
        $this->curl = curl_multi_init();
        if ($this->curl === false) {
            throw new \RuntimeException("curl resource init failed");
        }
    }

    public function attach()
    {


    }
}