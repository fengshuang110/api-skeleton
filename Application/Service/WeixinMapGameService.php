<?php 
namespace Application\Service;
use Application\Model\Weixin\Homework;
use Application\Model\SectionQuestion;
use Application\Model\Weixin\HomeworkQuestion;
use Luracast\Restler\RestException;
use Application\Libs\CustomerException;
class WeixinMapGameService extends BaseService{
	
	public static $instance = null;
	protected $cache = null;
	const HOMEWORK_TYPE = 'weixin_map_game';
	
	private function __construct(){
		$this->wxUser = WeixinAuthService::verifyLogin();
	}
	public static function getInstance(){
		if(self::$instance == null){
			self::$instance = new WeixinMapGameService();
		}
		return self::$instance;
	}
	
	private function checkHomework($homeworkId){
		$weixin_id = $this->wxUser['wx_user_id'];
		$homework = Homework::where('homework_id',$homeworkId)->where('weixin_id',$weixin_id)->first();
		if(empty($homework)){
			throw new CustomerException(40001,"作业不存在");
		}
		return $homework;
	}
	
	public function caculateIntegral($mapGameQuestion){
		if($mapGameQuestion instanceof  HomeworkQuestion){
		}
	}
	/**
	 * 提交答题
	 * @param unknown $id
	 * @param unknown $answer
	 * @param number $spendTime
	 * @throws RestException
	 * @return multitype:boolean unknown
	 */
	public function submitSingleQuestion($id,$answer,$spendTime = 15){
		$oneHomeworkQuestion = HomeworkQuestion::find($id);
		if(empty($oneHomeworkQuestion)){
			throw  new CustomerException(40001,'参数错误');
		}
		$homework = Homework::where('homework_id',$oneHomeworkQuestion->homework_id)->where('weixin_id',$this->wxUser->wx_user_id)->first();
		if(empty($homework)){
			throw  new CustomerException(40001,'参数错误');
		}
		$oneHomeworkQuestion->my_answer = $answer;
		$oneHomeworkQuestion->spend_time = $spendTime;
		
		//toDO增加积分是否在说
		$oneHomeworkQuestion->status = 1;
		if($oneHomeworkQuestion->question->right_answer == $answer){
			$oneHomeworkQuestion->is_right = 'Y';
		}else{
			$oneHomeworkQuestion->is_right = 'N';
		}
		
		if($homework->question_count == $oneHomeworkQuestion->index){
			$homework->status = 1;
			$retData = array("isLastQuestion"=>true,"result"=>$homework);
		}else{
			$retData = array("isLastQuestion"=>false,"result"=>$homework);
		}
		$homework->save();
		$oneHomeworkQuestion->save();
		return $retData;
	}
	
	public function checkUserGameQuestionStatus(){
		$weixin_id = $this->wxUser['wx_user_id'];
		$homework = Homework::where('weixin_id',$weixin_id)->where('homework_type',self::HOMEWORK_TYPE)->first();
		if(empty($homework)){
			return array();
		}
		return $homework;
	}
	
	
	public function getOldHomeworkQuestions($homeworkId){
		$homework = $this->checkHomework($homeworkId);
		if($homework->status == 1){
			throw  new CustomerException(40001,'参数错误');
		}
		
		$homeworkQuestions = HomeworkQuestion::with('question')->where(['homework_id'=>$homework->homework_id])->get();
		
		foreach ($homeworkQuestions as $item){
			$retData[] = array(
					'id'=>$item->id,
					'questionId'=>$item->question_id,
					'question'=>$item->question->question,
					'rightAnswer'=>$item->question->right_answer,
					'myAnswer'=>$item->my_answer,
					'isRight'=>$item->is_right,
					'spendTime'=>$item->spend_time,
					'status'=>$item->spend_time,
			);
		}
		return $retData;
		
	}
	
	public function initUserQuestion($sectionId){
		$weixin_id = $this->wxUser['wx_user_id'];
		$homework = Homework::where('weixin_id',$weixin_id)->where('homework_type',self::HOMEWORK_TYPE)->first();
		if(!empty($homework) && $homework->status != 1){
			return array("hasOldHomework"=>true,'homework'=>$homework);
		}
		$homework = Homework::where('weixin_id',$weixin_id)->where('section_id',$sectionId)->where('homework_type',self::HOMEWORK_TYPE)->first();
		if(empty($homework)){
			$limit = 10;
			$questions = SectionQuestion::where('question_type','FillIn')
						->where('section_id', $sectionId)
						->orderByRaw('RAND()')
						->take($limit)
						->get();
			if( empty($questions) ){
				return -1;//没有题目数
			}
			$homework = new Homework();
			$homeworkQuestions = $homework->initUserHomework($weixin_id,$sectionId, $questions);
			if(empty($homework)){
				return -2;//异常
			}
		}else{
			if($homework->status ==1){
				return -2;//异常
			}
			$homeworkQuestions = HomeworkQuestion::with('question')->where(['homework_id'=>$homework->homework_id])->get();
		}
		
		foreach ($homeworkQuestions as $item){
			$retData[] = array(
				'id'=>$item->id,
				'questionId'=>$item->question_id,	
				'question'=>$item->question->question,
				'rightAnswer'=>$item->question->right_answer,
				'myAnswer'=>$item->my_answer,
				'isRight'=>$item->is_right,
				'spendTime'=>$item->spend_time,
				'status'=>$item->spend_time,
			);
		}
		return array("hasOldHomework"=>false,'homework'=>$homework,'questions'=>$questions);
	}
	
	public function  getRank($gradeNo){
		if($gradeNo == 0){
			
		}
	}

}


?>