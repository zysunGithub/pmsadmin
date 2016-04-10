<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Purchasepaymentmodel extends CI_Model {

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

    public function upload($asn_item_id, $url)
    {
        $out = $this->helper->post("/purchase/finance/image/upload/$asn_item_id", array('url'=>$url));
        if ($this->helper->isRestOk($out)) {
            $result['data'] = $out;
        } else {
            $result['error_info'] = $out['error_info'];
        }
        return $result;
    }

    public function deleteImage($asn_item_id, $url)
    {
        $out = $this->helper->post("/purchase/finance/image/delete/$asn_item_id", array('url'=>$url));
        if ($this->helper->isRestOk($out)) {
            $result['data'] = $out;
        } else {
            $result['error_info'] = $out['error_info'];
        }
        return $result;

    }

    public function genRequest($params)
    {
        $out = $this->helper->post("/purchase/payment/create/request", $params);
        if ($this->helper->isRestOk($out)) {
            $result['data'] = $out;
        } else {
            $result['error_info'] = $out['error_info'];
        }
        return $result;
    }

    public function getPaymentRequests($cond)
    {
        $out = $this->helper->post("/purchase/payment/list/request", $cond);
        if($this->helper->isRestOk($out)){
            $result['data'] = $out['data'];
        }else{
            $result['error_info'] = $out['error_info'];
        }
        return $result;
    }

    public function getRequestDetails($id)
    {
        $out = $this->helper->get("/purchase/payment/request/details/$id");
        if ($this->helper->isRestOk($out)) {
            $result['data'] = $out['data'];
        } else {
            $result['error_info'] = $out['error_info'];
        }
        return $result;
    }

    public function check($params)
    {
        $out = $this->helper->post('/purchase/payment/check', $params);
        if ($this->helper->isRestOk($out)) {
            $result['data'] = $out;
        } else {
            $result['error_info'] = $out['error_info'];
        }
        return $result;
    }

    public function deleteRequest($id)
    {
        $out = $this->helper->get("/purchase/payment/request/delete/$id");
        if ($this->helper->isRestOk($out)) {
            $result['data'] = $out;
        } else {
            $result['error_info'] = $out['error_info'];
        }
        return $result;
    }

    public function addDefectiveReturn($asn_item_id, $ids)
    {
        $out = $this->helper->post("/purchase/payment/defectiveReturn/add", array('ids'=>$ids,'asn_item_id'=>$asn_item_id));
        if ($this->helper->isRestOk($out)) {
            $result = $out;
        } else {
            $result['error_info'] = $out['error_info'];
        }
        return $result;
    }

    public function removeDefectiveReturn($asn_item_id, $id)
    {
        $out = $this->helper->post("/purchase/payment/defectiveReturn/remove", array('id'=>$id,'asn_item_id'=>$asn_item_id));
        if ($this->helper->isRestOk($out)) {
            $result = $out;
        } else {
            $result['error_info'] = $out['error_info'];
        }
        return $result;
    }
}

?>
