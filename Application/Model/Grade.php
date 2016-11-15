<?php 
namespace Application\Model;

use Illuminate\Database\Eloquent\Model;
class Grade extends Model{
	
	protected $table = 'edu_grade';
	protected $primaryKey = "id";
	
	public function __construct(){
		Connection::init();
	}
	
}
?>