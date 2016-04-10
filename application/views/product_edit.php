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
<style type="text/css">
table .btn-danger { padding-top: 0; padding-bottom: 0; }
.valid_days { line-height: 24px; }
p input.form-control { display: inline-block; width: 100px; }
input.shippings{ width: 30px;}
#district_info_table input[type=checkbox] {width: 30px;}
#sdfm_district_info_table input[type=checkbox] {width: 30px;}
label { text-align: left;}
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
<body style="width: 100%; height: 200%" >
<div id="loadding" hidden="true"><img src="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/img/loadding.gif"></div>
<input type="text" hidden="true" id="WEB_ROOT" value="<?php echo $WEB_ROOT?>"> 
<ul class="nav nav-tabs">
    <li class="active"><a href="#masterData" data-toggle="tab">主数据</a></li>
    <li id="specification_li" ><a href="#specification_div" data-toggle="tab">作业要求</a></li>
	<li id="product_district_li" style=""><a href="#product_district_div" data-toggle="tab">服务区域</a></li>
    <li id="best_shipping_li" style="display:none;"><a href="#best_shipping_div" data-toggle="tab">设置快递</a></li>

</ul>
<form id="product_form" name="product_form" method="post" action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>productEdit/editProduct"
	enctype="multipart/form-data">
	<input type="hidden" name="product_status" value="<?php echo $product['status']; ?>" />
