<?php

class PurchaseFinanceList extends CI_Controller {
	function __construct(){
		parent::__construct();
      	$this->load->library('Pager'); 
		$this->load->library('session');
		$this->load->model('common');
		$this->load->library('Helper');
		$this->load->library('Excel');
		$this->load->model('purchasefinance');
		$this->load->model('productmodel');
		$this->helper->chechActionList(array('purchaseFinanceApply', 'purchaseFinance'),true);
	}
	
	public function getProductTypeList(){
		$product_type_list =  array();
		if($this->helper->chechActionList(array('caigouManager','purchaseFinance'))) {
			$item['product_type'] = 'goods';
			$item['product_type_name'] = '商品';
			$product_type_list[] = $item;
		}
		if($this->helper->chechActionList(array('suppliesCaigouManager','purchaseFinance'))) {
			$item['product_type'] = 'supplies';
			$item['product_type_name'] = '耗材';
			$product_type_list[] = $item;
		}
		 
		return $product_type_list;
	}
	
	public function index() {
		$product_type_list = $this->getProductTypeList();
    	if(empty($product_type_list)) {
    		die("无权限");
    	}
    	$cond['product_type_list'] = $product_type_list;
		$out = $this->common->getFacilityList();
		$cond['facility_list'] = $out['data'];
		$cond['start_time'] = date('Y-m-d 00:00:00', time());
		$data = $this->helper->merge($cond);
		$this->load->view("purchase_finance_list",$data);
	}
	
	public function query() {
		$cond = $this->getQueryCondition();   // 获取查询条件 下面需要把条件传递到前端
		if(isset($cond['act']) && $cond['act'] == 'download'){    // 下载
			$this->purchaseFinanceDownload($cond);
			return ;
		}
		$offset = (intval($cond['page_current'])-1)*intval($cond['page_limit']);
		$limit = $cond['page_limit'];
		$cond['offset'] = $offset;
		$cond['size'] = $limit;
		$out = $this->purchasefinance->getPurchaseFinanceList($cond);
		$product_type_list = $this->getProductTypeList();
    	if(empty($product_type_list)) {
    		die("无权限");
    	}
    	$cond['product_type_list'] = $product_type_list;
		$cond['purchase_finance_price_list'] = $out['data']['data']['purchase_finance_price_list'];
		//分页
		$record_total = $out['data']['data']['total'];
		$page_count = $cond['page_current']+3;
		if(count($cond['purchase_finance_price_list']) < $limit ){
			$page_count = $cond['page_current'];
		}
		if(!empty($record_total)){
			$cond['record_total'] = $record_total;
			$page_count = ceil($record_total / $limit );
		}
		$cond['page_count'] = $page_count;
		$cond['page'] = $this->pager->getPagerHtml($cond['page_current'],$page_count);
		
		$out = $this->common->getFacilityList();
		$cond['facility_list'] = $out['data'];
		$data = $this->helper->merge($cond);
		$data['financeStatus'] = array('INIT' => '待申请',
			'APPLIED' => '已申请',
			'MANAGERCHECKED' => '区总成功',
			'MANAGERCHECKFAIL' => '区总失败',
			'DIRECTORCHECKED' => '主管成功',
			'DIRECTORCKFAIL' => '主管失败',
			'CHECKED' => '财务已确认',
			'INREQUEST' => '申请中',
			'CHECKFAIL' => '审核作废',
			'PAID' => '已支付');
		$this->load->view('purchase_finance_list',$data);
	}
	
	private function purchaseFinanceDownload($cond){
		set_time_limit(0);
		$cond['offset'] = 0;
		$cond['size'] = 1000;
		$out = $this->purchasefinance->getPurchaseFinanceList($cond);
		$this->download($out);
	}
	
