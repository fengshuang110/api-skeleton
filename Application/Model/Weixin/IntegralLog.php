<?php 
namespace Application\Model\Weixin;

use Illuminate\Database\Eloquent\Model;
use Application\Model\Connection;
/**
 * 微信积分日志记录
 * @author sks
 *
 */
class IntegralLog extends Model{
	
	protected $table = 'edu_wx_integral_log';
	protected $primaryKey = "id";
	
	public function __construct(){
		Connection::init();
	}
	
}
