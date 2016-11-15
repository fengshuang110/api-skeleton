<?php 
namespace Application\Model\User;

use Illuminate\Database\Eloquent\Model;
use Application\Model\Connection;
class User extends Model{
	
	protected $table = 'edu_user';
	protected $primaryKey = "user_id";
	
	public function __construct(){
		Connection::init();
	}
	
}
?>