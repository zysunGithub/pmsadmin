<?php
/*
 * It is used for the Web Controller, extending CIController.
 * The name of the class must have first Character as Capital.
 *
**/
class PurchaseCommit extends CI_Controller {
	function __construct()
	{
		parent::__construct();
	  	$this->load->library('session'); 
	    $this->load->library('Helper'); 
	    $this->load->model('common');
	    $this->load->model("purchase");
	    $this->load->model("productmodel");
	    $this->load->model("facility");
	    $this->helper->chechActionList(array('purchaseCommit'),true);
		
	}

	private function getQueryCondition( ){
		$cond = array( );
		
		$facility_id = $this->getInput('facility_id');
		if(isset($facility_id)) {
			$cond['facility_id'] = $facility_id;
		} 
		$po_id = $this->getInput('po_id');
		if(isset($po_id)){
			$cond['po_id'] = $po_id;
		}
		
		$asn_item_id = $this->getInput('asn_item_id');
		if(isset($asn_item_id)) {
			$cond['asn_item_id'] = $asn_item_id;
		}
		$purchase_place_id = $this->getInput('purchase_place_id');
		if(isset($purchase_place_id)) {
			$cond['purchase_place_id'] = $purchase_place_id;
		}
		return $cond;
	}
	
	// 从 get 或 post 获取数据 优先从 post 没有返回 null
	private function getInput($name){
		$out = $this->input->post($name);
		if(is_array($out)){
			return $out;
		}
		$out = trim($out);
		if(isset($out) && $out!=""){
			return $out;
		}else{
			$out = trim($this->input->get($name));
			if(isset($out) && $out !="") return $out;
		}
		return null;
	}	
	
  public function index(){
  	$this->helper->chechActionList(array('caigouManager'),true);
  	$this->showIndex('goods');
  }
  
  public function suppliesIndex(){
  	$this->helper->chechActionList(array('suppliesCaigouManager'),true);
  	$this->showIndex('supplies');
  }
  
  public function showIndex($product_type){
  	$cond = $this->initData($product_type);
  	if(!empty($cond['error']) && $cond['error'] = 'error'){
  		echo 'ERROR!'.$cond['error_info'];
  		return;
  	}
  	
  	//如果现实采购计划一，可以回到前一天的采购计划二
  	$po_type = $this->getInput('po_type');
  	if(isset($po_type) && $po_type == 'SECOND') {
  		$cond['po_date'] = date('Y-m-d', strtotime ("-1 day", strtotime($cond['po_date'])));
  		$cond['po_type'] = $po_type;
  	}
  	
    $cond['form_url'] = $product_type; // 用于视图也判断form表单提交的url views/purchase_commit.php p58
  	$cond['product_type'] = $product_type;
  	$data = $this->helper->merge($cond);
  	$this->load->view('purchase_commit', $data);
  }

  public function getPurchaseOrderItemList(){
  	$cond = array();
  	$area_id = $this->getInput('area_id');
  	if( !empty($area_id) ){
  		$cond['area_id'] = $area_id;
  	}
  
  	$po_type = $this->getInput('po_type');
  	if( !empty($po_type) ){
  		$cond['po_type'] = $po_type;
  	}
  
  	$po_date = $this->getInput('po_date');
  	if( !empty($po_date) ){
  		$cond['po_date'] = $po_date;
  	}
  
  	$product_type = $this->getInput('product_type');
  	if( !empty($product_type) ){
  		$cond['product_type'] = $product_type;
  	}
  
  	$facility_id_list = $this->getInput('facility_id_list');
  	if( !empty($facility_id_list) ){
  		$cond['facility_id_list'] = $facility_id_list;
  	} else {
  		$cond['facility_id_list'] = null;
  	}
  	$purchase_order = $this->purchase->getAreaPurchaseOrder($cond['area_id'], $cond['po_date'], $cond['po_type'], $product_type);
  	 
  	if( !empty($purchase_order) ){
  		$purchase_order_item_info = $this->purchase->getPurchaseOrderItemDetailList( array("po_id" => $purchase_order['po_id'], "facility_id_list" => $cond['facility_id_list'] ) );
  		$asn_item_list = $this->purchase->getAsnItemListByPO($purchase_order['po_id']);
  		$purchase_place_facility_list = $this->handlePurchasePlaceFacilityList($purchase_order_item_info['purchase_place_facility_list']);
  		echo json_encode(array(
  				'success'=>'success',
  				'po_id'=>$purchase_order['po_id'],
  				'purchase_order_item_list'=>$purchase_order_item_info['purchase_order_item_detail_list'],
  				'asn_item_list'=>$asn_item_list,
  				'purchase_place_facility_list'=>$purchase_place_facility_list
  		)
  		);
  	}else{
  		echo json_encode(array('success'=>'failed','error_info'=>'后端没有获取到po'));
  	}
  }
  
