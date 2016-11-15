<?php
return  array(
	"module"=>"Application\\Api\\V1",
	"template"=>"blade",
	"document"=>true,
	"access"=>true,//是否支持跨域
	'format'=>array("JsonFormat"),//接口输出格式支持
	'cache'=>require(__DIR__ . '/cache.php'),
	'default'=>require(__DIR__ . '/db.php'),
	'database2'=>require(__DIR__ . '/database2.php')
);
