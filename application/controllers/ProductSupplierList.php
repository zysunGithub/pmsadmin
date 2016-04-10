<?php
/*
 * It is used for the Web Controller, extending CIController.
 * The name of the class must have first Character as Capital.
 *
**/
class ProductSupplierList extends CI_Controller {
	function __construct()
	{
		parent::__construct();
   	    $this->load->library('RestApi'); 
        $this->load->library('Pager'); 
        $this->load->library('Helper');
        $this->load->library('upload');
        $this->load->helper(array('form','url'));
        $this->load->model('Productsupplier');
        $this->load->model('Purchase');
        $this->helper->chechActionList(array('productSupplier'),true);
	}
	
	public function getProductTypeList(){
		$product_type_list =  array();
		if($this->helper->chechActionList(array('caigouManager'))) {
			$item['product_type'] = 'goods';
			$item['product_type_name'] = '商品';
			$product_type_list[] = $item;
		}
		if($this->helper->chechActionList(array('suppliesCaigouManager'))) {
			$item['product_type'] = 'supplies';
			$item['product_type_name'] = '耗材';
			$product_type_list[] = $item;
		}
			
		return $product_type_list;
	}
	
	public function index() {  
        $cond = $this->getQueryCondition();
        $cond['upload_path'] = $this->upload->upload_path;
        if(!empty($cond['error']) && $cond['error'] = 'error'){
        	echo $cond['error_info'];
        	return;
        }
        $product_type_list = $this->getProductTypeList();
        if(empty($product_type_list)) {
        	die("无权限");
        }
        if(empty($cond['product_type'])) {
        	$cond['product_type'] = $product_type_list[0]['product_type'];
        } 
       	
        $out = $this->Purchase->getProductSupplierList($cond);
		$taxRate = $this->getTaxRate();
		$deductionRate = $this->getDeductionRateList();
		$productCategory = $this->getProductCategory();
		$cond['tax_rate_list'] = $taxRate['data']['tax_rate_list'];
		$cond['deduction_rate_list'] = $deductionRate['data'];
        $cond['product_type_list'] = $product_type_list;
		$cond['product_category_list'] = $productCategory['data']['product_category_list'];
        $cond['product_supplier_list'] = $out['product_supplier_list'];
		$cond['statusMap'] = $this->Productsupplier->getStatusMap();
	  	$data = $this->helper->merge($cond);
	  	$this->load->view('product_supplier_list',$data);
	}
	
	private function getQueryCondition( ){
		$cond = array( );
		
		$product_supplier_id = $this->getInput("product_supplier_id");
		if(isset($product_supplier_id)) {
			$cond['product_supplier_id'] = $product_supplier_id;
		}

		$start_time = $this->getInput('start_time');
		if(isset($start_time)) {
			$cond['start_time'] = $start_time;
		} 
	
		$end_time = $this->getInput('end_time');
		if(isset($end_time)){
			$cond['end_time'] = $end_time;
		}
		
		$created_user = $this->getInput('created_user');
		if(isset($created_user)) {
			$cond['created_user'] = $created_user;
		}
		
		$product_supplier_name = $this->getInput('product_supplier_name');
		if(isset($product_supplier_name)) {
			$cond['product_supplier_name'] = $product_supplier_name;
		}
		
		$product_type = $this->getInput('product_type');
		if (!empty($product_type)) {
			//echo $product_type;
			$cond['product_type'] = $product_type;
		}
		$search_supplier_type = $this->getInput('search_supplier_type');
		if(!empty($search_supplier_type)) {
			$cond['search_supplier_type'] = $search_supplier_type;
		}
		$search_status = $this->getInput('search_status');
		if(isset($search_status)) {
			$cond['search_status'] = $search_status;
		}
		$tax_rate_examine = $this->getInput('tax_rate_examine');
		if (isset($tax_rate_examine)) {
			$cond['tax_rate_examine'] = $tax_rate_examine;
		}
		return $cond;
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
		$name = $this->getInput('product_supplier_name');
		if(!empty($name)){
			$data['product_supplier_name'] = trim($name);
		}
		$id = $this->getInput('product_supplier_id');
		if(!empty($id)){
			$data['product_supplier_id'] = trim($id);
		}
		$product_type = $this->getInput('product_type');
		if(!empty($product_type)) {
			$data['product_type'] = $product_type;
		}
		$attr = $this->getInput('supplier_type');
		if(!empty($attr)) {
			$data['supplier_type'] = $attr;
		}
		$address = $this->getInput('product_supplier_address');
		if(!empty($address)) {
			$data['product_supplier_address'] = $address;
		}else 
			$data['product_supplier_address'] = "";
		$contact_name = $this->getInput('supplier_contact_name');
		if(!empty($contact_name)) {
			$data['supplier_contact_name'] = $contact_name;
		}else 
			$data['supplier_contact_name'] = "";
		$contact_mobile = $this->getInput('supplier_contact_mobile');
		if(!empty($contact_mobile)) {
			$data['supplier_contact_mobile'] = $contact_mobile;
		}else 
			$data['supplier_contact_mobile'] = "";
		$bank = $this->getInput('opening_bank');
		if(!empty($bank)) {
			$data['opening_bank'] = $bank;
		}else 
			$data['opening_bank'] = "";
		$account = $this->getInput('bank_account');
		if(!empty($account)) {
			$data['bank_account'] = $account;
		}else
			$data['bank_account'] = "";
		$account = $this->getInput('bank_account_name');
		if(!empty($account)) {
			$data['bank_account_name'] = $account;
		}else
			$data['bank_account_name'] = "";
		$cycle = $this->getInput('payment_cycle');
		if(!empty($cycle)) {
			$data['payment_cycle'] = $cycle;
		}else 
			$data['payment_cycle'] = "";
		$level = $this->getInput('supplier_level');
		if(!empty($level)) {
			$data['supplier_level'] = $level;
		}else 
			$data['supplier_level'] = "1";
		
		$note = $this->getInput('note');
		if(!empty($note)){
			$data['note'] = trim($note);
		}
		
		return $data;
	}

