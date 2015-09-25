# async-http-php
An Async HTTP client based on curl_mulit* which is really simple and fast.

Description
-----------------
- If you want to use ssl or something else when you request a website, you can just realize a task class and extends the AbstractTask class.
- You can register a handler using Task object, when the response is usable the Async class will call the handler to handle the response.
- It will also return the response if it is handled by the handler or not.
- The longer the requests execute, the more time it will save.

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
 
 $async-start();

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
```shell
[root@huyanping async-http-php]# php tests/performance_sync.php  
------------------------------------------
mark:[total diff]
time:55.121547937393s
memory_real:1536KB
memory_emalloc:1300.5859375KB
memory_peak_real:2304KB
memory_peak_emalloc:1898.640625KB
[root@huyanping async-http-php]# php tests/performance_async.php 
------------------------------------------
mark:[total diff]
time:4.6412570476532s
memory_real:256KB
memory_emalloc:187.7109375KB
memory_peak_real:13312KB
memory_peak_emalloc:10387.8671875KB
```

