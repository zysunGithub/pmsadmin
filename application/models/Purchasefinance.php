<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed'); 
class Purchasefinance extends CI_Model {

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
     
     public function getPurchaseFinanceList($cond) {
     	$status = $cond['status'];
     	unset($cond['status']);
     	$out = $this->helper->get("/purchase/finance/price/list/{$status}", $cond);
     	if($this->helper->isRestOk($out)){
     		$result['data'] = $out;
     	}else{
     		$result['error_info'] = $out['error_info'];
     	}
     	return $result;
     }
     
     public function freezed($asn_item_id) {
     	$out = $this->helper->post("/purchase/finance/price/freeze/{$asn_item_id}", array());
     	if($this->helper->isRestOk($out)){
     		$result['data'] = $out;
     	}else{
     		$result['error_info'] = $out['error_info'];
     	}
     	return $result;
     }
      public function checked($asn_item_id, $note) {
     	$out = $this->helper->post("/purchase/finance/price/check/{$asn_item_id}", array("status"=>"CHECKED", "note" => $note));
     	if($this->helper->isRestOk($out)){
     		$result['data'] = $out;
     	}else{
     		$result['error_info'] = $out['error_info'];
     	}
     	return $result;
     }
      public function checkfail($asn_item_id, $note) {
     	$out = $this->helper->post("/purchase/finance/price/check/{$asn_item_id}", array("status"=>"CHECKFAIL", "note" => $note));
     	if($this->helper->isRestOk($out)){
     		$result['data'] = $out;
     	}else{
     		$result['error_info'] = $out['error_info'];
     	}
     	return $result;
     }
      public function paid($asn_item_id) {
     	$out = $this->helper->post("/purchase/finance/price/pay/{$asn_item_id}", array());
     	if($this->helper->isRestOk($out)){
     		$result['data'] = $out;
     	}else{
     		$result['error_info'] = $out['error_info'];
     	}
     	return $result;
     }
     public function recover($asn_item_id) {
     	$out = $this->helper->post("/purchase/finance/price/recover/{$asn_item_id}", array());
     	if($this->helper->isRestOk($out)){
     		$result['data'] = $out;
     	}else{
     		$result['error_info'] = $out['error_info'];
     	}
     	return $result;
     }
     
     public function apply($asn_item_id) {
     	$out = $this->helper->post("/purchase/finance/price/apply/{$asn_item_id}", array());
     	if($this->helper->isRestOk($out)){
     		$result['data'] = $out;
     	}else{
     		$result['error_info'] = $out['error_info'];
     	}
     	return $result;
     }
     
    public function purchaseManagerChecked($asn_item_id) {
        $out = $this->helper->post("/purchase/finance/price/purchaseManagerCheck/{$asn_item_id}", array("status" => "MANAGERCHECKED"));
        if ($this->helper->isRestOk($out)) {
            $result['data'] = $out;
        } else {
            $result['error_info'] = $out['error_info'];
        }
        return $result;
    }
    public function purchaseManagerCheckfail($asn_item_id, $note) {
        $out = $this->helper->post("/purchase/finance/price/purchaseManagerCheck/{$asn_item_id}", array("status" => "MANAGERCHECKFAIL", "note" => $note));
        if ($this->helper->isRestOk($out)) {
            $result['data'] = $out;
        } else {
            $result['error_info'] = $out['error_info'];
        }
        return $result;
    }
    public function purchaseDirectorChecked($asn_item_id) {
        $out = $this->helper->post("/purchase/finance/price/purchaseDirectorCheck/{$asn_item_id}", array("status" => "DIRECTORCHECKED"));
        if ($this->helper->isRestOk($out)) {
            $result['data'] = $out;
        } else {
            $result['error_info'] = $out['error_info'];
        }
        return $result;
    }
    public function purchaseDirectorCheckfail($asn_item_id, $note) {
        $out = $this->helper->post("/purchase/finance/price/purchaseDirectorCheck/{$asn_item_id}", array("status" => "DIRECTORCKFAIL", "note" => $note));
        if ($this->helper->isRestOk($out)) {
            $result['data'] = $out;
        } else {
            $result['error_info'] = $out['error_info'];
        }
        return $result;
    }

    public function inPaymentRequest($id)
    {
        $out = $this->helper->get("/purchase/finance/inPaymentRequest/$id");
        if ($this->helper->isRestOk($out)) {
            return $out['message'];
//            return $out;
        } else {
            return false;
        }
    }
}

?>