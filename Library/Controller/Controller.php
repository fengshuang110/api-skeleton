<?php 
namespace Library\Controller;
class Controller{
  	
  	private  $request;
  	public function __construct(){
  		$this->request = $this->setRequest();
  	}
  	
  	public function setRequest(){
  		$this->request = new Request();
  	}
  	
	public function getRequest(){
		if(empty($this->request)){
			$this->setRequest();
		}
		return $this->request;
	}
	/**
	 * @view $template
	 * @param unknown $template
	 * @param unknown $params
	 */
	public function Jump($template,$params){
		return array();
	}
	public function redirect($url){
		header("location: ". $url);exit();
	}
	
	public function Json($data){
		header("Content-type: application/json");
		echo  json_encode($data);exit();
	}
	
} 

class Request{
	public $params;
	public function __construct(){
		$this->params = (Object)$_SERVER;
	}
	
	public function isPost(){
		if(strtolower($this->params->REQUEST_METHOD) == 'post'){
			return true;
		}
		return false;
 	}
 	
 	public function isXmlHttpRequest(){
 		if(!isset($this->params->HTTP_X_REQUESTED_WITH)){
 			return false;
 		}
 		if( $this->params->HTTP_X_REQUESTED_WITH != 'XMLHttpRequest'){
 			return false;
 		}
 		return true;
 	}
 	
 	public function getPost($name="",$defalut=""){
		if(empty($name)){
			return $_POST;
		}
		if(!empty($_POST[$name])){
			return $_POST[$name];
		} 
		return $defalut;		
 	}
 	
 	public function getQuery($name="",$defalut=""){
 		if(empty($name)){
 			return $_GET;
 		}
 		if(!empty($_GET[$name])){
 			return $_GET[$name];
 		}
 		return $defalut;	
 	}
 	
 	public function getFile($name){
 		if(empty($name)){
 			return $_FILES;
 		}
 		if(!empty($_FILES[$name])){
 			return $_FILES[$name];
 		}
 		return ;
 	}
	
}
?>