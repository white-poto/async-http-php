<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/9/24
 * Time: 16:09
 */

date_default_timezone_set("PRC");
require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$timer = new \Jenner\Timer(\Jenner\Timer::UNIT_KB);
$timer->mark("start");
$async = new \Jenner\Http\Async();
$task = \Jenner\Http\Task::createGet("http://www.baidu.com");
$async->attach($task, "baidu");

$task2 = \Jenner\Http\Task::createGet("http://www.sina.com");
$async->attach($task2, "sina");

$task3 = \Jenner\Http\Task::createGet("http://www.qq.com");
$async->attach($task3, "qq");

$result = $async->execute();

$timer->mark("end");
$timer->printDiffReport();