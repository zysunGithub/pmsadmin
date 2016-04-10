<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

//  运费模板 
class Shipping_template_model extends CI_Model {

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
    
   public function getShippingByFacility($facility) {
   		return $this->helper->get('/shipping/shippingList/'.$facility);
   }
   
}