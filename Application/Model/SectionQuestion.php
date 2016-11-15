<?php 
namespace Application\Model;

use Illuminate\Database\Eloquent\Model;
class SectionQuestion extends Model{
	
	protected $table = 'section_question';
	protected $primaryKey = "question_id";
	
	public function __construct(){
		Connection::init();
	}
	
	public function section(){
		return $this->hasOne('Section', 'section_id', 'section_id');
	}
	
}
?>