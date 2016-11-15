<?php 
namespace Application\Model\Weixin;

use Illuminate\Database\Eloquent\Model;
use Application\Model\Connection;
class Homework extends Model{
	
	protected $table = 'edu_wx_homework';
	protected $primaryKey = "homework_id";
	const HOMEWORK_TYPE = 'weixin_map_game';
	
	public function __construct(){
		Connection::init();
	}
	
	public function initUserHomework($weixin_id,$sectionId,$questions){
		$this->getConnection()->beginTransaction();
		try {
			$this->weixin_id = $weixin_id;
			$this->question_count = count($questions);
			$this->section_id = $sectionId;
			$this->homework_type = self::HOMEWORK_TYPE;
			$this->save();
			$homeworkId = $this->homework_id;
			foreach ($questions as $key=>$question){
				$data[] = array(
					'index'			=>$key+1,
					"homework_id"	=>$homeworkId,
					"question_id"	=>$question->question_id,
					"right_answer"	=>$question->right_answer
				);
			}
			$homeworkQuestion = new HomeworkQuestion();
			$result =  $homeworkQuestion->insert($data);
			$this->getConnection()->commit();
			return $homeworkQuestion->where('homework_id',$homeworkId)->get();
		}catch (\Exception $e){
			$this->getConnection()->rollBack();
			return $e;
		}
	}
	
	
}
?>