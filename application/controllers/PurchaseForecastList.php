<?php
/*
 * It is used for the Web Controller, extending CIController.
 * The name of the class must have first Character as Capital.
 *
**/
class PurchaseForecastList extends CI_Controller {
	function __construct()
	{
		parent::__construct();
	  	$this->load->library('session'); 
	    $this->load->library('Pager');
	    $this->load->library('Helper'); 
	    $this->load->model("purchase");
	    $this->load->model('common');
	    $this->helper->chechActionList(array('purchaseForecastList'),true);
	}

 // 获取前端 post 传递过来的查询条件
   private function getQueryCondition(){
      $cond = array( );

      $facility_id = $this->getInput('facility_id');
      if( isset($facility_id)) {
      	$cond['facility_id'] = $facility_id;
      }
      
      $start_time = $this->getInput('start_time');
      if( isset($start_time)) {
      	$cond['start_time'] = $start_time;
      } else{
      	$cond['start_time'] = date('Y-m-d H:i:s', strtotime('-1 month'));
      }
      
      $end_time = $this->getInput('end_time');
      if( isset($end_time)) {
      	$cond['end_time'] = $end_time;
      } 
      
      $process_status = $this->getInput('process_status');
      if (isset($process_status)) {
      	$cond['process_status'] = $process_status;
      }
      
      $pf_sn = $this->getInput('pf_sn');
      if( isset($pf_sn)) {
      	$cond['pf_sn'] = $pf_sn;
      }
      
      $created_user = $this->getInput('created_user');
      if( isset($created_user)) {
      	$cond['created_user'] = $created_user;
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
  		$facility_list = $this->common->getFacilityList();
	  	$cond = $this->getQueryCondition();   // 获取查询条件 下面需要把条件传递到前端 
	  	if(isset($cond['error']) && $cond['error'] == 'error') {
	  		echo $cond['error_info'];
	  		return;
	  	}
     	$offset = (intval($cond['page_current'])-1)*intval($cond['page_limit']);
      	$limit = $cond['page_limit'];
	  	$out = $this->purchase->getPurchaseForecastList($cond,$offset,$limit);
	  	$cond['facility_list'] = $facility_list['data'];
	  	if(!isset($out['data'])){  // 调用 api 出现错误
	  		$con['error_info'] = $out['error_info'];
	  	}else{  //  调用 API 成功
	  		$purchaseForecastList =  $out['data']['purchase_forecast_list'] ;
	  		$cond['purchase_forecast_list'] = $purchaseForecastList;
	  		// 分页
	  		$record_total = $out['data']['total'];
	  		$page_count = $cond['page_current']+3;
	  		if( count($purchaseForecastList) < $limit ){
	  			$page_count = $cond['page_current'];
	  		}
	  		if(!empty($record_total)){
	  			$cond['record_total'] = $record_total;
	  			$page_count = ceil($record_total / $limit );
	  		}
	  		$cond['page_count'] = $page_count;
	  		$cond['page'] = $this->pager->getPagerHtml($cond['page_current'],$page_count);
	  	}
	  	$data = $this->helper->merge($cond);
	  	$this->load->view('purchase_forecast_list',$data);
  }
  
  
  public function detail(){
  	$pf_sn = $this->input->get('pf_sn');
  	$cond['pf_sn'] = $pf_sn;
  	$facility_name = $this->input->get('facility_name');
  	$cond['facility_name'] = $facility_name;
  	$created_time = $this->input->get('created_time');
  	$cond['created_time'] = $created_time;
  	$created_user = $this->input->get('created_user');
  	$cond['created_user'] = $created_user;
  	$out = $this->purchase->getPurchaseForecastItemList($cond);
  	if($this->helper->isRestOk($out)) {
  		$cond['item_list'] = $out['purchase_forecast_item_list'];
  	}
  	$data = $this->helper->merge($cond);
  	$this->load->view('purchase_forecast_detail',$data);
  }
}
?>