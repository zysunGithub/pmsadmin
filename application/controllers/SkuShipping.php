<?php

class SkuShipping extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->model('common');
		$this->load->model('region');
		$this->load->model('facility');
		$this->load->model('distributeshipping');
		$this->load->model('productmodel');
	}
	public function facilityList(){
		$input = array();
		$out = $this->facility->getFacilityCoverage($input);
		$data = $this->helper->merge($out);
		$this->load->view('facility_coverage',$data);
	}
	public function distributeShippingRule(){
		$cond = array();
		$data = $this->helper->merge($cond);
		$this->load->view('distribute_shipping_rule',$data);
	}
	public function distributeShippingRuleDetail(){
		$cond = array();
		$data = $this->helper->merge($cond);
		$this->load->view('distribute_shipping_rule_detail',$data);
	}
	public function getPackagingList(){
		$product_id = $this->getInput('product_id');
		$input = array(
			'product_id' => $product_id
		);
		$out = $this->distributeshipping->getPackagingList($input);
		echo json_encode($out);
	}
	public function getDistributionShippingDetail(){
		$facility_id = $this->getInput('facility_id');
		$product_id = $this->getInput('product_id');
		$shipping_id = $this->getInput('shipping_id');
		$out = $this->distributeshipping->getDistributionShippingDetail($facility_id,$product_id,$shipping_id);
		echo json_encode($out);
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
		$temp = $this->getInput("region_type");
		if(!empty($temp)){
			$data['region_type'] = $temp;
		}
		$temp = $this->getInput("region_id");
		if(!empty($temp)){
			$data['region_id'] = $temp;
		}
		$temp = $this->getInput("shipping_id");
		if(!empty($temp)){
			$data['shipping_id'] = $temp;
		}
		$temp = $this->getInput("sku_region_shipping_id");
		if(!empty($temp)){
			$data['sku_region_shipping_id'] = $temp;
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