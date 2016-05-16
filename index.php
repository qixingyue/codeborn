<?php

//ini_set("yaf.environ","develop");
ini_set("yaf.environ","product");

ini_set("display_errors","On");
error_reporting(E_ALL);

define("APP_PATH",  realpath(dirname(__FILE__) . '/app/'));

$app  = new Yaf_Application(APP_PATH . "/conf/application.ini");

if (PHP_SAPI === 'cli') {
	$app->bootstrap()->getDispatcher()->dispatch(new Yaf_Request_Simple());
} else {
	$app->bootstrap()->run();
}
