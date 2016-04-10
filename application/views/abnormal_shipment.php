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
			<p>1.商品档案未设置</p>
            <table class="table table-striped table-bordered commodity-table">
                <thead>
                    <tr>
                        <th> goods_id </th>
                        <th> goods_name </th>
                        <th> 数量 </th>                                 
                    </tr>
                </thead>
                <tbody>
                                	
                </tbody>
            </table>
            <p>2.仓库未选(分仓规则未设)</p>
            <table class="table table-striped table-bordered facility-table">
                <thead>
                    <tr>
                        <th> product_id </th>
                        <th> product_name </th>
                        <th> 城市名</th>
                        <th> 数量 </th>                                 
                    </tr>
                </thead>
                <tbody>
                                	
                </tbody>
            </table>
            <p>3.快递未选(分快递规则未设)</p>
            <table class="table table-striped table-bordered shipping-table">
                <thead>
                    <tr>
                        <th> product_id </th>
                        <th> product_name </th>
                        <th> 仓库名</th>
                        <th> 区域名</th>
                        <th> 数量 </th>                                 
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
	function getCommodityFileUnset(){
		var postUrl = $("#WEB_ROOT").val() + 'AbnormalShipment/getCommodityFileUnset';
		var submit_data = {
			'abnormal_shipment_type': 'commodity_file_unset'
		};
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
			if (data.result == "ok") {
				var html = '';
				if(data.data.length == 0){
					return false;
				}
				$.each(data.data,function(index,elem){
					html +="<tr><td>"+elem.goods_id+"</td><td>"+elem.goods_name+"</td><td><a target='_blank' href="+$('#WEB_ROOT').val()+"AbnormalShipment/getDetail?abnormal_shipment_type=commodity_file_unset&goods_id="+elem.goods_id+">"+elem.num+"</a></td></tr>";
				});
				$(".commodity-table tbody").empty().append(html);
			} else {
				alert("失败。" + data.error_info);
			}
		});
	}

	function getFacilityUnselect(){
		var postUrl = $("#WEB_ROOT").val() + 'AbnormalShipment/getFacilityUnselect';
		var submit_data = {
			'abnormal_shipment_type': 'facility_unselect'
		};
		$.ajax({
			url: postUrl,
			type: 'GET',
			data: submit_data,
			dataType: "json",
			xhrFields: {
				withCredentials: true
			}
		}).done(function(data) {
			if (data.result == "ok") {

				var html = '';
				if(data.data.length == 0){
					return false;
				}
				$.each(data.data,function(index,elem){
					html += "<tr><td>"+elem.product_id+"</td><td>"+elem.product_name+"</td><td>"+elem.city_name+
					"</td><td><a target='_blank' href="+$('#WEB_ROOT').val()+"AbnormalShipment/getDetail?abnormal_shipment_type=facility_unselect&product_id="+elem.product_id+"&city_id="+elem.city_id+">"+elem.num+"</a></td></tr>";
				});		
				$(".facility-table tbody").empty().append(html);
			} else {
				alert("失败。" + data.error_info);
			}
		});
	}

	function getShippingUnselect(){
		var postUrl = $("#WEB_ROOT").val() + 'AbnormalShipment/getShippingUnselect';
		var submit_data = {
			'abnormal_shipment_type': 'shipping_unselect'
		};
		$.ajax({
			url: postUrl,
			type: 'GET',
			data: submit_data,
			dataType: "json",
			xhrFields: {
				withCredentials: true
			}
		}).done(function(data) {
			$('#loadding').remove();
			if (data.result == "ok") {
				var html = '';
				if(data.data.length == 0){
					return false;
				}else{
					$.each(data.data,function(index,elem){
						console.log("a");
						html += "<tr><td>"+elem.product_id+"</td><td>"+elem.product_name+"</td><td>"+elem.facility_name+"</td><td>"+elem.district_name+
						"</td><td><a target='_blank' href="+$('#WEB_ROOT').val()+"AbnormalShipment/getDetail?abnormal_shipment_type=shipping_unselect&product_id="+elem.product_id+"&facility_id="+elem.facility_id+"&district_id="+elem.district_id+">"+elem.num+"</a></td></tr>";
					});		
				}
				
				$(".shipping-table tbody").empty().append(html);
			} else {
				alert("失败。" + data.error_info);
			}
		});
	}
    

	$(function() {
		var table;
		var flag = true;
		getCommodityFileUnset();
		getFacilityUnselect();
		getShippingUnselect();
	});
</script>
</body>
