<?php

// 产品转换
class ProductTransformProduct extends CI_Controller {
    function __construct() {
      date_default_timezone_set("Asia/Shanghai");
      parent::__construct();
      $this->load->library('Pager'); 
      $this->load->model('product_transform_mapping');
      $this->load->model('common');
      $this->load->model('productmodel');
	  
	  $facility_list = $this->common->getFacilityList();
	  if(!isset($facility_list['data'])){
	  	die('无仓库权限');
	  }
    }
    
    public function index() {
        $this->helper->chechActionList(array('createdProductTransformProduct'), true);
        $cond = array();
        $facility_list = $this->common->getFacilityList();
        $cond['is_all_facility_action'] = $this->helper->isAllFacilityAction();
        if (! isset($cond['facility_id'])) {
            $cond['facility_id'] = $facility_list['data'][0]['facility_id'];
        }
        $cond['facility_list'] = $facility_list['data'];
        $data = $this->helper->merge($cond);
        $this->load->view('product_transform_product',$data);
    }
    
    public function querylist() {
    	$this->helper->chechActionList(array('showProductTransformProduct'), true);
    	$facility_list = $this->common->getFacilityList();
    	if(empty($facility_list)) {
    		die('无仓库权限');
    	}
    	$cond = array();
    	$cond['facility_list'] = $facility_list['data'];
    	$data = $this->helper->merge($cond);
    	$this->load->view('product_transform_product_list',$data);
    }
    
    public function query() {
        $this->helper->chechActionList(array('showProductTransformProduct'), true);
    	$cond = $this->getQueryCondition();
    	$cond['to_inventory_status'] = 'in_stock';
        $cond['size'] = 10;
        $offset = (intval($cond['page_now'])-1)*intval($cond['size']);
        $cond['offset'] = $offset;
        $out = $this->product_transform_mapping->getProductTransformProduct($cond);
        if( $this->helper->isRestOk($out) ){
            $total = $out['total'];
            $cond['page_all'] = ceil($total/$cond['size']);
        }
        $transform_product_list = $this->handleTransformProductList( $out['transform_product_list'] );
        if(!empty($transform_product_list)){
            $cond['transform_product_list'] = $transform_product_list;    
        }
        $data = $this->helper->merge($cond);       
		$this->load->view('product_transform_product_list',$data);
    }

    private function handleTransformProductList($transform_product_list){
        $result = array();
        foreach ($transform_product_list as $key => $value) {
            $from = $value;
            unset($from['to_product_id']);
            unset($from['to_product_name']);
            unset($from['to_container_unid_code']);
            unset($from['to_container_unid_code_name']);
            unset($from['to_quantity']);
            unset($from['to_case_num']);
            unset($from['to_container_quantity']);
            unset($from['to_product_sub_type']);
            $result[$value['transform_product_id']]['from'] = $from;
            $result[$value['transform_product_id']]['to'][] = array(
                'to_product_name' => $value['to_product_name'],
                'to_product_id' => $value['to_product_id'],
                'to_container_unid_code' => $value['to_container_unid_code'],
                'to_container_unid_code_name' => $value['to_container_unid_code_name'],
                'to_quantity' => $value['to_quantity'],
                'to_case_num' => $value['to_case_num'],
                'to_container_quantity' => $value['to_container_quantity'],
            );
        }
        return $result;
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
        $status = $this->getInput('status');
        if (isset($status) && $status) {
            $cond['status'] = $status;
        }
        $start_apply_time = $this->getInput('start_apply_time');
        if (isset($start_apply_time) && $start_apply_time) {
            $cond['start_created_time'] = $start_apply_time;
        }
        $end_apply_time = $this->getInput('end_apply_time');
        if (isset($end_apply_time) && $end_apply_time) {
            $cond['end_created_time'] = $end_apply_time;
        }
        $status = $this->getInput('status');
        if (isset($status) && $status) {
            $cond['status'] = $status;
        }
        $facility_id = $this->getInput('facility_id');
        if (isset($facility_id)) {
        	$cond['facility_id'] = $facility_id;
        }
        $page_num = $this->getInput('page_num');
        if(!empty($page_num)){
            $cond['page_now'] = $page_num;
        }else{
            $cond['page_now'] = 1;
        }
        return $cond;
    }

    //弃用
    public function getProductTransformList(){ //autocomplete   producttransform
        $cond = array();
        $product_type = $this->getInput('product_type');
        if (isset($product_type)) {
            $cond['transform_type'] = $product_type;
        }
        $out = $this->product_transform_mapping->getProductTransformProduct($cond);
        echo json_encode( array( 'success'=>'success', 'product_transform_mapping_list' => $out['data']['transform_product_list']));
    }

    public function applyProductTransformProduct(){ //apply
        $this->helper->chechActionList(array('createdProductTransformProduct'), true);
        $cond = $this->getApplyTransformCondition();
        $out = $this->product_transform_mapping->applyProductTransformProduct($cond);

        if($this->helper->isRestOk($out)) {
           echo json_encode( array( 'success'=>'success'));
        } else {
            echo json_encode( array( 'success' => 'fail','error_info'=>!empty($out['error_info'])?$out['error_info']:'提交转换信息后端报错' ) );
        }
    }

