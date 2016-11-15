<?php 
namespace Application\Model\Database2;
use Illuminate\Database\Capsule\Manager as Capsule;

class Connection {
	protected static  $conn = null;
	public static function init(){
		if(self::$conn == null){
			self::$conn = new Connection();
		}
		return self::$conn;
	}
	private function __construct(){
		$dbconfig = \Application::$config;
		$mysql = $dbconfig['database2']['mysql'];
		$read = $mysql['read'];
		$mysql['read']['host'] =  $read[rand(1,count($read))];
		if(self::$conn == null){
			$capsule = new Capsule;
			// 创建链接
			$capsule->addConnection($mysql);
			// 设置全局静态可访问
			$capsule->setAsGlobal();
			// 启动Eloquent
			$capsule->bootEloquent();
		}
		\Application::$dbConnection['database2'] = $capsule->getConnection();
	}
	
}


?>