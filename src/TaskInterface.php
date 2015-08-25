<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/8/22
 * Time: 18:08
 */

namespace Jenner\Http;


interface TaskInterface
{
    /**
     * get curl resource
     * @return resource curl
     */
    public function getTask();

    /**
     * handle response
     * @param $content
     * @param $info
     * @param $error
     * @return mixed
     */
    public function handle($content, $info, $error);
}