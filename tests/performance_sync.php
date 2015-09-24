<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/9/24
 * Time: 16:10
 */

date_default_timezone_set("PRC");
require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$timer = new \Jenner\Timer(\Jenner\Timer::UNIT_KB);
$timer->mark("start");
$task = \Jenner\Http\Task::createGet("http://www.baidu.com");
$result = curl_exec($task->getCurl());

$task2 = \Jenner\Http\Task::createGet("http://www.sina.com");
$result2 = curl_exec($task2->getCurl());

$task3 = \Jenner\Http\Task::createGet("http://www.qq.com");
$result3 = curl_exec($task3->getCurl());
$timer->mark("end");

$timer->printDiffReport();