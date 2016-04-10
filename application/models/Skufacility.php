<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed'); 
// 处理商品相关的逻辑 为 商品 控制器服务 
class Skufacility extends CI_Model {

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

    
    public function getSkuRegionFacility($data){
    	$out = $this->helper->get("/SkuFacility/getSkuRegionFacility",$data);
    	if($this->helper->isRestOk($out)) {
    		return $out;
    	}else{
    		return array("success"=>"false","error_info"=>$out['error_info']);
    	}
    }
    public function getSkuFacilityAvaiableRegion($data){
    	$out = $this->helper->get("/SkuFacility/getSkuFacilityAvaiableRegion",$data);
    	if($this->helper->isRestOk($out)) {
    		return $out;
    	}else{
    		return array("success"=>"false","error_info"=>$out['error_info']);
    	}
    }
    
    
    public function addSkuRegionFacility($data){
    	$out = $this->helper->post("/product/setSkuRegionFacility",$data);
    	if($this->helper->isRestOk($out)) {
    		return array("success"=>"true");
    	}else{
    		return array("success"=>"false","error_info"=>$out['error_info']);
    	}
    }
    
    public function getNotSetting(){
    	$out = $this->helper->get("/SkuFacility/notSetting");
    	if($this->helper->isRestOk($out)) {
    		return $out;
    	}else{
    		return array("success"=>"false","error_info"=>$out['error_info']);
    	}
    }
}