	private function getTaxPostData(){
		$data = array();
		$id = $this->getInput('product_supplier_id');
		if(!empty($id)){
			$data['product_supplier_id'] = trim($id);
		}
		$product_category = $this->getInput('product_category');
		if(!empty($product_category)) {
			$data['product_category'] = $product_category;
		}
		$tax = $this->getInput('tax_rate');
		if(!empty($tax)) {
			$data['tax_rate'] = $tax;
		}
		$product = $this->getInput('product_array');
		if(!empty($product)) {
			$data['product_array'] = $product;
		}else
			$data['product_array'] = "";
		//$data['product_array'] = array("1","2","3");
		return $data;
	}
	
	
	public function getProductCategory(){
		$data = "";
		$result = $this->Productsupplier->getProductCategoryList($data);
		
		return $result;
	}
	//编辑供应商
	public function getTaxRate(){
		$data = "";
		$result = $this->Productsupplier->getTaxRateList($data);
		//die($result["data"]["tax_rate_list"][0]["tax_rate"]);
		
		return $result;
	}

	public function getDeductionRateList()
	{
		return $this->Productsupplier->getDeductionRateList();
	}
	
	//获取商品和供应商映射表
	public function getSupplierProductMappingList(){
		$data = array();
		if (func_num_args()!=1){
			$data['product_supplier_id'] = $this->getInput('product_supplier_id');
		}else{
			$data['product_supplier_id'] = func_get_arg(0);
			$result = $this->Productsupplier->getSupplierProductMappingList($data);
			return $result["data"]["mapping_list"];
		}
		
		$result = $this->Productsupplier->getSupplierProductMappingList($data);
		if(!isset($result['error_info'])){
			echo json_encode( array( 'success'=>'success', 'mapping_list' => $result["data"]["mapping_list"]));
		} else {
			echo json_encode( array( 'success' => 'fail','error_info'=>'服务器内部错误' ) );
		}
		//die($result["data"]["mapping_list"][0]["product_name"]);
	}
	//增加商品税率记录
	public function addSupplierProductMapping(){
		//$data = $this->getTaxPostData();
		$data = $this->getAddSupplierProductPostData();
		//die(json_encode($data));
		$this->Productsupplier->addSupplierProductMapping($data);
	}
	//获取 新增加商品税率记录
	private function getAddSupplierProductPostData(){
		$data = array();
		$id = $this->getInput('product_supplier_id');
		if(!empty($id)){
			$data['product_supplier_id'] = trim($id);
		}
		$product_category = $this->getInput('product_category');
		if(!empty($product_category)) {
			$data['product_category'] = $product_category;
		}
		$tax = $this->getInput('tax_rate');
		if(!empty($tax)) {
			$data['tax_rate'] = $tax;
		}
		$deduction_rate = $this->getInput('deduction_rate');
		if (!empty($deduction_rate)) {
			$data['deduction_rate'] = $deduction_rate;
		}
		$product_id = $this->getInput('product_id');
		if(!empty($product_id)) {
			$data['product_id'] = trim($product_id);
		}
		return $data;
	}
	//删除商品税率记录
	public function delSupplierProductMapping(){
		$data = $this->getDelSupplierProductPostData();
		$this->Productsupplier->delSupplierProductMapping($data);
	}
	//获取所要删除商品税率记录
	private function getDelSupplierProductPostData(){
		$data = array();
		$id = $this->getInput('product_supplier_id');
		if(!empty($id)){
			$data['product_supplier_id'] = trim($id);
		}
		$product_id = $this->getInput('product_id');
		if(!empty($product_id)) {
			$data['product_id'] = trim($product_id);
		}
		return $data;
	}

