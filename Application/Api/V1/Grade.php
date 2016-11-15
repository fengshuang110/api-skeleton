<?php 
namespace Application\Api\V1;

use Application\Api\Base;
use Application\Service\TikuService;
use Application\Service\GradeService;

class Grade extends Base{
	/**
	 * 获取年级列表
	 * @url GET /list
	 */
	public function lists(){
		$result = GradeService::getInstance()->getGrade();
		return $this->success($result);
	}
}

?>