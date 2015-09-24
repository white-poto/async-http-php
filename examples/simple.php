<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/8/25
 * Time: 14:05
 */

date_default_timezone_set("PRC");
require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

echo '1' . PHP_EOL;
$async = new \Jenner\Http\Async();
$task = \Jenner\Http\Task::createGet("http://www.baidu.com");
$async->attach($task, "baidu");

echo '2' . PHP_EOL;
$task2 = \Jenner\Http\Task::createGet("http://www.sina.com");
$async->attach($task2, "sina");

echo '3' . PHP_EOL;
$task3 = \Jenner\Http\Task::createGet("http://www.qq.com");
$async->attach($task3, "qq");

echo "4" . PHP_EOL;
$result = $async->execute();
print_r($result);