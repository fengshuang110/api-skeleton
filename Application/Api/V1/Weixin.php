<?php 
namespace Application\Api\V1;

use Application\Api\Base;
use Application\Third\Wechat;
use Application\Model\User\WeixinUser;
use Application\Service\WeixinAuthService;
use Application\Service\WeixinMapGameService;

class Weixin extends Base{
    //两个参数
	const DOMAIN = "http://121.40.203.96";
	protected $wechatoption =  array(
			'appid'=>"wx90275296d5e08ee2",
			'appsecret'=>"739ea4eee0e0a40b4c8569ed0056086c",
			'token'=>'maths', //填写你设定的key
	);
	
	/**
	 *微信授权中转
	 * @param unknown $callback
	 */
	public function auth2($callback){
		$wechat = Wechat::getInstance($this->wechatoption);
		$wechat->getOauthRedirect($callback);
		header("Location: {$callback}");
		exit();
	}
	
	/**
	 * 授权登录接口
	 * @return multitype:number unknown Ambigous <unknown, multitype:string >
	 */
	public function auth(){
		$wechat = Wechat::getInstance($this->wechatoption);
		$OauthAccessToken = $wechat->getOauthAccessToken();
		if(empty($OauthAccessToken)){
			$OauthAccessToken = array(
					'openid'=>'1234567890'
			);
		}
		if($OauthAccessToken){
			$user['source'] = 'weixin';
			$wxUser = array(
				'openid'=>$OauthAccessToken['openid'],
			);
			$result = WeixinAuthService::getInstance()->registerUser($user, $wxUser);
			if($result){
				header('Location: http://localhost/app.html?token='.$result['access_token']);
				exit();
				return $this->successMessage('授权注册成功',$result);
			}
			return $this->customerError('微信注册用户失败');
		}
		return $this->customerError('授权失败');
	}
}

?>