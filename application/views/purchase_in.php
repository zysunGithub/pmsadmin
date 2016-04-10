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
    <!-- <link rel="stylesheet" type="text/css" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/js/calendar/GooCalendar.css"/> -->
    <link rel="stylesheet" type="text/css" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/lhgcalendar.css"/>
    <link rel="stylesheet" type="text/css" href="<?php if (isset($WEB_ROOT)) echo $WEB_ROOT; ?>assets/css/mobiscroll.core-2.5.2.css" />
    <link rel="stylesheet" type="text/css" href="<?php if (isset($WEB_ROOT)) echo $WEB_ROOT; ?>assets/css/mobiscroll.animation-2.5.2.css" />
    
    <style type="text/css">
        tr td.product_cell{
            text-align: center;
            vertical-align:middle;
            height: 100%;
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
                    <label for="receive_name" class="col-sm-2 control-label">仓库：</label>
            		<div  class="col-sm-3">
                    	<select  style="width: 45%;" name="facility_id" id="facility_id" class="form-control" <?php if(isset($loading_bill)) echo "disabled=\"true\""?>>
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
                    <label for="receive_name" class="col-sm-2 control-label">扫描装车单：</label>
                    <div class="col-md-2">
						<input type="text" name="bol_sn" id="bol_sn" class="form-control" <?php if(isset($loading_bill)) echo " value=\"{$bol_sn}\" readOnly=\"true\""; ?>>
					</div>
                </div>
            </div>
            
            
            <?php if (isset($loading_bill)){?>
            
            <!-- loading_bill start -->
            <div class="row col-sm-10 " style="margin-left: 10px;margin-top: 10px;">
                <table class="table table-striped table-bordered" id="bill_list_table">
                    <tr>
                        <th>装车批次</th>
                        <th>六联单</th>
                        <th>车牌号</th>
                        <th>司机电话</th>
                        <th>司机名字</th>
                        <th>车队</th>
                        <th>车型</th>
                        <th>装车时间</th>
                        <th>实际发车时间</th>
                        <th>预估到货时间</th>
                        <th>实际到货时间</th>
                        <th>备注</th>
                    </tr>
                    <tr id="aa">
	                    <td><?php echo $loading_bill['bol_sn']?></td>
                        <td><?php echo $loading_bill['invoice_no']?></td>
	                    <td><?php echo $loading_bill['car_num']?></td>
	                    <td><?php echo $loading_bill['driver_mobile']?></td>
	                    <td><?php echo $loading_bill['driver_name']?></td>
                        <td><?php echo $loading_bill['car_provider']?></td>
                        <td><?php echo $loading_bill['car_model']?></td>
	                    <td><?php echo $loading_bill['created_time'] ?></td>
                        <td><?php echo $loading_bill['setoff_time'] ?></td>
                        <td><?php echo $loading_bill['estimated_arrival_time'] ?></td>
                        <td><?php
                            if (isset($loading_bill['arrival_time']) && $loading_bill['arrival_time'] != "") {
                                echo $loading_bill['arrival_time'];
                            } else { ?>
                            必须先选择到货时间才能入库
                            <input type="text" id="arrival_time" name="arrival_time" onchange="setArrivalTime(this, '<?php echo $facility_id; ?>', '<?php echo $loading_bill['bol_sn']; ?>');" />
                            <?php } ?>
                        </td>
	                    <td><?php echo $loading_bill['note']?></td>
	                </tr>
                </table>
                <table style="display:none;">
                </table>
            </div>
            <!-- loading_bill end -->
            
            
            
            <!-- loading_bill_item start -->
            <div class="row col-sm-10 " style="margin-left: 10px;margin-top: 10px;">
                <input type="hidden" id="bol_id" name="bol_id" <?php echo " value=\"{$loading_bill['bol_id']}\""; ?> >
                <table class="table table-striped table-bordered" id="bill_item_list_table">
                    <tr>
                    	<th>PRODUCT_ID</th>
                        <th>商品</th>
                        <th>供应商</th>
                        <th>纸箱条码</th>
                        <th>采购箱数</th>
                        <th>纸箱规格</th>
                        <th>已入库数量</th>
                        <?php if($container_revisable) {?>
                        <th>实际入库明细</th>
                        <?php }?>
                        <th>重量（kg）</th>
                        <th>操作</th>
                    </tr>
                    <?php 
                    	if (isset($loading_bill_item_list)) {
                    		foreach ($loading_bill_item_list as $loading_bill_item) {
                    			?>
                    <tr class="content">
                    	<td><?php echo $loading_bill_item['product_id']?></td>
                    	<td><?php echo $loading_bill_item['product_name']?></td>
                    	<td><?php echo $loading_bill_item['product_supplier_name']?></td>
                        <td><?php echo $loading_bill_item['container_code']?></td>
                        <td><?php echo $loading_bill_item['purchase_case_num']?></td>
                        <td><?php echo ($loading_bill_item['unit_code'] == "ge" ? intval($loading_bill_item['quantity']) : $loading_bill_item['quantity'] ). ($loading_bill_item['unit_code'] == "ge" ? "个" : "KG") . "/箱"?>
                        <td><?php echo $loading_bill_item['finish_case_num']?></td>
                        </td>
                        <?php if($container_revisable) {?>
                        <td><?php echo $loading_bill_item['inventory_container_detail']?></td>
                        <?php }?>
                        <td><?php echo $loading_bill_item['weight']?></td>
                        <td>
                        <?php
                        if(isset($loading_bill['arrival_time']) && $loading_bill['arrival_time']!=""){
                        if($loading_bill_item['inventory_status'] == "FINISH") {
                        	echo "已入库";
                        	if ($this->helper->chechActionList(array('superPurchaseIn')) && ($loading_bill_item['purchase_case_num'] - $loading_bill_item['finish_case_num'] > 0)) {?>
                        		<input type="button" class="btn btn-warning" value="二次入库" onclick="detail_modal(<?php echo $loading_bill_item['bol_item_id']?>,'<?php echo $loading_bill_item['product_name']?>','<?php echo $loading_bill_item['unit_code']?>','<?php echo $loading_bill_item['quantity']?>', '<?php echo $loading_bill_item['purchase_case_num']?>', '<?php echo $loading_bill_item['product_supplier_name']?>','<?php echo $loading_bill_item['finish_case_num']?>')" >
                        	<?php }
                        	
                        } else {
                        	?>
	                        <input type="button" class="btn btn-primary" value="入库" onclick="detail_modal(<?php echo $loading_bill_item['bol_item_id']?>,'<?php echo $loading_bill_item['product_name']?>','<?php echo $loading_bill_item['unit_code']?>','<?php echo $loading_bill_item['quantity']?>', '<?php echo $loading_bill_item['purchase_case_num']?>', '<?php echo $loading_bill_item['product_supplier_name']?>','<?php echo $loading_bill_item['finish_case_num']?>')" >
                        <?php }	
                        }else{
                            echo "请先确认实际到货时间";
                        }?>
                        </td>
                    </tr>		
                    			<?php
                    		}
                    	}
                    ?>
                </table>
            </div>
            <!-- loading_bill_item end -->
            <?php }?>
        </div>
    </div>
<div>
<div class="modal fade ui-draggable  text-center" id="detail_modal" role="dialog"  >
   <div class="modal-dialog" style="display: inline-block;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" id="btnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">入库</h4>
      </div>
      <div class="modal-body ">
      <div class='row'>
				<label for="modal_product_name" style="text-align: right;">商品：</label><input type="text" style="color: red" disabled="disabled" id="modal_product_name">
				<label for="modal_unit_code" style="text-align: right;">单位：</label><input type="text" style="color: red" disabled="disabled" id="modal_unit_code">
		</div>
		<div class='row'>
				<label for="modal_product_supplier_name" style="text-align: right;">供应商：</label><input type="text" style="color: red" disabled="disabled" id="modal_product_supplier_name">
				<label for="modal_purchase_case_num" style="text-align: right;">采购箱数：</label><input type="text" style="color: red" disabled="disabled" id="modal_purchase_case_num">
		</div>
        <div class="row" style="text-align: left;padding-left: 33px;">
            <?php if ($facility_type == 'EntityFacility') {?>
            <label for="weight" style="text-align: right;">重量：(kg)</label><input type="text" style="color: red" id="weight">
            <?php }?>
            <input type="hidden" id="modal_bol_item_id" value="">
            <input type="hidden" id="finish_case_num" value="">
            <?php if($container_revisable) {?>
                <input id="modal_add_item" type="button" class="btn btn-primary btn-sm" style="text-align: left;margin-left: 35px" value="添加">
            <?php }?>
        </div>
			<table id="modal_table" name="modal_table" border=3 style="width: 550px">
				<tr>
					<th id="modal_container_quantity">箱规</th>
					<th id="modal_quantity">箱数</th>
					<th width="50px">操作</th>
				</tr>
			</table>
      </div>
      <div class="modal-footer">
      <div class="row"><button class="btn btn-success btn-lager" id="add_to_asn_btn" style="margin-left: 50px">提交</button></div>
      </div>
    </div>
  </div>
	</div>
</div>
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if (isset($WEB_ROOT)) echo $WEB_ROOT; ?>assets/js/mobiscroll.core-2.5.2.js"></script>
<script type="text/javascript" src="<?php if (isset($WEB_ROOT)) echo $WEB_ROOT; ?>assets/js/mobiscroll.core-2.5.2-zh.js"></script>
<script type="text/javascript" src="<?php if (isset($WEB_ROOT)) echo $WEB_ROOT; ?>assets/js/mobiscroll.datetime-2.5.1.js"></script>
<script type="text/javascript" src="<?php if (isset($WEB_ROOT)) echo $WEB_ROOT; ?>assets/js/mobiscroll.datetime-2.5.1-zh.js"></script> 

<script>
$(document).ready(function(){
    $('#bol_sn').bind('keyup', listen_bol_sn).focus();
    var currYear = (new Date()).getFullYear();
    var opt = {
        dateFormat: 'yy-mm-dd',
        preset: 'date',
        theme: 'android-ics light', //皮肤样式
        display: 'modal', //显示方式
        mode: 'scroller', //日期选择模式
        preset: 'date', //日期
        dateOrder: 'yymmdd', //面板中日期排列格
        dateFormat: 'yy-mm-dd', // 日期格式
        lang: 'zh',
        setText: '确定', //确认按钮名称
        cancelText: '取消', //取消按钮
        dayText: '日', monthText: '月', yearText: '年', //面板中年月日文字    
        endYear: currYear + 10 //结束年份
    };
    $("#arrival_time").mobiscroll(opt).datetime(opt);
});
var KEY = {
    RETURN: 13,  // 回车
    CTRL: 17,    // CTRL
    TAB: 9
};
function listen_bol_sn(event) {
    switch (event.keyCode) {
        case KEY.RETURN:
            load_bol_sn();
            event.preventDefault();
            break;
    }
}

function detail_modal(bol_item_id,product_name,unit_code,container_quantity,purchase_case_num, product_supplier_name,finish_case_num){
    $("#weight").val('');
    $("#modal_bol_item_id").val(bol_item_id);
    $("#finish_case_num").val(finish_case_num);
    $("#modal_product_name").val(product_name);
    $("#modal_unit_code").val(unit_code);
    $("#modal_purchase_case_num").val(purchase_case_num);
    $("#modal_product_supplier_name").val(product_supplier_name);
	$("#modal_table tr.content").remove();
	var lineIndex = $("#modal_table tr.content").size();
	var tr = $("<tr>");
	tr.addClass('content');
	
	container_quantity_input = $("<input>");
	container_quantity_input.val(container_quantity);
	<?php if(isset($container_revisable) && !$container_revisable) {?>
		container_quantity_input.attr('readonly','true');
	<?php }?>
    td = $("<td>");
    td.addClass('container_quantity');
    td.append(container_quantity_input);
    td.append(unit_code + "/箱");
    tr.append(td);
	
	quantity = $("<input>");
    td = $("<td>");
    td.addClass('quantity');
    td.append(quantity);
    tr.append(td);

	delbtn = $("<input>");
	delbtn.width('50px');
	delbtn.val('删');
	delbtn.attr("type","button");
	delbtn.addClass("btn-danger");
	delbtn.addClass("add_modal_deltr");
	delbtn.click(deltr);
	td = $("<td>");
	td.append(delbtn);
	tr.append(td);
	$("#modal_table tr").eq(lineIndex).after(tr);
    $('#detail_modal').modal('show').on();
}

$("#modal_add_item").click(function(c_qoh) {
    var lineIndex = $("#modal_table tr.content").size();
    var unit_code = $("#modal_unit_code").val();
	var tr = $("<tr>");
	tr.addClass('content');
	
	container_quantity = $("<input>");
    td = $("<td>");
    td.addClass('container_quantity');
    td.append(container_quantity);
    td.append(unit_code + "/箱");
    tr.append(td);
	
	quantity = $("<input>");
    td = $("<td>");
    td.addClass('quantity');
    td.append(quantity);
    tr.append(td);

	delbtn = $("<input>");
	delbtn.width('50px');
	delbtn.val('删');
	delbtn.attr("type","button");
	delbtn.addClass("btn-danger");
	delbtn.addClass("add_modal_deltr");
	delbtn.click(deltr);
	td = $("<td>");
	td.append(delbtn);
	tr.append(td);
	$("#modal_table tr").eq(lineIndex).after(tr);
});

//删除行
function deltr(){
	$(this).parent().parent().remove();
}

$('#add_to_asn_btn').click(function(){
	var bol_item_id = $('#modal_bol_item_id').val();
    var facility_id = $('#facility_id').val();
	var purchase_case_num = $("#modal_purchase_case_num").val();
    var finish_case_num = parseFloat($("#finish_case_num").val() || 0);
    var unit_code = $("#modal_unit_code").val();
    var weight = $("#weight").val();
	var items = [];
	var available = true;
    var weight_for_calculation = 0;
    var finish_case_num_less = finish_case_num;//已入库的箱数
	$('#modal_table tr.content').each(function(){
		var facility_type = "<?php echo $facility_type?>"; 
		var container_quantity = $(this).find('td.container_quantity').find('input').val();
		quantity = $(this).find('td.quantity').find('input').val();
		if (container_quantity == null || container_quantity == "" || isNaN(container_quantity) || container_quantity < 0 || parseFloat(container_quantity) < 0) {
			available = false;
			alert("请输入正确箱规");
			return false;
		}

		if (quantity == null || quantity == "" || isNaN(quantity) || quantity < 0 || parseInt(quantity) != quantity) {
			available = false;
			alert("请输入正确箱数");
			return false;
		}
        if (facility_type == 'EntityFacility' && (!weight || isNaN(weight))) {
            alert("请输入正确重量(纯数字)");
            $("#weight").val('').focus();
            return false;
        };

		finish_case_num += parseFloat(quantity);
		var item = { 
			'container_quantity':container_quantity,
			'quantity':quantity
		}
        weight_for_calculation += parseFloat(container_quantity) * parseFloat(quantity);
		items.push(item);
	});
	if(!available){
		return false;
	}
	if(items.length == 0){
		alert('先填数量再提交');
		return false;
	}
	if (parseFloat(finish_case_num) > parseFloat(purchase_case_num)) {
		alert("入库箱数不能大于采购箱数");
		return false;
	}
    if (unit_code == 'kg' || unit_code == '斤') {
        if (weight < weight_for_calculation) {
            alert('称重必须大于箱数*箱规');
            return;
        };
    };

	btn = $(this);
	var cf=confirm('是否确认');
	if (cf==false)
		return false;
	btn.attr('disabled',"true");
	var submit_data = {
		"bol_item_id":bol_item_id,
		"data":items,
        "weight":weight,
        'unit_code': unit_code,
        'facility_id': facility_id
	};
	var postUrl = $('#WEB_ROOT').val() + 'purchaseIn/createPurchaseTransaction';
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
          $("#weight").val('');
	      $('#detail_modal').modal('hide');
	      location.reload();
      }else{
    	  btn.removeAttr('disabled');
          alert(data.error_info);
        }
    }).fail(function(data){
    	console.log(data);
    	btn.removeAttr('disabled');
	  	alert('入库失败');
    });
});