	// 导出 excel
	private function download($data)
	{
		$this->load->library('excelmergeutil');
		$header = array('ASN ITEM ID', '状态','ASN日期', '区域', '仓库','商品名称','PRODUCT_ID','采购员','供应商','申请人',
			'采购'=>array('时间','价格录入员','总数','箱数','录价格箱数','箱规'),
			'调度'=>array('总箱数','虚拟仓在途盘亏数量','虚拟仓暂存盘亏数量','时间','箱数','入库员'),
			'仓库'=>array('总数','总箱数','时间','仓库','箱数','箱规','入库员','入库含税单价','税率'),'单位','入库含税总金额',
			'供应商退货'=>array('类型','单价','箱数','箱规','申请总金额','退货金额','收款总金额'),
			'供价调整'=>array('采购数量','补货数量','调整时状态','含税总价','税率','其他费用'),
			'支出','区总备注','主管审核备注','审核作废备注'
			);
		$this->excelmergeutil->setHeader($header);
		$financeStatus = array('INIT' => '待申请',
			'APPLIED' => '已申请',
			'MANAGERCHECKED' => '区总成功',
			'MANAGERCHECKFAIL' => '区总失败',
			'DIRECTORCHECKED' => '主管成功',
			'DIRECTORCKFAIL' => '主管失败',
			'CHECKED' => '财务已确认',
			'CHECKFAIL' => '审核作废',
			'INREQUEST' => '申请中',
			'PAID' => '已支付');
		$statusMapping = function($data) use ($financeStatus) {
			return $financeStatus[$data];
		};
    	if( isset($data['data']['data']['purchase_finance_price_list']) && is_array($data['data']['data']['purchase_finance_price_list']))
			foreach ($data['data']['data']['purchase_finance_price_list'] as $key => $order) {
				$inventory_count = count($order['inventory_list']);
				$virtual_inventory_count = count($order['virtual_inventory_list']);
				$supplier_return_count = count($order['supplier_return_list']);
				if (isset($order['history'])) {
					$history_count = count($order['history']);
				} else {
					$history_count = 1;
				}
				$history_count = $history_count == 0 ? 1 : $history_count;

				if ($inventory_count == 0) {
					$inventory_count = 1;
				}
				if ($virtual_inventory_count == 0) {
					$virtual_inventory_count = 1;
				}
				if ($supplier_return_count == 0) {
					$supplier_return_count = 1;
				}
				$rowspans = $this->excelmergeutil->LCM($inventory_count, $virtual_inventory_count);
				$rowspans = $this->excelmergeutil->LCM($rowspans, $supplier_return_count);
				$rowspans = $this->excelmergeutil->LCM($rowspans, $history_count);
				if (isset($order['history'])) {
					$rowspans = max($rowspans, count($order['history']));
				}
				$history_rowspan = $rowspans / $history_count;
				$virtual_rowspans = $rowspans / $virtual_inventory_count;
				$general_rowspans = $rowspans / $inventory_count;
				$supplier_rowspans = $rowspans / $supplier_return_count;
				$this->excelmergeutil->lastRow = $this->excelmergeutil->currentRow + $rowspans - 1;
				$this->excelmergeutil->addItem($order, array('asn_item_id', 'status', 'asn_date', 'area_name', 'facility_name', 'product_name',
					'product_id', 'purchase_user', 'product_supplier_name', 'apply_user', 'created_time', 'created_user', 'purchase_total_num',
					'purchase_case_num', 'price_case_num', 'purchase_container_quantity', 'virtual_arrival_case_num', 'in_transit_variance_quantity',
					'in_stock_variance_quantity',
					'virtual_inventory_list' => array('created_time', 'quantity', 'created_user'),
					'arrival_real_quantity', 'arrival_case_num',
					'inventory_list' => array('created_time', 'facility_name', 'quantity', 'unit_quantity', 'created_user', 'unit_price'),
					'tax_rate', 'product_unit_code', 'purchase_total_price',
					'supplier_return_list' => array('return_type', 'unit_price', 'quantity', 'container_quantity', 'apply_amount', 'transaction_amount', 'finance_amount'),
					'history' => array('history_case_num', 'history_replenish_case_num', 'modified_finance_status', 'total_price', 'tax_rate', 'other_price'),
					'pay', 'purchase_manager_note', 'purchase_director_note', 'note'),
					array('status' => function($data) use ($financeStatus) {
						return $financeStatus[$data['status']];
					}, 'modified_finance_status' => function($data) use ($financeStatus) {
						return $financeStatus[$data['modified_finance_status']];
					}, 'return_type' => function($data) {
						if ($data['return_type'] == 'exchange') {
							return '换货';
						} elseif ($data['return_type'] == 'return') {
							return '退货';
						} elseif ($data['return_type'] == 'sale') {
							return '销售';
						} else {
							return '';
						}
					}, 'history_case_num' => function($data) {
						if ($data['purchase_unit'] == 'case') {
							return $data['case_num'];
						} else {
							return $data['kg_num'];
						}
					}, 'history_replenish_case_num' => function($data) {
						if ($data['purchase_unit'] == 'case') {
							return $data['replenish_case_num'];
						} else {
							return $data['replenish_kg_num'];
						}

					}, 'pay' => function($data) {
						$return_sum = 0;
						foreach($data['supplier_return_list'] as $item) {
							if ($item['return_type'] == 'return')
							$return_sum += $item['transaction_amount'];
						}
						return sprintf('%.2f', $data['purchase_total_price']-$return_sum);
					}));


				$this->excelmergeutil->currentColumn = 'A';
				$this->excelmergeutil->currentRow = $this->excelmergeutil->lastRow + 1;
			}
		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=财务报表.xls");

		$objWriter = PHPExcel_IOFactory::createWriter($this->excelmergeutil, 'Excel5');
		$objWriter->save('php://output');
	}
	
