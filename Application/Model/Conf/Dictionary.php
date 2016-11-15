<?php 
namespace Application\Model\Conf;

use Illuminate\Database\Eloquent\Model;
use Application\Model\Connection;
class Dictionary extends Model{

	protected $table = 'edu_dictionary_conf';
	protected $primaryKey = "id";

	public function __construct(){
		Connection::init();
	}
	
	public function getConfValue($table,$key){
		$record =  $this->where("table",$table)->where('key',$key)->first();
		if(empty($record)){
			return null;
		}
		return $record->value;
	}
}
?>

