<!doctype html>
<html>
<head>
<meta charset="UTF-8" />
<title>拼好货WMS</title>
<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/buttons.dataTables.css">
<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/autocomplete.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.0.0/css/fixedHeader.bootstrap.min.css">
<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
<style>
form .form-group { margin-right: 20px; margin-bottom: 10px !important; margin-top: 10px; }
</style>
</head>
<body>
	<form style="width:1000px;" class="form-inline center-block" role="form" method="get" action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>product/query">
		<div class="form-group">
			<label class="control-label">类型：
				<select class="form-control input-sm" id="product_type" name="product_type" required="required">
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
           </label>
        </div>
        <div class="form-group">
            <label class="control-label">子类型：
	            <select class="form-control" id="product_sub_type" name="product_sub_type">
					<option value="raw_material" <?php if (isset($product_sub_type) && $product_sub_type == "raw_material") echo "selected = true";?>>原材料</option>
					<option value="finished" <?php if (isset($product_sub_type) && $product_sub_type == "finished") echo "selected = true";?>>成品</option>
				</select> 
			</label>
		</div>
		<div class="form-group">
            <label class="control-label">产品状态：
	            <select class="form-control" id="product_status" name="product_status">
	            	<option value="OK" <?php if (isset($product_status) && $product_status == "OK") echo "selected = true";?>>已审核</option>
					<option value="INIT" <?php if (isset($product_status) && $product_status == "INIT") echo "selected = true";?>>未审核</option>
				</select> 
			</label>
		</div>
		</br>
		<div class="form-group">
			<label class="control-label">PRODUCT_ID：
				<input class="form-control" type="text" id="product_id" name="product_id" value="<?php if(!empty($product_id)){echo $product_id;}?>" />
			</label>
		</div>
		<div class="form-group">
			<label class="control-label">产品名称：
				<input class="form-control" type="text" id="product_name" name="product_name" value="<?php if(!empty($product_name)){echo $product_name;}?>" />
			</label>
		</div>
		<div class="form-group">
			<input type="submit" id="query" style="float: right;" class="btn btn-primary form-control btn-search"  value="查询"> 
		</div>
	</form>
	<input type="hidden" id="WEB_ROOT" value="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>">
	<div style="width: 1000px; margin: 20px auto 0;">
		<?php  
		if( $this->helper->chechActionList(array('productEdit')) ){ ?>
			<a href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>productNew" class="btn btn-primary btn-sm"  style="float: right; height:34px" id="addProduct">添加</a>
		<?php }?>		
		<table id="product_list_table" class="table table-striped table-bordered ">
			<thead>
				<tr>
					<th width="5%">PRODUCT ID</th>
					<th width="20%">产品名称</th>
					<th width="5%">类型</th>
					<th width="7%">子类型</th>
					<th width="10%">条码</th>
					<th width="10%">仓储单位</th>
					<th width="10%">创建者</th>
					<th width="10%">创建时间</th>
					<th width="15%">备注</th>
					<th width="5%">暗语</th>
					<th width="5%">操作</th>
				</tr>
			</thead>
			<tbody>
			<?php if(isset($product_list)) { foreach($product_list as $record){?>
				<tr>
					<td class="product_id"><?php echo $record['product_id']?></td>
					<td><a href="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT ; ?>productEdit?product_id=<?php echo $record['product_id'];?>" ><?php echo $record['product_name'];?></a></td>
					<td><?php if($record['product_type'] == "goods") echo "商品"; else echo "耗材";?></td>
					<td><?php if(isset($record['product_sub_type'])){ 
						if($record['product_sub_type'] == "raw_material") 
							echo "原材料"; 
						else if($record['product_sub_type'] == "finished") 
							echo "成品";
						else 
							echo "半成品";
						}?>
					</td>
					<td><?php echo $record['barcode'];?></td>
					<td><?php
							if ($record['product_type'] == 'supplies') {
								echo $record['container_unit_code_name'];
							} else {
								echo $record['unit_code_name'];
							}
						?></td>
					<td><?php echo $record['created_user'];?></td>
					<td><?php echo $record['created_time'];?></td>
					<td><?php echo $record['note'];?></td>
					<td><?php echo $record['secrect_code'];?></td><td>
				<?php if( $product_status == 'OK' || $product_status == 'INIT' ) {?>
					<a class="btn btn-danger btn-sm remove" href="#" id="removeProduct">删除</a>
				<?php } ?>
					</td>
				</tr>
			<?php }}?>
			</tbody>
		</table>
	</div>
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/dataTables.buttons.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/buttons.colVis.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/buttons.flash.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/common.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js"></script>
<script type="text/javascript">
$('.remove').click(function(){
	btn = $(this);
	product_id = btn.parent().siblings('.product_id').html();
	var cf=confirm( '是否确认删除?' )
		
	if (cf==false)
		return ;
	
	
	btn.attr('disabled','disabled');
	
	$.ajax({
		url:"<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>product/removeProduct",
		type:"get",
		data:{"product_id":product_id},
		dataType:"json",
		xhrFields: {
            withCredentials: true
        }
	}).done(function(data){
		if(data.success == "success"){
			alert('删除成功');
			btn.parent().parent().remove();
		}
		else{
			alert(data.error_info);
			btn.removeAttr('disabled');
		}
	}).fail(function(data){
		alert('内部服务器错误');
		btn.removeAttr('disabled');
	});
});
$(document).ready(function() {
	getProductList();
	
	var table = $('#product_list_table').DataTable({
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
	    "columnDefs": [
				        {
					         "searchable": false, 
					         "targets": [2,3,4,5,7,8,9] 
					    }
				    ],
	    "aaSorting": [
			[ 0, "desc" ]
		],
	    language: {
	        "url": "<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/Chinese.lang"
	    },
	    aLengthMenu: [[20, 10, 50, -1], [20, 10, 50, "所有"]], 
		scrollY: '100%',
		scrollX: '100%',
	});	
});

function getProductList() {
	getFinishGoodsProductListUrl = $('#WEB_ROOT').val() + 'product/getProductList';
	$.ajax({
	      type: "get",
	      url: getFinishGoodsProductListUrl,
		  dataType: "json",
		  data: {"product_status": "notnull" },
	      success: function(data) {
	    	  autocom($('#product_name'), data.product_list, productNameFormat, productNameFormat, productNameFormat2)
		      	.result(function(event, row, formatted) {
			        $('#product_id').val(row.product_id);
			        $('#product_type').val(row.product_type);
			        $('#product_sub_type').val(row.product_sub_type);
			        $('#product_status').val(row.status);
			    });
	      },
	      error: function() {
	        alert('参数错误');
	      }
	});
}

function productNameFormat2(row, i, max) {
	 return row.product_name;
}

function productNameFormat(row, i, max) {
	 return row.product_id + '【' + row.product_name + '】';
}

</script>
</body>
</html>