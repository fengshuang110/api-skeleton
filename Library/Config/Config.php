<?php 
namespace Library\Config;

class Config{
	
	public static  function array2object($array) {
	  if (is_array($array)) {
	    $obj = new \stdClass();
	    foreach ($array as $key => $val){
	      $obj->$key = $val;
	    }
	  }
	  else { $obj = $array; }
	  return $obj;
	}
	public static function object2array($object) {
	  if (is_object($object)) {
	    foreach ($object as $key => $value) {
	      $array[$key] = $value;
	    }
	  }
	  else {
	    $array = $object;
	  }
	  return $array;
	}
}

?>