<?php
ini_set('memory_limit', '50M');
ini_set('max_execution_time', '5');
ini_set('max_input_time', '6');

use Symfony\Component\ClassLoader\ApcClassLoader;
use Symfony\Component\HttpFoundation\Request;

$loader = require_once __DIR__.'/../app/bootstrap.php.cache';
// Use APC for autoloading to improve performance.
// Change 'sf2' to a unique prefix in order to prevent cache key conflicts
// with other applications also using APC.
$loader = new ApcClassLoader('opm-api', $loader);
$loader->register(true);

require_once __DIR__.'/../app/AppKernelApi.php';
//require_once __DIR__.'/../app/AppCache.php';

$kernel = new AppKernelApi('prod', false);
$kernel->loadClassCache();
//$kernel = new AppCache($kernel);
Request::enableHttpMethodParameterOverride();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
