<?php

class productTransformApply extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('helper');
        $this->load->model('common');
        $this->load->model('region');
        $this->load->model('facility');
        $this->load->model('ProductTransformApplyModel');
    }

    private function getInput($name) {
        $out = trim($this->input->post($name));
        if (isset($out) && $out != "") {
            return $out;
        } else {
            $out = trim($this->input->get($name));
            if (isset($out) && $out != "")
                return $out;
        }
        return null;
    }

    public function index(){
        $this->helper->chechActionList(array('createPackageTransformApply'), true);
        $cond = array();
        
        $facility_list = $this->common->getUserRealFacilityList();
            if (isset($facility_list['error_info'])) {
                die('获取仓库列表失败');
            }else{
                if(isset($facility_list['data'])){
                    $cond['facility_list'] = $facility_list['data'];
                }
        }

        $data = $this->helper->merge($cond);
        $this->load->view('package_transform_apply',$data);
    }

    public function getPackageListByFacilityId(){
        $this->helper->chechActionList(array('createPackageTransformApply'), true);
        $facility_id = $this->getInput('facility_id');
        $cond = array();
        if( empty($facility_id) ){
            echo json_encode(array('success'=>'failed','error_info'=>'缺少facility_id'));
        }else{
            $cond['facility_id'] = $facility_id;
            $out = $this->ProductTransformApplyModel->getPackageListByFacilityId($cond);
            if( $this->helper->isRestOk($out) ){
                echo json_encode(array('success'=>'success','package_list'=>$out['packageQoh_list']));
            }else{
                echo json_encode(array('success'=>'failed','error_info'=>'后端获取包裹列表失败'));
            }
        }
    }

    public function packageTransformApply(){
        $this->helper->chechActionList(array('createPackageTransformApply'), true);
        $cond['from_product_info'] = $this->input->post('from_product_info');
        if( !empty($cond['from_product_info']) ){
            $out = $this->ProductTransformApplyModel->packageTransformApply($cond);
            if( $this->helper->isRestOk($out) ){
                echo json_encode(array('success'=>'success'));
            }else{
                echo json_encode(array('success' => 'failed','error_info' => isset($out['error_info']) ? $out['error_info'] : '后端提交包裹转换信息失败'));
            }
        }else{
            echo json_encode(array('success'=>'failed','error_info'=>'没有要提交的转换信息'));
        }
    }

    public function packageTransformList(){
        $this->helper->chechActionList(array('packageTransformList'), true);
        $cond = array();
        $facility_list = $this->common->getFacilityList();
        if (isset($facility_list['error_info'])) {
            die('获取仓库列表失败');
        }
        if (!isset($cond['facility_id'])) {
            $cond['facility_id'] = $facility_list['data'][0]['facility_id'];
        }
        if(isset($facility_list['data'])){
            $cond['facility_list'] = $facility_list['data'];
        }
        $username = $this->session->userdata('username');
        if( !empty($username) ){
            $cond['username'] = $username;
        }
        $data = $this->helper->merge($cond);
        $this->load->view('package_transform_list',$data);
    }

    public function getQohPackageList(){
        $cond = $this->getPackageTransformListCondition();
        $cond['transform_type'] = "FINISHED2RAW";
        $out = $this->ProductTransformApplyModel->getPackageTransformList($cond);
//         echo json_encode($out);
        if( $this->helper->isRestOk($out) ){
            $package_list = $out['package_transformA_list']['product_transform_list'];
            echo json_encode(array("list"=>$package_list,"recordsTotal"=>$out['package_transformA_list']['total'],"recordsFiltered"=>$out['package_transformA_list']['total']));
        }else{
            die('后端获取包裹列表报错');
        }
    }

    private function getPackageTransformListCondition(){
        $cond = array();
        $facility_id = $this->getInput('facility_id');
        if( !empty($facility_id) ){
            $cond['facility_id'] = $facility_id;
        }

        $status = $this->getInput('status');
        if( !empty($status) ){
            $cond['status'] = $status;
        }

        $start_created_time = $this->input->get('start_created_time');
        if( isset($start_created_time) ){
            $cond['start_created_time'] = $start_created_time;
        }else{
            $cond['start_created_time'] = Date("Y-m-d");
        }

        $end_created_time = $this->getInput('end_created_time');
        if( !empty($end_created_time) ){
            $cond['end_created_time'] = $end_created_time;
        }

        $package_name = $this->getInput('package_name');
        if( !empty($package_name) ){
            $cond['package_name'] = $package_name;
        }

        $from_product_id = $this->getInput('from_product_id');
        if( !empty($from_product_id) ){
            $cond['from_product_id'] = $from_product_id;
        }
        
        $cloumns = $this->input->get('columns');
        
        $order = $this->input->get('order');
        if(isset($order[0]['column'])) {
        	$order_index = $order[0]['column'];
        	$cond['order_name'] = $cloumns[$order_index]['data'];
        	$cond['order_type'] = $order[0]['dir'];
        }
        

	    $length = $this->getInput('length');
	  	if(isset($length)) {
	  		$cond['size'] = $length;
	  	}
	  	
	  	$start = $this->getInput('start');
	  	if(isset($start)) {
	  		$cond['offset'] = $start;
	  	}

        return $cond;
    }

    public function checkProductTransform(){
        $this->helper->chechActionList(array('checkProductTransform'), true);
        $transform_product_id = $this->getInput('transform_product_id');
        if( isset($transform_product_id) ){
            $cond['transform_product_id'] = $transform_product_id;
        }
        $check_out = $this->ProductTransformApplyModel->checkProductTransform($cond);
        if( $this->helper->isRestOk($check_out) ){
            echo json_encode(array('success'=>'success'));
        }else{
            echo json_encode(array('success'=>'failed','error_info'=>'后端审核通过不成功'));
        }
    }

    public function checkFailProductTransform(){
        $this->helper->chechActionList(array('checkProductTransform'), true);
        $transform_product_id = $this->getInput('transform_product_id');
        if( isset($transform_product_id) ){
            $cond['transform_product_id'] = $transform_product_id;
        }
        $checkfail_out = $this->ProductTransformApplyModel->checkFailProductTransform($cond);
        if( $this->helper->isRestOk($checkfail_out) ){
            echo json_encode(array('success'=>'success'));
        }else{
            echo json_encode(array('success'=>'failed','error_info'=>'后端审核拒绝不成功'));
        }
    }

    public function receiveTask(){
        $this->helper->chechActionList(array('receiveProductTransform'), true);
        $transform_product_id = $this->getInput('transform_product_id');
        if( isset($transform_product_id) ){
            $cond['transform_product_id'] = $transform_product_id;
        }
        $receive_task_out = $this->ProductTransformApplyModel->receiveTask($cond);
        if( $this->helper->isRestOk($receive_task_out) ){
            echo json_encode(array('success'=>'success','receive_info'=>$receive_task_out['receive_info']));
        }else{
            echo json_encode(array('success'=>'failed','error_info'=>'后端领取任务不成功'));
        }
    }

    public function getTransformInfo(){//获取一个包裹的包含原料信息
        $this->helper->chechActionList(array('finishProductTransform'), true);
        $cond['from_product_id'] = $this->getInput('from_product_id');
        if( !empty($cond['from_product_id']) ){
            $transform_info_out = $this->ProductTransformApplyModel->getTransformInfo($cond);
            if( $this->helper->isRestOk($transform_info_out) ){
                echo json_encode(array('success'=>'success','to_product_info'=>$transform_info_out['toProductList']));
            }else{
                echo json_encode(array('success'=>'failed','error_info'=>'后端也有获取到一个包裹的包含原料信息'));
            }
        }else{  
            echo json_encode(array('success'=>'failed','error_info'=>'缺少from_product_id'));
        }
    }

    public function finishProductTransform(){
        $this->helper->chechActionList(array('finishProductTransform'), true);
        $cond['transform_product_id'] = $this->getInput('transform_product_id');
        $cond['to_product_info'] = $this->input->post('to_product_info');
        if( empty($cond['transform_product_id']) ){
            echo json_encode(array('success'=>'failed','error_info'=>'缺少transform_product_id'));
            die();
        }
        if( empty($cond['to_product_info']) ){
            echo json_encode(array('success'=>'failed','error_info'=>'缺少to_product_info'));
            die();
        }
        $finish_out = $this->ProductTransformApplyModel->finishProductTransform($cond);
        if( $this->helper->isRestOk($finish_out) ){
            echo json_encode(array('success'=>'success'));
        }else{
            echo json_encode(array(
                                'success' => 'failed',
                                'error_info' => (isset($finish_out['error_info']) ? $finish_out['error_info'] : '提交转换信息后端报错')
                            ));
        }
    }

    public function getTransformDetail(){
        $this->helper->chechActionList(array('packageTransformList'), true);
        $cond['transform_product_id'] = $this->getInput('transform_product_id');
        if( empty($cond['transform_product_id']) ){
            echo json_encode(array('success'=>'failed','error_info'=>'缺少transform_product_id'));
            die();
        }
        $transform_detail_out = $this->ProductTransformApplyModel->getTransformDetail($cond);
        //print_r($transform_detail_out);die();
        if( $this->helper->isRestOk($transform_detail_out) ){
            echo json_encode(array('success'=>'success','product_transform_list'=>$transform_detail_out['product_transform_list']));
        }else{
            echo json_encode(array('success'=>'failed','error_info'=>'后端没有获取转换详情'));
        }
    }
}
