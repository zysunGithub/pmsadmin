<!doctype html>
<html>
<head>
	<meta charset="UTF-8"/>
	<title>拼好货WMS</title>
	<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/order.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
</head>
<body>
<div style="width: 80%;margin: 0 auto;">
	<a href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>transferList" class="btn btn-primary btn-sm">返回列表</a>
	<table class="table table-striped table-bordered ">
		<thead>
			<th>ID</th>
			<th>原仓库</th>
			<th>目的仓库</th>
            <th>PRODUCT_ID</th>
			<th>商品</th>
			<th>运单号</th>
			<th>原快递方式</th>
			<th>目的快递方式</th>
			<th>原状态</th>
			<th>目的状态</th>
			<th>快递面单号</th>
		</thead>
		<tbody>
			<?php 
				if(isset($transfer_items_list)){
					foreach ($transfer_items_list as $transfer_items){
						echo "<tr>";
						echo "<td>".$transfer_items['transfer_shipment_id']."</td>";
						echo "<td>".$transfer_items['from_facility_name']."</td>";
						echo "<td>".$transfer_items['to_facility_name']."</td>";
                        echo "<td>".$transfer_items['product_id']."</td>";
						echo "<td>".$transfer_items['product_name']."</td>";
						echo "<td>".$transfer_items['shipment_id']."</td>";
						echo "<td>".$transfer_items['from_shipping_name']."</td>";
						echo "<td>".$transfer_items['to_shipping_name']."</td>";
						echo "<td>".$transfer_items['from_status']."</td>";
						echo "<td>".$transfer_items['to_status']."</td>";
						echo "<td>".$transfer_items['tracking_number']."</td>";
						echo "</tr>";
					}
				}
			?>
		</tbody>
	</table>
</body>
</html>
