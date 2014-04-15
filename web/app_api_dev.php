<?php
// Because of the big csv files we need to increase certain php.ini settings. Otherwise the profiler might explode
ini_set('memory_limit', '1024M');
ini_set('max_execution_time', '300');
ini_set('max_input_time', '300');

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;

$loader = require_once __DIR__.'/../app/bootstrap.php.cache';
Debug::enable();

require_once __DIR__.'/../app/AppKernelApi.php';

$kernel = new AppKernelApi('dev', true);
// @see http://symfony.com/doc/current/cookbook/debugging.html
//$kernel->loadClassCache();
Request::enableHttpMethodParameterOverride();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
