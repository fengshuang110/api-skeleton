<?php 
namespace Application\Service;

use Application\Libs\AES;
use Luracast\Restler\RestException;
use Application\Model\User\WeixinUser;
use Application\Libs\CustomerException;
class WeixinAuthService extends BaseService{
	
	public static $instance = null;
	protected $cache = null;
	private function __construct(){
	}
	public static function getInstance(){
		if(self::$instance == null){
			self::$instance = new WeixinAuthService();
		}
		return self::$instance;
	}
	
	public function getWeixinUserByOpenId($openid){
		if(empty($openid)){
			return null;
		}
		$wxUser = WeixinUser::where('open_id',$openid)->first();
		if(empty($wxUser)){
			return $wxUser;
		}
	}
	
	public function registerUser($user,$wxUser){
		$model = new WeixinUser();
		$result =  $model->saveUser($user, $wxUser);
		if($result){
			return $this->saveLogin($result);
		}
		return $result;
	}
	
	public function saveLogin($wxUserObj){
		$aes = new AES();
		$access_token = $aes->encode($wxUserObj->openid.'||'.$wxUserObj->salt);
		$res['access_token'] = $access_token;
		return $res;
	}
	/**
	 * 校验登录
	 * @access protected
	 * @return object
	 */
	public  static function verifyLogin($token = ""){
		$openid = 'oThrSjhFfF9AMbOWiz5N1OJCSFmk';
		$wexinUser = new WeixinUser();
		$user = $wexinUser->getByOpenid($openid);
		return $user;
		// 		$res =  $cache->get($token);
		// 		if(empty($res)){
		// 			throw new \Exception("未登录");
		// 		}
		// 		return $res;
		if(empty($token)){
			$token = self::getAccesstoken();
		}
		$token = str_replace(" ", "+", $token);
		$aes = new AES();
		$token = $aes->decode($token);
		$arrToken = explode('||', $token);
		if (count($arrToken) != 2) {
			throw new  CustomerException(40001,'未登录');
		}
		$openid = $arrToken[0];
		$salt = $arrToken[1];
		$wexinUser = new WeixinUser();
		//         $mobile = '13811209065';
		//         $passwd = md5('aaaaaa');
		$user = $wexinUser->getByOpenid($openid);
	
		if ($user === null) {
			//只需要返回客户端token失效
			throw new  CustomerException(40001,'未登录');
		}
		if(!$user->validateUser()){
			//只需要返回客户端token失效
			throw new  CustomerException(40001,'未登录');
		}
		return $user;
	}
	/**
	 * 获取请求的access_token值
	 * @return unknown|Ambigous <multitype:, number, multitype:unknown , boolean>|multitype:
	 */
	protected static function getAccesstoken(){
	
		$post = $_GET;
		$get = $_POST;
		$get = empty($get)?array():$get;
		$post = empty($post)?array():$post;
		$params = array_merge($post,$get);
		if(!empty($params['token'])){
			return $params['token'];
		}
		if(!empty($_REQUEST['token'])){
			return $_REQUEST['token'];
		}
	
		if(preg_match('/[\?\&]token=(\w+)/', $_SERVER['REQUEST_URI'], $matches)){
			return $matches[1];
		}
	
		if(!empty($_SERVER['HTTP_AUTHORIZATION'])){
			return explode(" ", $_SERVER['HTTP_AUTHORIZATION'])[1];
		}
	
	}
	
}


?>