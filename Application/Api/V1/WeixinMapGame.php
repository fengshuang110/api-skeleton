<?php 
namespace Application\Api\V1;

use Application\Service\WeixinMapGameService;
class WeixinMapGame extends WeixinAuth{

	/**
	 * 一个一个提交题目
	 * @url POST /submit-single-question
	 * @param unknown $id
	 * @param unknown $answer
	 * @return multitype:unknown number multitype:string
	 */
	public function submitSingleQuestion($id,$answer){
		$result = WeixinMapGameService::getInstance()->submitSingleQuestion($id,$answer);
		return $this->success($result);
	}
	
	/**
	 *  初始化用户作业
	 * @url GET /init-user-question
	 *
	 */
	public function initUserQuestion($sectionId){
		$result = WeixinMapGameService::getInstance()->initUserQuestion($sectionId);
		return $this->success($result);
	}
	
	/**
	 * 检查是否有新的作业没有做
	 * @url POST /check-user-homework
	 */
	public function userGameQuestionStatus(){
		$result = WeixinMapGameService::getInstance()->checkUserGameQuestionStatus();
		return $this->success($result);
	}
	
	/**
	 * 读取没有做完的作业
	 * @url GET /get-homework-question
	 * @param unknown $homeworkId
	 * @return multitype:unknown number multitype:string
	 */
	public function oldHomeworkQuestion($homeworkId){
		$result = WeixinMapGameService::getInstance()->getOldHomeworkQuestions($homeworkId);
		return $this->success($result);
	}
	
	/**
	 * 积分排行
	 * @url GET /integral-rank
	 */
	public function integralRank(){
		
	}
}

?>