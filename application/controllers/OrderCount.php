<?php
/**
 * Created by PhpStorm.
 * User: hutaojie-22
 * Date: 2015/6/30
 * Time: 11:09
 */

class OrderCount extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->library('session');
        $this->load->library('Excel');
        $this->load->library('Pager');
        $this->load->model('order');
        $this->load->model('common');
        $this->helper->chechActionList(array('orderCount'),true);
    }
    
    // 从 get 或 post 获取数据 优先从 post 没有返回 null
    private function getInput($name){
    	$out = $this->input->post($name);
    	if(is_array($out)){
    		$out = implode(',', $out );
    	} else {
    		$out = trim( $out );
    	}
    
    	if(isset($out) && $out!=""){
    		return $out;
    	}else{
    		$out = trim($this->input->get($name));
    		if(isset($out) && $out !="") return $out;
    	}
    	return null;
    }

    public function index(){
        $cur_date = date('Y-m-d',time());
        $area_id = $this->getInput('area_id');
       	$facility_id = $this->getInput('facility_id');		//从前台获取下拉框输入
        $fields['cur_date'] = $cur_date;
        $fields['area_id'] = $area_id;
        $fields['facility_id'] = $facility_id;
        
        $facility_list = $this->common->getFacilityList(array('area_id' =>$area_id));//根据权限选择仓库列表
        $area_list = $this->common->getUserAreaList(false);
        //如果前台没有输入，则选择仓库列表中的第一个仓库设为默认
	    if(empty($fields['area_id']) && !empty($area_list['data'][0]['area_id'])){
	  		$fields['area_id'] = $area_list['data'][0]['area_id'];
	  	}
	  	
	  	//查询结果
        $out = $this->order->getOrderCountResult($fields);
        
        //结果处理
        if (isset($out['error_info'])) {
            die("错误" . $out['error_info']);
        }
        if(isset($facility_list['error_info'])){
        	$fields['facility_list'] = array();
        }else {
        	if(isset($facility_list['data'])){
        		$fields['facility_list'] = $facility_list['data'];
        	}
        }
        
         if(isset($area_list['error_info'])){
        	$fields['area_list'] = array();
        }else {
        	if(isset($area_list['data'])){
        		$fields['area_list'] = $area_list['data'];
        	}
        }
        $fields['count_result'] = $out['data']['count_result'];
        $data = $this->helper->merge($fields);
        $this->load->view('order_count',$data);
    }
    
    private function listDownload($out,$str,$list){
    	$head = array();
        $constant_array = array('area_name'=>'大区','facility_name'=>'仓库','date_of_shipping'=>'发货日期','hour_of_shipping'=>'发货时间','date_of_confirm'=>'成团日期','hour_of_confirm'=>'成团时间','province_name'=>'省','city_name'=>'市','district_name'=>'区','address_name'=>'公司/家庭','product_name'=>'product_name','shipping_name'=>'快递','goods_id'=>'goods_id','product_id'=>'product_id','count_of_shipment'=>'订单数');
        if(isset($out['data'][$list])){
            foreach ($out['data'][$list][0] as $key => $value) {
                $head[$key] = $constant_array[$key];
            }
        }
    	$body=array();
    	if(isset($out['data'][$list])){
    		$index = 0;
            $order_list = $out['data'][$list];
    		foreach ($order_list as $key => $entry) {
                if( isset($entry['hour_of_shipping'])){
                    $entry['hour_of_shipping'].= "点";
                }
                if( isset($entry['hour_of_confirm'])){
                    $entry['hour_of_confirm'].= "点";
                }
                foreach ($entry as $key => $value) {
                    $body[$index][] = $value;
                }
    			$index++;
    		}
    	}
    	$this->download($head,$body,$str);
    }

    // 导出 excel
    private function download($head,$body,$fileName){
    	$excel =  $this->excel;
    	$excel->addHeader($head);
    	$excel->addBody($body);
    	$excel->downLoad($fileName);
    }
  
    public function query(){
        $cond = $this->getQueryCondition();
        if(isset($cond['error']) && $cond['error'] == 'error') {
            echo $cond['error_info'];
            return;
        }
        if ($this->getInput('act') == "download") {
            $offset = 0;
            $limit = 1000000;
            $out = $this->order->getDeliverCountResult($cond,$offset,$limit);
            $this->listDownload($out,"发货统计清单","orderCount_list");
            return;
        }
        $offset = (intval($cond['page_current'])-1)*intval($cond['page_limit']);
        $limit = $cond['page_limit'];
        $out = $this->order->getDeliverCountResult($cond,$offset,$limit);
        if(!isset($out['data'])){  // 调用 api 出现错误
            $cond['error_info'] = $out['error_info'];
        }else{  //  调用 API 成功
            $purchaseForecastList =  $out['data']['orderCount_list'] ;
            $cond['orderCount_list'] = $purchaseForecastList;
            // 分页
            $record_total = $out['data']['total'];
            $page_count = $cond['page_current']+3;
            if( count($purchaseForecastList) < $limit ){
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
        $this->load->view('shipping_deliver',$data);
    }
    //成团统计
    public function confirmDeliver(){
        $cond = $this->getQueryCondition();
        if(isset($cond['error']) && $cond['error'] == 'error') {
            echo $cond['error_info'];
            return;
        }
        if ($this->getInput('act') == "download") {
            $offset = 0;
            $limit = 1000000;
            $out = $this->order->getConfirmDeliverCountResult($cond,$offset,$limit);
            $this->listDownload($out,"成团统计清单","confirmOrderCountList");
            return;
        }
        $offset = (intval($cond['page_current'])-1)*intval($cond['page_limit']);
        $limit = $cond['page_limit'];
        $out = $this->order->getConfirmDeliverCountResult($cond,$offset,$limit);
        if(!isset($out['data'])){  // 调用 api 出现错误
            $cond['error_info'] = $out['error_info'];
        }else{  //  调用 API 成功
            $confirmOrderCountList =  $out['data']['confirmOrderCountList'] ;
            $cond['confirmOrderCountList'] = $confirmOrderCountList;
            // 分页
            $record_total = $out['data']['total'];
            $page_count = $cond['page_current']+3;
            if( count($confirmOrderCountList) < $limit ){
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
        $this->load->view('confirm_deliver',$data);
    }

    public function getQueryCondition(){
        $cond = array();
        $shipping_start_time = $this->getInput('shipping_start_time');
        if (isset($shipping_start_time) && $shipping_start_time) {
            $cond['shipping_start_time'] = $shipping_start_time;
        }
        $shipping_end_time = $this->getInput('shipping_end_time');
        if (isset($shipping_end_time) && $shipping_end_time) {
            $cond['shipping_end_time'] = $shipping_end_time;
        }
        $confirm_start_time = $this->getInput('confirm_start_time');
        if (isset($confirm_start_time) && $confirm_start_time) {
            $cond['confirm_start_time'] = $confirm_start_time;
        }
        $confirm_end_time = $this->getInput('confirm_end_time');
        if (isset($confirm_end_time) && $confirm_end_time) {
            $cond['confirm_end_time'] = $confirm_end_time;
        }
        $area_name = $this->getInput('area_name');
        if (isset($area_name) && $area_name) {
            $cond['area_name'] = $area_name;
        }
        $facility_name = $this->getInput('facility_name');
        if (isset($facility_name) && $facility_name) {
            $cond['facility_name'] = $facility_name;
        }
        $date_of_shipping = $this->getInput('date_of_shipping');
        if (isset($date_of_shipping) && $date_of_shipping) {
            $cond['date_of_shipping'] = $date_of_shipping;
        }
        $hour_of_shipping = $this->getInput('hour_of_shipping');
        if (isset($hour_of_shipping) && $hour_of_shipping) {
            $cond['hour_of_shipping'] = $hour_of_shipping;
        }
        $date_of_confirm = $this->getInput('date_of_confirm');
        if (isset($date_of_confirm) && $date_of_confirm) {
            $cond['date_of_confirm'] = $date_of_confirm;
        }
        $hour_of_confirm = $this->getInput('hour_of_confirm');
        if (isset($hour_of_confirm) && $hour_of_confirm) {
            $cond['hour_of_confirm'] = $hour_of_confirm;
        } 
        $province_name = $this->getInput('province_name');
        if (isset($province_name) && $province_name) {
            $cond['province_name'] = $province_name;
        }
        $city_name = $this->getInput('city_name');
        if (isset($city_name) && $city_name) {
            $cond['city_name'] = $city_name;
        }
        $district_name = $this->getInput('district_name');
        if (isset($district_name) && $district_name) {
            $cond['district_name'] = $district_name;
        }
        $address_name = $this->getInput('address_name');
        if (isset($address_name) && $address_name) {
            $cond['address_name'] = $address_name;
        }
        $product_name = $this->getInput('product_name');
        if (isset($product_name) && $product_name) {
            $cond['product_name'] = $product_name;
        }
        $shipping_name = $this->getInput('shipping_name');
        if (isset($shipping_name) && $shipping_name) {
            $cond['shipping_name'] = $shipping_name;
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
            $cond['page_limit'] = 20;
        }
        return $cond;
    }
}