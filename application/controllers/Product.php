<?php

class Product extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->library('Helper');
		$this->load->model('productmodel');
		$this->load->model('shippingmodel');
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
    
	public function index() {
		$cond = array();
		$this->helper->chechActionList(array('product'),true);
		$product_type_list = $this->getProductTypeList();
		if(empty($product_type_list)) {
			die("无产品档案权限");
		}
		$cond['product_type_list'] = $product_type_list;
		$data = $this->helper->merge($cond);
		$this->load->view('product_list',$data);
	}

	private function getQueryCondition(){
		$cond = array();
		$product_type = $this->getInput('product_type');
		if(isset($product_type) && trim($product_type) != ""){
			$cond['product_type'] = $product_type;
		} 
		$product_sub_type = $this->getInput('product_sub_type');
		if(isset($product_sub_type) && trim($product_sub_type) != ""){
			$cond['product_sub_type'] = $product_sub_type;
		}
		$product_name = $this->getInput('product_name');
		if(isset($product_name) && trim($product_name) != ""){
			$cond['product_name'] = $product_name;
		}
		$product_status = $this->getInput('product_status');
		if(isset($product_status) && trim($product_status) != ""){
			$cond['product_status'] = $product_status;
		}
		$product_id = $this->getInput('product_id');
		if(isset($product_id)) {
			$cond['product_id'] = $product_id;
		}
		return $cond;
	}
	
	public function query(){
		$cond = $this->getQueryCondition();
		$product_type_list = $this->getProductTypeList();
		if(empty($product_type_list)) {
			die("无产品档案权限");
		}
		
		$out = $this->productmodel->getProductList($cond);
		
		if($this->helper->isRestOk($out)){
  			$cond['product_list'] = $out['product_list'];
  		}
  		$cond['product_type_list'] = $product_type_list;
		$data = $this->helper->merge($cond);
		$this->load->view('product_list',$data);
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
	
    public function getFacilityShippingList($params=null){
        $this->helper->chechActionList(array('productEdit'),true);
        $out = $this->productmodel->getFacilityShippingList($params);
        if(!$this->helper->isRestOk($out)){
            die('获取仓库快递信息失败');
        }
        if(!empty($out['prodcut_facility_shipping_mapping'])){
            $facility_shipping_list = $this->handleFacilityShippingList($out['prodcut_facility_shipping_mapping']);
            return $facility_shipping_list;
        }
        return;
    }

    private function handleFacilityShippingList($out){
        $result = array();
        foreach($out as $value) {
          $result[$value['facility_id']]['facility_id'] = $value['facility_id'];
          $result[$value['facility_id']]['facility_name'] = $value['facility_name'];
          $result[$value['facility_id']]['merchant_id'] = $value['merchant_id'];
          if(isset($value['checked_facility']) && $value['checked_facility']){
            $result[$value['facility_id']]['checked_facility'] = 1;
          }
          $shipping = $value;
          $shipping['checked_shipping_id'] = isset($value['checked_shipping_id']) ? $value['checked_shipping_id'] : 0;
          unset($shipping['facility_id']);
          unset($shipping['facility_name']);
          $result[$value['facility_id']]['shipping'][] = $shipping;
          unset($shipping);
        }
        return $result;
    }

    private function checkProductId($params){//检测是否有product_id
        if(!empty($params['product_id'])){
            return true;
        }else {
            return false;
        }
    }

	public function checkProductStatus()
	{
		$this->helper->chechActionList( array('productCheck'),true);
		$product_id = $this->getInput('product_id');
		if( isset( $product_id )) {
			$cond['product_id'] = $product_id;
			$cond['product_status'] = 'OK';
			$out = $this->productmodel->checkProductStatus($cond);
			if($this->helper->isRestOk($out)) {
				echo json_encode( array('success'=>'success'));
				return;
			} else {
				echo json_encode( array( 'success' => 'fail','error_info'=>!empty($out['error_info'])?$out['error_info']:'服务器内部错误' ) );
				return;
			}
		}
		echo json_encode( array( 'success' => 'fail','error_info'=>'未知产品' ));
		
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
		if( isset( $product_status ) && $product_status == 'INIT' )
		{
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
        $facility_shipping_list = $this->getInput("facility_shipping_list");
        if(isset($facility_shipping_list)){
            $cond['facility_shipping_list'] = $facility_shipping_list;
        }

        $quality = $this->getInput('quality');
        if(isset($quality)){
            $cond['quality'] = $quality;
        }

        $price = $this->getInput('price');
        if(isset($price)){
            $cond['price'] = $price;
        }

        $unreachable = $this->getInput('unreachable');
        if(isset($unreachable)){
            $cond['unreachable'] = $unreachable;
        }

        $aftersale_rate = $this->getInput('aftersale_rate');
        if(isset($aftersale_rate)){
            $cond['aftersale_rate'] = $aftersale_rate;
        }

        $timeliness = $this->getInput('timeliness');
        if(isset($timeliness)){
            $cond['timeliness'] = $timeliness;
        }

        $use_best_shipping = $this->getInput('use_best_shipping');
        if(isset($use_best_shipping)){
            $cond['use_best_shipping'] = $use_best_shipping;
        }
        $facilitys = $this->input->post('facilitys');
        if(isset($facilitys)){
            $cond['facilitys'] = $facilitys;
        }
		return $cond;
	}
	
	public function getPurchasingUserList(){
		$out = $this->productmodel->getPurchasingUserList();
		if($this->helper->isRestOk($out)){
			echo json_encode( array( 'success'=>'success', 'purchasing_user_list' => $out['user_list']));
		} else {
			echo json_encode( array( 'success' => 'fail','error_info'=>!empty($out)?$out:'服务器内部错误' ) );
		}
	}
	
	public function getGoodsListByMerchant() {
		$merchant_id = $this->getInput('merchant_id');
		$out = $this->productmodel->goodsApplyList(array('merchant_id' => $merchant_id));
		if($this->helper->isRestOk($out)) {
			echo json_encode( array( 'success'=>'success', 'merchant_goods_list' => $out['data']));
		} else {
			echo json_encode( array( 'success' => 'fail','error_info'=>!empty($out['error_info'])?$out['error_info']:'服务器内部错误' ) );
		}
	}
	
	public function getProductFinishedList(){
		$cond = array();
		$cond['product_type'] = 'supplies';
		$cond['product_sub_type'] = 'finished';
		$out = $this->productmodel->getProductList($cond);
		if($this->helper->isRestOk($out)) {
			echo json_encode( array( 'success'=>'success', 'mapping_supplies_finished_list' => $out['product_list']));
		} else {
			echo json_encode( array( 'success' => 'fail','error_info'=>!empty($out['error_info'])?$out['error_info']:'服务器内部错误' ) );
		}
	}
	
	public function getProductList(){
		$cond = array();
		$product_type = $this->getInput('product_type');
		if(isset($product_type)) {
			$cond['product_type'] = $this->getInput('product_type');
		}
		$product_sub_type = $this->getInput('product_sub_type');
		if(isset($product_sub_type)) {
			$cond['product_sub_type'] = $product_sub_type;
		}
		
		$product_status = $this->getInput('product_status');
		if(isset($product_status)) {
			$cond['product_status'] = $product_status;
		}
		
		$out = $this->productmodel->getProductList($cond);
		if($this->helper->isRestOk($out)) {
			echo json_encode( array( 'res'=>'success', 'product_list' => $out['product_list']));
		} else {
			echo json_encode( array( 'res' => 'fail','error_info'=>!empty($out['error_info'])?$out['error_info']:'服务器内部错误' ) );
		}
	}
	
	public function removeProduct(){
		$product_id = $this->getInput("product_id");
		$out = $this->productmodel->removeProduct($product_id);
		if($this->helper->isRestOk($out)) {
			echo json_encode(array("success"=>"success"));
		} else {
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
	
	// 从get或post获取数据,优先从post没有返回 null
	private function getInput($name){
		$out = trim($this->input->post($name));
		if(isset($out) && $out!=""){
			return $out;
		}else{
			$out = trim($this->input->get($name));
			if(isset($out) && $out !="") return $out;
		}
		return null;
	}

	//获取商品服务区域的选项(不允许跨区)
	public function getAreaProductDistrict(){
		$id = $this->getInput("product_id");
		$result = "";
		if(!empty($id)){
			$result = $this->productmodel->getAreaProductDistrict($id);
		}
		return $result;
	}

    //获取商品服务区域的选项(允许跨区)
    public function getAllProductDistrict(){
        $id = $this->getInput("product_id");
        $result = "";
        if(!empty($id)){
            $result = $this->productmodel->getAllProductDistrict($id);
        }
        return $result;
    }

	//获取商品当前服务区域
	public function getProductDistrict(){
		$id = $this->getInput("product_id");
		$result = "";
		if(!empty($id)){
			$result = $this->productmodel->getProductDistrict($id);
		}
		return $result;
	}

	//用于获取商户覆盖区域
	public function getDefaultProductDistrict(){
		$product_id = $this->getInput("product_id");
		$result = "";
		if(!empty($product_id)){
			$result = $this->productmodel->getDefaultProductDistrict($product_id);
		}
		return $result;
	}

    //获取格式化的当前覆盖区域
    public function getProductDistrictList(){
        $id = $this->getInput("product_id");
        $result = "";
        if(!empty($id)){
            $result = $this->productmodel->getProductDistrictList($id);
        }
        return $result;
    }
	//用于数据的接收
	private function getDistrictData(){
		$product_id = $this->getInput("product_id");
		if(isset($product_id)){
			$params["product_id"]  = $product_id;
		}

        $params["district_array"]  = $this->input->post("district_array");

        $sync_to_merchant_district = $this->getInput("sync_to_merchant_district");
        if(isset($sync_to_merchant_district)){
            $params["sync_to_merchant_district"]  = $sync_to_merchant_district;
        }

        $cross_regional = $this->getInput("cross_regional");
        if(isset($cross_regional)){
            $params["cross_regional"]  = $cross_regional;
        }
		return $params;
	}

    //添加默认服务区域
    public function addDefaultProductDistrict(){
        $product_id = $this->getInput("product_id");
        $result = $this->productmodel->addDefaultProductDistrict($product_id);
        return $result;
    }
	//更新当前商品服务区域
	public function updateProductDistrict(){
		$params = $this->getDistrictData();
		$result = $this->productmodel->updateProductDistrict($params);
		return $result;
	}

}

?>
