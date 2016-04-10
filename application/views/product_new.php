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
</head>
<body style="width: 100%;">
<input type="text" hidden="true" id="WEB_ROOT" value="<?php echo $WEB_ROOT?>"> 

<ul class="nav nav-tabs">
   <li class="active"><a href="#masterData" data-toggle="tab">主数据</a></li>
   <li id="specification_li" ><a href="#specification_div" data-toggle="tab">作业要求</a></li>
</ul>
<form id="product_form" name="product_form" method="post" action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>productNew/addNewProduct"
	enctype="multipart/form-data">
<div class="tab-content">
	<div class="tab-pane fade in active" id="masterData">
		<div class="row col-md-12" >
			
				<div class="col-md-6 bs-product-basic" >
					<div class="col-md-6" style="margin-top: 20px" >
						<h5><span class="required">* </span>产品ID：</h5>  <input type="text" class="form-control" readonly='readonly' id="product_id">
						<h5><span class="required">* </span>产品名称：</h5>  <input type="text" class="form-control" id="product_name" name="product_name">
						<h5>商品条码：</h5> <input type="text" class="form-control" readonly="readonly" id="barcode">
					</div>
					<div class="col-md-6" style="margin-top: 20px">
						<h5>产品类型：</h5> 
						<?php foreach ($product_type_list as $key=>$item) {?>
							<label class="radio" style="display: inline-block;"><input class="product_type" type="radio" name="product_type" id="product_type" value="<?php echo $item['product_type']?>" <?php if($key ==0) echo "checked=\"checked\""?>><?php echo $item['product_type_name']?></label>
						<?php }?>
						<div id="product_sub_type">
					    <h5>子类型：</h5>
					    <label class="radio" style="display: inline-block;"><input class="product_sub_type" type="radio" name="product_sub_type" id="product_sub_type" value="raw_material" checked="checked">原料</label>
						<!-- <label class="radio" style="display: inline-block;"><input class="product_sub_type" type="radio" name="product_sub_type" id="product_sub_type" value="semi_finished">半成品</label>-->
						<label class="radio" style="display: inline-block;"><input class="product_sub_type" type="radio" name="product_sub_type" id="product_sub_type" value="finished" <?php if (isset($goods_product_list))  echo "checked=\"checked\""; ?>>成品</label>
				    	</div>
				     </div>
				     <div class="col-md-12">
				     	<h5><span class="required">* </span>产品描述：</h5> <input type="text" class="form-control" id="product_desc" name="product_desc" placeholder="如：商品特征">
				        <h5><span class="required">* </span>备注：</h5><textarea rows="3" cols="30" id="note" name="note" class="form-control"></textarea>
				     </div>
				</div>
				
				<!-- 耗材模块 -->
				<div class="col-md-10 bs-product-supplies" style="margin-top: 60px" id="product_supplies_div">
					<div class="col-md-12" style="margin-top: 20px;display: inline-block;" >
						<div class="row">  
							<h5 style="display: inline-block;">采购周期： <input type="number"  class="form-control" id="purchasing_cycle_supplies_raw" name="purchasing_cycle_supplies_raw" style="width: 50%;display: inline-block;" min="1">天</h5> 
						</div>
						<div class="row">
							<h5 style="display: inline-block; width: 20%"><span class="required">* </span>单位：  
								<select id="container_unit_code" name="container_unit_code" class="form-control" style="display: inline-block;width: 50%;">
									<option value=""></option>
									<?php if(!empty($unit_list) && !empty($unit_list['supplies']) && !empty($unit_list['supplies']['case'])){
		                                $str = '';
		                                foreach ($unit_list['supplies']['case'] as $key => $val) {
		                                    $str .= "<option value='".$val['unit_code']."'>".$val['unit_code_name']."</option>";
		                                }
		                                echo $str;
		                            } ?>
								</select>
								<input type="hidden" id="container_unit_code_name" name="container_unit_code_name">
							</h5>
							<h5 style="display: inline-block; width: 20%"><span class="required">* </span>规格：<input type="number" class="form-control" id="supplies_container_quantity" name="supplies_container_quantity" style="display: inline-block;width: 50%"></h5>
								<select id="supplies_unit_code" name="supplies_unit_code" class="form-control" style="display: inline-block;width: 10%;">
									<option value=""></option>
									<?php if(!empty($unit_list) && !empty($unit_list['supplies']) && !empty($unit_list['supplies']['general'])){
		                                $str = '';
		                                foreach ($unit_list['supplies']['general'] as $key => $val) {
		                                    $str .= "<option value='".$val['unit_code']."'>".$val['unit_code_name']."</option>";
		                                }
		                                echo $str;
		                            } ?>
								</select>
								<input type="hidden" id="supplies_unit_code_name" name="supplies_unit_code_name">
						</div>
						<div class="row">
							<h5 style="display: inline-block;"><span class="required">* </span>长：<input type="number" class="form-control" id="length" name="length" style="width: 100px;display: inline-block;">cm</h5>
							<h5 style="display: inline-block; margin-left: 5%"><span class="required">* </span>宽：<input type="number" class="form-control" id="width" name="width" style="width: 100px;display: inline-block;">cm</h5>
							<h5 style="display: inline-block; margin-left: 5%"><span class="required">* </span>高：<input type="number" class="form-control" id="height" name="height" style="width: 100px;display: inline-block;">cm</h5>
						</div>
					</div>
				</div>
				
				<!-- 包装方案模块 -->
				<div class="col-md-10 bs-supplies-finished" style="margin-top: 60px" id="product_supplies_finished_div">
					<div class="col-md-12" style="margin-top: 20px;display: inline-block;" >
						<p class="notice">请上传不超过五张，jpg,bmp,gif,png格式，大小在20k之下的的图片</p>
						<div class="row">
							<div class="col-md-5 imgDiv" style="margin-top: 20px;">
								<div id="imgDiv1">
									<input type="file" id="img1" name="img1" class="img" size="0" style="display: none; " />
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
							<div class="col-md-5 imgDiv" style="margin-top: 20px;">
								<div id="imgDiv2">
									<input type="file" id="img2" name="img2" class="img" size="0" style="display: none;" />
								</div>
								<div id="cover2" class="cover" style="position: absolute; background-color: White; z-index: 10;
								filter: alpha(opacity=100); -moz-opacity: 1; opacity: 1; ">
									<input id="selectImg2" type="button" value="选择图片" class="selectImg btn btn-primary" />
								</div>
								<div class="imgShow" id="imgShow2" style="width: 400px; margin-top: 60px;">
									<div class="productImg" id="productImg2"  hidden="true" >
										<div style="border: 1px solid #eeeeee; padding: 3px; max-height: 390px; max-width: 390px; overflow: hidden; text-align: center;">
											<img class="imgHolder" id="imgHolder2" style="max-height: 390px; max-width: 390px;" />
										</div>
										<input id="delImg2" type="button" style="width: 65px; height: 30px" value="删除" class="delImg btn btn-danger"> 
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-5 imgDiv"  style="margin-top: 20px;">
								<div id="imgDiv3">
									<input type="file" id="img3" name="img3" class="img" size="0" style="display: none;" />
								</div>
								<div id="cover3" class="cover" style="position: absolute; background-color: White; z-index: 10;
								filter: alpha(opacity=100); -moz-opacity: 1; opacity: 1; ">
									<input id="selectImg3" type="button" value="选择图片" class="selectImg btn btn-primary" />
								</div>
								<div class="imgShow" id="imgShow3" style="width: 400px; margin-top: 60px;">
									<div class="productImg" id="productImg3"  hidden="true" >
										<div style="border: 1px solid #eeeeee; padding: 3px; max-height: 390px; max-width: 390px; overflow: hidden; text-align: center;">
											<img class="imgHolder" id="imgHolder3" style="max-height: 390px; max-width: 390px;" />
										</div>
										<input id="delImg3" type="button" style="width: 65px; height: 30px" value="删除" class="delImg btn btn-danger"> 
									</div>
								</div>
							</div>
							<div class="col-md-5 imgDiv" style="margin-top: 20px;">
								<div id="imgDiv4">
									<input type="file" id="img4" name="img4" class="img" size="0" style="display: none;" />
								</div>
								<div id="cover4" class="cover" style="position: absolute; background-color: White; z-index: 10;
								filter: alpha(opacity=100); -moz-opacity: 1; opacity: 1; ">
									<input id="selectImg4" type="button" value="选择图片" class="selectImg btn btn-primary" />
								</div>
								<div class="imgShow" id="imgShow4" style="width: 400px; margin-top: 60px;">
									<div class="productImg" id="productImg4"  hidden="true" >
										<div style="border: 1px solid #eeeeee; padding: 3px; max-height: 390px; max-width: 390px; overflow: hidden; text-align: center;">
											<img class="imgHolder" id="imgHolder4" style="max-height: 390px; max-width: 390px;" />
										</div>
										<input id="delImg4" type="button" style="width: 65px; height: 30px" value="删除" class="delImg btn btn-danger"> 
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-5 imgDiv" style="margin-top: 20px;">
								<div id="imgDiv5">
									<input type="file" id="img5" name="img5" class="img" size="0" style="display: none;" />
								</div>
								<div id="cover5" class="cover" style="position: absolute; background-color: White; z-index: 10;
								filter: alpha(opacity=100); -moz-opacity: 1; opacity: 1; ">
									<input id="selectImg5" type="button" value="选择图片" class="selectImg btn btn-primary" />
								</div>
								<div class="imgShow" id="imgShow5" style="width: 400px; margin-top: 60px;">
									<div class="productImg" id="productImg5"  hidden="true" >
										<div style="border: 1px solid #eeeeee; padding: 3px; max-height: 390px; max-width: 390px; overflow: hidden; text-align: center;">
											<img class="imgHolder" id="imgHolder5" style="max-height: 390px; max-width: 390px;" />
										</div>
										<input id="delImg5" type="button" style="width: 65px; height: 30px" value="删除" class="delImg btn btn-danger"> 
									</div>
								</div>
							</div>
						</div>  
					<div class="row" style="margin-top: 30px">
						<div class="col-md-5">
							<input id="add_supplies_btn" type="button" class="btn btn-info btn-sm" value="添加">
					     	<table border=3 style="width:100%" id="supplies_raw_material_list">
						     	<tr>
						     		<th id="product_id_title">耗材ID</th>
						     		<th id="product_name_title">耗材</th>
						     		<th id="quantity_title">数量</th>
						     		<th id="supplies_product_unit_title">单位</th>
						     		<th id="operator_title" style="width: 40px">操作</th>
						     	</tr>
					     	</table>
				     	</div>
			     	</div>
					</div>
				</div>
				
				<!-- 原料模块 -->
				<div class="col-md-10 bs-product-raw_material" style="margin-top: 60px" id="product_raw_material_div">
					<div class="col-md-6" style="margin-top: 20px" id="product_raw_material_div2">
						<label style="display:inline-block; margin-top: 20px; text-align: left;"><span class="required">* </span>产地：<input type="text" class="form-control" id="producing_region" name="producing_region" style="display: inline;width: 60%;"></label>
						<label style="display:inline-block; margin-top: 20px; text-align: left;">采购周期：<input type="number" class="form-control" id="purchasing_cycle_goods_raw" name="purchasing_cycle_goods_raw" style="display: inline;width: 60%;">天</label>
						<h5><span class="required">* </span>存储单位：  
							<select id="unit_code" name="unit_code" class="form-control" style="width: 20%;display: inline-block;" >
								<option value=""></option>
	                            <?php if(!empty($unit_list) && !empty($unit_list['goods']) && !empty($unit_list['goods']['general'])){
	                                $str = '';
	                                foreach ($unit_list['goods']['general'] as $key => $val) {
	                                    $str .= "<option value='".$val['unit_code']."'>".$val['unit_code_name']."</option>";
	                                }
	                                echo $str;
	                            } ?>
							</select>
							<input type="hidden" id="unit_code_name" name="unit_code_name">
						</h5>
						<h5><span class="required">* </span>采购单位：  
							<select id="purchase_unit_code" name="purchase_unit_code" class="form-control" style="width: 20%;display: inline-block;" >
								<option value=""></option>
								<?php if(!empty($unit_list) && !empty($unit_list['goods']) && !empty($unit_list['goods']['general'])){
	                                $str = '';
	                                foreach ($unit_list['goods']['general'] as $key => $val) {
	                                    $str .= "<option value='".$val['unit_code']."'>".$val['unit_code_name']."</option>";
	                                }
	                                echo $str;
	                            } ?>
							</select>
						</h5>
						<h5><span class="required">* </span>销售单位：  
							<select id="sale_unit_code" name="sale_unit_code" class="form-control" style="width: 20%;display: inline-block;" >
								<option value=""></option>
								<?php if(!empty($unit_list) && !empty($unit_list['goods']) && !empty($unit_list['goods']['general'])){
	                                $str = '';
	                                foreach ($unit_list['goods']['general'] as $key => $val) {
	                                    $str .= "<option value='".$val['unit_code']."'>".$val['unit_code_name']."</option>";
	                                }
	                                echo $str;
	                            } ?>
							</select>
						</h5>
	                    <label class="valid_days"><span class="required">* </span>保质期：<input type="number" class="valid_days_input" name="valid_days" value="">天</label>
	                    <div id='weight_div'>
							<h5 style="display: inline-block;">
								<span class="required">*</span>净重：
								<input min="0" type="number" id="net_weight_min" name="net_weight_min" class="form-control" style="display: inline-block; width: 20%;"> --
								<input min="0" type="number" id="net_weight_max" name="net_weight_max" class="form-control" style="display: inline-block; width: 20%;">kg
							</h5>
						</div>
					</div>
				</div>

				<!-- 半成品模块 -->
				<div class="col-md-10 bs-product-semi-finish"  style="margin-top: 60px" id="product_semi_finish_div">
					<div class="col-md-6" style="margin-top: 20px">
						<h5>parent_ID：<input type="text"  class="form-control" readonly='readonly' id="parent_product_id"></h5>  
						<h5>原料：</h5> <input type="text"  class="form-control" id="parent_product_name">
					</div>
				</div>
				
				<!-- 成品模块 -->
				<div class="col-md-10 bs-product-finish" style="margin-top: 60px" id="product_finish_div">
					<div class="col-md-10 " style="margin-top: 20px" id="product_finish_div2">
						<h5><span class="required">* </span>快递服务：<select id="shipping_service_id" name="shipping_service_id" class="form-control" style="width: 30%; display: inline-block;">
									<option value=""></option>
									<?php if(isset($shipping_service_list) && count($shipping_service_list)>0) foreach($shipping_service_list as $item){?>
				                   	<option value=<?php echo '"'.$item['service_id'].'"';?>><?php echo $item['service_name'];?></option>
		                           <?php }?></select>
		                </h5>       
						<h5><span class="required">* </span>暗语： <input type="text" class="form-control" id="secrect_code" name="secrect_code" style="width: 80%; display: inline-block;"></h5>  
						<h5>平台： <select id="platform_id" name="platform_id" class="form-control" style="width: 40%; display: inline-block;" >
									<?php if(isset($platform_list) && count($platform_list)>0) foreach($platform_list as $item){ ?>
				                   	<option value=<?php echo '"'.$item['platform_id'].'"'; ?>><?php echo $item['platform_name'];?></option>
										<?php } ?>
										</select></h5>
						<h5>商户： <select id="merchant_id" name="merchant_id" class="form-control" style="width: 40%; display: inline-block;" ></select> </h5>
						<div class="form-group">
						     <div class="checkbox">
						        <label style="line-height: 20px;">
						        	<input type="checkbox" id="pre_selection" name="pre_selection"> 是否需预拣选
						        </label>
						     </div>
						</div>
						<div class='row' style="text-align: left;margin-left:35px">
							<input id="add_merchant_goods_ids_btn" type="button" class="btn btn-info btn-sm"  value="添加成品-oms商品映射关系">
							<table id="merchant_goods_table" name="mapping_product_table" border=3 style="width:480px">
								<tr>
									<th width="100px" id="merchant_goods_id_title">GOODS_ID</th>
									<th id="merchant_goods_name_title">商品名称</th>
									<th id="merchant_goods_operator_title" style="width: 40px">操作</th>
								</tr>
								<?php if(!empty($goods_product_list)){ ?>
								<tr class="content">
									<td><input name="merchant_goods_ids[]" value="<?php echo (!empty($goods_product_list['goods_id'])) ? $goods_product_list['goods_id'] : ''; ?>" ></td>
									<td class="merchant_goods_name"><?php echo (!empty($goods_product_list['goods_name'])) ? $goods_product_list['goods_name'] : ''; ?></td>
									<td class="merchant_goods_operator"><input type="button" class="btn btn-danger" value="删" style="height: 24px;"></td>
								</tr>
								<?php } ?>
							</table>
						</div>
						<div class="row" style="text-align: left;margin-left: 35px; margin-top: 35px" id="mapping_products_div">
							<input id="add_mapping_products_btn" type="button" class="btn btn-info btn-sm" value="添加成品-原料映射关系">
			      			<table id="mapping_product_table" name="mapping_product_table" border="3" style="width:480px">
								<tr>
									<th id="mapping_product_id_title">PRODUCT_ID</th>
									<th id="mapping_product_name_title">产品名称</th>
									<th id="mapping_product_quantity_title">数量</th>
									<th id="mapping_product_unit_title">单位</th>
									<th id="mapping_product_operator_title">操作</th>
								</tr>
							</table>
						</div>
					</div>
				</div>
		</div>
	</div>
	<div class="tab-pane fade" id="specification_div">
		<div class="col-md-10 bs-product-specification" id="product_specification_div">
			<div class="col-md-10" style="margin-top: 20px">
				<h5 style="margin-top: 20px">收货标准：<textarea id='receiving_standard' name="receiving_standard" class="form-control" rows="3" cols="30"></textarea></h5>
				<h5 style="margin-top: 5px">收货异常处理：<textarea id='receiving_exception_handling' name ="receiving_exception_handling" class="form-control" rows="3" cols="30"></textarea></h5>
				<h5 style="margin-top: 30px;display: inline;">存储温度：<input type="text" id='storage_temperature' name="storage_temperature" class="form-control" style="width: 50%; display: inline-block;"></h5>
				<h5 style="display: inline-block;margin-left: 20px;">存储天数：<input type="number" id='storage_days' name="storage_days" class="form-control" min="1" style="display: inline-block;width: 40%;"></h5>
				<h5 style="margin-top: 5px">存储注意事项：<textarea id='storage_notes' name="storage_notes" class="form-control" rows="3" cols="30"></textarea></h5>
				<h5 style="margin-top: 30px">拣选次果标准：<textarea id='defective_standard' name="defective_standard" class="form-control" rows="3" cols="30"></textarea></h5>
				<h5 style="margin-top: 5px">拣选坏果标准：<textarea id='bad_standard' name="bad_standard" class="form-control" rows="3" cols="30"></textarea></h5>
				<h5 style="margin-top: 5px">次品处理方法：<textarea id='defective_handing' name="defective_handing" class="form-control" rows="3" cols="30"></textarea></h5>
				<h5 style="margin-top: 30px">操作要求：<textarea id='specification' name="specification" class="form-control" rows="3" cols="30"></textarea></h5>
			</div>
		</div>
    </div>
</div>
<input type="hidden" id="purchasing_cycle" name="purchasing_cycle">
</form>
<div class="row col-md-10"  style="text-align: center;"> 
	<?php if( $this->helper->chechActionList(array('productEdit')) ){ ?>
		<input type="button" class="btn btn-primary" value="提交" id="sub">
	<?php } ?>
</div>
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="http://cdn.bootcss.com/jquery.form/3.51/jquery.form.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/product_new.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/common.js"></script>
<script>
    var WEB_ROOT = "<?php  echo isset($WEB_ROOT) ? $WEB_ROOT : ''; ?>",
        g_product_id = "<?php echo isset($product_id) ? $product_id : ''; ?>";
</script>
</body>
</html>