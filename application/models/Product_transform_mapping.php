<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class Product_transform_mapping extends CI_Model {

    private $CI;
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
    
    public function creatProductTransformMappingList($cond = array()){
        $out =  $this->helper->post("/product/transform/mapping/create",$cond); 
        $result = array();  
        if($this->helper->isRestOk($out)){
            $result['data'] = $out;
        }else{
            $result['error_info'] = $out['error_info'];
        }
        return $result; 
    }

    public function getProductTransformMappingList($cond = array()){
        $out =  $this->helper->get("/product/transform/mapping/list",$cond); 
        $result = array();  
        if($this->helper->isRestOk($out)){
            $result['data'] = $out;
        }else{
            $result['error_info'] = $out['error_info'];
        }
        return $result; 
    }

    public function applyProductTransformProduct($cond = array()){
        $out =  $this->helper->post("/transform/product/apply",$cond); 
        return $out; 
    }

    public function getProductTransformProduct($cond = array()){
        $out =  $this->helper->get("/transform/product/list",$cond); 
        $result = array();  
        if($this->helper->isRestOk($out)){
            $result = $out;
        }else{
            $result['error_info'] = $out['error_info'];
        }
        return $result; 
    }

    public function checkedProductTransform($cond = array()){
        $out =  $this->helper->post("/transform/product/check",$cond); 
        $result = array();  
        if($this->helper->isRestOk($out)){
            $result['data'] = $out;
        }else{
            $result['error_info'] = $out['error_info'];
        }
        return $result; 
    }

    public function checkfailProductTransform($cond = array()){
        $out =  $this->helper->post("/transform/product/checkfail",$cond); 
        $result = array();  
        if($this->helper->isRestOk($out)){
            $result['data'] = $out;
        }else{
            $result['error_info'] = $out['error_info'];
        }
        return $result; 
    }

    public function executeProductTransform($cond = array()){
        return  $this->helper->post("/transform/product/execute",$cond); 
    }

    public function getMappingContainerList($cond = array()){
        $out =  $this->helper->get("/product/Mapping/list",$cond); 
        $result = array();
        if($this->helper->isRestOk($out)){
            $result['data'] = $out;
        }else{
            $result['error_info'] = $out['error_info'];
        }
        return $result; 
    }

    public function getTransfromProductList($params=null){
        return $this->helper->get('/product/transform/mapping/list/byFromProductId',$params);
    }

    public function showProductTransformMapping($cond = array()){
        $out =  $this->helper->get("/product/transform/mapping/show",$cond); 
        $result = array();  
        if($this->helper->isRestOk($out)){
            $result['data'] = $out;
        }else{
            $result['error_info'] = $out['error_info'];
        }
        return $result; 
    }

    public function getAbProductList(){
        return $this->helper->get('/product/transform/mapping/list/AB');
    }
}

  