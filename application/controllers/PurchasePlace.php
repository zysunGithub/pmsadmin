<?php
/*
 * It is used for the Web Controller, extending CIController.
 * The name of the class must have first Character as Capital.
 *
**/
class PurchasePlace extends CI_Controller {
	function __construct()
	{
		parent::__construct();
	  	$this->load->library('session'); 
	    $this->load->library('Pager');
	    $this->load->library('Helper'); 
	    $this->load->model("purchase");
	    $this->load->model('common');
	    $this->helper->chechActionList(array('purchasePlace'),true);
	}

	private function getQueryCondition( ){
		$cond = array( );
		
		$area_id = $this->getInput('area_id');
		if(isset($area_id)) {
			$cond['area_id'] = $area_id;
		} 
		
		$start_time = $this->getInput("start_time");
		if(isset($start_time)) {
			$cond['start_time'] = $start_time;
		}
		
		$end_time = $this->getInput('end_time');
		if(isset($end_time)){
			$cond['end_time'] = $end_time;
		}
		
		$purchase_place_name = $this->getInput('purchase_place_name');
		if(isset($purchase_place_name)) {
			$cond['purchase_place_name'] = $purchase_place_name;
		}
		
		$page_current = $this->getInput('page_current');
		if(!empty($page_current)) {
			$cond['page_current'] = $page_current;
		}else{
			$cond['page_current'] = 1;
		}
		
		$page_limit = $this->getInput('page_limit');
		if(!empty($page_limit)) {
			$cond['page_limit'] = $page_limit;
		}else{
			$cond['page_limit'] = 10;
		}
		return $cond;
	}
	
	// 从 get 或 post 获取数据 优先从 post 没有返回 null
	private function getInput($name){
		$out = trim( $this->input->post($name) );
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
  	$offset = (intval($cond['page_current'])-1)*intval($cond['page_limit']);
  	$limit = $cond['page_limit'];
	$out = $this->purchase->getPurchasePlace( $cond ,$offset,$limit);
	if(!isset($out['data'])){  // 调用 api 出现错误
		$con['error_info'] = $out['error_info'];
	}else{  //  调用 API 成功
		$purchase_place_list =  $out['data']['purchase_place_list'] ;
		$cond['purchase_place_list'] = $purchase_place_list;
		// 分页
		$record_total = $out['data']['total'];
		$page_count = $cond['page_current']+3;
		if( count($purchase_place_list) < $limit ){
			$page_count = $cond['page_current'];
		}
		if(!empty($record_total)){
			$cond['record_total'] = $record_total;
			$page_count = ceil($record_total / $limit );
		}
		$cond['page_count'] = $page_count;
		$cond['page'] = $this->pager->getPagerHtml($cond['page_current'],$page_count);
	}
	
	$area_list = $this->common->getAreaList();
	if(isset($area_list['data'])) {
		$cond['area_list'] = $area_list['data'];
	}
	
	$data = $this->helper->merge($cond);
	$this->load->view('purchase_place', $data);
  }
  
  public function addPurchasePlace(){
  	$type = $this->getInput("type");
  	if(!isset($type)) {
  		echo json_encode( array( "success" => 'fail','error_info'=>'采购地点类型不能为空' ) );
  		return false;
  	}
  	
  	$area_id = $this->getInput("area_id");
  	if($type == 'MARKET' && !isset($area_id)) {
  		echo json_encode( array( "success" => 'fail','error_info'=>'大区不能为空' ) );
  		return false;
  	}
  	$purchase_place_name = $this->getInput('purchase_place_name');
  	if(!isset($purchase_place_name)) {
  		echo json_encode( array( "success" => 'fail','error_info'=>'采购地点不能为空' ) );
  		return false;
  	}
  	$cond['area_id'] = $area_id;
  	$cond['type'] = $type;
  	$cond['purchase_place_name'] = $purchase_place_name;
  	
  	
  	$out = $this->purchase->addPurchasePlace($cond);
   	if($out == 'success'){
  		echo json_encode( array( "success" => 'success' ) );
  	} else {
  		echo json_encode( array( "success" => 'fail','error_info'=>!empty($out)?$out:'服务器内部错误' ) );
  	}
  }
  
  public function removePurchasePlace(){
  	$purchase_place_id = $this->getInput('purchase_place_id');
  	if(!isset($purchase_place_id)) {
  		echo json_encode( array( "success" => 'fail','error_info'=>'删除采购地点失败' ) );
  	}
  	
  	$out = $this->purchase->removePurchasePlace($purchase_place_id);
  	if($out == 'success'){
  		echo json_encode( array( "success" => 'success' ) );
  	} else {
  		echo json_encode( array( "success" => 'fail','error_info'=>!empty($out)?$out:'服务器内部错误' ) );
  	}
  }
}
?>