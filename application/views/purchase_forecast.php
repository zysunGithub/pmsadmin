<!doctype html>
<html>

<head>
    <title>采购预估</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="Pragma" content="no-cache">   
    <meta http-equiv="Cache-Control" content="no-store">
    <meta http-equiv="Expires" content="0">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT ; ?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT ; ?>assets/css/global.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/lhgcalendar.css"/>
    <!--[if lt IE 9]>
            <script src="http://assets.yqphh.com/assets/js/html5shiv.min-3.7.2.js"></script>
        <![endif]-->
    <style type="text/css">
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
		<input type="hidden" id="asn_id"  <?php if(isset($asn_id)) echo "value={$asn_id}"; ?> >
			<div class="tab-content">
				<div class="row col-sm-12 col-sm-offset-0" style="margin-top: 10px;">
					<form style="width:100%;" method="post" action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>PurchaseForecast">
					<div class="row">
					<label for="facility_id">仓库：</label>
					<select style="width:12%; height: 30px" id="facility_id" name="facility_id" >
                                <?php foreach ( $facility_list as $facility ) {
									if (isset( $facility_id ) && $facility ['facility_id'] == $facility_id) {
										echo "<option value=\"{$facility['facility_id']}\" selected='true'>{$facility['facility_name']}</option>";
									} else {
										echo "<option value=\"{$facility['facility_id']}\">{$facility['facility_name']}</option>";
									}
								} ?>
                    </select>
					</div>
					</form>
					<div id="myPrintArea">
					<div class='row' style="font-size: 15px;color: blue;">注意：所有数据都已转换成ge或斤， 总数是否加上（D0未发货公司单量）每日可能不一样，请看仔细</div>
					<div class='row' style="font-size: 15px;color: red">D0期初库存：当日截止04:50库存数</div>
					<div class='row' style="font-size: 15px;color: red">D0未发货单量：当日截止05:00的未发货订单数.周日~周四包括家庭件和公司件.周五和周六只包含家庭件.</div>
					<div class='row' style="font-size: 15px;color: red">D0未发货公司单量：当日截止05:00的未发货公司即时订单数</div>
					<div class='row' style="font-size: 15px;color: red">D0当日进货量(已录装车单)：当日05:00至此刻，已录装车单数量，如果装车单未入库，取发车数量，如果装车单已入库，取入库数量</div>
					<div class='row' style="font-size: 15px;color: red">D0当日进货量(未录装车单)： 今日还会采购，未录装车单的数量</div>
					<div class='row' style="font-size: 15px;color: red">D0即时订单量：当日05:00至此刻产生的订单量</div>
					<div class='row' style="font-size: 15px;color: red">D0订单量(预估)：此刻至24:00预估产生的订单量</div>
					<div class='row' style="font-size: 15px;color: red">D1订单量(预估)：明日00:00至明日<?php if(isset($fulfill_end_time)) echo $fulfill_end_time;?>预估产生的订单量</div>
					<div class='row' style="font-size: 15px;color: red">D0订单转仓：今日05:00至此刻创建的转仓单，成团时间今日05:00之前的订单转仓数量。转出为-，转入为+</div>
					<div class='row' style="font-size: 15px;color: red">D0库存调拨：今日05:00至此刻创建的调拨，转出为-，转入为+</div>
					<div class='row' style="font-size: 15px;color: red">
					<?php if($add_weekend_order == 1) {?>
					总数=D0未发货单量+D0即时订单量+D0订单量(预估)+D1订单量(预估)+D0订单转仓-D0期初库存-D0当日进货量(已录装车单)-D0当日进货量(未录装车单)-库存调拨+D0未发货公司单量
					<?php } else {?>
					总数=D0未发货单量+D0即时订单量+D0订单量(预估)+D1订单量(预估)+D0订单转仓-D0期初库存-D0当日进货量(已录装车单)-D0当日进货量(未录装车单)-库存调拨
					<?php }?>
					</div>
					<div><label for="today_order2_coefficient_batch">D0订单量(预估)系数批量设置:</label>
						<input type="number" id="today_order2_coefficient_batch" name="today_order2_coefficient_batch" placeholder="输入系数后回车">
					</div>
					<div>
						<label for="tomorrow_order_coefficient_batch">D1订单量(预估)系数批量设置:</label>
						<input type="number" id="tomorrow_order_coefficient_batch" name="tomorrow_order_coefficient_batch" placeholder="输入系数后回车">
					</div>
					<table id="pf_item_table" class="table table-striped table-bordered "  style="width:100%" >
						<tr>
			            	<th>PRODUCT_ID</th>
			                <th width="10%">商品</th>
			                <th width="5%">D0期初库存</th>
			                <th width="5%">D0未发货单量</th>
			                <th width="5%">D0未发货公司单量</th>
			                <th width="5%">D0当日进货量(已录装车单)</th>
			                <th width="5%">D0当日进货量(未录装车单)</th>
							<th width="7%">D0即时订单量</th>
							<th width="4%" colspan="2">D0订单量(预估)</th>
							<th width="8%" colspan="2">D1订单量(预估)</th>
							<th width="8%">D0订单转仓</th>
							<th width="8%">D0库存调拨</th>
							<th width="3%">总数</th>
							<th width="3%">单位</th>
						</tr>
						<?php if( isset($init_item_list) && is_array($init_item_list))  foreach ($init_item_list as $key => $init_item) { ?> 
						<?php if($init_item['unit_code'] == 'kg') {?>
			            <tr class="content">
			                <td><?php echo !empty($key)?$key:'' ?></td>
			                <td class="product_name"><?php echo !empty($init_item['product_name'])?$init_item['product_name']:'' ?></td>
			                <td class="beginning_inventory"><?php echo !empty($init_item['beginning_inventory'])?$init_item['beginning_inventory']*2:0 ?></td>
			                <td class="unshipped_inventory"><?php echo !empty($init_item['unshipped_inventory'])?$init_item['unshipped_inventory']*2:0 ?></td>
			                <td class="unshipped_work_inventory"><?php echo !empty($init_item['unshipped_work_inventory'])?$init_item['unshipped_work_inventory']*2:0 ?></td>
			                <td class="today_purchase"><?php echo !empty($init_item['today_purchase'])?$init_item['today_purchase']*2:0 ?></td>
			                <td class="today_purchase2" style="padding-left: 0px;padding-right: 0px"><input style="width:100px" type="number" id="today_purchase2" value='0' class="today_purchase2"></td>
			                <td class="today_order"><?php echo !empty($init_item['today_order'])?$init_item['today_order']*2:0 ?></td>
			                <td class="today_order2_coefficient" style="padding-left: 0px;padding-right: 0px"><input style="width:50px" type="number" id="today_order2_coefficient" value='0' class="today_order2_coefficient"></td>
			                <td class="today_order2" style="padding-left: 0px;padding-right: 0px"><input style="width:100px" type="number" id="today_order2" value='0' class="today_order2"></td>
			                <td class="tomorrow_order_coefficient" style="padding-left: 0px;padding-right: 0px"><input style="width:50px" type="number" id="tomorrow_order_coefficient" value='0' class="tomorrow_order_coefficient"></td>
			                <td class="tomorrow_order" style="padding-left: 0px;padding-right: 0px"><input style="width:100px" type="number" id="tomorrow_order" value='0' class="tomorrow_order"></td>
			                <td class="transfer_shipment"><?php echo !empty($init_item['transfer_shipment'])?$init_item['transfer_shipment']*2:0 ?></td>
			                <td class="transfer_inventory"><?php echo !empty($init_item['transfer_inventory'])?$init_item['transfer_inventory']*2:0 ?></td>
			                <td class='total_inventory'><?php echo !empty($init_item['total_inventory'])?$init_item['total_inventory']*2:0 ?></td>
			                <td class='unit_code'>斤</td>
						</tr>
						<?php } else {?>
						 <tr class="content">
			                <td><?php echo !empty($key)?$key:'' ?></td>
			                <td class="product_name"><?php echo !empty($init_item['product_name'])?$init_item['product_name']:'' ?></td>
			                <td class="beginning_inventory"><?php echo !empty($init_item['beginning_inventory'])?$init_item['beginning_inventory']:0 ?></td>
			                <td class="unshipped_inventory"><?php echo !empty($init_item['unshipped_inventory'])?$init_item['unshipped_inventory']:0 ?></td>
			                <td class="unshipped_work_inventory"><?php echo !empty($init_item['unshipped_work_inventory'])?$init_item['unshipped_work_inventory']:0 ?></td>
			                <td class="today_purchase"><?php echo !empty($init_item['today_purchase'])?$init_item['today_purchase']:0 ?></td>
			                <td class="today_purchase2" style="padding-left: 0px;padding-right: 0px"><input style="width:100px" type="number" id="today_purchase2" value='0' class="today_purchase2"></td>
			                <td class="today_order"><?php echo !empty($init_item['today_order'])?$init_item['today_order']:0 ?></td>
			                <td class="today_order2_coefficient" style="padding-left: 0px;padding-right: 0px"><input style="width:50px" type="number" id="today_order2_coefficient" value='0' class="today_order2_coefficient"></td>
			                <td class="today_order2" style="padding-left: 0px;padding-right: 0px"><input style="width:100px" type="number" id="today_order2" value='0' class="today_order2"></td>
			                <td class="tomorrow_order_coefficient" style="padding-left: 0px;padding-right: 0px"><input style="width:50px" type="number" id="tomorrow_order_coefficient" value='0' class="tomorrow_order_coefficient"></td>
			                <td class="tomorrow_order" style="padding-left: 0px;padding-right: 0px"><input style="width:100px" type="number" id="tomorrow_order" value='0' class="tomorrow_order"></td>
			                <td class="transfer_shipment"><?php echo !empty($init_item['transfer_shipment'])?$init_item['transfer_shipment']:0 ?></td>
			                <td class="transfer_inventory"><?php echo !empty($init_item['transfer_inventory'])?$init_item['transfer_inventory']:0 ?></td>
			                <td class='total_inventory'><?php echo !empty($init_item['total_inventory'])?$init_item['total_inventory']:0 ?></td>
			                <td class='unit_code'><?php echo !empty($init_item['unit_code'])?$init_item['unit_code']:'' ?></td>
						</tr>
						<?php }?>
	      				<?php }?>
      				</table>
      				</div>
	                    <div style="position: relative">
							<button class="btn btn-primary" id="add_purchase_forecast" style="float: left">
	            				<i class="fa fa-check"></i>保存
	        				</button>
	        			</div>
    				
    			</div>
    		</div>
    	</div>
    </div>
