<?php 
namespace Application\Model\Weixin;


/**
 * 微信用户积分记录
 */
use Illuminate\Database\Eloquent\Model;
use Application\Model\Connection;
class Integral extends Model{
	
	protected $table = 'edu_wx_integral';
	protected $primaryKey = "id";
	
	public function __construct(){
		Connection::init();
	}
	
}
?>