  public function initData($product_type){
  	$initData = array();
  	$area_list = $this->purchase->getUserAreaAndFacilityList();
  	if(empty($area_list) || ( !empty($area_list['data']) && count($area_list['data']) )< 1) {
  		$initData['error'] = 'error';
  		$initData['error_info'] = '账号无大区权限';
  		return $initData;
  	}
  	$initData['readonly'] = false;
//    	if(count($area_list['data']) > 1) {
// 		$initData['readonly'] = true;
//    	} else {
//    		$initData['readonly'] = false;
//    	}
	$initData['area_list'] = $area_list['data'];
  	
  	$facility_list = $this->common->getFacilityList();
  	if(empty($facility_list['data'][0]['facility_id'])){
  		$initData['error'] = 'error';
  		$initData['error_info'] = '账号无仓库权限';
  		return $initData;
  	}

  	$area_id = $this->getInput('area_id');
  	if(isset($area_id)) {
  		$initData['area_id'] = $area_id;
  	} else {
  		$initData['area_id'] = $area_list['data'][0]['area_id'];
  	}
  	
  	if($product_type == 'goods') {
  		$out = $this->common->getPurchasePlaceByAreaId($initData['area_id']);
  		$purchase_place_facility_list = $out['data'];
  	} elseif ($product_type == 'supplies'){
  		//耗材直接到实体仓，不用采购地
  		$facility_types[] = '1';
  		$facility_types[] = '2';
  		$facility_params['area_id'] = $initData['area_id'];
  		$facility_params['facility_types'] = implode(",",$facility_types);
  		$out = $this->facility->getFacilityList($facility_params);
  		$purchase_place_facility_list = array();
  		if($this->helper->isRestOk($out)) {
  		 	foreach ($out['facility_list'] as $facility) {
  		 		$purchase_place_facility = array();
  		 		$purchase_place_facility['purchase_place_name'] = $facility['facility_name'];
  		 		$purchase_place_facility['facility_id'] = $facility['facility_id'];
  		 		$purchase_place_facility['facility_name'] = $facility['facility_name'];
  		 		$purchase_place_facility['facility_type'] = $facility['facility_type'];
  		 		$purchase_place_facility_list[] = $purchase_place_facility;
  		 	}
  		}
  		
  	}
  	
  	if (empty($purchase_place_facility_list)) {
  		$initData['error'] = 'error';
  		$initData['error_info'] = '无采购地';
  		return $initData;
  	}
  	$initData['purchase_place_facility_list'] = $purchase_place_facility_list;
  	
  	$purchase_plan1_time = $this->common->getFacilityAttribute($facility_list['data'][0]['facility_id'], 'purchase_plan1_time');
  	$purchase_plan2_time = $this->common->getFacilityAttribute($facility_list['data'][0]['facility_id'], 'purchase_plan2_time');
  	$fulfill_end_time = $this->common->getFacilityAttribute($facility_list['data'][0]['facility_id'], 'fulfill_end_time');
  	if(!empty($fulfill_end_time)){
  		$initData['fulfill_end_time'] = $fulfill_end_time;
  	}
  	
  	if(date('H:i:s') >= $purchase_plan1_time) {
  		$initData['po_date'] = date('Y-m-d',strtotime('+1 day'));
  		$initData['po_type'] = 'FIRST';
  	} elseif (date("H:i:s") < $purchase_plan2_time) {
  		$initData['po_date'] = date("Y-m-d");
  		$initData['po_type'] = 'FIRST';
  	} else {
  		$initData['po_date'] = date('Y-m-d');
  		$initData['po_type'] = 'SECOND';
  	}
  	
  	return $initData;
  }
  
  public function addAsnItems(){
  	$cond['po_id'] = $this->getInput('po_id');
  	$cond['product_id'] = $this->getInput('product_id');
  	$cond['asn_items'] = $this->getInput('asn_items');
  	
  	$out = $this->purchase->addAsnItems($cond);
  	if($this->helper->isRestOk($out)){
  		echo json_encode( array( "success" => 'success', "asn_item_list" => $out['asn_item_list'], "productInventory"=>$out['productInventory'] ) );
  	} else {
  		echo json_encode( array( "success" => 'fail','error_info'=>!empty($out['error_info'])?$out['error_info']:'服务器内部错误' ) );
  	}
  }
  
  public function removeAsnItem(){
  	$this->helper->chechActionList(array('purchaseCommit'),true);
  	$cond = $this->getQueryCondition();
  	$out = $this->purchase->removeAsnItem($cond);
  	if($out == 'success'){
  		echo json_encode( array( "success" => 'success' ) );
  	} else {
  		echo json_encode( array( "success" => 'fail','error_info'=>!empty($out)?$out:'服务器内部错误' ) );
  	}
  }
  private function getAddStockUpProductCond(){
  	$cond = array();
  	$product_id = $this->getInput('product_id');
  	if(isset($product_id)){
  		$cond['product_id'] = $product_id;
  	} else {
  		$cond['error'] = 'error';
  		$cond['error_info'] = '商品错误';
  	}
  	
  	$product_name = $this->getInput('product_name');
  	if(isset($product_name)) {
  		$cond['product_name'] = $product_name;
  	} else{
  		$cond['error'] = 'error';
  		$cond['error_info'] = '商品错误';
  	}
  	
  	$po_id = $this->getInput('po_id');
  	if(isset($po_id)) {
  		$cond['po_id'] = $po_id;
  	} else {
  		$cond['error'] = 'error';
  		$cond['error_info'] = '获取PO错误';
  	}
  	
  	return $cond;
  }
  
