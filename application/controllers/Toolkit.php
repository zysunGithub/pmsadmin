<?php

class Toolkit extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('Helper');
		$this->load->library('session');
		$this->load->model('common');
		$this->load->model('Toolkitmodel');
		$this->load->model('productmodel');
		// if (! $this->helper->chechActionList(array("toolkit"))) {
		// 	die("无权限");
		// }
	}
	
	public function index(){
		$cond = array();
		$act = $this->getInput('act');
		switch ($act) {
			case "transitVarianceIn":
				$cond = $this->transitVarianceIn();
				break;	
			default:
				break;
		}
		$tab = $this->getInput('tab');
		if(!empty($tab)){
			$cond['tab'] = $tab;
		}
		$data = $this->helper->merge($cond);
		$this->load->view("toolkit",$data);
	}

	public function getdata(){
		$cond = array();
		//title
	    $out = $this->helper->get("/admin/actionTitleList");
	    if($this->helper->isRestOk($out)){
	    	$cond['action_title_list'] = $out['action_title_list'];
	    }else{
	    	$cond['action_title_list'] = array();
	    }
	    $cond['WEB_ROOT'] = $this->helper->getUrl();
		$data = $this->helper->merge($cond);
		// $data = (json_encode($data));
		echo json_encode($data);
	}
	public function getPostData(){
		$out = array();
		$out['action_name'] = $this->input->post('action_name');
		$out['action_code'] = $this->input->post('action_code');
		$temp = $this->input->post('action_id');
		$out['action_id'] = '';
		if(is_array($temp) && count($temp)>0){
			foreach($temp as $id){
				$out['action_id'] .= ($id.",");
			}
			$out['action_id'] = substr($out['action_id'], 0, strlen($out['action_id'])-1);
		}
		return $out;
	}

	public function addAction(){
		$record = $this->getPostData();
		$res = $this->helper->post("/admin/addNewAction", $record);
		$success = false;
		if(!empty($res['action_id']) ){
			$success = true;
			echo json_encode(array(
				"success"=>$success
				));
		}else {
			echo json_encode(array(
				"success"=>$success,
				"error_info" => $res['error_info']
				));
		}
	}


	public function getProduct() {
		$product_id = $this->getInput('product_id');
		$res = $this->productmodel->getProductByID($product_id);
		echo json_encode($res['product']);
	}
	
	public function productToInit(){
		$product_id = $this->getInput('product_id');
		$out = $this->productmodel->productToInit($product_id);
		if($this->helper->isRestOk($out)) {
    		echo json_encode( array( 'success'=>'success'));
    	} else {
    		echo json_encode( array( 'success' => 'fail','error_info'=>!empty($out['error_info'])?$out['error_info']:'服务器内部错误' ) );
    	}
	}
	
	public function productForceToInit(){
		$product_id = $this->getInput('product_id');
		$out = $this->productmodel->productForceToInit($product_id);
		if($this->helper->isRestOk($out)) {
    		echo json_encode( array( 'success'=>'success'));
    	} else {
    		echo json_encode( array( 'success' => 'fail','error_info'=>!empty($out['error_info'])?$out['error_info']:'服务器内部错误' ) );
    	}
	}

	//ajax 通过asn_item_id获取相关的信息
	public function getPurchaseFinanceInfoByAsnItemId() {
		$asn_item_id = $this->getInput('asn_item_id');
		if (isset($asn_item_id)) {
			$cond['asn_item_id'] = $asn_item_id;
			$result = $this->Toolkitmodel->getPurchaseFinanceInfoByAsnItemId($cond);
			echo json_encode($result);
		}
	}
	
	//ajax 通过asn_item_id类型置为init
	public function purchaseFinanceInfoByForce() {
		$asn_item_id = $this->getInput('asn_item_id');
		if (isset($asn_item_id)) {
			$cond['asn_item_id'] = $asn_item_id;
			$result = $this->Toolkitmodel->purchaseFinanceInfoByForce($cond);
			echo json_encode($result);
		}
	}
	
	// 从 get 或 post 获取数据 优先从 post 没有返回 null
	private function getInput($name){
		$out = trim( $this->input->post($name) );
		if(isset($out) && $out!=""){
			return $out;
		}else{
			$out = trim($this->input->get($name));
			if(isset($out) && $out !="") return $out;
		}
		return null;
	}
	
	
	public function transitVarianceIn() {
		$cond['bol_item_id'] =  $this->getInput('transitVarianceIn_bol_item_id');
		$cond['qoh'] = $this->getInput('transitVarianceIn_qoh');
		$cond['note'] = $this->getInput('transitVarianceIn_note');
		$out = $this->transferinventory->transitVarianceIn($cond);
		if(isset($out['error_info'])) {
			$cond['error_info'] = $out['error_info'];
		} else {
			$cond['message'] = "操作成功";
		}
		return $cond;
	}
}

?>