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
                	<form method="post" action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>transferException/unPurchaseIn">
                    
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
								<div class="row">
								<label for="product_type" class="col-sm-1 control-label">产品类型:</label>
								<div class="col-sm-3 control-label">
									<select style="width:200px" name="product_type" id="product_type" class="form-control">
		                                    	<?php
										foreach ($product_type_list as $item) {
											if (isset ($product_type) && $item['product_type'] == $product_type) {
												echo "<option value=\"{$item['product_type']}\" selected='true'>{$item['product_type_name']}</option>";
											} else {
												echo "<option value=\"{$item['product_type']}\">{$item['product_type_name']}</option>";
											}
										}
										?>
                               </select>
								</div>
                                <br/>
								<div class="col-sm-1">
                                    <button type="submit" class="btn btn-primary btn-sm"  id="query"  >搜索 </button> 
								</div>
							</div>
                 	</form>
                    
                    
                        <!-- product list start -->
                        <div class="row  col-sm-10 " style="margin-top: 10px;">
                            <table class="table table-striped table-bordered ">
                                <thead>
                                    <tr>
                                        <th>仓库</th>
                                        <th>ASN日期</th>
                                        <th>装车时间</th>
                                        <th>装车批次</th>
                                        <th>六联单</th>
                                        <th>PRODUCT_ID</th>
                                        <th>商品</th>
                                        <th>装车箱数</th>
                                        <th>装车箱规</th>
                                        <th>单位</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                            	<?php
								if (!empty ($loading_bill_item_list)) {
									foreach ($loading_bill_item_list as $loading_bill_item) {
								?>
                            		<tr>
                            			<td class="product_cell"><?php echo $loading_bill_item['facility_name']?></td>
                            			<td class="product_cell"><?php echo $loading_bill_item['asn_date']?></td>
                            			<td class="product_cell"><?php echo $loading_bill_item['created_time']?></td>
                            			<td class="product_cell"><?php echo $loading_bill_item['bol_sn']?></td>
                                        <td class="product_cell"><?php echo $loading_bill_item['invoice_no']?></td>
                                        <td class="product_cell"><?php echo $loading_bill_item['product_id']?></td>
                            			<td class="product_cell"><?php echo $loading_bill_item['product_name']?></td>
                            			<td class="product_cell"><?php echo $loading_bill_item['purchase_case_num']?></td>
                            			<td class="product_cell"><?php echo $loading_bill_item['quantity']?></td>
                            			<td class="product_cell"><?php echo $loading_bill_item['unit_code']?></td>
                                        <td class="product_cell">
                                        	<?php if($this->helper->chechActionList(array('purchaseIn'))) {?>
                                        	<a class="btn btn-primary" target="_blank" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>purchaseIn/index?bol_sn=<?php echo $loading_bill_item['bol_sn']?>&facility_id=<?php echo $loading_bill_item['facility_id']?>">入库</a>
                                        	<?php }?>
                                        	<?php if($this->helper->chechActionList(array('purchaseModify'))) {?>
                                        	<input type="button" class="btn btn-danger remove_btn" value="删除装车单">
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

$('.remove_btn').click(function(){
	btn = $(this);
	bol_item_id = btn.parent().parent().find('td.bol_item_id').html();
	submit_data = {'bol_item_id':bol_item_id};
	var postUrl = $('#WEB_ROOT').val() + 'loadingBillList/removeItem';
	var cf=confirm( '是否确认删除' )
		
	if (cf==false)
		return ;
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
			  alert('删除成功');
			  location.reload();
		  } else{
			  alert(data.error_info);
			  input.removeAttr('disabled');
		  }
	  	}).fail(function(data){
	  		alert('删除失败');
			  input.removeAttr('disabled');
	  	});
})
</script>
</body>
</html>
