<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/11/2
 * Time: 10:57
 */

date_default_timezone_set("PRC");
require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$async = new \Jenner\Http\Async();
$task = \Jenner\Http\Task::createGet("http://www.baidu.com");
$promise = $async->attach($task, "baidu");

$promise->then(
    function ($data) {
        echo 'success:' . var_export($data, true) . PHP_EOL;
    },
    function ($data) {
        echo 'error:' . var_export($data, true) . PHP_EOL;
    }
);

$async->execute();