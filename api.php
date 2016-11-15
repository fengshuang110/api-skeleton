<?php
//加载composer库
error_reporting(0);
date_default_timezone_set('Asia/Shanghai');
ini_set('date.timezone','Asia/Shanghai');
error_reporting(E_ALL);
//加载rest composer库
if (is_readable(__DIR__ . '/vendor/autoload.php')) {
	//if composer auto loader is found use it
	$loader = require_once __DIR__ . '/vendor/autoload.php';
	$loader->setUseIncludePath(true);
	class_alias('Luracast\\Restler\\Restler', 'Restler');
}

include_once(__DIR__.'/auto_init.php');

include __DIR__ . '/Library/Loader/AutoloaderFactory.php';
Library\Loader\AutoloaderFactory::factory(array(
			'Library\Loader\StandardAutoloader' => array(
			'autoregister_zf' => true,
			"namespaces"=>array(
				"Application"=>__DIR__.'/Application',
			)
		)	
));

Application::init(require 'Config/api.php')->run();
