<?php

// 采购入库
class PurchaseIn extends CI_Controller {
    function __construct() {
      date_default_timezone_set("Asia/Shanghai");
      parent::__construct();
      $this->load->library('Pager'); 
      $this->load->model('inventorytransaction');
      $this->load->model('loadingbill');
      $this->load->model('common');
      $this->helper->chechActionList(array('purchaseIn'),true);
    }
    
    public function index() {
    	$cond = array();
        $bol_sn = $this->getInput('bol_sn');
        $facility_id = $this->getInput('facility_id');
        $cond['product_type'] = $this->getInput('product_type');
        if ($cond['product_type'] == 'supplies' && !$this->helper->chechActionList(array('suppliesInventoryManager'))) {
        	die("无耗材权限");
        }
        if ($cond['product_type'] != 'supplies' && !$this->helper->chechActionList(array('wuliaoManager','transferManager'))) {
        	die("无商品权限");
        }
        
        if ($bol_sn && $facility_id) {
        	$cond['bol_sn'] = $bol_sn;
        	$cond['facility_id'] = $facility_id;
        	$out = $this->loadingbill->getLoadingBill($cond);
        	if (isset($out['error_info'])) {
        		//$cond['message'] = $out['message'];
        		echo $out['error_info'] . "<br/>";
        	} else {
        		$cond['loading_bill'] = $out['data']['loading_bill'];
        		$cond['loading_bill_item_list'] = $out['data']['loading_bill_item_list'];
                $cond['facility_type'] = $out['data']['facility_type'];
        		$cond['container_revisable'] = $out['data']['container_revisable'] && $cond['product_type'] != 'supplies' && $cond['loading_bill']['product_type'] != 'supplies';
        	}
        }
        
    	$facility_list = $this->common->getFacilityList();
        $cond['facility_list'] = $facility_list['data'];
        $data = $this->helper->merge($cond); 
        $this->load->view('purchase_in',$data);
    }
    
    public function getLoadingBillItem() {
    	$cond = array();
    	$cond['bol_id'] = $this->getInput('bol_id');
    	$cond['container_code'] = $this->getInput('container_code');
    	$out = $this->loadingbill->getLoadingBillItem($cond);
    	if (isset($out['error_info'])) {
    		echo json_encode($out);
    	} else {
    		$loading_bill_item = $out['data']['loading_bill_item'][0];
	    	echo json_encode($loading_bill_item);
    	}
    }
    
    public function createPurchaseTransaction() {
    	$cond = array();
    	$cond['bol_item_id'] = $this->input->post("bol_item_id");
    	$cond['data'] = $this->input->post("data");
        $cond['weight'] = $this->input->post("weight");
        $cond['unit_code'] = $this->input->post("unit_code");
        $cond['facility_id'] = $this->input->post("facility_id");
    	$out = $this->inventorytransaction->createPurchaseTransaction($cond);
    	
    	if (isset($out['error_info'])) {
    		echo json_encode($out);
    	} else {
    		echo json_encode(array("success" => 'success'));
    	}
    	
    }
     // 从 get 或 post 获取数据 优先从 post 没有返回 null 
    private function getInput($name) {
        $out = trim($this->input->post($name));
        if(isset($out) && $out!=""){
          return $out;
        }else{
          $out = trim($this->input->get($name));
          if(isset($out) && $out !="") return $out;
        }
        return null;
    }
}
?>