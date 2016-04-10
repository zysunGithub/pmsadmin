<?php
/*
 * It is used for the Web Controller, extending CIController.
 * The name of the class must have first Character as Capital.
 *
**/
class ProductFacilityShippingList extends CI_Controller {
	function __construct() {
		parent::__construct();
	  	$this->load->library('session'); 
	    $this->load->library('Helper'); 
	    $this->load->model("productmodel");
	    $this->load->model('common');
	}
	
	// 从 get 或 post 获取数据 优先从 post 没有返回 null
	private function getInput($name){
		$out = $this->input->post($name);
		if(is_array($out)){
			return $out;
		} else {
			$out = trim( $out );
		}
	
		if(isset($out) && $out!=""){
			return $out;
		}else{
			$out = trim($this->input->get($name));
			if(isset($out) && $out !="") return $out;
		}
		return null;
	}
	
  public function index() {
  	$cond = array();
  	$data = $this->helper->merge($cond);
  	$this->load->view('product_facility_shipping_list', $data);
  }
  
  public function getProductFactiliyShippingList() {
  	$cond = $this->getQueryCond();
  	$out = $this->productmodel->getProductFacilityShippingList($cond);
  	if($this->helper->isRestOk($out)) {
  		echo json_encode(array('res'=>'success',"list"=>$out['product_facility_shipping_list'],"recordsTotal"=>$out['total'],"recordsFiltered"=>$out['total']));
  	} else {
  		echo json_encode(array('res'=>'fail', "error_info"=>!empty($out['error_info'])?$out['error_info']:'内部服务错误' ));
  	}
  }
  
  private function getQueryCond() {
  	$cond = array();
  	$product_id = $this->getInput('product_id');
  	if(isset($product_id)) {
  		$cond['product_id'] = $product_id;
  	}
  	
  	$product_name = $this->getInput('product_name');
  	if(isset($product_name)) {
  		$cond['product_name'] = $product_name;
  	}
  	
  	$shipping_id = $this->getInput('shipping_id');
  	if(isset($shipping_id)) {
  		$cond['shipping_id'] = $shipping_id;
  	}
  	
  	$facility_id = $this->getInput('facility_id');
  	if(isset($facility_id)) {
  		$cond['facility_id'] = $facility_id;
  	}
  	
  	$length = $this->getInput('length');
  	if(isset($length)) {
  		$cond['length'] = $length;
  	}
  	
  	$start = $this->getInput('start');
  	if(isset($start)) {
  		$cond['start'] = $start;
  	}
  	
  	return $cond;
  }
}
?>