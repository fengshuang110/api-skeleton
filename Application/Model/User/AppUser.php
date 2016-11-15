<?php 
namespace Application\Model\User;

use Illuminate\Database\Eloquent\Model;
use Application\Model\Connection;
use Library\Helper\Security;
use Illuminate\Support\Facades\DB;
class AppUser extends Model{
	
	protected $table = 'edu_app_user';
	protected $primaryKey = "app_user_id";
	protected $security;
	public function __construct(){
		Connection::init();
	}
	
}
?>