<div class="tab-content">
	<div class="tab-pane fade in active" id="masterData">
		<div class="row col-md-12" >
			<div class="col-md-6 bs-product-basic" >
				<div class="col-md-6" style="margin-top: 20px">
					<h5>产品ID：</h5>  <input type="text" class="form-control" readonly='readonly' id="product_id" name="product_id" value="<?php echo $product['product_id'];?>">
					<h5><span class="required">* </span>产品名称：</h5>
					<input type="text" class="form-control" <?php if( $product['status'] != 'INIT' ) echo "readonly=\"readonly\""; ?> id="product_name" name="product_name" value="<?php echo $product['product_name'];?>">
					<h5>商品条码：</h5> <input type="text" class="form-control" readonly="readonly" id="barcode" value="<?php echo $product['barcode'];?>">
				</div>
				<div class="col-md-6" style="margin-top: 20px">
					<h5>产品类型：</h5> 
					<label class="radio" style="display: inline-block;"><input disabled="disabled" class="product_type" type="radio" name="product_type" id="product_type" value="goods" <?php if($product['product_type'] == 'goods') echo "checked=\"checked\""?>>商品</label>
					<label class="radio" style="display: inline-block;"><input disabled="disabled" class="product_type" type="radio" name="product_type" id="product_type" value="supplies" <?php if($product['product_type'] == 'supplies') echo "checked=\"checked\""?>>耗材</label>
					
					<div id="product_sub_type">
				    <h5>子类型：</h5>
				    <label class="radio" style="display: inline-block;"><input disabled="disabled" class="product_sub_type" type="radio" name="product_sub_type" id="product_sub_type" value="raw_material" <?php if($product['product_sub_type'] == 'raw_material') echo "checked=\"checked\""?>>原料</label>
					<!-- <label class="radio" style="display: inline-block;"><input disabled="disabled" class="product_sub_type" type="radio" name="product_sub_type" id="product_sub_type" value="semi_finished" <?php if($product['product_sub_type'] == 'semi_finished') echo "checked=\"checked\""?>>半成品</label> -->
					<label class="radio" style="display: inline-block;"><input disabled="disabled" class="product_sub_type" type="radio" name="product_sub_type" id="product_sub_type" value="finished" <?php if($product['product_sub_type'] == 'finished') echo "checked=\"checked\""?>>成品</label>
			    	</div>
			     </div>
			     <div class="col-md-12">
			     	<h5><span class="required">* </span>产品描述：</h5> <input type="text" class="form-control" id="product_desc" name="product_desc" value="<?php echo $product['product_desc'];?>">
			        <h5><span class="required">* </span>备注：</h5><textarea rows="3" cols="30" id="note" name="note" class="form-control"><?php echo $product['note'];?></textarea><br/>
			        <?php if( $product['status'] == 'INIT' && $this->helper->chechActionList( array('productCheck'))) { ?>
						<a class="btn btn-info btn-sm update" style="margin-right:30px" href="javascrip:;" id="updateProductStatus">审核</a>
					<?php } ?>	
			     </div>
			</div>
			
			<!-- 耗材模块 -->
			<div class="col-md-10 bs-product-supplies" style="margin-top: 60px" id="product_supplies_div">
				<div class="col-md-12" style="margin-top: 20px;display: inline-block;" >
					<div class="row">  
						<h5 style="display: inline-block;">采购周期： <input type="number"  class="form-control" id="purchasing_cycle_supplies_raw" name="purchasing_cycle_supplies_raw" style="width: 50%;display: inline-block;" value="<?php echo $product['purchasing_cycle']?>">天</h5> 
					</div>
					<div class="row">
						<h5 style="display: inline-block; width: 20%">单位：  
							<select id="container_unit_code" <?php if( $product['status'] != 'INIT' ) echo "disabled=\"disabled\""; ?> class="form-control" name="container_unit_code" style="display: inline-block;width: 50%;">
								<?php if(!empty($unit_list) && !empty($unit_list['supplies']) && !empty($unit_list['supplies']['case'])){
	                                $str = '';
	                                foreach ($unit_list['supplies']['case'] as $key => $val) {
	                                	if(!empty($product['container_unit_code']) && $product['container_unit_code']==$val['unit_code'] ){
	                                		$str .= "<option value='".$val['unit_code']."' selected='selected'>".$val['unit_code_name']."</option>";
	                                	}else{
	                                    	$str .= "<option value='".$val['unit_code']."'>".$val['unit_code_name']."</option>";
                                    	}
	                                }
	                                echo $str;
	                            } ?>
							</select>
						</h5>
						<h5 style="display: inline-block; width: 20%">规格：<input type="number" class="form-control" id="supplies_container_quantity" <?php if( $product['status'] != 'INIT' ) echo "readonly=\"readonly\""; ?> name="supplies_container_quantity" value="" style="display: inline-block;width: 77%"></h5>
						<select id="supplies_unit_code" class="form-control" <?php if( $product['status'] != 'INIT' ) echo "disabled=\"disabled\""; ?> name="supplies_unit_code" style="display: inline-block;width: 10%;">
							<?php if(!empty($unit_list) && !empty($unit_list['supplies']) && !empty($unit_list['supplies']['general'])){
                                $str = '';
                                foreach ($unit_list['supplies']['general'] as $key => $val) {
                                	if(!empty($product['unit_code']) && $product['unit_code']==$val['unit_code'] ){
                                		$str .= "<option value='".$val['unit_code']."' selected='selected'>".$val['unit_code_name']."</option>";
                                	}else{
                                    	$str .= "<option value='".$val['unit_code']."'>".$val['unit_code_name']."</option>";
                                	}
                                }
                                echo $str;
                            } ?>
						</select>
					</div>
					<input type="hidden" name="unit_code_name" id="unit_code_name"/>
					<input type="hidden" name="supplies_unit_code_name" id="supplies_unit_code_name" />
					<input type="hidden" name="container_unit_code_name" id="container_unit_code_name" />
					<div class="row">
						<h5 style="display: inline-block;"><span class="required">* </span>长：<input type="number" class="form-control" id="length" name="length" value="<?php echo $product['length']?>" style="width: 100px;display: inline-block;">cm</h5>
						<h5 style="display: inline-block; margin-left: 5%"><span class="required">* </span>宽：<input type="number" class="form-control" id="width" name="width" value="<?php echo $product['width']?>" style="width: 100px;display: inline-block;">cm</h5>
						<h5 style="display: inline-block; margin-left: 5%"><span class="required">* </span>高：<input type="number" class="form-control" id="height" name="height" value="<?php echo $product['height']?>" style="width: 100px;display: inline-block;">cm</h5>
					</div>
				</div>
			</div>
			
			<!-- 包装方案模块 -->
			<div class="col-md-10 bs-supplies-finished" style="margin-top: 60px" id="product_supplies_finished_div">
				<div class="col-md-12" style="margin-top: 20px;display: inline-block;" >
					<div class="row">
						<div class="col-md-5 imgDiv" style="margin-top: 20px;">
							<div id="imgDiv1">
								<input type="file" id="img1" name="img1" class="img" size="0" style="display: none;" />
							</div>
							<div id="cover1" class="cover" style="position: absolute; background-color: White; z-index: 10;
							filter: alpha(opacity=100); -moz-opacity: 1; opacity: 1; ">
								<input id="selectImg1" type="button" value="选择图片" class="selectImg btn btn-primary" />
							</div>
							<div class="imgShow" id="imgShow1" style="width: 400px; margin-top: 60px;">
								<div class="productImg" id="productImg1" <?php if(empty($supplies_finished_img[0])) echo "hidden=true" ?>>
									<div style="border: 1px solid #eeeeee; padding: 3px;">
										<img src="<?php if(!empty($supplies_finished_img[0])) echo $WEB_ROOT.$upload_path.$supplies_finished_img[0]?>" class="imgHolder" id="imgHolder1" style="max-height: 390px; max-width: 390px;" />
										<input type="hidden" name="imgPath[]" value="<?php if(!empty($supplies_finished_img[0])) echo $supplies_finished_img[0]?>">
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
								<div class="productImg" id="productImg2" <?php if(empty($supplies_finished_img[1])) echo "hidden=true" ?>>
									<div style="border: 1px solid #eeeeee; padding: 3px;">
										<img src="<?php if(!empty($supplies_finished_img[1])) echo $WEB_ROOT.$upload_path.$supplies_finished_img[1]?>" class="imgHolder" id="imgHolder2" style="max-height: 390px; max-width: 390px;" />
										<input type="hidden" name="imgPath[]" value="<?php if(!empty($supplies_finished_img[1])) echo $supplies_finished_img[1]?>">
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
							filter: alpha(opacity=100); -moz-opacity: 1; opacity: 1;">
								<input id="selectImg3" type="button" value="选择图片" class="selectImg btn btn-primary" />
							</div>
							<div class="imgShow" id="imgShow3" style="width: 400px; margin-top: 60px;">
								<div class="productImg" id="productImg3" <?php if(empty($supplies_finished_img[2])) echo "hidden=true" ?> >
									<div style="border: 1px solid #eeeeee; padding: 3px;">
										<img src="<?php if(!empty($supplies_finished_img[2])) echo $WEB_ROOT.$upload_path.$supplies_finished_img[2]?>" class="imgHolder" id="imgHolder3" style="max-height: 390px; max-width: 390px;" />
										<input type="hidden" name="imgPath[]" value="<?php if(!empty($supplies_finished_img[2])) echo $supplies_finished_img[2]?>">
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
								<div class="productImg" id="productImg4" <?php if(empty($supplies_finished_img[3])) echo "hidden=true" ?>>
									<div style="border: 1px solid #eeeeee; padding: 3px;">
										<img src="<?php if(!empty($supplies_finished_img[3])) echo $WEB_ROOT.$upload_path.$supplies_finished_img[3]?>" class="imgHolder" id="imgHolder4" style="max-height: 390px; max-width: 390px;" />
										<input type="hidden" name="imgPath[]" value="<?php if(!empty($supplies_finished_img[3])) echo $supplies_finished_img[3]?>">
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
							filter: alpha(opacity=100); -moz-opacity: 1; opacity: 1;">
								<input id="selectImg5" type="button" value="选择图片" class="selectImg btn btn-primary" />
							</div>
							<div class="imgShow" id="imgShow5" style="width: 400px; margin-top: 60px;">
								<div class="productImg" id="productImg5" <?php if(empty($supplies_finished_img[4])) echo "hidden=true" ?> >
									<div style="border: 1px solid #eeeeee; padding: 3px;">
										<img src="<?php if(!empty($supplies_finished_img[4])) echo $WEB_ROOT.$upload_path.$supplies_finished_img[4]?>" class="imgHolder" id="imgHolder5" style="max-height: 390px; max-width: 390px;" />
										<input type="hidden" name="imgPath[]" value="<?php if(!empty($supplies_finished_img[4])) echo $supplies_finished_img[4]?>">
									</div>
									<input id="delImg5" type="button" style="width: 65px; height: 30px" value="删除" class="delImg btn btn-danger"> 
								</div>
							</div>
						</div>
					</div>
				<div class="row" style="margin-top: 30px">
					<div class="col-md-5">
					<input id="add_supplies_finished_ids_btn" type="button" class="btn btn-info btn-sm" value="成品-原料映射">
				     	<table border=3 style="width:100%" id="supplies_raw_material_list">
					     	<tr>
					     		<th id="product_id_title">耗材ID</th>
					     		<th id="product_name_title">耗材</th>
					     		<th id="quantity_title">数量</th>
					     		<th id="supplies_product_unit_title">单位</th>
					     		<th id="operator_title" style="width: 40px">操作</th>
					     	</tr>
				     	</table>
				     	<input type="hidden" name="product_supplies_id" value="">
			     	</div>
		     	</div>
				</div>
			</div>
			
			<!-- 原料模块 -->
			<div class="col-md-10 bs-product-raw_material" style="margin-top: 60px" id="product_raw_material_div">
				<div class="col-md-6" style="margin-top: 20px" id="product_raw_material_div2">
					<h5 style="display: block; margin-top: 10px;"><span class="required">* </span>产地：<input type="text" class="form-control" id="producing_region" name="producing_region" style="display: inline;width: 30%;" value="<?php echo $product['producing_region']?>"></h5>
					<h5 style="display: block; margin-top: 10px;">采购周期：<input type="text" class="form-control" id="purchasing_cycle_goods_raw" name="purchasing_cycle_goods_raw" style="display: inline;width: 30%;" value="<?php echo $product['purchasing_cycle']?>">天</h5>
					<h5><span class="required">* </span>存储单位：  
						<select id="unit_code" class="form-control" <?php if( $product['status'] != 'INIT' ) echo "disabled=\"disabled\""; ?> name="unit_code" style="width: 20%;display: inline-block;" >
							<?php if(!empty($unit_list) && !empty($unit_list['goods']) && !empty($unit_list['goods']['general'])){
                                $str = '';
                                foreach ($unit_list['goods']['general'] as $key => $val) {
                                	if(!empty($product['unit_code']) && $product['unit_code']==$val['unit_code'] ){
                                		$str .= "<option value='".$val['unit_code']."' selected='selected'>".$val['unit_code_name']."</option>";
                                	}else{
                                		$str .= "<option value='".$val['unit_code']."'>".$val['unit_code_name']."</option>";
                                	}    
                                }
                                echo $str;
                            } ?>
						</select>
					</h5>
					<h5><span class="required">* </span>采购单位：  
						<select id="purchase_unit_code" <?php if( $product['status'] != 'INIT' ) echo "disabled=\"disabled\""; ?> name="purchase_unit_code" class="form-control" style="width: 20%;display: inline-block;" >
							<?php if(!empty($unit_list) && !empty($unit_list['goods']) && !empty($unit_list['goods']['general'])){
                                $str = '';
                                foreach ($unit_list['goods']['general'] as $key => $val) {
                                    if(!empty($product['purchase_unit_code']) && $product['purchase_unit_code']==$val['unit_code'] ){
                                		$str .= "<option value='".$val['unit_code']."' selected='selected'>".$val['unit_code_name']."</option>";
                                	}else{
                                		$str .= "<option value='".$val['unit_code']."'>".$val['unit_code_name']."</option>";
                                	}  
                                }
                                echo $str;
                            } ?>
						</select>
					</h5>
					<h5><span class="required">* </span>销售单位：  
						<select id="sale_unit_code" <?php if( $product['status'] != 'INIT' ) echo "disabled=\"disabled\""; ?> name="sale_unit_code" class="form-control" style="width: 20%;display: inline-block;" >
							<?php if(!empty($unit_list) && !empty($unit_list['goods']) && !empty($unit_list['goods']['general'])){
                                $str = '';
                                foreach ($unit_list['goods']['general'] as $key => $val) {
                                    if(!empty($product['sale_unit_code']) && $product['sale_unit_code']==$val['unit_code'] ){
                                		$str .= "<option value='".$val['unit_code']."' selected='selected'>".$val['unit_code_name']."</option>";
                                	}else{
                                		$str .= "<option value='".$val['unit_code']."'>".$val['unit_code_name']."</option>";
                                	}  
                                }
                                echo $str;
                            } ?>
						</select>
					</h5>
                    <label class="valid_days"><span class="required">* </span>保质期：<input type="number" class="valid_days_input" name="valid_days" value="<?php echo $product['valid_days'] ?>">天</label>
                    <div id='weight_div'>
						<h5 style="display: inline-block;">
							<span class="required">* </span>净重：
							<input min="0" type="number" id="net_weight_min" name="net_weight_min" class="form-control" value="<?php echo $product['net_weight_min']?>" style="display: inline-block; width: 20%;"> --
							<input max="0" type="number" id="net_weight_max" name="net_weight_max" class="form-control" value="<?php echo $product['net_weight_max']?>" style="display: inline-block; width: 20%;">kg
						</h5>
					</div>
				</div>
			</div>
			
			<!-- 半成品模块 -->
			<div class="col-md-10 bs-product-semi-finish"  style="margin-top: 60px" id="product_semi_finish_div">
				<div class="col-md-6" style="margin-top: 20px">
					<h5><span class="required">* </span>父产品ID：<input type="text"  class="form-control" readonly='readonly' id="parent_product_id" value="<?php echo $product['parent_product_id']?>"></h5>  
					<h5><span class="required">* </span>父产品：</h5> <input type="text" readonly="readonly" class="form-control" id="parent_product_name" value="<?php echo $product['parent_product_name']?>">
				</div>
			</div>
		
			<!-- 成品模块 -->
			<div class="col-md-10 bs-product-finish" style="margin-top: 60px" id="product_finish_div">
				<div class="col-md-10" style="margin-top: 20px" id="product_finish_div2">
					<h5><span class="required">* </span>快递服务：<select id="shipping_service_id" name="shipping_service_id" class="form-control" style="width: 30%; display: inline-block;"></select>
	                </h5>       
					<h5><span class="required">* </span>暗语： <input type="text" class="form-control" id="secrect_code" name="secrect_code" value="<?php echo $product['secrect_code'];?>" style="width: 80%; display: inline-block;"></h5>  
					<h5>平台： <select id="platform_id" <?php if( $product['status'] != 'INIT' ) echo "disabled=\"disabled\""; ?> name="platform_id" class="form-control" style="width: 40%; display: inline-block;" ></select>
					</h5>
					<h5>商户： <select id="merchant_id" <?php if( $product['status'] != 'INIT' ) echo "disabled=\"disabled\""; ?> name="merchant_id" class="form-control" style="width: 40%; display: inline-block;" ></select>
					</h5>
					<div class="form-group">
					     <div class="checkbox">
					        <label style="line-height: 20px;">
					        	<input type="checkbox" id="pre_selection" name="pre_selection" <?php if($product['pre_selection']==1) echo 'checked="checked"' ?> >  是否需预拣选
					        </label>
					     </div>
					</div>
					<div class='row' style="text-align: left;margin-left:35px">
						<input id="add_merchant_goods_ids_btn" type="button" class="btn btn-info btn-sm"  value="添加成品-oms商品映射关系">
						<table id="merchant_goods_table" name="mapping_product_table" style="width:480px;" border="1" cellspacing="0" cellpadding="0">
							<tr>
								<th width="100px" id="merchant_goods_id_title">GOODS_ID</th>
								<th id="merchant_goods_name_title">商品</th>
								<th id="merchant_goods_operator_title" style="width: 40px">操作</th>
							</tr>
							<?php foreach ($merchant_goods_ids as $item){?>
							<tr class="content" data-product_goods_mapping_id="<?php echo $item['product_goods_mapping_id'] ?>">
								<td width="100px" class="merchant_goods_id"><?php echo $item['goods_id']?></td>
								<td class="merchant_goods_name"><?php echo $item['goods_name']?></td>
								<td width="40px">
								<?php if(!empty($product['status']) && $product['status']=='INIT'){ ?>
									<input type="button" class="btn btn-danger" value="删" style="width: 38px; height: 24px;">
								<?php } ?>
								</td>
							</tr>
							<?php }?>
						</table>
						<input type="hidden" name="product_goods_mapping_id" value="">
					</div>
					<div class="row" style="text-align: left;margin-left: 35px; margin-top: 35px" id="mapping_products_div">
						<input id="add_mapping_product_ids_btn" type="button" class="btn btn-info btn-sm"  value="成品-原料映射关系">
		      			<table id="mapping_product_table" name="mapping_product_table" border="1" style="width:580px">
							<thead>
							<tr>
								<th style="width: 100px" id="mapping_product_id_title">PRODUCT_ID</th>
								<th id="mapping_product_name_title">产品名称</th>
								<th id="mapping_product_quantity_title" style="width: 60px;">数量</th>
								<th id="mapping_product_unit_title" style="width: 60px;">单位</th>
								<th id="mapping_product_operator_title" style="width: 40px">操作</th>
							</tr>
							</thead>
							<tbody id="product_mapping"></tbody>
						</table>
						<input type="hidden" name="product_component_id" value="">
					</div>
				</div>
			</div>
		</div>
		<div class="row col-md-10"  style="text-align: center;">
