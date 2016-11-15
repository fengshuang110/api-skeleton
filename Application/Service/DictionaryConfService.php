<?php 
namespace Application\Service;
use Application\Model\Conf\Dictionary;
class DictionaryConfService extends BaseService{
	
	public static $instance = null;
	protected $cache = null;
	protected $dictionary;
	const SINGLE_QUESTION_NUM = 5;
	private function __construct(){
		$this->dictionary = new Dictionary();
	}
	public static function getInstance(){
		if(self::$instance == null){
			self::$instance = new DictionaryConfService();
		}
		return self::$instance;
	}
	
	public static function getValue($table,$key){
		if(self::$instance == null){
			self::$instance = new DictionaryConfService();
		}
		return self::$instance->dictionary->getConfValue($table,$key);
	}

}


?>