<?php
/*
 * It is used for the Web Controller, extending CIController.
 * The name of the class must have first Character as Capital.
 *
**/
class LaunchTransferInventoryList extends CI_Controller {
	function __construct()
	{
		parent::__construct();
	  	$this->load->library('session'); 
    	$this->load->library('Pager');
	    $this->load->library('Helper'); 
	    $this->load->library('Excel'); 
		$this->load->model('common');
		$this->load->model('productmodel');  
		$this->load->model('transferinventory');
		$this->load->model('inventoryTransaction');
		$this->helper->chechActionList(array('launchTransferInventoryList', 'transferOut'),true);
	}
	
  public function index() {
    $this->helper->chechActionList(array('wuliaoManager', 'transferManager'),true);
    $this->showIndex('goods');
  }

  public function suppliesIndex() {
    $this->helper->chechActionList(array('suppliesTransferManager'),true);
    $this->showIndex('supplies');
  }
	public function showIndex($product_type) {
      	$temp_cond = array();
      	$temp_cond['exclude_virtual'] = 1;
      	if($product_type == 'goods') {
      		$user_facility_list = $this->common->getFacilityList();
      	} elseif ($product_type == 'supplies') {
      		$user_facility_list = $this->common->getFacilityList($temp_cond);
      	}
      	$facility_list = $this->helper->get("/admin/allfacilities", $temp_cond);
      	$facility_list = $facility_list['facility_list'];
		
	  	$cond = $this->getQueryCondition($user_facility_list);   // 获取查询条件 下面需要把条件传递到前端 
	  	$cond['product_type'] = $product_type;
      	if(isset($cond['error']) && $cond['error'] == 'error') {
	  		echo $cond['error_info'];
	  		return;
	  	}      
     	$offset = (intval($cond['page_current'])-1)*intval($cond['page_limit']);
      	$limit = $cond['page_limit'];
	  	$out = $this->transferinventory->getTransferInventoryList($cond,$offset,$limit);
	  	$cond['facility_list'] = $facility_list;
	  	$cond['user_facility_list'] = $user_facility_list['data'];
	  	if(!isset($out['data'])){  // 调用 api 出现错误
	  		$con['error_info'] = $out['error_info'];
	  	}else{  //  调用 API 成功
	  		$transferInventoryList =  $out['data']['transfer_inventory_list'] ;
	  		$cond['item_list'] = $transferInventoryList;
	  		// 分页
	  		$record_total = $out['data']['total'];
	  		$page_count = $cond['page_current']+3;
	  		if( count($transferInventoryList) < $limit ){
	  			$page_count = $cond['page_current'];
	  		}
	  		if(!empty($record_total)){
	  			$cond['record_total'] = $record_total;
	  			$page_count = ceil($record_total / $limit );
	  		}
	  		$cond['page_count'] = $page_count;
	  		$cond['page'] = $this->pager->getPagerHtml($cond['page_current'],$page_count);
	  	}
      
      if($cond['product_type'] == "goods"){
        $cond['product_type_name'] = "商品";
      }else {
        $cond['product_type_name'] = "耗材";
      }
	  	$data = $this->helper->merge($cond);
	  	$this->load->view('launch_transfer_inventory_list',$data);
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

   // 获取前端 post 传递过来的查询条件
   private function getQueryCondition($user_facility_list){
      $cond = array( );

      $from_facility_id = $this->getInput('from_facility_id');
      if( isset($from_facility_id)) {
      	$cond['from_facility_id'] = $from_facility_id;
      } else {
      	$cond['from_facility_id'] = $user_facility_list['data'][0]['facility_id'];
      }
      
      $to_facility_id = $this->getInput('to_facility_id');
      if( isset($to_facility_id)) {
      	$cond['to_facility_id'] = $to_facility_id;
      }
      
      $start_time = $this->getInput('start_time');
      if( isset($start_time)) {
      	$cond['start_time'] = $start_time;
      } else{
      	$cond['start_time'] = date('Y-m-d 06:00:00');
      }
      
      $end_time = $this->getInput('end_time');
      if( isset($end_time)) {
      	$cond['end_time'] = $end_time;
      } 
      
      $process_status = $this->getInput('process_status');
      if (isset($process_status)) {
      	$cond['process_status'] = $process_status;
      }
      
      $ti_sn = $this->getInput('ti_sn');
      if( isset($ti_sn)) {
      	$cond['ti_sn'] = $ti_sn;
      }
      
      $product_name = $this->getInput('product_name');
      if( isset($product_name)) {
      	$cond['product_name'] = $product_name;
      }
      
      $product_id = $this->getInput('product_id');
      if( isset($product_id)) {
      	$cond['product_id'] = $product_id;
      }
      
      $page_current = $this->getInput('page_current');
      if(!empty($page_current)) {
        $cond['page_current'] = $page_current;
      }else{
        $cond['page_current'] = 1;
      }
      $page_limit = $this->getInput('page_limit');    
      if(!empty($page_limit)) {
        $cond['page_limit'] = $page_limit;
      }else{
        $cond['page_limit'] = 10;
      }
      return $cond;
   }
   
   public function addTransferInventory(){
   		$cond = $this->getAddCondition();
   		if(!empty($cond['error_info'])){
   			echo json_encode( array( "success" => 'fail','error_info'=> $cond['error_info'] ) );
   			return;
   		}
   		$out = $this->transferinventory->addTransferInventory($cond);
   		if($out == 'success'){
   			echo json_encode( array( "success" => 'success' ) );
   		} else {
   			echo json_encode( array( "success" => 'fail','error_info'=>!empty($out)?$out:'服务器内部错误' ) );
   		}
   }
   
   private function getAddCondition(){
   		$cond = array();
	   	$note = $this->getInput('note');
	   	if( isset($note)) {
	   		$cond['note'] = $note;
	   	} else{
	   		$cond['note'] = '';
	   	}
	   	$from_facility_id = $this->getInput('from_facility_id');
	   	if( isset($from_facility_id)) {
	   		$cond['from_facility_id'] = $from_facility_id;
	   	} else {
	   		$cond['error_info'] = '出库仓库不能为空';
	   	}
	   	
	   	$to_facility_id = $this->getInput('to_facility_id');
	   	if( isset($to_facility_id)) {
	   		$cond['to_facility_id'] = $to_facility_id;
	   	} else {
	   		$cond['error_info'] = '出库仓库不能为空';
	   	}
	   	
	   	$ti_items = $this->input->post('ti_items');
	   	if(isset($ti_items)) {
	   		$cond['ti_items'] = $ti_items;
	   	} else {
	   		$cond['error_info'] = '商品不能为空';
	   	}

      $product_type = $this->input->post('product_type');
      if(isset($product_type)) {
        $cond['product_type'] = $product_type;
      } else {
        $cond['product_type'] = 'goods';
      }
	   	
	   	return $cond;
   }
   
   public function remove(){
   		$ti_id = $this->getInput('ti_id');
   		$out = $this->transferinventory->removeTransferInventory($ti_id);
   		if($out == 'success'){
   			echo json_encode( array( "success" => 'success' ) );
   		} else {
   			echo json_encode( array( "success" => 'fail','error_info'=>!empty($out)?$out:'服务器内部错误' ) );
   		}
   }
   
   public function detail(){
   		$ti_id = $this->getInput('ti_id');
   		$out = $this->transferinventory->getItemList($ti_id);
   		if($this->helper->isRestOk($out)) {
   			echo json_encode( array( "success" => 'success','item_list'=>$out['item_list'] ) );
   		} else {
   			echo json_encode( array( "success" => 'fail','error_info'=>!empty($out['error_info'])?$out['error_info']:'服务器内部错误' ) );
   		}
   }
   
   public function getCanSaleProductList(){
	   	$cond = array();
	   	$facility_id = $this->getInput('facility_id');
      	$product_type = $this->getInput('product_type');
	   	$cond['facility_id'] = $facility_id;
	   	$cond['product_type'] = $product_type;
	   	$out = $this->inventoryTransaction->getCanSaleProductList($cond);
	   	if(empty($out['error_info']))
	   		echo json_encode( array("success" => 'success',"product_list"=> $out['data']['product_list']));
	   	else
	   		echo json_encode( array("success"=>'fail'));
   }

    public function goodsDetailIndex() {
        $this->helper->chechActionList(array('wuliaoManager', 'transferManager'),true);
        $this->detail_list('goods');
    }
    public function suppliesDetailIndex(){
       $this->helper->chechActionList(array('suppliesTransferManager'),true);
        $this->detail_list('supplies');
    }  
   private function detail_list($product_type) {
   		$facility_list = $this->helper->get("/admin/allfacilities"); 
		$user_facility_list = $this->common->getFacilityList();
	  	$cond = $this->getQueryCondition($user_facility_list);   // 获取查询条件 下面需要把条件传递到前端 
        if (isset($product_type)) {
            $cond['product_type'] = $product_type;
        }else{
            $cond['product_type'] = 'goods';
        }
	  	if(isset($cond['error']) && $cond['error'] == 'error') {
	  		echo $cond['error_info'];
	  		return;
	  	}
	  	if ($this->getInput('act') == "download") {
	  		$out = $this->transferinventory->getTransferInventoryDetailList($cond,0,8000);
	  		$this->exportExcel($out);
	  		return ;
	  	}
     	$offset = (intval($cond['page_current'])-1)*intval($cond['page_limit']);
      	$limit = $cond['page_limit'];
	  	$out = $this->transferinventory->getTransferInventoryDetailList($cond,$offset,$limit);
	  	$cond['facility_list'] = $facility_list['facility_list'];
	  	$cond['user_facility_list'] = $user_facility_list['data'];
	  	if(!isset($out['data'])){  // 调用 api 出现错误
	  		$con['error_info'] = $out['error_info'];
	  	}else{  //  调用 API 成功
	  		$transferInventoryList =  $out['data']['transfer_inventory_list'] ;
	  		$cond['item_list'] = $transferInventoryList;
	  		// 分页
	  		$record_total = $out['data']['total'];
	  		$page_count = $cond['page_current']+3;
	  		if( count($transferInventoryList) < $limit ){
	  			$page_count = $cond['page_current'];
	  		}
	  		if(!empty($record_total)){
	  			$cond['record_total'] = $record_total;
	  			$page_count = ceil($record_total / $limit );
	  		}
	  		$cond['page_count'] = $page_count;
	  		$cond['page'] = $this->pager->getPagerHtml($cond['page_current'],$page_count);
	  	}
	  	$data = $this->helper->merge($cond);
        //var_dump($data);die();
	  	$this->load->view('launch_transfer_inventory_detail_list',$data);
   }
   
   private function exportExcel($out){
   	
  	$head = array(
  		'出库仓库',
        '入库仓库',
        '调拨批次',
        '状态',
        '商品',
        '箱规',
        '供应商',
        '装车批次',
        '六联单',
        '车牌号',
        '司机电话',
        '司机名字',
        '车队',
        '车型',
        '创建时间',
        '装车时间',
        '入库时间',
        '计划调拨数量',
        '装车数量',
        '入库数量',
        '盘亏数量',
        '追回数量',
        '差异',
        '备注',);
  	$body = array();
  	if(isset($out['data'])){
  		$orders = $out['data']['transfer_inventory_list'];
  		foreach ($orders as $key => $order) {
  			$body[$key][] = $order['from_facility_name'];
			$body[$key][] = $order['to_facility_name'];
			$body[$key][] = $order['ti_sn'];
			$body[$key][] = $order['inventory_status'] == "FINISH" ? "已入库" : "未入库";
			$body[$key][] = $order['product_name'];
			$body[$key][] = $order['container_quantity'] .  $order['unit_code'] . "/箱";
			$body[$key][] = $order['product_supplier_name'];
			$body[$key][] = $order['bol_sn'];
            $body[$key][] = $order['invoice_no'];
			$body[$key][] = $order['car_num'];
			$body[$key][] = $order['driver_mobile'];
			$body[$key][] = $order['driver_name'];
            $body[$key][] = $order['car_provider'];
            $body[$key][] = $order['car_model'];
			$body[$key][] = $order['ti_created_time'];
			$body[$key][] = $order['bol_created_time'];
			$body[$key][] = $order['finish_time'];
			$body[$key][] = $order['plan_case_num'];
			$body[$key][] = $order['from_quantity'];
			$body[$key][] = $order['to_quantity'];
			$body[$key][] = $order['variance_quantity'];
			$body[$key][] = $order['return_quantity'];
			$body[$key][] = $order['transit_quantity'];
			$body[$key][] = $order['note'];
  	
  		}
  	}
	$this->download($head,$body,"调拨明细列表");
  }
  
   // 导出 excel 
    private function download($head,$body,$fileName){
        $excel =  $this->excel;
        $excel->addHeader($head);
        $excel->addBody( $body);
        $excel->downLoad($fileName);
    }

   public function getProductListBysubTypes(){
   		$cond['product_type'] = $this->getInput('product_type');
       	$cond['product_sub_type'] = 'raw_material';
       	$cond['product_status'] = 'OK';
       	$out = $this->productmodel->getProductList($cond);
       	if($this->helper->isRestOk($out)) {
       		echo json_encode( array( 'success'=>'success', 'product_list' => $out['product_list']));
       	} else {
       		echo json_encode( array( 'success' => 'fail','error_info'=>!empty($out)?$out:'服务器内部错误' ) );
        }
   }
}
?>
