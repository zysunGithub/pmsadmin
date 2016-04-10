<!doctype html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta name="viewport"
	content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="format-detection" content="telephone=no">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-store">
<meta http-equiv="Expires" content="0">
<title>拼好货WMS</title>
<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">

<link rel="stylesheet" type="text/css" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/mobiscroll.core-2.5.2.css" />
<link rel="stylesheet" type="text/css" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/mobiscroll.animation-2.5.2.css" />
<!--[if lt IE 9]>
        <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <![endif]-->
<style>
    .content td{
        border-bottom: 1px solid #999;
    }
</style>
</head>
<body>
	<input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> >
	<input type="hidden" id="readonly"  <?php if(isset($readonly)) echo "value={$readonly}"; ?> >
	<div class="container-fluid"
		style="margin-left: -18px; padding-left: 19px;">
		<div role="tabpanel" class="row tab-product-list tabpanel">
			<div class="col-md-12">
			    <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="onsale">
                        <form style="width:100%;"  action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>loadingBillList<?php if( !empty( $product_type ) && $product_type == "supplies" ) echo '/suppliesIndex'; ?>">
                                <table >
                                <tr>
                                    <td><label for="facility_id"  class=" col-sm-1 control-label">仓库：</label></td>
                                    <td><select style="width:100%;" id="facility_id" name="facility_id" class="form-control">
                                		<?php foreach ( $facility_list as $facility ) {
											if (isset( $facility_id ) && $facility ['facility_id'] == $facility_id) {
												echo "<option value=\"{$facility['facility_id']}\" selected='true'>{$facility['facility_name']}</option>";
											} else {
												echo "<option value=\"{$facility['facility_id']}\">{$facility['facility_name']}</option>";
											}
										} ?>
                                        </select>
                                    </td>
                                    <td><label>装车时间</label></td>
                                    <td><input type="text" id="start_date" name="start_date" class="form-control" value="<?php echo $start_date;?>" style="width:100%;"></td>    
                                   	<td><label>到</label></td>
                                    <td><input type="text" id="end_date" name="end_date" value="<?php echo $end_date;?>" class="form-control" style="width:100%;" ></td>    
                                    <td> <div style="margin-left: 60px;text-align: center;">
                                    <button type="button" class="btn btn-primary btn-sm"  id="query"  >搜索 </button>  
                                    </div></td>
                                </tr>
                                </table>
                         <input type="hidden" name="product_type" value="<?php echo $product_type; ?>" />
                         <input type="hidden"  <?php if(isset($asn_date)) echo "value='{$asn_date}'"; ?>  id="hidden_asn_date" > 
                        </form>
        
                        <!-- product list start -->
                        <div class="row  col-sm-10 " style="margin-top: 10px;">
                            <table class="table table-striped table-bordered ">
                                <thead>
                                    <tr>
                                    	<th> 车牌号 </th>
                                        <th> 装车批次 </th>
                                        <th> 六联单 </th>
                                        <th> 状态</th>
                                        <th> 类型</th>
                                        <th style="width:20%;"> 装车时间 </th>
                                        <th style="width:20%;"> 实际发车时间 </th>
                                        <th style="width:20%;"> 预计到货时间 </th>
                                        <th style="width:20%;"> 实际到货时间 </th>
                                        <th style="width:20%;"> 入库时间 </th>
                                        <th>车费</th>
                                        <th>装车费</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                                            
                                <?php if( isset($loading_bill_list) && is_array($loading_bill_list))  { ?> 
                                <tbody >
                                    <?php foreach ($loading_bill_list as $key => $loading_bill) { 
                                    	?>
                                    <tr>
                                        <td><?php echo $loading_bill['car_num'] ?></td>
                                        <td><?php echo $loading_bill['bol_sn'] ?></td>
                                        <td><?php echo $loading_bill['invoice_no'] ?></td>
                                        <td><?php echo $loading_bill['status'] ?></td>
                                        <td><?php 
                                        if($loading_bill['asn_type'] == 'PO') {
                                        	echo '采购';
                                        }elseif ($loading_bill['asn_type'] == 'TI'){
                                        	echo '仓库调拨';
                                        }
                                        ?></td>
                                        <td><?php echo $loading_bill['created_time'] ?></td>
                                        <td><?php echo $loading_bill['setoff_time'] ?></td>
                                        <td><?php echo $loading_bill['estimated_arrival_time'] ?></td>
                                        <td><?php
                                                    
                                                        if (isset($loading_bill['arrival_time']) && $loading_bill['arrival_time'] != "") {
                                                            echo $loading_bill['arrival_time'];
                                                        } else {
                                                            if ($this->helper->chechActionList(array('purchaseIn'))) {
                                                            ?>
                                                            必须先选择到货时间才能入库
                                                            <input type="text"  name="arrival_time" onchange="setArrivalTime(this, '<?php echo $facility_id; ?>', '<?php echo $loading_bill['bol_sn']; ?>');" />
                                                            <?php
                                                            } else { 
                                                            ?>
                                                                 权限不足
                                                            <?php }
                                                        } ?>
                                                       
                                                   
                                        </td>
                                        <td><?php echo !empty($loading_bill['finishtime'])?$loading_bill['finishtime']:0 ?></td>
                                        
                                        <td><?php echo !empty($loading_bill['deliver_price'])?$loading_bill['deliver_price']:0?>
                                        <td><?php echo !empty($loading_bill['loading_price'])?$loading_bill['loading_price']:0?>
                                        <td><a class="btn btn-info" href="javascript:void(0)" 
                                        	onclick="detail(<?php echo $loading_bill['bol_id'] ?>, '<?php echo $loading_bill['bol_sn']?>',
                                        	'<?php echo $loading_bill['driver_name']?>','<?php echo $loading_bill['driver_mobile']?>',
                                            '<?php echo $loading_bill['car_provider']?>','<?php echo $loading_bill['car_model']?>',
                                        	'<?php echo $loading_bill['car_num']?>','<?php echo $loading_bill['estimated_arrival_time']?>',
                                        	'<?php echo $loading_bill['invoice_no']?>','<?php echo $loading_bill['note']?>')"> 详情  </a> 
                                        	<?php if (isset($loading_bill['arrival_time']) && $loading_bill['arrival_time'] != "") { ?>
                                            <?php if($this->helper->chechActionList(array('purchaseIn'))) {?>
                                            	<?php if($this->helper->chechActionList(array('superPurchaseIn')) || ($loading_bill['status'] != 'FINISH')) {?>
                                        	<a class="btn btn-primary" target="_blank" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>purchaseIn/index?bol_sn=<?php echo $loading_bill['bol_sn']?>&facility_id=<?php echo $loading_bill['facility_id']?>&product_type=<?php echo $product_type?>">入库</a>
                                        		<?php }?>
                                        	<?php }?>
                                            <?php }?>
                                        	</td>
                                    </tr>
                                    <?php } ?> <!--  purchase list end  -->
                                </tbody>
                                <?php } ?>
                            </table>
                        </div>
                        <!-- product list end -->
                    </div>
                    <div role="tabpanel" class="tab-pane" id="undercarriage">
                    </div>
                </div>
			</div>
		</div>
	</div>
