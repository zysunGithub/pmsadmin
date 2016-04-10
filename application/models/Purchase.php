<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

// 处理订单相关的逻辑 为 订单控制器服务 
class Purchase extends CI_Model {

    private $CI  ;
    private $helper;
    function __construct(){
    	 parent::__construct();
    	 if(!isset($this->CI)){
            $this->CI = & get_instance();
        }
         if(!isset($this->helper)){
           $this->CI->load->library('Helper'); 
           $this->helper = $this->CI->helper;
        }
     }
     
     public function  getDistributedList($cond){
     	$out = $this->helper->get("/produce/distributedList",$cond);
     	if($this->helper->isRestOk($out, 'distributedList')) {
     		return $out;
     	} else {
     		return array();
     	}
     }
     
     public function getAreaPurchaseOrder($area_id, $po_date, $po_type, $product_type) {
     	$params['product_type'] = $product_type;
     	$out = $this->helper->get("/purchase/area/purchaseOrder/{$area_id}/{$po_date}/{$po_type}", $params);
     	if($this->helper->isRestOk($out,'purchase_order')){
     		return $out['purchase_order'];
     	}
     	return array();
     }
     
     public function getPurchaseOrderItemList($po_id){
     	$out = $this->helper->get("/purchase/purchaseOrderItemList/{$po_id}");
     	if($this->helper->isRestOk($out,'purchase_order_item_list')){
     		return $out['purchase_order_item_list'];
     	}
     	return array();
     }
     public function getAsnItemList($asn_id) {
     	$out = $this->helper->get("/purchase/asnItemList/{$asn_id}");
     	if($this->helper->isRestOk($out,'asn_item_list')){
     		return $out['asn_item_list'];
     	}
     	return $out['error_info'];
     }
     
     public function getAsnItemListByPO($po_id) {
     	$out = $this->helper->get("/purchase/asnItemListByPO/{$po_id}");
     	if($this->helper->isRestOk($out,'asn_item_list')){
     		return $out['asn_item_list'];
     	}
     	return $out['error_info'];
     }
     
     public function getAsnItemListInPriceByFacilityAndAsnDate($facility_id, $asn_date_start, $asn_date_end, $product_type) {
     	$params['facility_id']=$facility_id;
     	$params['product_type'] = $product_type;
     	$params['asn_date_start']= $asn_date_start;
     	$params['asn_date_end'] = $asn_date_end;
     	$out = $this->helper->get("/purchase/price/asnItemList", $params);
     	if($this->helper->isRestOk($out,'asn_item_list')){
     		return $out['asn_item_list'];
     	}
     	return $out['error_info'];
     }
     
     public function getAsn($facility_id, $asn_date, $product_type, $facility_type, $area_type) {
          $params['product_type'] = $product_type;
          $params['facility_type'] = $facility_type;
     	$params['area_type'] = $area_type;
     	$out = $this->helper->get("/purchase/asn/{$facility_id}/{$asn_date}", $params);
     	if($this->helper->isRestOk($out,'asn')){
     		return $out['asn'];
     	}
     	return $out['error_info'];
     }
     
     public function addLoadingBill($params) {
     	$out = $this->helper->post("/purchase/addLoadingBill", $params);
     	if($this->helper->isRestOk($out,'message')){
     		return 'success';
     	}
     	return $out['error_info'];
     }
     public function getLoadingBillList($params) {
     	$out = $this->helper->get("/purchase/loadingBillList", $params);
     	if($this->helper->isRestOk($out,'loading_bill_list')){
     		return $out['loading_bill_list'];
     	}
     	return $out['error_info'];
     }
     
     public function getLoadingBillItemList($bol_id){
		$params['bol_id'] = $bol_id;
     	$out = $this->helper->get("/admin/loading_bill_item", $params );
     	if($this->helper->isRestOk($out,'loading_bill_item')){
     		return $out['loading_bill_item'];
     	}
     	return "error";
     }
     
     public function getLoadingBillItemListByBol($bol_id){
     	$out = $this->helper->get("/admin/loadingBillItemByBol/".$bol_id );
     	if($this->helper->isRestOk($out,'loading_bill_item')){
     		return $out['loading_bill_item'];
     	}
     	return "error";
     }
     
     public function addAsnItems($params){
     	return $this->helper->post("/purchase/asn/addItems",$params);
     }
     
     public function removeAsnItem($params){
     	$out = $this->helper->post("/purchase/asn/removeItem",$params);
     	if($this->helper->isRestOk($out,'message')){
     		return 'success';
     	}
     	return $out['error_info'];
     }
     
     public function addStockUpProduct($params) {
     	$out = $this->helper->post("/purchase/purchaseOrder/addStockUpProduct",$params);
     	if($this->helper->isRestOk($out,'message')) {
     		return 'success';
     	}
     	return $out['error_info'];
     }
     
     public function getArnormalAsnItemList($cond,$offset,$limit) {
     	if(empty($cond)){
     		$cond = array();
     	}
     	$cond['offset'] = $offset;
     	$cond['size'] = $limit;
     	$out =  $this->helper->get("/purchase/bolItemList/abnormal",$cond);
     	$result = array();
     	if($this->helper->isRestOk($out)){
     		$result['data'] = $out['data'];
     	}else{
     		$result['error_info'] = $out['error_info'];
     	}
     	return $result;
     }
     