function load_bol_sn() {
    var bol_sn = $.trim($('#bol_sn').val());
    var facility_id = $('#facility_id').val();
    if (bol_sn == '') {
        alert('请先输入装车单号');
        return; 
    }
    var product_type = "<?php echo isset($product_type) ? $product_type : ""?>";
    location.href =  $("#WEB_ROOT").val()+"purchaseIn/index?product_type="+product_type+"&bol_sn="+bol_sn+"&facility_id="+facility_id;
}
function setArrivalTime(event, facility_id, bol_sn) {
        var cf=confirm('是否确认');
        if (cf==false)
        return false;
        var arrival_time = $(event)[0].value;
        var bol_sn = bol_sn;
        var submit_data;
        submit_data = {
            'arrival_time': arrival_time,
            'bol_sn': bol_sn
        };
        var postUrl = $('#WEB_ROOT').val() + 'loadingBillList/setLoadingBillArrivalTime';
        $.ajax({
            url: postUrl,
            type: 'POST',
            data: submit_data,
            dataType: "json",
            xhrFields: {
                withCredentials: true
            }
        }).done(function (data) {
        if (data.success == "success") {
            alert('到货时间添加成功');
            window.location.reload();
        } else {
            alert(data.error_info);
        }
        }).fail(function (data) {
            alert('添加失败');
        });
}
</script>
</body>
</html>
