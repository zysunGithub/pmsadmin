<!doctype html>
<html>

<head>
    <title>拼好货WMS</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="Pragma" content="no-cache">   
    <meta http-equiv="Cache-Control" content="no-store">
    <meta http-equiv="Expires" content="0">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT ; ?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT ; ?>assets/css/global.css">
    
    <link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.7/css/jquery.dataTables.css"> 
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>/assets/css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>/assets/css/buttons.dataTables.css">
	
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/lhgcalendar.css"/>
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/autocomplete.css">
    <!--[if lt IE 9]>
            <script src="http://assets.yqphh.com/assets/js/html5shiv.min-3.7.2.js"></script>
        <![endif]-->
    <style type="text/css">
        .remind { padding: 10px 0 0 15px; margin: 10px 0 0 10px; border: 1px solid #ddd; color: red; font-size: 18px; font-weight: 700; }
        .main {
            width: 100%;
            max-width: 640px;
            margin: 0 auto;
        }

        .date {
            font-size:15pt;
            float: left;
            color: red;
        }
        table {
            text-align: left;
            border: 1px;
            border-spacing: 0;
        }

        .text span {
            float: right;
        }
    </style>
</head>
<body>
<div class="container-fluid" style="margin-left: -18px;padding-left: 19px;" >
    <div role="tabpanel" class="row tab-product-list tabpanel" >
        <div class="col-md-12">
        <input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> >
        <input type="hidden" id="po_id" value="" >
        <input type="hidden" id="product_type"  value="<?php echo !empty($product_type)?$product_type:''?>" >
            <div class="tab-content">
                <div class="row col-sm-12  col-sm-offset-0" style="margin-top: 10px;">
                    <div class="row" style="text-align: center;">
                        <h1>
                            <?php if(!empty($po_type) && $po_type == 'FIRST'){ echo '23点采购计划'; } else { echo '5点采购计划';}?>
                        </h1>
                    </div>
                    <form action="<?php if(isset($WEB_ROOT)) echo "{$WEB_ROOT}"; ?>purchaseCommit<?php if( !empty( $form_url ) && $form_url == "supplies" ) echo '/suppliesIndex'; ?>">
                    <div>
                    <label for="area_id" style="width: 5%;text-align: left;">大区：</label>
                    <select style="width: 10%;" name="area_id" id="area_id" >
                        <?php foreach ($area_list as $area) {
                            echo "<option value=\"{$area['area_id']}\">{$area['area_name']}</option>";
                        }?>
                    </select>
                    <br/>
                    <label class="text-left" style=" vertical-align: top;">仓库：</label>
                    <div id="facility_ids" style="display:inline-block; width: 1000px;">
                        <?php 
                        if( !empty($area_list) ){
                            foreach ($area_list as $key1 => $area_item) {
                        ?>
                            <div id="area_<?php echo $area_item['area_id']; ?>" class="facility_wrap <?php if($key1!=0) echo 'hidden'; ?>">
                                <?php 
                                if( !empty($area_item['facility_info']) ){
                                    foreach ($area_item['facility_info'] as $key2 => $facility_item) {
                                        if( $product_type === 'goods' ){
                                ?>
                                        <label class="text-left"><input type="checkbox" name="facility_ids" data-flag="<?php if(isset($facility_item['flag'])) echo $facility_item['flag']; ?>" value="<?php echo $facility_item['facility_id']; ?>" <?php if( isset($facility_item['flag']) && $key1==0 && $facility_item['flag'] ) echo 'checked="checked"'; ?> ><?php echo $facility_item['facility_name']; ?></label>
                                <?php
                                        }else if( $product_type === 'supplies' ){ 
                                            if( isset($facility_item['facility_type']) && ($facility_item['facility_type'] == 1 || $facility_item['facility_type'] == 2) ){
                                ?>
                                                <label class="text-left"><input type="checkbox" name="facility_ids" data-flag="<?php if(isset($facility_item['flag'])) echo $facility_item['flag']; ?>" value="<?php echo $facility_item['facility_id']; ?>" <?php if( isset($facility_item['flag']) && $key1==0 && $facility_item['flag'] ) echo 'checked="checked"'; ?> ><?php echo $facility_item['facility_name']; ?></label>
                                <?php       }
                                        }
                                    }
                                }
                                ?>
                            </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                    </div>
                    <input type="hidden" id="po_date" value="<?php if(isset($po_date)) echo $po_date; ?>">
                    <div><label style="width: 5%;text-align: left;">日期：</label><?php echo $po_date;?></div>
                    <?php if($po_type == 'FIRST') {?>
                    <div>
                    <input type="button" value="5点采购计划" id="change_po_btn">
                    </div>
                    <?php }?>
                    </form>
                    
                    <?php if($po_type == 'SECOND' && !$readonly) {?>
                    <div><button id="stock_up_btn" class="btn btn-primary btn-large">备货</button></div>
                    <?php }?>
                    <table id="po_list" class="table table-striped table-bordered "  style="width:100%" >
                    <thead>
                    <tr>
                        <th width="10%">PRODUCT_ID</th>
                        <th width="14%">商品</th>
                        <th width="10%">期初库存</th>
                        <?php if(!empty($po_type) && $po_type == 'FIRST'){?>
                        <th width="12%">已确认待发货(截止<?php echo date($po_date,strtotime("-1 day")); ?>日23点）</th>
                        <th width="10%">前天23:00~<?php if(isset($fulfill_end_time)) echo $fulfill_end_time?>销售数量</th>
                        <th width="10%">昨天23:00~<?php if(isset($fulfill_end_time)) echo $fulfill_end_time?>销售数量</th>
                        <?php }else{?>
                        <th width="12%">已确认待发货(截止<?php echo $po_date;?>日5点）</th>
                        <th width="10%">前日05:00~<?php if(isset($fulfill_end_time)) echo $fulfill_end_time?>销售数量</th>
                        <th width="10%">昨日05:00~<?php if(isset($fulfill_end_time)) echo $fulfill_end_time?>销售数量</th>
                        <?php }?>
                        <th width="8%">预估数量</th>
                        <th width="12%">计划数量(已确认待发货 + 预估数量 - 期初库存)</th>
                        <th width="8%">承诺数量</th>
                        <th width="8%">到货数量</th>
                        <th width="5%">单位</th>
						<td hidden="true"></td>
                        <?php if($po_type == 'SECOND' && !$readonly) {?>
                        <th width="10%">操作</th>
                        <?php }?>
                    </tr>
					</thead>
					<tbody>
<!--                     <?php if( isset($purchase_order_item_list) && is_array($purchase_order_item_list))  foreach ($purchase_order_item_list as $key => $purchase_order_item) { ?> 
<?php if($purchase_order_item['unit_code'] == 'kg' && $product_type == 'goods') {?>
<tr class="po_item">
    <td><?php echo $purchase_order_item['product_id']?></td>
    <td><?php if(!empty($purchase_order_item['product_name'])) echo $purchase_order_item['product_name'] ?></td>
    <td><?php echo !empty($purchase_order_item['beginning_inventory'])?$purchase_order_item['beginning_inventory']*2:0 ?></td>
    <td><?php echo !empty($purchase_order_item['unshipped_inventory'])?$purchase_order_item['unshipped_inventory']*2:0 ?></td>
    <td><?php echo !empty($purchase_order_item['dminus2_inventory'])?$purchase_order_item['dminus2_inventory']*2:0 ?></td>
    <td><?php echo !empty($purchase_order_item['dminus1_inventory'])?$purchase_order_item['dminus1_inventory']*2:0 ?><br></td>
    <td><?php echo !empty($purchase_order_item['estimated_inventory'])?$purchase_order_item['estimated_inventory']*2:0 ?></td>
    <td><?php echo !empty($purchase_order_item['plan_inventory'])?$purchase_order_item['plan_inventory']*2:0 ?></td>
    <td><?php echo !empty($purchase_order_item['commitment_inventory'])?$purchase_order_item['commitment_inventory']*2:0 ?></td>
    <td><?php echo !empty($purchase_order_item['finish_inventory'])?$purchase_order_item['finish_inventory']*2:0 ?></td>
    <td>斤</td>
    <td hidden="true"><input type="hidden" id="po_item_id" value="<?php echo !empty($purchase_order_item['po_item_id'])?$purchase_order_item['po_item_id']:'' ?>" ></td>
    <?php if($po_type == 'SECOND' && !$readonly) {?>
    <td>
    <input id="add_record_btn_<?php echo $key?>"  type="button" class="btn <?php echo (!empty($purchase_order_item['commitment_inventory'])&&($purchase_order_item['commitment_inventory']!=0.00))?'btn-warning':'btn-primary'?> btn-large "value="添加" onclick="detail_modal(<?php echo $purchase_order_item['product_id']?>,'<?php echo $purchase_order_item['product_name']?>','<?php echo $purchase_order_item['unit_code']?>','<?php echo $purchase_order_item['po_item_id']?>','<?php echo $key?>','<?php echo $purchase_order_item['container_unit_code_name']?>','<?php echo $purchase_order_item['container_quantity']?>')" >
    </td>
<?php }?>
</tr>

<?php } else {?>
<tr class="po_item">
    <td><?php echo $purchase_order_item['product_id']?></td>
    <td><?php if(!empty($purchase_order_item['product_name'])) echo $purchase_order_item['product_name'] ?></td>
    <td><?php echo !empty($purchase_order_item['beginning_inventory'])?$purchase_order_item['beginning_inventory']:0 ?></td>
    <td><?php echo !empty($purchase_order_item['unshipped_inventory'])?$purchase_order_item['unshipped_inventory']:0 ?></td>
    <td><?php echo !empty($purchase_order_item['dminus2_inventory'])?$purchase_order_item['dminus2_inventory']:0 ?></td>
    <td><?php echo !empty($purchase_order_item['dminus1_inventory'])?$purchase_order_item['dminus1_inventory']:0 ?><br></td>
    <td><?php echo !empty($purchase_order_item['estimated_inventory'])?$purchase_order_item['estimated_inventory']:0 ?></td>
    <td><?php echo !empty($purchase_order_item['plan_inventory'])?$purchase_order_item['plan_inventory']:0 ?></td>
    <td><?php echo !empty($purchase_order_item['commitment_inventory'])?$purchase_order_item['commitment_inventory']:0 ?></td>
    <td><?php echo !empty($purchase_order_item['finish_inventory'])?$purchase_order_item['finish_inventory']:0 ?></td>
    <td><?php echo !empty($purchase_order_item['product_unit_code'])?$purchase_order_item['product_unit_code']:'' ?></td>
    <td hidden="true"><input type="hidden" id="po_item_id" value="<?php echo !empty($purchase_order_item['po_item_id'])?$purchase_order_item['po_item_id']:'' ?>" ></td>
    <?php if($po_type == 'SECOND' && !$readonly) {?>
    <td>
    <input id="add_record_btn_<?php echo $key?>"  type="button" class="btn <?php echo (!empty($purchase_order_item['commitment_inventory'])&&($purchase_order_item['commitment_inventory']!=0.00))?'btn-warning':'btn-primary'?> btn-large "value="添加" onclick="detail_modal(<?php echo $purchase_order_item['product_id']?>,'<?php echo $purchase_order_item['product_name']?>','<?php echo $purchase_order_item['unit_code']?>','<?php echo $purchase_order_item['po_item_id']?>','<?php echo $key?>','<?php echo $purchase_order_item['container_unit_code_name']?>','<?php echo $purchase_order_item['container_quantity']?>')" >
    </td>
    <?php }?>
</tr>
<?php }?>
<?php }?> -->
					</tbody>
                    </table>
                    <input type="hidden" id="po_type" value="<?php echo $po_type; ?>">
                    <input type="hidden" id="is_readonly" value="<?php echo $readonly; ?>">
                    <table id="record" class="table table-striped table-bordered" style="width:90%">
                        <thead>
                            <tr>
                                <th width="10%">PRODUCT_ID</th>
                                <th width="20%">商品</th>
                                <th width="10%">供应商</th>
                                <th width="10%">仓库</th>
                                <th class="hidden">仓库ID</th>
                                <th class="hidden">采购地ID</th>
                                <th class="<?php if($product_type==='supplies') echo 'hidden'; ?>" style="width: 10%;">采购地</th>
                                <th width="10%">件数</th>
                                <th width="10%">箱规</th>
                                <th width="10%">单位</th>
                                <?php if($po_type == 'SECOND' && !$readonly) {?>
                                    <th width="10%">删除</th>
                                <?php }?>
                            </tr>
                        </thead>
                        <tbody>
                        <!-- <?php 
                        if( isset($asn_item_list) && is_array($asn_item_list))  foreach ($asn_item_list as $key => $asn_item) {
                        if($asn_item['product_unit_code'] == 'kg' && $product_type == 'goods') {
                        ?>
                        <tr>
                            <td><?php echo $asn_item['product_id'] ?></td>
                            <td><?php if(!empty($asn_item['product_name'])) echo $asn_item['product_name'] ?></td>
                            <td><?php if(!empty($asn_item['product_supplier_name'])) echo $asn_item['product_supplier_name'] ?></td>
                            <td><?php echo !empty($asn_item['facility_name'])?$asn_item['facility_name']:''?></td>
                            <td><?php echo !empty($asn_item['commitment_case_num'])?($asn_item['commitment_case_num']-$asn_item['replenish_case_num']):0 ?></td>
                            <td><?php echo !empty($asn_item['quantity'])?$asn_item['quantity']*2:0 ?></td>
                            <td>斤</td>
                            <?php if($po_type == 'SECOND' && !$readonly) {?>
                            <td><input id="remove_record_btn_<?php echo $key?>"  type="button" class="btn btn-danger btn-large "value="删除" onclick="remove_asn_item(<?php echo $asn_item['asn_item_id']?>)" ></td>
                            <?php }?>
                        </tr>
                        <?php } else {?>
                        <tr>
                            <td><?php echo $asn_item['product_id'] ?></td>
                            <td><?php if(!empty($asn_item['product_name'])) echo $asn_item['product_name'] ?></td>
                            <td><?php if(!empty($asn_item['product_supplier_name'])) echo $asn_item['product_supplier_name'] ?></td>
                            <td><?php echo !empty($asn_item['facility_name'])?$asn_item['facility_name']:''?></td>
                            <td><?php echo !empty($asn_item['commitment_case_num'])?($asn_item['commitment_case_num']-$asn_item['replenish_case_num']):0 ?></td>
                            <td><?php echo !empty($asn_item['quantity'])?$asn_item['quantity']:0 ?></td>
                            <td><?php echo !empty($asn_item['product_unit_code'])?$asn_item['product_unit_code']:'' ?></td>
                            <?php if($po_type == 'SECOND' && !$readonly) {?>
                            <td><input id="remove_record_btn_<?php echo $key?>"  type="button" class="btn btn-danger btn-large "value="删除" onclick="remove_asn_item(<?php echo $asn_item['asn_item_id']?>)" ></td>
                            <?php }?>
                        </tr>
                        <?php }?>
                        <?php }?> -->
                                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div>
    <div class="modal fade ui-draggable  text-center" id="detail_modal" role="dialog"  >
       <div class="modal-dialog" style="display: inline-block; width:70%;">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" id="btnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">添加</h4>
          </div>
          <div class="modal-body ">
          <div class='row'>
                    <label for="modal_product_name" style="text-align: right;">商品：</label><input type="text" class="form-control" style="color: red;display:inline;width: 200px" disabled="disabled" id="modal_product_name">
                    <input type="hidden" style="color: red" disabled="disabled" id="modal_unit_code">
                    <label for="modal_unit_code_desc" style="text-align: right;">单位：</label><input type="text" class="form-control" style="color: red;display:inline;width: 200px" disabled="disabled" id="modal_unit_code_desc">
                    <input type="hidden" id="modal_product_id" value="">
                    <input type="hidden" id="modal_po_item_id" value="">
                    <input type="hidden" id="modal_key" value="">
                    <input type="hidden" id="modal_container_unit_code_name">
                    <input type="hidden" id="modal_container_quantity">
                    <input id="modal_add_item" type="button" class="btn btn-primary btn-sm" style="text-align: left;margin-left: 35px" value="添加">
            </div></br>
                <table id="modal_table" style="width: 700px;border: 3 ">
                    <tr>
                        <th id="modal_table_purchase_place_name" style="width:120px;">采购地</th>
                        <th id="modal_table_facility_name" style="width:75px;">仓库</th>
                        <th id="modal_table_commitment_case_num" width="100px">件数</th>
                        <th id="modal_table_container_quantity" width="100px">箱规 </th>
                        <th id="modal_table_supplier" width="110px">供应商</th>
                        <th id="modal_table_purchase_agent" width="100px">采购员</th>
                        <th id="modal_table_unit_price" width="100px">单价</th>
                        <th id="modal_table_supplier_return" width="210px">供应商换货(退货ID+供应商名)</th>
                        <th width="30px">操作</th>
                    </tr>
                </table>
          </div>
          <div class="modal-footer">
          <div class="row"><button class="btn btn-success btn-lager" id="add_to_asn_btn" style="float:right;margin-right: 50px">提交</button></div>
          </div>
        </div>
      </div>
    </div>
</div>
<!-- modal end  -->
<div class='row' style="display:none" id="display_div">
    <select name="purchase_place"></select>
</div>

<!-- Modal -->
<div>
<div class="modal fade ui-draggable" id="stock_up_modal" role="dialog"  >
  <div class="modal-dialog" style="width: 400px">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" id="btnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">备货</h4>
      </div>
      <div class="modal-body ">
        <div class='row'>
            <input type="text" id='stock_up_product_id' hidden="true">
            <label for="stock_up_product_name">商品：</label><input type="text" class="form-control" style="width:200px; height: 100%;display: inline" id="stock_up_product_name" name="stock_up_product_name">
        </div></br>
        <div class="row"><button class="btn btn-success btn-lager" id="add_stock_up_btn" style="float:right;margin-right: 50px" >提交</button></div>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
</div>
<!-- modal end  -->

    <script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
    <script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script type="text/javascript" charset="utf8" src="http://cdn.datatables.net/1.10.7/js/jquery.dataTables.js"></script>

	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/jquery.dataTables.js"></script>
	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/dataTables.bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/dataTables.buttons.js"></script>
	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/buttons.colVis.js"></script>
	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/buttons.flash.js"></script>
    <script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/lhgcalendar.min.js"></script>
    <script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js"></script>
    <script type="text/javascript">
    var product_type = $('#product_type').val();
    $('#stock_up_btn').click(function(){
         $('#stock_up_modal').modal('show').on();
    });

    $('#add_stock_up_btn').click(function(){
        var product_id = $('#stock_up_product_id').val();
        var product_name = $('#stock_up_product_name').val();
        if(product_id == '' || product_name == ''){
            alert('请输入备货商品');
            return false;
        }
        var po_id = $('#po_id').val();
        var submit_data = {
                "product_id": product_id,
                "product_name": product_name,
                "po_id": po_id
            };

        var cf=confirm('是否确认提交');
        if (cf==false)
            return ;
        
        var postUrl = $('#WEB_ROOT').val() + 'purchaseCommit/addStockUpProduct';
        $.ajax({
            url: postUrl,
            type: 'POST',
            data:submit_data, 
            dataType: "json", 
            xhrFields: {
              withCredentials: true
            }
      }).done(function(data){
          if(data.success == "success"){
              alert("添加成功");
              $('#stock_up_modal').modal('hide');
              location.reload();
          }else{
              $('#add_stock_up_btn').removeAttr('disabled');
              alert(data.error_info);
            }
        });
        $('#add_stock_up_btn').attr('disabled',"true");
    });
    
    function detail_modal(product_id,product_name,unit_code,po_item_id,key){
        $("#modal_product_id").val(product_id);
        $("#modal_product_name").val(product_name);
        $("#modal_po_item_id").val(po_item_id);
        $("#modal_commitment_case_num").val('');
        $("#modal_container_quantity").val('');
        /*$("#modal_container_unit_code_name").val(container_unit_code_name);
        $("#modal_container_quantity").val(container_quantity);*/
        $("#modal_key").val(key);
        var data = {
            "product_id" : product_id
        };
        if(product_type == 'goods') {
            $("#modal_unit_code_desc").val( (unit_code==='kg' ? '斤' : unit_code) + '/' + '箱');
            $("#modal_unit_code").val( (unit_code==='kg' ? '斤' : unit_code) );
            $("#modal_container_unit_code_name").val('');
            $("#modal_container_quantity").val('');
            $('#modal_table_purchase_place_name').removeClass('hidden');
            $('#modal_table_purchase_agent').addClass('hidden');
            $('#modal_table_unit_price').addClass('hidden');
        } else {
            $('#modal_table_purchase_agent').removeClass('hidden');
            $('#modal_table_unit_price').removeClass('hidden');
            $('#modal_table_purchase_place_name').addClass('hidden');
            getContainerQuantity(data).done(function(data){
                if( data.success === 'success' ){
                    $("#modal_unit_code_desc").val(unit_code + '/' + data.container_info.container_unit_code_name);
                    $("#modal_unit_code").val(unit_code);   
                    $("#modal_container_unit_code_name").val(data.container_info.container_unit_code_name);
                    $("#modal_container_quantity").val(data.container_info.container_quantity);                 
                }else{
                    alert(data.error_info);
                }
            });
        }
	/*暂时不用这个功能
 		$.ajax({
            type: 'GET',
            url: '<?php // echo $WEB_ROOT; ?>purchaseCommit/suppliers?product_id=' + product_id,
            dataType: 'json',
            success: function(data) {
                productSupplierList = data.product_supplier_list;
            }
        });*/
        $("#modal_table tr.content").remove();
        $('#detail_modal').modal('show').on();
    }

    function getContainerQuantity(data){
        return $.ajax({
            url : $('#WEB_ROOT').val() + 'purchaseCommit/getContainerQuantity',
            type : 'GET',
            data : data,
            dataType : 'json'
        }).fail(function(xhr){
            alert( xhr.statusText+':获取箱规请求失败' );
        });
    }
    function getAreaPurchaseManagerList(){
        product_type =  $('#product_type').val();
        submit_data = {
            'product_type': product_type
        };
        var postUrl = $('#WEB_ROOT').val() + 'purchasePrice/getAreaPurchaseManagerList';
        $.ajax({
            url: postUrl,
            type: 'POST',
            data:submit_data,
            dataType: "json",
            xhrFields: {
                withCredentials: true
            }
        }).done(function(data){
            if(data.success == "success"){
                purchase_user_list = data.manager_list;
            }else{
            }
        }).fail(function(data){
        });
    }
    $('#add_to_asn_btn').click(function(){
        product_id = $('#modal_product_id').val();
        product_name = $('#modal_product_name').val();
        product_unit_code = $('#modal_unit_code').val();
        po_item_id = $('#modal_po_item_id').val();
        var items = [];
        var available = true;
        $('#modal_table tr.content').each(function(){
            var purchase_place_id = $(this).find('td.purchase_place').find('select').val(),
                facility_id = $(this).find('td.facility_select').find('select').val(),
                container_quantity = $(this).find('td.container_quantity').find('input').val(),
                commitment_case_num = $(this).find('td.commitment_case_num').find('input').val(),
                product_supplier_id = $(this).find('td.product_supplier_id').html(),
                product_supplier_name = $(this).find('td.supplier').find('input').val(),
                supplier_return_id = $(this).find('td.supplier_return_id').html(),
                purchase_agent_id = $(this).find('td.purchase_agent_id').html(),
                purchase_agent = $(this).find('td.purchase_agent').find('input').val(),
                unit_price = $(this).find('td.unit_price').find('input').val();

            if (product_type == 'supplies' && (purchase_agent_id == '' || unit_price == '')) {
                available = false;
                    alert("采购员与单价不能为空");
                    return false;
            }
            if( product_type === 'goods' && purchase_place_id == '' ) {
                available = false;
                alert('采购地不能为空');
                return false;
            }    
            if(facility_id == '' ) {
                available = false;
                alert('仓库不能为空');
                return false;
            }
            if(container_quantity == '' ) {
                available = false;
                alert('箱规不能为空');
                return false;
            } 
            if(product_unit_code == '斤'){
                container_quantity = parseFloat(container_quantity)/2;
                product_unit_code_s = 'kg';
            } else {
                product_unit_code_s = product_unit_code;
            }
            if (commitment_case_num == ''){
                available = false;
                alert('件数不能为空');
                return false;
            }
            if( product_supplier_id == '' || product_supplier_name == ''){
                available = false;
                alert('供应商不能为空');
                return false;
            }
            
            var item = { 
                'facility_id': facility_id,
                'product_id':product_id,
                'product_name':product_name,
                'product_unit_code':product_unit_code_s,
                'po_item_id':po_item_id,
                'commitment_case_num':commitment_case_num,
                'container_quantity':container_quantity,
                'product_supplier_id':product_supplier_id,
                'product_supplier_name':product_supplier_name,
                'purchase_agent_id':purchase_agent_id,
                'purchase_agent':purchase_agent,
                'unit_price':unit_price
            };

            product_type==='goods' && (item['purchase_place_id']=purchase_place_id);
            supplier_return_id && (item.supplier_return_id = supplier_return_id);
            items.push(item);
        });
        if(!available){
            return false;
        }
        if(items.length == 0){
            alert('先填数量再提交');
            return false;
        }
        btn = $(this);
        var cf=confirm('是否确认');
        if (cf==false)
            return false;
        var po_id = $('#po_id').val();
        btn.attr('disabled',"true");
        var submit_data = {
            "po_id":po_id,
            "product_id":product_id,
            "asn_items":items
        };

        var $record = $('#record').find('tbody');
        var postUrl = $('#WEB_ROOT').val() + 'purchaseCommit/addAsnItems';
        $.ajax({
            url: postUrl,
            type: 'POST',
            data:submit_data, 
            dataType: "json", 
            xhrFields: {
              withCredentials: true
            }
      }).done(function(data){
          if(data.success == "success"){
                alert("提交成功");
                $('#detail_modal').modal('hide');
                var tmp = data.asn_item_list;                   
                $.each(tmp,function(i){
                    var str = '';
                    str+= '<tr><td>'+this.product_id+'</td><td>'+this.product_name+'</td><td>'+this.product_supplier_name+'</td><td>'+this.facility_name+'</td><td class="facility_id hidden">'+this.facility_id+'</td><td class="purchase_place_id hidden">'+this.purchase_place_id+'</td><td class="purchase_place_name';
                    if( product_type==='supplies' ){
                        str += ' hidden';
                    }
                    str += '">'+(this.purchase_place_name ? this.purchase_place_name : '')+'</td>';
                    str+= '<td>'+(this.commitment_case_num ? (this.commitment_case_num-this.replenish_case_num) : 0) +'</td>';
                    if(this.product_unit_code == 'kg'){
                        str+= '<td>'+(this.quantity ? (2*this.quantity) : 0)+'</td><td>斤</td>';
                    }else {
                        str+= '<td>'+(this.quantity ? (this.quantity) : 0)+'</td><td>'+(this.product_unit_code ? this.product_unit_code : '') +'</td>';
                    }
                    if( $('#po_type').val()=='SECOND' && !$('#is_readonly').val() ){
                        str+= '<td><input id="remove_record_btn_'+i+'" type="button" class="btn btn-danger btn-large " value="删除" onclick="remove_asn_item('+this.asn_item_id+','+this.facility_id+','+this.purchase_place_id+')"></td></tr>';
                    }else{
                        str+= '<td></td></tr>';                       
                    }
                    $record.html( $record.html()+str );
                });
                
                if(data.productInventory > 0) {
                    key = parseInt($('#modal_key').val());
                    $('#add_record_btn_'+key).parent().prev().prev().prev().prev().html(data.productInventory);
                    $('#add_record_btn_'+key).addClass('btn-warning');
                    $('#add_record_btn_'+key).removeClass('btn-primary');
                }
                btn.removeAttr('disabled');
          }else{
              btn.removeAttr('disabled');
              alert(data.error_info);
            }
        }).fail(function(data){
            btn.removeAttr('disabled');
            alert('添加失败');
        });
    });

    function remove_asn_item(asn_item_id,facility_id,purchase_place_id) {
        var po_id = $('#po_id').val();
        var submit_data = {
                "asn_item_id":asn_item_id,
                "po_id":po_id,
                "facility_id":facility_id,
                "purchase_place_id":purchase_place_id
            };
        var cf=confirm('是否确认删除');
        if (cf==false)
            return ;
        
        var postUrl = $('#WEB_ROOT').val() + 'purchaseCommit/removeAsnItem';
        $.ajax({
            url: postUrl,
            type: 'POST',
            data:submit_data, 
            dataType: "json", 
            xhrFields: {
              withCredentials: true
            }
      }).done(function(data){
          if(data.success == "success"){
              alert("删除成功");
              location.reload();
          }else{
              alert(data.error_info);
            }
        });
    }
    
      //添加sku
    $("#modal_add_item").click(function() {
        var lineIndex = $("#modal_table tr.content").size();
        var tr = $("<tr>");
        tr.addClass('content');
        
        if( product_type === 'goods' ){
            var productSelect = $("#display_div").find("select[name='purchase_place']").clone();
            productSelect.width('150px');
            productSelect = productSelect.eq(0);
            td = $("<td>");
            td.addClass("purchase_place");
            td.append(productSelect);
            tr.append(td);

            var purchase_place_id = $("#display_div").find("select[name='purchase_place']").val();
            var $facilitySelect = $('#of_purchase_'+purchase_place_id).clone();
            var $td = $('<td>');
            $td.addClass('facility_select');
            $td.append($facilitySelect);
            tr.append($td);
        }else if( product_type === 'supplies' ){
            var $facilitys = $('.facility_wrap input:checked');
            var $facilitySelect = '<select>';
            $facilitys.each(function(){
                var id = $(this).val(),
                    name = $(this).parent().text();
                $facilitySelect += '<option value="'+id+'">'+name+'</option>';
            });
            $facilitySelect += '</select>';
            var $td = $('<td>');
            $td.addClass('facility_select');
            $td.append($facilitySelect);
            tr.append($td);
        }

        commitment_case_num = $("<input>");
        commitment_case_num.width('100px');
        commitment_case_num.attr('type','number');
        commitment_case_num.attr('value','0');
        td = $("<td>");
        td.addClass('commitment_case_num');
        td.append(commitment_case_num);
        tr.append(td);
        
        container_quantity = $("<input>");
        container_quantity.width('100px');
        container_quantity.attr('type','number');
        container_quantity.addClass('container_number');
        container_quantity.attr('min','0.000');
        container_quantity.attr('step','0.001');
        container_quantity.attr('value','0.000');
        if(product_type == 'supplies') {
            container_quantity.val($('#modal_container_quantity').val());
            container_quantity.attr('readonly','readonly');
        }
        td = $("<td>");
        td.addClass('container_quantity');
        td.append(container_quantity);
        tr.append(td);

        td = $("<td>");
        td.attr('hidden','hidden');
        td.addClass('product_supplier_id');
        tr.append(td);

        supplier = $("<input>");
        supplier.css('width','100px');
         
        supplier.autocomplete(productSupplierList, {
            minChars: 0,
            width: 310,
            max: 100,
            matchContains: true,
            autoFill: false,
            formatItem: function(row, i, max) {
                return "[" + row.product_supplier_code + ']'+ row.product_supplier_name;
            },
            formatMatch: function(row, i, max) {
                return row.product_supplier_code + row.product_supplier_name ;
            },
            formatResult: function(row) {
                return (row.product_supplier_name);
            }
        }).result(function(event, row, formatted) {
            $(this).parent().parent().find('td.product_supplier_id').html(row.product_supplier_id);
            $(this).val(row.product_supplier_name);
        });
        td = $("<td>");
        td.addClass('supplier');
        td.append(supplier);
        tr.append(td);
        if (product_type == 'supplies') {
            td = $("<td>");
            td.addClass('purchase_agent_id');
            td.attr('hidden','hidden');
            tr.append(td);
            purchase_agent = $("<input>");
            purchase_agent.css('width','80px');
            purchase_agent.autocomplete(purchase_user_list, {
                minChars: 0,
                width: 310,
                max: 100,
                matchContains: true,
                autoFill: false,
                formatItem: function (row, i, max) {
                    return row.real_name;
                },
                formatMatch: function (row, i, max) {
                    return row.real_name;
                },
                formatResult: function (row) {
                    return (row.real_name);
                }
            }).result(function (event, row, formatted) {
                $(this).parent().parent().find('.purchase_agent_id').html(row.user_id);
                $(this).val(row.real_name);
            });
            td = $("<td>");
            td.addClass('purchase_agent');
            td.append(purchase_agent);
            tr.append(td);

            unit_price = $("<input>");
            unit_price.css('width','60px');
            td = $("<td>");
            td.addClass('unit_price');
            td.append(unit_price);
            tr.append(td);
        }
        td = $("<td>");
        td.addClass('supplier_return_id')
        td.attr('hidden','hidden');
        tr.append(td);

        supplier_return = $('<input>');
        supplier_return.width('210px');
        //获取supplierreturnlist，并使用autocomplete
        supplier_return.one('mouseup',function(ev){//监听供应商退货框鼠标事件，从而加载数据
            var $this = $(this),
                product_id = $.trim($('#modal_product_id').val()),
                facility_id = $.trim($this.closest('tr.content').find(".facility_select select").val()),
                data = {
                    'product_id' : product_id,
                    'facility_id' : facility_id,
                    'return_type' : 'exchange',
                    'status' : 'EXECUTED'
                };
            $this.attr('disabled','disabled');
            $.ajax({
                url : $('#WEB_ROOT').val() + 'purchaseCommit/getSupplierReturnList',
                type : 'GET',
                data : data,
                dataType : 'json',
                beforeSend : function(){
                    $this.attr('placeholder','正在获取数据...');
                }
            }).done(function(data){
                $this.attr('placeholder','数据获取成功');
                $this.removeAttr('disabled');
                if(data.success!='success'){
                    $this.attr('placeholder','数据为空,该条件下没有退货记录');
                    return;
                }
                $this.autocomplete(data.supplies_return_list,{
                    minChars : 0,
                    width : 310,
                    max : 100,
                    matchContains : true,
                    autoFill : false,
                    formatItem: function(row, i, max) {
                        return '['+row.supplier_return_id+']'+row.product_supplier_name;
                    },
                    formatMatch: function(row, i, max) {
                        return '['+row.supplier_return_id+']'+row.product_supplier_name;
                    },
                    formatResult: function(row) {
                        return '['+row.supplier_return_id+']'+row.product_supplier_name;
                    }
                }).result(function(event, row, formatted) {
                    var $this = $(this),   
                        $commitment_case_num = $this.closest('tr.content').find('td.commitment_case_num > input'),
                        $container_quantity = $this.closest('tr.content').find('td.container_quantity > input'),
                        $supplier = $this.closest('tr.content').find('td.supplier > input'),
                        $product_supplier_id = $this.closest('tr.content').find('td.product_supplier_id'),
                        $supplier_return_id = $this.closest('tr.content').find('td.supplier_return_id'),
                        $supplier_return_ids = $('#modal_table').find('.supplier_return_id');

                    var flag = false;
                    $supplier_return_ids.each(function(){
                        if($(this).html() !== '' && $(this).html() === row.supplier_return_id){
                            alert('不能对一条退货记录进行两次换货');
                            flag = true;
                            return false;
                        }
                    });
                    if(flag){
                        $this.val('');
                        return;
                    }
                    $commitment_case_num.val(row.apply_quantity);
                    $commitment_case_num.attr('disabled','disabled');
                    $container_quantity.val( $('#modal_unit_code_desc').val()=='斤/箱' ? row.quantity*2 : row.quantity );
                    $container_quantity.attr('disabled','disabled');
                    $supplier.val(row.product_supplier_name);
                    $supplier.attr('disabled','disabled');
                    $product_supplier_id.html(row.product_supplier_id);
                    $supplier_return_id.html(row.supplier_return_id);
                    $this.val('['+row.supplier_return_id+']'+row.product_supplier_name);
                });
            }).fail(function(){
                alert('ajax发送失败，请联系前后端开发人员');
            });

        });
//fn end

        td = $("<td>");
        td.addClass('supplier_return');
        td.append(supplier_return);
        tr.append(td);

        delbtn = $("<input>");
        delbtn.width('30px');
        delbtn.val('删');
        delbtn.attr("type","button");
        delbtn.addClass("btn-danger");
        delbtn.addClass("add_modal_deltr");
        delbtn.click(deltr);
        td = $("<td>");
        td.append(delbtn);
        tr.append(td);
        $("#modal_table tr").eq(lineIndex).after(tr);
    });

    $('#modal_table').on('change','.facility_select > select',function(){//当仓库地change的时候，需要回退对应这一行的状态，并且重新绑定mouseup来获取数据
        var $this = $(this),
            $commitment_case_num = $this.closest('tr.content').find('td.commitment_case_num > input'),
            $container_quantity = $this.closest('tr.content').find('td.container_quantity > input'),
            $supplier = $this.closest('tr.content').find('td.supplier > input'),
            $supplier_return = $this.closest('tr.content').find('td.supplier_return > input'),
            $supplier = $this.closest('tr.content').find('td.supplier > input'),
            $product_supplier_id = $this.closest('tr.content').find('td.product_supplier_id'),
            $supplier_return_id = $this.closest('tr.content').find('td.supplier_return_id');

        $commitment_case_num.removeAttr('disabled');
        $commitment_case_num.val('');
        $container_quantity.removeAttr('disabled');
        if(product_type != 'supplies') {
        	$container_quantity.val('');
        }
        $supplier.removeAttr('disabled');
        $supplier.val('');
        $supplier_return.removeAttr('disabled');
        $supplier_return.attr('placeholder','');
        $supplier_return.val('');
        $product_supplier_id.html('');
        $supplier_return_id.html('');
        if( $this.val()==='' ){
            return;
        }
        $supplier_return.one('mouseup',function(ev){//监听供应商退货框鼠标事件，从而加载数据
            var $this = $(this),
                product_id = $.trim($('#modal_product_id').val()),
                facility_id = $.trim($this.closest('tr.content').find(".facility_select select").val()),
                data = {
                    'product_id' : product_id,
                    'facility_id' : facility_id,
                    'return_type' : 'exchange',
                    'status' : 'EXECUTED'
                };
            $this.attr('disabled','disabled');
            $.ajax({
                url : $('#WEB_ROOT').val() + 'purchaseCommit/getSupplierReturnList',
                type : 'GET',
                data : data,
                dataType : 'json',
                beforeSend : function(){
                    $this.attr('placeholder','正在获取数据...');
                }
            }).done(function(data){
                $this.attr('placeholder','数据获取成功');
                $this.removeAttr('disabled');
                if(data.success!='success'){
                    $this.attr('placeholder','数据为空,该条件下没有退货记录');
                    return;
                }
                $this.autocomplete(data.supplies_return_list,{
                    minChars : 0,
                    width : 310,
                    max : 100,
                    matchContains : true,
                    autoFill : false,
                    formatItem: function(row, i, max) {
                        return '['+row.supplier_return_id+']'+row.product_supplier_name;
                    },
                    formatMatch: function(row, i, max) {
                        return '['+row.supplier_return_id+']'+row.product_supplier_name;
                    },
                    formatResult: function(row) {
                        return '['+row.supplier_return_id+']'+row.product_supplier_name;
                    }
                }).result(function(event, row, formatted) {
                    var $this = $(this),   
                        $commitment_case_num = $this.closest('tr.content').find('td.commitment_case_num > input'),
                        $container_quantity = $this.closest('tr.content').find('td.container_quantity > input'),
                        $supplier = $this.closest('tr.content').find('td.supplier > input');
                        $product_supplier_id = $this.closest('tr.content').find('td.product_supplier_id'),
                        $supplier_return_id = $this.closest('tr.content').find('td.supplier_return_id'),
                        $supplier_return_ids = $('#modal_table').find('.supplier_return_id');

                    var flag = false;
                    $supplier_return_ids.each(function(){
                        if($(this).html() !== '' && $(this).html() === row.supplier_return_id){
                            flag = true;
                            return false;
                        }
                    });
                    if(flag){
                        $this.val('');
                        return;
                    }
                    $commitment_case_num.val(row.apply_quantity);
                    $commitment_case_num.attr('disabled','disabled');
                    $container_quantity.val( $('#modal_unit_code_desc').val()=='斤/箱' ? row.quantity*2 : row.quantity );
                    $container_quantity.attr('disabled','disabled');
                    $supplier.val(row.product_supplier_name);
                    $supplier.attr('disabled','disabled');
                    $product_supplier_id.html(row.product_supplier_id);
                    $supplier_return_id.html(row.supplier_return_id);
                    $this.val('['+row.supplier_return_id+']'+row.product_supplier_name);
                });
            }).fail(function(){
                alert('ajax发送失败，请联系前后端开发人员');
            });
            
        }); 
    })
    .on('change','select[name=purchase_place]',function(){
        var $this = $(this),
            $facility_id = $this.closest('tr').find('.facility_select > select');
        $facility_id.trigger('change');
    });

    //删除行
    function deltr(){
        $(this).parent().parent().remove();
    }

    function getSuppliers(){
        var postUrl = $('#WEB_ROOT').val() + 'purchaseCommit/getProductSupplierList';
        $.ajax({
            url: postUrl,
            type: 'POST',
            data: {'product_type': $('#product_type').val()},
            dataType: "json", 
            xhrFields: {
              withCredentials: true
            }
        }).done(function(data){
          if(data.success == "success"){
              productSupplierList = data.product_supplier_list;
          }else{
           }
        }).fail(function(data){
        });
    }

    function getStockUpProductList(){
        var po_id = $('#po_id').val();
        if( po_id == ''){
            return false;
        }
        var postUrl = $('#WEB_ROOT').val() + 'purchaseCommit/getStockUpProductList';
        submit = {'po_id':po_id, 'product_type':product_type};
        $.ajax({
            url: postUrl,
            type: 'POST',
            data: submit,
            dataType: "json", 
            xhrFields: {
              withCredentials: true
            }
        }).done(function(data){
          if(data.success == "success"){
              $('#stock_up_product_name').autocomplete(data.product_list, {
                    minChars: 0,
                    width: 310,
                    max: 100,
                    matchContains: true,
                    autoFill: false,
                    formatItem: function(row, i, max) {
                        return "[" + row.product_id + ']'+ row.product_name;
                    },
                    formatMatch: function(row, i, max) {
                        return row.product_id + row.product_name ;
                    },
                    formatResult: function(row) {
                        return (row.product_name);
                    }
                }).result(function(event, row, formatted) {
                    $('#stock_up_product_id').val(row.product_id);
                    $(this).val(row.product_name);
                });
          }
        }).fail(function(data){
        });
    }
    
    $(document).ready(function(){
        getSuppliers();
        getStockUpProductList();
        getAreaPurchaseManagerList();
    }) ;
    $('#change_po_btn').click(function(){
        $('#po_type').val('SECOND');
        $("form").submit();
    });
    
    /*$('#area_id').change(function(){
        $("form").submit();
    });*/
	//搜索
    var $table = null;
    var getPurchaseOrderItemListAjax = null;
    createTableHtml();
    $('#area_id').on('change',function(){
        var area_id = $(this).val(),
            $showArea = $('#area_'+area_id),
            $checkbox =  $showArea.find('input:checkbox');

        $showArea.removeClass('hidden').siblings('.facility_wrap').addClass('hidden');
        $checkbox.each(function(){
            if( $(this).data('flag') === 1 ){
                $(this).prop('checked','checked');
            }
        });
        $showArea.siblings('.facility_wrap').find('input:checkbox').removeAttr('checked');
        createTableHtml();
    });
    $('#facility_ids').on('change','input:checkbox',function(){
        createTableHtml();
    });
    function createTableHtml(){
        if( $table ){
            $table.destroy();
            $table = null;
        }
        $('#po_list').find('tbody').html('');
        $('#record').find('tbody').html('');
        var area_id = $('#area_id').val(),
            po_date = $('#po_date').val(),
            po_type = $('#po_type').val(),
            product_type = $('#product_type').val(),
            $facility_ids = $('#facility_ids').find('input:checked'),
            data = {},
            facilityIdArr = [],
            $purchase_select = $('#display_div').find('select[name=purchase_place]');

        $purchase_select.html('');
        $('#display_div').find('select').not('[name=purchase_place]').remove();
        $facility_ids.each(function(){
            facilityIdArr.push( $(this).val() );
        });
        data['area_id'] = area_id;
        data['po_date'] = po_date;
        data['po_type'] = po_type;
        data['product_type'] = product_type;
        data['facility_id_list'] = facilityIdArr.join(',');

        getPurchaseOrderItemList(data).done(function(data){
            if( data.success === 'success' ){
                var product_type = $('#product_type').val(),
                    readonly = $('#is_readonly').val(),
                    str = '';
                    asnStr = '';

                $('#po_id').val( data.po_id );
                getStockUpProductList();
                $.each(data.purchase_order_item_list,function(key,val){//poitem的信息数据
                    if( this.unit_code === 'kg' && product_type === 'goods' ){
                        str += '<tr class="po_item"><td>'+this.product_id+'</td><td>'+this.product_name+'</td><td>'+(this.beginning_inventory ? this.beginning_inventory*2 : 0)+'</td><td>'+(this.unshipped_inventory ? this.unshipped_inventory*2 : 0)+'</td><td>'+(this.dminus2_inventory ? this.dminus2_inventory*2 : 0)+'</td><td>'+(this.dminus1_inventory ? this.dminus1_inventory*2 : 0)+'</td><td>'+(this.estimated_inventory ? this.estimated_inventory*2 : 0)+'</td><td>'+(this.plan_inventory ? this.plan_inventory*2 : 0)+'</td><td>'+(this.commitment_inventory ? this.commitment_inventory*2 : 0)+'</td><td>'+(this.finish_inventory ? this.finish_inventory*2 : 0)+'</td><td>斤</td><td hidden="true"><input type="hidden" id="po_item_id" value="'+(this.po_item_id ? this.po_item_id : '')+'" ></td>';
                        if( po_type === 'SECOND' && (!readonly) ){
                            str += '<td><input id="add_record_btn_'+key+'" type="button" class="btn '+(this.commitment_inventory&&this.commitment_inventory!=0.00 ? 'btn-warning' : 'btn-primary')+'" value="添加" onclick="detail_modal('+this.product_id+',\''+this.product_name+'\',\''+this.unit_code+'\',\''+this.po_item_id+'\',\''+key+'\')" /></td>';
                        }
                        str += '</tr>';
                    }else{
                        str += '<tr class="po_item"><td>'+this.product_id+'</td><td>'+this.product_name+'</td><td>'+(this.beginning_inventory ? this.beginning_inventory : 0)+'</td><td>'+(this.unshipped_inventory ? this.unshipped_inventory : 0)+'</td><td>'+(this.dminus2_inventory ? this.dminus2_inventory : 0)+'</td><td>'+(this.dminus1_inventory ? this.dminus1_inventory : 0)+'</td><td>'+(this.estimated_inventory ? this.estimated_inventory : 0)+'</td><td>'+(this.plan_inventory ? this.plan_inventory : 0)+'</td><td>'+(this.commitment_inventory ? this.commitment_inventory : 0)+'</td><td>'+(this.finish_inventory ? this.finish_inventory : 0)+'</td><td>'+(this.unit_code ? this.unit_code : '')+'</td><td hidden="true"><input type="hidden" id="po_item_id" value="'+(this.po_item_id ? this.po_item_id : '')+'" ></td>';
                        if( po_type === 'SECOND' && !readonly ){
                            str += '<td><input id="add_record_btn_'+key+'" type="button" class="btn '+(this.commitment_inventory&&this.commitment_inventory!=0.00 ? 'btn-warning' : 'btn-primary')+'" value="添加" onclick="detail_modal('+this.product_id+',\''+this.product_name+'\',\''+this.unit_code+'\',\''+this.po_item_id+'\',\''+key+'\')" /></td>';
                        }
                        str += '</tr>';
                    }
                });
                
                var asn_item_list = data.asn_item_list;

                $.each(asn_item_list,function(key,val){
                    if( $.inArray(this.facility_id,facilityIdArr) == -1 ){
                        asnStr += '<tr class="hidden">';
                    }else{
                        asnStr += '<tr>';
                    }
                    if( this.unit_code === 'kg' && product_type === 'goods' ){//asnitem的数据
                        asnStr += '<td>'+this.product_id+'</td><td>'+(this.product_name ? this.product_name : '')+'</td><td>'+(this.product_supplier_name ? this.product_supplier_name : '')+'</td><td>'+(this.facility_name ? this.facility_name : '')+'</td><td class="facility_id hidden">'+(this.facility_id ? this.facility_id : '')+'</td><td class="purchase_place_id hidden">'+(this.purchase_place_id ? this.purchase_place_id : '')+'</td><td class="purchase_place_name">'+(this.purchase_place_name ? this.purchase_place_name : '')+'</td><td>'+(this.commitment_case_num ? this.commitment_case_num-this.replenish_case_num : 0)+'</td><td>'+(this.quantity ? this.quantity*2 : 0)+'</td><td>斤</td>';
                        if( po_type === 'SECOND' && !readonly ){
                            asnStr += '<td><input id="remove_record_btn_'+key+'" type="button" class="btn btn-danger" value="删除" onclick="remove_asn_item('+this.asn_item_id+','+this.facility_id+','+this.purchase_place_id+')" /></td>';
                        }
                    }else if( this.unit_code !== 'kg' && product_type === 'goods' ){
                        asnStr += '<td>'+this.product_id+'</td><td>'+(this.product_name ? this.product_name : '')+'</td><td>'+(this.product_supplier_name ? this.product_supplier_name : '')+'</td><td>'+(this.facility_name ? this.facility_name : '')+'</td><td class="facility_id hidden">'+(this.facility_id ? this.facility_id : '')+'</td><td class="purchase_place_id hidden">'+(this.purchase_place_id ? this.purchase_place_id : '')+'</td><td class="purchase_place_name">'+(this.purchase_place_name ? this.purchase_place_name : '')+'</td><td>'+(this.commitment_case_num ? this.commitment_case_num-this.replenish_case_num : 0)+'</td><td>'+(this.quantity ? this.quantity : 0)+'</td><td>'+(this.unit_code ? this.unit_code : '')+'</td>';
                        if( po_type === 'SECOND' && !readonly ){
                            asnStr += '<td><input id="remove_record_btn_'+key+'" type="button" class="btn btn-danger" value="删除" onclick="remove_asn_item('+this.asn_item_id+','+this.facility_id+','+this.purchase_place_id+')" /></td>';
                        }
                    }else{
                        asnStr += '<td>'+this.product_id+'</td><td>'+(this.product_name ? this.product_name : '')+'</td><td>'+(this.product_supplier_name ? this.product_supplier_name : '')+'</td><td>'+(this.facility_name ? this.facility_name : '')+'</td><td class="facility_id hidden">'+(this.facility_id ? this.facility_id : '')+'</td><td class="purchase_place_id hidden">'+(this.purchase_place_id ? this.purchase_place_id : '')+'</td><td class="purchase_place_name hidden">'+(this.purchase_place_name ? this.purchase_place_name : '')+'</td><td>'+(this.commitment_case_num ? this.commitment_case_num-this.replenish_case_num : 0)+'</td><td>'+(this.quantity ? this.quantity : 0)+'</td><td>'+(this.unit_code ? this.unit_code : '')+'</td>';
                        if( po_type === 'SECOND' && !readonly ){
                            asnStr += '<td><input id="remove_record_btn_'+key+'" type="button" class="btn btn-danger" value="删除" onclick="remove_asn_item('+this.asn_item_id+','+this.facility_id+',\'\')" /></td>';
                        }
                    }
                    asnStr += '</tr>';
                });
                $('#record').find('tbody').html( asnStr );

                $('#po_list').find('tbody').html(str);
                
                $table = $('#po_list').DataTable(
                    {
                        dom: 'lBfrtip',
                        "columnDefs": [
                            {
                                 "searchable": false, 
                                 "targets": [2,3,4,5,6,7,8,9,10] 
                            }
                        ],
                        buttons: [
                            
                        ],
                        "bDestroy": true,
                        "aaSorting": [
                            [ 1, "desc" ]
                        ],
                        language: {
                            "url": "<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/Chinese.lang"
                        },
                        aLengthMenu: [[20, 10, 50, -1], [20, 10, 50, "所有"]], 
                        scrollY: '100%',
                        scrollX: '100%'
                });

                var purchase_place_list = data.purchase_place_facility_list;

                $.each(purchase_place_list,function(key,val){
                    this.facility_list =  mixed(this.facility_list,facilityIdArr,'facility_id');
                });
                var purchaseSelectStr = '<option></option>';
                $.each(purchase_place_list,function(){
                    purchaseSelectStr += '<option value="'+this.purchase_place_id+'">'+this.purchase_place_name+'</option>';
                });
                $purchase_select.html(purchaseSelectStr);
                var facilitySelectStr = '<select id="of_purchase_"></select>';
                $.each(purchase_place_list,function(){
                    var self = this;
                    facilitySelectStr += '<select id="of_purchase_'+self.purchase_place_id+'">';
                    if( self.facility_list.length == 1 ){
                        facilitySelectStr += '<option value="'+self.facility_list[0]['facility_id']+'">'+self.facility_list[0]['facility_name']+'</option>';
                    }else{
                        facilitySelectStr += '<option value=""></option>';
                        $.each(self.facility_list,function(){
                            facilitySelectStr += '<option value="'+this.facility_id+'">'+this.facility_name+'</option>';
                        });
                    }
                    facilitySelectStr += '</select>';
                });
                $('#display_div').html( $('#display_div').html()+facilitySelectStr );
            }else{
                alert(data.error_info);
            }
        });
    }

    function mixed(list,arr,attr){//求交集，参数依次为数据list，需要作比较的字段数组，比较的字段
        var result = [];
        $.each(list,function(){
            var tempAttr = this[attr];
            if( $.inArray(tempAttr,arr) != -1 ){
                result.push(this);
            }
        });  
        return result;         
    }
        
    function getPurchaseOrderItemList(data){
        if( getPurchaseOrderItemListAjax ){
            getPurchaseOrderItemListAjax.abort();
        }
        getPurchaseOrderItemListAjax = $.ajax({
            url : '<?php echo $WEB_ROOT; ?>PurchaseCommit/getPurchaseOrderItemList',
            type : 'GET',
            data : data,
            dataType : 'json'
        }).fail(function(xhr){
            if( $table ){
                $table = null;
            }
            if( xhr.statusText !== 'abort' ){
                alert(xhr.statusText+':获取采购计划列表请求失败');
            }
        });
        return getPurchaseOrderItemListAjax;
    }
    $('#modal_table').on('change','select[name=purchase_place]',function(){
        var $this = $(this),
            purchase_place_id = $.trim( $this.val() ),
            $facilitySelectStr = $('#of_purchase_'+purchase_place_id).clone();
        $this.closest('tr').find('.facility_select').html('');
        $this.closest('tr').find('.facility_select').append($facilitySelectStr);
    });

    var old_num = 0.000;
    $('#modal_table').keyup(function(e){

        var item = $(e.target);
        var tag_class = item.attr('class');
        if(tag_class=='container_number')
        {
            var value = item.val();
            var p = /^-?\d+\.?\d{0,3}$/;
            if(!p.test(value) && value != ''){
                item.val(old_num);
                return;
            }
            old_num = value;
        }
    });


</script>
</body>
</html>