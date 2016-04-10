<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

// 处理订单相关的逻辑 为 订单控制器服务 
class Common extends CI_Model {

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
   

  public function getFacilityList($cond = array()){
    $out =  $this->helper->get("/admin/userfacilities",$cond); 
    $result = array();  
    if($this->helper->isRestOk($out)){
    	$result['data'] = $out['facility_list'];
    }else{
    	$result['error_info'] = $out['error_info'];
    }
    return $result; 
  }
  
  public function getUserRealFacilityList($cond = array()){
    $out =  $this->helper->get("/admin/userfacilities",$cond); 
    $result = array();  
    if($this->helper->isRestOk($out)){
    	$facility_list = array();
    	foreach ($out['facility_list'] as $facility) {
    		if (in_array($facility['facility_type'], array(3,4,5))) {
    			continue;
    		}
    		$facility_list[] = $facility;
    	}
    	$result['data'] = $facility_list;
    	$result['result'] = 'ok';
    }else{
    	$result['error_info'] = $out['error_info'];
    	$result['result'] = 'no';
    }
    return $result; 
  }
  
  public function getFacilityAttribute($facility_id,$attrName){
  	$out = $this->helper->get("/facility/attribute/".$facility_id."/".$attrName);
  	if($this->helper->isRestOk($out)){
  		return $out['attribute'];
  	}
  	return null;
  }
  
  public function getPurchasePlaceByAreaId($area_id) {
  	$out = $this->helper->get("/purchase/purchasePlace/list/facility/" . $area_id);
  	$result = array();  
    if($this->helper->isRestOk($out)){
    	$result['data'] = $out['data'];
    }else{
    	$result['error_info'] = $out['error_info'];
    }
    return $result; 
  }
  
  public function getAreaList(){
  	$out =  $this->helper->get("/admin/area/list");
  	$result = array();
  	if($this->helper->isRestOk($out)){
  		$result['data'] = $out['area_list'];
  		$result['result'] = 'ok';
  	}else{
  		$result['error_info'] = $out['error_info'];
  		$result['result'] = 'no';
  	}
  	return $result;
  }
  
  public function getProductionBatchTypeList(){
  	$out = $this->helper->get('/production/batch/type/list');
  	$result = array();
  	if($this->helper->isRestOk($out)){
  		$result['data'] = $out['type_list'];
  	}else{
  		$result['error_info'] = $out['error_info'];
  	}
  	return $result;
  }
  
  public function getUserAreaList($containGreaterChina = true){
  	$out =  $this->helper->get("/admin/user/area/list/".$containGreaterChina);
  	$result = array();
  	if($this->helper->isRestOk($out)){
  		$result['data'] = $out['area_list'];
  	}else{
  		$result['error_info'] = $out['error_info'];
  	}
  	return $result;
  }
}