     public function getPurchaseForecast($params) {
     	return $this->helper->get("/purchase/purchaseForecast/getInitItems/{$params['facility_id']}", $params);
     }
     
     public function addPurchaseForecast($params){
     	$out = $this->helper->post("/purchase/purchaseForecast/add",$params);
     	if($this->helper->isRestOk($out,'message')){
     		return 'success';
     	}
     	return $out['error_info'];
     }
     
     public function getPurchaseForecastList($cond,$offset,$limit) {
     	if(empty($cond)){
     		$cond = array();
     	}
     	$cond['offset'] = $offset;
     	$cond['size'] = $limit;
     	$out =  $this->helper->get("/purchase/purchaseForecast/list",$cond);
     	$result = array();
     	if($this->helper->isRestOk($out)){
     		$result['data'] = $out['data'];
     	}else{
     		$result['error_info'] = $out['error_info'];
     	}
     	return $result;
     }
     
     public function getPurchaseForecastItemList($cond) {
     	$out =  $this->helper->get("/purchase/purchaseForecast/item/list",$cond);
     	return $out;
     }
     
     public function getAreaPurchaseForecast($area_id) {
     	$out =  $this->helper->get("/purchase/purchaseForecast/area/list/{$area_id}");
     	return $out;
     }
     
     public function addPurchasePrice($params) {
     	$out = $this->helper->post("/purchase/asn/price/add",$params);
     	if($this->helper->isRestOk($out,'message')){
     		return 'success';
     	}
     	return $out['error_info'];
     }
     
     public function getPurchasePriceList($asn_item_id) {
     	$out = $this->helper->get("/purchase/asn/price/list/".$asn_item_id);
     	return $out;
     }
     
     public function modifyPurchasePrice($params) {
     	$out = $this->helper->post("/purchase/asn/price/modify",$params);
     	if($this->helper->isRestOk($out,'message')){
     		return $out;
     	}
     	return $out['error_info'];
     }
     
     public function payPurchasePrice($pp_id) {
     	$out = $this->helper->post("/purchase/asn/price/pay/".$pp_id);
     	if($this->helper->isRestOk($out,'message')){
     		return 'success';
     	}
     	return $out['error_info'];
     }
     
     public function getPurchasePlace($cond,$offset,$limit) {
     	if(empty($cond)){
     		$cond = array();
     	}
     	$cond['offset'] = $offset;
     	$cond['size'] = $limit;
     	$out =  $this->helper->get("/purchase/purchasePlace/list",$cond);
     	$result = array();
     	if($this->helper->isRestOk($out)){
     		$result['data'] = $out['data'];
     	}else{
     		$result['error_info'] = $out['error_info'];
     	}
     	return $result;
     }
     
     public function addPurchasePlace($cond){
     	$out = $this->helper->post("/purchase/purchasePlace/add",$cond);
     	if($this->helper->isRestOk($out,'message')){
     		return 'success';
     	}
     	return $out['error_info'];
     }
     
     public function removePurchasePlace($purchase_place_id){
     	$out = $this->helper->post("/purchase/purchasePlace/remove/".$purchase_place_id);
     	if($this->helper->isRestOk($out,'message')){
     		return 'success';
     	}
     	return $out['error_info'];
     }
     
     public function pp2po($param) {
     	$out = $this->helper->post("/purchase/purchaseOrder/pp2po", $param);
     	if($this->helper->isRestOk($out,'message')){
     		return 'success';
     	}
     	return $out['error_info'];
     }
     
     public function getProductSupplierList($params){
     	return $this->helper->get("/purchase/productsupplier/list",$params);
     } 
     
     public function getPurchaseInventoryList($asn_item_id){
     	return $this->helper->get("/purchase/inventory/".$asn_item_id);
     }
     
     public function removeLoadingBillItem($bol_item_id) {
     	$params['bol_item_id'] = $bol_item_id;
     	return $this->helper->post("/purchase/loadingBillItem/remove", $params);
     }
     
     public function getSupplierList($params) {
     	return $this->helper->post("/purchase/supplier/list", $params);
     }
     public function setArrivalTime($params){ 
        return $this->helper->post('/purchase/setLoadingBillArrivalTime',$params);
     }

     public function getSupplierReturnList($params){
     	return $this->helper->get('/admin/getSupplierReturnList',$params);
     }
     
     // 20160119 // 获取大区和大区下面的仓库
     public function getUserAreaAndFacilityList(){
     	return $this->helper->get('/admin/area/facility/List');
     }
     
     public function getPurchaseOrderItemDetailList($params){
     	$out = $this->helper->get("/purchase/purchaseOrderItemDetailList", $params);
     	if($this->helper->isRestOk($out,'purchase_order_item_detail_list')){
     		return $out;
     	}
     	return array();
     }
     
     public function getContainerQuantity($params){
     	return $this->helper->get('/purchase/purchaseOrder/getProductContainerInfo',$params);
     }

	/**
	 * 获取指定商品的所有供货商
	 *
	 * @param int $productId 商品ID
	 */
	public function getSuppliers($productId)
	{
		return $this->helper->get('/suppliers/' . $productId);
	}
}
