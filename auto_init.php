<?php

use Luracast\Restler\Restler;
use Luracast\Restler\Format\HtmlFormat;
use Luracast\Restler\Defaults;
use Luracast\Restler\Format\UploadFormat;

class Application {

	public static $config;
	public static $r;
	public static   $instance;
	public $format;
	public static $dbConnection;
	private function __construct(){

	}

	public  static function Init($config){
		if(is_null(self::$instance)){
			self::$instance  = new Application();
		}
		self::$config = ($config);
		self::$instance->module = $config['module'];

		//是否支持文档
		self::$instance->document = isset($config['document']) ? $config['document'] : false;

		//是否支持跨域
		self::$instance->access = isset($config['access']) ? $config['access'] : false;
		//是否是api
		self::$instance->api = !isset($config['api']) ? true : $config['api'];
		if( empty($config['api']) ){
			//视图文件路径
			self::$instance->viewPath = isset($config['viewPath']) ? $config['viewPath'] : 'views';
			//var_dump($config['viewPath']);die;
		//数据传输支持的格式协议
			self::$instance->format = isset($config['format']) ? $config['format'] : 'JsonFormat';

			HtmlFormat::$template = isset($config['template']) ? $config['template'] : 'php';
			HtmlFormat::$errorView = "/error/index";
		}	
		return self::$instance;
	}

	public  function run(){
		if(is_null(self::$r)){
			self::$r = new Restler();
		}
		$name_dir = explode('\\', $this->module);
		$dir = "";
		foreach ($name_dir as $name){
		  $dir .=$name."/";
		}
		$files=scandir(__DIR__.'/'.$dir);

		foreach ($files as $file){
			$fileinfo = pathinfo($file);
			if(strtolower($fileinfo['extension']) == "php"){
				echo self::$r->addAPIClass($this->module."\\".$fileinfo['filename']);
			}
		}

		if($this->document){
			self::$r->addAPIClass("Resources");
		}
		if($this->access){

			$this->cors();

		}

	
		Defaults::$crossOriginResourceSharing = true;//是否允许跨域

		UploadFormat::$allowedMimeTypes = array('image/jpeg', 'image/png', 'application/macbinary', 'application/octet-stream');
		if(empty($this->api)){
			HtmlFormat::$template = "blade";
			self::$r->setSupportedFormats('JsonFormat', 'HtmlFormat', 'UploadFormat', 'XmlFormat');

			HtmlFormat::$viewPath = $this->viewPath;
       
		}else{
			self::$r->setSupportedFormats('JsonFormat', 'UploadFormat', 'XmlFormat');
		}
		return self::$r->handle();

	}

	public function cors() {
		if (isset($_SERVER['HTTP_ORIGIN'])) {
			header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
			header('Access-Control-Allow-Credentials: true');
			header('Access-Control-Max-Age: 86400');    // cache for 1 day
		}
		if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

			if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
				header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

			if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
				header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

			exit(0);
		}
	}
}


?>
