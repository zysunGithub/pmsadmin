<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>拼好货WMS</title>
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/order.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/autocomplete.css">
    <!-- <link rel="stylesheet" type="text/css" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/js/calendar/GooCalendar.css"/> -->
    <link rel="stylesheet" type="text/css" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/lhgcalendar.css"/>
    
    <style type="text/css">
        tr td.product_cell{
            text-align: center;
            vertical-align:middle;
            height: 100%;
        }
        td input,td select{
        	width: 90%;
        	margin: 10px 5%;
        }
       .order{
            border: 1px solid gray;
            margin-top:2px;
            margin-bottom: 2px;
       }

       .order_head{
            background-color: #cccccc;
       }


      .currentPage{
       font-weight: bold;
       font-size: 120%; 
       }
    </style>
    <!--[if lt IE 9]>
        <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <![endif]-->
</head>
<body>  
    <div class="container-fluid" style="margin-left: -18px;padding-left: 19px;" >
        <div role="tabpanel" class="row tab-product-list tabpanel" >
            <div class="col-md-12">
                <!-- Nav tabs -->
                <input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> >
                <!-- Tab panes -->
                <div class="tab-content">
                	<form method="post" action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>supplierReturnList/index<?php if( !empty( $product_type ) && $product_type == "supplies" ) echo '?product_type=supplies'; ?>">
                    
							<div class="row">
								<label for="start_time" class="col-sm-2 control-label"><h4>仓库</h4></label>
								<div class="col-sm-3">
									<select  style="width: 50%;" name="facility_id" class="form-control">
                                    	<?php
										foreach ($facility_list as $facility) {
											if (isset ($facility_id) && $facility['facility_id'] == $facility_id) {
												echo "<option value=\"{$facility['facility_id']}\" selected='true'>{$facility['facility_name']}</option>";
											} else {
												echo "<option value=\"{$facility['facility_id']}\">{$facility['facility_name']}</option>";
											}
										}
										?>
                                    </select>
								</div>
								<label class="col-sm-2 control-label"><h4>商品名称</h4></label>
								<div class="col-sm-3">
									<input type="text" style="width: 50%;" class="form-control" name="product_name" id="product_name" value="<?php if(isset($product_name)) echo "{$product_name}"; ?>">
									<input type="hidden" id="product_id" name="product_id" <?php if(isset($product_id)) echo "value=\"{$product_id}\""; ?>/>
								</div>
							</div>
							
                         <div style="width: 100%;float:left;">
                                <div style="width:66%;float:left;text-align: center;">
                                    <input type="hidden" id="facility_id" value="<?php echo $facility_id?>">
                                    <input type="button" class="btn btn-primary btn-sm"  id="query"  value="搜索"> 
                                </div>
                         </div>
                 	</form>
                    
                    
                        <!-- product list start -->
                        <div class="row  col-sm-10 " style="margin-top: 10px;">
                            <table class="table table-striped table-bordered ">
                                <thead>
                                    <tr>
                                        <th>商品 </th>
                                        <th>单位</th>
                                        <th><?php echo $product_type_name?>操作</th>
                                    </tr>
                                </thead>
                            	<?php
								if (!empty ($material_product_list)) {
									foreach ($material_product_list as $product) {
								?>
                            		<tr>
                            			<td hidden="true" class="container_list"><?php echo json_encode($product['product_container_list'])?></td>
                                    	<td hidden="true" class="product_id"><?php echo $product['product_id']?></td>
                                    	<td hidden="true" class="unit_code"><?php echo $product['unit_code']?></td>
                            			<td class="product_name"><?php echo $product['product_name']?></td>
                            			<td class="unit_code"><?php echo $product['unit_code']?></td>
                            			<td class="product_cell">
                            				<?php if(! empty($product['product_container_list'])) {?>
                            					<button type="button" class="btn btn-primary returnMaterial" >申请退<?php echo $product_type_name?></button>
                            				<?php }?>
                            			</td>
                            		</tr>
                            	<?php


									}
								}
								?>
                                                            
                            </table>
                        </div>
                        <!-- product list end -->
                        <?php if (! isset($product_type) || $product_type != 'supplies') {?>
                        	
                        
                        <!-- product list start -->
                        <div class="row  col-sm-10 " style="margin-top: 10px;">
                            <table class="table table-striped table-bordered ">
                                <thead>
                                    <tr>
                                        <th>商品 </th>
                                        <th>单位</th>
                                        <th>次果操作</th>
                                        <th>坏果操作</th>
                                    </tr>
                                </thead>
                            	<?php
								if (!empty ($product_list)) {
									foreach ($product_list as $product) {
								?>
                            		<tr>
                                    	<td hidden="true" class="defective_qoh"><?php echo $product['defective_qoh']?></td>
                                    	<td hidden="true" class="history_unit_price"><?php echo $product['history_unit_price']?></td>
                                    	<td hidden="true" class="bad_qoh"><?php echo $product['bad_qoh']?></td>
                                    	<td hidden="true" class="product_id"><?php echo $product['product_id']?></td>
                                    	<td hidden="true" class="unit_code"><?php echo $product['unit_code']?></td>
                            			<td class="product_name"><?php echo $product['product_name']?></td>
                            			<td class="unit_code"><?php echo $product['unit_code']?></td>
                            			<td class="product_cell">
                            				<?php if($product['defective_qoh']) {?>
                            					<button type="button" class="btn btn-primary returnDefective">申请退次果</button>
                            				<?php }?>
                            			</td>
                            			<td class="product_cell">
                            				<?php if($product['bad_qoh']) {?>
                            					<button type="button" class="btn btn-primary returnBad">申请退坏果</button>
                            				<?php }?>
                            			</td>
                            		</tr>
                            	<?php


									}
								}
								?>
                                                            
                            </table>
                        </div>
                        <!-- product list end -->
                        <?php }?> 
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Modal -->
<div>
	<div class="modal fade ui-draggable" id="material_modal" role="dialog"  >
	  <div class="modal-dialog" style="width:100%">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" id="btnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">申请退<?php echo $product_type_name?></h4>
	      </div>
	      <input type="hidden" id="material_product_id">
	      <div class="modal-body " >
	      	<div class='row'>
		    <table id="material_table" name="material_table" border=3 style="width:100%">
				<tr>
					<th style="width: 5%;">ASN ITEM ID</th>
					<th style="width: 10%;">类型</th>
					<th style="width: 10%;">供应商</th>
					<th style="width: 10%;">采购员</th>
					<th style="width: 5%;">PRODUCT_ID</th>
					<th style="width: 5%;">商品</th>
					<th style="width: 5%;">箱规</th>
					<th style="width: 5%;">单位</th>
					<th style="width: 5%;">库存箱数</th>
					<th style="width: 5%;">箱数</th>
					<th style="width: 10%;" class='material_table_unit_price'>单价</th>
					<th style="width: 5%;">参考单价</th>
					<th style="width: 10%;">总价</th>
					<th style="width: 10%;">备注</th>
				</tr>
			</table>
	      	</div>
	      </div>
	    <div class="modal-footer">
	      	<input id="material_sub" type="button" class="btn btn-primary" style="text-align: right" value="提交申请">
	      </div>
	    </div>
	  </div>
	</div>
