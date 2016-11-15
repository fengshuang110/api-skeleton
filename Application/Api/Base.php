<?php 
namespace Application\Api;

class Base{
	public static $errCode = array(
			"40001"=>"未定义的错误码",
			"20001"=>"帐号密码错误",
			"20002"=>"手机号已注册",
			"20019"=>"手机号未注册",
			"20028"=>"短信发送失败",
			"20000"=>"参数错误",
			'20027'=>"短信验证码不正确",
			'10001'=>'自定义错误',
			'0'=>"成功",
		    '-1'=>"失败"
	);
	
	protected function success($data=array()){
		var_dump(\Application::$dbConnection['default']->getQueryLog());
		var_dump(\Application::$dbConnection['database2']->getQueryLog());
		die;
		$code = 0;
		return array("code"=>$code,'msg'=>self::$errCode[$code],'data'=>$data);
	}
	
	protected function error($code,$message='',$data=array()){
		$code = 10001;
		$msg = empty($message) ? self::$errCode[$code] : $message;
		return array("code"=>$code,'msg'=>$msg,'data'=>$data);
	}
	
	protected  function successMessage($msg = '',$data=array(),$code=0){
		$msg = empty($msg) ? self::$errCode[$code] : $msg;
		return array("code"=>$code,'msg'=>$msg,'data'=>$data);
	}
	protected  function customerError($msg='',$data=array(),$code = 10001){
		$msg = empty($msg) ? self::$errCode[$code] : $msg;
		return array("code"=>$code,'msg'=>$msg,'data'=>$data);
	}
}

?>