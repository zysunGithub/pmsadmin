<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class Supplierreturn extends CI_Model {

    private $CI;
    private $helper;
    function __construct(){
        parent::__construct();
        if(!isset($this->CI)){
            $this->CI = & get_instance();
        }
        if(!isset($this->helper)){
            $this->CI->load->library('Helper'); 
            $this->helper = $this->CI->helper;
        }
    }
    
    public function getCanSupplierReturnProductList($cond = array()){
        $out =  $this->helper->get("/admin/can_supplier_return_product_list",$cond); 
        $result = array();  
        if($this->helper->isRestOk($out)){
            $result['data'] = $out;
        }else{
            $result['error_info'] = $out['error_info'];
        }
        return $result; 
    }
   
    
    public function getSupplierReturnList($cond = array()) {
    	$out =  $this->helper->get("/admin/supplier_return_list",$cond); 
        return $out; 
    }
    public function createSupplierReturn($cond = array()) {
    	$out =  $this->helper->post("/admin/create_supplier_return",$cond);
    	$result = array();  
        if($this->helper->isRestOk($out)){
            $result['data'] = $out;
        }else{
            $result['error_info'] = $out['error_info'];
        }
        return $result; 
    }
    
    public function checkSupplierReturn($cond) {
    	$out =  $this->helper->post("/admin/check_supplier_return",$cond);
    	if($this->helper->isRestOk($out)){
    		$out['success'] = "OK";
    	}
    	return $out ;
    }
    public function executeSupplierReturn($cond) {
    	$out =  $this->helper->post("/admin/execute_supplier_return",$cond);
    	if($this->helper->isRestOk($out)){
    		$out['success'] = "OK";
    	}
    	return $out ;
    }
    
    public function finishSupplierReturn($cond) {
    	$out =  $this->helper->post("/admin/finish_supplier_return",$cond);
    	if($this->helper->isRestOk($out)){
    		$out['success'] = "OK";
    	}
    	return $out ;
    }
    // 区总
    public function purchaseManagerCheckSupplierReturn($cond) {
        $out =  $this->helper->post("/admin/purchase_manager_check_supplier_return",$cond);
        if ($this->helper->isRestOk($out)) {
            $out['success'] = "OK";
        }
        return $out ;
    }
}

  