</div>
<!-- modal end  -->
<!-- Modal -->
<div>
	<div class="modal fade ui-draggable" id="defective_modal" role="dialog"  >
	  <div class="modal-dialog" style="width:100%">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" id="btnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">申请退次果</h4>
	      </div>
	      <input type="hidden" id="defective_product_id">
	      <input type="hidden" id="defective_qoh">
	      <div class="modal-body " >
	      	<div class='row'>
		    <table id="defective_table" name="defective_table" border=3 style="width:100%">
				<tr>
					<th style="width: 5%;">PRODUCT_ID</th>
					<th style="width: 10%;">类型</th>
					<th style="width: 10%;">商品</th>
					<th style="width: 10%;">供应商</th>
					<th style="width: 5%;">采购员</th>
					<th style="width: 5%;">单位</th>
					<th style="width: 5%;">库存</th>
					<th style="width: 5%;">数量</th>
					<th style="width: 10%;" class='defective_table_unit_price'>单价</th>
					<th style="width: 5%;">参考单价</th>
					<th style="width: 10%;">总价</th>
					<th style="width: 10%;">备注</th>
				</tr>
				<tr>
					<td id="modal_defective_product_id"></td>
					<td id="modal_defective_refund">
						<select>
                            <option value=""></option>
                            <option value="exchange">换货</option>
							<option value="return">退货</option>
							<option value="sale">销售</option>
						</select>
					</td>
					<td id="modal_defective_product_name"></td>
					<td hidden='true' id='defective_product_supplier_id' class='product_supplier_id'></td>
					<td id="modal_defective_supplier"><input type="text" id="defective_supplier"></td>
					<td hidden='true' id='defective_purchase_user_id' class='purchase_user_id'></td>
					<td id="modal_defective_purchase_user"><input type="text" id="defective_purchase_user"></td>
					<td id="modal_defective_unit_code"></td>
					<td id="modal_defective_inventory_quantity"></td>
					<td id="modal_defective_quantity" class='quantity'><input type="text"></td>
					<td id="modal_defective_unit_price" class='unit_price'><input type="text"></td>
					<td id="modal_defective_history_unit_price" class='history_unit_price'></td>
					<td id="modal_defective_total_price" class='total_price'><input type="text"></td>
					<td id="modal_defective_note"><input type="text"></td>
				</tr>
			</table>
	      	</div>
	      </div>
	    <div class="modal-footer">
	      	<input id="defective_sub" type="button" class="btn btn-primary" style="text-align: right" value="提交申请">
	      </div>
	    </div>
	  </div>
	</div>
