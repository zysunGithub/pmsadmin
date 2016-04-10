<?php 
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 
// 处理订单相关的逻辑 为 订单控制器服务 
class Facility extends CI_Model {

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
     
     public function addFacility($data) {
     		$out = $this->helper->post("/facility/addFacility",$data);
     		if($this->helper->isRestOk($out)) {
     			$info['success'] = "OK";
     		}else {
	     		if (isset($out['error_info'])) {
	     			$info['error_info'] = "仓库添加失败！" . $out['error_info'];
	     		} else {
	     			$info['error_info'] = "仓库添加失败！无详细信息";
	     		}
     			$info['error_info'] = "仓库添加失败！";
     		}
     		return $info;
     }

     public function transfer($data) {
     	$out = $this->helper->post("/shipment/transfer",$data);
     	if($this->helper->isRestOk($out)) {
     		$info = $out;
     	}else {
     		if (isset($out['error_info'])) {
     			$info['error_info'] = $out['error_info'];
     		} else {
     			$info['error_info'] = "转仓失败！ 无详细信息";
     		}
     	}
     	return $info;
     }
     public function getTransferList($params) {
     	$out = $this->helper->get("/shipment/transferList",$params);
     	if($this->helper->isRestOk($out)){
     		$result['data'] = $out;
     	}else{
     		$result['error_info'] = $out['error_info'];
     	}
     	return $result;
     }
     
     public function getTransferItems($transfer_shipment_id) {
     	$out = $this->helper->get("/shipment/transferItems",array("transfer_shipment_id" => $transfer_shipment_id));
     	if($this->helper->isRestOk($out)){
     		$result['data'] = $out;
     	}else{
     		$result['error_info'] = $out['error_info'];
     	}
     	return $result;
     }
     
     public function getAreaPurchaseManagerList($params) {
     	return $this->helper->get("/admin/area/purchaseManagerList",$params);
     }
     
     public function getFacilityList($params) {
     	return $this->helper->get("/admin/allfacilities", $params);
     }
}