<?php if( $this->helper->chechActionList( array('productEdit'))) { ?>
<input type="button" class="btn btn-primary" value="提交" id="sub">
<?php } ?>
</div>
	</div>

	<div class="tab-pane fade" id="specification_div">
		<div class="col-md-10 bs-product-specification" id="product_specification_div">
			<div class="col-md-10" style="margin-top: 20px">
				<h5 style="margin-top: 20px">收货标准：<textarea id='receiving_standard' name='receiving_standard' class="form-control" rows="3" cols="30"></textarea></h5>
				<h5 style="margin-top: 5px">收货异常处理：<textarea id='receiving_exception_handling' name='receiving_exception_handling' class="form-control" rows="3" cols="30"></textarea></h5>
				<h5 style="margin-top: 30px;display: inline;">存储温度：<input type="text" id='storage_temperature' name='storage_temperature' class="form-control" value="" style="width: 50%; display: inline-block;"></h5>
				<h5 style="display: inline-block;margin-left: 20px;">存储天数：<input type="number" min="1" id='storage_days' name='storage_days' class="form-control" value="" style="display: inline-block;width: 40%;"></h5>
				<h5 style="margin-top: 5px">存储注意事项：<textarea id='storage_notes' name='storage_notes' class="form-control" rows="3" cols="30"></textarea></h5>
				<h5 style="margin-top: 30px">拣选次果标准：<textarea id='defective_standard' name='defective_standard' class="form-control" rows="3" cols="30"></textarea></h5>
				<h5 style="margin-top: 5px">拣选坏果标准：<textarea id='bad_standard' name='bad_standard' class="form-control" rows="3" cols="30"></textarea></h5>
				<h5 style="margin-top: 5px">次品处理方法：<textarea id='defective_handing' name='defective_handing' class="form-control" rows="3" cols="30"></textarea></h5>
				<h5 style="margin-top: 30px">操作要求：<textarea id='specification' name='specification' class="form-control" rows="3" cols="30"></textarea></h5>
			</div>
		</div>
			<div class="row col-md-10"  style="text-align: center;">
			<?php if( $this->helper->chechActionList( array('productEdit'))) { ?>
			<input type="button" class="btn btn-primary" value="提交" id="sub">
			<?php } ?>
			</div>
	</div>
	<div class="tab-pane fade" id="best_shipping_div">
		<input type="hidden" name="facility_shipping_list" id="facility_shipping_list">
		<div class="panel panel-default">
	        <div class="panel-body">
	        	<label>第一步：设置仓库快递<input type="button" id="setProductFacilityShippingMapppingBtn" value="设置" class="btn btn-primary btn-sm"></label>
	        	<table id="facility_shipping_table" style="width: 80%;border: 3;" class="table table-striped table-bordered " >
	        		<thead>
	           			<tr>
	           				<th>仓库</th>
	           				<th>快递方式</th>
	           				<th>快递</th>
	           			</tr>
	           		</thead>
	           		<tbody style="text-align: left;">
	           			
	           		</tbody>
	           	</table>
	      		
	      		<label>第二步：设置包装方案<input type="button" id="setPackagingBtn" value="设置" class="btn btn-primary btn-sm"></label>
	      		<table class="table table-striped table-bordered " style="width: 80%;border: 3" id="set_packaging_table">
	           		<thead>
	           			<tr>
	           				<th>仓库</th>
	           				<th>快递</th>
	           				<th>包装方案</th>
	           			</tr>
	           		</thead>
	           		<tbody>
	           			
	           		</tbody>
		         </table>
	        
	            <label>第三步：是否使用最优快递：
	                <select  name="use_best_shipping" id="use_best_shipping" <?php if(!$this->helper->chechActionList(array('setShippingType'))) echo 'disabled="disabled"'?>></select>
	            </label>
	           
	           	<div id="general_link">
		           	<label>第四步：设置分快递规则</label>
		           	<table class="table table-striped table-bordered " style="width: 80%;border: 3" id="distribute_shipping_table">
		           		<thead>
		           			<tr>
		           				<th>仓库</th>
		           				<th>商品</th>
		           				<th>省</th>
		           				<th>市</th>
		           				<th>快递</th>
		           				<th>包装方案</th>
		           				<th>详情</th>
		           			</tr>
		           		</thead>
		           		<tbody>
		           			
		           		</tbody>
		           	</table>
		           	
		           	<label>第五步：设置分仓规则</label>
		           	<table class="table table-striped table-bordered " style="width: 80%;border: 3" id="distribute_facility_table">
						<thead>
							<tr>
								<th> PRODUCT_ID</th>
								<th> 商品 </th>
								<th> 仓库 </th>
								<th> 已设置省 </th>
								<th> 已设置市</th>
								<th>操作</th>
							</tr>
							</thead>
						<tbody>
		           	</table>
	            </div>
	            <div id="best_link">
	            	<label>第四步：设置权重<input type="button" id="product_shipping_btn" class="btn btn-primary btn-sm" value="设置"></label>
				</div>
	        </div>
	    </div>
    </div>

	<div class="tab-pane fade" id="product_district_div">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="row">
					<label class="col-md-2">商品服务区域是否与商户服务区域同步:</label>
					<select id="sync_to_merchant_district" style="width: 120px;float: left;" class="form-control district_status wait_loading" <?php if(!$this->helper->chechActionList(array('setProductdistrict'))) echo "disabled=\"disabled\""?>>
						<?php if($product['sync_to_merchant_district'] == "0"){?>
							<option value="1">同步</option>
							<option value="0" selected>不同步</option>
						<?php }else{?>
							<option value="1"  selected>同步</option>
							<option value="0" >不同步</option>
						<?php }?>
					</select>
					<input type="button" id="sync_district_sub" style="margin-left:3%;display: none" value="确认同步" class="btn btn-primary btn-sm wait_loading" >
				</div><br/>
				<div class="row">
					<label class="col-md-2">商品服务区域是否可超过商户服务区域:</label>
					<select id="cross_regional" style="width: 120px;float: left;" class="form-control wait_loading">
						<?php if($product['cross_regional'] == "1"){?>
							<option value="1" selected>允许</option>
							<option value="0">不允许</option>
						<?php }else{?>
							<option value="1">允许</option>
							<option value="0" selected>不允许</option>
						<?php }?>

					</select>
				</div><br/>
				<div class="row">
					<label class="col-md-2">是否在当前商户对应大区外的仓库发货:</label>
					<select id="delivery_facility_type" style="width: 120px;float: left;" class="form-control wait_loading" <?php if(!$this->helper->chechActionList(array('setProductdistrict'))) echo "disabled=\"disabled\""?>>
						<?php if($product['delivery_facility_type'] == "all"){?>
							<option value="current">当前大区仓库</option>
							<option value="all" selected>全国仓库</option>
						<?php }else{?>
							<option value="current" selected>当前大区仓库</option>
							<option value="all">全国仓库</option>
						<?php }?>

					</select>
				</div><br/>
				<div class="row" >
					<label class="col-md-2">设置商品服务区域 </label>
					<input type="button" id="setProductDistrictBtn" value="设置" class="btn btn-primary btn-sm wait_loading"  data-toggle="modal"
						   data-target="#product_district_modal">
				</div><br/>
				<p id="loading_table">数据加载中,请稍等...</p>
				<table id="product_district_table" name="product_district_table" style="width: 900px" border=3 class="table">

				</table>
			</div>
		</div>
	</div>