	// 获取前端 post 传递过来的查询条件
	private function getQueryCondition( ){
		$cond = array();
		
		$act = $this->getInput('act');    // 查询 还是 下载
		if(isset($act)) {
			$cond['act'] = $act;
		}
		
		$facility_id = $this->getInput('facility_id');
		if(isset($facility_id) && $facility_id != 'all'){
			$cond['facility_id'] = $facility_id;
		}
	    
	    $product_name = $this->getInput('product_name');
	    if (  isset($product_name)) {
	    	$cond['product_name'] = $product_name;
	    }
	    
	    $product_type = $this->getInput('product_type');
	    if (  isset($product_type)) {
	    	$cond['product_type'] = $product_type;
	    }
	     
		$start_time = $this->getInput('start_time');
		if(isset($start_time)){
			$cond['start_time'] = $start_time;
		}
		
		$end_time = $this->getInput('end_time');
		if(isset($end_time)){
			$cond['end_time'] = $end_time;
		}
		$asn_date_start = $this->getInput('asn_date_start');
		if(isset($asn_date_start)){
			$cond['asn_date_start'] = $asn_date_start;
		}
		
		$asn_date_end = $this->getInput('asn_date_end');
		if(isset($asn_date_end)){
			$cond['asn_date_end'] = $asn_date_end;
		}
		$asn_date = $this->getInput('asn_date');
		if(isset($asn_date)){
			$cond['asn_date'] = $asn_date;
		}
		
		$status = $this->getInput('status');
		if(isset($status)){
			$cond['status'] = $status;
		}
		
		$apply_user = $this->getInput('apply_user');
		if(isset($apply_user)){
			$cond['apply_user'] = $apply_user;
		}
		$asn_item_id = $this->getInput('asn_item_id');
		if(isset($asn_item_id)){
			$cond['asn_item_id'] = $asn_item_id;
		}
		
		$page_current = $this->getInput('page_current');
		if(!empty($page_current)) {
			$cond['page_current'] = $page_current;
		}else{
			$cond['page_current'] = 1;
		}
		$page_limit = $this->getInput('page_limit');
		if(!empty($page_limit)) {
			$cond['page_limit'] = $page_limit;
		}else{
			$cond['page_limit'] = 10;
		}

		$supplier_name = $this->getInput('supplier');
		$supplier = $this->getInput('supplier_id');
		if (!empty($supplier_name)) {
			$cond['supplier_name'] = $supplier_name;
			if (!empty($supplier)) {
				$cond['supplier'] = $supplier;
			}
		}
		
		return $cond;
	}


	public function checked() {
		$asn_item_id = $this->getInput('asn_item_id');
		$note = $this->getInput('note');
		$out = $this->purchasefinance->checked($asn_item_id, $note);
		if (isset($out['error_info'])) {
			echo json_encode($out);
		} else {
			$data = $out['data'];
			echo json_encode($data);
		}
	}
	
	public function checkfail() {
		$asn_item_id = $this->getInput('asn_item_id');
		$note = $this->getInput('note');
		$out = $this->purchasefinance->checkfail($asn_item_id, $note);
		if (isset($out['error_info'])) {
			echo json_encode($out);
		} else {
			$data = $out['data'];
			echo json_encode($data);
		}
	}

	public function paid() {
		$asn_item_id = $this->getInput('asn_item_id');
		$out = $this->purchasefinance->paid($asn_item_id);
		if (isset($out['error_info'])) {
			echo json_encode($out);
		} else {
			$data = $out['data'];
			echo json_encode($data);
		}
	}
	public function recover(){
		$asn_item_id = $this->getInput('asn_item_id');
		$out = $this->purchasefinance->recover($asn_item_id);
		if (isset($out['error_info'])) {
			echo json_encode($out);
		} else {
			$data = $out['data'];
			echo json_encode($data);
		}
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
	
	public function apply() {
		$asn_item_id = $this->getInput('asn_item_id');
		$out = $this->purchasefinance->apply($asn_item_id);
		if (isset($out['error_info'])) {
			echo json_encode($out);
		} else {
			$data = $out['data'];
			echo json_encode($data);
		}
	}
	//区总
	public function purchaseManagerChecked() {
		$asn_item_id = $this->getInput('asn_item_id');
		$out = $this->purchasefinance->purchaseManagerChecked($asn_item_id);
		if (isset($out['error_info'])) {
			echo json_encode($out);
		} else {
			$data = $out['data'];
			echo json_encode($data);
		}
	}
	
	public function purchaseManagerCheckfail() {
		$asn_item_id = $this->getInput('asn_item_id');
		$note = $this->getInput('note');
		$out = $this->purchasefinance->purchaseManagerCheckfail($asn_item_id, $note);
		if (isset($out['error_info'])) {
			echo json_encode($out);
		} else {
			$data = $out['data'];
			echo json_encode($data);
		}
	}
	//主管审批
	public function purchaseDirectorChecked() {
		$asn_item_id = $this->getInput('asn_item_id');
		$out = $this->purchasefinance->purchaseDirectorChecked($asn_item_id);
		if (isset($out['error_info'])) {
			echo json_encode($out);
		} else {
			$data = $out['data'];
			echo json_encode($data);
		}
	}
	
	public function purchaseDirectorCheckfail() {
		$asn_item_id = $this->getInput('asn_item_id');
		$note = $this->getInput('note');
		$out = $this->purchasefinance->purchaseDirectorCheckfail($asn_item_id, $note);
		if (isset($out['error_info'])) {
			echo json_encode($out);
		} else {
			$data = $out['data'];
			echo json_encode($data);
		}
	}
	
}

?>
