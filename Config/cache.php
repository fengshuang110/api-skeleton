<?php 

return array(
	"cache"=>array(
		'memcache' => array (
			"local"=>array(
				"0"=>array (
					'host' => '192.168.1.49',
					'port' => '11211' ,
					'weight' => '1'
					),
				),
			'rls' => array (
				"0"=>array (
					'host' => '127.0.0.1',
					'port' => '11211' ,
					'weight' => '1'
					),
				)
			),
					
		'redis' => array (
			"local"=>array(
// 					'host' => 'localhost',
					'host' => '121.41.117.10',
					'port' => '6379' ,
					'weight' => '1'
						),
				),
		)
);
?>