<?php 
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 
// 处理订单相关的逻辑 为 订单控制器服务 
class Asn extends CI_Model {
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
     
     public function getAsnList($params) {
     	return $this->helper->get('/asn/getAsnList', $params);
     }
}