</div>			

<!-- Modal -->
<div>
	<div class="modal fade ui-draggable" id="facility_shipping_modal" role="dialog"  >
	  <div class="modal-dialog" style="width: 900px">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" id="btnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="facility_shipping_title" name="facility_shipping_title">设置候选仓库快递</h4>
	      </div>
	      <div class="modal-body ">
	      		<table id="facility_shipping_setting_table" name="facility_shipping_setting_table" border=3>
		      		<thead>
			      		<tr>
			      			<th id='province_title' style='width: 10%'>仓库</th>
			      			<th id='city_title' style='width: 10%'>快递方式</th>
			      			<th id='district_title' style='width: 80%'>快递</th>
			      		</tr>
		      		</thead>
		      		<tbody></tbody>
	      		</table>
	      </div>
	    <div class="modal-footer" >
	      	<input id="facility_shipping_sub" type="button" class="btn btn-primary" style="text-align: right; <?php if(!$this->helper->chechActionList(array('setProductFacilityShiipping'))) echo 'display: none;';?>" value="保存"  >
	      </div>
	    </div>
	  </div>
	</div>
</div>


	<!-- 设置商品服务区域Modal -->
	<div>
		<div class="modal fade ui-draggable" id="product_district_modal" role="dialog"  >
			<div class="modal-dialog" style="width: 900px">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" id="btnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="product_district_title" name="product_district_title">设置商品服务区域</h4>
					</div>
					<div class="modal-body ">
						<p id="loading_hits">数据加载中,请稍等...</p>
						<table id="district_table" name="product_district_setting_table" style="width: 100%" border=3 class="table">

						</table>
					</div>
					<div class="modal-footer" >
						<input id="product_district_sub" type="button" class="btn btn-primary" style="text-align: right; <?php if(!$this->helper->chechActionList(array('setProductdistrict'))) echo 'display: none;';?>" value="保存"  >
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- Modal -->
<div>
	<div class="modal fade ui-draggable" id="packaging_modal" role="dialog"  >
	  <div class="modal-dialog" style="width: 700px">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" id="btnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="packaging_title" name="packaging_modal_title">设置包装方案</h4>
	      </div>
	      <div class="modal-body ">
	      		<div>
		      		<label>批量设置</label>
		      		<label>仓库:<select id="packagingModalFacilitySel"></select></label>
		      		<label>快递方式:<select id="packagingModalShippingTypeSel">
		      			<option value=''>全部</option>
		      			<option value=1>落地配</option>
		      			<option value=0>快递配</option>
		      		</select></label>
		      		<label>包装方案：<input type="text" id="packagingModalBatchInp" class="form-control"></label>
	      		</div>
	      		
	      		<table class="table table-striped table-bordered " style="width: 80%;border: 3" id="packaging_modal_table">
						<thead>
							<tr>
								<th> 商品 </th>
								<th> 仓库</th>
								<th>快递方式</th>
								<th> 快递 </th>
								<th> 包装方案ID </th>
								<th> 包装方案</th>
							</tr>
							</thead>
						<tbody>
		           	</table>
	      </div>
	    <div class="modal-footer">
	      	<input id="packaging_sub" type="button" class="btn btn-primary" style="text-align: right; <?php if(!$this->helper->chechActionList(array('setPackaging'))) echo 'display: none;';?>" value="保存" >
	      </div>
	    </div>
	  </div>
	</div>
