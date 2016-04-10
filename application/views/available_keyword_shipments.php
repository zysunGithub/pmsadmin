<!doctype html>
<html>
<head>
	<title>拼好货WMS</title>
	<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/order.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/autocomplete.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <style>
        .main{
            width: 1000px;
            margin: 0 auto;
        }
        .table-responsive{
            margin-top: 30px;
        }
        #citySel,#keyword{
            width:240px;
            margin-right:30px;
        }
        .table,tr,td,th{
            border:1px solid #e2e2e2;
        }
        #loadding{
            display:none;
            background:transparent;
        }
    </style>
</head>
<body>
<div id="loadding"><img src="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/img/loadding.gif"></div>
<input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> >
<div class="main">
    <form role="form" class="form-inline">
        <div class="form-group">
            <select class="form-control" id="citySel">
                <option value="">请选择城市</option>
            </select>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="请输入关键词" id="keyword">
        </div>
        <div class="form-group">
            <button type="button" class="btn btn-primary" id="search">搜索</button>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table" id="table">
            <thead>
                <tr>
                    <th>日期</th>
                    <th>订单数量</th>
                </tr>
            </thead>
            <tbody id="tableData">

            </tbody>
        </table>
    </div>
</div>
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    availableFacility();
});

//点击搜索调用
$('#search').click(function(){
    availableShipments();
})
//回车提交
$(document).keydown(function(event) {
    if (event.keyCode == "13"){
        availableShipments();
    }
});
//获取仓库列表
function availableFacility(){
    var url = $('#WEB_ROOT').val() + 'stationKeyword/getMainAvailableCitys';
    $.ajax({
        url: url,
        type: "post",
        dataType: "json"
    })
        .done(function(data) {
            var cityStr = "";
            $('#citySel').html('<option value="">请选择城市</option>');
            $.each(data.city_list,function(i,item){
                cityStr += '<option value='+ item.city_id +'>'+ item.city_name +'</option>'
            })
            $('#citySel').append(cityStr);
        })
        .fail(function() {
            console.log("error");
        });
}

//获取快递数据并以表格形式展现
function availableShipments(){
    var url = $('#WEB_ROOT').val() + 'stationKeyword/getAvailableShipments';
    var keyword = $('#keyword').val();
    var city_id = $('#citySel').val();
    var params = {
        "city_id": city_id,
        "keyword": $.trim(keyword)
    };
    //判空
    if(city_id == ""){
        alert("请先选择城市!")
    }else if($.trim(keyword) == ""){
        alert("请输入关键词!")
    }else{
        $("#loadding").show();
        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            data: params
        })
        .done(function(data) {
            if(!data.shipment_list|| (data.shipment_list.length == 0)){
                alert("当前无订单")
            }
            $("#loadding").hide();
            var shipmentStr = "";
            $('#tableData').html('');
            $.each(data.shipment_list,function(i,item){
                shipmentStr += '<tr><td>'+ item.created_date +'</td><td>'+ item.num +'</td></tr>';
            })
            $('#tableData').append(shipmentStr);
        })
        .fail(function() {
            console.log("error");
        });
    }
}
</script>
</body>
</html>