<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/8/25
 * Time: 14:05
 */

require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$async = new \Jenner\Http\Async();
$task = \Jenner\Http\Task::createGet("http://www.baidu.com");
$async->attach($task);


while(true){
    var_dump($async->isDone());
    echo PHP_EOL;
    usleep(100);
}