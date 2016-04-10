<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

//  运费模板 
class Shippingmodel extends CI_Model {

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

    public function getShippingService() {
    	$out = $this->helper->get("/admin/shippingservice");
    	if( $this->helper->isRestOk($out,'shipping')  ){
    		return $out['shipping'];
    	}else{
    		return array();
    	}
    }
}