</div>
    <script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
	<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/lhgcalendar.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		$('#pf_item_table tr.content').each(function(){
			beginning_inventory = parseFloat($(this).find('td.beginning_inventory').html());
			unshipped_inventory = parseFloat($(this).find('td.unshipped_inventory').html());
			unshipped_work_inventory = parseFloat($(this).find('td.unshipped_work_inventory').html());
			today_purchase = parseFloat($(this).find('td.today_purchase').html());
			today_order = parseFloat($(this).find('td.today_order').html());
			transfer_inventory = parseFloat($(this).find('td.transfer_inventory').html());
			transfer_shipment = parseFloat($(this).find('td.transfer_shipment').html());
			total = unshipped_inventory - beginning_inventory - today_purchase +
			today_order - transfer_inventory + transfer_shipment;
			
			<?php if($add_weekend_order == 1) {?>
				total = total + unshipped_work_inventory;
			<?php }?>
			$(this).find('td.total_inventory').html(total);
		});
	}) ;

	$(".today_order2_coefficient").on('input',function(e){
		if($(this).val() == ''){
			return;
		}
		if(isNaN($(this).val())){
			return;
		}
		today_order = $(this).parent('td').prev().html();
		today_order2 = today_order * $(this).val();
		input = $(this).parent('td').next().find('input');
		input.val(today_order2.toFixed(2));
		changeTotalInventory($(this).parent('td').parent('tr'));
	});
	$(".tomorrow_order_coefficient").on('input',function(e){
		if($(this).val() == ''){
			return;
		}
		if(isNaN($(this).val())){
			return;
		}
		today_order = $(this).parent('td').prev().prev().prev().html();
		today_tomorrow = today_order * $(this).val();
		input = $(this).parent('td').next().find('input');
		input.val(today_tomorrow.toFixed(2));
		changeTotalInventory($(this).parent('td').parent('tr'));
	});

	$(".today_purchase2").on('input',function(e){
		if($(this).val() == ''){
			return;
		}
		if(isNaN($(this).val())){
			return;
		}
		changeTotalInventory($(this).parent('td').parent('tr'));
	}); 
	$(".today_order2").on('input',function(e){
		if($(this).val() == ''){
			return;
		}
		if(isNaN($(this).val())){
			return;
		}
		changeTotalInventory($(this).parent('td').parent('tr'));
	});
	$(".tomorrow_order").on('input',function(e){
		if($(this).val() == ''){
			return;
		}
		if(isNaN($(this).val())){
			return;
		}
		changeTotalInventory($(this).parent('td').parent('tr'));
	});
	function changeTotalInventory(tr){
		beginning_inventory = parseFloat(tr.find('td.beginning_inventory').html());
		unshipped_inventory = parseFloat(tr.find('td.unshipped_inventory').html());
		unshipped_work_inventory = parseFloat(tr.find('td.unshipped_work_inventory').html());
		today_purchase = parseFloat(tr.find('td.today_purchase').html());
		today_purchase2 = parseFloat(tr.find('td.today_purchase2').find('input').val());
		today_order = parseFloat(tr.find('td.today_order').html());
		today_order2 = parseFloat(tr.find('td.today_order2').find('input').val());
		tomorrow_order = parseFloat(tr.find('td.tomorrow_order').find('input').val());
		transfer_shipment = parseFloat(tr.find('td.transfer_shipment').html());
		transfer_inventory = parseFloat(tr.find('td.transfer_inventory').html());

		total = unshipped_inventory - beginning_inventory - today_purchase - today_purchase2 +
				today_order + today_order2 + tomorrow_order - transfer_inventory + transfer_shipment;
		if(new Date().getDay()==6) {
			total = total + unshipped_work_inventory;
		}
		tr.find('td.total_inventory').html(total.toFixed(2));
	}

	$('#add_purchase_forecast').click(function(){
		facility_id = $('#facility_id').val();
		var pf_items = new Array();
		available = true;
		$('#pf_item_table tr.content').each(function(){
			product_id = $(this).find('td').eq(0).html();
			beginning_inventory = parseFloat($(this).find('td.beginning_inventory').html());
			unshipped_inventory = parseFloat($(this).find('td.unshipped_inventory').html());
			unshipped_work_inventory = parseFloat($(this).find('td.unshipped_work_inventory').html());
			today_purchase = parseFloat($(this).find('td.today_purchase').html());
			today_purchase2 = parseFloat($(this).find('td.today_purchase2').find('input').val());
			today_order = parseFloat($(this).find('td.today_order').html());
			today_order2_coefficient = parseFloat($(this).find('td.today_order2_coefficient').find('input').val());
			today_order2 = parseFloat($(this).find('td.today_order2').find('input').val());
			tomorrow_order_coefficient = parseFloat($(this).find('td.tomorrow_order_coefficient').find('input').val());
			tomorrow_order = parseFloat($(this).find('td.tomorrow_order').find('input').val());
			transfer_shipment = parseFloat($(this).find('td.transfer_shipment').html());
			transfer_inventory = parseFloat($(this).find('td.transfer_inventory').html());
			total_inventory = parseFloat($(this).find('td.total_inventory').html());
			unit_code = $(this).find('td.unit_code').html();
			
			if(product_id == ''){
				alert('获取商品失败');
				available = false;
				return false;
			}
			if(isNaN(today_purchase2)){
				alert('今日采购未录装车单不能为空或非数字');
				available = false;
				return false;
			}
			if(isNaN(today_order2_coefficient)){
				alert('今日预估订单系数不能为空或非数字');
				available = false;
				return false;
			}
			if(isNaN(today_order2)){
				alert('今日预估订单不能为空或非数字');
				available = false;
				return false;
			}
			if(isNaN(tomorrow_order_coefficient)){
				alert('明日截止16点预估订单系数不能为空或非数字');
				available = false;
				return false;
			}
			if(isNaN(tomorrow_order)){
				alert('明日截止16点预估订单不能为空或非数字');
				available = false;
				return false;
			}
			if(unit_code == '斤'){
				beginning_inventory = beginning_inventory/2;
			   	unshipped_inventory = unshipped_inventory/2;
			    today_purchase = today_purchase/2;
			   	today_purchase2 = today_purchase2/2;
			   	today_order = today_order/2;
			   	today_order2 = today_order2/2;
			   	tomorrow_order = tomorrow_order/2;
			   	transfer_shipment = transfer_shipment/2;
			   	transfer_inventory = transfer_inventory/2;
			   	unshipped_work_inventory = unshipped_work_inventory/2;
			   	total_inventory = total_inventory/2;
			}
			
			var pf_item = {
		   			"product_id":product_id,
				   	"beginning_inventory":beginning_inventory,
				   	"unshipped_inventory":unshipped_inventory,
				   	"today_purchase":today_purchase,
				   	"today_purchase2":today_purchase2,
				   	"today_order":today_order,
				   	"today_order2":today_order2,
				   	"today_order2_coefficient":today_order2_coefficient,
				   	"tomorrow_order":tomorrow_order,
				   	"tomorrow_order_coefficient":tomorrow_order_coefficient,
				   	"transfer_shipment":transfer_shipment,
				   	"transfer_inventory":transfer_inventory,
				   	"unshipped_work_inventory":unshipped_work_inventory,
				   	"total_inventory":total_inventory
				};
			pf_items.push(pf_item);
		});
		if(pf_items.length == 0){
			alert('没有可保存数据');
			return false;
		}

		if(available == false) {
			return false;
		}

		var submit_data = {
					"facility_id":facility_id,
					"pf_items":pf_items
				};
		var cf=confirm('是否保存');
		if (cf==false)
			return false;
		
		var postUrl = $('#WEB_ROOT').val() + 'PurchaseForecast/addPurchaseForecast';
		console.log( postUrl );
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
		      alert("保存成功");
		      $('#add_purchase_forecast').removeAttr('disabled');
	      }else{
	          alert(data.error_info);
	          $('#add_purchase_forecast').removeAttr('disabled');
	        }
	    }).fail(function(data){
		     alert('保存失败');
	    	 $('#add_purchase_forecast').removeAttr('disabled');
	    });
	    $('#add_purchase_forecast').attr('disabled',"true");
	});

	$('#facility_id').change(function(){
		$('form').submit();
	});

	$('#today_order2_coefficient_batch').bind('keypress',function(event){
        if(event.keyCode == "13")    
        {
            coeffiecient_key = $(this).val();
        	if($(this).val() == ''){
    			return;
    		}
    		if(isNaN($(this).val())){
    			return;
    		}
    		$('#pf_item_table tr.content').each(function(){
    			$(this).find('td.today_order2_coefficient').find('input').val(coeffiecient_key);
    			today_order = $(this).find('td.today_order').html();
    			today_order2 = today_order * coeffiecient_key;
    			$(this).find('td.today_order2').find('input').val(today_order2.toFixed(2));
    			
    			changeTotalInventory($(this));
    	    });
        }
    });

	$('#tomorrow_order_coefficient_batch').bind('keypress',function(event){
        if(event.keyCode == "13")    
        {
            coeffiecient_key = $(this).val();
        	if($(this).val() == ''){
    			return;
    		}
    		if(isNaN($(this).val())){
    			return;
    		}
    		$('#pf_item_table tr.content').each(function(){
    			$(this).find('td.tomorrow_order_coefficient').find('input').val(coeffiecient_key);
				today_order = $(this).find('td.today_order').html();
				today_tomorrow = today_order * coeffiecient_key;
    			$(this).find('td.tomorrow_order').find('input').val(today_tomorrow.toFixed(2));
    			
    			
    			changeTotalInventory($(this));
    	    });
        }
    });
	
	</script>
</body>
</html>