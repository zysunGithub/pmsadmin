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
    <link rel="stylesheet" type="text/css" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/lhgcalendar.css"/>
    
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
                	<form method="post" action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>transferException/facilityDiff">
                    
							<div class="row">
								<label for="start_time" class="col-sm-1 control-label"><h4>仓库</h4></label>
								<div  class="col-sm-3 control-label">
									<select style="width:200px" name="facility_id" id="facility_id" class="form-control">
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
                                <br/>
								<div class="col-sm-2">
									<input type="hidden" name="act" id="act" value="query">
                                    <button type="button" class="btn btn-primary btn-sm"  id="query"  >搜索 </button> 
                                      <span>&nbsp;</span>
                                    <button type="button" class="btn btn-primary btn-sm"  id="download" >导出</button>
								</div>
							</div>
                 	</form>
                    
                    
                        <!-- product list start -->
                        <div class="row  col-sm-10 " style="margin-top: 10px;">
                            <table class="table table-striped table-bordered ">
                                <thead>
                                    <tr>
                                        <th>出库仓库</th>
                                        <th>入库仓库</th>
                                        <th>调拨批次</th>
                                        <th>状态</th>
                                        <th>PRODUCT_ID</th>
                                        <th>商品</th>
                                        <th>箱规</th>
                                        <th>供应商</th>
                                        <th>装车批次</th>
                                        <th>六联单</th>
                                        <th>车牌号</th>
                                        <th>司机电话</th>
                                        <th>司机名字</th>
                                        <th>车队</th>
                                        <th>车型</th>
                                        <th>创建时间</th>
                                        <th>装车时间</th>
                                        <th>入库时间</th>
                                        <th>计划调拨数量</th>
                                        <th>装车数量</th>
                                        <th>入库数量</th>
                                        <th>盘亏数量</th>
                                        <th>追回数量</th>
                                        <th>差异</th>
                                        <th>备注</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                            	<?php
								if (!empty ($loading_bill_item_list)) {
									foreach ($loading_bill_item_list as $loading_bill_item) {
								?>
                            		<tr>
                            			<td class="product_cell"><?php echo $loading_bill_item['from_facility_name']?></td>
                            			<td class="product_cell"><?php echo $loading_bill_item['to_facility_name']?></td>
                            			<td class="product_cell"><?php echo $loading_bill_item['ti_sn']?></td>
                            			<td class="product_cell"><?php echo $loading_bill_item['inventory_status'] == "FINISH" ? "已入库" : "未入库"?></td>
                                        <td class="product_cell"><?php echo $loading_bill_item['product_id']?></td>
                            			<td class="product_cell"><?php echo $loading_bill_item['product_name']?></td>
                            			<td class="product_cell"><?php echo $loading_bill_item['container_quantity'] .  $loading_bill_item['unit_code']?>/箱</td>
                            			<td class="product_cell"><?php echo $loading_bill_item['product_supplier_name']?></td>
                            			<td class="product_cell"><?php echo $loading_bill_item['bol_sn']?></td>
                                        <td class="product_cell"><?php echo $loading_bill_item['invoice_no']?></td>
                            			<td class="product_cell"><?php echo $loading_bill_item['car_num']?></td>
                            			<td class="product_cell"><?php echo $loading_bill_item['driver_mobile']?></td>
                            			<td class="product_cell"><?php echo $loading_bill_item['driver_name']?></td>
                                        <td class="product_cell"><?php echo $loading_bill_item['car_provider']?></td>
                                        <td class="product_cell"><?php echo $loading_bill_item['car_model']?></td>
                            			<td class="product_cell"><?php echo $loading_bill_item['ti_created_time']?></td>
                            			<td class="product_cell"><?php echo $loading_bill_item['bol_created_time']?></td>
                            			<td class="product_cell"><?php echo $loading_bill_item['finish_time']?></td>
                            			<td class="product_cell"><?php echo $loading_bill_item['plan_case_num']?></td>
                            			<td class="product_cell"><?php echo $loading_bill_item['from_quantity']?></td>
                            			<td class="product_cell"><?php echo $loading_bill_item['to_quantity']?></td>
                            			<td class="product_cell"><?php echo $loading_bill_item['variance_quantity']?></td>
                            			<td class="product_cell"><?php echo $loading_bill_item['return_quantity']?></td>
                            			<td class="product_cell transit_quantity"><?php echo $loading_bill_item['transit_quantity']?></td>
                            			<td class="product_cell"><?php echo $loading_bill_item['note']?></td>
                                        <td class="product_cell">
                                        	<?php if($this->helper->chechActionList(array('superTransferVairance'))) {?>
                                        		<input type="button" class="btn btn-warning variance_btn" id="variance_btn" value="盘亏"><br><br>
                                        		<input type="button" class="btn btn-primary return_btn" id="return_btn" value="追回">
                                        	<?php } elseif ($this->helper->chechActionList(array('transferVairance'))) {?>
                                        		<?php if(empty($loading_bill_item['variance_quantity']) || $loading_bill_item['variance_quantity'] == 0) {?>
                                        			<input  type="button" class="btn btn-warning variance_btn" id="variance_btn" value="盘亏"><br><br>
                                        		<?php }?>
                                        		<?php if(empty($loading_bill_item['return_quantity']) || $loading_bill_item['return_quantity'] == 0) {?>
                                        			<input  type="button" class="btn btn-primary return_btn" id="return_btn" value="追回">
                                        		<?php }?>
                                        	<?php }?>
                                        </td>
                                        <td class="bol_item_id" hidden="hidden"><?php echo $loading_bill_item['bol_item_id']?></td>
                            		</tr>
                            	<?php


									}
								}
								?>
                                                            
                            </table>
                        </div>
                        <!-- product list end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<div class="modal fade" id="fix_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" id="modal_close" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">操作</h4>
      </div>
      <div class="modal-body">
        <div class="container">
            <div class="row col-md-10">
             <div class="col-md-2">
                   <h5>  数量: </h5>
                </div>
                <div class="col-md-4" >
                   <input type="text"  class="form-control"  id="qoh">
                </div>
                <div class="col-md-6"></div>
            </div>
            <div class="row col-md-10">
                <div class="col-md-2">
                   <h5>  备注: </h5>
                </div>
                <div class="col-md-4" >
                   <input type="text"  class="form-control" id="note">
                </div>
                <div class="col-md-6"></div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
      	<input type="hidden" id="bol_item_id">
      	<input type="hidden" id="transit_quantity">
      	<input type="hidden" id="text">
      	<input type="hidden" id="type">
        <button type="button" class="btn btn-primary" id="modal_commit" data-dismiss="modal">确定</button>
      </div>
    </div>
  </div>