</div>
<!-- modal end  -->
<!-- Modal -->
<div>
	<div class="modal fade ui-draggable" id="bad_modal" role="dialog"  >
	  <div class="modal-dialog" style="width:100%">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" id="btnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">申请退坏果</h4>
	      </div>
	      <input type="hidden" id="bad_product_id">
	      <input type="hidden" id="bad_qoh">
	      <div class="modal-body " >
	      	<div class='row'>
		    <table id="bad_table" name="bad_table" border=3 style="width:100%">
				<tr>
					<th style="width: 5%;">PRODUCT_ID</th>
					<th style="width: 10%;">类型</th>
					<th style="width: 10%;">商品</th>
					<th style="width: 10%;">供应商</th>
					<th style="width: 5%;">采购员</th>
					<th style="width: 5%;">单位</th>
					<th style="width: 5%;">库存</th>
					<th style="width: 5%;">数量</th>
					<th style="width: 10%;" class='bad_table_unit_price'>单价</th>
					<th style="width: 5%;">参考单价</th>
					<th style="width: 10%;">总价</th>
					<th style="width: 10%;">备注</th>
				</tr>
				<tr>
					<td id="modal_bad_product_id"></td>
					<td id="modal_bad_refund">
						<select>
                            <option value=""></option>
                            <option value="exchange">换货</option>
							<option value="return">退货</option>
							<option value="sale">销售</option>
						</select>
					</td>
					<td id="modal_bad_product_name"></td>
					<td hidden='true' id='bad_product_supplier_id' class='product_supplier_id'></td>
					<td id="modal_bad_supplier"><input type="text" id="bad_supplier"></td>
					<td hidden='true' id='bad_purchase_user_id' class='purchase_user_id'></td>
					<td id="modal_bad_purchase_user"><input type="text" id="bad_purchase_user"></td>
					<td id="modal_bad_unit_code"></td>
					<td id="modal_bad_inventory_quantity"></td>
					<td id="modal_bad_quantity" class='quantity'><input type="text"></td>
					<td id="modal_bad_unit_price" class='unit_price'><input type="text"></td>
					<td id="modal_bad_history_unit_price" class='history_unit_price'></td>
					<td id="modal_bad_total_price" class='total_price'><input type="text"></td>
					<td id="modal_bad_note"><input type="text"></td>
				</tr>
			</table>
	      	</div>
	      </div>
	    <div class="modal-footer">
	      	<input id="bad_sub" type="button" class="btn btn-primary" style="text-align: right" value="提交申请">
	      </div>
	    </div>
	  </div>
	</div>
</div>
<!-- modal end  -->

<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/common.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script>
$(document).ready(function(){
    getSuppliers();
	getRawMaterialList();
    getAreaPurchaseManagerList();
}) ;
 $("#query").click(function(){
     if ($("#product_name").val() == null || $("#product_name").val().trim() == "") {
     	$("#product_id").val("");
     }
     $("form").submit();
 }); 
WEB_ROOT = $("#WEB_ROOT").val();
product_type = "<?php if(isset($product_type)) echo $product_type?>";
function getRawMaterialList(){
		$.ajax({
			url:WEB_ROOT + "product/getProductList?product_type="+product_type,
			type:"get",
			dataType:"json",
			xhrFields: {
	            withCredentials: true
	        }
		}).done(function(data){
			if(data.res == "success"){
				autocoms($('#product_name'), data.product_list,  function(row, i, max) {
			    	return(row.product_name);
			    }).result(function(event, row, formatted) {
					$('#product_id').val(row.product_id);
				});
			}	
		});
	}

