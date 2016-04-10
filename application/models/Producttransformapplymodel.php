<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Producttransformapplymodel extends CI_Model {

    private $CI;
    private $helper;

    function __construct() {
        parent::__construct();
        if (!isset($this->CI)) {
            $this->CI = & get_instance();
        }
        if (!isset($this->helper)) {
            $this->CI->load->library('Helper');
            $this->helper = $this->CI->helper;
        }
    }

    public function getPackageListByFacilityId($params){
        return $this->helper->get('/admin/product/transform/packageQohList',$params);
    }

    public function packageTransformApply($params){
        return $this->helper->post('/admin/product/transform/createPackage',$params);
    }

    public function getPackageTransformList($params){
        return $this->helper->get('/admin/product/transform/packageAList',$params);
    }    

    public function checkProductTransform($params){
        return $this->helper->post('/admin/product/transform/check',$params);
    }

    public function checkFailProductTransform($params){
        return $this->helper->post('/admin/product/transform/checkfail',$params);
    }

    public function receiveTask($params){
        return $this->helper->post('/admin/product/transform/receive',$params);
    }

    public function getTransformInfo($params){
        return $this->helper->get('/admin/product/transform/MappingListByFPId',$params);
    }

    public function finishProductTransform($params){
        return $this->helper->post('/admin/product/transform/finish',$params);
    }

    public function getTransformDetail($params){
        return $this->helper->get('/admin/product/transform/andItemList',$params);
    }
}
