<?php
/*
 * It is used for the Web Controller, extending CIController.
 * The name of the class must have first Character as Capital.
 *
**/
class PurchaseForecast extends CI_Controller {
	function __construct()
	{
		parent::__construct();
	  	$this->load->library('session'); 
	    $this->load->library('Pager');
	    $this->load->library('Helper'); 
	    $this->load->model("purchase");
	    $this->load->model('common');
	    $this->helper->chechActionList(array('purchaseForecast','suppliesPurchaseForecast'),true);
	}

	private function getQueryCondition( ){
		$cond = array( );
		
		//默认嘉兴仓
		$facility_id = $this->getInput('facility_id');
		if(isset($facility_id)) {
			$cond['facility_id'] = $facility_id;
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
  	$this->helper->chechActionList(array('purchaseForecast'),true);
  	$this->showIndex('goods');
  }
  
  public function suppliesIndex() {
  	$this->helper->chechActionList(array('suppliesPurchaseForecast'),true);
  	$this->showIndex('supplies');
  }
  
  public function showIndex($product_type){
  	$cond = $this->getQueryCondition();
  	$cond['product_type'] = $product_type;
  	$facility_list = $this->common->getFacilityList();
  	if(empty($cond['facility_id']) && !empty($facility_list['data'][0]['facility_id'])){
  		$cond['facility_id'] = $facility_list['data'][0]['facility_id'];
  	}
  	$out = $this->purchase->getPurchaseForecast( $cond);
  	if (isset($facility_list['error_info'])) {
  		$cond['facility_list'] = array();
  	} else {
  		if(isset($facility_list['data'])){
  			$cond['facility_list'] = $facility_list['data'];
  		}
  	}
  	if($this->helper->isRestOk($out)) {
  		$cond['init_item_list'] = $out['init_item_list'];
  		$cond['add_weekend_order'] = $out['add_weekend_order'];
  	}
  	$fulfill_end_time = $this->common->getFacilityAttribute($cond['facility_id'], 'fulfill_end_time');
  	if(isset($fulfill_end_time)){
  		$cond['fulfill_end_time'] = $fulfill_end_time;
  	}
  	$data = $this->helper->merge($cond);
  	$this->load->view('purchase_forecast', $data);
  }
  
  public function addPurchaseForecast(){
  	$cond = $this->getAddCondition();
  	$out = $this->purchase->addPurchaseForecast($cond);
  	if($out == 'success'){
  		echo json_encode( array( "success" => 'success' ) );
  	} else {
  		echo json_encode( array( "success" => 'fail','error_info'=>!empty($out)?$out:'服务器内部错误' ) );
  	}
  }
  
  private function getAddCondition(){
  	$cond = array();
  	//默认嘉兴仓
  	$facility_id = $this->getInput('facility_id');
  	if(isset($facility_id)) {
  		$cond['facility_id'] = $facility_id;
  	}
  	$pf_items = $this->input->post('pf_items');
  	if(isset($pf_items)) {
  		$cond['pf_items'] = $pf_items;
  	}
  	return $cond;
  }
}
?>