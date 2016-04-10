<?php
class LoadingBillList extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('common');
		$this->load->model('purchase');
		$this->load->library('Pager');
		$this->load->library('Helper');
		$this->helper->chechActionList(array('loadingBillList'),true);
	}

	public function index() {
		$this->helper->chechActionList(array('wuliaoManager', 'caigouManager','transferManager'),true);
		$this->showIndex('goods');
	}

	public function suppliesIndex() {
		$this->helper->chechActionList(array('suppliesCaigouManager','suppliesInventoryManager'),true);
		$this->showIndex('supplies');
	}
	
	private function showIndex( $product_type ) {
		$facility_list = $this->common->getFacilityList();
		if(empty($facility_list)) {
			die('无仓库权限');
		}
		$cond = $this->getQueryCondition();
		
		if(empty($cond['start_date']) && empty($cond['end_date'])) {
			$cond['start_date'] = date('Y-m-d');
			$cond['end_date'] = date('Y-m-d');
		}
		if(empty($cond['facility_id'])) {
			$cond['facility_id'] = $facility_list['data'][0]['facility_id'];
		}

		$cond['product_type'] = $product_type;
		$out = $this->purchase->getLoadingBillList($cond);
		if(!is_array($out)) {
			echo isset($out)?$out:"ERROR!请联系ERP";
		}
		$cond['loading_bill_list'] = $out;
		$cond['facility_list'] = $facility_list['data'];

		if(!$this->helper->chechActionList(array('purchaseModify'))) {
			$cond['readonly'] = 'true';
		} else {
			$cond['readonly'] = 'false';
		}
		$data = $this->helper->merge($cond);
		$this->load->view('loading_bill_list',$data);
	}

	private function getQueryCondition( ){
		$cond = array( );
		$facility_id = $this->getInput('facility_id');
		if(isset($facility_id)) {
			$cond['facility_id'] = $facility_id;
		}
		
		$start_date = $this->getInput('start_date');
		if(isset($start_date)) {
			$cond['start_date'] = $start_date;
		}
		
		$end_date = $this->getInput('end_date');
		if(isset($end_date)) {
			$cond['end_date'] = $end_date;
		}
		
		$product_type = $this->getInput('product_type');
		if(isset($product_type)) {
			$cond['product_type'] = $product_type;
		} 
		return $cond;
	}
	
	// 从 get 或 post 获取数据 优先从 post 没有返回 null
	private function getInput($name){
		$out = trim($this->input->post($name));
		if(isset($out) && $out!=""){
			return $out;
		}else{
			$out = trim($this->input->get($name));
			if(isset($out) && $out !="") return $out;
		}
		return null;
	}
	
	public function detail(){
		$bol_id = $this->getInput('bol_id');
		if(empty($bol_id)) {
			echo json_encode( array( "success" => 'fail','error_info' => '无装车单' ) );
		}
		$out = $this->purchase->getLoadingBillItemListByBol($bol_id);
		if($out == 'error') {
			echo json_encode( array( 'success' => 'fail','error_info' => '服务器内部错误') );
		} else {
			echo json_encode( array( 'success' => 'success','loading_bill_item_list' => $out) );
		}
	}
	
	public function removeItem(){
		$bol_item_id = $this->getInput('bol_item_id');
		if(empty($bol_item_id)){
			echo json_encode( array( "success" => 'fail','error_info' => '删除失败' ) );
			return;
		}
		$out = $this->purchase->removeLoadingBillItem($bol_item_id);
		if($this->helper->isRestOk($out,'message') && $out['message'] == 'success'){
			echo json_encode( array( "success" => 'success','error_info' => '删除成功' ) );
		} else {
			echo json_encode( array( 'success' => 'fail', 'error_info' => !empty($out['error_info'])?$out['error_info']:'服务器内部错误'));
		}
	}
	
    public function setLoadingBillArrivalTime(){
        $cond = array();
        $bol_sn = $this->input->post('bol_sn');
        if (isset($bol_sn)) {
            $cond['bol_sn'] = $bol_sn;
        } else {
            $cond['error'] = 'true';
        }
        $arrival_time = $this->input->post('arrival_time');
        if (isset($arrival_time)) {
            $cond['arrival_time'] = $arrival_time;
        } else {
            $cond['error'] = 'true';
        }
        if (!empty($cond['error']) && $cond['error'] == 'true') {
            echo json_encode(array("success" => 'fail', 'error_info' => '提交失败'));
            die();
        }
        $out = $this->purchase->setArrivalTime($cond);
        if ($out['message'] == 'success') {
            echo json_encode(array("success" => 'success', 'error_info' => '提交成功'));
        } else {
            echo json_encode(array('success' => 'fail', 'error_info' => !empty($out['error_info']) ? $out['error_info'] : '服务器内部错误'));
        }
    }
}