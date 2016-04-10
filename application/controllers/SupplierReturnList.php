<?php

// 供应商退货
class SupplierReturnList extends CI_Controller {
    function __construct() {
      date_default_timezone_set("Asia/Shanghai");
      parent::__construct();
      $this->load->library('Pager'); 
      $this->load->model('supplierreturn');
      $this->load->model('common');
      $this->load->model('productmodel');
	  
	  $facility_list = $this->common->getFacilityList();
	  if(!isset($facility_list['data'])){
	  	die('无仓库权限');
	  }
    }
    
    public function index() {
    	$this->helper->chechActionList(array('supplierReturn'),true);
		$product_type_list = $this->getProductTypeList();
		if(empty($product_type_list)) {
    		die("无权限");
    	}
		$cond = $this->getQueryCondition();
		$product_type = $this->getInput('product_type');
        if(isset($product_type)) {
        	$cond['product_type'] = $product_type;
        }
		if ( !isset($cond['product_type'])) {
        	$cond['product_type'] = $product_type_list[0]['product_type'];
        }
        if ($cond['product_type'] == 'supplies') {
        	$this->helper->chechActionList(array('suppliesCaigouManager'),true);
        	$cond['product_type_name'] = "原料";
        	
        } 
        if ($cond['product_type'] != 'supplies') {
        	$this->helper->chechActionList(array('caigouManager'),true);
        	$cond['product_type_name'] = "好果";
        	
        }
    	$facility_list = $this->common->getFacilityList();
    	if (! isset($cond['facility_id'])) {
	    	$cond['facility_id'] = $facility_list['data'][0]['facility_id'];
    	}
        $out = $this->supplierreturn->getCanSupplierReturnProductList($cond);
        if (isset($out['error_info'])) {
        	die($out['error_info']);
        } else {
        	$cond['product_list'] = $out['data']['product_list'];
        	$cond['material_product_list'] = $out['data']['material_product_list'];
        }
        
        
        $cond['facility_list'] = $facility_list['data'];
        $data = $this->helper->merge($cond); 
        $this->load->view('supplier_return',$data);
    }
    
    public function query() {
    	$product_type_list = $this->getProductTypeList();
    	if(empty($product_type_list)) {
    		die("无权限");
    	}
    	$this->helper->chechActionList(array('supplierReturnList'),true);
		
		$cond = $this->getQueryCondition();
		$product_type = $this->getInput('product_type');
        if(isset($product_type)) {
        	$cond['product_type'] = $product_type;
        }
		if ( !isset($cond['product_type'])) {
        	$cond['product_type'] = $product_type_list[0]['product_type'];
        }
        if ($cond['product_type'] == 'goods') {
    		$cond['product_type_name'] = '商品';
    		$cond['product_type_name3'] = '好果';//不同的地方显示不同的词语，真是太坑了
        } else {
        	$cond['product_type_name'] = '耗材';
    		$cond['product_type_name3'] = '原料';
        }
    	$facility_list = $this->common->getFacilityList();
    	if (isset($facility_list['error_info']) || empty($facility_list)) {
		    $facility_list = array();
		} else {
	    	$facility_list = $facility_list['data'];
		}
		if (!isset($facility_list) || empty ($facility_list) || ! is_array($facility_list)) {
			die("无仓库权限");
		}
		if (! isset($cond['facility_id']) && ! $cond['is_all_facility_action']) {
			$cond['facility_id'] = $facility_list[0]['facility_id'];
		}
		
        $cond['facility_list'] = $facility_list;
        $cond['product_type_list'] = $product_type_list;
	    $data = $this->helper->merge($cond); 
		$this->load->view('supplier_return_list',$data);
    }
    public function getSupplierReturnListForPages() {
  
    	$this->helper->chechActionList(array('supplierReturnList'),true);
    
    	$cond = $this->getQueryCondition();
    	$out = $this->supplierreturn->getSupplierReturnList($cond);
    	if($this->helper->isRestOk($out)){  // 调用 api ok
    		echo json_encode(array("list"=> $out['supplier_return_list']['supplier_return_list'],"recordsTotal"=>$out['total'],"recordsFiltered"=>$out['total']));
    	}else{  //  调用 API fail
    		echo json_encode(array());
    	}
    }
    
    public function getProductContainer(){
    	$cond = array();
    	$cond['container_code'] = $this->getInput('container_code');
    	$out = $this->product->getProductContainer($cond);
    	if (! isset($out) || empty($out)) {
    		echo "null";
    	} else {
    		echo json_encode($out[0]);
    	}
    }
    
     // 从 get 或 post 获取数据 优先从 post 没有返回 null 
    private function getInput($name) {
        $out = $this->input->post($name);
        if(isset($out) && $out!=""){
          return $out;
        }else{
          $out = trim($this->input->get($name));
          if(isset($out) && $out !="") return $out;
        }
        return null;
    }
    
