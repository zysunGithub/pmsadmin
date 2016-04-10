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
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/buttons.dataTables.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/autocomplete.css">
    <!-- <link rel="stylesheet" type="text/css" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/js/calendar/GooCalendar.css"/> -->
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

       .button_margin {
        margin: 8%;
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
                    <div role="tabpanel" class="tab-pane active" id="onsale">


                        <form style="width:100%;" method="post" 
                                action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>supplierReturnList/query">

                         <div class="row">
								<label for="start_time" class="col-sm-2 control-label">申请开始时间</label>
								<div class="col-sm-3">
									<input required="required" type="text" class="form-control" name="start_time" id="start_time" value="<?php if(isset($start_time)) echo "{$start_time}"; ?>">
								</div>
								<label for="end_time" class="col-sm-2 control-label">申请结束时间</label>
								<div class="col-sm-3">
									<input required="required" type="text" class="form-control" name="end_time" id="end_time" value="<?php if(isset($end_time)) echo "{$end_time}"; ?>">
								</div>
							</div>
							<div class="row">
								<label for="start_time" class="col-sm-2 control-label">仓库</label>
								<div class="col-sm-3">
									<select  name="facility_id" id="facility_id" class="form-control">
                                    	<?php
										if($is_all_facility_action) {
											echo "<option value=''>全部</option>";
										}
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
								<label class="col-sm-2 control-label">状态</label>
								<div class="col-sm-3">
									<select  name="status" id="status" class="form-control" >
									    <option value="">全部</option>
		                                <option value="INIT"  <?php if(isset($status) && $status == 'INIT') echo "selected='true'" ?>>待审核</option>
                                        <option value="MANAGERCHECKED"  <?php if(isset($status) && $status == 'MANAGERCHECKED') echo "selected='true'" ?>>区总成功</option>
                                        <option value="MANAGERCHECKFAIL"  <?php if(isset($status) && $status == 'MANAGERCHECKFAIL') echo "selected='true'" ?>>区总失败</option>
                                		<option value="CHECKED"  <?php if(isset($status) && $status == 'CHECKED') echo "selected='true'" ?>>已审核，待出库</option>
                                		<option value="CHECKFAIL"  <?php if(isset($status) && $status == 'CHECKFAIL') echo "selected='true'" ?>>审核拒绝</option>
                                		<option value="EXECUTED"  <?php if(isset($status) && $status == 'EXECUTED') echo "selected='true'" ?>>已出库，待财务收款</option>
                                		<option value="FINISH"  <?php if(isset($status) && $status == 'FINISH') echo "selected='true'" ?>>已完成</option>
                                    </select>
								</div>
							</div>
							
							<div class="row">
								<label for="product_type" class="col-sm-2 control-label">产品类型</label>
								<div  class="col-sm-3 control-label">
									<select  name="product_type" id="product_type" class="form-control">
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
								<label class="col-sm-2 control-label">子类型</label>
								<div class="col-sm-3">
									<select name="type" id="type" class="form-control">
										<option value="raw_material"><?php echo $product_type_name3?></option>
										<?php if($product_type == 'goods') {?>
											<option value="defective" <?php if (isset($type) && $type == 'defective') echo "selected='true'"?>>次果</option>
											<option value="bad" <?php if (isset($type) && $type == 'bad') echo "selected='true'"?>>坏果</option>
										<?php }?>
                                    </select>
								</div>
							</div>
							<div class="row">
								<label class="col-sm-2 control-label">产品名称</label>
								<div class="col-sm-3">
									<input type="text" class="form-control" name="product_name" id="product_name" value="<?php if(isset($product_name)) echo "{$product_name}"; ?>">
									<input type="hidden" id="product_id" name="product_id" <?php if(isset($product_id)) echo "value=\"{$product_id}\""; ?>/>
								</div>
                                <label class="col-sm-2 control-label">退货类型</label>
                                <div class="col-sm-3">
                                    <select name="return_type" id="return_type" class="form-control">
                                        <option value="">全部</option>
                                        <option value="exchange" <?php if (isset($return_type) && $return_type == 'exchange') echo "selected='true'"?>>换货</option>
										<option value="return" <?php if (isset($return_type) && $return_type == 'return') echo "selected='true'"?>>退货</option>
										<option value="sale" <?php if (isset($return_type) && $return_type == 'sale') echo "selected='true'"?>>销售</option>
                                    </select>
                                </div>
							</div>
							<div class="row">
								<label for="asn_item_id" class="col-sm-2 control-label">ASN ITEM ID:</label>
								<div class="col-sm-3">
									<input type='number' class="form-control"  id="asn_item_id" name="asn_item_id"/>
								</div>
							</div>
                         <div style="width: 100%;float:left;">
                                <div style="width:66%;float:left;text-align: center;">
                                    <input type="button" class="btn btn-primary btn-sm"  id="query" value="搜索"  >
                                </div>
                         </div>

                        </form>
        
<br/>
<br/>

                        <!-- product list start -->
                        <div class="row col-sm-15 " style="margin-top: 10px;">
                            <table class="table table-striped table-bordered " id="list">
                                <thead>
                                    <tr>
                                        <th>仓库</th>
                                        <th>SUPPLIER_RETURN_ID</th>
                                        <th>退货类型 </th>
                                        <th>类型 </th>
                                        <th>ASN ITEM ID</th>
                                        <th>供应商</th>
                                        <th>采购员</th>
                                        <th>PRODUCT_ID</th>
                                        <th>产品名</th>
                                        <th>单位</th>
                                        <th>箱规</th>
                                        <th>申请数量</th>
                                        <th>执行数量</th>
                                        <th>系统实际退货数量</th>
                                        <?php if($this->helper->chechActionList(array('lookSupplierReturnPrice'))) {?>
                                        	<th>单价</th>
	                                        <th>申请总金额</th>
	                                        <th>退货总金额</th>
	                                        <th>收款总金额</th>
                                        <?php }?>
                                        <th style="width: 10%;">区总备注</th>
                                        <th style="width: 10%;">审核备注</th>
                                        <th>状态</th>
                                        <th>申请人</th>
                                        <th>申请时间</th>
                                        <th>审核人</th>
                                        <th>审核时间</th>
                                        <th>执行人</th>
                                        <th>执行时间</th>
                                        <?php if($this->helper->chechActionList(array('lookSupplierReturnPrice'))) {?>
	                                        <th>收款人</th>
	                                        <th>收款时间</th>
                                        <?php }?>
                                        <th>操作</th>
                                    </tr>
                                </thead><tbody></tbody>                   
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
    
	<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js"></script>
	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/js_wms/product.js"></script>
	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/common.js"></script>
	<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/lhgcalendar.min.js"></script>
	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/jquery.dataTables.js"></script>
	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/dataTables.bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/dataTables.buttons.js"></script>
	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/buttons.colVis.js"></script>
	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/buttons.flash.js"></script>
	<script type="text/javascript">
	WEB_ROOT = $("#WEB_ROOT").val();
	product_type = "<?php if(isset($product_type)) echo $product_type?>";
	productNameList={};
$(document).ready(function(){

    (function(config){
        config['extendDrag'] = true; // 注意，此配置参数只能在这里使用全局配置，在调用窗口的传参数使用无效
        config['lock'] = true;
        config['fixed'] = true;
        config['okVal'] = 'Ok';
        config['format'] = 'yyyy-MM-dd HH:mm:ss';
    })($.calendar.setting);

    $("#start_time").calendar({btnBar:true,
                   minDate:'2010-05-01', 
                   maxDate:'2022-05-01'});
    $("#end_time").calendar({btnBar:true,
                   minDate:'2010-05-01', 
                   maxDate:'2022-05-01'});
   getRawMaterialList();
   loadTableData();
});

function loadTableData(){
	var url = WEB_ROOT+'supplierReturnList/getSupplierReturnListForPages',
    facility_id = $('#facility_id').val(),
    status = $('#status').val(),
    start_time = $('#start_time').val(),
    end_time = $('#end_time').val(),
    product_id = $('#product_id').val();
	product_type=$('#product_type').val();
	type=$('#type').val();
	return_type=$('#return_type').val();
asn_item_id=$('#asn_item_id').val();
	var params = {
	    "facility_id" : facility_id,
	    "status" : status,
	    "start_time" : start_time,
	    "end_time" : end_time,
	    "product_id" : product_id,
	    "product_type":product_type,
	    "type":type,
	    "return_type":return_type,
	    "asn_item_id":asn_item_id
	};
	if($table){
	    $table.destroy();
	}
	var $table = $('#list').DataTable({
			"processing": true,
	        "serverSide": false,
	        "searching" : true,
	        "bSort": true,
	        "ordering": true,
	        "DeferRender": true,
	        "StateSave": true,
	        "bDestroy": true,
	        "ajax": {
	            "url": url,
	            "type": 'get',
	            "dataSrc": "list",
	            "data": params
	        },
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'colvis',
                    text: '设置列可见'
                },
                { 
                    extend: 'copyFlash',
                    text: '复制'
                },
                'excelFlash',
            ],
            language: {
                "url": "<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/Chinese.lang"
            },
            "lengthMenu": [[200, 50, 100, 200, -1], [200, 50, 100, 200, "全部"]],
             "columns": [
                         {"data":"facility_name"},
                         {"data":"supplier_return_id"},
                         {"data":"return_type","render":function(a,b,row,c){ // 返回自定义内容
		                        	if(row['return_type'] == 'sale') {
	                        	        return "销售"; 
	                        	    } else if (row['return_type'] == 'return') {
	                        	        return "退货";
	                        	    } else if (row['return_type'] == 'exchange') {
	                        	        return "换货";
	                        	    } else {
	                        	        return "一个神秘的未知退货类型";
		                        	}
		                  	    }
						 },
                         {"data":"type","render":function(a,b,row,c){ // 返回自定义内容
		                        	if(row['type'] == 'raw_material') {
		                     		    return "<?php echo $product_type_name3; ?>"; 
		                     		} else if (row['type'] == 'defective') {
		                     		    return "次果";
		                     		} else {
		                     		    return "坏果";
		                     		}
	                        	 	return "";
		                  	    }
						 },
                         {"data":"asn_item_id"},
                         {"data":"product_supplier_name"},
                         {"data":"purchase_user_name"},
                         {"data":"product_id"},
                         {"data":"product_name"},
                         {"data":"unit_code"},
                         {"data":"container_quantity"},
                         {"render": function(a,b,row,c){ // 返回自定义内容
                        	   			return (row['apply_quantity']?parseFloat(row['apply_quantity']):row['apply_quantity'])+(row['type']=='raw_material' ? "箱":row['unit_code']);
                     	      		}
                   	     },
                         {"render": function(a,b,row,c){ // 返回自定义内容
                        	     		return (row["execute_quantity"]?parseFloat(row["execute_quantity"]):row["execute_quantity"])+(row['type']=='raw_material' ? "箱":row['unit_code']);
                     	   			}
                   	   	 },
                         {"render": function(a,b,row,c){ // 返回自定义内容
		                       			return (row['inventory_transaction_quantity']?parseFloat(row['inventory_transaction_quantity']):row['inventory_transaction_quantity'])+(row['type']=='raw_material' ? "箱":row['unit_code']);
		                     	    }
						 },
						 <?php if($this->helper->chechActionList(array('lookSupplierReturnPrice'))) {?>
                                     {"render": function(a,b,row,c){ // 返回自定义内容
			 		                       		return (typeof row['unit_price']=='string'?parseFloat(row['unit_price']):row['unit_price'])+"/"+row['unit_code'];
			 		                     	    }
			 						 },
                                     {"data":"total_price","render": function(a,b,row,c){ // 返回自定义内容
			 		                       			return (typeof a=='string'?parseFloat(a):a)+"";
			 		                     	    }
			 						 },
                                     {"render": function(a,b,row,c){ // 返回自定义内容
			                                    	if ($.trim(row['status'])=="EXECUTED"||$.trim(row['status'])=="FINISH"){
			                                    		if (row['type'] == 'raw_material'){
			                                    			return row['unit_price']*row['inventory_transaction_quantity']*row['container_quantity']+"";
			                                    	    } else {
			                                    	        return row['unit_price']*row['inventory_transaction_quantity']+"";
			                                    	    }
			                                    	}
			                                    	return "";
			 		                     	    }
			 						 },
                                     {"data":"finance_amount"},
                         <?php }?>
                         {"data":"purchase_manager_note"},
                         {"data":"note"},
                         {"data":"status","render":function(a,b,row,c){ // 返回自定义内容
	                        	 	if (row['status'] == "INIT") {
	                        		    return "待审核";
	                        		}else if (row['status'] == "MANAGERCHECKED") {
	                        		    return "区总成功";
	                        		}else if (row['status'] == "MANAGERCHECKFAIL") {
	                        		    return "区总失败";
	                        		}else if (row['status'] == "CHECKFAIL") {
	                        		    return "审核拒绝";
	                        		} else if (row['status'] == "CHECKED") {
	                        		    return "已审核，待出库";
	                        		}else if (row['status'] == "EXECUTED") {
	                        		    return "已出库，待财务收款";
	                        		}else if (row['status'] == "FINISH") {
	                        		    return "已完成";
	                        		} else {
	                        		    return row['status'];
	                        		}
		                  	    }
						 },
                         {"data":"created_user"},
                         {"data":"created_time"},
                         {"data":"check_user"},
                         {"data":"check_time"},
                         {"data":"execute_user"},
                         {"data":"execute_time"},
                         <?php if($this->helper->chechActionList(array('lookSupplierReturnPrice'))) {?>
                                 {"data":"finish_user"},
                                 {"data":"finish_time"},
                         <?php }?>
                         {"render": function(a,b,row,c){ // 返回自定义内容
                        	 var str="";
                        	  <?php if($this->helper->chechActionList(array('purchaseManagerCheckSupplierReturn'))) {?>
		                             if(row['status'] == "INIT"){
			                             str+="<button type='button' class=\"btn btn-success btn-sm button_margin\"  onClick=\"checkSupplierReturn(this, '"+row['supplier_return_id']+"','MANAGERCHECKED' );\" >区总成功</button><br/>";
		                            	 str+="<button type='button' class=\"btn btn-danger btn-sm button_margin\"  onClick=\"checkSupplierReturn(this, '"+row['supplier_return_id']+"','MANAGERCHECKFAIL');\" >区总失败</button><br/>";
			                         }
    		                 <?php }?>
    		                 <?php if($this->helper->chechActionList(array('checkSupplierReturn'))) {?>
		    		                 if(row['status'] == "MANAGERCHECKED"){
			                             str+="<button type='button' class=\"btn btn-success btn-sm button_margin\"  onClick=\"checkSupplierReturn(this, '"+row['supplier_return_id']+"','CHECKED' );\" >审核通过</button><br/>";
		                            	 str+="<button type='button' class=\"btn btn-danger btn-sm button_margin\"  onClick=\"checkSupplierReturn(this, '"+row['supplier_return_id']+"','CHECKFAIL');\" >审核拒绝</button><br/>";
			                         }
    		                 <?php }?>
    		                 <?php if($this->helper->chechActionList(array('executeSupplierReturn'))) {?>
		    		                 if(row['status'] == "CHECKED"){
			                             str+="<button type='button' class=\"btn btn-primary btn-sm\"  onClick=\"executeSupplierReturn(this,'"+row['supplier_return_id']+"','CHECKED' );\" >执行退货</button><br/>";
			                         }
    		                 <?php }?>
    		                 <?php if($this->helper->chechActionList(array('finishSupplierReturn'))) {?>
		    		                 if(row['status'] == "EXECUTED"){
			                             str+="<button type='button' class=\"btn btn-primary btn-sm\"  onClick=\"finishSupplierReturn(this,'"+row['supplier_return_id']+"','CHECKED' );\" >收款</button><br/>";
			                         }
    		                 <?php }?>
		                    			return str;
					               }
						 }
              ]
        });
}
function getRawMaterialList(){
	ajaxProductList({"product_type":"goods"},function(data){
		if(data.res == "success"){
			productNameList["goods"]=data.product_list;
			autoProductName("goods");
		}
	});
	
	ajaxProductList({"product_type":"supplies"},function(data){
		if(data.res == "success"){
			productNameList["supplies"]=data.product_list;
			autoProductName("supplies");
		}
	});
}
$("#product_type").change(function(e){
	autoProductName($(this).val());
});
function autoProductName(gs){
	if($("#product_type").val()==gs){
		$('#product_name').unbind();
		$('#product_name').val("");
		$('#product_id').val("");
		autocoms($('#product_name'),productNameList[gs],function(row, i, max) {
	   		return(row.product_name);
	   	});
		$('#product_name').result(function(event, row, formatted) {
			$('#product_id').val(row.product_id);
		});
	}
}
function checkSupplierReturn(button, supplier_return_id, check) {
	var note = "";
    var selected =  $("#status option:selected").val();
	if (check == "CHECKFAIL" || check == "MANAGERCHECKFAIL") {
		if (! confirm("真的要拒绝吗？")) {
			return ;
		}
		note = prompt("请输入备注");
	}
	$(button).attr("disabled", true);
	var myurl = $("#WEB_ROOT").val()+"supplierReturnList/checkSupplierReturn";
    var mydata = {
      "supplier_return_id":supplier_return_id,
      "check":check,
      "note":note,
    };
    $.ajax({
        url: myurl,
        type: 'POST',
        data:mydata, 
        dataType: "json", 
        xhrFields: {
             withCredentials: true
        }
      }).done(function(data){
          console.log(data);
          if (data.success == "OK") {
            if (selected == "" && check == "MANAGERCHECKED") {
                $(button).parent().parent().find(".current_status").html("区总成功");
            <?php if ($this->helper->chechActionList(array('checkSupplierReturn'))) { ?>
                $(button).parent().html("<button type=\"button\" class=\"btn btn-success btn-sm button_margin\"  onClick=\"checkSupplierReturn(this, "+supplier_return_id+",'CHECKED' );\" >审核通过</button><br/><button type=\"button\" class=\"btn btn-danger btn-sm button_margin\"  onClick=\"checkSupplierReturn(this, "+supplier_return_id+",'CHECKFAIL');\" >审核拒绝 </button><br/>");
            <?php } else { ?>
                $(button).parent().html("");
            <?php } ?>
            } else if(selected == "" &&  check == "CHECKED") {
                $(button).parent().parent().find(".current_status").html("已审核，待出库");
                $(button).parent().parent().find(".check_time").html(data.check_time);
                $(button).parent().parent().find(".check_user").html(data.check_user);
            <?php if ($this->helper->chechActionList(array('executeSupplierReturn'))) { ?>
                $(button).parent().html("<button type=\"button\" class=\"btn btn-primary btn-sm\"  onClick=\"executeSupplierReturn(this, "+supplier_return_id+");\" > 执行退货 </button>");
            <?php } else { ?>
                $(button).parent().html("");
            <?php } ?>
            } else if (selected == "" && (check == "MANAGERCHECKFAIL" || check == "CHECKFAIL")) {
                if (check == "MANAGERCHECKFAIL") {
                    $(button).parent().parent().find(".current_status").html("区总失败");
                } else if(check == "CHECKFAIL") {
                    $(button).parent().parent().find(".current_status").html("审核拒绝");
                    $(button).parent().parent().find(".check_time").html(data.check_time);
                    $(button).parent().parent().find(".check_user").html(data.check_user);
                }
                $(button).parent().html("");
            } else {
                $(button).parent().parent().remove();
            }
          	//window.location.reload();
          }else{
            alert("操作失败"+data.error_info);
            $(button).removeAttr("disabled");
          }
      });
} 

