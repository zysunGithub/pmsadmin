<?php
/*
 * It is used for the Web Controller, extending CIController.
 * The name of the class must have first Character as Capital.
 *
**/
class AreaPurchaseForecast extends CI_Controller {
	function __construct()
	{
		parent::__construct();
	  	$this->load->library('session'); 
	    $this->load->library('Pager');
	    $this->load->library('Helper'); 
	    $this->load->model("purchase");
	    $this->load->model('common');
	    $this->helper->chechActionList(array('areaPurchaseForecast'),true);
	}

	
	private function getQueryCondition( ){
		$cond = array( );

		$area_id = $this->getInput('area_id');
		if(isset($area_id)) {
			$cond['area_id'] = $area_id;
		}

		return $cond;
	}
	
	// 从 get 或 post 获取数据 优先从 post 没有返回 null
	private function getInput($name){
		$out = $this->input->post($name);
		if(is_array($out)){
			$out = implode(',', $out );
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
	
  public function index()
  {
  	$cond = $this->getQueryCondition();
  	$area_list = $this->common->getAreaList();
  	if(empty($cond['area_id']) && !empty($area_list['data'][0]['area_id'])){
  		$cond['area_id'] = $area_list['data'][0]['area_id'];
  	}
	$out = $this->purchase->getAreaPurchaseForecast( $cond['area_id']);
	if (isset($area_list['error_info'])) {
		$cond['area_list'] = array();
	} else {
		if(isset($area_list['data'])){
			$cond['area_list'] = $area_list['data'];
		}
	}
	if($this->helper->isRestOk($out)) {
		$cond['item_list'] = $out['item_list'];
		$cond['available_facility_list'] = $out['facility_list'];
	}
	
	$data = $this->helper->merge($cond);
	$this->load->view('area_purchase_forecast', $data);
  }
  
}
?>