<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>拼好货WMS</title>
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/buttons.dataTables.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/autocomplete.css">
    <style type="text/css">
            fieldset{
                width: 1000px;
                padding: 15px;
                margin: 50px auto;
                border: 1px solid #eee;
            }
            p{
                padding: 0 10px;
            }
            select,input[type='text']{
                width: 280px;
                height: 40px;
                border: 1px solid #ddd;
                border-radius: 5px;
                padding: 0 0.5em;
                overflow: auto;
            }
            label{
              width: 100px;
            }
            label:nth-child(odd){
              margin-left: 60px;
            }
            input[type='text']{
                height: 36px;
            }
            .dtlBtn{
              background: #fff;
              border: 0;
              border-radius: 5px;
              background: #91bed4;
              color: #fff;
              font-weight: 300;
              font-size: 12px;
              padding: 8px 12px;
              margin:0 5px;
            }
            .dtlBtn:hover{
              background: #7cb8d3;
            }
            #search{
                margin-left: 345px;
                width: 100px;
                height: 36px;
                background: #fff;
                border: 0;
                border-radius: 5px;
                background: #1895e0;
                color: #fff;
                font-weight: 300;
                }
            #search:hover{
                background: #1584c4;
                cursor: pointer;
            }
            table,tr,td,th{
              border: 1px solid #ddd;
              padding: 8px;
              color: #232323;
              text-align: center;
            }
            th{
              background: #a2b7db;
              color: #fff;
            }
            tr:nth-child(even){
              background: #e8e8e8;
            }
            tr:hover{
              background: #d8dff2;
            }
            #listTable_wrapper,#listTable{
              width: 1000px!important;
              padding: 15px;
              margin: 0 auto;
            } 
            #listTable_processing{
              position: absolute;
              left: 45%;
              top: 45%;
              width: 100px;
              height: 36px;
              text-align: center;
              line-height: 36px;
              color: #1895e0;
              background: #ddd;
              filter:alpha(opacity=70); 
              opacity: 0.7;   
            }
            caption{
              margin-bottom: 10px;
            }
    </style>
    <!--[if lt IE 9]>
        <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <![endif]-->
</head>
<body>  
	<input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> > 
  <!-- 表单开始 -->
  <fieldset>
    <input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> > 
        <form action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>Shipments" method="post">
          <p>
          
            <label for="facility_id">仓库：</label>
            <select id="facility_id" name="facility_id">
            </select>
            <label for="shipping_id">快递：</label>
            <select id="shipping_id" name="shipping_id">
            </select>
          </p>
          <p>
          	<label for="order_sn">商品ID:</label>
            <input type="text" id="product_id">
            <label for="order_sn">商品:</label>
            <input type="text" id="product_name">
            <input type="button" id="search" value="搜索">
          </p>
        </form>
  </fieldset> <!-- 表单结束 -->

  <!-- 订单列表 -->
  <table id="listTable">
    <caption>订单列表</caption>
    <thead>
      <tr>
        <th>仓库</th>
        <th>快递</th>
        <th>PRODUCT_ID</th>
        <th>商品</th>
      </tr>
    </thead>
  </table>
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/common.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/dataTables.buttons.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/buttons.colVis.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/buttons.flash.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js"></script>
<script type="text/javascript">
//大区、仓库、快递联动
$(document).ready(function() {
    var keyVal = GetRequests();
    $("#facility_id").val(keyVal.facility_id);
    $("#shipping_id").val(keyVal.shipping_id);
    $("#product_id").val(keyVal.product_id);
    $("#product_name").val(keyVal.product_name);
	initFacilitySel();
	getFinishProductList();
});

function initFacilitySel() {
	var getFacilityListUrl = $('#WEB_ROOT').val() + 'Commons/getFacilityList';
	$.ajax({
	  type: "get",
	  url: getFacilityListUrl,
	  data: {},
	  dataType: "json",
	  success: function(data) {
	      $.each(data.data, function(i, item) {
	        var dataFacility = item;
	        $("#facility_id").append("<option value='" + dataFacility.facility_id + "'>" + dataFacility.facility_name + "</option>");
	      });
	      
		  initShippingSel();
	  },
	  error: function() {
	    alert('获取用户仓库列表错误');
	  }
	});
}

function initShippingSel() {
	var facilityId = $('#facility_id').val();
	if(isNullOrEmpty(facilityId)) {
		alert('请先选择仓库');
	  	return false;
	}
	$("#shipping_id").empty();
	$("#shipping_id").append("<option value=''>全部</option>");
    getShippingListUrl = $('#WEB_ROOT').val() + 'Commons/getShippingList';
  	$.ajax({
      type: "get",
      url: getShippingListUrl,
      data: {"facility_id" : facilityId}, // 传入获取到的仓库id
      dataType: "json",
      success: function(data) {
          $.each(data.shipping, function(i, item) {
            var shipping = item;
            $("#shipping_id").append("<option value='" + shipping.shipping_id + "'>" + shipping.shipping_name + "</option>");
          });
      },
      error: function() {
        alert('参数错误');
      }
  });
}

$("#facility_id").change(function() {
	initShippingSel();
});

function getFinishProductList() {
	getFinishGoodsProductListUrl = $('#WEB_ROOT').val() + 'product/getProductList';
	$.ajax({
	      type: "get",
	      url: getFinishGoodsProductListUrl,
	      data: {
		      "product_type": 'goods',
		      "product_sub_type": 'finished'
		  }, 
		  dataType: "json",
	      success: function(data) {
	    	  autocoms($('#product_name'), data.product_list, productNameFormat)
		      	.result(function(event, row, formatted) {
			        $('#product_id').val(row.product_id);
			    });
	      },
	      error: function() {
	        alert('参数错误');
	      }
	});
}

function productNameFormat(row, i, max) {
	 return row.product_name;
}

$("#search").click(function () {
    refreshTable();
});

function refreshTable(){
	getFinishGoodsProductListUrl = $('#WEB_ROOT').val() + 'productFacilityShippingList/getProductFactiliyShippingList';
	params = {
		'facility_id': $('#facility_id').val(),
		'shipping_id': $('#shipping_id').val(),
		'product_id': $('#product_id').val(),
		'product_name': $('#product_name').val()
	}
	table = $('#listTable').DataTable( {
	  "processing": true,
	  "serverSide": true,
	  "searching" : false,
	  "bSort": false,
	  "ordering": true,
	  "DeferRender": true,
	  "StateSave": true,
// 	  "retrieve": true,
	  "destroy": true,
	  "ajax": {
	      "url": getFinishGoodsProductListUrl,
	      "type": 'get',
	      "dataSrc": "list",
	      "data": params
	  },
	  aLengthMenu: [[100, 50, 500], [100, 50, 500]], 
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
	  "language": {
	          "url": "<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/Chinese.lang"
	      },
	  "columns": [
	      { "data": "facility_name"},
	      { "data": "shipping_name" },
	      { "data": "product_id" },
	      { "data": "product_name" },
	  ],
	  "initComplete": function(){
			flag = false;
		}
	} );

}
</script>

</body>
</html>