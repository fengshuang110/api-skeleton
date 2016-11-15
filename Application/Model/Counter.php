<?php 
namespace Application\Model;

use Illuminate\Database\Eloquent\Model;
class Counter extends Model{
	
	protected $table = 'edu_counter';
	protected $primaryKey = "id";
	
	public function __construct(){
		Connection::init();
	}
	
	public static  function getValue($key){
		$record = self::where('key',$key)->first();
		if(empty($record)){
			return 0;
		}
		return $record->value;
	}
	
}
?>