</div>

<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/lhgcalendar.min.js"></script>
<script>

var property={
    divId:"demo1",
    needTime:true,
    yearRange:[1970,2030],
    week:['日','一','二','三','四','五','六'],
    month:['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月'],
    format:"yyyy-MM-dd hh:mm:00"
};

(function(config){
    config['extendDrag'] = true; // 注意，此配置参数只能在这里使用全局配置，在调用窗口的传参数使用无效
    config['lock'] = true;
    config['fixed'] = true;
    config['okVal'] = 'Ok';
    config['format'] = 'yyyy-MM-dd HH:mm:ss';
    // [more..]
})($.calendar.setting);
$(document).ready(function(){
    $("#end_time").calendar({btnBar:true,
                   minDate:'2010-05-01', 
                   maxDate:'2022-05-01'});
});

$('.variance_btn').click(function(){
	fixDiff('VARIANCE',$(this),'盘亏');
});
$('.return_btn').click(function(){
	fixDiff('RETURN',$(this),'追回');
});
$("#query").click(function(){
         $("#page_current").val("1");
         $("#act").val("query");
         $("form").submit();
     }); 
     
 // 点击下载 excel 按钮 
 $('#download').click(function(){
    $("#act").val("download");
    $("form").submit();
 }); 

function fixDiff(type,btn,text){
	bol_item_id = btn.parent().parent().find('td.bol_item_id').html();
	diff_num = btn.parent().parent().find('td.transit_quantity').html();
	$("#bol_item_id").val(bol_item_id);
	$("#transit_quantity").val(diff_num);
	$("#text").val(text);
	$("#type").val(type);
	$("#fix_modal").modal("show");
}
$("#modal_commit").click(function () {
	var qoh = $("#qoh").val().trim();
	var diff_num = $("#transit_quantity").val();
	var note = $("#note").val();
	var text = $("#text").val();
	var type = $("#type").val();
	if(!/^(\+|-)?(\d+)(\.\d*)?$/g.test(qoh)){
		alert('请输入数字');
		return false;
	}
	qoh = parseFloat(qoh);
	diff_num = parseFloat(diff_num);
	if (qoh <= 0) {
		alert("请输入正数");
		return false;
	}

	if(diff_num < qoh){
		alert('不能大于差异数量');
		return false;
	}

	var cf=confirm( text + qoh + ',是否确认' )
		
	if (cf==false)
		return false;
	if (parseFloat(diff_num) != parseFloat(qoh)) {
		if(!confirm("数量小于差异数量，真的确认吗")) {
			return false;
		}
	}
	$("#modal_commit").attr("disabled", 'disabled');
	var postUrl = $('#WEB_ROOT').val() + 'transferException/fixDiff';
	submit_data = {'bol_item_id':bol_item_id,'type':type,'qoh':qoh,'note':note}
    $.ajax({
        url: postUrl,
        type: 'POST',
        data: submit_data, 
        dataType: "json", 
        xhrFields: {
          withCredentials: true
        }
  	}).done(function(data){
	  if(data.success == "success"){
		  alert(text + '成功');
		  location.reload();
	  } else{
		  alert(data.error_info);
		  $("#modal_commit").removeAttr('disabled');
	  }
  	}).fail(function(data){
	  alert(text + '失败');
	   $("#modal_commit").removeAttr('disabled');
  	});
	
});
</script>
</body>
</html>
