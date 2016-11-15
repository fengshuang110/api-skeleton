<?php 
namespace Application\Model\Weixin;

use Illuminate\Database\Eloquent\Model;
use Application\Model\Connection;
use Application\Model\SectionQuestion;
class HomeworkQuestion extends Model{
	
	protected $table = 'edu_wx_homework_question';
	protected $primaryKey = "id";
	
	public function __construct(){
		Connection::init();
	}
	
	public function Question(){
        return $this->belongsTo(new SectionQuestion,'question_id', 'question_id');
    }
    
	
}
?>