function executeSupplierReturn(button, supplier_return_id){
	$(button).attr("disabled", true);
	var myurl = $("#WEB_ROOT").val()+"supplierReturnList/executeSupplierReturn";
    var selected =  $("#status option:selected").val();
	var quantity = prompt("请输入数量");
	if (quantity == null || quantity == "" || isNaN(quantity) || parseFloat(quantity) < 0) {
		alert("请输入正确的数字");
		$(button).removeAttr("disabled");
		return ;
	}
	apply_quantity = $(button).parent().parent().find('td.apply_quantity').html();
	if (parseFloat(quantity) > parseFloat(apply_quantity)) {
		alert("不能超过申请数量");
		$(button).removeAttr("disabled");
		return;
	}
	$.ajax({
        url: myurl,
        type: 'POST',
        data: {
            "supplier_return_id":supplier_return_id,
            "quantity":quantity
          }, 
        dataType: "json", 
        xhrFields: {
             withCredentials: true
        }
      }).done(function(data){
          console.log(data);
          if(data.success == "OK"){
            if(selected == "" &&  typeof(data.update_supplier_return) == "undefined" ) {
                $(button).parent().parent().find(".execute_time").html(data.execute_time);
                $(button).parent().parent().find(".execute_user").html(data.execute_user);
                $(button).parent().parent().find(".current_status").html("已出库，待财务收款");
            <?php if ($this->helper->chechActionList(array('finishSupplierReturn'))) { ?> 
                $(button).parent().html("<button type=\"button\" class=\"btn btn-primary btn-sm\"  onClick=\"finishSupplierReturn(this, "+supplier_return_id+");\" > 收款 </button>");
            <?php } else { ?>
                $(button).parent().html("");
            <?php } ?>
            } else if (selected == "" && data.update_supplier_return == 1) {
                $(button).parent().parent().find(".execute_time").html(data.execute_time);
                $(button).parent().parent().find(".execute_user").html(data.execute_user);
                $(button).parent().parent().find(".current_status").html("EXECUTEFAIL");
                $(button).parent().html("");//出库失败
            } else {
                $(button).parent().parent().remove();
            }
          	//window.location.reload();
          }else{
            alert("操作失败"+data.error_info);
            $(button).removeAttr("disabled");
          }
      });
}

