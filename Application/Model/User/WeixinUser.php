<?php 
namespace Application\Model\User;

use Illuminate\Database\Eloquent\Model;
use Application\Model\Connection;
use Library\Helper\Security;
use Illuminate\Support\Facades\DB;
class WeixinUser extends Model{
	
	protected $table = 'edu_weixin_user';
	protected $primaryKey = "wx_user_id";
	protected $security;
	public function __construct(){
		Connection::init();
		$this->security = new Security();
	}
	
	public function  getByOpenid($openid){
		if(empty($openid)){
			return false;
		}
		return $this->where('openid',$openid)->first();
	}
	
	public function saveUser($user,$wxUser){
		$wxUserObj = $this->getByOpenid($wxUser['openid']);
		if(!empty($wxUserObj)){
			return $wxUserObj;
		}
		$db = $this->getConnection();
		$db->beginTransaction();
		try {
			$userModel = new User();
			$userModel->source = $user['source'];
			$userModel->save();
			$salt = $this->security->generatePasswordHash($wxUser['openid']);
			$this->salt = $salt;
			$this->user_id = $userModel->user_id;
			$this->openid=$wxUser['openid'];
			$this->save();
			$db->commit();
			return $this;
		}catch (\Exception $e){
			$db->rollback();
			return  false;
		}
	}
	
	public function validateUser(){
		return $this->security->validatePassword($this->openid, $this->salt);
	}
	
}
?>