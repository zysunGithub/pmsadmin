<!doctype html>
<html>
<head>
	<meta charset="UTF-8"/>
	<title>拼好货WMS</title>
	<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>/assets/css/normalize.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>/assets/css/global.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>/assets/css/order.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">

</head>
<body>
<div style="width: 100%;float:left;">
	<input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> >
    <div style="float:left;text-align: center;margin-left: 40%;margin-top: 20px">

        
        <?php  
			if( $this->helper->chechActionList(array('addMerchant')) ){ ?>
			<button class="btn btn-primary btn-sm"  style="float: right; margin-left:5px;" id="add_merchant">新增</button>
		<?php }?>	

    </div>
</div>
<div class="container-fluid" style="margin-left: -9px;padding-left: 19px;" >
        <div role="tabpanel" class="row tab-product-list tabpanel" >
            <div class="col-md-12">
				<div style="margin-top: 10px;" >
					<table class="table table-striped table-bordered table-condensed" style="text-align:center;vertical-align:middle;">
			            <thead>
			                <tr>
			                	<th style="text-align:center" width="10%">WMS商户编号</th>
								<th style="text-align:center" width="15%">WMS商户名称</th>
								<th style="text-align:center" width="10%">商户类型</th>
								<th style="text-align:center" width="10%">OMS商户名称</th>
								<th style="text-align:center" width="10%">覆盖区域</th>
								<th style="text-align:center" width="10%">上次更新时间</th>
								<th style="text-align:center" width="10%">更改状态</th>
								<th hidden>数据状态</th>
			                </tr>
			            </thead>
			            <tbody>
			            <?php if( isset($merchant_list) && is_array($merchant_list))  foreach ($merchant_list as $key => $merchant) { 
			            		$shop_array = array();
			            		$num = 0;
			            	 	if( isset($shops) && is_array($shops))  foreach ($shops as $key => $shop){
			            	 		if($key == $merchant['merchant_id']){
			            	 			$shop_array = $shop;
			            	 			$num = count($shop_array);
			            	 		}
			            	 	}
			            	?>
								<tr>
									<td class="merchant_id" rowspan="<?php echo $num; ?>"><?php echo $merchant['merchant_id']; ?></td>
									<td class="merchant_name" rowspan="<?php echo $num; ?>">
										<a href = "<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>MerchantList/editIndex?merchant_id=<?php echo $merchant['merchant_id'] ?>" id="editMerchant"><?php echo $merchant['merchant_name']; ?></a></td>
									<td class="merchant_type" rowspan="<?php echo $num; ?>"><?php 
											$type = $merchant['merchant_type'];
											if($type=="thirdparty")
												echo "第三方";
											elseif($type=="self")
												echo "自营";
											else
												echo $type; ?></td>
									<td class="shop_name"><?php if($num>=1){
																	echo $shop_array['0']['shop_name'];
																}else{
																	echo "";
																}
																	 ?></td>	


									<td class="area_id" rowspan="<?php echo $num; ?>"><?php echo $merchant['area_name']; ?></td>	
									<td class="created_time" rowspan="<?php echo $num; ?>"><?php echo $merchant['last_updated_time']; ?></td>
									<td class="enabled" rowspan="<?php echo $num; ?>">
										<?php 
											if($this->helper->chechActionList( array('updateMerchant'))){
												if($merchant['enabled']==1){ ?>
													<input  type="button"  class="status_change btn btn-danger" style="text-align: right;" name='1' value="冻结">
											<?php }else{ ?>
													<input  type="button"  class="status_change btn btn-success" style="text-align: right;" name ='0' value="激活">
											<?php }
											}else{
												if($merchant['enabled']==1){
													echo "已激活";
												}else{
													echo "已冻结";
												}
											}
										?>
									</td>
									<td class="enabled" hidden><?php echo $merchant['enabled']; ?></td>
		
								</tr>
								<?php 
									if($num>=2){
										for($i=1;$i<$num;$i++){
											echo "<tr><td class='shop_name'>".$shop_array["$i"]['shop_name']."</td></tr>";
										}
									}
								}?>
			            	
			            </tbody>
			        </table>


				</div>
			</div>
        </div>
    </div>


