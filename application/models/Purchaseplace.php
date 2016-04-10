<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

// 采购地址相关逻辑 
class PurchasePlace extends CI_Model {

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
     
     public function getPurchasePlaceFacility() {
     	$out =  $this->helper->get("/purchase/purchasePlaceFacility/list",array());
     	$result = array();
     	if($this->helper->isRestOk($out)){
     		$result['data'] = $out['data'];
     	}else{
     		$result['error_info'] = $out['error_info'];
     	}
     	return $result;
     }
     
     public function addPurchasePlaceFacility($purchase_place_id,$cond){
     	$out = $this->helper->post("/purchase/purchasePlaceFacility/".$purchase_place_id."/add",$cond);
     	
     	if($this->helper->isRestOk($out,'message')){
     		$out['success'] = 'OK';
     	}else{
     		$out['success'] = "error";
     	}
     	return $out;
     }
     
     public function removePurchasePlaceFacility($purchase_place_id, $facility_id){
     	$out = $this->helper->post("/purchase/purchasePlaceFacility/$purchase_place_id/$facility_id/remove",array());
     	$out['success'] = "error";
     	if($this->helper->isRestOk($out,'message')){
     		$out['success'] = 'OK';
     	}
     	return $out;
     }
     
     public function getFacilityList(){
     	$out =  $this->helper->get("/purchase/purchasePlaceFacility/facilitys",array());
     	$result = array();
     	$result['success'] = "error";
     	if($this->helper->isRestOk($out)){
     		$result['data'] = $out['data'];
     		$result['success'] = 'OK';
     	}else{
     		$result['error_info'] = $out['error_info'];
     	}
     	return $result;
     }
}