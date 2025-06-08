<?php

use support\Response;

/**
 * 报错html
 * @param int $status
 * @return Response
 */
function alone_error_html(int $status = 404): Response {
    return response("<html><head><title>$status Not Found</title></head><body><center><h1>$status Not Found</h1></center></body></html>");
}


if (!function_exists('alone_send_chunk')) {
    /**
     * 发送http chunk数据
     * https://www.workerman.net/doc/workerman/http/response.html
     * @param callable|array $chunk function ($send) {$send('发送的数据');}
     * @return Response
     */
    function alone_send_chunk(callable|array $chunk): Response {
        $callback = function($call) {
            $count = 0;
            $connection = request()->connection;
            $call(function($body) use ($connection, &$count) {
                $count = $count + 1;
                if ($count == 1) {
                    $body = !empty($body) ? $body : response();
                    $body = is_callable($body) && ($body instanceof \Closure) ? $body() : $body;
                    $response = is_array($body) ? json($body) : (is_object($body) && method_exists($body, 'rawBody') ? $body : response($body));
                    $connection->send($response->withStatus(200)->withHeaders(['Transfer-Encoding' => 'chunked']));
                } else {
                    $connection->send(new \Workerman\Protocols\Http\Chunk($body));
                }
            });
            if ($count == 0) {
                $connection->send(response()->withStatus(200)->withHeaders(['Transfer-Encoding' => 'chunked']));
            }
            $connection->send(new \Workerman\Protocols\Http\Chunk(''));
            return response()->withHeaders(["Content-Type" => "application/octet-stream", "Transfer-Encoding" => "chunked"]);
        };
        $chunk = is_array($chunk) ? (function($send) use ($chunk) {
            foreach ($chunk as $val) {
                $send($val);
            }
        }) : $chunk;
        return $callback($chunk);
    }
}