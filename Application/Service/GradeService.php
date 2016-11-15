<?php 
namespace Application\Service;
use Application\Model\Grade;

class GradeService extends BaseService{
	
	public static $instance = null;
	protected $cache = null;
	private function __construct(){
	}
	public static function getInstance(){
		if(self::$instance == null){
			self::$instance = new GradeService();
		}
		return self::$instance;
	}
	/**
	 * 年级列表
	 * @param number $type
	 * @return multitype:multitype:NULL
	 */
	public function getGrade($type =  0){
		$ret = array();
		if($type == 0){//基础年级 
			$grades = Grade::where('type',0)->get();
			foreach ($grades as $grade){
				$ret[] = array(
					'gradeName'=>$grade->grade_name,
					'gradeNo'=>$grade->grade_no	
				);
			}
		}
		return $ret;
	}
	
}


?>