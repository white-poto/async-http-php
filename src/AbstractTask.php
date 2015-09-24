<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/8/22
 * Time: 18:08
 */

namespace Jenner\Http;


abstract class AbstractTask
{

    /**
     * @var callable response handler
     */
    protected $handler = null;

    /**
     * get curl resource
     * @return resource curl
     */
    abstract public function getCurl();

    /**
     * @param $handler
     */
    public function registerHandler($handler)
    {
        if (!is_callable($handler)) {
            throw new \RuntimeException("param callback is not callable");
        }
    }

    /**
     * @return bool
     */
    public function hasHandler()
    {
        if (!is_null($this->handler) && is_callable($this->handler)) {
            return true;
        }

        return false;
    }
}