$('.returnMaterial').click(function(){       
	$('#material_table tr.content').remove();
	
	product_id = $(this).parent().parent().find('td.product_id').html();
	product_name = $(this).parent().parent().find('td.product_name').html();
	product_list = JSON.parse($(this).parent().parent().find('td.container_list').html());
	if(product_id == ''){
		alert('系统异常');
		return false;
	}
	$('.material_table_unit_price').html("单价（" + $(this).parent().parent().find('td.unit_code').html() + "）");
	$('#material_product_id').val(product_id);
	$('#material_modal').modal('show').on();
	for(var i = 0;i<product_list.length;i++){
		var lineIndex = $("#material_table tr.content").size();
		 var tr = $("<tr>");
		 tr.addClass('content');
		 
		 var td = $("<td>");
		 td.html(product_list[i].asn_item_id);
		 td.addClass('asn_item_id');
		 tr.append(td);
		 
		 
		td = $("<td>");
        td.attr('hidden','hidden');
        td.addClass('product_supplier_id');
        td.html(product_list[i].product_supplier_id);
        tr.append(td);

     	var select = $("<select>");
        var option0 = $("<option>");
        option0.attr("value","");
        option0.text("");
        var option1 = $("<option>");
        option1.attr("value","sale");
        option1.text("销售");
        var option2 = $("<option>");
        option2.attr("value","return");
        option2.text("退货");
        var option3 = $("<option>");
        option3.attr("value","exchange");
        option3.text("换货");

        select.append(option0);
        select.append(option3);
        select.append(option2);
        select.append(option1);
		var td = $("<td>");
		td.addClass('refund');
		td.append(select);
		tr.append(td);

        supplier = $("<input>");
        supplier.attr("required","required");
        supplier.autocomplete(productSupplierList, {
		    minChars: 0,
		    width: 310,
		    max: 100,
		    matchContains: true,
		    autoFill: false,
		    formatItem: function(row, i, max) {
		        return "[" + row.product_supplier_code + ']'+ row.product_supplier_name;
		    },
		    formatMatch: function(row, i, max) {
		        return row.product_supplier_code + row.product_supplier_name ;
		    },
		    formatResult: function(row) {
		    	return (row.product_supplier_name);
		    }
		}).result(function(event, row, formatted) {
			$(this).parent().parent().find('td.product_supplier_id').html(row.product_supplier_id);
			$(this).val(row.product_supplier_name);
		});
		supplier.val(product_list[i].product_supplier_name);
        td = $("<td>");
        td.addClass('supplier');
        td.append(supplier);
        tr.append(td);
        
        td = $("<td>");
        td.attr('hidden','hidden');
        td.addClass('purchase_user_id');
        td.html(product_list[i].purchase_user_id);
        tr.append(td);
        
        purchase_user = $("<input>");
        purchase_user.autocomplete(purchase_user_list, {
	      minChars: 0,
		    width: 310,
		    max: 100,
		    matchContains: true,
		    autoFill: false,
		    formatItem: function(row, i, max) {
		        return row.real_name;
		    },
		    formatMatch: function(row, i, max) {
		        return row.real_name ;
		    },
		    formatResult: function(row) {
		    	return (row.real_name);
		    }
		}).result(function(event, row, formatted) {
			$(this).parent().parent().find('td.purchase_user_id').html(row.user_id);
			$(this).val(row.real_name);
		});
		purchase_user.val(product_list[i].purchase_user_name);
        td = $("<td>");
        td.addClass('purchase_user');
        td.append(purchase_user);
        tr.append(td);
        
        var td = $("<td>");
		 td.html(product_list[i].product_id);
		 tr.append(td);
		 
		 var td = $("<td>");
		 td.html(product_list[i].product_name);
		 tr.append(td);
		 
		 var td = $("<td>");
		 td.addClass('container_quantity');
		 td.html(product_list[i].quantity);
		 tr.append(td);
		 
		 var td = $("<td>");
		 td.attr('hidden','hidden');
		 td.html(product_list[i].container_id);
		 td.addClass('container_id');
		 tr.append(td);
		 var td = $("<td>");
		 td.attr('hidden','hidden');
		 td.html(product_list[i].bol_item_id);
		 td.addClass('bol_item_id');
		 tr.append(td);
		 var td = $("<td>");
		 td.attr('hidden','hidden');
		 td.html(product_list[i].qoh);
		 td.addClass('inventory_quantity');
		 tr.append(td);
		 
		 var td = $("<td>");
		 td.html(product_list[i].unit_code);
		 tr.append(td);
		 
		 var td = $("<td>");
		 td.html(product_list[i].qoh);
		 tr.append(td);
		 
		 var input = $("<input>");
		 var td = $("<td>");
		 td.addClass('quantity');
		 td.append(input);
		 tr.append(td);
		 input.on('input',resetPrice);
		 
		 var input = $("<input>");
		 var td = $("<td>");
		 td.addClass('unit_price');
		 td.append(input);
		 tr.append(td);
		 input.on('input',calc);
		 
		 var td = $("<td>");
		 td.append(product_list[i].history_unit_price == "" ? "无" : product_list[i].history_unit_price);
		 tr.append(td);
		 
		 var input = $("<input>");
		 var td = $("<td>");
		 td.addClass('total_price');
		 td.append(input);
		 tr.append(td);
		input.on('input',calc);
		 
		 var input = $("<input>");
		 var td = $("<td>");
		 td.addClass('note');
		 td.append(input);
		 tr.append(td);
		 
		 $("#material_table tr").eq(lineIndex).after(tr);
	}
});

