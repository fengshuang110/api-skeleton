<?php 
namespace Application\Api\V1;

use Application\Api\Base;
use Application\Model\Database2\User\Section;
use Illuminate\Database\Eloquent\Model;
use Application\Model\Database2\BaseModel;

class Test extends Base{
	
    public function action1($section_id){
    	$record = Section::whereIn('section_id', array('142','143'))->with('questions')->get();
foreach ($record as $item){
	var_dump(count($item->questions));
}
die;
//     	var_dump(BaseModel::getConnectionResolver()->connection()->getQueryLog());
//    		var_dump(Model::getConnectionResolver()->connection()->getQueryLog());die;
    	return $this->success(($record));
    }
}

?>