<!-- Modal -->
<div>
<div class="modal fade ui-draggable" id="detail_modal"   role="dialog"  >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" id="btnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">装车单<input type="text" disabled="disabled" id="detail_sn" value="">详情</h4>
      </div>
      <div class="modal-body ">
      	<div class='row'>
      		<table>
				<tr>
					<td style="width: 10%;text-align: right"> 车牌号：<input type="text" disabled="disabled" id="car_num" value=""></td>
					<td style="width: 10%;text-align: right"> 司机电话：<input type="text" disabled="disabled" id="driver_mobile" value=""></td>
				</tr>
				<tr>
					<td style="width: 10%;text-align: right"> 司机名字：<input type="text" disabled="disabled" id="driver_name" value=""></td>
					<td style="width: 15%; text-align: right">预估到货时间：<input type="text" disabled="disabled" id="estimated_arrival_time" value=""></td>
				</tr>
                <tr>
                    <td style="width: 10%;text-align: right"> 车队：<input type="text" disabled="disabled" id="car_provider" value=""></td>
                    <td style="width: 10%;text-align: right"> 车型：<input type="text" disabled="disabled" id="car_model" value=""></td>
                </tr>
				<tr>
                    <td style="width: 10%;text-align: right"> 六联单：<input type="text" disabled="disabled" id="invoice_no" value=""></td>
					<td style="width: 10%;text-align: right"> 备注：<input type="text" disabled="disabled" id="note" value=""></td>
				</tr>
			</table>
      	</div>
      	<br>
      	<br>
      	<table id="detail_table" style="width:100%;border: 3">
			<tr>
				<th style="width:20%;">PRODUCT_ID</th>
				<th style="width:20%;">商品</th>
				<th style="width:12%;">装车箱数 </th>
				<th style="width:12%;">装车箱规 </th>
				<th style="width:13%;">入库总箱数 </th>
				<th>入库箱数 </th>
				<th style="width:12%;">入库箱规</th>
                <th style="width:8%;">单位</th>
				<th style="width:8%;">重量(kg)</th>
				<?php if(!empty($readonly) && $readonly == 'false') {?>
				<th style="width:5%;">操作</th>
				<?php }?>
			</tr>
		</table>
      </div>
    </div>
  </div>
