<?php
class SkuRegionFacility extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->model('common');
		$this->load->model('skufacility');
	}
	
	public function addSkuRegionFacility(){
		$data = $this->getPostData();
		$res = $this->skufacility->addSkuRegionFacility($data);
		echo json_encode($res);
	}
	public function getSkuRegionFacilityList(){
		$data = $this->helper->merge(array());
		$this->load->view('sku_region_facility',$data);
		
	}

	public function getSkuRegionFacilityListData(){
		$data = array(
			'facility_id' => $this->getInput("facility_id"),
			'product_id' => $this->getInput("product_id"),
		);
		$res = $this->skufacility->getSkuRegionFacility($data);
	    echo json_encode($res);
		
	}
	public function getSkuFacilityAvaiableRegion(){
		$data = array(
			'facility_id' => $this->getInput("facility_id"),
			'product_id' => $this->getInput("product_id"),
		);
		$res = $this->skufacility->getSkuFacilityAvaiableRegion($data);
	    echo json_encode($res);
	}


	// demo
	public function getNotSetting(){
		$res = $this->skufacility->getNotSetting();
		//var_dump($res);
		$data['list'] = $res['list'];
		$data = $this->helper->merge($data);
		$this->load->view('facility_notexit',$data);
	}
	
	
	public function getPostData(){
		$data = array();
		$temp = $this->getInput("facility_id");
		if(!empty($temp)){
			$data['facility_id'] = $temp;
		}
		$temp = $this->getInput("product_id");
		if(!empty($temp)){
			$data['product_id'] = $temp;
		}
		$data['city_ids'] = '';
		$temp = $this->input->post("city_ids");
		if(is_array($temp) && count($temp)>0){
			$data['city_ids'] = implode(',',$temp);
		}
		return $data;
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