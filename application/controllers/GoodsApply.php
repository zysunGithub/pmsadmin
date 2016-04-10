<?php

class GoodsApply extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->library('Helper');
		$this->load->library('upload');
		$this->load->helper(array('form','url'));
        $this->load->model('productmodel');
		$this->helper->chechActionList(array('product','goodsProduct'),true);
	}
    /*
     * goodsproduct
     */
    public function goodsProduct() {
        //检查权限
        $this->helper->chechActionList(array('goodsProduct'),true);
        $merchant_list = $this->productmodel->getMerchantList(array());
        $goods_status = $this->getInput('goods_status');
        //默认状态为未建档案商品
        $cond['goods_status'] = (isset($goods_status)) ? $goods_status : 0;
        $merchant_id = $this->getInput('merchant_id');
        $goods_name = $this->getInput('goods_name');
        //默认商城为商城列表中的第一个
        if (isset($merchant_id))
            $cond['merchant_id'] = $merchant_id;
        if (isset($goods_name))
            $cond['goods_name'] = $goods_name;
        $data = array();
        $data = $this->productmodel->getGoodsProduct($cond);
        $data['goods_status'] = $cond['goods_status'];
        $data['goods_status_list'] = array(
        		array('goods_status' => 0, 'goods_status_name' => '未建档案商品'), 
                array('goods_status' => 1, 'goods_status_name' => '已建档案商品')
        );
        $data['merchant_id'] = $merchant_id;
        $data['goods_name'] = $goods_name;
        $data['merchant_list'] = $merchant_list;
        $data = $this->helper->merge($data);
        //print_r($data);die();
        $this->load->view('goods_product',$data);
    }
    /*
     * 对于未创建商品档案的申请商品档案进行处理ajax
     */
    public function addGoodsApply(){
        if (! $this->helper->chechActionList(array('addGoodsApply'))) {
            echo json_encode(array('success' => 'fail','error_info'=>'没有申请权限'));
            exit();
        }
        $goods_id = $this->getInput("goods_id");
        $merchant_id = $this->getInput("merchant_id");
        $goods_name = $this->getInput("goods_name");
        if (isset($goods_id) && isset($merchant_id) && isset($goods_name)) {
            $params['goods_id'] = $goods_id;
            $params['goods_name'] = $goods_name;
            $params['merchant_id'] = $merchant_id;
        } else {
            echo json_encode(array('success' => 'fail','error_info' => '条件出错！'));
            exit();
        }
        $out = $this->productmodel->addGoodsApply($params);
        if ($this->helper->isRestOk($out)) {
            echo json_encode(array("success"=>"success"));
        } else {
            echo json_encode(array('success' => 'fail','error_info'=>!empty($out['error_info'])?$out['error_info']:'服务器内部错误'));
        }
    }
    /*
     * 申请商品档案列表
     */
    public function goodsApplyList() {
        //检查权限
        $this->helper->chechActionList(array('goodsApplyList'), true);
        $merchant_list = $this->productmodel->getMerchantList(array());
        $merchant_id = $this->getInput('merchant_id');
        $goods_name = $this->getInput('goods_name');
        $cond = array();
        if (isset($merchant_id))
            $cond['merchant_id'] = $merchant_id;
        if (isset($goods_name))
            $cond['goods_name'] = $goods_name;
        $goods_product_list = $this->productmodel->goodsApplyList($cond);
        $data = array();
        $data['goods_product_list'] = $goods_product_list['data'];
        $data['merchant_id'] = $merchant_id;
        $data['merchant_list'] = $merchant_list;
        $data['goods_name'] = $goods_name;
        $data = $this->helper->merge($data);
        $this->load->view('goods_apply_list',$data);
    }
    /*
     * 取消商品档案申请
     */
    public function removeGoodsApply() {
        if (! $this->helper->chechActionList(array('removeGoodsApply'))) {
            echo json_encode(array('success' => 'fail','error_info'=>'没有取消申请权限'));
            exit();
        }
        $goods_apply_id = $this->getInput("goods_apply_id");
        $params = array();
        if (isset($goods_apply_id)) {
            $params['goods_apply_id'] = $goods_apply_id;
        } else {
            echo json_encode(array('success' => 'fail','error_info' => '条件出错！'));
            exit();
        }
        $out = $this->productmodel->removeGoodsApply($params);
        if ($this->helper->isRestOk($out)) {
            echo json_encode(array("success"=>"success"));
        } else {
            echo json_encode(array('success' => 'fail','error_info'=>!empty($out['error_info'])?$out['error_info']:'服务器内部错误'));
        }
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
