<?php 
namespace Application\Service;

class BaseService{
	 protected $models = array();
	 protected static  $instance = null;
	 public function loadModel($model){
	 	$this->models[get_class($model)] = $model;
	 }
	
}

?>