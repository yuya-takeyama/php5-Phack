<?php
/**
 * Phack: Superglue for PHP applications and web servers.
 *
 * Strongly influenced by Rack, WSGI and Plack (PSGI).
 *
 * @author Yuya Takeyama
 */
namespace Phack;

const VERSION = '0.0.1';

require_once __DIR__ . '/Phack/Request.php';
require_once __DIR__ . '/Phack/Response.php';
require_once __DIR__ . '/Phack/Handler/Apache2.php';
require_once __DIR__ . '/Phack/Util.php';
