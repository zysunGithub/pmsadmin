<?php 
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 
// 处理订单相关的逻辑 为 订单控制器服务 
class Productsupplier extends CI_Model
{
    private $CI  ;
    private $helper;
	private $statusMap;
    function __construct(){
    	 parent::__construct();
    	 if(!isset($this->CI)){
            $this->CI = & get_instance();
        }
         if(!isset($this->helper)){
           $this->CI->load->library('Helper'); 
           $this->helper = $this->CI->helper;
        }
		$this->statusMap = array('未审核','审核成功','审核失败');
     }

	public function getStatusMap()
	{
		return $this->statusMap;
	}

     public function shownProductSupplierList($cond,$offset,$limit) {
     	if(empty($cond)){
     		$cond = array();
     	}
     	$cond['offset'] = $offset;
     	$cond['size'] = $limit;
     	$out =  $this->helper->get("/product/supplier/list",$cond);
     	$result = array();
     	if($this->helper->isRestOk($out)){
     		$result['data'] = $out['data'];
     	}else{
     		$result['error_info'] = $out['error_info'];
     	}
     	return $result;
     }
     
     public function editProductSupplier($data){
     	$out =  $this->helper->post("/product/supplier/modify",$data);
     	if($this->helper->isRestOk($out)){
     		echo json_encode(array("success"=>"true"));
     	}else{
     		echo json_encode(array("success"=>"false","error_info"=>$out['error_info']));
     	}
     }
     
     public function createProductSupplier($data){
  
     	$out =  $this->helper->post("/product/supplier",$data);
     	if($this->helper->isRestOk($out)){
     		echo json_encode(array("success"=>"true"));
     	}else{
     		echo json_encode(array("success"=>"false","error_info"=>$out['error_info']));
     	}
     }
     
     //获取发票类型列表
     public function getProductCategoryList($cond){
     
     	$out =  $this->helper->get("/product/productcategory/list",$cond);
     	$result = array();
     	
     	//$result['data'] ="hello";
     	if($this->helper->isRestOk($out)){
     		$result['data'] = $out['data'];
     	}else{
     		$result['error_info'] = $out['error_info'];
     	}
     	return $result;
     }
     //获取发票税率列表
     public function getTaxRateList($cond){
     	 
     	$out =  $this->helper->get("/product/taxrate/list",$cond);
     	$result = array();
     	
     	//$result['data'] ="hello3";
     	if($this->helper->isRestOk($out)){
     		$result['data'] = $out['data'];
     	}else{
     		$result['error_info'] = $out['error_info'];
     	}
     	return $result;
     }

	public function getDeductionRateList()
	{
		$out = $this->helper->get("/product/deductionrate/list");
		$result = array();
		if ($this->helper->isRestOk($out)){
			$result['data'] = $out['data'];
		} else {
			$result['error_info'] = $out['error_info'];
		}
		return $result;
	}

	public function getSupplierProductTaxMap()
	{
		$out = $this->helper->get('/map/supplierproducttax/list');
		$result = array();
		if ($this->helper->isRestOk($out)){
			$result['data'] = $out['data'];
		} else {
			$result['error_info'] = $out['error_info'];
		}
		return $result;
	}
     
     //获取商品和供应商映射表
     public function getSupplierProductMappingList($cond){
     	 
     	$out =  $this->helper->get("/product/supplier/map",$cond);
     	$result = array();
     
     	if($this->helper->isRestOk($out)){
     		$result['data'] = $out['data'];
     	}else{
     		$result['error_info'] = $out['error_info'];
     	}
     	return $result;
     }
     
     public function addSupplierProductMapping($data){
     
     	$out =  $this->helper->post("/product/supplier/taxrate",$data);
     	if($this->helper->isRestOk($out)){
     		echo json_encode(array("success"=>"true"));
     	}else{
     		echo json_encode(array("success"=>"false","error_info"=>$out['error_info']));
     	}
     }
     //删除供应商的某个商品
     public function delSupplierProductMapping($data){
       
	     $out =  $this->helper->post("/product/supplier/taxrate/delete",$data);
	     if($this->helper->isRestOk($out)){
			echo json_encode(array("success"=>"true"));
	     }else{
			echo json_encode(array("success"=>"false","error_info"=>$out['error_info']));
	     }
     }
     
     public function updateSupplierStatus($data){
     	$out =  $this->helper->post("/supplier/status/update",$data);
     	if($this->helper->isRestOk($out)){
     		echo json_encode(array("success"=>"true"));
     	}else{
     		echo json_encode(array("success"=>"false","error_info"=>$out['error_info']));
     	}
     }

	public function examine($id, $status)
	{
		$out = $this->helper->get("/product/taxrate/examine/$id/$status");
		if ($this->helper->isRestOk($out)) {
			echo json_encode(array("success"=>"true"));
		} else {
			echo json_encode(array("success"=>"false","error_info"=>$out['error_info']));
		}
	}

	public function modifyandcheck($id, $productCategory, $taxRate, $deductionRate,$checked)
	{
		$out = $this->helper->get("/product/taxrate/modifyandcheck/$id/$productCategory/$taxRate/$deductionRate/$checked");
		if ($this->helper->isRestOk($out)) {
			echo json_encode(array('success' => 'true'));
		} else {
			echo json_encode(array('success'=> 'false','error_info'=>$out['error_info']));
		}
	}
}