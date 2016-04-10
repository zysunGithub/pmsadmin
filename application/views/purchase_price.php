<!doctype html>
<html>

<head>
    <title>拼好货WMS</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="Pragma" content="no-cache">   
    <meta http-equiv="Cache-Control" content="no-store">
    <meta http-equiv="Expires" content="0">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT ; ?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT ; ?>assets/css/global.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/lhgcalendar.css"/>
	<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/autocomplete.css">
    <!--[if lt IE 9]>
            <script src="http://assets.yqphh.com/assets/js/html5shiv.min-3.7.2.js"></script>
        <![endif]-->
    <style type="text/css">
    </style>
</head>
<body>
<div class="container-fluid" style="margin-left: -18px;padding-left: 19px;" >
	<div role="tabpanel" class="row tab-product-list tabpanel" >
		<div class="col-md-12">
		<input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> >
			<div class="tab-content">
				<div class="row col-sm-12 col-sm-offset-0" style="margin-top: 10px;">
					<form style="width:100%;" method="get" action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>purchasePrice/query">
					<div class="row">
					<label for="facility_id" style="width: 110px;">仓库：</label>
					<select style="width:12%; height: 30px" id="facility_id" name="facility_id" >
                                <?php foreach ( $facility_list as $facility ) {
									if (isset( $facility_id ) && $facility ['facility_id'] == $facility_id) {
										if(in_array($facility['facility_type'],array(3,4,5))) {
											$is_virtual = false;
										} else {
											$is_virtual = true;
										}
										echo "<option value=\"{$facility['facility_id']}\" selected='true'>{$facility['facility_name']}</option>";
									} else {
										echo "<option value=\"{$facility['facility_id']}\">{$facility['facility_name']}</option>";
									}
								} ?>
                    </select>
                   		<label>开始日期：</label>
                    	<input type="text" id="asn_date_start" name="asn_date_start" value="<?php echo $asn_date_start; ?>"  style="width:12%; height: 30px">
                  		<label>结束日期：</label>
                    	<input type="text" id="asn_date_end" name="asn_date_end" value="<?php echo $asn_date_end; ?>"  style="width:12%; height: 30px">
	                	
	                	<button type="button" class="btn btn-primary btn-sm" id="query"  >搜索 </button>
					</div>
				
                    <input id="hidden_product_type" type="hidden" name="product_type" value="<?php echo $product_type?>">
					</form>
					<div id="myPrintArea">
					<table id="bol_item" class="table table-striped table-bordered "  style="width:100%" >
						<tr>
							<th width="10%">ASN ITEM ID</th>
			            	<th width="10%">PRODUCT_ID</th>
			                <th width="13%">商品</th>
							<td width="10%">供应商名称</td>
			                <th width="10%">承诺箱数</th>
			                <th width="10%">发货箱数</th>
			                <th width="10%">入库箱数</th>
							<th width="7%">箱规</th>
							<th width="5%">单位</th>
							<th width="20%">总价</th>
							<th width="10%">财务状态</th>
							<th>是否冻结</th>
							<th width="7">操作</th>
						</tr>
						<?php if( isset($asn_item_list) && is_array($asn_item_list))  foreach ($asn_item_list as $key => $asn_item) { ?> 
						<tr class="content">
							<td class="asn_item_id"><?php echo !empty($asn_item['asn_item_id'])?$asn_item['asn_item_id']:'' ?></td>
			                <td class="product_id"><?php echo !empty($asn_item['product_id'])?$asn_item['product_id']:'' ?></td>
			                <td class="product_name"><?php echo !empty($asn_item['product_name'])?$asn_item['product_name']:'' ?></td>
							<td class="supplier_name"><a href="<?php if(isset($WEB_ROOT)) {
									echo $WEB_ROOT;
								};
								echo 'productSupplierList/editIndex?product_supplier_id='.$asn_item['product_supplier_id']; ?>"><?php
								echo $asn_item['product_supplier_name']; ?></a></td>
			                <td class="case_num"><?php echo !empty($asn_item['commitment_case_num'])?$asn_item['commitment_case_num']:0 ?></td>
			                <td class="setoff_case_num"><?php echo !empty($asn_item['setoff_case_num'])?$asn_item['setoff_case_num']:0 ?></td>
			                <td class="arrival_case_num"><?php echo !empty($asn_item['arrival_case_num'])?$asn_item['arrival_case_num']:0 ?></td>
			                <td class="quantity"><?php if($asn_item['product_unit_code'] == 'kg' && $product_type == 'goods'){ echo ($asn_item['quantity'] * 2 );} else {echo $asn_item['quantity']; }?></td>
			                <td class="product_unit_code_name"><?php if($asn_item['product_unit_code'] == 'kg' && $product_type == 'goods'){ echo '斤';} else {echo $asn_item['product_unit_code_name']; }?></td>
			                <td class="unit_price_td" ><?php echo !empty($asn_item['price_container'])?$asn_item['price_container']:'' ?></td>
			                <td class="purchase_finance_status" >
			                <?php 
			                if(empty($asn_item['purchase_finance_status']) || $asn_item['purchase_finance_status'] == 'INIT') { echo '待申请'; }
			                else if($asn_item['purchase_finance_status'] == 'APPLIED') { echo '已申请'; }
			                else if($asn_item['purchase_finance_status'] == 'MANAGERCHECKED') { echo '区总成功'; }
			                else if($asn_item['purchase_finance_status'] == 'MANAGERCHECKFAIL') { echo '区总失败'; }
			                else if($asn_item['purchase_finance_status'] == 'DIRECTORCHECKED') { echo '主管审批成功'; }
			                else if($asn_item['purchase_finance_status'] == 'DIRECTORCKFAIL') { echo '主管审批失败'; }
			                else if($asn_item['purchase_finance_status'] == 'FREEZED') { echo '已冻结'; }			
			                else if($asn_item['purchase_finance_status'] == 'CHECKED') { echo '财务已确认'; }
			                else if($asn_item['purchase_finance_status'] == 'CHECKFAIL') { echo '审核失败'; }
			                else if($asn_item['purchase_finance_status'] == 'PAID') { echo '财务已支付'; }
			                else {echo 'ERROR';}
			                ?></td>
							<td><?php echo $asn_item['frozen'] == 1 ? '已冻结':'未冻结';?></td>
			                <td class="price_detail_td" <?php if($asn_item['is_priced'] != 1) echo "hidden = 'hidden'" ?>><input type="button" class="btn btn-success price_detail" id="price_detail" value="价格详情"></td>
			                <td class="price_keyin_td" <?php if($asn_item['is_priced'] == 1) echo "hidden = 'hidden'" ?>><input type="button" class="btn btn-primary price_keyin" id="price_keyin" name="price_keyin" value="价格录入"></td>
			                <td class="bol_info" hidden="true" ><?php echo !empty($asn_item['bol_info'])?$asn_item['bol_info']:'' ?></td>
			                <td class="product_unit_code" hidden="true" ><?php echo !empty($asn_item['product_unit_code'])?$asn_item['product_unit_code']:'' ?></td>
			                <td class="product_supplier_id" hidden="true"><?php echo !empty($asn_item['product_supplier_id'])?$asn_item['product_supplier_id']:'' ?></td>
							<td class="product_supplier_name" hidden="true"><?php echo !empty($asn_item['product_supplier_name'])?$asn_item['product_supplier_name']:'' ?></td>
							<td class="container_unit_code" hidden="true"><?php echo !empty($asn_item['container_unit_code'])?$asn_item['container_unit_code']:'' ?></td>
							<td class="container_unit_code_name" hidden="true"><?php echo !empty($asn_item['container_unit_code_name'])?$asn_item['container_unit_code_name']:'' ?></td>
							<td class="tax_rate" hidden="true"><?php
								if ($asn_item['product_type'] == 'supplies') {
									echo '0.17';
								} else {
									echo isset($asn_item['tax_rate']) && isset($asn_item['tax_rate_status']) && $asn_item['tax_rate_status']==1 ?$asn_item['tax_rate']:'';
								}
								?></td>
							<td class="deduction_rate" hidden="true"><?php echo isset($asn_item['deduction_rate']) && isset($asn_item['tax_rate_status']) && $asn_item['tax_rate_status']==1 ?$asn_item['deduction_rate']:'' ?></td>
							<td class="tax_rate_status" hidden="true"><?php echo isset($asn_item['tax_rate_status'])?$asn_item['tax_rate_status']:'' ?></td>
							<td class="frozen" hidden="true"><?php echo $asn_item['frozen'];?></td>
							<td class="product_type" hidden="true"><?php echo $asn_item['product_type'];?></td>
						</tr>
	      				<?php }?>
      				</table>
      				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>

	<!-- Modal -->