function calc(){
	var cls = $(this).parent().attr('class');
	quantity = $(this).parent().parent().find('td.quantity').find('input').val();
	container_quantity = $(this).parent().parent().find('td.container_quantity').html();
	price = $(this).val();
	if (container_quantity == null || container_quantity == "") {
		container_quantity = 1;
	}
	if (quantity == "" || isNaN(quantity) || parseFloat(quantity) < 0 ) {
		alert("请先输入正确的箱数");
		$(this).val("");
		$(this).parent().parent().find('td.quantity').find('input').focus();
		return;
	}
	if (price == "" || isNaN(price) || parseFloat(price) < 0 ) {
		alert("请输入的数字");
		$(this).focus();
		return;
	}
	if (cls == 'unit_price') {
		$(this).parent().parent().find('td.total_price').find('input').val(($(this).val() * quantity * container_quantity).toFixed(6));
	} else {
		$(this).parent().parent().find('td.unit_price').find('input').val(($(this).val() / quantity / container_quantity).toFixed(6));
	}
}

function resetPrice() {
	quantity = $(this).val();
	if (quantity == "" || isNaN(quantity) || parseFloat(quantity) < 0 ) {
		alert("请先输入正确的箱数");
		$(this).focus();
		return;
	}
	container_quantity = $(this).parent().parent().find('td.container_quantity').html();
	if (container_quantity == null || container_quantity == "") {
		container_quantity = 1;
	}
	if ($(this).parent().parent().find('td.unit_price').find('input').val() != "") {
		$(this).parent().parent().find('td.total_price').find('input').val(($(this).parent().parent().find('td.unit_price').find('input').val() * quantity * container_quantity).toFixed(6));
	}
}

$('.returnDefective').click(function(){
	product_id = $(this).parent().parent().find('td.product_id').html();
	product_name = $(this).parent().parent().find('td.product_name').html();
	unit_code = $(this).parent().parent().find('td.unit_code').html();
	history_unit_price = $(this).parent().parent().find('td.history_unit_price').html();
	defective_qoh = $(this).parent().parent().find('td.defective_qoh').html();
	if(product_id == ''){
		alert('系统异常');
		return false;
	}
	$("#defective_product_id").val(product_id);
	$("#defective_qoh").val(defective_qoh);
	$(".defective_table_unit_price").html("单价（" + unit_code +"）");
	$("#modal_defective_product_id").html(product_id);
	$("#modal_defective_product_name").html(product_name);
	$("#modal_defective_unit_code").html(unit_code);
	$("#modal_defective_inventory_quantity").html(defective_qoh);
	$("#modal_defective_quantity").find('input').val("");
	$("#modal_defective_unit_price").find('input').val("");
	$("#modal_defective_total_price").find('input').val("");
	$("#modal_defective_history_unit_price").html(history_unit_price == "" ? "无" : history_unit_price);
	$("#modal_defective_note").find('input').val("");
	
	$("#modal_defective_unit_price").find('input').bind("input",calc);
	$("#modal_defective_total_price").find('input').bind("input",calc);
	$("#modal_defective_quantity").find('input').bind("input",resetPrice);
	
	$("#defective_supplier").autocomplete(productSupplierList, {
	    minChars: 0,
	    width: 310,
	    max: 100,
	    matchContains: true,
	    autoFill: false,
	    formatItem: function(row, i, max) {
	        return "[" + row.product_supplier_code + ']'+ row.product_supplier_name;
	    },
	    formatMatch: function(row, i, max) {
	        return row.product_supplier_code + row.product_supplier_name ;
	    },
	    formatResult: function(row) {
	    	return (row.product_supplier_name);
	    }
	}).result(function(event, row, formatted) {
		$(this).parent().parent().find('td.product_supplier_id').html(row.product_supplier_id);
		$(this).val(row.product_supplier_name);
	});
	
	$("#defective_purchase_user").autocomplete(purchase_user_list, {
      minChars: 0,
	    width: 310,
	    max: 100,
	    matchContains: true,
	    autoFill: false,
	    formatItem: function(row, i, max) {
	        return row.real_name;
	    },
	    formatMatch: function(row, i, max) {
	        return row.real_name ;
	    },
	    formatResult: function(row) {
	    	return (row.real_name);
	    }
	}).result(function(event, row, formatted) {
		$(this).parent().parent().find('td.purchase_user_id').html(row.user_id);
		$(this).val(row.real_name);
	});
	
	$('#defective_modal').modal('show').on();
});

