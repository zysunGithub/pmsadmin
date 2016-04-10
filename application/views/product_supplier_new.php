<!doctype html>
<html>
<head>
<meta charset="UTF-8" />
<title>拼好货WMS</title>
<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/product.css">
<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/autocomplete.css">
<style>
	.label_info{margin-left:-5%;margin:10px,0px,5px;font-size:110%}
	table .btn-danger { padding-top: 0; padding-bottom: 0; }
	table input { width: 100%; }
	p input.form-control { display: inline-block; width: 100px; }

</style>
</head>
<body style="width: 100%;">
<input type="text" hidden="true" id="WEB_ROOT" value="<?php echo $WEB_ROOT?>"> 
<form id="supplier_form" name="supplier_form" method="post" action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>productSupplierList/addNewSupplier"
	enctype="multipart/form-data">
<div style="margin-left:10%" id='basicData'>
		<label class="label_info" style="text-align:left;">基础信息</label>   
	        <div class='row'>
				<label  style="text-align: right;"><em style="font-style: normal;color: red;font-weight: 900;">*</em>供应商：</label><input class="form-control" style="width: 200px;display: inline" type="text" id="edit_product_supplier_name" name="product_supplier_name" >
			</div>
			<div class='row'>
				<label  style="text-align: right;"><em style="font-style: normal;color: red;font-weight: 900;">*</em>商品类型：</label><select id="edit_product_type" class="form-control" style="width: 200px;display: inline" name="product_type" >
										<option value="">==请选择==</option>
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
			<div class='row'>
				<label  style="text-align: right;"><em style="font-style: normal;color: red;font-weight: 900;">*</em>供应商类型：</label><select class="form-control" style="width: 200px;display: inline" id="edit_supplier_type"  name="supplier_type" >
					<option value="">==请选择==</option>
					<option value="company">公司</option>
					<option value="market">市场档口</option>
					<option value="cooperative">产地合作社</option>
                </select>
			</div>
			<div class='row'>
				<label  style="text-align: right;"><em style="font-style: normal;color: red;font-weight: 900;">*</em>联系人：</label><input class="form-control" style="width: 200px;display: inline" type="text" id="edit_supplier_contact_name" name="supplier_contact_name">
			</div>
			<div class='row'>
				<label  style="text-align: right;"><em style="font-style: normal;color: red;font-weight: 900;">*</em>联系电话：</label><input class="form-control" style="width: 200px;display: inline" type="text" id="edit_supplier_contact_mobile" name="supplier_contact_mobile" >
			</div>
			<div class='row'>
				<label  style="text-align: right; margin:0px;vertical-align:top"><em style="font-style: normal;color: red;font-weight: 900;">*</em>地址：</label><textarea class="form-control" style="width: 200px;display: inline" rows="3" cols="50" id="edit_product_supplier_address" name="product_supplier_address"></textarea>
			</div>
			<div class='row'>
				<label  style="text-align: right;">营业执照：</label><br>
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
			
		<label class="label_info" style="text-align:left;">财务信息</label> 
			<div class='row'>
				<label  style="text-align: right;"><em style="font-style: normal;color: red;font-weight: 900;">*</em>开户银行：</label><input class="form-control" style="width: 200px;display: inline" placeholder="请填写全称" type="text" id="edit_opening_bank" name="opening_bank">
			</div>
			<div class='row'>
				<label  style="text-align: right;"><em style="font-style: normal;color: red;font-weight: 900;">*</em>银行账户：</label><input class="form-control" style="width: 200px;display: inline" type="text" id="edit_bank_account" name="bank_account">
			</div>
			<div class='row'>
				<label  style="text-align: right;"><em style="font-style: normal;color: red;font-weight: 900;">*</em>账户姓名：</label><input class="form-control" style="width: 200px;display: inline" type="text" id="edit_bank_account_name" name="bank_account_name">
			</div>
			<div class='row'>
				<label  style="text-align: right;">付款周期：</label><input class="form-control" style="width: 200px;display: inline" type="text" id="edit_payment_cycle" name="payment_cycle">
			</div>
		<label class="label_info" style="text-align:left;">状态信息</label>
			
			
			<div class='row'>
				<label  style="text-align: right;">等级：</label><select id="edit_supplier_level" class="form-control" style="width: 200px;display: inline" name="supplier_level" >
					<option value="">==请选择==</option>
					<option value="5">5星</option>
					<option value="4">4星</option>
					<option value="3">3星</option>
					<option value="2">2星</option>
					<option value="1">1星</option>
                </select>
			</div>
			
			<div class='row'>
				<label style="text-align: right;vertical-align:top">备注：</label><textarea class="form-control" style="width: 200px;display: inline" rows="3" cols="50" id="edit_note" name="note"></textarea>
			</div>

			
	      </div>
	</div>			
</form>
<div class="row col-md-10"  style="text-align: left;margin-left:20%">
	<input id="create_product_supplier" type="button" class="btn btn-primary" value="提交" >
</div><br><br><br><br>

<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="http://cdn.bootcss.com/jquery.form/3.51/jquery.form.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/common.js"></script>
<script>

function validateSubmitData(){
    //基础数据
    var product_supplier_name = $("#edit_product_supplier_name");
    var product_type = $("#edit_product_type");
    var supplier_type = $("#edit_supplier_type");
    var supplier_contact_name = $("#edit_supplier_contact_name");
    var supplier_contact_mobile = $("#edit_supplier_contact_mobile");
	var product_supplier_address = $("#edit_product_supplier_address");
    var opening_bank = $("#edit_opening_bank");
    var bank_account = $("#edit_bank_account");
    var bank_account_name = $("#edit_bank_account_name");
    var payment_cycle = $("#edit_payment_cycle");
    var supplier_level = $("#edit_supplier_level");
    var note = $("#edit_note");

    if($.trim(product_supplier_name.val()) == '') {
        alert("供应商名称不能为空！");
        product_supplier_name.focus();
        return false;
    }
    if($.trim(product_type.val()) == '') {
        alert("商品类型不能为空！");
        product_type.focus();
        return false;
    }
    if($.trim(supplier_type.val()) == '') {
        alert("供应商类型不能为空！");
        supplier_type.focus();
        return false;
    }
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

	$('#create_product_supplier').click(function(){
	
    	var result = validateSubmitData();

    	if(!result){
        	return false;
    	}else if(result!==1){
        	var cf=confirm( "是否确认创建?" )
        	if(!cf){
            	return;
       		}
    	}
            
    	btn = $(this);
    	btn.attr('disabled','disabled');
    	$('#supplier_form').submit();
	});

    $("#supplier_form").submit(function(){ 

        options = {
            dataType: 'json',
            success: function (data) {
                if(data.success == "true"){
                    alert('创建成功');
                    window.history.back(-1);
                } else{
                    alert("创建失败!");
                    btn.removeAttr('disabled');
                }
            }
        };
       $("#supplier_form").ajaxSubmit(options);
       return false;
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