<div>
	<div class="modal fade ui-draggable text-center" id="price_detail_modal" role="dialog" style="overflow:auto" >
	  <div class="modal-dialog" style="display: inline-block; width: 1050px">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" id="btnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">价格详情</h4>
	      </div>
	      <div class="modal-body" style="text-align: left;">
	      	<div class="row">
	      		<label for="price_detail_asn_item_id" style="text-align: right;">ASN ITEM ID：</label><input type="text" disabled="disabled" readonly="readonly" id="price_detail_asn_item_id" >
	      	</div>
	      	<div class='row'>
				<label for="price_detail_product_name" style="text-align: right;">商品：</label><input type="text" disabled="disabled" id="price_detail_product_name" value="">
				<label for="price_detail_commitment_case_num" style="text-align: right;">承诺箱数：</label><input type="text" disabled="disabled" id="price_detail_commitment_case_num" value="">
			</div>
			<div class="row">
				<label for="price_detail_setoff_case_num" style="text-align: right;">发货箱数：</label><input type="text" disabled="disabled" id="price_detail_setoff_case_num" value="">
				<label for="price_detail_arrival_case_num" style="text-align: right;">入库箱数：</label><input type="text" disabled="disabled" id="price_detail_arrival_case_num" value="">
			</div>
			<div class="row">
				<label for="price_detail_container_quantity" style="text-align: right;">箱规：</label><input type="text" disabled="disabled" id="price_detail_container_quantity" value="">
				<label for="price_detail_product_unit_code" style="text-align: right;">单位：</label><input type="text" disabled="disabled" id="price_detail_product_unit_code" value="">
	      	</div>
	      	<div class="row"> 
	      		<label for="price_detail_purchase_unit" style="text-align: right;">采购单位：</label>
	      		<select id="price_detail_purchase_unit" disabled="disabled">
	      			<option value="jin">斤</option>
	      			<option value="case">箱</option>
	      			<option value="ge">个</option>
					<option value="juan">卷</option>
					<option value="zhi">只</option>
					<option value="kuai">块</option>
					<option value="zhang">张</option>
					<option value="kg">KG</option>
					<option value="box">箱</option>
	      		</select>
	      	</div>
	      	<input type="hidden" id="price_detail_product_id" >
	      	<input type="hidden" id="price_detail_product_supplier_id" >
	      	<input type="hidden" id="price_detail_product_supplier_name" >
			  <input type="hidden" id="price_detail_tax_rate">
			  <input type="hidden" id="price_detail_deduction_rate">
			  <input type="hidden" id="price_detail_is_frozen">

	      	<div class='row'><input id="price_detail_add_product" type="button" class="btn btn-info btn-sm" style="text-align: left;margin-left: 35px" value="添加"></div>
	      	<table id="price_detail_table"  style="width:880px; border: 3" class="table table-striped table-bordered ">
				<tr>
					<th id="price_detail_purchase_user_title" style="width: 150px">采购员</th>
					<th id="price_detail_product_supplier_name_title" style="width: 150px">供应商</th>
					<th id="price_detail_case_num_title" style="width: 95px">购买箱数 </th>
					<th id="price_detail_replenish_case_num_title" style="width: 95px">补货箱数 </th>
					<th id="price_detail_container_quantity_title" style="width: 60px">箱规</th>
					<th id="price_detail_kg_num_title" style="width: 125px">购买斤数</th>
					<th id="price_detail_replenish_kg_num_title" style="width: 125px">补货斤数</th>
					<th id="price_detail_total_price_with_tax_title" style="width: 80px">含税总价</th>
					<th id="price_detail_unit_price_with_tax_title" style="width: 80px">含税单价</th>
					<th id="price_detail_tax_title" style="width: 80px">税费</th>
					<td id="price_detail_tax_rate_title" style="width: 80px">进项税率</td>
					<td id="price_detail_deduction_rate_title" style="width: 80px;">扣除率</td>
					<th id="price_detail_deduction_title" style="width: 80px">可抵扣金额</th>
					<th id="price_detail_other_price_title" style="width: 80px">其他费用</th>
					<th id="price_detail_is_paid_title" style="width: 60px">是否付款</th>
					<th id="price_detail_operator_title" style="width: 30px"></th>
				</tr>
			</table>
			<br>
			  <div id="history_div" style="display: none">
				  <div>供价调整记录</div>
				  <table id="history_table" class="table table-striped table-bordered">
					  <tr>
						  <th id="purchase_num">购买箱数</th>
						  <th id="replenish_num">补货箱数</th>