    private function getApplyTransformCondition(){
        $cond = array();
        $facility_id = $this->getInput('facility_id');
        if(!empty($facility_id)){
            $cond['facility_id'] = $facility_id;
        }
        $from_product_id = $this->getInput('from_product_id');
        if(!empty($from_product_id)){
            $cond['from_product_id'] = $from_product_id;
        }
        $from_container_id = $this->getInput('from_container_id');
        if(!empty($from_container_id)){
            $cond['from_container_id'] = $from_container_id;
        }
        $transform_type = $this->getInput('transform_type');
        if(!empty($transform_type)){
            $cond['transform_type'] = $transform_type;
        }
        $from_quantity = $this->getInput('from_quantity');
        if(!empty($from_quantity)){
            $cond['from_quantity'] = $from_quantity;
        }
        $from_container_quantity = $this->getInput('from_container_quantity');
        if(!empty($from_container_quantity)){
            $cond['from_container_quantity'] = $from_container_quantity;
        }
        $from_case_num = $this->getInput('from_case_num');
        if(!empty($from_case_num)){
            $cond['from_case_num'] = $from_case_num;
        }
        $note = $this->getInput('note');
        if(!empty($note)){
            $cond['note'] = $note;
        }
        $to_product_info = $this->input->post('to_product_info');
        if(!empty($to_product_info)){
            $cond['to_product_info'] = $to_product_info;
        }
        $loss_quantity = $this->input->post('loss_quantity');
        if(isset($loss_quantity)){
            $cond['loss_quantity'] = $loss_quantity;
        }
        return $cond;
    }

    public function checkedProductTransform(){
        $this->helper->chechActionList(array('checkedProductTransformProduct'), true);
        $cond = array();
        $cond['transform_product_id'] = $this->getInput('transform_product_id');
        $out = $this->product_transform_mapping->checkedProductTransform($cond);
        if($this->helper->isRestOk($out['data'])) {
            echo json_encode( array( 'success'=>'success'));
        } else {
            echo json_encode( array( 'success' => 'fail','error_info'=>!empty($out)?$out:'服务器内部错误' ) );
        }
    }

    public function checkfailProductTransform(){
        $this->helper->chechActionList(array('checkfailProductTransformProduct'), true);
        $cond = array();
        $cond['transform_product_id'] = $this->getInput('transform_product_id');
        $out = $this->product_transform_mapping->checkfailProductTransform($cond);
        if($this->helper->isRestOk($out['data'])) {
            echo json_encode( array( 'success'=>'success'));
        } else {
            echo json_encode( array( 'success' => 'fail','error_info'=>!empty($out)?$out:'服务器内部错误' ) );
        }
    }

    public function executeProductTransform(){
        $this->helper->chechActionList(array('executedProductTransformProduct'), true);
        $cond = array();
        $cond['transform_product_id'] = $this->getInput('transform_product_id');
        $out = $this->product_transform_mapping->executeProductTransform($cond);
        if($this->helper->isRestOk($out)) {
            echo json_encode( array( 'success'=>'success'));
        } else {
            echo json_encode( array( 'success' => 'fail','error_info'=>!empty($out['error_info'])?$out['error_info']:'服务器内部错误' ) );
        }
    }

    public function getRawFinList(){ //autocomplete
        $this->helper->chechActionList(array('createdProductTransformProduct'), true);
        $cond = array();
        $product_type = $this->getInput('product_type');
        $facility_id = $this->getInput('facility_id');
        if (isset($product_type)) {
            $cond['transform_type'] = $product_type;
        }
        if (isset($facility_id)) {
            $cond['facility_id'] = $facility_id;
        }
        $out = $this->product_transform_mapping->getProductTransformMappingList($cond);
        echo json_encode( array( 'success'=>'success', 'product_transform_mapping_list' => $out['data']['product_transform_mapping_list']));

    }
    
    public function getProductList() {
    	$cond['product_type'] = 'goods';
    	$cond['product_sub_type'] = $this->getInput('product_sub_type');
    	$cond['product_status'] = 'OK';
    	$out = $this->productmodel->getProductList($cond);
    	
    	if($this->helper->isRestOk($out)) {
    		echo json_encode( array( 'success'=>'success', 'product_list' => $out['product_list']));
    	} else {
    		echo json_encode( array( 'success' => 'fail','error_info'=>!empty($out)?$out:'服务器内部错误' ) );
    	}
    }

    public function getTransfromProductList(){//根据product_id获取可以转换为的商品列表
        $this->helper->chechActionList(array('createdProductTransformProduct'), true);
        $product_id = $this->getInput('from_product_id');
        $transform_type = $this->getInput('transform_type');
        $cond['from_product_id'] = $product_id;
        $cond['transform_type'] = $transform_type;
        $out = $this->product_transform_mapping->getTransfromProductList($cond);
        if( $this->helper->isRestOk($out) ){
            echo json_encode(array('success'=>'success','product_list'=>$out['toProductList']));
        }else {
            echo json_encode(array('success'=>'failed','error_info'=>'获取可转换为商品列表后端报错'));
        }
    }

    public function getAbProductList(){
        $this->helper->chechActionList(array('showProductTransformProduct'), true);
        $out = $this->product_transform_mapping->getAbProductList();
        //print_r($out);die();
        if( $this->helper->isRestOk($out) ){
            echo json_encode(array('success'=>'success','abProductList'=>$out['product_transform_mapping_list']));
        }else{
            echo json_encode(array('success'=>'failed','error_info'=>'获取AB商品列表后端报错'));
        }
    }
}
?>
