<!doctype html>
<html>
<head>
<title>异常订单</title>
<meta charset="utf-8">
<meta name="viewport"
	content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="format-detection" content="telephone=no">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-store">
<meta http-equiv="Expires" content="0">
<link rel="stylesheet"
	href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
<link rel="stylesheet"
	href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">	
<link rel="stylesheet"
	href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/order.css">	
<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/autocomplete.css">
<link rel="stylesheet"
	href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet"
	href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
<!--[if lt IE 9]>
<script src="http://assets.yqphh.com/assets/js/html5shiv.min-3.7.2.js"></script>
<![endif]-->
<style type="text/css">
</style>
</head>
<body id="main">
<div id="loadding"><img src="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/img/loadding.gif"></div>
	<div class="container">
		<input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> >
		<div class="row  col-sm-10 " style="margin-top: 10px;">
            <table class="table table-striped table-bordered detail-table">
                <thead>
                    <tr>
                    	<th>订单号</th>
                    	<th>成团时间</th>
                    	<th>流转到wms时间</th>
                        <th> goods_id </th>
                        <th> goods_name </th>
                        <th> product_id </th>
                        <th> product_name </th>                                
                    </tr>
                </thead>
                <tbody>
                                	
                </tbody>
            </table>
            
		</div>
	<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
	<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<script type="text/javascript">
	var WEB_ROOT = "<?php if(isset($WEB_ROOT)) echo $WEB_ROOT; ?>";
	var abnormal_shipment_type = "<?php if(isset($abnormal_shipment_type)) echo $abnormal_shipment_type; ?>";
	var goods_id = "<?php if(isset($goods_id)) echo $goods_id; ?>";
	var product_id = "<?php if(isset($product_id)) echo $product_id; ?>";
	var city_id = "<?php if(isset($city_id)) echo $city_id; ?>";
	var facility_id = "<?php if(isset($facility_id)) echo $facility_id; ?>";
	var district_id = "<?php if(isset($district_id)) echo $district_id; ?>";
	function getDetail(){
		var postUrl = $("#WEB_ROOT").val() + 'AbnormalShipment/getDetailData';
		var submit_data = {
			'abnormal_shipment_type': abnormal_shipment_type
		};
		if(goods_id != ''){
			submit_data.goods_id = goods_id;
		}
		if(product_id != ''){
			submit_data.product_id = product_id;
		}
		if(city_id != ''){
			submit_data.city_id = city_id;
		}
		if(facility_id != ''){
			submit_data.facility_id = facility_id;
		}
		if(district_id != ''){
			submit_data.district_id = district_id;
		}
		console.log(submit_data);
		$.ajax({
			url: postUrl,
			type: 'GET',
			data: submit_data,
			dataType: "json",
			xhrFields: {
				withCredentials: true
			}
		}).done(function(data) {
			console.log(data);
			$("#loadding").remove();
			if (data.result == "ok") {
				var html = '';
				if(data.data.length == 0){
					return false;
				}
				$.each(data.data,function(index,elem){
					html +="<tr><td>"+elem.shipment_id+"</td><td>"+elem.confirm_time+"</td><td>"+elem.created_time+"</td><td>"+elem.goods_id+"</td><td>"+elem.goods_name+"</td><td>"+elem.product_id+"</td><td>"+elem.product_name+"</td></tr>";
				});
				$(".detail-table tbody").empty().append(html);
			} else {
				alert("失败。" + data.error_info);
			}
		});
	}


	$(function() {
		getDetail();

	});
</script>
</body>