<!-- 新增商户Modal -->
<div>
	<div class="modal fade ui-draggable text-center" id="merchant_modal" role="dialog"  >
	  <div class="modal-dialog" style="display: inline-block; width: 600px">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" id="btnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">新增商户</h4>
	      </div>
	      <div class="modal-body" style="text-align: left; margin-left:15%">

			<div class='row'>
				<label  style="text-align: right;">商户名称：</label><input type="text"  id="edit_merchant_name" >
			</div>
			<div class='row'>
				<label style="text-align: right;">商户类型：</label><select  id="edit_merchant_type" style="width:175px;height:26px" >
					<option value="thirdparty">第三方</option>
					<option value="self">自营</option>
                </select>
			</div>
			<div class='row'>
				<label style="text-align: right;">所属平台：</label><select  id="platform_id" style="width:175px;height:26px" ></select>
			</div>
			<div class='row'>
				<label  style="text-align: right;">所属区域：</label><select  id="edit_area_id" style="width:175px;height:26px" >
					<option value="1">华东</option>
					<option value="2">华中</option>
					<option value="3">华南</option>
					<option value="4">华北</option>
					<option value="5">西北</option>
					<option value="6">西南</option>
					<option value="7">东北</option>
					<option value="8">大中华区</option>
                </select>
			</div>
			<div  hidden class='row'>
				<label  style="text-align: right;">商户门店：</label><select  id="edit_shop" style="width:175px;height:26px" >

					<?php if( isset($shop_list) && is_array($shop_list))  foreach ($shop_list as $key => $shop) { ?>
							<option value="<?php echo $shop['shop_id'];?>"><?php echo $shop['shop_name'];?></option>
					<?php }?>
                </select>
			</div>
	      </div>
	      <div class="modal-footer">
	      		
	      	<input id="merchant_submit" type="button" class="btn btn-primary" style="text-align: right" value="提交">
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
<script type="text/javascript">

	
 	$('#add_merchant').click(function(){
 		 var obj = $(this).parent();
 		 $("#merchant_submit").attr("disabled","disabled");
		 $("#merchant_modal").modal('show');
		 $.ajax({
 			type:'post',
 			url:$('#WEB_ROOT').val()+'MerchantList/getPlatformList',
 			dataType:'json',
 			success:function(data){
 				if(data.success == 'success'){
 					var str="";
 					for(var i in data.platform_list){
 						var item=data.platform_list[i];
 						str+="<option value='"+item['platform_id']+"'>"+item['platform_name']+"</option>";
 					}
 					$("#platform_id").html(str);
 					$("#merchant_submit").removeAttr("disabled");
 				}else{
 					alert("获取平台失败");
 				}
 			}
 		}).fail(function(data){
 			alert("获取平台请求失败");
 			console.log(data);
 		});
	 		
	});

 	//新增商户
 	$('#merchant_submit').click(function(){
 		var name = $('#edit_merchant_name').val().trim();
 		var p_id=$("#platform_id").val();
 		var type = $('#edit_merchant_type').val();
 		var area = $('#edit_area_id').val();

 		if(name ==""){
 			alert("用户名不能为空!");
 			return;
 		}

 		var cf = confirm("是否确认创建?");
 		if(!cf){
 			return;
 		}

 		$.ajax({
 			type:'post',
 			url:$('#WEB_ROOT').val()+'MerchantList/addMerchant',
 			data:{
 				'merchant_name':name,
 				'merchant_type':type,
 				'platform_id':p_id,
 				'area_id':area },
 			dataType:'json',
 			success:function(data){
 				if(data.success == 'true'){
 					window.location.reload();
 				}else{
 					alert("添加失败 "+data.success+" "+data.error_info);
 				}
 			}
 		}).fail(function(data){
 			console.log(data);
 		});

 	});

 	$('.status_change').click(function(){
 		var status_tmp = 0;
		var message = "激活成功";
		var obj = $(this).parent().parent();

		var status = $(this).attr("name");
		var id = $.trim(obj.children(".merchant_id").html());

		if(status==0)
		 	status_tmp = 1;
		else if(status==1){
		 	status_tmp = 0;
			message = "冻结成功";}
		else 
		 	alert("状态信息有误"); 

		$.ajax({
		    type: "post",
		    url: $('#WEB_ROOT').val() + 'MerchantList/updateMerchantStatus',

		    data: {	'merchant_id':id, 
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

	
</script>


</body>
</html>