    public function create() {
    	$cond['product_id'] = $this->getInput("product_id");
    	$cond['type'] = $this->getInput("type");
    	$cond['facility_id'] = $this->getInput("facility_id");
    	if ($cond['type'] == 'raw_material') {
	    	$cond['items'] = $this->getInput("items");
    	} else {
    		$cond['product_supplier_id'] = $this->getInput("product_supplier_id");
		$cond['purchase_user_id'] = $this->getInput("purchase_user_id");
		$cond['return_type'] = $this->getInput("return_type");
    		$cond['unit_price'] = $this->getInput("unit_price");
    		$cond['total_price'] = $this->getInput("total_price");
    		$cond['quantity'] = $this->getInput("quantity");
    		$cond['note'] = $this->getInput("note");
    	}
    	$out = $this->supplierreturn->createSupplierReturn($cond);
    	if (isset($out['error_info'])) {
	    	echo json_encode(array('success'=>'fail', 'error_info' => $out['error_info']));
    	} else {
    		echo json_encode(array('success'=>'success'));
    	}
    }
    
    public function getProductTypeList(){
    	$product_type_list =  array();
    	if($this->helper->chechActionList(array('wuliaoManager', 'caigouManager', 'purchaseFinance'))) {
    		$item['product_type'] = 'goods';
    		$item['product_type_name'] = '商品';
    		$product_type_list[] = $item;
    	}
    	if($this->helper->chechActionList(array('suppliesInventoryManager', 'suppliesCaigouManager', 'purchaseFinance'))) {
    		$item['product_type'] = 'supplies';
    		$item['product_type_name'] = '耗材';
    		$product_type_list[] = $item;
    	}
    	
    	return $product_type_list;
    }
    
   private function getQueryCondition() {
    	$cond = array();
    	$start_time = $this->getInput('start_time');
        if (isset($start_time) && $start_time) {
        	$cond['start_time'] = $start_time;
        }
        
        $end_time = $this->getInput('end_time');
        if (isset($end_time) && $end_time) {
        	$cond['end_time'] = $end_time;
        }
        $status = $this->getInput('status');
        if (isset($status) && $status) {
        	$cond['status'] = $status;
        }
        
        $facility_id =  $this->getInput('facility_id');
        if(isset($facility_id)) $cond['facility_id'] = $facility_id;
        $cond['product_id'] = $this->getInput('product_id');
        if (!$cond['product_id']) {
        	$cond['product_id'] = 0;
        }
        $cond['is_all_facility_action'] = $this->helper->isAllFacilityAction();
        
        $cond['product_name'] = $this->getInput('product_name');
        
        $type = $this->getInput('type');
        if ($type) {
        	$cond['type'] = $type;
        } else {
        	$cond['type'] = 'raw_material';
        }
        
        $return_type = $this->getInput('return_type');
        if (isset($return_type) && $return_type) {
        	$cond['return_type'] = $return_type;
        }
        $product_type = $this->getInput('product_type');
        if (isset($product_type) && $product_type) {
        	$cond['product_type'] = $product_type;
        }
        
        $asn_item_id = $this->getInput('asn_item_id');
        if(isset($asn_item_id) && $asn_item_id){
        	$cond['asn_item_id'] = $asn_item_id;
        }
        
        $length = $this->getInput('length');
        if(isset($length)) {
        	$cond['size'] = $length;
        }
        
        $start = $this->getInput('start');
        if(isset($start)) {
        	$cond['offset'] = $start;
        }
        
        return $cond;
    }
    
    public function checkSupplierReturn() {
    	$cond = array();
	    $cond['supplier_return_id'] = $this->getInput('supplier_return_id'); 
	    $cond['check'] = $this->getInput('check');
	    $cond['note'] = $this->getInput('note');
        //+新增 通过check来选择类型
        if ($cond['check'] == "MANAGERCHECKED" || $cond['check'] == "MANAGERCHECKFAIL") {
            $out = $this->supplierreturn->purchaseManagerCheckSupplierReturn($cond);
            echo json_encode($out);
        } else if ($cond['check'] == "CHECKED" || $cond['check'] == "CHECKFAIL") {
            $out = $this->supplierreturn->checkSupplierReturn($cond);
            echo json_encode($out);
        }
    }
    
    public function executeSupplierReturn() {
    	$cond = array();
	    $cond['supplier_return_id'] = $this->getInput('supplier_return_id'); 
	    $cond['quantity'] = $this->getInput('quantity');
	    $out = $this->supplierreturn->executeSupplierReturn($cond); 
	    echo json_encode($out);
    }
    
    public function finishSupplierReturn() {
    	$cond = array();
	    $cond['supplier_return_id'] = $this->getInput('supplier_return_id'); 
	    $cond['finance_amount'] = $this->getInput('finance_amount');
	    $out = $this->supplierreturn->finishSupplierReturn($cond); 
	    echo json_encode($out);
    }
}
?>