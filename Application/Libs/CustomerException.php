<?php 
namespace Application\Libs;

use Luracast\Restler\RestException;
class CustomerException extends RestException{
	protected $customerCode;
	public function __construct($customerCode = 40001, $errorMessage = '自定义错误', $httpStatusCode=200,array $details = array(), \Exception $previous = null){
		$this->customerCode = $customerCode;
		parent::__construct($httpStatusCode, $errorMessage,$details, $previous);
	}
	
	public function getCustomerCode(){
		return $this->customerCode;
	}
}

?>