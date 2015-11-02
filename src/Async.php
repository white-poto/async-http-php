<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/8/22
 * Time: 17:52
 */

namespace Jenner\Http;


use React\Promise\Deferred;

class Async
{
    /**
     * multi-curl resource
     * @var resource
     */
    protected $curl;

    /**
     * @var Task[] array
     */
    protected $tasks = array();

    /**
     * @var Deferred[]
     */
    protected $deferred = array();

    /**
     * @param null $callback
     */
    public function __construct($callback = null)
    {
        $this->curl = curl_multi_init();
        if ($this->curl === false) {
            throw new \RuntimeException("curl resource init failed");
        }

        if (!is_null($callback)) {
            $this->callback = $callback;
        } else {
            $this->callback = array($this, "defaultCallback");
        }
    }

    /**
     * add new task and return a promise
     *
     * @param Task $task
     * @param null $task_name
     * @return \React\Promise\PromiseInterface
     */
    public function attach(Task $task, $task_name = null)
    {
        if (is_null($task_name)) {
            $task_name = count($this->tasks);
        }
        $this->tasks[$task_name] = $task;
        curl_multi_add_handle($this->curl, $task->getCurl());
        $deferred = new Deferred();
        $this->deferred[$task_name] = $deferred;

        return $deferred->promise();
    }

    /**
     * while you need to call isDone to check all tasks,
     * you should call start first.
     */
    public function start()
    {
        curl_multi_exec($this->curl, $active);
    }

    /**
     * @return bool
     */
    public function isDone()
    {
        $code = curl_multi_exec($this->curl, $active);
        if ($code != CURLM_CALL_MULTI_PERFORM && $code == CURLM_OK && $active == 0) {
            return true;
        }

        return false;
    }

    /**
     * @return array
     */
    public function execute($return = false)
    {
        $responses = array();

        do {
            while (($code = curl_multi_exec($this->curl, $active)) == CURLM_CALL_MULTI_PERFORM) ;

            if ($code != CURLM_OK) {
                break;
            }

            // a request was just completed -- find out which one
            while ($done = curl_multi_info_read($this->curl)) {

                // get the info and content returned on the request
                $info = curl_getinfo($done['handle']);
                $error = curl_error($done['handle']);
                $errno = curl_errno($done['handle']);
                $content = curl_multi_getcontent($done['handle']);


                $task_name = $task = null;
                foreach ($this->tasks as $task_name => $task) {
                    if ($done['handle'] == $task->getCurl()) {
                        break;
                    }
                }
                $deferred = $this->deferred[$task_name];
                $result = compact('info', 'error', 'content');

                if ($errno != 0) {
                    if ($return) {
                        throw new \RuntimeException("curl error. errno:" . $errno . '. error:' . $error);
                    } else {
                        $deferred->reject($result);
                        continue;
                    }
                }

                $deferred->resolve($result);

                if ($return) {
                    $responses[$task_name] = compact('info', 'error', 'content');
                }

                // remove the curl handle that just completed
                curl_multi_remove_handle($this->curl, $done['handle']);
                curl_close($done['handle']);
            }

            // Block for data in / output; error handling is done by curl_multi_exec
            if ($active > 0) {
                curl_multi_select($this->curl, 0.05);
            }

        } while ($active);

        curl_multi_close($this->curl);

        if ($return) {
            return $responses;
        }
    }

}