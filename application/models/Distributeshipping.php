<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed'); 
// 处理商品相关的逻辑 为 商品 控制器服务 
class Distributeshipping extends CI_Model {

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

    public function getPackagingList($data){
        $out = $this->helper->get("/product/getPackaging/{$data['product_id']}");
        return $out;
        if($this->helper->isRestOk($out)) {
            return $out;
        }else{
            return array("success"=>"false","error_info"=>$out['error_info']);
        }
    }
    public function getDistributionShippingDetail($facility_id,$product_id,$shipping_id){
    	$out = $this->helper->get("/distributionshipping/".$facility_id."/".$product_id."/".$shipping_id."/getDistributionShippingDetail",array());
    	if($this->helper->isRestOk($out)) {
    		return $out;
    	}else{
    		return array("success"=>"false","error_info"=>$out['error_info']);
    	}
    }
    public function addDistributionShippingRule($facility_id,$product_id,$shipping_id,$data){
    	$out = $this->helper->post("/distributionshipping/".$facility_id."/".$product_id."/".$shipping_id."/addDistributionShippingRule",$data);
    	if($this->helper->isRestOk($out)) {
    		return $out;
    	}else{
    		return array("success"=>"false","error_info"=>$out['error_info']);
    	}
    }
}