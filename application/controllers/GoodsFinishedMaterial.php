<?php 

class GoodsFinishedMaterial extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->library('Helper');
		$this->load->library('Pager');
		$this->load->helper(array('form','url'));
		$this->load->model('productmodel');
	}

	#coding
	public function index(){
		$this->helper->chechActionList(array('goodsFinishedMaterial'),true);
		$cond = $this->getQueryCondition();
		$result = $this->getProductMappingAndGoodsMapping($cond);
		$merchant_list = $this->productmodel->getMerchantList(array());
		$data['merchant_list'] = $merchant_list;
		$data['result'] = $result['list'];
		$data['req'] = $cond;
		$data['page_total'] = $result['page_total'];
		$data = $this->helper->merge($data);
		$this->load->view('goods_finished_material',$data);
	}

	private function getQueryCondition(){
		$cond = array();
		$merchant_id = $this->getInput('merchant_id');
		if(!empty($merchant_id)){
			$cond['merchant_id'] = $merchant_id;
		}else{
			$cond['merchant_id'] = '3';
		}
		$goods_name = $this->getInput('goods_name');
		if(!empty($goods_name)){
			$cond['goods_name'] = $goods_name;
		}
		$product_name = $this->getInput('product_name');
		if(!empty($product_name)){
			$cond['product_name'] = $product_name;
		}
		$component_name = $this->getInput('component_name');
		if(!empty($component_name)){
			$cond['component_name'] = $component_name;
		}
		$page_current = $this->getInput("page_current");
		if(!empty($page_current)){
			$cond['page_current'] = $page_current;
		}else{
			$cond['page_current'] = 1;
		}
		$cond['page_limit'] = 5000;
		return $cond;
	}

	public function getProductMappingAndGoodsMapping($params){
		if(empty($params)){
			return null;
		}
		$offset = (intval($params['page_current'])-1)*intval($params['page_limit']);
        $limit = $params['page_limit'];
		$result = $this->productmodel->getProductMappingAndGoodsMapping( $params, $offset, $limit );
		if(isset($result['data']['list'])){			
			$re = self::handelDataOfProductMappingAndGoodsMapping( $result['data']['list'] );
			$res['page_total'] = ceil( $result['data']['total'] / $limit );// 对总数/每页数 取上余
			$res['list'] = $re;
			return $res;
		}
	}
	private function handelDataOfProductMappingAndGoodsMapping( $params ){
		$result = array();
		foreach( $params as $data ) // data数据
		{
			$result[$data['product_id']]['product_id'] = $data['product_id'];
			$result[$data['product_id']]['product_name'] = $data['product_name'];
			$result[$data['product_id']]['merchant_name'] = $data['merchant_name'];
			$result[$data['product_id']]['product_status'] = $data['product_status'];
			$result[$data['product_id']]['platform_name'] = $data['platform_name'];
			$result[$data['product_id']]['goods'][$data['goods_id']] = array( 'goods_id' => $data['goods_id'], 'goods_name' => $data['goods_name'], 'goods_status' => $data['goods_status'] );
			$result[$data['product_id']]['components'][$data['component_id']] = array( 'component_id' => $data['component_id'], 'component_name' => $data['component_name'], 'component_status' => $data['component_status'] );
		}
		foreach( $result as $rek => $rev )
		{
			$result[$rek]['goods'] = array_values( $result[$rek]['goods']);
			$result[$rek]['components'] = array_values( $result[$rek]['components'] );
		}
		return array_values( $result );
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