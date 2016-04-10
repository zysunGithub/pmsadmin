<?php

// 产品转换
class ProductTransformMappingList extends CI_Controller {
    function __construct() {
      date_default_timezone_set("Asia/Shanghai");
      parent::__construct();
      $this->load->library('Pager'); 
      $this->load->library('helper'); 
      $this->load->model('product_transform_mapping');
      $this->load->model('common');
      $this->load->model('productmodel');
	  
	  $facility_list = $this->common->getFacilityList();
	  if(!isset($facility_list['data'])){
	  	die('无仓库权限');
	  }
    }
    
    public function index() {
        $this->helper->chechActionList(array('createProductTransformMapping'), true);
        $cond = array();
        $data = $this->helper->merge($cond);
        $this->load->view('product_transform_mapping',$data);
    }
    
    public function query() {
        $this->helper->chechActionList(array('showProductTransformMapping'), true);
    	$cond = $this->getQueryCondition();
        $out = $this->product_transform_mapping->showProductTransformMapping($cond);
        $cond['product_transform_mapping_list'] = $out['data']['product_transform_mapping_list'];
	    $data = $this->helper->merge($cond);
		$this->load->view('product_transform_mapping_list',$data);
    }
    
     // 从 get 或 post 获取数据 优先从 post 没有返回 null 
    private function getInput($name) {
        $out = $this->input->post($name);
        if(isset($out) && $out!=""){
          return $out;
        }else{
          $out = trim($this->input->get($name));
          if(isset($out) && $out !="") return $out;
        }
        return null;
    }
    
    private function getQueryCondition() {
    	$cond = array();
        $from_product_name = $this->getInput('from_product_name');
        if (isset($from_product_name) && $from_product_name) {
            $cond['from_product_name'] = $from_product_name;
            $from_product_id = $this->getInput('from_product_id');
            if (isset($from_product_id) && $from_product_id) {
                $cond['from_product_id'] = $from_product_id;
            }
        }
        $to_product_name = $this->getInput('to_product_name');
        if (isset($to_product_name) && $to_product_name) {
            $cond['to_product_name'] = $to_product_name;
            $to_product_id = $this->getInput('to_product_id');
            if (isset($to_product_id) && $to_product_id) {
                $cond['to_product_id'] = $to_product_id;
            }
        }
        $transform_type = $this->getInput('transform_type');
        if (isset($transform_type) && $transform_type) {
            $cond['transform_type'] = $transform_type;
        }
        $quality = $this->getInput('quality');
        if (isset($quality) && $quality) {
            $cond['quality'] = $quality;
        }
        return $cond;
    }

    public function creatProductTransformMapping(){
        $this->helper->chechActionList(array('createProductTransformMapping'), true);
        $cond = array();
        $cond['from_product_id'] = $this->getInput('from_product_id');
        $cond['to_product_id'] = $this->getInput('to_product_id');
        $cond['quantity'] = $this->getInput('quantity');
        $cond['transform_type'] = $this->getInput('transform_type');
        $cond['price_quantity'] = $this->getInput('price_quantity');
        $cond['note'] = $this->getInput('note');
        $out = $this->product_transform_mapping->creatProductTransformMappingList($cond);
        echo json_encode($out);
    }
}
?>