$('.returnBad').click(function(){
	product_id = $(this).parent().parent().find('td.product_id').html();
	product_name = $(this).parent().parent().find('td.product_name').html();
	unit_code = $(this).parent().parent().find('td.unit_code').html();
	history_unit_price = $(this).parent().parent().find('td.history_unit_price').html();
	bad_qoh = $(this).parent().parent().find('td.bad_qoh').html();
	if(product_id == ''){
		alert('系统异常');
		return false;
	}
	$("#bad_product_id").val(product_id);
	$("#bad_qoh").val(bad_qoh);
	$(".bad_table_unit_price").html("单价（" + unit_code +"）");
	$("#modal_bad_product_id").html(product_id);
	$("#modal_bad_product_name").html(product_name);
	$("#modal_bad_unit_code").html(unit_code);
	$("#modal_bad_inventory_quantity").html(bad_qoh);
	$("#modal_bad_quantity").find('input').val("");
	$("#modal_bad_unit_price").find('input').val("");
	$("#modal_bad_total_price").find('input').val("");
	$("#modal_bad_history_unit_price").html(history_unit_price == "" ? "无" : history_unit_price);
	$("#modal_bad_note").find('input').val("");
	$("#modal_bad_unit_price").find('input').bind("input",calc);
	$("#modal_bad_total_price").find('input').bind("input",calc);
	$("#modal_bad_quantity").find('input').bind("input",resetPrice);
	
	$("#bad_supplier").autocomplete(productSupplierList, {
	    minChars: 0,
	    width: 310,
	    max: 100,
	    matchContains: true,
	    autoFill: false,
	    formatItem: function(row, i, max) {
	        return "[" + row.product_supplier_code + ']'+ row.product_supplier_name;
	    },
	    formatMatch: function(row, i, max) {
	        return row.product_supplier_code + row.product_supplier_name ;
	    },
	    formatResult: function(row) {
	    	return (row.product_supplier_name);
	    }
	}).result(function(event, row, formatted) {
		$(this).parent().parent().find('td.product_supplier_id').html(row.product_supplier_id);
		$(this).val(row.product_supplier_name);
	});
	
	$("#bad_purchase_user").autocomplete(purchase_user_list, {
      minChars: 0,
	    width: 310,
	    max: 100,
	    matchContains: true,
	    autoFill: false,
	    formatItem: function(row, i, max) {
	        return row.real_name;
	    },
	    formatMatch: function(row, i, max) {
	        return row.real_name ;
	    },
	    formatResult: function(row) {
	    	return (row.real_name);
	    }
	}).result(function(event, row, formatted) {
		$(this).parent().parent().find('td.purchase_user_id').html(row.user_id);
		$(this).val(row.real_name);
	});
	

	$('#bad_modal').modal('show').on();
});

