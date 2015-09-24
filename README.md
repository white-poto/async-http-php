# async-http-php
An Async HTTP client based on curl_mulit* which is really simple and fast.

Description
-----------------
If you want to use ssl or something else when you request a website, you can just realize a task class and extends the AbstractTask class.
And you can register a handler use Task object, when the response is usable the Async class will call the handler to handle the response.
It will also return the response which is not handled by the handler.

The longer the requests execute, the more time it will save.


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

Performance tests
---------------------
[root@jenner async-http-php]# php tests/performance_async.php 
------------------------------------------
mark:[total diff]
time:10.497985124588s
memory_real:17152KB
memory_emalloc:12509.796875KB
memory_peak_real:18688KB
memory_peak_emalloc:13611.03125KB
[root@jenner async-http-php]# php tests/performance_sync.php  
------------------------------------------
mark:[total diff]
time:30.681544065475s
memory_real:1792KB
memory_emalloc:1527.8828125KB
memory_peak_real:2816KB
memory_peak_emalloc:2084.484375KB


