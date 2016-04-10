<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class Loadingbill extends CI_Model {

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

    public function getLoadingBill($cond = array()){
        $out =  $this->helper->get("/admin/loading_bill",$cond); 
        $result = array();  
        if($this->helper->isRestOk($out)){
            $result['data'] = $out;
        }else{
            $result['error_info'] = $out['error_info'];
        }
        return $result; 
    }
    
    public function getLoadingBillItem($cond = array()){
        $out =  $this->helper->get("/admin/loading_bill_item",$cond); 
        $result = array();  
        if($this->helper->isRestOk($out)){
            $result['data'] = $out;
        }else{
            $result['error_info'] = $out['error_info'];
        }
        return $result; 
    }
    
}

  