$('#material_sub').click(function(){
	product_id = $('#material_product_id').val();
	var items = [];
	var available = true;
	$('#material_table tr.content').each(function(){
		facility_id = $("#facility_id").val();
		return_type = $(this).find('td.refund select option:selected').val();
		container_id = $(this).find('td.container_id').html();
		asn_item_id = $(this).find('td.asn_item_id').html();
		bol_item_id = $(this).find('td.bol_item_id').html();
		product_supplier_id = $(this).find('td.product_supplier_id').html();
		purchase_user_id = $(this).find('td.purchase_user_id').html();
		inventory_quantity = $(this).find('td.inventory_quantity').html();
		quantity = $(this).find('td.quantity').find('input').val();
		unit_price = $(this).find('td.unit_price').find('input').val();
		total_price = $(this).find('td.total_price').find('input').val();
		note = $(this).find('td.note').find('input').val();
		
		if(quantity == '') {
			return true;
		} 

		if(return_type === ''){
            alert('类型不能为空');
            available = false;
            return false;
        }
		if (isNaN(quantity) || quantity < 0) {
			alert(quantity + " 错误");
			available = false;
			return false;
		}
		if (parseFloat(quantity) > parseFloat(inventory_quantity)) {
			alert(quantity + "箱已经超过系统库存");
			available = false;
			return false;
		}
		
		if (unit_price == '' || isNaN(unit_price) || unit_price < 0) {
			alert("请输入正确的单价");
			available = false;
			return false;
		}
		if($('#material_table tr.content .supplier input').val()==null||$('#material_table tr.content .supplier input').val()==""){
			alert("供应商不能为空");
			$('#material_table tr.content .supplier input').focus();
			return false;
		}
		if($('#material_table tr.content .purchase_user input').val()==null||$('#material_table tr.content .purchase_user input').val()==""){
			alert("采购员不能为空");
			$('#material_table tr.content .purchase_user input').focus();
			return false;
		}
		if (product_supplier_id == null || product_supplier_id == "") {
			alert("请选择供应商");
		}
		
		if (purchase_user_id == null || purchase_user_id == "") {
			alert("请选择采购员");
		}
		
		var item = {  
				'container_id': container_id,
				'return_type': return_type,
				'quantity':quantity,
				"unit_price":unit_price,
				"note":note,
				"total_price":total_price,
				"asn_item_id":asn_item_id,
				"bol_item_id":bol_item_id,
				"product_supplier_id":product_supplier_id,
				"purchase_user_id":purchase_user_id
				}
		items.push(item);
	});
	if(!available){
		return false;
	}

	if(product_id == '') {
		alert('操作失败');
		return false;
	}

	if(items.length == 0){
		alert('先填数量再提交');
		return false;
	}
	
	btn = $(this);
	var cf=confirm('是否确认');
	if (cf==false)
		return false;
	btn.attr('disabled',"true");
	submit_data = {
			'product_id':product_id,
			'facility_id':facility_id,
			'type':'raw_material',
			'items':items
			}
	var postUrl = $('#WEB_ROOT').val() + 'supplierReturnList/create';
    $.ajax({
        url: postUrl,
        type: 'POST',
        data:submit_data, 
        dataType: "json", 
        xhrFields: {
          withCredentials: true
        }
  	}).done(function(data){
  		console.log(data);
      if(data.success == "success"){
	      alert("提交成功");
	      location.reload();
      }else{
    	  btn.removeAttr('disabled');
          alert(data.error_info);
       }
    }).fail(function(data){
    	btn.removeAttr('disabled');
    });
});

$('#defective_sub').click(function(){
	product_id = $('#defective_product_id').val();
	return_type = $('#modal_defective_refund select option:selected').val();
	product_supplier_id = $('#defective_product_supplier_id').html();
	purchase_user_id = $('#defective_purchase_user_id').html();
	inventory_quantity = $('#defective_qoh').val();
	facility_id = $("#facility_id").val();
	var items = [];
	var available = true;
	quantity = $("#modal_defective_quantity").find('input').val();
	unit_price = $("#modal_defective_unit_price").find('input').val();
	total_price = $("#modal_defective_total_price").find('input').val();
	note = $("#modal_defective_note").find('input').val();
	
    if( return_type === '' ){
        alert('类型不能为空');
        available = false;
        return false;
    }
	if (isNaN(quantity) || quantity < 0) {
		alert("数量填写错误");
		return false;
	}
	if (parseFloat(quantity) > parseFloat(inventory_quantity)) {
		alert(quantity + "已经超过系统库存");
		return false;
	}
	if (unit_price == '' || isNaN(unit_price) || unit_price < 0) {
		alert("请输入正确的单价");
		return false;
	}
	if (product_supplier_id == null || product_supplier_id == "") {
		alert("请选择供应商");
		return false;
	}
	
	if (purchase_user_id == null || purchase_user_id == "") {
		alert("请选择采购员");
		return false;
	}
	
	if(product_id == '') {
		alert('操作失败');
		return false;
	}
	
	btn = $(this);
	var cf=confirm('是否确认');
	if (cf==false)
		return false;
	btn.attr('disabled',"true");
	submit_data = {
			'product_id':product_id,
			'return_type':return_type,
			'facility_id':facility_id,
			'product_supplier_id':product_supplier_id,
			'purchase_user_id':purchase_user_id,
			'type':'defective',
			'unit_price':unit_price,
			'quantity':quantity,
			'total_price':total_price,
			'note':note
			}
	//alert(JSON.stringify(submit_data));
	var postUrl = $('#WEB_ROOT').val() + 'supplierReturnList/create';
    $.ajax({
        url: postUrl,
        type: 'POST',
        data:submit_data, 
        dataType: "json", 
        xhrFields: {
          withCredentials: true
        }
  	}).done(function(data){
  		console.log(data);
      if(data.success == "success"){
	      alert("提交成功");
	      location.reload();
      }else{
    	  btn.removeAttr('disabled');
          alert(data.error_info);
       }
    }).fail(function(data){
    	btn.removeAttr('disabled');
    });
});

