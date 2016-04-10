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
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/style.css">
	<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/product.css">
	<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/autocomplete.css">
    
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
       #popTable input,#popTable select{width:80%;}
       .secondTab .table>thead:first-child>tr:first-child>th{border-top:1px solid #ddd;border-bottom:0;}
  		.no-click{color:#626262 !important;background:#d0d0d0 !important;}
    </style>
    <!--[if lt IE 9]>
        <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <![endif]-->
</head>
<body> 
<ul class="nav nav-tabs">
   <li class="active main_tab"><a href="#masterData" data-toggle="tab">主数据</a></li>
   <li id="taxEdit_tab" ><a href="#taxEdit" data-toggle="tab">进项税率设置</a></li>
</ul>
<div class="firstTab">
	<form id="supplier_form" name="supplier_form" method="post" action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>productSupplierList/editSupplier" enctype="multipart/form-data">
		<div>
	        	<button type="button" class="close" id="btnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        	<br><h4 style="margin-left:5%;" class="modal-title" >编辑供应商信息</h4>
	    </div>
	    <div class="modal-body" style="text-align: left; margin-left:5%">
			<div class='row'>
				<label  style="text-align: right;">编号：</label><input class="form-control" style="width: 200px;display: inline"  type="text" name="product_supplier_id" class="no-click" readonly="readonly" value= "<?php echo $product_supplier['product_supplier_id'] ?>" >
			</div>
			<div class='row'>
				<label  style="text-align: right;">供应商：</label><input class="form-control" style="width: 200px;display: inline" type="text" name="product_supplier_name" class="no-click"  readonly="readonly" id="edit_product_supplier_name" value= "<?php echo $product_supplier['product_supplier_name'] ?>">
			</div>
			<div class='row'>
				<label  style="text-align: right;">类型：</label><select class="form-control" style="width: 200px;display: inline" id="edit_product_type" name="product_type" class="no-click" disabled="disabled" readonly="readonly" style="width:175px;height:26px"  >
		                            <?php
		                                $product_type = $product_supplier['product_type'];
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
			<div hidden class='row'>
				<label style="text-align: right;">供应商类型：</label><select class="form-control" style="width: 200px;display: inline" readonly="readonly" name="supplier_type" value= "<?php echo $product_supplier['supplier_type'] ?>"  >
					<option <?php	if($product_supplier['supplier_type'] =="company")
										echo "selected = 'selected'";
										?> value="company">公司</option>
					<option <?php	if($product_supplier['supplier_type'] =="market")
										echo "selected = 'selected'";
										?> value="market">市场档口</option>
					<option <?php	if($product_supplier['supplier_type'] =="cooperative")
										echo "selected = 'selected'";
										?>  value="cooperative">产地合作社</option>
                </select>
			</div>
			<div class='row'>
				<label  style="text-align: right;">供应商类型：</label><input disabled class="form-control" style="width: 200px;display: inline" type="text"  value= " <?php	if($product_supplier['supplier_type'] =='company')
					echo '公司';
				if($product_supplier['supplier_type'] =='market')
					echo '市场档口';
				if($product_supplier['supplier_type'] =='cooperative')
					echo '产地合作社'; ?>"</input>
			</div>
			<div class='row'>
				<label  style="text-align: right;">联系人：</label><input class="form-control" style="width: 200px;display: inline" type="text" name="supplier_contact_name"  value= "<?php echo $product_supplier['supplier_contact_name'] ?>" >
			</div>
			<div class='row'>
				<label  style="text-align: right;">联系电话：</label><input class="form-control" style="width: 200px;display: inline" type="text"  name="supplier_contact_mobile" value= "<?php echo $product_supplier['supplier_contact_mobile'] ?>"  >
			</div>
			<div class='row'>
				<label  style="text-align: right;vertical-align:top">地址：</label><textarea class="form-control" style="width: 200px;display: inline" name="product_supplier_address" rows="3" cols="40" ><?php echo $product_supplier['product_supplier_address'] ?></textarea>
			</div>
			<div class='row'>
				<label  style="text-align: right;">营业执照：</label>
				<img width="20%" class="business_license" src=<?php if(!empty($product_supplier['business_license'] ))
                                             					echo $WEB_ROOT.$upload_path.$product_supplier['business_license'];
                                             				else 
                                             					echo "../uploads/index.jpg"?>   alt="证件照" />
			</div>
			<div class='row'>
				<label  style="text-align: right;"></label><br>
					<div class="row col-md-5 imgDiv" style="margin-left: 10%;margin-top: 10px;">
								<div id="imgDiv1">
									<input type="file" id="business_license" name="business_license" class="img" size="0" style="display:none" />
								</div>
								<div id="cover1" class="cover" style="position: absolute; background-color: White; z-index: 10;
								filter: alpha(opacity=100); -moz-opacity: 1; opacity: 1; ">
									<input id="selectImg1" type="button" value="选择图片" class="selectImg btn btn-primary" />
								</div>
								<div class="imgShow" id="imgShow1" style="width: 400px; margin-top: 60px;">
									<div class="productImg" id="productImg1"  hidden="true" >
										<div style="border: 1px solid #eeeeee; padding: 3px; max-height: 390px; max-width: 390px; overflow: hidden; text-align: center; ">
											<img class="imgHolder" id="imgHolder1" style="max-height: 390px; max-width: 390px;" />
										</div>
										<input id="delImg1" type="button" style="width: 65px; height: 30px" value="删除" class="delImg btn btn-danger"> 
									</div>
								</div>
					</div>
			</div>
			
			<div class='row'>
				<label  style="text-align: right;">开户银行：</label><input class="form-control" style="width: 200px;display: inline" type="text" name="opening_bank"  value= "<?php echo $product_supplier['opening_bank'] ?>" >
			</div>
			<div class='row'>
				<label  style="text-align: right;">银行账户：</label><input class="form-control" style="width: 200px;display: inline" type="text" name="bank_account" id="bank_account"  value= "<?php echo $product_supplier['bank_account'] ?>">
			</div>
			<div class='row'>
				<label  style="text-align: right;">账户姓名：</label><input class="form-control" style="width: 200px;display: inline" type="text" name="bank_account_name"  value= "<?php echo $product_supplier['bank_account_name'] ?>">
			</div>
			<div class='row'>
				<label style="text-align: right;">付款周期：</label><input class="form-control" style="width: 200px;display: inline" type="text"  name="payment_cycle" value= "<?php echo $product_supplier['payment_cycle'] ?>" >
			</div>
			<div class='row'>
				<label  style="text-align: right;">等级：</label><select class="form-control" style="width: 200px;display: inline" name="supplier_level" value="<?php echo $product_supplier['supplier_level'] ?>"  style="width:175px;height:26px" >
					
					<option 
					<?php	if($product_supplier['supplier_level'] =="5") 
										echo "selected = 'selected'";
										?> value="5">5星</option>
					<option 
					<?php	if($product_supplier['supplier_level'] =="4") 
										echo "selected = 'selected'";
										?> value="4">4星</option>
					<option 
					<?php	if($product_supplier['supplier_level'] =="3") 
										echo "selected = 'selected'";
										?> value="3">3星</option>
					<option 
					<?php	if($product_supplier['supplier_level'] =="2") 
										echo "selected = 'selected'";
										?> value="2">2星</option>
					<option 
					<?php	if($product_supplier['supplier_level'] =="1") 
										echo "selected = 'selected'";
										?> value="1">1星</option>
                </select>
			</div>
			
			<div class='row'>
				<label for="edit_note" style="text-align: right;vertical-align:top">备注：</label><textarea class="form-control" style="width: 200px;display: inline" name="note"  rows="3" cols="40"><?php echo $product_supplier['note'] ?></textarea>
			</div>
	      </div>
	  </form>

	 <div style="margin-left: 15%;">
	    <?php  
			if( $this->helper->chechActionList(array('productSupplierEdit')) ){ ?>
				<input id="edit_supplier" type="button" class="btn btn-primary" style="text-align: right" value="提交">
		<?php }?>
	 </div><br><br><br>
	      
</div>

<!-- modal end  -->

<!-- 设置税率Modal -->
<div class="secondTab" style="display:none">
<div class="panel panel-default">
	<div class="panel-body">
		<label>设置进项税率
			<input type="button" id="setSupplierProductMappingBtn" value="编辑" class="btn btn-primary btn-sm"></label>
		<table style="width: 60%;border:3px;" class="table table-striped table-bordered ">
					<thead>
						<tr>
							<th>商品</th>
							<th>商品类型</th>
							<th>进项税率</th>
							<th>扣除率</th>
							<th>审核状态</th>
							<th>创建时间</th>
							<th>创建人</th>
						</tr>
					</thead>
					<tbody style="text-align: left;" id="showProductInfo">
					<?php 
					foreach ($SupplierProductMappingList as $item) {
						echo "<tr><td>".$item['product_name']."</td><td>".$item['product_category_name']."</td><td>".
							($item['tax_rate']*100)."%</td><td>".($item['deduction_rate']*100)."%</td><td>".
							$statusMap[$item['status']]."</td><td>".
							$item['created_time']."</td><td>".
							$item['created_user']."</td><tr>";
					}
					 ?>
					</tbody>
				</table>
	</div>
</div>

<!-- Start popWin -->
<div class="popWin modal fade" style="display:none" role="dialog" >
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" 
	               data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">进项税率设置</h4>
				</div>
				<div class="modal-body">
				<?php  
			if( $this->helper->chechActionList(array('productSupplierEdit')) ){ ?>
				<em class="btn btn-sm btn-primary" style="margin-bottom:10px;font-style:normal;" id="newAdd">新增</em>
		<?php }?>
	      <table style="border: 3;" class="table table-striped table-bordered ">
					<thead>
						<tr>
							<th>商品</th><th>商品类型</th><th>进项税率</th><th>扣除率</th><th>审核状态</th><th>操作</th>
						</tr>
					</thead>
					<tbody style="text-align: left;" id="popTable"></tbody>
				</table>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" 
	               data-dismiss="modal" id="popWinClose">关闭</button>
					<!--<button type="button" class="btn btn-primary" id="productSubmit">保存</button>
				--></div>
			</div>
		</div>
	</div>
<!-- End popWin -->
</div>
<input type="text" hidden="true" id="WEB_ROOT" value="<?php echo $WEB_ROOT?>">
<input type="text" hidden="true" id="current_user" value="<?php 
            $CI =& get_instance();
    $CI->load->library('session');
    echo $CI->session->userdata('username');
?>"> 
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="http://cdn.bootcss.com/jquery.form/3.51/jquery.form.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/common.js"></script>

<script type="text/javascript">
	webUrl = $('#WEB_ROOT').val();
	var supplierType = '<?php echo $product_supplier['supplier_type'];?>';
	var defaultTaxInfo = <?php echo json_encode($supplier_product_tax_map); ?>;

	current_user=$("#current_user").val();
	product_category_lists=<?php echo json_encode($product_category_list); ?>;
	taxrate_lists=<?php echo json_encode($tax_rate_list); ?>;
	deduction_rate_list=<?php echo json_encode($deduction_rate_list); ?>;
	statusMap = <?php echo json_encode($statusMap);?>;
	SupplierProductMappingList=<?php echo json_encode($SupplierProductMappingList); ?>;
	all_product_list=null;
	$(document).ready(function(){
		//console.log(webUrl+"product/getProductList?product_type=goods&product_sub_type=raw_material");
		$.ajax({
			url:webUrl+"product/getProductList?product_type=goods&product_sub_type=raw_material",
			type:"get",
			dataType:"json",
			xhrFields: {
	            withCredentials: true
	        }
		}).done(function(data){
			if(data.res == "success"){
				all_product_list=data.product_list;
			}	
			else{
				alert("获取商品失败");}
			});
		$("#bank_account").keydown(function(event){
			//bank_account_val=this.value;
		});
		$("#bank_account").keyup(function(){
			this.value =this.value.replace(/\D/g,'').replace(/(\d{4})(?=\d)/g,"$1 ");
		});
	});
	function getRateObj(commodityType) {
		var len = defaultTaxInfo.length;
		for (var i = 0; i < len; i++) {
			if (defaultTaxInfo[i].supplier_type == supplierType && defaultTaxInfo[i].product_category_id == commodityType) {
				return defaultTaxInfo[i];
			}
		}

	}

	function validateSubmitData(){
		//必填数据
		var supplier_contact_name = $("input[name='supplier_contact_name']");
		var supplier_contact_mobile = $("input[name='supplier_contact_mobile']");
		var product_supplier_address = $("textarea[name='product_supplier_address']");
		var opening_bank = $("input[name='opening_bank']");
		var bank_account = $("input[name='bank_account']");
		var bank_account_name = $("input[name='bank_account_name']");

		if($.trim(supplier_contact_name.val()) == '') {
			alert("联系人不能为空！");
			supplier_contact_name.focus();
			return false;
		}
		if($.trim(supplier_contact_mobile.val()) == '') {
			alert("联系电话不能为空！");
			supplier_contact_mobile.focus();
			return false;
		}
		if($.trim(product_supplier_address.val()) == '') {
			alert("地址不能为空！");
			product_supplier_address.focus();
			return false;
		}
		if($.trim(opening_bank.val()) == '') {
			alert("开户银行不能为空！");
			opening_bank.focus();
			return false;
		}
		if($.trim(bank_account.val()) == '') {
			alert("银行账户不能为空！");
			bank_account.focus();
			return false;
		}
		if($.trim(bank_account_name.val()) == '') {
			alert("账户姓名不能为空！");
			bank_account_name.focus();
			return false;
		}
		return true;

	}

	$('#edit_supplier').click(function(){
		
        var cf=confirm( "无论是否更改,提交都将重新审核\n是否提交?" )
        if(!cf){
            	return;
       	}     

		if(validateSubmitData()){
			btn = $(this);
			btn.attr('disabled','disabled');
			$("#edit_product_type").removeAttr("disabled");
			$('#supplier_form').submit();
		};
	});
	

		$("#supplier_form").submit(function(){
		
	        //var val = $("#edit_product_type").val();
	        //alert(val);
	        options = {
        		dataType: 'json',
        		success: function (data) {
	        		if(data.success == "true"){
	        		    alert('修改成功');
	        		    window.history.back(-1);
	        		} else{
	        		    alert("修改失败"+data.error_info);
	        		    btn.removeAttr('disabled');
	        		}
	            	$("#edit_product_type").attr('disabled','disabled');
        		},
        		fail:function(data){
        		    console.log(data);
        		}
	        };
	        $("#supplier_form").ajaxSubmit(options);
	        return false;
		});

	    $('#taxEdit_tab').click(function(){
	 		 //var obj = $(this).parent().parent();
	 		 var code = $("#edit_product_supplier_name").val();
	 		// alert(code);
	 		 
	 		 $("#add_product_supplier_name").val($.trim(code));
			 //$("#tax_edit_modal").modal('show');
	 		$(".firstTab").hide();
	 		$(".secondTab").show();
		 });

	     $(".tax_edit").click(function(){
	         //$("#tax_edit_modal").modal('toggle');
	     }); 
	     $('.main_tab').click(function(){
	    	$(".firstTab").show();
		 	$(".secondTab").hide();
		 	
		 });
		 $("#setSupplierProductMappingBtn").click(function(){
			 var str="";
			 for(var i=0;i<SupplierProductMappingList.length;i++){
				 var t=SupplierProductMappingList[i];
				 str+="<tr><td><input type='text'  name='product_name' class='product_name no-click' data-product-id='"+t["product_id"]+"' value='"+t["product_name"]+"' disabled='disabled'></td>";
				 str+="<td><select class='product_category no-click' name='product_category' disabled='disabled'>";
				 str+="<option value='0' selected='selected'>"+t["product_category_name"]+"</option></select></td>";
				 str+="<td><select class='tax_rate no-click' name='tax_rate' disabled='disabled'>";
				 str+="<option value='0' selected='selected'>"+(t["tax_rate"]*100)+"%</option></select></td>";
				 str += "<td>"+(t['deduction_rate']*100)+"%</td>";
				 str += "<td>" + statusMap[t['status']] + "</td>";
				 str+="<td><a href='javascript:'>删除</a></td></tr>";
			 }
			 $("#popTable").html(str);
	    	 $(".popWin").modal('show');
		 });
	function padWithZero(number) {
		return number < 10 ? "0" + number : number;
	}
	function formatDate() {
		var now = new Date();
		var year = now.getFullYear();
		var month = padWithZero(now.getMonth()+1);
		var day = padWithZero(now.getDate());
		var hour = padWithZero(now.getHours());
		var minute = padWithZero(now.getMinutes());
		var second = padWithZero(now.getSeconds());
		return year + "-" + month + "-" + day + " " + hour + ":" + minute + ":" + second;
	}

	$("#newAdd").click(function () {
		var str = "";
		str += "<tr><td><input type='text'  name='product_name' class='product_name'></td>";
		str += "<td><select class='product_category' name='product_category'>";
		for (var i = 0; i < product_category_lists.length; i++) {
			str += "<option value='" + product_category_lists[i]["product_category_id"] + "'>" + product_category_lists[i]["product_category_name"] + "</option>";
		}
		str += "</select></td>";
		str += "<td><select class='tax_rate' name='tax_rate'>";
		for (var i = 0; i < taxrate_lists.length; i++) {
			str += "<option value='" + taxrate_lists[i]["tax_rate_id"] + "'>" + (taxrate_lists[i]["tax_rate"] * 100) + "%</option>";
		}
		str += "</select></td>";
		str += "<td><select class='deduction_rate' name='deduction_rate'>";
		for (var i = 0; i < deduction_rate_list.length; i++) {
			str += "<option value='" + deduction_rate_list[i]['tax_rate_id'] + "'>" + (deduction_rate_list[i]['tax_rate'] * 100) + "%</option>";
		}
		str += "<td>未审核</td><td><button class='btn btn-default btn-xs'>保存</button></td></tr>";
		$("#popTable").append(str);
	});
		 //delete
		 $("#popTable").click(function(e){
			 if(e.target.tagName.toLowerCase()=="a"){
				 var pCon=$(e.target.parentNode.parentNode);
				 var delData = {
			                'product_supplier_id': <?php echo '"'.$product_supplier['product_supplier_id'].'"'; ?>,
			                'product_id': pCon.find("[name=product_name]").attr("data-product-id")
			            };
				 $.ajax({
						url : webUrl+"ProductSupplierList/delSupplierProductMapping/taxrate/delete",
						type : 'POST',
						data : delData,
						dataType : "json",
						xhrFields:{
							withCredentials : true
						}
					}).done(function(data){
						if(data.success == "true"){
							delData['product_id'];
							for(var i=0;SupplierProductMappingList.length;i++){
								if(SupplierProductMappingList[i]['product_id']==delData['product_id']){
									SupplierProductMappingList.splice(i,1);
									break;
								}
							}
							var str="";
							for(var i=0;i<SupplierProductMappingList.length;i++){
								var tmp=SupplierProductMappingList[i];
								str+="<tr><td>"+tmp['product_name']+"</td><td>"+tmp['product_category_name']+"</td><td>"+(tmp['tax_rate']*100)+"%</td><td>"+(tmp['deduction_rate']*100)+"%</td><td>"+statusMap[tmp['status']]+"</td><td>"+tmp['created_time']+"</td><td>"+tmp['created_user']+"</td><tr>";
							}
							$("#showProductInfo").html(str);
							$(e.target.parentNode.parentNode).remove();
						}else{
							if (data.error_info == undefined) {
								alert("删除失败!");
							} else {
								alert(data.error_info);
							}
						}
					});
			 }
			 if(e.target.tagName.toLowerCase()=="button"){
				 var pCon=$(e.target.parentNode.parentNode);
				 var tmpProduct=pCon.find("[name=product_name]");
				 if(!tmpProduct.attr("data-product-id")){
					 tmpProduct.removeAttr("data-product-id");
					 alert("输入了不存在的商品,请重新输入");
					 pCon.find("[name=product_name]").focus();
					 return false;
				 }else{
					 var tmpId=-1;
					 for(var i=0;i<all_product_list.length;i++){
						 if(all_product_list[i]['product_id']==tmpProduct.attr("data-product-id")){
							 tmpId=i;
							 break;
						 }
					 }
					 if(tmpId!=-1 && $.trim(all_product_list[tmpId]['product_name'])!=$.trim(tmpProduct.val())){
						 tmpProduct.removeAttr("data-product-id");
						 alert("输入了不存在的商品,请重新输入");
						 pCon.find("[name=product_name]").focus();
						 return false;
					 }
				 }
				 var newAddData = {
			                'product_supplier_id': <?php echo '"'.$product_supplier['product_supplier_id'].'"'; ?>,
			                'product_id': pCon.find("[name=product_name]").attr("data-product-id"),
			                'product_category': pCon.find("[name=product_category]").val(),
			                'tax_rate': pCon.find("[name=tax_rate]").val(),
					 		'deduction_rate': pCon.find('[name=deduction_rate]').val()
			            };
				 $.ajax({
						url : webUrl+"ProductSupplierList/addSupplierProductMapping",
						type : 'POST',
						data : newAddData,
						dataType : "json",
						xhrFields:{
							withCredentials : true
						}
					}).done(function(data){
						if(data.success == "true"){
							var tmp={
									"product_category":pCon.find("[name=product_category] option:selected").text(),
									"product_id":newAddData['product_id'],
									"product_name":pCon.find("[name=product_name]").val(),
									"tax_rate":parseFloat(pCon.find("[name=tax_rate] option:selected").text())/100,
									"deduction_rate":parseFloat(pCon.find('[name=deduction_rate] option:selected').text())/100,
								status:0,
									"created_time": formatDate(),
					                "created_user":current_user
								};
							SupplierProductMappingList.push(tmp);

							var str="<tr><td>"+tmp['product_name']+"</td><td>"+tmp['product_category']+"</td><td>"+(tmp['tax_rate']*100)+"%</td><td>"+(tmp['deduction_rate']*100)+"%</td><td>未审核</td><td>"+
							tmp['created_time']+"</td><td>"+tmp['created_user']+"</td><tr>";
							$("#showProductInfo").append(str);
							pCon.children().children().attr("disabled","disabled").addClass("no-click");
							pCon.children(":last").html("<a href='javascript:'>删除</a>");
						}else{
							alert("新增失败!");
						}
					});
			 }
			 if(e.target.tagName.toLowerCase()=="input" && $(e.target).prop("disabled")!="true"){
				 if(all_product_list==null){
					 alert("未获取商品,请重新刷新页面!");
					 return false;
				 }
				 //$(e.target).attr("data-product-id",3);
				 $(e.target).autocomplete(all_product_list, {
				        minChars: 0,
				        width: 280,
				        max: 100,
				        matchContains: true,
				        autoFill: false,
				        formatItem: function(row, i, max) {
				            return row.product_name;
				        },
				        formatMatch: function(row, i, max) {
				            return row.product_name;
				        },
				        formatResult: function(row) {
				            return row.product_name;
				        }
				    }).result(function(event, row, formatted) {
				        $(this).attr("data-product-id",row.product_id);
					 	var tr = $(this).parent().parent();
					 	tr.find('.product_category option[value='+row.product_category_id+']').prop("selected",true);
					 var rateObj = getRateObj(row.product_category_id);
					 console.log(rateObj);
					 	tr.find('.tax_rate option[value='+rateObj.tax_rate+']').prop("selected",true);
					 tr.find('.deduction_rate option[value='+rateObj.deduction_rate+']').prop("selected",true);

				    });
			 }
		 });
		 $("#popWinClose").click(function(){
		    	//alert(123);
		 });
	
		 $(".img", ".imgDiv").mouseover(function () {
			    $(this).blur();
			});

			$(".img", ".imgDiv").change(function () {
			    productImg =$(this).parent().siblings('.imgShow').children('.productImg').attr('id');
			    imgHolder = $(this).parent().siblings('.imgShow').children('.productImg').children(0).children('.imgHolder').attr('id');
			    PreviewImage(this, imgHolder, productImg);
			});
			$('.selectImg').on('click',function(){
			    var $this = $(this),
			        $tInput = $this.parents('.imgDiv').find("input[type='file']");
			    $tInput.trigger('click');
			});
</script>
</body>
</html>
