<?php
require_once __DIR__ . '/../src/Phack.php';

use Phack;

$app = function ($env) {
    $request = new Phack\Request($env);

    $body = array(
        "REMOTE_ADDR    : {$request->address}\n",
        "REQUEST_METHOD : {$request->method}\n",
        "PATH_INFO      : {$request->path_info}\n",
        "QUERY_STRING   : {$request->query_string}\n",
    );

    return array(
        200,
        array('Content-Type' => 'text/plain'),
        $body
    );
};

Phack\Handler\Apache2::run($app);
