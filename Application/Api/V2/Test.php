<?php 
namespace Application\Api\V2;

use Application\Api\Base;

class Test extends Base{
	//没有参数
	public function func1(){
		return $this->success(array("message"=>"成功"));
	}
    //两个参数
	public function func2($arg1,$arg2){
		return $this->success(array("message"=>"成功"));
	}
	//更多参数
	public function func3($arg1,$arg2,$arg3){
		return $this->success(array("message"=>"成功"));
	}
	//失败
	public function func4($arg1,$arg2,$arg3){
		return $this->error(array("message"=>"成功"));
	}
}

?>