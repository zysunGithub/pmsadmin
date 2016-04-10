<?php
/*
 * It is used for the Web Controller, extending CIController.
 * The name of the class must have first Character as Capital.
 *
**/
class ArnormalBolItemList extends CI_Controller {
	function __construct()
	{
		parent::__construct();
	  	$this->load->library('session'); 
    	$this->load->library('Pager');
	    $this->load->library('Helper'); 
		$this->load->model('common'); 
		$this->load->model('purchase');
		$this->helper->chechActionList( array('arnormalBolItemList'),true );
	}
	
	public function index() {
		$facility_list = $this->common->getFacilityList();
	  	$cond = $this->getQueryCondition($facility_list);   // 获取查询条件 下面需要把条件传递到前端 
	  	if(isset($cond['error']) && $cond['error'] == 'error') {
	  		echo $cond['error_info'];
	  		return;
	  	}
     	$offset = (intval($cond['page_current'])-1)*intval($cond['page_limit']);
      	$limit = $cond['page_limit'];
	  	$out = $this->purchase->getArnormalAsnItemList($cond,$offset,$limit);
	  	$cond['facility_list'] = $facility_list['data'];
	  	if(!isset($out['data'])){  // 调用 api 出现错误
	  		$con['error_info'] = $out['error_info'];
	  	}else{  //  调用 API 成功
	  		$bol_item_list =  $out['data']['bol_item_list'] ;
	  		$cond['bol_item_list'] = $bol_item_list;
	  		// 分页
	  		$record_total = $out['data']['total'];
	  		$page_count = $cond['page_current']+3;
	  		if( count($bol_item_list) < $limit ){
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
	  	$this->load->view('arnormal_bol_item_list',$data);
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

   // 获取前端 post 传递过来的查询条件
   private function getQueryCondition($facility_list){
      $cond = array( );  

      if(!isset($facility_list)){
      	$cond['error'] = 'error';
  		$cond['error_info'] = '账号无仓库权限';
  		return $cond;
      }
      
      $facility_id = $this->getInput('facility_id');
      if( isset($facility_id)) {
      	$cond['facility_id'] = $facility_id;
      }  else {
      	if(isset($facility_list['data'][0]['facility_id'])) {
      		$cond['facility_id'] = $facility_list['data'][0]['facility_id'];
      	} else {
      		$cond['error'] = 'error';
      		$cond['error_info'] = '获取仓库失败';
      		return $cond;
      	}
      }
      
      $product_type = $this->getInput( 'product_type' );
      $cond['product_type'] = empty( $product_type ) ? "goods" : $product_type;

      $start_time = $this->getInput('start_time');
      if( isset($start_time)) {
      	$cond['start_time'] = $start_time;
      } else{
      	$cond['start_time'] = date('Y-m-d', strtotime('-1 week'));
      }
      
      $end_time = $this->getInput('end_time');
      if( isset($end_time)) {
      	$cond['end_time'] = $end_time;
      } else {
      	$cond['end_time'] = date('Y-m-d');
      }
      
      $is_arnormal = $this->getInput('is_arnormal');
      if( isset($is_arnormal)) {
      	$cond['is_arnormal'] = $is_arnormal;
      } 
      
      $bol_sn = $this->getInput('bol_sn');
      if( isset($bol_sn)) {
      	$cond['bol_sn'] = $bol_sn;
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
}
?>