</div>
<!-- modal end  -->

<!-- Modal -->
<div>
	<div class="modal fade ui-draggable" id="product_shipping_modal" role="dialog"  >
	  <div class="modal-dialog" style="width: 900px">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" id="btnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="product_shipping_title" name="product_shipping_title">权值设置</h4>
	      </div>
	      <div class="modal-body" id="modalWeight"></div>
	    <div class="modal-footer">
	      	<input id="product_shipping_sub" type="button" class="btn btn-primary" style="text-align: right; <?php if(!$this->helper->chechActionList(array('setProductShipping'))) echo 'display: none;';?>" value="保存">
	      </div>
	    </div>
	  </div>
	</div>
</div>
<!-- Modal -->
<div>
	<div class="modal fade ui-draggable" id="region_modal" role="dialog"  >
	  <div class="modal-dialog" style="width: 700px">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" id="btnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="region_title" name="region_title"></h4>
	      </div>
	      <input type="hidden" id="facility_id1" >
	      <input type="hidden" id="shipping_id1" >
	      <input type="hidden" id="product_id1" >
	      <div class="modal-body ">
	      		<table id="district_info_table" name="district_info_table" style="width: 100% " border=3>
		      		
	      		</table>
	      </div>
	    <div class="modal-footer">
	      	<input id="package_sub" type="button" class="btn btn-primary" style="text-align: right; <?php if(!$this->helper->chechActionList(array('distributeShipping'))) echo 'display: none;';?>" value="保存" onclick="onSave(this)">
	      </div>
	    </div>
	  </div>
	</div>
