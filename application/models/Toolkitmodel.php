<?php 
if (! defined('BASEPATH')) exit('No direct script access allowed'); 
class Toolkitmodel extends CI_Model {

    private $CI;
    private $helper;

    function __construct() {
        parent::__construct();
        if (! isset($this->CI)) {
            $this->CI = & get_instance();
        }
        if (! isset($this->helper)) {
            $this->CI->load->library('Helper');
            $this->helper = $this->CI->helper;
        }
    }
    
    // 根据asn_item_id获取信息
    public function getPurchaseFinanceInfoByAsnItemId($asn_item_id) {
    	$out = $this->helper->get("/admin/purchaseFinanceInfoByAsnItemId", $asn_item_id);
    	if ($this->helper->isRestOk($out)) {
    		return $out;
    	} else {
    		return array("success"=>"false","error_info" => "获取asn信息失败");
    	}
    }

    // asn_item_id更新init
    public function purchaseFinanceInfoByForce($cond) {
    	$out =  $this->helper->post("/admin/purchaseFinanceInfoByForce", $cond);
    	$result = array();  
        if ($this->helper->isRestOk($out)) {
            $result['data'] = $out;
        } else {
            $result['error_info'] = $out['error_info'];
        }
        return $result; 
    }
}