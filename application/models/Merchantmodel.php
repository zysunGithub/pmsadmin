<?php
	if(!defined('BASEPATH'))  exit('No direct script access allowed');

//用于商户信息管理
class Merchantmodel extends CI_Model {

	private $CI;
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
	//获取商户列表
	public function getMerchantList($cond){

		if(empty($cond)){
			$cond = array();
		}
		$out = $this->helper->get("/merchant/list",$cond);
		$result = array();
		if($this->helper->isRestOk($out)){
			$result['data'] = $out['data'];
			$result['shop'] = $out['shop'];
			//echo json_encode($result['data']);
		}else{
			$result['error_info'] = $out['error_info'];
		}
		return $result;
	}
	public function getPlatformList($cond){
		return $this->helper->get("/merchant/platformlist",$cond);
	}

	//添加商户
	public function addMerchant($data){
		$out = $this->helper->post("/merchant/add",$data);
		if($this->helper->isRestOk($out)){
			echo json_encode(array("success"=>"true","data"=>$out['data']));
		}else{
			echo json_encode(array("success"=>"false","error_info"=>$out['error_info']));
		}
	}

	//编辑商户信息
	public function editMerchant($data){
		return $this->helper->post("/merchant/edit",$data);
	}

	//更改商户状态
	public function updateMerchantStatus($data){
		$out = $this->helper->post("/merchant/status/update",$data);
		if($this->helper->isRestOk($out)){
			echo json_encode(array("success"=>"true"));
		}else{
			echo json_encode(array("success"=>"false","error_info"=>$out['error_info']));
		}
	}

	//获取商户和门店映射列表
	public function getMerchantShopMapping($data){
		$out = $this->helper->get("/merchant/shop/mapping",$data);
		$result = array();
		if($this->helper->isRestOk($out)){
			$result['data'] = $out['data'];
		}else{
			$result['error_info'] = $out['error_info'];
		}
		return $result;
	}

	//获取商户门店列表
	public function getShopList($cond){
		$out = $this->helper->get("/shop/list",$cond);
		$result = array();
		if($this->helper->isRestOk($out)){
			$result['data'] = $out['data'];
		}else{
			$result['error_info'] = $out['error_info'];
		}
		return $result;
	}

	//添加商户的门店
	public function addMerchantShopMapping($data){
		$out = $this->helper->post("/merchant/shop/mapping/add",$data);

		if($this->helper->isRestOk($out)){
			echo json_encode(array("success"=>"true"));
		}else{
			echo json_encode(array("success"=>"false","error_info"=>$out['error_info']));
		}
	}

	//删除用户门店
	public function removeMerchantShopMapping($data){
		$out = $this->helper->post("/merchant/shop/mapping/remove",$data);

		if($this->helper->isRestOk($out)){
			echo json_encode(array("success"=>"true"));
		}else{
			echo json_encode(array("success"=>"false","error_info"=>$out['error_info']));
		}
	}

	//获取商户覆盖区域
	public function getMerchantDistricts($cond){
		$out = $this->helper->get("/merchant/district/list",$cond);

		if($this->helper->isRestOk($out)){
			echo json_encode(array("success"=>"true","district_list"=>$out['data']));
		}else{
			echo json_encode(array("success"=>"false","error_info"=>$out['error_info']));
		}
	}

	//获取已选的区域
	public function getCheckedMerchantDistrict($cond){

		$out = $this->helper->get("/merchant/district/checked",$cond);
		if($this->helper->isRestOk($out)){
			echo json_encode(array("success"=>"true","district_list"=>$out['data']));
		}else{
			echo json_encode(array("success"=>"false","error_info"=>$out['error_info']));
		}
	}
	//获取选中的id
	public function getCurrentMerchantDistrict($cond){

		$out = $this->helper->get("/merchant/district/current",$cond);
		if($this->helper->isRestOk($out)){
			echo json_encode(array("success"=>"true","district_list"=>$out['data']));
		}else{
			echo json_encode(array("success"=>"false","error_info"=>$out['error_info']));
		}
	}

	//更新商户覆盖区域
	public function updateMerchantDistrict($data){
		$out = $this->helper->post("/merchant/district/update",$data);
		if($this->helper->isRestOk($out)){
			echo json_encode(array("success"=>"true"));
		}else{
			echo json_encode(array("success"=>"false","error_info"=>$out['error_info']));
		}
	}
}