</div>
<!-- modal end  -->

<div>
	<div class="modal fade ui-draggable" id="sdfm_region_modal" role="dialog"  >
	  <div class="modal-dialog" style="width: 700px">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" id="btnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="sdfm_region_title" name="sdfm_region_title"></h4>
	      </div>
	      <input type="hidden" id="sdfm_facility_id1" name="sdfm_facility_id">
	      <input type="hidden" id="sdfm_product_id1" name="sdfm_product_id">
	      <div class="modal-body ">
	      		<table id="sdfm_district_info_table" name="sdfm_district_info_table" border=3>
		      		
	      		</table>
	      </div>
	    <div class="modal-footer">
	      	<input id="sdfm_package_sub" type="button" class="btn btn-primary" style="text-align: right; <?php if(!$this->helper->chechActionList(array('distributeFacility'))) echo 'display: none;';?>" value="保存 " onclick="onSdfmSave()">
	      </div>
	    </div>
	  </div>
	</div>
</div>
<input type="hidden" name="purchasing_cycle" id="purchasing_cycle">
</form>    
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="http://cdn.bootcss.com/jquery.form/3.51/jquery.form.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/common.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/product_edit.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/js_wms/set_shipping.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/js_wms/distribute_shipping.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/js_wms/distribute_facility.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/js_wms/set_packaging.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/js_wms/set_product_district.js"></script>

<script>
    var WEB_ROOT = "<?php  echo isset($WEB_ROOT) ? $WEB_ROOT : ''; ?>",
        g_product_id = "<?php echo isset($product_id) ? $product_id : ''; ?>";
        productJs=<?php echo json_encode($product); ?>;
    var loadding = '<div id="loadding" class="loadding"><img src="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/img/loadding.gif"></div>';
</script>
<script type="text/javascript">
$('.update').click(function(){
	up_btn = $(this);
	product_id = $('#product_id').val();
	var cf=confirm( '是否确认审核?' )
	if (cf==false)
		return ;
	up_btn.attr('disabled','disabled');
	$.ajax({
		url:"<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>product/checkProductStatus",
		type:"get",
		data:{"product_id":product_id},
		dataType:"json",
		xhrFields: {
            withCredentials: true
        }
	}).done(function(data){
		if(data.success == "success"){
			alert('审核成功');
			window.location.reload();
		}
		else{
			alert(data.error_info);
			up_btn.removeAttr('disabled');
		}
	}).fail(function(data){
		//alert('内部服务器错误');
		up_btn.removeAttr('disabled');
	});
});
</script>

</body>
</html>
