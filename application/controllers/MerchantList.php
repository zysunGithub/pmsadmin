<?php
/*
 * It is used for the Web Controller, extending CIController.
 * The name of the class must have first Character as Capital.
 *
**/
class MerchantList extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->library('RestApi');
		$this->load->library('Pager');
		$this->load->library('Helper');
		$this->load->library('upload');
		$this->load->helper(array('form','url'));
		$this->load->model('Merchantmodel');
	}

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

	private function getPostData(){
		$data = array();

		$id = $this->getInput('merchant_id');
		if(!empty($id)){
			$data['merchant_id'] = trim($id);
		}
		
		$pId = $this->getInput('platform_id');
		if(!empty($pId)){
			$data['platform_id'] = trim($pId);
		}

		$name = $this->getInput('merchant_name');
		if(!empty($name)){
			$data['merchant_name'] = trim($name);
		}

		$type = $this->getInput('merchant_type');
		if(!empty($type)){
			$data['merchant_type'] = trim($type);
		}

		$area = $this->getInput('area_id');
		if(!empty($area)){
			$data['area_id'] = trim($area);
		}

		$status= $this->getInput('enabled');
		if(isset($status)){
			$data['enabled'] = trim($status);
		}

		$sid = $this->getInput('shop_id');
		if(!empty($sid)){
			$data['shop_id'] = trim($sid);
		}

		$district = $this->getInput('district_id');
		if(!empty($district)){
			$data['district_id'] = trim($district);
		}

		return $data;
	}

	//商户列表获取
	public function getMerchantList(){

		$data = array();

		$id = $this->getInput('merchant_id');
		if(!empty($id)){
			$data['merchant_id'] = trim($id);
		}
		
		$result = $this->Merchantmodel->getMerchantList($data);
		return $result;
	}
	//商户所属平台获取
	public function getPlatformList(){
	
		$data = array();
	
		$id = $this->getInput('platform_id');
		if(!empty($id)){
			$data['platform_id'] = trim($id);
		}
	
		$out = $this->Merchantmodel->getPlatformList($data);
		if($this->helper->isRestOk($out)) {
			echo json_encode( array('success'=>'success',"platform_list"=>$out['list']));
		} else{
			echo json_encode( array( 'success' => 'fail','error_info'=>!empty($out['error_info'])?$out['error_info']:'服务器内部错误' ) );
		}
	}

	//增加商户
	public function addMerchant(){
		$data = $this->getPostData();
		$this->Merchantmodel->addMerchant($data);
	}

	//编辑商户信息
	public function editMerchant(){
		$data = $this->getPostData();
		$out=$this->Merchantmodel->editMerchant($data);
		if($this->helper->isRestOk($out)){
			echo json_encode(array("success"=>"true","shop_select"=>$out['data']));
		}else{
			echo json_encode(array("success"=>"false","error_info"=>$out['error_info']));
		}
	}

	//商户状态更新
	public function updateMerchantStatus(){
		$data = $this->getPostData();
		$this->Merchantmodel->updateMerchantStatus($data);
	}

	//获取商户门店映射列表
	public function getMerchantShopMapping(){
		$data = array();
		$id = $this->getInput('merchant_id');
		if(!empty($id)){
			$data['merchant_id'] = trim($id);
		}
		
		$result = $this->Merchantmodel->getMerchantShopMapping($data);
		return $result;
	}

	//添加商户门店
	public function addMerchantShopMapping(){
		//?merchant_id=88&shop_id=9
		$data = $this->getPostData();
		$this->Merchantmodel->addMerchantShopMapping($data);
	}

	//删除商户门店
	public function removeMerchantShopMapping(){
		$data = $this->getPostData();
		$this->Merchantmodel->removeMerchantShopMapping($data);
	}

	//获取商户门店列表
	public function getShopList($cond=""){
		$result = $this->Merchantmodel->getShopList($cond);
		return $result;
	}

	//获取商户覆盖区域列表
	public function getMerchantDistrictList(){
		$data['merchant_id'] = $this->getInput("merchant_id");
		$this->Merchantmodel->getMerchantDistricts($data); 
	}

	//获取已选商户覆盖区域
	public function getCheckedMerchantDistrict(){
		$data['merchant_id'] = $this->getInput("merchant_id");
		$this->Merchantmodel->getCheckedMerchantDistrict($data);
	}

	//获取选中的id
	public function getCurrentMerchantDistrict(){
		$data['merchant_id'] = $this->getInput("merchant_id");
		$this->Merchantmodel->getCurrentMerchantDistrict($data);
	}

	//更新商户覆盖区域
	/*	{
   	 		"merchant_id":"7",
    		"districts":["3318","3319","3320"] 
		}
	*/
	public function updateMerchantDistrict(){
		$merchant_id = $this->getInput('merchant_id');
    	$districts = $this->input->post("districts");
    	$cond['merchant_id'] = $merchant_id;		
		$cond['districts'] = $districts;
		$this->Merchantmodel->updateMerchantDistrict($cond);

	}

	public function index(){
		$result = array();
		$shop_array = $this->getShopList();
		$result["shop_list"] = $shop_array['data'];

		$merchant_array = $this->getMerchantList();
		$result["merchant_list"] = $merchant_array['data'];
		$result["shops"] = $merchant_array['shop'];

		$data = $this->helper->merge($result);
		$this->load->view('merchant_list',$data);

	}

	public function editIndex(){
		$result = array();

		$platform_list = $this->Merchantmodel->getPlatformList(array());
		$result["platform_list"]=$platform_list['list'];

		$shop_array = $this->getMerchantShopMapping();
		$result["shop_list"] = $shop_array['data'];

		$merchant = $this->getMerchantList();
		$result["merchant_list"] = $merchant['data'];
		
		$shops = $this->getShopList(array("platform_id"=>$merchant['data'][0]['platform_id']));

		$result["shop_select"] = $shops['data'];

		$data = $this->helper->merge($result);
		$this->load->view('merchant_edit',$data);

	}
}