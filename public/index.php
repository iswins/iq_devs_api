<?php
/**
 * Created by v.taneev.
 */

use Luracast\Restler\Restler;

require_once __DIR__ . "/../vendor/autoload.php";

$restler = new Restler();
$restler->addAuthenticationClass(\App\AuthGuard\RestlerGuard::class);
$restler->addAPIClass(\App\Controllers\UserController::class, 'api/user');
$restler->addAPIClass(\App\Controllers\OrderController::class, 'api/orders');

header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, PATCH, DELETE');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: *');

$restler->handle();
