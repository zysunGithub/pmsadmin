<?php

class TransferException extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->library('Excel'); 
		$this->load->model('common');
		$this->load->model('loadingbill');
		$this->load->model('transferinventory');
		$this->load->model('inventorytransaction');
		$this->helper->chechActionList(array('transferException'),true);
	}
	
	public function getProductTypeList(){
		$product_type_list =  array();
		if($this->helper->chechActionList(array('transferException'))) {
			$item['product_type'] = 'goods';
			$item['product_type_name'] = '商品';
			$product_type_list[] = $item;
		}
			
		return $product_type_list;
	}
	
	
	public function unPurchaseIn(){
		$cond = array();
		$cond['asn_type'] = 'PO';
		$cond['status'] = 'OK';
		$cond['inventory_status'] = 'INIT';
		$out = $this->common->getFacilityList();
		if (isset($out['error_info']) || empty($out['data'])) {
			die("无法获取仓库" . $out['error_info']);
		}
		$facility_list = array();
		foreach ($out['data'] as $facility) {
			$facility_list[] = $facility;
		}
		if (empty($facility_list)) {
			die("没有仓库的权限");
		}
		
		$product_type_list = $this->getProductTypeList();
		if(empty($product_type_list)) {
			die('无权限2');
		}
		$facility_id = $this->getInput('facility_id');
		if (!empty($facility_id)) {
			$cond['facility_id'] = $facility_id;
		} else {
			$cond['facility_id'] = $facility_list[0]['facility_id'];
		}
		
		$product_type = $this->getInput('product_type');
		if (!empty($product_type)) {
			$cond['product_type'] = $product_type;
		} else {
			$cond['product_type'] = $product_type_list[0]['product_type'];
		}
		
		$out = $this->loadingbill->getLoadingBillItem($cond);
		if (isset($out['error_info'])) {
			die("无法获取数据" . $out['error_info']);
		}
		$cond['product_type_list'] = $product_type_list;
		$cond['facility_list'] = $facility_list;
		$cond['loading_bill_item_list'] = $out['data']['loading_bill_item'];
		$data = $this->helper->merge($cond);
		$this->load->view("transfer_exception_un_purchase_in",$data);
	}
	
	public function purchaseDiff(){
		$cond = array();
		$cond['asn_type'] = 'PO';
		$cond['status'] = 'OK';
		$cond['inventory_status'] = 'FINISH';
		$cond['diff'] = 1;
		$out = $this->common->getFacilityList();
		if (isset($out['error_info']) || empty($out['data'])) {
			die("无法获取仓库" . $out['error_info']);
		}
		$facility_list = array();
		foreach ($out['data'] as $facility) {
			if (in_array($facility['facility_type'], array(3,4,5))) {
				$facility_list[] = $facility;
			}
		}
		if (empty($facility_list)) {
			die("没有虚拟仓的权限");
		}
		if ($this->getInput('facility_id')) {
			$cond['facility_id'] = $this->getInput('facility_id');
		} else {
			$cond['facility_id'] = $facility_list[0]['facility_id'];
		}
		$out = $this->loadingbill->getLoadingBillItem($cond);
		if (isset($out['error_info'])) {
			die("无法获取数据" . $out['error_info']);
		}
		$cond['facility_list'] = $facility_list;
		$cond['loading_bill_item_list'] = $out['data']['loading_bill_item'];
		if ($this->getInput('act') == "download") {
	  		$this->exportPurchaseDiffExcel($out['data']['loading_bill_item']);
	  		return ;
	  	}
		$data = $this->helper->merge($cond);
		$this->load->view("transfer_exception_purchase_diff",$data);
	}
	
	public function unTransferOut(){
		$cond = array();
		$out = $this->common->getFacilityList();
		if (isset($out['error_info']) || empty($out['data'])) {
			die("无法获取仓库" . $out['error_info']);
		}
		$facility_list = array();
		foreach ($out['data'] as $facility) {
			if (in_array($facility['facility_type'], array(3,4,5))) {
				$facility_list[] = $facility;
			}
		}
		if (empty($facility_list)) {
			die("没有虚拟仓的权限");
		}
		if ($this->getInput('facility_id')) {
			$cond['facility_id'] = $this->getInput('facility_id');
		} else {
			$cond['facility_id'] = $facility_list[0]['facility_id'];
		}
	   	$out = $this->inventorytransaction->getCanSaleInventoryItemList($cond);
	   	if (isset($out['error_info'])) {
	   		die("无法获取数据" . $out['error_info']);
	   	}
		$cond['facility_list'] = $facility_list;
		$cond['inventory_item_list'] = $out['data']['inventory_item_list'];
		$data = $this->helper->merge($cond);
		$this->load->view("transfer_exception_un_transfer_out",$data);
	}
	
	public function facilityDiff(){
		$cond = array();
		$out = $this->common->getFacilityList();
		if (isset($out['error_info']) || empty($out['data'])) {
			die("无法获取仓库" . $out['error_info']);
		}
		$facility_list = array();
		foreach ($out['data'] as $facility) {
		//	if (in_array($facility['facility_type'], array(3,4,5))) {
				$facility_list[] = $facility;
		//	}
		}
		if (empty($facility_list)) {
			die("没有仓库的权限");
		}
		if ($this->getInput('facility_id')) {
			$cond['facility_id'] = $this->getInput('facility_id');
		} else {
			$cond['facility_id'] = $facility_list[0]['facility_id'];
		}
	   	$out = $this->transferinventory->getFacilityDiff($cond['facility_id']);
	   	if (isset($out['error_info'])) {
	   		die("无法获取数据" . $out['error_info']);
	   	}
		$cond['facility_list'] = $facility_list;
		$cond['loading_bill_item_list'] = $out['data'];
		if ($this->getInput('act') == "download") {
	  		$this->exportFacilityDiffExcel($out['data']);
	  		return ;
	  	}
		$data = $this->helper->merge($cond);
		$this->load->view("transfer_exception_facility_diff",$data);
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
	
	public function fixDiff() {
		$cond = array();
		$type = $this->getInput('type');
		$qoh = $this->getInput('qoh');
		$note = $this->getInput('note');
		$bol_item_id = $this->getInput('bol_item_id');
		if(isset($type) && isset($qoh) && isset($bol_item_id)) {
			$cond['type'] = $type;
			$cond['bol_item_id'] = $bol_item_id;
			$cond['qoh'] = $qoh;
			$cond['note'] = $note;
		} else{
			echo json_encode( array( 'success' => 'fail','error_info' => '获取参数失败') );
			return ;
		}
		$out = $this->transferinventory->fixDiff($cond);
		if($this->helper->isRestOk($out)) {
			echo json_encode( array( 'success' => 'success') );
		} else {
			echo json_encode( array( 'success' => 'fail','error_info' => !empty($out['error_info'])?$out['error_info']:'服务器内部错误') );
		}
	}
	
	public function inventoryVariance() {
		$cond = array();
		$qoh = $this->getInput('qoh');
		$note = $this->getInput('note');
		$inventory_item_id = $this->getInput('inventory_item_id');
		if(isset($inventory_item_id) && isset($qoh)) {
			$cond['inventory_item_id'] = $inventory_item_id;
			$cond['qoh'] = $qoh;
			$cond['note'] = $note;
		} else{
			echo json_encode( array( 'success' => 'fail','error_info' => '获取参数失败') );
			return ;
		}
		$out = $this->inventorytransaction->createVarianceOutTransaction($cond);
		if(! isset($out['error_info'])) {
			echo json_encode( array( 'success' => 'success') );
		} else {
			echo json_encode( array( 'success' => 'fail','error_info' => !empty($out['error_info'])?$out['error_info']:'服务器内部错误') );
		}
	}
	
	private function exportPurchaseDiffExcel($list){
  	$head = array(
  		'仓库',
  		'ASN日期',
  		'装车时间',
  		'装车批次',
        '六联单',
  		'商品',
  		'装车箱数',
  		'入库箱数',
  		'装车箱规',
  		'单位');
  	$body = array();
	foreach ($list as $key => $order) {
	$body[$key][] = $order['facility_name'];
	$body[$key][] = $order['asn_date'];
	$body[$key][] = $order['created_time'];
	$body[$key][] = $order['bol_sn'];
    $body[$key][] = $order['invoice_no'];
	$body[$key][] = $order['product_name'];
	$body[$key][] = $order['purchase_case_num'];
	$body[$key][] = $order['finish_case_num'];
	$body[$key][] = $order['quantity'];
	$body[$key][] = $order['unit_code'];
  	
  	}
  	$this->download($head,$body,'调拨与采购差异');
  }
  
  private function exportFacilityDiffExcel($list){
  	
  	$head = array(
  		'出库仓库',
		'入库仓库',
		'调拨批次',
		'状态',
		'商品',
		'箱规',
		'供应商',
		'装车批次',
        '六联单',
		'车牌号',
		'司机电话',
		'司机名字',
        '车队',
        '车型',
		'创建时间',
		'装车时间',
		'入库时间',
		'计划调拨数量',
		'装车数量',
		'入库数量',
		'盘亏数量',
		'追回数量',
		'差异',
		'备注',);
  	$body = array();
	foreach ($list as $key => $order) {
	  	$body[$key][] = $order['from_facility_name'];
		$body[$key][] = $order['to_facility_name'];
		$body[$key][] = $order['ti_sn'];
		$body[$key][] = $order['inventory_status'] == "FINISH" ? "已入库" : "未入库";
		$body[$key][] = $order['product_name'];
		$body[$key][] = $order['container_quantity'] .  $order['unit_code'] . "/箱";
		$body[$key][] = $order['product_supplier_name'];
		$body[$key][] = $order['bol_sn'];
        $body[$key][] = $order['invoice_no'];
		$body[$key][] = $order['car_num'];
		$body[$key][] = $order['driver_mobile'];
		$body[$key][] = $order['driver_name'];
        $body[$key][] = $order['car_provider'];
        $body[$key][] = $order['car_model'];
		$body[$key][] = $order['ti_created_time'];
		$body[$key][] = $order['bol_created_time'];
		$body[$key][] = $order['finish_time'];
		$body[$key][] = $order['plan_case_num'];
		$body[$key][] = $order['from_quantity'];
		$body[$key][] = $order['to_quantity'];
		$body[$key][] = $order['variance_quantity'];
		$body[$key][] = $order['return_quantity'];
		$body[$key][] = $order['transit_quantity'];
		$body[$key][] = $order['note'];
  	}
  	
  	
  	$this->download($head,$body,'调拨与仓库差异');
  }
  
   // 导出 excel 
  private function download($head,$body,$fileName){
     $excel =  $this->excel;
     $excel->addHeader($head);
     $excel->addBody( $body);
     $excel->downLoad($fileName);
  }
}

?>
