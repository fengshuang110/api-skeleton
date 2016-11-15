<?php 
namespace Application\Model\Database2;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model{
	public function __construct(){
		Connection::init();
	}
}
?>