	//用于文本和图片的同时上传
	public function addNewSupplier(){
		$unrequired = '未选择上传文件';
		$data = $this->getPostData();
		
		if(!empty($data['error_info'])) {
			echo json_encode( array( 'error_info'=>$data['error_info']));
			return;
		}
		$img = array();
		if ( !$this->upload->do_upload('business_license')) {
			if(!strstr($this->upload->display_errors(), $unrequired)){
				$data['business_license']="";
			}
		} else {
			$img_data = $this->upload->data();
			$data['business_license'] = $img_data['file_name'];
		}
		$out = $this->Productsupplier->createProductSupplier($data);
		

	}
	
	public function editSupplier(){
		$unrequired = '未选择上传文件';
		$data = $this->getPostData();
		
		if(!empty($data['error_info'])) {
			echo json_encode( array( 'error_info'=>$data['error_info']));
			return;
		}
		$img = array();
		if ( !$this->upload->do_upload('business_license')) {
			if(!strstr($this->upload->display_errors(), $unrequired)){
				$data['business_license']="";
			}
		} else {
			$img_data = $this->upload->data();
			$data['business_license'] = $img_data['file_name'];
		}
		$out = $this->Productsupplier->editProductSupplier($data);

	}
	//用于更改供应商的状态
	public function updateSupplierStatus(){
		$data['product_supplier_id'] = $this->getInput('product_supplier_id');
		$data['enabled'] = $this->getInput('enabled');
		
		$this->Productsupplier->updateSupplierStatus($data);
	}
	//增加新的供应商
	public function newIndex(){
		$cond = array();
		$this->helper->chechActionList(array('productSupplierAdd'),true);
		// url?goods_apply_id=12,判断有无档案商品申请goods_apply_id传过来值

		$product_type_list = $this->getProductTypeList();
		if(empty($product_type_list)) {
			die("无权限");
		}
		$cond['product_type_list'] = $product_type_list;
	
		$data = $this->helper->merge($cond);
		$this->load->view('product_supplier_new',$data);
	}
	
	//编辑供应商
	public function editIndex(){
		$cond = array();
		$this->helper->chechActionList(array('productSupplierEdit'),true);
		// url?goods_apply_id=12,判断有无档案商品申请goods_apply_id传过来值

		$product_type_list = $this->getProductTypeList();
		if(empty($product_type_list)) {
			die("无权限");
		}
			
		$cond = $this->getQueryCondition();
		if(!empty($cond['error']) && $cond['error'] = 'error'){
			echo $cond['error_info'];
			return;
		}
		$out = $this->Purchase->getProductSupplierList($cond);
		$cond['product_type_list'] = $product_type_list;
		$supplierProductTaxMap = $this->Productsupplier->getSupplierProductTaxMap();
		$cond['supplier_product_tax_map'] = isset($supplierProductTaxMap['data'])?$supplierProductTaxMap['data']:array();
		
		$tax_rate_list = $this->getTaxRate();
		$cond['tax_rate_list'] = $tax_rate_list["data"]["tax_rate_list"];
		$product_category_list = $this->getProductCategory();
		$cond['product_category_list'] = $product_category_list["data"]["product_category_list"];
		$deduction_rate_list = $this->getDeductionRateList();
		$cond['deduction_rate_list'] = $deduction_rate_list['data'];
		$cond['upload_path'] = $this->upload->upload_path;
		if($this->helper->isRestOk($out)) {
			$cond['product_supplier'] = $out['product_supplier_list'][0];
		} else {
			$con['error_info'] = $out['error_info'];
		}
		
		$cond['SupplierProductMappingList']= $this->getSupplierProductMappingList($cond['product_supplier']["product_supplier_id"]);
		$cond['statusMap'] = $this->Productsupplier->getStatusMap();
		$data = $this->helper->merge($cond);
		$this->load->view('product_supplier_edit',$data);
	}

	/**
	 * 对税率进行审核
	 */
	public function examine()
	{
		$status = $this->getInput('status');
		$id = intval($this->getInput('id'));
		if ($status == 'checked' || $status == 'failed') {
			$out = $this->Productsupplier->examine($id, $status);
		} else {
			echo json_encode(array('success'=>'false','error' => 'invalid operation'));
			return;
		}
		return $out;
	}

	public function modifyandcheck()
	{
		$taxRate = $this->getInput('tax_rate');
		$deductionRate = $this->getInput('deduction_rate');
		$productCategory = $this->getInput('product_category');
		$id = $this->getInput('id');
		$checked = $this->getInput('checked');
		$checked = !empty($checked) && $checked=='true'? 'true' : 'false';
		return $this->Productsupplier->modifyandcheck($id, $productCategory, $taxRate, $deductionRate, $checked);
	}

}
?>