<!--						  <th>购买斤数</th>-->
<!--						  <th>补货斤数</th>-->
						  <th>调整时状态</th>
						  <th>含税总价</th>
						  <th>进项税率</th>
						  <th>扣除率</th>
						  <th>不含税单价</th>
						  <th>其他费用</th>
					  </tr>

				  </table>
			  </div>
				<div style="font-size: large;font-size: 22px;font-weight: bold;" id="price_detail_virtual_lable" <?php if($is_virtual) echo "hidden='hidden'"?>>调拨入库详情</div>
	      		<table id="price_datail_virtual_bol_info_table" class="table table-striped table-bordered " style="width: 880px;border=3 " <?php if($is_virtual) echo "hidden='hidden'"?>>
		      		<tr>
		      			<th id="price_detial_virtual_bol_info_facility_name_title" style="width: 80px">仓库</th>
						<th id="price_datail_virtual_bol_info_bol_sn_title" style="width: 150px">装车单号</th>
						<th id="price_datail_virtual_bol_info_finish_quantity_title" style="width: 60px">入库箱数</th>
						<th id="price_datail_virtual_bol_info_in_transit_variance_quantity_title" style="width: 60px">虚拟仓在途盘亏数量</th>
						<th id="price_datail_virtual_bol_info_in_stock_variance_quantity_title" style="width: 60px">虚拟仓暂存盘亏数量</th>
						<th id="price_datail_virtual_bol_info_finish_user_title" style="width: 50px">入库人 </th>
						<th id="price_datail_virtual_bol_info_finish_time_title" style="width: 60px">入库时间</th>
						<th id="price_datail_virtual_bol_info_case_num_total_title" style="width: 70px">入库总箱数</th>
					</tr>
	      		</table>
	      		<br>
	      		<div style="font-size: large;font-size: 22px;font-weight: bold;">实体仓入库详情</div>
	      		<table id="price_datail_bol_info_table" style="width: 880px;border=3 " class="table table-striped table-bordered ">
		      		<tr>
		      			<th id="price_detail_bol_info_facility_name_title" style="width: 80px">仓库</th>
						<th id="price_datail_bol_info_bol_sn_title" style="width: 150px">装车单号</th>
						<th id="price_datail_bol_info_finish_quantity_title" style="width: 60px">入库箱数</th>
						<th id="price_datail_bol_info_unit_quantity_title" style="width: 50px">箱规</th>
						<th id="price_datail_bol_info_finish_user_title" style="width: 50px">入库人 </th>
						<th id="price_datail_bol_info_finish_time_title" style="width: 60px">入库时间</th>
						<th id="price_datail_bol_info_finish_case_num_total_title" style="width: 70px">入库总箱数</th>
						<th id="price_datail_bol_info_finish_quantity_total_title" style="width: 80px">入库总数</th>
					</tr>
	      		</table>
	      </div>
	      <div class="modal-footer">
	      	<input id="price_detail_sub" type="button" class="btn btn-primary" style="text-align: right" value="提交">
	      </div>
	    </div>
	  </div>
	</div>
