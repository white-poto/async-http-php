# async-http-php
An Async HTTP client based on curl_mulit* which is really simple and fast.

If you want to use ssl or something else when you request a website, you can just realize a task class and implement the TaskInterface interface.

example code:
```php
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
    // nonblock
    if(!$async->isDone()){
        echo "I am running" . PHP_EOL;
        sleep(1);
        continue;
    }

    $result = $async->execute();
    print_r($result);
    break;
}

/**
 * or you just call execute. it will block the process until all tasks are done.
 * $result = $async->execute();
 * print_r($result);
 */
```

