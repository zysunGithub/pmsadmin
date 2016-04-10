<?php
class PurchasePlaceFacility extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->library('Helper');
		$this->load->library('session');
		$this->load->model('common');
		$this->load->model('purchaseplace');
	}
	public function index(){

		//获取快递方式
		$out = $this->purchaseplace->getPurchasePlaceFacility();
		$data['list'] = $out['data'];
		$data = $this->helper->merge($data);
		$this->load->view('purchase_place_facility',$data);
	}

	public function addPurchasePlaceFacility() {
		$purchase_place_id = $this->input->post('purchase_place_id');
		$data = array(
			"facility_id" => $this->input->post("facility_id"),
		);
		$info = $this->purchaseplace->addPurchasePlaceFacility($purchase_place_id,$data);
		echo json_encode($info);
	}

	public function deletePurchasePlaceFacility() {
		$purchase_place_id = $this->input->post('purchase_place_id');
		$facility_id = $this->input->post('facility_id');
		$info = $this->purchaseplace->removePurchasePlaceFacility($purchase_place_id, $facility_id);
		echo json_encode($info);
	}
	public function getFacilityList() {
		$info = $this->purchaseplace->getFacilityList();
		echo json_encode($info);
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
}

?>