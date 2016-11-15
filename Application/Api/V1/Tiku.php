<?php 
namespace Application\Api\V1;

use Application\Api\Base;
use Application\Service\TikuService;

class Tiku extends Base{
	/**
	 * 根据年级获取地图板块
	 * @url GET /maps
	 * @param unknown $grade_no
	 * @return multitype:unknown number multitype:string
	 */
	public function getMap($grade_no){
		$result = TikuService::getInstance()->getMap($grade_no);
		return $this->success($result);
	}
	/**
	 * 根据地图板块得到关卡
	 * @url GET /map/levels
	 * 
	 * @param unknown $sectionId
	 */
	public function getMapLevel($sectionId){
		$result = TikuService::getInstance()->getMapLevel($sectionId);
		return $this->success($result);
	}
}

?>