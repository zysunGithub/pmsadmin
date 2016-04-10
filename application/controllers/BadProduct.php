<?php

// 坏果处理
class BadProduct extends CI_Controller {
    function __construct() {
      date_default_timezone_set("Asia/Shanghai");
      parent::__construct();
      $this->load->library('Pager'); 
      $this->load->model('common');
      $this->load->model('productmodel');
    }
    
    public function getBadProductList(){
    	$cond = $this->getQueryCondition();
    	$facility_list = $this->common->getFacilityList();
    	if (isset($facility_list['error_info'])) {
    		$facility_list = array();
    	} else {
    		$facility_list = $facility_list['data'];
    	}
    	if (!isset($facility_list) || empty ($facility_list) || ! is_array($facility_list)) {
    		die("无仓库权限");
    	}
    	if (! isset($cond['facility_id'])) {
    		$cond['facility_id'] = $facility_list[0]['facility_id'];
    	}
    	$offset = (intval($cond['page_current'])-1)*intval($cond['page_limit']);
    	$limit = $cond['page_limit'];
    	$cond['offset'] = $offset;
    	$cond['size'] = $limit;
    	
    	$out = $this->helper->get("/admin/badProductList", $cond);
    	if($this->helper->isRestOk($out)){
    		$cond['product_list'] = $out['product_list'];
    	}else{
    		$cond['error_info'] = $out['error_info'];
    	}
    	
    	// 分页
    	$record_total = $out['total'];
    	$page_count = $cond['page_current']+3;
    	if(count($out['product_list']) < $limit ){
    		$page_count = $cond['page_current'];
    	}
    	if(!empty($record_total)){
    		$cond['record_total'] = $record_total;
    		$page_count = ceil($record_total / $limit );
    	}
    	$cond['page_count'] = $page_count;
    	$cond['page'] = $this->pager->getPagerHtml($cond['page_current'],$page_count);
    	
    	$cond['facility_list'] = $facility_list;
    	$data = $this->helper->merge($cond);
    	$this->load->view('bad_product_list',$data);
    }
    
    public function recordBadProduct() {
    	$cond = $this->getQueryCondition();
    	$out = $this->helper->post("/admin/product/bad/record",$cond);
    	$success = "true";
    	if($this->helper->isRestOk($out)){
    		echo json_encode(array("success"=>"true", "stocktake_bad_id"=>$out['stocktake_bad_id']));
    	}else{
    		echo json_encode(array("success"=>"false", "error_info"=>$out['error_info']));
    	}
    }

    public function recordDefectiveProduct() {
        $cond = $this->getQueryCondition();
        $out = $this->helper->post("/admin/product/defective/record",$cond);
        $success = "true";
        if($this->helper->isRestOk($out)){
            echo json_encode(array("success"=>"true", "stocktake_bad_id"=>$out['stocktake_bad_id']));
        } else {
            echo json_encode(array("success"=>"false", "error_info"=>$out['error_info']));
        }
    }
    
     private function getQueryCondition() {
        $cond = array( );
        $cond['start_time'] = date('Y-m-d', time());
        
        $start_time =  $this->getInput('start_time');
        if(isset($start_time)) $cond['start_time'] = $start_time;// 时间段起始
        $end_time =  $this->getInput('end_time');// 时间段终止
        if(isset($end_time)) $cond['end_time'] = $end_time;
        
        $product_id =  $this->getInput('product_id');
        if(isset($product_id)) $cond['product_id'] = $product_id;
        
        $product_name =  $this->getInput('product_name');
        if(isset($product_name)) $cond['product_name'] = $product_name;
        
        $facility_id =  $this->getInput('facility_id');
        if(isset($facility_id)) $cond['facility_id'] = $facility_id;
        
        $quantity =  $this->getInput('quantity');
        if(isset($quantity)) $cond['quantity'] = $quantity;
        
        $note =  $this->getInput('note');
        $cond['note'] = "";
        if(isset($note)) $cond['note'] = $note;
        
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
    private function getInput($name) {
        $out = trim($this->input->post($name));
        if(isset($out) && $out!=""){
          return $out;
        }else{
          $out = trim($this->input->get($name));
          if(isset($out) && $out !="") return $out;
        }
        return null;
    }
    
    public function getProductList(){
    	$out = array();
    	$out = $this->productmodel->getProductList(array());
    	if(isset($out)&&isset($out['product_list'])){
    		echo json_encode(array('success'=>'success','product_list'=>$out['product_list']));
    	}else{
    		echo json_encode(array('success'=>'failed'));
    	}
    }
}
?>
