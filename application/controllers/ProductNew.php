<?php

class ProductNew extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->library('Helper');
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
		$cond = array();
		$this->helper->chechActionList(array('productEdit'),true);
        $goods_apply_id = $this->getInput("goods_apply_id");
        if (isset($goods_apply_id)) {
            $params['goods_apply_id'] = $goods_apply_id;
            $goods_product_list = $this->productmodel->goodsApply($params);
            $cond['goods_product_list'] = $goods_product_list['data'];
        }
		$product_type_list = $this->getProductTypeList();
		if(empty($product_type_list)) {
			die("无耗材档案管理菜单,商品档案管理菜单权限");
		}
		$cond['product_type_list'] = $product_type_list;
		
		$product_type = $this->getInput('product_type');
		if(isset($product_type)){
			$cond['product_type'] = $product_type;
		}
		$merchant_list = $this->productmodel->getMerchantList(array());
		$cond['merchant_list'] = $merchant_list['list'];
		$platform_list = $this->productmodel->getPlatformList(array());
		$cond['platform_list'] = $platform_list['list'];
		$shipping_service_list = $this->shippingmodel->getShippingService();
		$cond['shipping_service_list'] = $shipping_service_list;

		if(!isset($cond['product_type']) && count($product_type_list) == 1) {
			foreach ($product_type_list as $key=>$product_type) {
				$cond['product_type'] = $key;
			}
		}
		
        $unit_list = $this->getProductUnit(array());
        $cond['unit_list'] = $unit_list;
        $data = $this->helper->merge($cond);
		$this->load->view('product_new',$data);
	}
	
	private function getAddCond(){
		$cond = array();
		$product_name = $this->getInput('product_name');
		$cond['product_name'] = $product_name;
		
		$product_type = $this->getInput('product_type');
		$cond['product_type'] = $product_type;
		
		$product_sub_type = $this->getInput('product_sub_type');
		if(!empty($product_sub_type)) {
			$cond['product_sub_type'] = $product_sub_type;
		}
		
		$platform_id = $this->getInput('platform_id');
		if(!empty($platform_id)) {
			$cond['platform_id'] = $platform_id;
		} 
		
		$product_desc = $this->getInput('product_desc');
		if(!empty($product_desc)) {
			$cond['product_desc'] = $product_desc;
		} 
		
		$note = $this->getInput('note');
		if(!empty($note)) {
			$cond['note'] = $note;
		}
		
		$producing_region = $this->getInput('producing_region');
		if(!empty($producing_region)) {
			$cond['producing_region'] = $producing_region;
		}
		
		$unit_code = $this->getInput('unit_code');
		if(!empty($unit_code)) {
			$cond['unit_code'] = $unit_code;
		}
		
        $purchase_unit_code = $this->getInput('purchase_unit_code');
        if(!empty($purchase_unit_code)) {
            $cond['purchase_unit_code'] = $purchase_unit_code;
        }

        $sale_unit_code = $this->getInput('sale_unit_code');
        if(!empty($sale_unit_code)) {
            $cond['sale_unit_code'] = $sale_unit_code;
        }

		$unit_code_name = $this->getInput('unit_code_name');
		if(!empty($unit_code_name)) {
			$cond['unit_code_name'] = $unit_code_name;
		}
		
		$supplies_unit_code = $this->getInput('supplies_unit_code');
		if(!empty($supplies_unit_code)) {
			$cond['supplies_unit_code'] = $supplies_unit_code;
		}
		
		$supplies_unit_code_name = $this->getInput('supplies_unit_code_name');
		if(!empty($supplies_unit_code_name)) {
			$cond['supplies_unit_code_name'] = $supplies_unit_code_name;
		}
		
		$container_unit_code = $this->getInput('container_unit_code');
		if(!empty($container_unit_code)) {
			$cond['container_unit_code'] = $container_unit_code;
		}
		
		$container_unit_code_name = $this->getInput('container_unit_code_name');
		if(!empty($container_unit_code_name)) {
			$cond['container_unit_code_name'] = $container_unit_code_name;
		}
		
		$secrect_code = $this->getInput('secrect_code');
		if(!empty($secrect_code)){
			$cond['secrect_code'] = $secrect_code;
		}
		
		$merchant_id = $this->getInput('merchant_id');
		if(!empty($merchant_id)) {
			$cond['merchant_id'] = $merchant_id;
		}
		
		$pre_selection = $this->getInput('pre_selection');
		if(!empty($pre_selection)) {
			$cond['pre_selection'] = $pre_selection;
		}

		$product_component_ids = $this->input->post('product_component_ids');
		if(!empty($product_component_ids)) {
			$cond['product_component_ids'] = $product_component_ids;
		}
		
		$product_component_quantitys = $this->input->post('product_component_quantitys');
		if(!empty($product_component_quantitys)) {
			$cond['product_component_quantitys'] = $product_component_quantitys;
		}
		
		$mapping_supplies_finished_ids = $this->input->post('mapping_supplies_finished_ids');
		if(!empty($mapping_supplies_finished_ids)) {
			$cond['mapping_supplies_finished_ids'] = $mapping_supplies_finished_ids;
		}
		$parent_product_id = $this->getInput('parent_product_id');
		if(!empty($parent_product_id)) {
			$cond['parent_product_id'] = $parent_product_id;
		}
		
		$shipping_service_id = $this->getInput('shipping_service_id');
		if(!empty($shipping_service_id)) {
			$cond['shipping_service_id'] = $shipping_service_id;
		}
		
		$merchant_goods_ids = $this->input->post('merchant_goods_ids');
		if(!empty($merchant_goods_ids)) {
			$cond['merchant_goods_ids'] = $merchant_goods_ids;
		}
		
		$purchasing_cycle = $this->getInput('purchasing_cycle');
		if(!empty($purchasing_cycle)) {
			$cond['purchasing_cycle'] = $purchasing_cycle;
		}
		
		$length = $this->getInput("length");
		if(!empty($length)) {
			$cond['length'] = $length;
		}
		
		$width = $this->getInput('width');
		if(!empty($width)){
			$cond['width'] = $width;
		}
		
		$height = $this->getInput('height');
		if(!empty($height)){
			$cond['height'] = $height;
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
		if( !empty( $valid_days ) ) {
			$cond['valid_days'] = $valid_days;
		}

		$supplies_container_quantity = $this->getInput('supplies_container_quantity');
		if(!empty($supplies_container_quantity)) {
			$cond['supplies_container_quantity'] = $supplies_container_quantity;
		}
		
		$product_supplies_ids = $this->input->post("product_supplies_ids");
		if(!empty($product_supplies_ids)) {
			$cond['product_supplies_ids'] = $product_supplies_ids;
		} 
		 
		$product_supplies_names = $this->input->post("product_supplies_names");
		if(!empty($product_supplies_names)) {
			$cond['product_supplies_names'] = $product_supplies_names;
		} 
		 
		$supplies_quantitys = $this->input->post("supplies_quantitys");
		if(!empty($supplies_quantitys)) {
			$cond['supplies_quantitys'] = $supplies_quantitys;
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

		return $cond;
	}
	public function getMerchantListByPlatform(){
		$product_id = $this->getInput('platform_id');
		$out = $this->productmodel->getMerchantList(array('platform_id'=>$product_id));
		if($this->helper->isRestOk($out)) {
			echo json_encode(array('success'=>'success','platform_merchant_list'=>$out['list']));
		} else{
			echo json_encode( array( 'success' => 'fail','error_info'=>!empty($out['error_info'])?$out['error_info']:'服务器内部错误' ) );
		}
	}
	public function addNewProduct(){
		$unrequired = 'You did not select a file to upload.';
		$cond = $this->getAddCond();
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
		if(!empty($img)) {
			$cond['supplies_finished_img'] = json_encode($img);
		}
		$out = $this->productmodel->addProduct($cond);
		if($this->helper->isRestOk($out)) {
            echo json_encode(array('success'=>'success'));
		} else{
			echo json_encode( array( 'success' => 'fail','error_info'=>!empty($out['error_info'])?$out['error_info']:'服务器内部错误' ) );
		}
	}
	
    private function getProductUnit($params){
        $out = $this->productmodel->getProductUnit($params);
        if($this->helper->isRestOk($out)) {
            $res = $this->handleProductUnitList($out['data']);
            return $res;
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
