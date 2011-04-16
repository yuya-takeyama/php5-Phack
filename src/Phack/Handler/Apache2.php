<?php
namespace Phack\Handler;

/**
 * Phack application handler for Apache2.
 *
 * @author Yuya Takeyama
 */
class Apache2
{
    public static function run($app)
    {
        $env = $_SERVER;
        list($status, $headers, $body) = $app($env);
        $response = new \Phack\Response($body, $status, $headers);
        header("{$_SERVER['SERVER_PROTOCOL']}: {$response->getStatus()}");
        foreach ($response->getHeaders() as $key => $value) {
            header("{$key}:{$value}");
        }
        foreach ($response->getBody() as $line) {
            echo $line;
        }
    }
}
