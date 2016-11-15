<?php 
namespace Application\Api\V1;

use Application\Api\Base;
use Application\Service\DictionaryConfService;
use Application\Service\WeixinAuthService;

class WeixinAuth extends Base{
	public $wxUser;
    public function __contruct(){
    	$this->wxUser = WeixinAuthService::verifyLogin();
    }
}

?>