</div>
<!-- modal end  -->

<!-- Modal -->
<div style="width: 900px">
	<div class="modal fade ui-draggable text-center" id="price_keyin_modal" role="dialog" style="overflow:auto" >
	  <div class="modal-dialog" style="display: inline-block; width: 1000px">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" id="btnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">价格录入</h4>
	      </div>
	      <div class="modal-body" style="text-align: left; ">
	      	<div class="row">
	      		<label for="price_keyin_asn_item_id" style="text-align: right;" >ASN ITEM ID：</label> <input type="text" disabled="disabled"  id="price_keyin_asn_item_id" >
	      	</div>
	      	<div class='row'>
				<label for="price_keyin_product_name" style="text-align: right;">商品：</label><input type="text" disabled="disabled" id="price_keyin_product_name" >
				<label for="price_keyin_commitment_case_num" style="text-align: right;">承诺箱数：</label><input type="text" disabled="disabled" id="price_keyin_commitment_case_num" >
			</div>
			<div class="row">
				<label for="price_keyin_setoff_case_num" style="text-align: right;">发货箱数：</label><input type="text" disabled="disabled" id="price_keyin_setoff_case_num" >
				<label for="price_keyin_arrival_case_num" style="text-align: right;">入库箱数：</label><input type="text" disabled="disabled" id="price_keyin_arrival_case_num" >
			</div>
			<div class="row">
				<label for="price_keyin_container_quantity" style="text-align: right;">箱规：</label><input type="text" disabled="disabled" id="price_keyin_container_quantity" >
				<label for="price_keyin_product_unit_code" style="text-align: right;">单位：</label><input type="text" disabled="disabled" id="price_keyin_product_unit_code" >
	      	</div>
	      	<div class="row" >
	      		<label for="price_keyin_purchase_unit" style="text-align: right;">采购单位：</label>
	      		<select id="price_keyin_purchase_unit" disabled="disabled">
	      			<option value="jin">斤</option>
	      			<option value="case">箱</option>
	      			<option value="ge">个</option>
					<option value="juan">卷</option>
					<option value="zhi">只</option>
					<option value="kuai">块</option>
					<option value="zhang">张</option>
					<option value="kg">KG</option>
					<option value="box">箱</option>
	      		</select>
	      	</div>
	      	<input type="hidden" id="price_keyin_product_id" >
	      	<input type="hidden" id="price_keyin_product_supplier_id" >
	      	<input type="hidden" id="price_keyin_product_supplier_name" >
	      	<input type="hidden" id="price_keyin_inventory_qoh" >
			  <div style="width: 100%; overflow-x: auto;">
	      	<table id="price_keyin_table" style="width: 950px;border: 3" class="table table-striped table-bordered ">
				<tr>
					<th id="price_keyin_purchase_user_title" style="width: 150px">采购员</th>
					<th id="price_keyin_product_supplier_name_title" style="width: 150px">供应商</th>
					<th id="price_keyin_case_num_title" style="width: 95px">购买箱数 </th>
					<th id="price_keyin_replenish_case_num_title" style="width: 85px">补货箱数 </th>
					<th id="price_keyin_container_quantity_title" style="width: 80px">箱规</th>
					<th id="price_keyin_kg_num_title" style="width: 125px">购买斤数</th>
					<th id="price_keyin_replenish_kg_num_title" style="width: 125px">补货斤数</th>
					<th id="price_keyin_total_price_with_tax_title" style="width: 80px">含税总价</th>
					<th id="price_keyin_tax_title" style="width: 80px">税费</th>
					<th id="price_keyin_deduction_title" style="width: 80px">可抵金额</th>
					<th id="price_keyin_total_price_without_tax_title" style="width: 80px">不含税总价</th>
					<th id="price_keyin_unit_price_with_tax_title" style="width: 80px">含税单价</th>
					<th id="price_keyin_unit_price_without_tax_title" style="width: 80px">不含税单价</th>
					<th id="price_keyin_tax_rate_title" style="width: 80px">进项税率</th>
					<th id="price_keyin_deduction_rate_title" style="width: 80px">扣除率</th>
					<th id="price_keyin_other_price_title" style="width: 80px">其他费用</th>
					<th id="price_keyin_history_inventory_unit_price_title" style="width: 80px">最近实体仓入库单价</th>
					<th id="price_keyin_is_paid_title" style="width: 60px">是否付款</th>
					<th id="price_keyin_operator_title" style="width: 80px;"></th>
				</tr>
			</table>
			  </div>
				<div style="font-size: large;font-size: 22px;font-weight: bold;" id="price_keyin_virtual_lable" <?php if($is_virtual) echo "hidden='hidden'"?>>调拨入库详情</div>
	      		<table id="price_keyin_virtual_bol_info_table" class="table table-striped table-bordered " style="width: 880px;border: 3 " <?php if($is_virtual) echo "hidden='hidden'"?>>
		      		<tr>
		      			<th id="price_keyin_virtual_bol_info_facility_name_title" style="width: 80px">仓库</th>
						<th id="price_keyin_virtual_bol_info_bol_sn_title" style="width: 150px">装车单号</th>
						<th id="price_keyin_virtual_bol_info_finish_quantity_title" style="width: 60px">入库数量</th>
						<th id="price_keyin_virtual_bol_info_in_transit_variance_quantity_title" style="width: 60px">虚拟仓在途盘亏数量</th>
						<th id="price_keyin_virtual_bol_info_in_stock_variance_quantity_title" style="width: 60px">虚拟仓暂存盘亏数量</th>
						<th id="price_keyin_virtual_bol_info_finish_user_title" style="width: 60px">入库人 </th>
						<th id="price_keyin_virtual_bol_info_finish_time_title" style="width: 60px">入库时间</th>
						<th id="price_keyin_virtual_bol_info_case_num_total_title" style="width: 70px">入库总箱数</th>
					</tr>
	      		</table>
			<div style="font-size: large;font-size: 22px;font-weight: bold;">实体仓入库详情</div>
	      		<table id="price_keyin_bol_info_table" style="width: 880px;border: 3 " class="table table-striped table-bordered ">
		      		<tr>
		      			<th id="price_keyin_bol_info_facility_name_title" style="width: 80px">仓库</th>
						<th id="price_keyin_bol_info_bol_sn_title" style="width: 150px">装车单号</th>
						<th id="price_keyin_bol_info_finish_quantity_title" style="width: 60px">入库数量</th>
						<th id="price_keyin_bol_info_unit_quantity_title" style="width:70px">箱规</th>
						<th id="price_keyin_bol_info_finish_user_title" style="width: 60px">入库人 </th>
						<th id="price_keyin_bol_info_finish_time_title" style="width: 60px">入库时间</th>
						<th id="price_keyin_bol_info_case_num_total_title" style="width: 70px">入库总箱数</th>
						<th id="price_keyin_bol_info_quantity_total_title" style="width: 80px">入库总数</th>
					</tr>
	      		</table>
	      </div>
	      <div class="modal-footer">
	      	<input id="price_keyin_sub" type="button" class="btn btn-primary" style="text-align: right" value="提交">
	      </div>
	    </div>
	  </div>
	</div>
</div>
<!-- modal end  -->

    <script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
	<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/lhgcalendar.min.js"></script>
	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js"></script>
	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/js_wms/purchase_price.js"></script>
	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/js_wms/purchase_price_add.js"></script>
	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/js_wms/purchase_price_detail.js"></script>
	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/js_wms/unit_code.js"></script>
</body>
</html>
