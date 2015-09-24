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
for($i=0; $i<20; $i++){
    $task = \Jenner\Http\Task::createGet("http://www.baidu.com?" . $i);
    $result = curl_exec($task->getCurl());

    $task2 = \Jenner\Http\Task::createGet("http://www.sina.com?" . $i);
    $result2 = curl_exec($task2->getCurl());

    $task3 = \Jenner\Http\Task::createGet("http://www.qq.com?" . $i);
    $result3 = curl_exec($task3->getCurl());
}

$timer->mark("end");

$timer->printDiffReport();