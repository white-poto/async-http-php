<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/8/25
 * Time: 14:05
 */

require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$async = new \Jenner\Http\Async();
$task = \Jenner\Http\Task::createGet("http://www.baidu.com", "baidu");
$async->attach($task);

$task2 = \Jenner\Http\Task::createGet("http://www.google.com", "google");
$async->attach($task);

$task3 = \Jenner\Http\Task::createGet("http://www.facebook.com", "facebook");
$async->attach($task3);


$result = $async->execute();
print_r($result);