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
    <link rel="stylesheet" type="text/css" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/lhgcalendar.css"/>
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/style.css">
    
    <style type="text/css">
        tr {
            text-align: center;
            vertical-align:middle;
            height: 100%;
        }
        tr th{
            text-align: center;
            vertical-align:middle;
            height: 100%;
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
                    <div role="tabpanel" class="tab-pane active" id="onsale">
                        <form style="width:100%;" method="post" action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>productSupplierList">
							<div class="row">
							        <label for="start_time" class="col-sm-2 control-label">创建日期：</label>
							        <div class="col-sm-3">
							            <input required="required" type="text" class="form-control" name="start_time" id="start_time" <?php if(isset($start_time)) echo "value='{$start_time}'"; ?>></div>
							        <label for="end_time" class="col-sm-2 control-label">至：</label>
							        <div class="col-sm-3">
							            <input required="required" type="text" class="form-control" name="end_time" id="end_time" <?php if(isset($end_time)) echo "value='{$end_time}'"; ?>></div>
							    </div>
							    <div class="row">
							        <label for="start_time" class="col-sm-2 control-label">创建人：</label>
							        <div class="col-sm-3">
							            <input type="text"  id="created_user" name="created_user" class="form-control" <?php if(isset($created_user))  echo "value={$created_user}"; ?>></div>
							        <label class="col-sm-2 control-label">供应商：</label>
							        <div class="col-sm-3">
							            <input type="text"  id="product_supplier_name" name="product_supplier_name" class="form-control" <?php if(isset($product_supplier_name))  echo "value={$product_supplier_name}"; ?>></div>
							    </div>
							    <div class="row">
							        <label for="product_type" class="col-sm-2 control-label">产品类型：</label>
							        <div  class="col-sm-3 control-label">
							            <select  name="product_type" id="product_type" class="form-control">
							                <?php 
							                    foreach ($product_type_list as $item) {
							                        if (isset ($product_type) && $item['product_type'] == $product_type) {
							                            echo "<option value=\"{$item['product_type']}\" selected='selected'>{$item['product_type_name']}</option>
							            ";
							                        } else {
							                            echo "
							            <option value=\"{$item['product_type']}\">{$item['product_type_name']}</option>
							            ";
							                        }
							                    }
							                 ?>
							            </select>
							        </div>
							        <label class="col-sm-2 control-label">供应商类型：</label>
							        <div class="col-sm-3">
							            <select name="search_supplier_type" id="search_supplier_type" class="form-control">
							            	<option value="">全部</option>
							                <option value="company" <?php if(isset($search_supplier_type ) && $search_supplier_type == "company") echo "selected='selected'"?>>公司</option>
							                <option value="market" <?php if(isset($search_supplier_type ) && $search_supplier_type == "market") echo "selected='selected'"?>>市场档口</option>
							                <option value="cooperative" <?php if(isset($search_supplier_type ) && $search_supplier_type == "cooperative") echo "selected='selected'"?>>产地合作社</option>
							            </select>
							        </div>
							    </div>
							    <div class="row">
							        <label class="col-sm-2 control-label">状态：</label>
							        <div class="col-sm-3">
							            <select name="search_status" id="search_status" class="form-control">
							            	<option value="">全部</option>
							            	<option value="2" <?php if(isset($search_status ) && $search_status == 2) echo "selected='selected'"?>>未审核</option>
							                <option value="1" <?php if(isset($search_status ) && $search_status == 1) echo "selected='selected'"?>>激活</option>
							                <option value="0" <?php if(isset($search_status ) && $search_status == 0) echo "selected='selected'"?>>冻结</option>
							            </select>
							        </div>
									<label class="col-sm-2 control-label">税率审核状态： </label>
									<div class="col-sm-3">
										<select name="tax_rate_examine" id="tax_rate_examine" class="form-control">
											<option value="">全部</option>
											<option value="0" <?php if(isset($tax_rate_examine) && $tax_rate_examine == 0) echo 'selected="selected"';?>>未审核</option>
										</select>
									</div>
							    </div>
                         <div style="width: 100%;float:left;">
                                <div style="float:left;text-align: center;margin-left: 40%">
                                    <button type="button" class="btn btn-primary btn-sm"  id="query"  >搜索 </button> 
                                    <?php  
										if( $this->helper->chechActionList(array('productSupplierAdd')) ){ ?>
										<a href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>productSupplierList/newIndex" class="btn btn-primary btn-sm"  style="float: right; margin-left:5px;" id="addProduct">新增</a>
									<?php }?>	

                                </div>
                                <!-- 隐藏的 input  start  -->
                                <?php 
                                /*<input type="hidden"  id="page_current" name="page_current" <?php if(isset($page_current)) echo "value={$page_current}"; ?> /> 
                                <input type="hidden"  id="page_count" name="page_count" <?php if(isset($page_count)) echo "value={$page_count}"; ?> />
                                <input type="hidden"  id="page_limit" name="page_limit" <?php if(isset($page_limit)) echo "value={$page_limit}"; ?> />
                                */
                                 ?>
                                <!-- 隐藏的 input  end  -->
                         </div>
                        </form>
                        <!-- product list start -->
                        <div class="row  col-sm-10 " style="margin-top: 10px;width:100%">
                            <table class="table table-striped table-bordered " style="width:100%" id="list">
                                <thead>
                                    <tr>
                                        <th width="5%">编号</th>
                                        <th width="10%">供应商</th>
                                        <th width="8%">商品类型</th>
                                        <th width="10%">供应商类型</th>
                                        <th hidden >地址</th>
                                        <th width="5%">等级</th>
                                        <th width="10%">联系人</th>
                                        <th width="10%">联系电话</th>
                                        <th width="15%">创建日期</th>
                                        <th width="10%">营业执照</th> 
                                        
                                        <th width="10%">银行账户</th>
                                        <th width="10%">进项税率详情</th>
                                        <th width="10%">状态</th>
                                        <th width="15%">操作</th>
                                        <th hidden>备注</th>
                                        <th hidden>开户银行</th>
                                        <th hidden>银行账户</th>
                                        <th hidden>账户姓名</th>
                                        <th hidden>付款周期</th>
                                        <th hidden>供应商主数据状态</th>
                                        <th hidden>营业执照</th>
                                    </tr>
                                </thead>
                                    <tbody >                        
                                <?php if( isset($product_supplier_list) && is_array($product_supplier_list))  foreach ($product_supplier_list as $key => $product_supplier) { ?>
                                    <tr>
                                    <td class="product_supplier_id">
                                            <?php echo $product_supplier['product_supplier_id'] ?> 
                                        </td>
                                        <td class="product_supplier_name">
                                            <a href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>productSupplierList/editIndex?product_supplier_id=<?php echo $product_supplier['product_supplier_id'] ?>" id="addProduct"><?php echo $product_supplier['product_supplier_name'] ?> </a>
                                        </td>
                                        
                                        <td class="product_type">
                                             <?php if($product_supplier['product_type']=='goods')
                                             	   	 echo "商品";
                                              	   elseif($product_supplier['product_type']=='supplies')
                                              	   	 echo "耗材";
                                              	   else 
                                              	   	 echo $product_supplier['product_type'];?>   
                                        </td>
                                        <td class="supplier_type">
                                        	 <?php if($product_supplier['supplier_type']=='company')
                                             	   	 echo "公司";
                                              	   elseif($product_supplier['supplier_type']=='market')
                                              	   	 echo "市场档口";
                                              	   elseif($product_supplier['supplier_type']=='cooperative') 
                                              	   	 echo "产地合作社";
                                              	   else 
                                              	   	 echo "";?>  
                                        </td>
                                        <td hidden class="product_supplier_address">
                                             <?php echo $product_supplier['product_supplier_address'] ?>   
                                        </td>
                                        <td class="supplier_level">
                                        	 <?php if($product_supplier['supplier_level']=='')
                                        	 		 echo "";
                                        	 	   else 
                                        	 	   	 echo $product_supplier['supplier_level']."星";?>  
                                        </td>
                                        <td class="supplier_contact_name">
                                             <?php echo $product_supplier['supplier_contact_name'] ?>   
                                        </td>
                                        <td class="supplier_contact_mobile">
                                             <?php echo $product_supplier['supplier_contact_mobile'] ?>   
                                        </td>
                                        <td class="created_time">
                                             <?php echo $product_supplier['created_time'] ?>   
                                        </td>
                                        <td>
                                             <img width="40px" class="business_license" src=<?php if(!empty($product_supplier['business_license'] ))
                                             					echo $WEB_ROOT.$upload_path.$product_supplier['business_license'];
                                             				else 
                                             					echo "uploads/index.jpg"?>   alt="证件照" /> 
                                        </td>
                                        <td hidden class="note">
                                             <?php echo $product_supplier['note'] ?>   
                                        </td>
                                        <td>
                                        	<input  type="button"  class="show_account btn btn-primary" style="text-align: right" value="账户信息">
                                        </td>
                                        <td>
                                        	<input  type="button"  class="show_details btn btn-primary" style="text-align: right" value="进项税率详情">
                                        </td>
                                        <td>
                                        	<?php  
												if( $this->helper->chechActionList(array('updateSupplierStatus')) ){
		                                        	switch($product_supplier['enabled']){
		                                        		case 2:
		                                        			echo "未审核";
		                                        			break;
		                                        		case 1:
		                                        			echo "激活";
		                                        			break;
		                                        		case 0:
		                                        			echo "冻结";
		                                        			break;
		                                        	}
												}
											?>	
                                        </td>
                                        <td>
                                        <?php  
										if( $this->helper->chechActionList(array('updateSupplierStatus')) ){ ?>
                                        	<?php if($product_supplier['enabled']==1){ ?>
                                        		<input  type="button"  class="status_change btn btn-danger" style="text-align: right;" value="冻结" >
                                        	<?php } else {?>
                                        		<input  type="button"  class="status_change btn btn-success" style="text-align: right;" value="激活" >
										<?php }
										}?>	
                                        </td>
                                        <td hidden class="opening_bank">
                                             <?php echo $product_supplier['opening_bank'] ?>   
                                        </td>
                                        <td hidden class="bank_account">
                                             <?php echo $product_supplier['bank_account'] ?>   
                                        </td>
                                        <td hidden class="bank_account_name">
                                             <?php echo $product_supplier['bank_account_name'] ?>   
                                        </td>
                                        <td hidden class="payment_cycle">
                                             <?php echo $product_supplier['payment_cycle'] ?>   
                                        </td>
                                        <td hidden class="enabled">
                                       		 <?php echo $product_supplier['enabled'] ?> 
                                        </td>
                                        <td hidden class="photos_url">
                                       		 <?php echo $product_supplier['business_license'] ?>
                                        </td>
                                        
                                    </tr>
                                
                                <?php } ?>
								</tbody>
                            </table>
                        </div>
                        <!-- product list end -->
                    </div>
                    <div role="tabpanel" class="tab-pane" id="undercarriage"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- 银行账户Modal -->
<div>
	<div class="modal fade ui-draggable text-center" id="account_modal" role="dialog"  >
	  <div class="modal-dialog" style="display: inline-block; width: 500px">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" id="btnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">银行账户信息</h4>
	      </div>
	      <div class="modal-body" style="text-align: left;">
	      
	      	<div class='row'>
				<label style="text-align: right;">开户银行：</label><input readonly="readonly"  style="border:0px" type="text" id="show_opening_bank" >
			</div>
			<div class='row'>
				<label style="text-align: right;">银行账户：</label><input readonly="readonly"  style="border:0px" type="text" id="show_bank_account" >
			</div>
			<div class='row'>
				<label style="text-align: right;">账户姓名：</label><input readonly="readonly"  style="border:0px" type="text" id="show_bank_account_name" >
			</div>	
			<div class='row'>
				<label style="text-align: right;">付款条件：</label><input readonly="readonly"  style="border:0px" type="text" id="show_payment_cycle" >
			</div>
	      </div>
	      <div class="modal-footer">
	      	<input id="show_bank_info" type="button" class="bank_info btn btn-primary" style="text-align: right" value="确认">
	      </div>
	    </div>
	  </div>
	</div>
</div>
<!-- modal end  -->

    <!-- 税率详情Modal -->
<div>
	<div class="modal fade ui-draggable text-center" id="details_modal" role="dialog"  >
	  <div class="modal-dialog" style="display: inline-block; width: 500px">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" id="btnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">进项税率详细信息</h4>
	      </div>
	      <div class="modal-body" style="text-align: left;">
	      
	      	<table class="table table-striped table-bordered " style="width:100%">
                    <thead>
                           <tr>
                                 <th>供应商</th>
                                 <th>商品名</th>
                                 <th>商品类型</th>
                                 <th>进项税率</th>
							   <th>扣除率</th>
							   <th>审核状态</th>
							   <th>操作</th>
                                        
                           </tr>
                    </thead>
                    <tbody id = "show_table_body">

                    </tbody> 
              </table>
	      </div>
	      <div class="modal-footer">
	      	<input id="show_details_info" type="button" class="details btn btn-primary" style="text-align: right" value="确认">
	      </div>
	    </div>
	  </div>
	</div>
</div>
<!-- modal end  -->

<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/lhgcalendar.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/jquey-bigic.js"></script>
	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/jquery.dataTables.js"></script>
	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/dataTables.bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/dataTables.buttons.js"></script>
	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/buttons.colVis.js"></script>
	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/buttons.flash.js"></script>


<script type="text/javascript">
																								
	$(document).ready(function(){
	    (function(config){
	        config['extendDrag'] = true; // 注意，此配置参数只能在这里使用全局配置，在调用窗口的传参数使用无效
	        config['lock'] = true;
	        config['fixed'] = true;
	        config['okVal'] = 'Ok';
	        config['format'] = 'yyyy-MM-dd HH:mm:ss';
	    })($.calendar.setting);

	    $("#start_time").calendar({btnBar:true});
	    $("#end_time").calendar({btnBar:true});
	    var table=$('#list').DataTable({
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
            "lengthMenu": [[30, 10, 60, 100, -1], [30, 10, 60, 100, "全部"]],
            "aaSorting":[0,"desc"]
        });
	}) ;	


	
     $("#query").click(function(){
         $("#page_current").val("1");
         $("form").submit();
     }); 

 	 $('.show_account').click(function(){
 		 var obj = $(this).parent().parent();
 		 $("#show_opening_bank").val($.trim(obj.children(".opening_bank").html()));
		 $("#show_bank_account").val($.trim(obj.children(".bank_account").html()));
		 $("#show_bank_account_name").val($.trim(obj.children(".bank_account_name").html()));
		 $("#show_payment_cycle").val($.trim(obj.children(".payment_cycle").html()));
		 $("#account_modal").modal('show');
	 });

	var permission = <?php echo $this->helper->chechActionList(array('productTaxRate')) ? 'true':'false' ;?>;
 	$('.show_details').click(function(){
		 var obj = $(this).parent().parent();
		 var id = $.trim(obj.children(".product_supplier_id").html());
		 var name = $.trim(obj.children(".product_supplier_name").html());
		var statusMap = <?php echo json_encode($statusMap);?>;
		 $.ajax({
	            type: "get",
	            url: $('#WEB_ROOT').val() + 'productSupplierList/getSupplierProductMappingList',
	            data: {'product_supplier_id':id},
	            dataType: "json",
	            success: function(data) {
	                if (data.success == 'success') {
	                	$("#show_table_body").empty();
	                	$.each(data.mapping_list, function (n, value) { 
	                		
							var str = "";
	                        var product_category=value.product_category_name;
	                        var tax_rate=value.tax_rate;
							var deduction_rate = value.deduction_rate;
							var status = statusMap[value.status] == undefined ? '' : statusMap[value.status];
	                        str += "<tr><td>"+name+"</td><td>"+value.product_name+"</td><td class='product-category'>"+product_category+"</td><td class='tax-rate'>"+tax_rate+"</td><td class='deduction-rate'>"+deduction_rate+"</td><td>"+status+"</td><td>";
							if (permission) {
								if (value.status == 0) {
									str += '<input type="button" class="btn btn-success check" value="通过"><br>';
									str += '<input type="button" class="btn btn-danger fail" value="修改">';
								} else {
									str += '<input type="button" class="btn btn-danger modify" value="修改">';
								}
							}
							str += "</td><td hidden='true'>"+value.id+"</td></tr>";
	                        $(str).appendTo("#show_table_body");
	                    });  
		                $("#details_modal").modal('show');
	                } else {
	                    alert("获取失败");
	                }
	            }
	        }).fail(function(data) {
	            console.log(data)
	        });
			
		 //$("#details_modal").modal('show');
		 
	 });

	function examine(event, status, description) {
		var operationTd = $(event.target).parent();
		var id = operationTd.next().html();
		$.ajax({
			type: 'get',
			url: $('#WEB_ROOT').val()+'productSupplierList/examine',
			data: {id:id,status:status},
			dataType: 'json',
			success: function(data) {
				if (data.success == 'true') {
					operationTd.html('<input type="button" class="btn btn-danger modify" value="修改">');
					operationTd.prev().html(description);
				} else {
					if (data.error_info != undefined) {
						alert(data.error_info);
					} else {
						alert('操作失败')
					}
				}
			}
		})
	}
	$(document).on('click','.check',function(event){
		var operationTd = $(event.target).parent();
		var id = operationTd.next().html();
		var grandpa = $(event.target).parent().parent();
		if (grandpa.find('.tax-rate select').length) {
			var taxRate = grandpa.find('.tax-rate select').val();
			var deductionRate = grandpa.find('.deduction-rate select').val();
			var productCategory = grandpa.find('.product-category select').val();
			$.ajax({
				type: 'get',
				url: $('#WEB_ROOT').val()+'productSupplierList/modifyandcheck',
				data: {id:id,tax_rate:taxRate,deduction_rate:deductionRate, product_category:productCategory},
				dataType: 'json',
				success: function(data) {
					if (data.success == 'true') {
						operationTd.html('<input type="button" class="btn btn-danger modify" value="修改">');
						operationTd.prev().html('审核成功');
						grandpa.find('.product-category').html(grandpa.find('.product-category select').find('option:selected').text());
						grandpa.find('.tax-rate').html(grandpa.find('.tax-rate select').find('option:selected').text());
						grandpa.find('.deduction-rate').html(grandpa.find('.deduction-rate select').find('option:selected').text());
					} else {
						if (data.error_info != undefined) {
							alert(data.error_info);
						} else {
							alert('操作失败');
						}
					}
				}

			})
		} else {
			examine(event, 'checked', '审核成功');
		}


	});

	$(document).on('click','.fail', function(event){
//		examine(event, 'failed', '审核失败');
		var grandpa = $(event.target).parent().parent();
		var productCategoryTd = grandpa.find('.product-category');
		var taxRateTd = grandpa.find('.tax-rate');
		var deductionRateTd = grandpa.find('.deduction-rate');
		var productCategoryList = <?php echo json_encode($product_category_list); ?>;
		var taxRateList = <?php echo json_encode($tax_rate_list); ?>;
		var deductionRateList = <?php echo json_encode($deduction_rate_list); ?>;
		transferElement(productCategoryTd, productCategoryList, 'product_category_id', 'product_category_name');
		transferElement(taxRateTd, taxRateList, 'tax_rate_id','tax_rate');
		transferElement(deductionRateTd, deductionRateList, 'tax_rate_id', 'tax_rate');

	});
	$(document).on('click','.modify',function(event) {
		var grandpa = $(event.target).parent().parent();
		var productCategoryTd = grandpa.find('.product-category');
		var taxRateTd = grandpa.find('.tax-rate');
		var deductionRateTd = grandpa.find('.deduction-rate');
		var productCategoryList = <?php echo json_encode($product_category_list); ?>;
		var taxRateList = <?php echo json_encode($tax_rate_list); ?>;
		var deductionRateList = <?php echo json_encode($deduction_rate_list); ?>;
		transferElement(productCategoryTd, productCategoryList, 'product_category_id', 'product_category_name');
		transferElement(taxRateTd, taxRateList, 'tax_rate_id','tax_rate');
		transferElement(deductionRateTd, deductionRateList, 'tax_rate_id', 'tax_rate');
		$(this).removeClass('modify');
		$(this).removeClass('btn-danger');
		$(this).addClass('modify-submit');
		$(this).addClass('btn-success');
		$(this).val('确认');

	});
	$(document).on('click','.modify-submit', function(event) {
		var operationTd = $(event.target).parent();
		var id = operationTd.next().html();
		var grandpa = $(event.target).parent().parent();
		var taxRate = grandpa.find('.tax-rate select').val();
		var deductionRate = grandpa.find('.deduction-rate select').val();
		var productCategory = grandpa.find('.product-category select').val();
		var thisButton = $(this);
		$.ajax({
			type: 'get',
			url: $('#WEB_ROOT').val()+'productSupplierList/modifyandcheck',
			data: {id:id,tax_rate:taxRate,deduction_rate:deductionRate, checked: true, product_category:productCategory},
			dataType: 'json',
			success: function(data) {
				if (data.success == 'true') {
					grandpa.find('.product-category').html(grandpa.find('.product-category select').find('option:selected').text());
					grandpa.find('.tax-rate').html(grandpa.find('.tax-rate select').find('option:selected').text());
					grandpa.find('.deduction-rate').html(grandpa.find('.deduction-rate select').find('option:selected').text());
					console.log($(this));
					thisButton.removeClass('modify-submit');
					thisButton.removeClass('btn-success');
					thisButton.addClass('modify');
					thisButton.addClass('btn-danger');
					thisButton.val('修改');
				} else {
					if (data.error_info != undefined) {
						alert(data.error_info);
					} else {
						alert('操作失败');
					}
				}
			}

		})

	});
	function transferElement(element, options, key, value) {
		var html = '<select>';
		for (var i = 0; i < options.length; i++) {
			if (options[i][value] == element.html()) {
				html += '<option selected value="'+options[i][key]+'">'+options[i][value]+'</option>';
			} else {
				html += '<option value="'+options[i][key]+'">'+options[i][value]+'</option>';
			}
		}
		element.html(html + '</select>');
	}
     $(".bank_info").click(function(){
         $("#account_modal").modal('toggle');
     });   

     $(".details").click(function(){
         $("#details_modal").modal('toggle');
     });
     
     $(".status_change").click(function(){
         var status_tmp = 0;
         var message = "激活成功";
    	 var obj = $(this).parent().parent();
    	 
    	 var status = $.trim(obj.children(".enabled").html());

    	 var id = $.trim(obj.children(".product_supplier_id").html());

    	 
    	 if(status==0)
        	 status_tmp = 1;
    	 else if(status==1){
        	 status_tmp = 0;
    	 	 message = "冻结成功";}
    	 else if(status==2){
    		 status_tmp = 1;
    	 	 message = "审核通过";
    	 }

    	 $.ajax({
	            type: "post",
	            url: $('#WEB_ROOT').val() + 'productSupplierList/updateSupplierStatus',

	            data: {'product_supplier_id':id, 
		            	'enabled':status_tmp },
	            dataType: "json",
	            success: function(data) {
	                if (data.success == 'true') {
	                	alert(message);
	                	window.location.reload();
	                } else {
	                    alert("操作失败");
	                }
	            }
	        }).fail(function(data) {
	            console.log(data)
	        });	 
     });
    	
    // 分页 
    $('a.page').click(function(){
        var page =$(this).attr('p');
        $("#page_current").val(page); 
        $("form").submit();
    }); 

    // 上一页
    $('a#page_prev').click(function(){
        var page = $("#page_current").val();
        if(page != parseInt(page) ) {
            $('#page_current').val(1);
            page = 1; 
        }else{
            page = parseInt(page); 
            if(page > 1 ){
                page = page - 1; 
               $('#page_current').val(page);
               $("form").submit(); 
            }
        }
    }); 

    // 下一页
    $('a#page_next').click(function(){
        var page = $("#page_current").val();
        page = parseInt(page);
        var page_count = $("#page_count").val(); 
        page_count = parseInt(page_count);
        if(page < page_count ){
            page = page + 1; 
            $("#page_current").val(page);
            $("form").submit(); 
        }
    }); 

    $(function(){
    	$('img').bigic();
    });


</script>
</body>
</html>
