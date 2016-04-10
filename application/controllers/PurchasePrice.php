<?php
/*
 * It is used for the Web Controller, extending CIController.
 * The name of the class must have first Character as Capital.
 *
**/
class PurchasePrice extends CI_Controller {
	function __construct()
	{
		parent::__construct();
	  	$this->load->library('session'); 
	    $this->load->library('Helper'); 
	    $this->load->model('common');
	    $this->load->model("purchase");
	    $this->load->model("facility");
	    $this->helper->chechActionList(array('purchasePrice'),true);
		
	}

	private function getQueryCondition( ){
		$cond = array( );
		$facility_id = $this->getInput('facility_id');
		if(isset($facility_id)) {
			$cond['facility_id'] = $facility_id;
		} 
		
		$asn_date_start = $this->getInput('asn_date_start');
		if(isset($asn_date_start)){
			$cond['asn_date_start'] = $asn_date_start;
		}
		$asn_date_end = $this->getInput('asn_date_end');
		if(isset($asn_date_end)){
			$cond['asn_date_end'] = $asn_date_end;
		}
		
		$product_type = $this->getInput('product_type');
		if(isset($product_type)){
			$cond['product_type'] = $product_type;
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
	
	public function suppliesIndex() {
		$this->helper->chechActionList(array('suppliesCaigouManager'),true);
		$cond['product_type'] = 'supplies';
		$this->showIndex($cond);
	}
	
  public function index() {
  	$this->helper->chechActionList(array('caigouManager'),true);
  	
  	$cond['product_type'] = 'goods';
  	$this->showIndex($cond);
  }
  
  public function query() {
  	$cond = $this->getQueryCondition();
  	$this->showIndex($cond);
  }
  
  private function showIndex($cond){

  	$facility_list = $this->common->getFacilityList();
  	if(empty($facility_list)) {
  		die('无仓库权限');
  	}
  	 
  	if(empty($cond['facility_id'])) {
  		$cond['facility_id'] = $facility_list['data'][0]['facility_id'];
  	}

  if(empty($cond['asn_date_start'])) {
  		$cond['asn_date_start'] = date('Y-m-d');
  	}
  	if(empty($cond['asn_date_end'])) {
  		$cond['asn_date_end'] = date('Y-m-d');
  	}
  	
  	
  	$asnItemList = $this->purchase->getAsnItemListInPriceByFacilityAndAsnDate($cond['facility_id'], $cond['asn_date_start'],$cond['asn_date_end'], $cond['product_type']);
  	
  	$cond['facility_list'] = $facility_list['data'];
  	if(!isset($asnItemList)){
  		$data = $this->helper->merge($cond);
  		$this->load->view('purchase_price', $data);
  		return;
  	}
  	 
  	$cond['asn_item_list'] = $asnItemList;
  	$data = $this->helper->merge($cond);
  	
  	$this->load->view('purchase_price', $data);
  }
  
  public function addPurchasePrice(){
  	$cond = $this->getAddCondition();
  	$out = $this->purchase->addPurchasePrice($cond);
  	if($out == 'success'){
  		echo json_encode( array( "success" => 'success' ) );
  	} else {
  		echo json_encode( array( "success" => 'fail','error_info'=>!empty($out)?$out:'服务器内部错误' ) );
  	}
  }
  
  private function getAddCondition(){
  	$cond = array();
  	$price_items = $this->input->post('price_items');
  	if(isset($price_items)) {
  		$cond['price_items'] = $price_items;
  	}
  	$asn_item_id = $this->input->post('asn_item_id');
  	if(isset($asn_item_id)) {
  		$cond['asn_item_id'] = $asn_item_id;
  	}
  	$product_type = $this->input->post('product_type');
  	if(isset($product_type)) {
  		$cond['product_type'] = $product_type;
  	}
  	return $cond;
  }
  
  public function getPurchasePriceList(){
  	$asn_item_id = $this->input->post('asn_item_id');
  	$out = $this->purchase->getPurchasePriceList($asn_item_id);
  	if($this->helper->isRestOk($out)){
		$out['success'] = 'success';
		echo json_encode($out);
  	}else{
  		echo json_encode(array( 'success' => 'fail','error_info'=>!empty($out['error_info'])?$out['error_info']:'服务器内部错误'));
  	}
  }
  
  public function modifyPurchasePrice() {
  	$cond = $this->getModifyCondition();
  	$out = $this->purchase->modifyPurchasePrice($cond);
  	if(isset($out['message']) && $out['message'] == 'success'){
  		echo json_encode( array( "success" => 'success','is_priced' => $out['is_priced'] ) );
  	} else {
  		echo json_encode( array( "success" => 'fail','error_info'=>!empty($out)?$out:'服务器内部错误' ) );
  	}
  }
  
  private function getModifyCondition(){
  	$cond = array();
  	$add_price_items = $this->input->post('add_price_items');
  	if(isset($add_price_items)) {
  		$cond['add_price_items'] = $add_price_items;
  	}
  	$asn_item_id = $this->input->post('asn_item_id');
  	if(isset($asn_item_id)) {
  		$cond['asn_item_id'] = $asn_item_id;
  	}
  	$remove_price_items = $this->input->post('remove_price_items');
  	if(isset($remove_price_items)) {
  		$cond['remove_price_items'] = $remove_price_items;
  	}
  	$product_type = $this->input->post('product_type');
  	if(isset($product_type)) {
  		$cond['product_type'] = $product_type;
  	}
  	return $cond;
  }
  
  public function payPurchasePrice(){
  	$pp_id = $this->input->post('pp_id');
  	if(isset($pp_id)) {
  		$cond['pp_id'] = $pp_id;
  	}
  	$out = $this->purchase->payPurchasePrice($pp_id);
  	if($out == 'success'){
  		echo json_encode( array( "success" => 'success' ) );
  	} else {
  		echo json_encode( array( "success" => 'fail','error_info'=>!empty($out)?$out:'服务器内部错误' ) );
  	}
  }
  
  public function getProductSupplierList(){
  	$product_type = $this->getInput('product_type');
  	$params['product_type'] = $product_type;
  	$params['enabled'] = 1;
  	$out = $this->purchase->getProductSupplierList($params);
  	if($this->helper->isRestOk($out)){
  		echo json_encode(array( 'success' => 'success','product_supplier_list' => $out['product_supplier_list']));
  	}else{
  		echo json_encode(array( 'success' => 'fail','error_info'=>!empty($out['error_info'])?$out['error_info']:'服务器内部错误'));
  	}
  }
  
  public function getAreaPurchaseManagerList(){
  	$params['product_type'] = $this->getInput('product_type');
  	$out = $this->facility->getAreaPurchaseManagerList($params);
  	if($this->helper->isRestOk($out)){
  		echo json_encode(array( 'success' => 'success','manager_list' => $out['manager_list']));
  	}else{
  		echo json_encode(array( 'success' => 'fail','error_info'=>!empty($out['error_info'])?$out['error_info']:'服务器内部错误'));
  	}
  }
  
  public function getPurchaseInventoryList() {
  	$asn_item_id = $this->getInput('asn_item_id');
  	$out = $this->purchase->getPurchaseInventoryList($asn_item_id);
  	if($this->helper->isRestOk($out)){
  		echo json_encode(array( 'success' => 'success','in_stock_variance_quantity' => $out['in_stock_variance_quantity'], 'in_transit_variance_quantity' => $out['in_transit_variance_quantity'], 'inventory_list' => $out['inventory_list'],'is_virtual_facility' => $out['is_virtual_facility'], 'virtual_inventory_list'=>$out['virtual_inventory_list'], 'history_inventory_unit_price'=>$out['history_inventory_unit_price']));
  	}else{
  		echo json_encode(array( 'success' => 'fail','error_info'=>!empty($out['error_info'])?$out['error_info']:'服务器内部错误'));
  	}
  }
}
?>