</div>
</div>
<!-- modal end  -->
	<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
	
	<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/mobiscroll.core-2.5.2.js"></script>
 	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/mobiscroll.core-2.5.2-zh.js"></script>
	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/mobiscroll.datetime-2.5.1.js"></script>
 	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/mobiscroll.datetime-2.5.1-zh.js"></script> 
	<script type="text/javascript">
	var readonly;
	$(document).ready(function(){
	    $("#asn_date").val($("#hidden_asn_date").val());
	    readonly = $('#readonly').val();
		var currYear = (new Date()).getFullYear();
		var opt = {
				dateFormat : 'yy-mm-dd',
				preset : 'date',
			 	theme: 'android-ics light', //皮肤样式
	            display: 'modal', //显示方式
	            mode: 'scroller', //日期选择模式
	            preset: 'date', //日期
	            dateOrder: 'yymmdd', //面板中日期排列格
	            dateFormat: 'yy-mm-dd', // 日期格式
	            lang: 'zh',
	            setText: '确定', //确认按钮名称
	            cancelText: '取消',//取消按钮
	            dayText: '日', monthText: '月', yearText: '年', //面板中年月日文字    
	            endYear: currYear + 10 //结束年份
			};
        $("input[name='arrival_time']").each(function () {
            if ($(this).val() == "") {
                $(this).mobiscroll(opt).datetime(opt);
            }
        });
	    $("#start_date").mobiscroll(opt).date(opt);
	    $("#end_date").mobiscroll(opt).date(opt);
	}) ;
	
	$("#query").click(function(){
        $("form").submit();
    }); 

   	function detail(bol_id, bol_sn, driver_name, driver_mobile, car_provider, car_model, car_num, estimated_arrival_time, invoice_no, note){
   	   	$("#detail_sn").val(bol_sn);
   	   	$("#driver_name").val(driver_name);
   	   	$("#driver_mobile").val(driver_mobile);
        $("#car_provider").val(car_provider);
        $("#car_model").val(car_model);
   	   	$("#car_num").val(car_num);
   	   	$("#estimated_arrival_time").val(estimated_arrival_time);
        $("#invoice_no").val(invoice_no);
   	   	$("#note").val(note);
   		$("#detail_table tr.content").remove();
   		var submit_data = {"bol_id":bol_id };
   		var postUrl = $('#WEB_ROOT').val() + 'loadingBillList/detail';
	    $.ajax({
            url: postUrl,
            type: 'POST',
            data: submit_data, 
            dataType: "json", 
            xhrFields: {
              withCredentials: true
            }
	  }).done(function(data){
	   	  $("#detail_table tr.content").remove();
	      if(data.success == "success"){
	    	  data.loading_bill_item_list.forEach(function(loading_bill_item){
	    		  var lineIndex = $("#detail_table tr.content").size();

	    		  if(loading_bill_item.unit_code == 'kg') {
	    			  loading_bill_item.unit_code = '斤';
	    			  loading_bill_item.quantity = loading_bill_item.quantity * 2;
	    		  }
	    		  loading_bill_item.purchaseIn.forEach(function(pi,index){
		    		  if(index == 0){
			    		  return true;
		    		  }
		    		  if(loading_bill_item.unit_code == '斤') {
		    			  pi.unit_quantity = pi.unit_quantity * 2;
		    		  }
	    			  var trHtml = "<tr class='content'>" 
		    			  	+"<td>"+((pi.quantity!='')?pi.quantity:'0')+"</td>"
							+"<td style='text-align:center;'>"+pi.unit_quantity+"</td>" + + "</tr>";
							$("#detail_table tr").eq(0).after(trHtml);
	    		  })
	    		  
	    		  if(loading_bill_item.unit_code == '斤' && (loading_bill_item.purchaseIn.length > 0)) {
	    			  loading_bill_item.purchaseIn[0].unit_quantity = loading_bill_item.purchaseIn[0].unit_quantity * 2;
	    		  } 
	    		  
	              var trHtml = "<tr class='content'>"
	              	+"<td rowspan='"+((loading_bill_item.purchaseIn.length==0)?1:loading_bill_item.purchaseIn.length)+"'>"+loading_bill_item.product_id +"</td>"
	              	+"<td rowspan='"+((loading_bill_item.purchaseIn.length==0)?1:loading_bill_item.purchaseIn.length)+"'>"+loading_bill_item.product_name +"</td>"
	              	+"<td rowspan='"+((loading_bill_item.purchaseIn.length==0)?1:loading_bill_item.purchaseIn.length)+"'>"+((loading_bill_item.purchase_case_num!='')?loading_bill_item.purchase_case_num:'0')+"</td>"
	              	+"<td rowspan='"+((loading_bill_item.purchaseIn.length==0)?1:loading_bill_item.purchaseIn.length)+"'>"+loading_bill_item.quantity+"</td>"
	             	+"<td rowspan='"+((loading_bill_item.purchaseIn.length==0)?1:loading_bill_item.purchaseIn.length)+"'>"+((loading_bill_item.finish_case_num!='')?loading_bill_item.finish_case_num:'0')+"</td>"
	              	+"<td>"+((loading_bill_item.purchaseIn.length == 0)?0:loading_bill_item.purchaseIn[0].quantity)+"</td>"
	            	+"<td style='text-align:center;'>"+((loading_bill_item.purchaseIn.length == 0)?0:loading_bill_item.purchaseIn[0].unit_quantity)+"</td>"
	              	+"<td rowspan='"+((loading_bill_item.purchaseIn.length==0)?1:loading_bill_item.purchaseIn.length)+"'>"+loading_bill_item.unit_code+"</td>" 
	              	+"<td class='bol_item_id' rowspan='"+((loading_bill_item.purchaseIn.length==0)?1:loading_bill_item.purchaseIn.length)+"' hidden='hidden'>"+loading_bill_item.bol_item_id+"</td>" 
                    +"<td rowspan='"+((loading_bill_item.purchaseIn.length==0)?1:loading_bill_item.purchaseIn.length)+"'>"+((!loading_bill_item.weight)?'':loading_bill_item.weight)+"</td>"
					+((readonly=='false')?"<td rowspan='"+((loading_bill_item.purchaseIn.length==0)?1:loading_bill_item.purchaseIn.length)+"'><input id='remove_bol_item_btn' style='width:40px;' type='button' class='btn btn-danger' value='删'></input></td>":"")
	              	+ "</tr>";
	             	$("#detail_table tr").eq(0).after(trHtml);
	    		})
	    	
	    	  $('#detail_modal').modal('show').on();

	    	  var remove_bol_item_btn = $("td #remove_bol_item_btn");
	    	  remove_bol_item_btn.click(remove_bol_item_click);
	      }else{
	    	  $('#purchase_commit_btn').removeAttr('disabled');
	          alert(data.error_info);
	        }
	    }).fail(function(data){
		    alert('error');
	    });
   	}

   	function remove_bol_item_click(){
   	   	var input = $(this);
   	 	input.attr('disabled','disabled');
   	   	var td = input.parent('td');
   	   	var tr = td.parent('tr');
   		var cf=confirm( '是否确认删除商品：' + tr.find('td').eq(0).html() )
   		
		if (cf==false)
			return ;
		submit_data = {'bol_item_id':tr.find('td.bol_item_id').html()};
   		var postUrl = $('#WEB_ROOT').val() + 'loadingBillList/removeItem';
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
			  tr.remove();
			  alert('删除成功');
			  input.removeAttr('disabled');
		  } else{
			  alert(data.error_info);
			  input.removeAttr('disabled');
		  }
	  }).fail(function(data){
		  alert('删除失败');
		  input.removeAttr('disabled');
	  });
   	}
     function setArrivalTime(event, facility_id, bol_sn) {
        var cf=confirm('是否确认');
        if (cf==false)
        return false;
        var str = '<a class="btn btn-primary" target="_blank" href="<?php if (isset($WEB_ROOT)) echo $WEB_ROOT; ?>purchaseIn/index?bol_sn=' + bol_sn + '&facility_id=' + facility_id + '">入库</a>';
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
                $(event).parent().next().next().next().append(str);
                $(event).parent().html(arrival_time + ":00");
                alert('到货时间添加成功');
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