function finishSupplierReturn(button, supplier_return_id){
	$(button).attr("disabled", true);
    var selected =  $("#status option:selected").val();
	var myurl = $("#WEB_ROOT").val()+"supplierReturnList/finishSupplierReturn";
	var finance_amount = prompt("请输入金额");
	if (finance_amount == null || finance_amount == "" || isNaN(finance_amount) || parseFloat(finance_amount) < 0) {
		alert("请输入正确的数字");
		$(button).removeAttr("disabled");
		return ;
	}
	inventory_transaction_total_price = $(button).parent().parent().find('td.inventory_transaction_total_price').html();
	diff = parseFloat(finance_amount) - parseFloat(inventory_transaction_total_price);
	if (diff != 0) {
		if (!confirm("与出库总金额相差 " + diff + " 是否确认?" )) {
			$(button).removeAttr("disabled");
			return ;
		}
	}
	
	$.ajax({
        url: myurl,
        type: 'POST',
        data: {
            "supplier_return_id":supplier_return_id,
            "finance_amount":finance_amount
          }, 
        dataType: "json", 
        xhrFields: {
             withCredentials: true
        }
      }).done(function(data){
          console.log(data);
          if(data.success == "OK"){
            if (selected == "") {
                $(button).parent().parent().find(".current_status").html("已完成");
                $(button).parent().parent().find(".finish_time").html(data.finish_time);
                $(button).parent().parent().find(".finish_user").html(data.finish_user);
                $(button).parent().html("");
            } else {
                $(button).parent().parent().remove();
            }
          }else{
            alert("操作失败"+data.error_info);
            $(button).removeAttr("disabled");
          }
      });
}

function checkQuantity(input, quantity, can_sale_return_quantity, flag) {
	if (quantity == null || quantity == "" || isNaN(quantity) || parseFloat(quantity) < 0) {
		alert("请输入正确的数字");
		$(input).focus();
	}
	
	if (flag && parseFloat(quantity) > parseFloat(can_sale_return_quantity)) {
		alert("不能超过申请数量");
		$(input).focus();
	}
}

$("input[name='execute_quantity']").blur(function (){
	checkQuantity(this, $(this).val().trim(), $(this).attr('quantity'), true);
});
$("input[name='finance_amount']").blur(function (){
	checkQuantity(this, $(this).val().trim(), 0, fasle);
});
WEB_ROOT = $("#WEB_ROOT").val();
 $("#query").click(function(e){
	 e.preventDefault();
	 loadTableData();
 }); 
 $("#asn_item_id").keyup(function(){
	 this.value=this.value.replace(/\D/g,"");
 });

</script>
</body>
</html>
