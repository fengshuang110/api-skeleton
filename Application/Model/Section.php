<?php 
namespace Application\Model;

use Illuminate\Database\Eloquent\Model;
class Section extends Model{
	
	protected $table = 'section';
	protected $primaryKey = "section_id";
	
	public function __construct(){
		Connection::init();
	}
	
	public function questions(){
		return $this->hasMany('SectionQuestion', 'section_id', 'section_id');
	}
	
}
?>