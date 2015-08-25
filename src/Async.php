<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/8/22
 * Time: 17:52
 */

namespace Jenner\Http;


class Async
{
    /**
     * multi-curl resource
     * @var resource
     */
    protected $curl;

    protected $tasks = array();

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
     * @param Task $task
     * @param $task_name
     */
    public function attach(Task $task, $task_name = null)
    {
        if(is_null($task_name)){
            $task_name = count($this->tasks);
        }
        $this->tasks[$task_name] = $task;
        curl_multi_add_handle($this->curl, $task->getTask());
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
    public function execute()
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
                $content = curl_multi_getcontent($done['handle']);

                $callback = $task_name = null;
                foreach($this->tasks as $task_name=>$task){
                    if($done['handle'] == $task->getTask() && method_exists($task, "handle")){
                        $callback = array($task, "handle");
                        break;
                    }
                }

                if (!is_null($callback) && is_callable($callback)) {
                    $result = call_user_func($callback, $content, $info, $error);
                }

                $responses[$task_name] = compact('info', 'error', 'result');

                // remove the curl handle that just completed
                curl_multi_remove_handle($this->curl, $done['handle']);
                curl_close($done['handle']);
            }

            // Block for data in / output; error handling is done by curl_multi_exec
            if ($active > 0) {
                curl_multi_select($this->curl, 0.5);
            }

        } while ($active);

        curl_multi_close($this->curl);

        return $responses;
    }

}