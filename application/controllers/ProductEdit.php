<?php

class ProductEdit extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->library('Helper');
		$this->load->library('Pager');
		$this->load->library('upload');
		$this->load->helper(array('form','url'));
		$this->load->model('productmodel');
		$this->load->model('shippingmodel');
		$this->helper->chechActionList(array('product','goodsProduct'),true);
	}
	
	private function getProductTypeList(){
		$product_type_list =  array();
		if($this->helper->chechActionList(array('goodsManager'))) {
			$item['product_type'] = 'goods';
			$item['product_type_name'] = '商品';
			$product_type_list[] = $item;
		}
		if($this->helper->chechActionList(array('suppliesManager'))) {
			$item['product_type'] = 'supplies';
			$item['product_type_name'] = '耗材';
			$product_type_list[] = $item;
		}
	
		return $product_type_list;
	}
	
    public function index(){
        $cond['upload_path'] = $this->upload->upload_path;
        $product_id = $this->getInput('product_id');
        $product = $this->productmodel->getProductByID($product_id);
        if(key_exists("error_info", $product)){
            echo "获取商品数据失败";
            die();
        }
        if(!empty($product['product']['imgs'])) {
            $supplies_finished_img = json_decode($product['product']['imgs']);
            $cond['supplies_finished_img'] = $supplies_finished_img;
        }
        $cond=array();
        $cond['product'] = $product['product'];
        $cond['merchant_goods_ids'] = $product['merchant_goods_ids'];
        
        $unit_list = $this->getProductUnit(array());
        $cond['unit_list'] = $unit_list;
          
        $data = $this->helper->merge($cond);
        $this->load->view('product_edit',$data);
    }
    
    private function getRemoteData($product){
    	$cond = array();
    	$cond['product_mapping'] = array();
    	$cond['shipping_service_list'] = array();
    	$cond['merchant_list'] = array();
    	$cond['product_shipping'] = array();
    	$cond['specification'] = array();
    	$cond['supplies_raw_material_list'] = array();
    	$cond['product_container_list'] = array();
    	
    	if($product['product_type'] == 'goods') {
    		if($product['product_sub_type'] == 'finished') {
    			$product_mapping = $this->productmodel->getProductMapping($product['product_id'], 'goods2goods');
    			if(key_exists("error_info", $product_mapping)){
    				echo "获取商品数据失败";
    				die();
    			}
    			$cond['product_mapping'] = $product_mapping['product_mapping'];
    			
    			$shipping_service_list = $this->shippingmodel->getShippingService();
    			$cond['shipping_service_list'] = $shipping_service_list;
    			
    			$merchant_list = $this->productmodel->getMerchantList(array());
    			$cond['merchant_list'] = $merchant_list['list'];
    			
    			$product_shipping = $this->productmodel->getProductShipping($product['product_id']);
    			if(!empty($product_shipping['product_shipping'])) {
    				$cond['product_shipping'] = $product_shipping['product_shipping'];
    			}
    		} elseif($product['product_sub_type'] == 'raw_material') {
    			$specification = $this->productmodel->getSpecificationByProduct($product['product_id']);
    			if(key_exists("error_info", $specification)){
    				echo "获取商品数据失败";
    				die();
    			}
    			$cond['specification'] = $specification['specification'];
    		}
    	} else if($product['product_type'] == 'supplies'){
    		if($product['product_sub_type'] == 'finished') {
    			$supplies_raw_material_list = $this->productmodel->getProductMapping($product['product_id'], 'supplies2supplies');
    			if(key_exists("error_info", $supplies_raw_material_list)){
    				echo "获取商品数据失败";
    				die();
    			}
    			$cond['supplies_raw_material_list'] = $supplies_raw_material_list['product_mapping'];
    		} elseif($product['product_sub_type'] == 'raw_material') {
    			$product_container_list = $this->productmodel->getProductContainerList($product['product_id']);
    			if(key_exists("error_info", $product_container_list)){
    				echo "获取商品箱规失败";
    				die();
    			}
    			$cond['product_container_list'] = $product_container_list['product_container_list'];
    		}
    	}
    	return $cond;
    }
    
    public function getRemoteDataAjax(){
    	$product = $this->getEditCond();
    	$cond = array();
    	$cond['product_mapping'] = array();
    	$cond['shipping_service_list'] = array();
    	$cond['platform_list'] = array();
    	$cond['merchant_list'] = array();
    	$cond['product_shipping'] = array();
    	$cond['specification'] = array();
    	$cond['supplies_raw_material_list'] = array();
    	$cond['product_container_list'] = array();
    	 
    	if($product['product_type'] == 'goods') {
    		if($product['product_sub_type'] == 'finished') {
    			$product_mapping = $this->productmodel->getProductMapping($product['product_id'], 'goods2goods');
    			if(key_exists("error_info", $product_mapping)){
    				echo "获取商品数据失败";
    				die();
    			}
    			$cond['product_mapping'] = $product_mapping['product_mapping'];
    			 
    			$shipping_service_list = $this->shippingmodel->getShippingService();
    			$cond['shipping_service_list'] = $shipping_service_list;
    			 
    			$platform_list = $this->productmodel->getPlatformList(array());
    			$cond['platform_list'] = $platform_list['list'];
    			
    			$merchant_list = $this->productmodel->getMerchantList(array());
    			$cond['merchant_list'] = $merchant_list['list'];
    			 
    			$product_shipping = $this->productmodel->getProductShipping($product['product_id']);
    			if(!empty($product_shipping['product_shipping'])) {
    				$cond['product_shipping'] = $product_shipping['product_shipping'];
    			}
    		} elseif($product['product_sub_type'] == 'raw_material') {
    			$specification = $this->productmodel->getSpecificationByProduct($product['product_id']);
    			if(key_exists("error_info", $specification)){
    				echo "获取商品数据失败";
    				die();
    			}
    			$cond['specification'] = $specification['specification'];
    		}
    	} else if($product['product_type'] == 'supplies'){
    		if($product['product_sub_type'] == 'finished') {
    			$supplies_raw_material_list = $this->productmodel->getProductMapping($product['product_id'], 'supplies2supplies');
    			if(key_exists("error_info", $supplies_raw_material_list)){
    				echo "获取商品数据失败";
    				die();
    			}
    			$cond['supplies_raw_material_list'] = $supplies_raw_material_list['product_mapping'];
    		} elseif($product['product_sub_type'] == 'raw_material') {
    			$product_container_list = $this->productmodel->getProductContainerList($product['product_id']);
    			if(key_exists("error_info", $product_container_list)){
    				echo "获取商品箱规失败";
    				die();
    			}
    			$cond['product_container_list'] = $product_container_list['product_container_list'];
    		}
    	}
    	echo json_encode(array("success"=>"success","res"=>$cond));
    }
    
    public function editProduct(){
    	$this->helper->chechActionList(array('productEdit'),true);
    	$cond = $this->getEditCond();
    	$unrequired = 'You did not select a file to upload.';
    	if(!empty($cond['error_info'])) {
    		echo json_encode( array( 'error_info'=>$cond['error_info']));
    		return;
    	}
    	$img = array();
    	if ( !$this->upload->do_upload('img1')) {
    		if(!strstr($this->upload->display_errors(), $unrequired)){
    			echo json_encode( array( 'error_info'=>$this->upload->display_errors()));
    			return;
    		}
    	} else {
    		$data1 = $this->upload->data();
    		$img[] = $data1['file_name'];
    	}
    
    	if ( !$this->upload->do_upload('img2')) {
    		if(!strstr($this->upload->display_errors(), $unrequired)){
    			echo json_encode( array( 'error_info'=>$this->upload->display_errors()));
    			return;
    		}
    	} else {
    		$data2 = $this->upload->data();
    		$img[] = $data2['file_name'];
    	}
    
    	if ( !$this->upload->do_upload('img3')) {
    		if(!strstr($this->upload->display_errors(), $unrequired)){
    			echo json_encode( array( 'error_info'=>$this->upload->display_errors()));
    			return;
    		}
    	} else {
    		$data3 = $this->upload->data();
    		$img[] = $data3['file_name'];
    	}
    
    	if ( !$this->upload->do_upload('img4')) {
    		if(!strstr($this->upload->display_errors(), $unrequired)){
    			echo json_encode( array( 'error_info'=>$this->upload->display_errors()));
    			return;
    		}
    	} else {
    		$data4 = $this->upload->data();
    		$img[] = $data4['file_name'];
    	}
    
    	if ( !$this->upload->do_upload('img5')) {
    		if(!strstr($this->upload->display_errors(), $unrequired)){
    			echo json_encode( array( 'error_info'=>$this->upload->display_errors()));
    			return;
    		}
    	} else {
    		$data5 = $this->upload->data();
    		$img[] = $data5['file_name'];
    	}
    	foreach ($cond['imgPath'] as $item) {
    		if(!empty($item)) {
    			$img[] = $item;
    		}
    	}
    	if(!empty($img)) {
    		$cond['supplies_finished_img'] = json_encode($img);
    	}
    	$out = $this->productmodel->editProduct($cond);
    	if($this->helper->isRestOk($out)) {
    		echo json_encode( array('success'=>'success'));
    	} else{
    		echo json_encode( array( 'success' => 'fail','error_info'=>!empty($out['error_info'])?$out['error_info']:'服务器内部错误' ) );
    	}
    }
    
    private function getEditCond(){
    	$cond = array();
    	$product_id = $this->getInput('product_id');
    	$cond['product_id'] = $product_id;
    
    	$product_desc = $this->getInput('product_desc');
    	if(!empty($product_desc)) {
    		$cond['product_desc'] = $product_desc;
    	}
    
    	$note = $this->input->post('note');
    	if(isset($note)) {
    		$cond['note'] = $note;
    	}
    
    	$producing_region = $this->getInput('producing_region');
    	if(!empty($producing_region)) {
    		$cond['producing_region'] = $producing_region;
    	}
    	
    	$product_type = $this->getInput('product_type');
    	if(!empty($product_type)) {
    		$cond['product_type'] = $product_type;
    	}
    	
    	$product_sub_type = $this->getInput('product_sub_type');
    	if(!empty($product_sub_type)) {
    		$cond['product_sub_type'] = $product_sub_type;
    	}
    
    	$purchasing_cycle = $this->getInput('purchasing_cycle');
    	if(!empty($purchasing_cycle)) {
    		$cond['purchasing_cycle'] = $purchasing_cycle;
    	}
    
    	$shipping_service_id = $this->getInput('shipping_service_id');
    	if(!empty($shipping_service_id)) {
    		$cond['shipping_service_id'] = $shipping_service_id;
    	}
    
    	$secrect_code = $this->getInput('secrect_code');
    	if(!empty($secrect_code)){
    		$cond['secrect_code'] = $secrect_code;
    	}
    
    	$merchant_goods_ids = $this->input->post('merchant_goods_ids');
    	if(!empty($merchant_goods_ids)) {
    		$cond['merchant_goods_ids'] = $merchant_goods_ids;
    	}
    
    	$pre_selection = $this->getInput('pre_selection');
    	if(!empty($pre_selection)) {
    		$cond['pre_selection'] = $pre_selection;
    	}
    
    	$net_weight_min = $this->getInput('net_weight_min');
    	if(!empty($net_weight_min)) {
    		$cond['net_weight_min'] = $net_weight_min;
    	}
    
    	$net_weight_max = $this->getInput('net_weight_max');
    	if(!empty($net_weight_max)) {
    		$cond['net_weight_max'] = $net_weight_max;
    	}
    
    	$valid_days = $this->getInput('valid_days');
    	if(!empty($valid_days)) {
    		$cond['valid_days'] = $valid_days;
    	}
    
    	$supplies_finished_ids = $this->input->post('supplies_finished_ids');
    	if(!empty($supplies_finished_ids)) {
    		$cond['supplies_finished_ids'] = $supplies_finished_ids;
    	}
    
    	$length = $this->getInput('length');
    	if(!empty($length)) {
    		$cond['length'] = $length;
    	}
    
    	$width = $this->getInput('width');
    	if(!empty($width)) {
    		$cond['width'] = $width;
    	}
    
    	$height = $this->getInput('height');
    	if(!empty($height)) {
    		$cond['height'] = $height;
    	}
    
    	$receiving_standard = $this->getInput("receiving_standard");
    	if(!empty($receiving_standard)) {
    		$cond['receiving_standard'] = $receiving_standard;
    	}
    
    	$receiving_exception_handling = $this->getInput("receiving_exception_handling");
    	if(!empty($receiving_exception_handling)) {
    		$cond['receiving_exception_handling'] = $receiving_exception_handling;
    	}
    
    	$storage_temperature = $this->getInput("storage_temperature");
    	if(!empty($storage_temperature)) {
    		$cond['storage_temperature'] = $storage_temperature;
    	}
    
    	$storage_days = $this->getInput("storage_days");
    	if(!empty($storage_days)) {
    		$cond['storage_days'] = $storage_days;
    	}
    
    	$storage_notes = $this->getInput("storage_notes");
    	if(!empty($storage_notes)) {
    		$cond['storage_notes'] = $storage_notes;
    	}
    
    	$defective_standard = $this->getInput("defective_standard");
    	if(!empty($defective_standard)) {
    		$cond['defective_standard'] = $defective_standard;
    	}
    
    	$bad_standard = $this->getInput("bad_standard");
    	if(!empty($bad_standard)) {
    		$cond['bad_standard'] = $bad_standard;
    	}
    
    	$defective_handing = $this->getInput("defective_handing");
    	if(!empty($defective_handing)) {
    		$cond['defective_handing'] = $defective_handing;
    	}
    
    	$specification = $this->getInput("specification");
    	if(!empty($specification)) {
    		$cond['specification'] = $specification;
    	}
    
    	$imgPath = $this->input->post('imgPath[]');
    	if(!empty($imgPath)) {
    		$cond['imgPath'] = $imgPath;
    	}
    
    	$product_status = $this->input->post( 'product_status' );
    	if( isset( $product_status ) && $product_status == 'INIT' ) {
    		$cond['product_status'] = $product_status;
    		//商品原料 1 2 3
    		$product_name = $this->input->post( 'product_name' );//1
    		if( !empty( $product_name ))
    			$cond['product_name'] = $product_name;
    		$unit_code = $this->input->post( 'unit_code' );//2
    		if( !empty( $unit_code ))
    			$cond['unit_code'] = $unit_code;
    		$purchase_unit_code = $this->input->post( 'purchase_unit_code' );//2
    		if( !empty( $purchase_unit_code )){
    			$cond['purchase_unit_code'] = $purchase_unit_code;
    		}
    		$sale_unit_code = $this->input->post( 'sale_unit_code' );//2
    		if( !empty( $sale_unit_code )){
    			$cond['sale_unit_code'] = $sale_unit_code;
    		}
    		$unit_code_name = $this->input->post( 'unit_code_name' );//3
    		if( !empty( $unit_code_name ))
    			$cond['unit_code_name'] = $unit_code_name;
    		//商品成品 1 3
    		$merchant_id = $this->input->post( 'merchant_id' );//4
    		if( !empty( $merchant_id ))
    			$cond['merchant_id'] = $merchant_id;
    		//耗材原料 1 4 5 6
    		$container_unit_code = $this->input->post( 'container_unit_code' );//5
    		if( !empty( $container_unit_code))
    			$cond['container_unit_code'] = $container_unit_code;
    		$container_unit_code_name = $this->getInput('container_unit_code_name');//6
    		if(!empty($container_unit_code_name))
    			$cond['container_unit_code_name'] = $container_unit_code_name;
    		$supplies_container_quantity = $this->input->post( 'supplies_container_quantity' );//7
    		if( !empty( $supplies_container_quantity ))
    			$cond['supplies_container_quantity'] = $supplies_container_quantity;
    
    		$supplies_unit_code = $this->input->post( 'supplies_unit_code' ); //8
    		if( !empty( $supplies_unit_code ))
    			$cond['supplies_unit_code'] = $supplies_unit_code;
    		$supplies_unit_code_name = $this->input->post( 'supplies_unit_code_name' );//9
    		if( !empty( $supplies_unit_code_name ))
    			$cond['supplies_unit_code_name'] = $supplies_unit_code_name;
    		$product_goods_mapping_id = $this->input->post( 'product_goods_mapping_id' );
    		if( !empty( $product_goods_mapping_id ))
    		{
    			$product_goods_mapping_id_arr = explode(",", $product_goods_mapping_id);
    			$cond['product_goods_mapping_id'] = $product_goods_mapping_id_arr;
    		}
    		//add 1
    		$product_component_ids = $this->input->post( 'product_component_ids' );
    		if( !empty( $product_component_ids ))
    			$cond['product_component_ids'] = $product_component_ids;
    		$product_component_quantitys = $this->input->post( 'product_component_quantitys' );
    		if( !empty( $product_component_quantitys ))
    			$cond['product_component_quantitys'] = $product_component_quantitys;
    		//remove 1
    		$product_component_id = $this->input->post( 'product_component_id' );
    		if( !empty( $product_component_id ))
    		{
    			$product_component_id_arr = explode(",", $product_component_id);
    			$cond['product_component_id'] = $product_component_id_arr;
    		}
    		//add 2
    		$product_supplies_ids = $this->input->post( 'product_supplies_ids' );
    		if( !empty( $product_supplies_ids ))
    			$cond['product_supplies_ids'] = $product_supplies_ids;
    		$supplies_quantitys = $this->input->post( 'supplies_quantitys' );
    		if( !empty( $supplies_quantitys ))
    			$cond['supplies_quantitys'] = $supplies_quantitys;
    		//remove 2
    		$product_supplies_id = $this->input->post( 'product_supplies_id' );
    		if( !empty( $product_supplies_id ))
    		{
    			$product_supplies_id_arr = explode(",", $product_supplies_id);
    			$cond['product_supplies_id'] = $product_supplies_id_arr;
    		}
    	}
    
    	return $cond;
    }
    
    public function getFacilityShippingListByProduct() {
    	$product_id = $this->getInput('product_id');
    	$facility_shipping_list_and_checked = $this->productmodel->getFacilityShippingListByProduct($product_id);
    	echo json_encode( array("list" => $facility_shipping_list_and_checked['facility_shipping_list'],"checked_list"=>$facility_shipping_list_and_checked["checked_facility_shipping_list"]));
    }

    public function setProductFacilityShippingMapping() {
    	$mappings = $this->input->post('mappings');
    	$product_id = $this->getInput('product_id');
    	$params['product_id'] = $product_id;
    	$params['mappings'] = $mappings;
    	$out = $this->productmodel->setProductFacilityShippingMapping($params);
    	if($this->helper->isRestOk($out)) {
			echo json_encode(array("success"=>"success"));
		} else {
			echo json_encode( array( 'success' => 'fail','error_info'=>!empty($out['error_info'])?$out['error_info']:'服务器内部错误' ) );
		}
    }
    
    public function setDeliveryFacilityType() {
		$product_id = $this->getInput('product_id');
		$delivery_facility_type = $this->getInput('delivery_facility_type');
		$params['product_id'] = $product_id;
		$params['delivery_facility_type'] = $delivery_facility_type;
		$out = $this->productmodel->setDeliveryFacilityType($params);
		if($this->helper->isRestOk($out)) {
			echo json_encode(array("success"=>"true"));
		} else {
			echo json_encode( array( 'success' => 'fail','error_info'=>!empty($out['error_info'])?$out['error_info']:'服务器内部错误' ) );
		}
    }
    
    private function getSetProductShippingCond() {
    	$cond['product_id'] = $this->getInput('product_id');
    	$cond['use_best_shipping'] = $this->getInput('use_best_shipping');
    	$cond['quality'] = $this->getInput('quality');
    	$cond['price'] = $this->getInput('price');
    	$cond['unreachable'] = $this->getInput('unreachable');
    	$cond['aftersale_rate'] = $this->getInput('aftersale_rate');
    	$cond['timeliness'] = $this->getInput('timeliness');
    	return $cond;
    }
    
    public function setProductShipping() {
    	$cond = $this->getSetProductShippingCond();
    	$out = $this->productmodel->setProductShipping($cond);
    	if($this->helper->isRestOk($out)) {
    		echo json_encode(array("success"=>"success"));
    	} else {
    		echo json_encode( array( 'success' => 'fail','error_info'=>!empty($out['error_info'])?$out['error_info']:'服务器内部错误' ) );
    	}
    }
    
    public function productPackagingBatchUpdate(){
    	$packagings = $this->input->post('packagings');
    	$cond['packagings'] = $packagings;
    	$out = $this->productmodel->productPackagingBatchUpdate($cond);
    	if($this->helper->isRestOk($out)) {
    		echo json_encode(array("res"=>"success"));
    	} else {
    		echo json_encode( array( 'res' => 'fail','error_info'=>!empty($out['error_info'])?$out['error_info']:'服务器内部错误' ) );
    	}
    }
    
    public function getSkuRegionShippingList(){
    	$product_id = $this->getInput('product_id');
    	$out = $this->productmodel->getSkuRegionShippingList($product_id);
    	echo json_encode($out);
    }
    
    public function getSkuRegionShippingDetail() {
    	$facility_id = $this->getInput('facility_id');
    	$product_id = $this->getInput('product_id');
    	$shipping_id = $this->getInput('shipping_id');
    	$out = $this->productmodel->getSkuRegionShippingDetail($facility_id,$product_id,$shipping_id);
    	echo json_encode($out);
    }   
    public function setSkuRegionShipping(){
    	$data = array();
    	$data['facility_id'] = $this->getInput('facility_id');
    	$data['product_id'] = $this->getInput('product_id');
    	$data['shipping_id'] = $this->getInput('shipping_id');
    	$temp = $this->input->post("district_ids");
    	if(is_array($temp) && count($temp)>0){
    		$data['district_ids'] = implode(',',$temp);
    	}
    
    	$out = $this->productmodel->setSkuRegionShipping($data);
    	echo json_encode($out);
    }
    
    private function getProductUnit($params){
    	$out = $this->productmodel->getProductUnit($params);
    	if($this->helper->isRestOk($out)) {
    		return $this->handleProductUnitList($out['data']);
    	}
    }
    
    private function handleProductUnitList($data){
    	$result = array();
    	foreach ($data as $key => $val) {
    		$result[$val['product_type']][$val['unit_code_type']][] = array('unit_code'=>$val['unit_code'],'unit_code_name'=>$val['unit_code_name']);
    	}
    	return $result;
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