function getSuppliers(){
	var postUrl = $('#WEB_ROOT').val() + 'purchasePrice/getProductSupplierList?product_type='+product_type;
    $.ajax({
        url: postUrl,
        type: 'POST',
        dataType: "json", 
        xhrFields: {
          withCredentials: true
        }
  	}).done(function(data){
      if(data.success == "success"){
	      productSupplierList = data.product_supplier_list;
      }else{
       }
    }).fail(function(data){
    });
}
function getAreaPurchaseManagerList(){
    facility_id = $("#facility_id").val();
    submit_data = {'facility_id':facility_id};
	var postUrl = $('#WEB_ROOT').val() + 'purchasePrice/getAreaPurchaseManagerList?product_type='+product_type;
    $.ajax({
        url: postUrl,
        type: 'POST',
        data:submit_data, 
        dataType: "json", 
        xhrFields: {
          withCredentials: true
        }
  	}).done(function(data){
      if(data.success == "success"){
	      purchase_user_list = data.manager_list;
      }else{
       }
    }).fail(function(data){
    });
}
$("#query").click(function(){
    $("form").submit();
});

$('#bad_sub').click(function(){
	product_id = $('#bad_product_id').val();
	return_type = $('#modal_bad_refund select option:selected').val();
	product_supplier_id = $('#bad_product_supplier_id').html();
	purchase_user_id = $('#bad_purchase_user_id').html();
	inventory_quantity = $('#bad_qoh').val();
	facility_id = $("#facility_id").val();
	var items = [];
	var available = true;
	quantity = $("#modal_bad_quantity").find('input').val();
	unit_price = $("#modal_bad_unit_price").find('input').val();
	total_price = $("#modal_bad_total_price").find('input').val();
	note = $("#modal_bad_note").find('input').val();
	
    if(return_type === ''){
        alert('类型不能为空');
        available = false;
        return false;
    }
	if (isNaN(quantity) || quantity < 0) {
		alert("数量填写错误");
		return false;
	}
	if (parseFloat(quantity) > parseFloat(inventory_quantity)) {
		alert(quantity + "已经超过系统库存");
		return false;
	}
	
	if (unit_price == '' || isNaN(unit_price) || unit_price < 0) {
		alert("请输入正确的单价");
		return false;
	}
	if (product_supplier_id == null || product_supplier_id == "") {
		alert("请选择供应商");
		return false;
	}
	
	if (purchase_user_id == null || purchase_user_id == "") {
		alert("请选择采购员");
		return false;
	}
	if(product_id == '') {
		alert('操作失败');
		return false;
	}
	
	btn = $(this);
	var cf=confirm('是否确认');
	if (cf==false)
		return false;
	btn.attr('disabled',"true");
	submit_data = {
			'product_id':product_id,
			'return_type': return_type,
			'facility_id':facility_id,
			'product_supplier_id':product_supplier_id,
			'purchase_user_id':purchase_user_id,
			'type':'bad',
			'unit_price':unit_price,
			'total_price':total_price,
			'quantity':quantity,
			'note':note
			}
	var postUrl = $('#WEB_ROOT').val() + 'supplierReturnList/create';
    $.ajax({
        url: postUrl,
        type: 'POST',
        data:submit_data, 
        dataType: "json", 
        xhrFields: {
          withCredentials: true
        }
  	}).done(function(data){
  		console.log(data);
      if(data.success == "success"){
	      alert("提交成功");
	      location.reload();
      }else{
    	  btn.removeAttr('disabled');
          alert(data.error_info);
       }
    }).fail(function(data){
    	btn.removeAttr('disabled');
    });
});
</script>
</body>
</html>
