<!doctype html>
<html>
<head>
	<title>拼好货WMS</title>
	<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/order.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/autocomplete.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<style type="text/css">
	#panel-41555 table td em{display:inline-block;min-width: 13%;font-style:normal;text-align:left;}
	.city_type{
		cursor:pointer;
		padding: 6px 8px 6px 8px;

	}
	.province_type{
		cursor:pointer;
		padding: 6px 10px 6px 10px;
	}
	.district_type{
		cursor:pointer;
		padding: 5px 5px 5px 5px;
	}
	</style>
</head>
<body>

<input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> >

<div class="container-fluid" id="LG">
	<div class="row-fluid">
		<div class="span12">
			<div class="tabbable" id="tabs-669685">
				<ul class="nav nav-tabs">
					<li class="active  ">
						<a href="#panel-316747" data-toggle="tab">主数据</a>
					</li>
					<li >
						<a href="#panel-41488" data-toggle="tab">商户门店</a>
					</li>
					<li >
						<a href="#panel-41555" data-toggle="tab">服务区域</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="panel-316747">
						<div class="container" id="LG" style="margin-top:30px;margin-left:-2%">
							<form class="form-horizontal" id="merchant_form" role="form" method="post" action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>merchantList/editMerchant">
								<?php if( isset($merchant_list) && is_array($merchant_list))  foreach ($merchant_list as $key => $merchant) { ?>
								<div class="form-group">
									<label class="col-sm-2" style="text-align: right;" readonly="readonly">商户编号：</label>
									<div class="col-sm-3">
										<input class="form-control" type="text" id="merchant_id" readonly="readonly" value="<?php echo $merchant['merchant_id']; ?>" name="merchant_id">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2" style="text-align: right;">商户名称：</label>
									<div class="col-sm-3">
										<input class="form-control" type="text" id="edit_merchant_name" name="merchant_name" value= "<?php echo $merchant['merchant_name'] ?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2" style="text-align: right;">商户类型：</label>
									<div class="col-sm-3 ">
										<select class="form-control" id="edit_merchant_type" name="merchant_type" >
											<option  value="thirdparty">第三方</option>
											<option  value="self">自营</option>
                						</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2" style="text-align: right;">所属平台：</label>
									<div class="col-sm-3 ">
										<select class="form-control" id="edit_platform_id" name="platform_id" >
										<?php foreach ($platform_list as $key => $platform){ ?>
										   <option  value="<?php echo $platform['platform_id']; ?>" <?php if($platform['platform_id']==$merchant['platform_id'])echo "selected='selected'"; ?>><?php echo $platform['platform_name']; ?></option>
										<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2" style="text-align: right;">所属区域：</label>
									<div class="col-sm-3 area_select_item">
										<select class="form-control" name="area_id" id="edit_area_id"  >
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
								</div>
							<?php } ?>
							</form>
							<?php if( $this->helper->chechActionList(array('merchantEdit')) ){ ?>
							<div><button type="button" class="btn btn-primary" id="submitBtn" style="margin-left:35%;margin-top:10px;">提交</button></div>
							<?php }?>
							<div hidden>
								<select class="form-control" id="shop_select_item">
									<?php if(isset($shop_select) && is_array($shop_select)) foreach ($shop_select as $key => $item) { ?>
										<option value="<?php echo $item['shop_id'];?>"><?php echo $item['shop_name'];?></option>
									<?php } ?>
                				</select>
							</div>
						</div>						
					</div>

					<div class="tab-pane" id="panel-41488">

						<?php if( $this->helper->chechActionList(array('merchantEdit')) ){ ?>
						<button type="button" class="btn btn-primary btn-sm" id="editShopBtn" style="margin-left:5%;margin-top:10px;">编辑</button>
						<?php }?>
						<table class="table table-striped table-bordered"  style="width:30%;margin-left:5%;margin-top:10px;text-align:center">
			            <thead>
			                <tr>
								<th style="text-align:center" width="30%">商户名称</th>
								<th style="text-align:center" width="50%">门店名称</th>
			                </tr>
			            </thead>
			            <tbody class="view_table_row">
			            <?php if( isset($shop_list) && is_array($shop_list))  foreach ($shop_list as $key => $shop) { ?>
								<tr id="<?php echo $shop['shop_id']; ?>">
									<td class="shop_merchant_name"><?php echo $shop['merchant_name']; ?></td>
									<td class="shop_name" ><?php echo $shop['shop_name']; ?></td>
									</td>			
								</tr>
						<?php }?>
			            	
			            </tbody>
			        </table>

					</div>
					<div class="tab-pane" id="panel-41555">
						<?php 
						 if($this->helper->chechActionList(array('merchantEdit'))){ ?>
						 	<label style="margin-left:10px;margin-top:15px">设置商户服务区域:</label>
							 <input type="button" id="setMerchantDistrictBtn" value="设置" class="btn btn-primary btn-sm"  data-toggle="modal"
									data-target="#merchant_district_modal">
				   <?php }else{  ?>
						 	<label style="margin-left:10px;margin-top:15px">商户服务区域:</label>
				   <?php }  ?>

						<br/><p id="loading_table">数据加载中,请稍等...</p>
						<table id="merchant_district_table" name="merchant_district_table" style="width: 900px" border=3 class="table">

						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<div>
	<div class="shopEdit modal fade ui-draggable text-center" id="shopEdit" role="dialog">
	  	<div class="modal-dialog" style="display: inline-block; width: 500px">
	    	<div class="modal-content">
	      		<div class="modal-header">
	        		<button type="button" class="close" id="btnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	       			<h4 class="modal-title">商户门店编辑</h4>
	     		</div>
	      		<div class="modal-body" style="text-align: left;">
	      		<?php if( $this->helper->chechActionList(array('merchantEdit')) ){ ?>
					<button type="button" class="btn btn-primary btn-sm" id="addShopBtn" style="float:left;margin-bottom:5px">新增</button>
				<?php }?>
	      			<table class="table table-striped table-bordered " style="width:100%;text-align:center">
                    	<thead>
							<tr>
								<th style="text-align:center">商户</th>
								<th style="text-align:center">门店</th>
								<th style="text-align:center">操作</th>
							</tr>
						</thead>
                    	<tbody id = "shop_table_body">

                    	</tbody> 
              		</table>
	      		</div>
	      		<div class="modal-footer">
	      			<input data-dismiss="modal" type="button" class="btn btn-primary" style="text-align: right" value="确认">
	      		</div>
	    	</div>
	  	</div>
	</div>
</div>

<!-- 设置商品服务区域Modal -->
<div>
	<div class="modal fade ui-draggable" id="merchant_district_modal" role="dialog"  >
		<div class="modal-dialog" style="width: 900px">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" id="btnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="merchant_district_title" name="merchant_district_title">设置商户服务区域</h4>
				</div>
				<div class="modal-body ">
					<p id="loading_hits">数据加载中,请稍等...</p>
					<table id="district_table" name="merchant_district_setting_table" style="width: 100%" border=3 class="table">

					</table>
				</div>
				<div class="modal-footer" >
					<input id="merchant_district_sub" type="button" class="btn btn-primary" style="text-align: right; " value="保存"  >
				</div>
			</div>
		</div>
	</div>
</div>

    <script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
	<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<script src="http://cdn.bootcss.com/jquery.form/3.51/jquery.form.js"></script>
<script src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/common.js"></script>
<script type="text/javascript">

	current_dist=null;
	all_district=null;
	var mname = "<?php echo $merchant['merchant_name'] ?>";
	var nid = "<?php echo $merchant['merchant_id'] ?>";
	var shop_list=<?php echo json_encode($shop_list); ?>;

	//var merchant_id = $('#merchant_id').val();

	$(document).ready(function() {

		$('#edit_merchant_type option[value="<?php echo $merchant['merchant_type'] ?>"]').attr("selected", "selected");
		$('#edit_area_id option[value="<?php echo $merchant['area_id'] ?>"]').attr("selected", "selected");

		getDistrictForView();

		$("#editShopBtn").click(function(){
			var str="";
			var content = $('#shop_table_body').html().trim();
			if(content == ""){
				for(var num in shop_list){

		 			var mname = shop_list[num]['merchant_name'];
		 			var mshop = shop_list[num]['shop_name'];
		 			var mid = shop_list[num]['shop_id'];
		 			str +="<tr><td>"+mname+"</td><td>"+mshop+"</td><td hidden name='data_shop'>"+mid+"</td><td><a href='javascript:' class='shop_del_btn btn btn-sm btn-danger'>删除</a></td></tr>";
	 			}
			}else{
	 				str = $("#shop_table_body").html();
	 		}

	 		$("#shop_table_body").html(str);
			$(".shopEdit").modal('show');
		});
		//.shopEdit隐藏所执行事件
		$('.shopEdit').on('hidden.bs.modal', function () {
			$("#shop_table_body>tr").filter(function(){
				if($(this).find(".shop_add_btn").length>0) return true;
			}).remove();
		});
			
		$('#addShopBtn').click(function(){
			var str="";
			var str_area=$("#shop_select_item").html();
			str +="<tr><td >"+mname+"</td><td><select name='mshop' class='edit_area' style='height:25px;border:0'>"+str_area+"</select></td><td><button  class='shop_add_btn btn btn-sm btn-primary'>添加</button></td></tr>";

			$("#shop_table_body").append(str);
		});

		$('#submitBtn').click(function(){

			var name = $('#edit_merchant_name').val().trim();
			if (name == ''){
				alert("商户名不能为空！");
				return;
			}

			var cf = confirm("是否确认修改?");
 				if(!cf){
 					return;
 				}

			var act = $('#merchant_form').attr("action");
			//alert(act);

			options = {
				dataType:'json',
				success:function(data){
					if(data.success == 'true'){
						alert('修改成功');
						var str="";
						for(var i in data.shop_select){
							var item=data.shop_select[i];
							str+="<option value='"+item['shop_id']+"'>"+item['shop_name']+"</option>";
						}
						$("#shop_select_item").html(str);
						//history.back(-1);
					}else{
						alert('修改失败');
					}
				},
				fail:function(data){
					console.log(data);
				}
			};
			$('#merchant_form').ajaxSubmit(options);
			return;
		});

		$('#shop_table_body').click(function(e){
			//删除
			if(e.target.tagName.toLowerCase()=="a"){

				var cf = confirm("是否确认删除?");
 				if(!cf){
 					return;
 				}

				var item = $(e.target.parentNode.parentNode);
				var shopid = item.find("[name = 'data_shop']").html();
				var remove_shop = {
					'merchant_id': nid,
					'shop_id':shopid
				}

				$.ajax({
					url:$('#WEB_ROOT').val() + 'merchantList/removeMerchantShopMapping',
					type:'post',
					data: remove_shop,
					dataType:'json',
					xhrFields:{
						withCredentials:true
					}
				}).done(function(data){
					if(data.success == 'true'){
						$("#"+shopid).remove();
						item.remove();
					}else{
						alert("删除失败!");
					}
				});

			}
			//添加
			if(e.target.tagName.toLowerCase()=="button"){

				var cf = confirm("是否确认添加?");
 				if(!cf){
 					return;
 				}

				var item = $(e.target.parentNode.parentNode);
				var shop = item.find("[name = 'mshop']").val();
				var shop_name = item.find("[name = 'mshop']").find("option:selected").text();
				var add_shop ={
					'merchant_id':nid,
					'shop_id':shop
				}
				$.ajax({
					url:$('#WEB_ROOT').val()+'merchantList/addMerchantShopMapping',
					type:'post',
					data:add_shop,
					dataType:'json',
					xhrFields:{
						withCredentials:true
					}
				}).done(function(data){
					if(data.success == 'true'){
						item.remove();
						var viewStr = "<tr id="+shop+"><td class='shop_merchant_name'>"+mname+"</td><td class='shop_name'>"+shop_name+"</td><tr>";
						var tmpStr = "<tr><td>"+mname+"</td><td name='mshop'>"+shop_name+"</td><td hidden name='data_shop'>"+shop+"</td><td><a href='javascript:' class='shop_del_btn btn btn-sm btn-danger'>删除</a></td></tr>";

						$("#shop_table_body").append(tmpStr);
						$(".view_table_row").append(viewStr);
					}else{
						alert("添加失败！");
					}
				});
			}
		});


		$('#setMerchantDistrictBtn').click(function(){

			var merchant_id = $('#merchant_id').val();
			$('#district_table').empty();
			getBaseMerchantDistrict(merchant_id);
		});

		//绘制当前服务区域的表格
		function getDistrictForView(){
			var merchant_id = $('#merchant_id').val();
			$('.wait_loading').attr('disabled','disabled');
			$.ajax({
				url:$('#WEB_ROOT').val()+"merchantList/getMerchantDistrictList",
				type:"get",
				data:{"merchant_id":merchant_id},
				dataType:'json',
			}).done(function(data){
				if(data.success == "true"){
					$("#loading_table").hide();
					var district_list = data.district_list;
					drawDistrictForView(district_list);
				}else{
					$("#loading_table").text("服务区域数据获取失败");
				}
			}).fail(function(data){
				alert("内部服务器错误");
			});
		}

		function drawDistrictForView(district_list){
			$("#merchant_district_table").empty();
			var thead = "<tr><td style='width:10%'>省</td><td style='width:10%'>市</td><td style='width:80%'>区</td></tr>"
			var tbody = "";
			$("#merchant_district_table").append(thead);
			for(var pid in district_list){
				province_id = district_list[pid]["province_id"];
				province_name = district_list[pid]["province_name"];
				city_list = district_list[pid]["city_list"];
				var city_num = Object.keys(district_list[pid]['city_list']).length;
				var flag = 1;
				for(var cid in city_list){
					city_id = district_list[pid]["city_list"][cid]["city_id"];
					city_name = district_list[pid]["city_list"][cid]["city_name"];
					districts = district_list[pid]["city_list"][cid]["district_list"];
					var district_str = "";
					for(var did in districts){
						district_id = district_list[pid]["city_list"][cid]["district_list"][did]["district_id"];
						district_name = district_list[pid]["city_list"][cid]["district_list"][did]["district_name"];
						district_str += " <span>"+district_name+"</span> ";
					}
					if(flag == 1){
						tbody = "<tr><td rowspan="+city_num+"><span>"+province_name+"</span></td><td><span>"+city_name
								+"</span></td><td>"+district_str+"</td></tr>";
						flag =0;
						continue;
					}
					tbody += "<tr><td><span>"+city_name +"</sapn></td><td>"+district_str+"</td></tr>";
				}
				$("#merchant_district_table").append(tbody);
			}
		}

		//用于区域选择表格的绘制
		function drawMerchantDistrict(district_list){
			$("#district_table").empty();
			var thead = "<tr><td style='width:10%'>省</td><td style='width:10%'>市</td><td style='width:80%'>区</td></tr>"
			var tbody = "";
			$("#district_table").append(thead);
			for(var pid in district_list){
				province_id = district_list[pid]["province_id"];
				province_name = district_list[pid]["province_name"];
				city_list = district_list[pid]["city_list"];
				var city_num = Object.keys(district_list[pid]['city_list']).length;

				var flag = 1;
				for(var cid in city_list){
					city_id = district_list[pid]["city_list"][cid]["city_id"];
					city_name = district_list[pid]["city_list"][cid]["city_name"];
					districts = district_list[pid]["city_list"][cid]["district_list"];
					var district_str = "";
					for(var did in districts){
						district_id = district_list[pid]["city_list"][cid]["district_list"][did]["district_id"];
						district_name = district_list[pid]["city_list"][cid]["district_list"][did]["district_name"];
						district_str += " <span class='district_type' data-did="+district_id+" id=d"+district_id+">"+district_name+"</span> ";
					}
					if(flag == 1){
						tbody = "<tr><td rowspan="+city_num+"><span class='province_type' id=d"+province_id+">"+province_name
								+"</span></td><td name='d"+province_id+"'><span class='city_type'  id=d"+city_id+">"+city_name
								+"</span></td><td class='district_list' name='d"+province_id+"'>"+district_str+"</td></tr>";
						flag =0;
						continue;
					}
					tbody += "<tr><td name='d"+province_id+"'><span class='city_type'  id=d"+city_id
							+">"+city_name +"</sapn></td><td class='district_list' name='d"+province_id+"'>"+district_str+"</td></tr>";
				}
				$("#district_table").append(tbody);
			}

		}

		//获取服务区域选项
		function getBaseMerchantDistrict(merchant_id){
			$.ajax({
				url:$('#WEB_ROOT').val()+"MerchantList/getCheckedMerchantDistrict",
				type:"get",
				data:{"merchant_id":merchant_id},
				dataType:"json",
				xhrFields:{
					withCredentials:true
				}
			}).done(function(data){

				if(data.success == "true"){
					var district_list = data.district_list;
					$("#loading_hits").hide();
					drawMerchantDistrict(district_list);
					getCurrentMerchantDistrict(merchant_id);
				}else{
					$("#loading_hits").text("获取数据失败!");
				}
			}).fail(function(data){
				alert('内部服务器错误');
			});
		}

		//获取当前商品服务区域
		function getCurrentMerchantDistrict(merchant_id){
			$.ajax({
				url:$('#WEB_ROOT').val()+"MerchantList/getCurrentMerchantDistrict",
				type:"post",
				data:{"merchant_id":merchant_id},
				dataType:"json",
				xhrFields:{
					withCredentials:true
				}
			}).done(function(data){
				if(data.success == "true"){
					district_array = [];
					for(var district_id in data.district_list){
						district_array.push(district_id);
						$("#d"+district_id).addClass("btn-primary");
					}
					console.log(district_array);
				}else{
					alert("当前服务区域数据获取失败！");
				}
			}).fail(function(data){
				alert('内部服务器错误');
			});
		}

		var prompter = $.prompter('正在提交，请稍后。。。');
		//用于商品服务区域的提交
		$('#merchant_district_sub').click(function(){
			var merchant_id = $('#merchant_id').val();
			$('#merchant_district_sub').attr('disabled','disabled');

			var sync_to_merchant_district = $('#sync_to_merchant_district').val();
			var cross_regional = $('#cross_regional').val();
			var merchant_id = $('#merchant_id').val();
			var district_array = [];

			var district_item = $('#district_table').find("[class='district_type btn-primary']");
			$(district_item).each(function(){
				district_array.push($(this).attr("data-did"));
			});
			prompter.show();
			$.ajax({
				url:$('#WEB_ROOT').val()+"MerchantList/updateMerchantDistrict",
				type:"post",
				data:{"merchant_id":merchant_id,
					"districts":district_array },
				dataType:"json",
				xhrFields:{
					withCredentials:true
				}
			}).done(function(data){
				if(data.success == "true"){
					alert("提交成功");
					prompter.hide();
					$('#merchant_district_sub').removeAttr('disabled');
					getDistrictForView();
					$('#merchant_district_modal').modal("hide");
				}else{
					alert("提交失败");
					$('#merchant_district_sub').removeAttr('disabled');
					prompter.hide();
				}
			}).fail(function(data){
				$('#merchant_district_sub').removeAttr('disabled');
				alert('内部服务器错误');
				prompter.hide();
			});
		});

		function changeDistrictStatus(target){
			if($(target).hasClass('btn-primary')){
				$(target).removeClass("btn-primary");
			}else{
				$(target).addClass("btn-primary");
			}
		}
		function changeCityStatus(target){
			var district_target = $(target.parentNode.parentNode).find("[class='district_list']");
			if($(target).hasClass('btn-primary')){
				$(target).removeClass("btn-primary");
				district_target.find("span").removeClass("btn-primary");
			}else{
				$(target).addClass("btn-primary");
				district_target.find("span").addClass("btn-primary");
			}
		}
		function changeProvinceStatus(target){
			var proid = $(target).attr("id");
			var district_target = $(target.parentNode.parentNode.parentNode).find("[name='"+proid+"']");
			if($(target).hasClass('btn-primary')){
				$(target).removeClass("btn-primary");
				district_target.find("span").removeClass("btn-primary");
			}else{
				$(target).addClass("btn-primary");
				district_target.find("span").addClass("btn-primary");
			}
		}

		$('#district_table').click(function(e){
			if($(e.target).hasClass('district_type')){
				changeDistrictStatus(e.target);

			}else if($(e.target).hasClass('city_type')){
				changeCityStatus(e.target);
			}else if($(e.target).hasClass('province_type')){
				changeProvinceStatus(e.target);
			}
		});
	});

</script>
</body>
</html>