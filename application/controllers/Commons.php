<?php
/*
 * It is used for the Web Controller, extending CIController.
 * The name of the class must have first Character as Capital.
 *
**/
class Commons extends CI_Controller {
	function __construct()
	{
		parent::__construct();
	  	$this->load->library('session'); 
	    $this->load->library('Helper'); 
	    $this->load->model('common');
	    $this->load->model('shipping_template_model');
	    $this->load->model('facility');
	    $this->load->model('productmodel');
	}
	public function index(){
		
	}
  public function getArealist(){
	$info = $this->common->getAreaList();
	echo json_encode($info);
  }
  //user facility
  public function getFacilityList(){
  	$area_id = $this->getInput('area_id');
  	$info = $this->common->getUserRealFacilityList(array('area_id'=>$area_id));
	echo json_encode($info);
  }
  
  //user facility 
  public function getUserFacilityList() {
  	$info = $this->common->getFacilityList(array('area_id'=>$area_id));
	echo json_encode($info);
  }
  public function getShippingList(){
  	$facility_id = $this->getInput('facility_id');
  	$info = $this->shipping_template_model->getShippingByFacility($facility_id);
	echo json_encode($info);
  }
  public function getAvaiableProduct(){
    $facility_id = $this->getInput('facility_id');
    $area_id = $this->getInput('area_id');
    $data = array(
    	'facility_id' => $facility_id,
    	'area_id' 	  => $area_id
    );
    $info = $this->productmodel->getFacilityAvaiableProducts($data);
    echo json_encode($info);
  }
  
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