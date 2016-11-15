<?php

class ConsoleApplication {

	public static $config;
	public static $r;
	public static   $instance;
	public $namespace = 'Command\\Controller\\';
	private function __construct(){

	}

	public  static function Init($config){

		if(is_null(self::$instance)){
			self::$instance  = new ConsoleApplication();
		}
		self::$instance->module = $config['module'];
		return self::$instance;
	}

	public  function run(){
		$argv = $_SERVER['argv'] ;
		$consoleName = $argv[0];
		$router  = $argv[1];
		unset($argv[0],$argv[1]);
		$params = $argv;
		$router = explode("/", $router);
		$controllerName = str_replace(' ', '', ucwords(implode(' ', explode('-', $router[0]))));
		$action = 'action'.str_replace(' ', '', ucwords(implode(' ', explode('-', $router[1]))));
		$controllerName = $this->namespace.$controllerName;
		$controller = new  $controllerName;
		try{
			return call_user_func_array(array($controller, $action), $params);
		}catch (Exception $e){
			echo $e->getMessage();
		}
		die;
	}
}


?>
