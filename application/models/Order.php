<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

// 处理订单相关的逻辑 为 订单控制器服务 
class Order extends CI_Model {

    private $CI  ;
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
   
  
  /**
   *  按查询条件取得待打单列表
   *   每个订单中 包含多个商品 
   * @param  [type] $cond   [查询条件数组]
   * @param  [type] $offset [分页中 第 $offset 条记录 ]
   * @param  [type] $limit  [分页中 每页大小 ]
   * @return [type]         [description]
   */
  public function getOrderPrintList($cond){
    if(empty($cond)){
      $cond = array(); 
    }
    $out =  $this->helper->get("/print/print_orders",$cond); 
    $result = array();  
    if($this->helper->isRestOk($out)){
    	$result['data'] = $out;
    }else{
    	$result['error_info'] = $out['error_info'];
    }
    return $result; 
  }
  
  /**
  *  打单
  * @param  [type] $order_id [订单 id 号 ]
  * @return [type]           [description]
  */
 public function printOrder($order_id, $tracking_number = null){
    $out = $this->helper->post("/print/print_orders"."/".$order_id, array("tracking_number"=>$tracking_number));
    $result = array(); 
    if( $this->helper->isRestOk($out) ){
    	$result['data'] = $out['order'];
    }else {
        $result['error_info'] = $out['error_info']; 
    }
    return $result; 
  }

  public function getOrderCountResult($fields){
  	$out = $this->helper->get("/admin/orders/order_count",$fields);
  	if($this->helper->isRestOk($out)){
  		$result['data'] = $out;
  	}else{
  		$result['error_info'] = $out['error_info'];
  	}
  	return $result;
  }  

  public function getDeliverCountResult($cond,$offset,$limit){
    $cond['offset'] = $offset;
    $cond['size'] = $limit;
    $out = $this->helper->get("/shipment/orderCount",$cond);
    if($this->helper->isRestOk($out)){
      $result['success'] = 'success';
      $result['data'] = $out['data'];
    }else{
      $result['error_info'] = $out['error_info'];
    }
    return $result;
  }
  //获取成团统计数据
  public function getConfirmDeliverCountResult($cond,$offset,$limit){
    $cond['offset'] = $offset;
    $cond['size'] = $limit;
    $out = $this->helper->get("/shipment/confirmOrderCount",$cond);
    if($this->helper->isRestOk($out)){
        $result['success'] = 'success';
        $result['data'] = $out['data'];
    }else{
        $result['error_info'] = $out['error_info'];
    }
    return $result;
  }

}

  