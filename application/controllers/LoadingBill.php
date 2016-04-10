<?php
/*
 * It is used for the Web Controller, extending CIController.
 * The name of the class must have first Character as Capital.
 *
**/
class LoadingBill extends CI_Controller {
	function __construct()
	{
		parent::__construct();
	  	$this->load->library('session'); 
	    $this->load->library('Helper'); 
	    $this->load->model('common');
	    $this->load->model("purchase");
	    $this->helper->chechActionList(array('suppliesLoadingBill','loadingBill','TILoadingBill'),true) ;
		
	}

	private function getQueryCondition( ){
		$cond = array( );
		$facility_id = $this->getInput('facility_id');
		if(isset($facility_id)) {
			$cond['facility_id'] = $facility_id;
		} else{
			$cond['error'] = "error";
			$cond['error_info'] = "无法获取当前仓库";
		}
		$asn_id = $this->getInput('asn_id');
		if(isset($asn_id)){
			$cond['asn_id'] = $asn_id;
		} else{
			$cond['error'] = "error";
			$cond['error_info'] = "无法获取asn_id";
		}
		$estimated_arrival_time = $this->getInput('estimated_arrival_time');
		if(isset($estimated_arrival_time)){
			$cond['estimated_arrival_time'] = $estimated_arrival_time;
		} else{
			$cond['error'] = "error";
			$cond['error_info'] = "无法获取预估到货时间";
		}
        $setoff_time = $this->getInput('setoff_time');
        if(isset($setoff_time)){ 
			$cond['setoff_time'] = $setoff_time;
		} else{
			$cond['error'] = "error";
			$cond['error_info'] = "无法获取实际发车时间";
		}
		$car_num = $this->getInput('car_num');
		if(isset($car_num)) {
			$cond['car_num'] = $car_num;
		} else{
			$cond['error'] = "error";
			$cond['error_info'] = "无法获取车牌号码";
		}
		
		$driver_mobile = $this->getInput('driver_mobile');
		if(isset($driver_mobile)) {
			$cond['driver_mobile'] = $driver_mobile;
		} else{
			$cond['error'] = "error";
			$cond['error_info'] = "无法获取司机电话";
		}
		
		$deliver_price = $this->getInput('deliver_price');
		if(isset($deliver_price)) {
			$cond['deliver_price'] = $deliver_price;
		} else{
			$cond['error'] = "error";
			$cond['error_info'] = "无法获取车费";
		}
		
		$loading_price = $this->getInput('loading_price');
		if(isset($loading_price)) {
			$cond['loading_price'] = $loading_price;
		} else{
			$cond['error'] = "error";
			$cond['error_info'] = "无法获取装车费";
		}
		
		$driver_name = $this->getInput('driver_name');
		if(isset($driver_name)) {
			$cond['driver_name'] = $driver_name;
		}  else {
            $cond['error'] = "error";
            $cond['error_info'] = "无法获取司机姓名";
		}

        $car_provider = $this->getInput('car_provider');
        if(isset($car_provider)) {
            $cond['car_provider'] = $car_provider;
        }  else {
            $cond['error'] = "error";
            $cond['error_info'] = "无法获取车队信息";
        }
    
        $car_model = $this->getInput('car_model');
        if(isset($car_model)) {
            $cond['car_model'] = $car_model;
        }  else {
            $cond['error'] = "error";
            $cond['error_info'] = "无法获取车型信息";
        }

        $invoice_no = $this->getInput('invoice_no');
        if(isset($invoice_no)) {
            $cond['invoice_no'] = $invoice_no;
        }  else {
            $cond['error'] = "error";
            $cond['error_info'] = "无法获取六联单编号";
        }
		
		$note = $this->getInput('note');
		if(isset($note)) {
			$cond['note'] = $note;
		} else {
			$cond['note'] = '';
		}
		
		$bol_items = $this->getInput('bol_items');
		if(isset($bol_items)){
			$cond['bol_items'] = $bol_items;
		} else{
			$cond['error'] = "error";
			$cond['error_info'] = "无法获取装车信息";
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
	
  public function index() {
	  $productType = $this->getInput('product_type');
	  if ($productType == 'supplies') {
		  $permission = 'suppliesLoadingBill';
	  } else {
		  $permission = 'loadingBill';
	  }
  	$this->helper->chechActionList(array($permission), true);
	$cond = $this->initData();
    $cond['from_p'] = 'INDEX';
  	if(!empty($cond['error']) && $cond['error'] = 'error'){
  		echo 'ERROR!'.$cond['error_info'];
  		return;
  	}

	  $cond['product_type'] = $productType;
    $asn = $this->purchase->getAsn($cond['facility_id'], $cond['po_date'], $productType, $cond['facility_type'], $cond['area_type']);
    if( $cond['facility_type'] == 1 || $cond['facility_type'] == 2 || $cond['area_type'] != 'national' || empty($cond['asn_id']) ){
      if(!is_array($asn)) {
        $cond['error_info'] =  isset($asn)?$asn:"ERROR!请联系ERP";
        $data = $this->helper->merge($cond);
        $this->load->view('loading_bill', $data);
        return;
      }else{
        $cond['asn_id'] = $asn[0]['asn_id'];
        $cond['asn_type'] = $asn[0]['asn_type'];
        $cond['asn_date'] = $asn[0]['asn_date'];
      }
    }else{
      foreach ($asn as $key => $asn_val) {
        if( $asn_val['asn_id'] == $cond['asn_id'] ){
          $cond['asn_type'] = $asn_val['asn_type'];
          $cond['asn_date'] = $asn_val['asn_date'];
        }
      }
    }
    if(empty($asn['asn_id'])) {
	    $cond['asn_list'] = $asn;
	  	$asnItemList = $this->purchase->getAsnItemList($cond['asn_id']);
	  	if(empty($asnItemList)){
	  		$cond['error_info'] = '无ASN明细';
	      $data = $this->helper->merge($cond);
        $this->load->view('loading_bill', $data);
        return;
	  	}
	  	$cond['asn_item_list'] = $asnItemList;
	  	if($cond['asn_type'] == 'PO' && in_array($cond['facility_type'], array(3, 4, 5)) ) {
	  		$cond['default_driver_name'] = '虚拟仓自动装车';
	  		$cond['default_car_num'] = '浙WMS8888';
	  		$cond['default_driver_mobile'] = '13188888888';
	          $cond['default_car_provider'] = '速达';
	          $cond['default_car_model'] = 's1';
	  		$cond['default_loading_price'] = 0;
	  		$cond['default_deliver_price'] = 0;
	  	}
    }
	$data = $this->helper->merge($cond);
	$this->load->view('loading_bill', $data);
  }
  
  public function getAsnList(){
    $facility_id = $this->getInput('facility_id');
    if(empty($facility_id)){
      echo '缺少仓库ID';
      return;
    }

    $po_date = $this->getInput('po_date');
    if(empty($po_date)){
      echo '缺少po的日期';
      return;
    }

    $facility_type = $this->getInput('facility_type');
    if(empty($facility_type)){
      echo '缺少仓库类型';
      return;
    }

    $area_type = $this->getInput('area_type');
    if(empty($area_type)){
      echo '缺少大区类型';
      return;
    }
    $asn = $this->purchase->getAsn($facility_id, $po_date, 'goods', $facility_type, $area_type);
    if( !empty($asn) && is_array($asn) ){
      echo json_encode(array('success'=>'success','asn_list'=>$asn));
    }else{
      echo json_encode(array('success'=>'failed','error_info'=>'后端没有获取到asn,请确定今天是否下过PO'));
    }
  }
  public function tiIndex(){
  	$this->helper->chechActionList(array('TILoadingBill'),true);
  	$asn_id = $this->getInput('asn_id');
  	if(isset($asn_id)) {
  		$cond['asn_id'] = $asn_id;
  	} else {
  		echo '获取asn失败';
  		return;
  	}
  	
  	$from_facility_name = $this->getInput('from_facility_name');
  	if(isset($from_facility_name)) {
  		$cond['from_facility_name'] = $from_facility_name;
  	} 
  	$to_facility_name = $this->getInput('to_facility_name');
  	if(isset($to_facility_name)){
  		$cond['to_facility_name'] = $to_facility_name;
  	}
  	
  	$asnItemList = $this->purchase->getAsnItemList($asn_id);
  	if(empty($asnItemList)){
  		echo '无asn明细';
  		return;
  	}
  	$cond['asn_item_list'] = $asnItemList;
  	$cond['asn_date'] = $asnItemList[0]['asn_date'];
  	$cond['asn_type'] = $asnItemList[0]['asn_type'];
  	$cond['facility_id'] = $asnItemList[0]['facility_id'];
  	$cond['from_p'] = 'TIINDEX';
  	$data = $this->helper->merge($cond);
  	$this->load->view('loading_bill', $data);
  }
  
  public function initData(){
    $initData = array();
  	//$area_list = $this->common->getUserAreaList(false);
	$facility_list = $this->common->getFacilityList($initData);
  	if(empty($facility_list) || ! isset($facility_list['data']) || count($facility_list['data']) < 1) {
  		$initData['error'] = 'error';
  		$initData['error_info'] = '账号无仓库权限！';
  		return $initData;
  	}

  	$initData['facility_list'] = $facility_list['data'];
  	
  	if ($this->getInput('facility_id')) {
  		foreach ($facility_list['data'] as $f) {
  			if ($this->getInput('facility_id') == $f['facility_id']) {
  				$facility = $f;
  				break;
  			}
  		}
  	} else {
  		$facility = $facility_list['data'][0];
  	}
	$initData['facility_id'] = $facility['facility_id'];
	$initData['facility_name'] = $facility['facility_name'];
  	$initData['facility_type'] = $facility['facility_type'];
	$initData['area_type'] = $facility['area_type'];
  	$asn_id = $this->getInput('asn_id');
    if( !empty($asn_id) ){
      $initData['asn_id'] = $asn_id;
    }
  	$purchase_plan2_time = $this->common->getFacilityAttribute($initData['facility_id'], 'purchase_plan2_time');
  	$fulfill_end_time = $this->common->getFacilityAttribute($initData['facility_id'], 'fulfill_end_time');
  	if(!empty($fulfill_end_time)){
  		$initData['fulfill_end_time'] = $fulfill_end_time;
  	}
  	 
  	if(date('H:i:s') < $purchase_plan2_time) {
  		$initData['po_date'] = date('Y-m-d',strtotime('-1 day'));
  	} else {
  		$initData['po_date'] = date('Y-m-d');
  	}
  	$initData['po_type'] = 'SECOND';
  	return $initData;
  }
  
  public function addLoadingBill() {
  	$cond = $this->getQueryCondition();
  	if(!empty($cond['error']) && $cond['error'] = 'error'){
  		echo json_encode( array( "success" => 'fail',"error_info" => 'ERROR!'.$cond['error_info'] ) );
  		return;
  	}
  	$out = $this->purchase->addLoadingBill($cond);
  	if($out == 'success'){
  		echo json_encode( array( "success" => 'success' ) );
  	} else {
  		echo json_encode( array( "success" => 'fail','error_info'=>!empty($out)?$out:'服务器内部错误' ) );
  	}
  }
}
?>
