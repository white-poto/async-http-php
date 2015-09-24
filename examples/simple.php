<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/8/25
 * Time: 14:05
 */

date_default_timezone_set("PRC");
require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$async = new \Jenner\Http\Async();
$task = \Jenner\Http\Task::createGet("http://www.baidu.com");
$async->attach($task, "baidu");

$task2 = \Jenner\Http\Task::createGet("http://www.sina.com");
$async->attach($task2, "sina");

$task3 = \Jenner\Http\Task::createGet("http://www.qq.com");
$async->attach($task3, "qq");

/**
 * you can do something here before receive the http responses
 * eg. query data from mysql or redis.
 */

while(true){
    if(!$async->isDone()){
        echo "I am running" . PHP_EOL;
        sleep(1);
        continue;
    }

    $result = $async->execute();
    print_r($result);
    break;
}