  public function addStockUpProduct(){
  	$cond = $this->getAddStockUpProductCond();
  	$out = $this->purchase->addStockUpProduct($cond);
  	if($out == 'success'){
  		echo json_encode( array( "success" => 'success' ) );
  	} else {
  		echo json_encode( array( "success" => 'fail','error_info'=>!empty($out)?$out:'服务器内部错误' ) );
  	}
  }
  
  public function getStockUpProductList() {
  	$po_id = $this->getInput("po_id");
  	$product_type = $this->getInput('product_type');
  	$product_list = $this->productmodel->getStockUpProduct($po_id, $product_type);
  	if($product_list != null) {
  		echo json_encode( array( "success" => 'success', "product_list" => $product_list) );
  	} else {
  		echo json_encode( array( "success" => 'fail','error_info'=>!empty($out)?$out:'服务器内部错误' ) );
  	}
  }
  
  public function getProductSupplierList(){
  	$product_type = $this->getInput("product_type");
  	$params = array();
  	$params['product_type'] = $product_type;
  	$params['enabled'] = 1;
  	$out = $this->purchase->getProductSupplierList($params);
  	if($this->helper->isRestOk($out)){
  		echo json_encode(array( 'success' => 'success','product_supplier_list' => $out['product_supplier_list']));
  	}else{
  		echo json_encode(array( 'success' => 'fail','error_info'=>!empty($out['error_info'])?$out['error_info']:'服务器内部错误'));
  	}
  }
  
  public function getSupplierReturnList(){
  	$facility_id = $this->getInput('facility_id');
  	$product_id = $this->getInput('product_id');
  	$return_type = $this->getInput('return_type');
  	$status = $this->getInput('status');
  	$params = array();
  	if(!empty($facility_id)){
  		$params['facility_id'] = $facility_id;
  	}
  	if(!empty($product_id)){
  		$params['product_id'] = $product_id;
  	}
  	if(!empty($return_type)){
  		$params['return_type'] = $return_type;
  	}
  	if(!empty($status)){
  		$params['status'] = $status;
  	}
  	$out = $this->purchase->getSupplierReturnList($params);
  	//print_r($out);die();
  	if($this->helper->isRestOk($out)){
  		if(!empty($out['supplier_return'])){
  			echo json_encode(array('success'=>'success','supplies_return_list'=>$out['supplier_return']));
  		}else{
  			echo json_encode(array('success'=>'failed'));
  		}
  	}else{
  		echo json_encode(array('success'=>'failed'));
  	}
  }

  public function getContainerQuantity(){
  	$product_id = $this->getInput('product_id');
  	if( empty($product_id) ){
  		echo json_encode(array('success'=>'failed','error_info'=>'缺少product_id'));
  		die();
  	}else{
  		$cond['product_id'] = $product_id;
  	}
  	$out = $this->purchase->getContainerQuantity($cond);
  	if( $this->helper->isRestOk($out) ){
  		echo json_encode(array('success'=>'success','container_info'=>$out['purchase_order_item_list']));
  	}else{
  		echo json_encode(array('success'=>'failed','error_info'=>'后端没有获取到箱规'));
  	}
  }
  
  private static function handlePurchasePlaceFacilityList($purchase_place_facility_list) {
  	$facility_info = array();
  	foreach ($purchase_place_facility_list as $purchase_place_k => $purchase_place_v) {
  		$purchase_place_info[$purchase_place_v['purchase_place_id']] = array(
  				"purchase_place_id" => $purchase_place_v['purchase_place_id'],
  				"purchase_place_name" => $purchase_place_v['purchase_place_name']
  		);
  		$facility_info[$purchase_place_v['purchase_place_id']][] = $purchase_place_v;
  	}
  	foreach ($purchase_place_info as $key => $value) {
  		if (isset($facility_info[$key])) {
  			$purchase_place_info[$key]["facility_list"] = $facility_info[$key];
  		}
  	}
  	return array_values($purchase_place_info);
  }

	/**
	 * 获取指定商品的所有供货商
	 */
	public function suppliers()
	{
		$productId = $this->getInput('product_id');
		$suppliers = $this->purchase->getSuppliers($productId);
		if ($this->helper->isRestOk($suppliers)) {
			echo json_encode(array('success' => 'success', 'product_supplier_list' => $suppliers['product_supplier_list']));
		} else {
			echo json_encode(array('success' => 'failed', 'error_info' => '服务器内部错误'));
		}
	}
}
?>
