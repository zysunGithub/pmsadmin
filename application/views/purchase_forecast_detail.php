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
        
        .cyan {
        	background: cyan;
        }
        .green {
        	background: rgb(56, 231, 151);
        }
        .red {
        	background: red;
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
					<form style="width:100%;" method="post" action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>/PurchaseForecast">
					<div class="row">
					<label>仓库：</label>
					<?php if (isset($facility_name)) echo $facility_name;?>
					<label>创建时间：</label>
					<?php if (isset($created_time)) echo $created_time;?>
					<label>创建者：</label>
					<?php if (isset($created_user)) echo $created_user;?>
					</div>
					<div id="myPrintArea">
					<div class='row' style="font-size: 15px;color: blue;">注意：所有数据都已转换成ge或斤</div>
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
					总数=D0未发货单量+D0即时订单量+D0订单量(预估)+D1订单量(预估)+D0订单转仓-D0期初库存-D0当日进货量(已录装车单)-D0当日进货量(未录装车单)-库存调拨+D0未发货公司单量(如果是周六)
					</div>
					<div class='row' style="font-size: 10px;color: red"></div>
					<div class='row' style="font-size: 10px;color: red"></div>
					<table id="pf_item_table" class="table table-striped table-bordered "  style="width:100%" >
						<tr>
			               	<th>PRODUCT_ID</th>
			                <th width="10%">商品</th>
			                <th width="5%">D0期初库存</th>
			                <th width="5%">D0未发货单量</th>
			                <th width="5%">D0未发货公司单量</th>
			                <th width="5%">D0当日进货量(已录装车单)</th>
			                <th width="5%">D0当日进货量(未录装车单)</th>
							<th width="7%">D0订单量</th>
							<th width="4%" colspan="2">D0订单量(预估)</th>
							<th width="8%" colspan="2">D1订单量(预估)</th>
							<th width="8%">D0转仓</th>
							<th width="8%">D0库存调拨</th>
							<th width="3%">总数</th>
							<th width="3%">单位</th>
						</tr>
						<?php if( isset($item_list) && is_array($item_list))  foreach ($item_list as $key => $item) { ?> 
						<?php if($item['unit_code'] == 'kg') {?>
			            <tr class="content">
			                <td><?php echo !empty($item['product_id'])?$item['product_id']:'' ?></td>
			                <td><?php echo !empty($item['product_name'])?$item['product_name']:'' ?></td>
			                <td><?php echo !empty($item['beginning_inventory'])?$item['beginning_inventory']*2:0 ?></td>
			                <td><?php echo !empty($item['unshipped_inventory'])?$item['unshipped_inventory']*2:0 ?></td>
			                <td><?php echo !empty($item['unshipped_work_inventory'])?$item['unshipped_work_inventory']*2:0 ?></td>
			                <td><?php echo !empty($item['today_purchase'])?$item['today_purchase']*2:0 ?></td>
			                <td><?php echo !empty($item['today_purchase2'])?$item['today_purchase2']*2:0 ?></td>
			                <td><?php echo !empty($item['today_order'])?$item['today_order']*2:0 ?></td>
			                <td><?php echo !empty($item['today_order2_coefficient'])?$item['today_order2_coefficient']:0 ?></td>
			                <td><?php echo !empty($item['today_order2'])?$item['today_order2']*2:0 ?></td>
			                <td><?php echo !empty($item['tomorrow_order_coefficient'])?$item['tomorrow_order_coefficient']:0 ?></td>
			                <td><?php echo !empty($item['tomorrow_order'])?$item['tomorrow_order']*2:0 ?></td>
			                <td><?php echo !empty($item['transfer_shipment'])?$item['transfer_shipment']*2:0 ?></td>
			                <td><?php echo !empty($item['transfer_inventory'])?$item['transfer_inventory']*2:0 ?></td>
			                <td class='total_inventory'><?php echo !empty($item['total_inventory'])?$item['total_inventory']*2:0 ?></td>
			                <td>斤</td>
						</tr>
						<?php } else {?>
						 <tr class="content">
			                <td><?php echo !empty($item['product_id'])?$item['product_id']:'' ?></td>
			                <td><?php echo !empty($item['product_name'])?$item['product_name']:'' ?></td>
			                <td><?php echo !empty($item['beginning_inventory'])?$item['beginning_inventory']:0 ?></td>
			                <td><?php echo !empty($item['unshipped_inventory'])?$item['unshipped_inventory']:0 ?></td>
			                <td><?php echo !empty($item['unshipped_work_inventory'])?$item['unshipped_work_inventory']:0 ?></td>
			                <td><?php echo !empty($item['today_purchase'])?$item['today_purchase']:0 ?></td>
			                <td><?php echo !empty($item['today_purchase2'])?$item['today_purchase2']:0 ?></td>
			                <td><?php echo !empty($item['today_order'])?$item['today_order']:0 ?></td>
			                <td><?php echo !empty($item['today_order2_coefficient'])?$item['today_order2_coefficient']:0 ?></td>
			                <td><?php echo !empty($item['today_order2'])?$item['today_order2']:0 ?></td>
			                <td><?php echo !empty($item['tomorrow_order_coefficient'])?$item['tomorrow_order_coefficient']:0 ?></td>
			                <td><?php echo !empty($item['tomorrow_order'])?$item['tomorrow_order']:0 ?></td>
			                <td><?php echo !empty($item['transfer_shipment'])?$item['transfer_shipment']:0 ?></td>
			                <td><?php echo !empty($item['transfer_inventory'])?$item['transfer_inventory']:0 ?></td>
			                <td class='total_inventory'><?php echo !empty($item['total_inventory'])?$item['total_inventory']:0 ?></td>
			                <td><?php echo !empty($item['unit_code'])?$item['unit_code']:'' ?></td>
						</tr>
						<?php }?>
	      				<?php }?>
      				</table>
      				</div>
    				</form>
    			</div>
    		</div>
    	</div>
    </div>
</div>
    <script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
	<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/lhgcalendar.min.js"></script>
	<script type="text/javascript">
	</script>
</body>
</html>