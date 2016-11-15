<?php 
namespace Application\Model\Database2\User;

use Application\Model\SectionQuestion;
use Application\Model\Database2\Connection;
use Application\Model\Database2\BaseModel;

class Section extends BaseModel{
	
	protected $table = 'sections';
	protected $primaryKey = "section_id";
	
	public function __construct(){
		Connection::init();
	}
	
	public function questions(){
		return $this->hasMany(new SectionQuestion(), 'section_id', 'section_id');
	}
	
}
?>