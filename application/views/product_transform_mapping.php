<!doctype html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<title>乐微SHOP</title>
<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/autocomplete.css">
</head>
<body>
    <div id="loadding" class="loadding"><img src="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/img/loadding.gif" ></div>
    <div class="container-fluid tabpanel" style="margin-left: -18px;padding-left: 19px;" >
            <div class="col-md-12">
                <!-- Nav tabs -->
                <input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> >
                <!-- Tab panes -->
                <div class="tab-content tabpanel">
                	<div class="row">
		                	名词解释：
		                	<br>
		                 	转换比例-----1个A果转成几个B果。如果1箱榴莲饼=20个榴莲饼，转换比例为20。1个金枕榴莲转成1个金枕榴莲7斤以上，转换比例为1。
		                 	<br>
                 			价格比例-----1个A果价格等于1个B果的几倍。如果1箱榴莲饼的价格时一个榴莲饼20被，价格比例为20。1个金枕榴莲等于1个金枕榴莲7斤以上的0.8倍，价格比例为0.8。
                 	</div>
                <form>
                    <div class="row">
                        <label for="transform_type" class="col-sm-2 control-label">类型</label>
                        <div class="col-sm-3">
                            <select  name="transform_type" id="transform_type" class="form-control" onchange="change()">
                                <option value="RAW2RAW">原料转原料</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <label for="from_product_name" class="col-sm-2 control-label">A果</label>
                        <div class="col-sm-3">
                            <input required="required" type="text" class="form-control" id="from_product_name">
                        </div>
                        <input type="hidden" id="from_product_id" name="from_product_id"/>
                        <label for="to_product_name" class="col-sm-2 control-label">B果</label>
                        <div class="col-sm-3">
                            <input required="required" type="text" class="form-control" id="to_product_name">
                        </div>
                        <input type="hidden" id="to_product_id" name="to_product_id"/>
                    </div>
                    <br>
                    <div class="row">
                   	 	<label for="quantity" class="col-sm-2 control-label">转换比例</label>
                        <div class="col-sm-3">
                            <input required="required" type="number" min="0" class="form-control" id="quantity">
                        </div>
                        
                        <label for="quantity" class="col-sm-2 control-label">价格比例</label>
                        <div class="col-sm-3">
                            <input required="required" type="number" min="0" class="form-control" id="price_quantity">
                        </div>
                    </div>
                    <div class="row">
                        <label for="note" class="col-sm-2 control-label">备注</label>
                        <div class="col-sm-3">
                            <input required="required" type="text" class="form-control" id="note">
                        </div>
                        <div style="width:40%;float:right;text-align: center;">
                            <button type="reset" class="btn btn-primary"  id="reset"  >重置 </button> 
                            <button type="button" class="btn btn-primary"  id="query"  >创建 </button> 
                        </div>
                    </div>
                </form>
                </div>
            </div>
    </div>
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/common.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript">
var onOff1 = false,onOff2 = false;
$(function(){
    getRawMaterialList();
    // getChangeList('raw_material');
})

var WEB_ROOT = $("#WEB_ROOT").val();
var myurl = WEB_ROOT + "ProductTransformMappingList/creatProductTransformMapping";

$("#query").click(function(){
    var bnt = $(this);
    bnt.attr('disabled',"disabled");
    var submit_data = {
        from_product_id: $('#from_product_id').val(),
        to_product_id: $('#to_product_id').val(),
        quantity: Number($('#quantity').val()),
        transform_type: $('#transform_type option:selected').val(),
        price_quantity: Number($('#price_quantity').val()),
        note: $("#note").val()
    };
    if (!submit_data['from_product_id'] || !submit_data['to_product_id'] || !submit_data['quantity'] || submit_data['quantity'] <= 0 ||submit_data['price_quantity'] <= 0) {
        alert('请填写正确信息');
        bnt.removeAttr('disabled');
        return false;
    };
    var cf = confirm('是否确认创建?');
    if (!cf) {
        return false;
    };
    $.ajax({
        url: myurl,
        data: submit_data,
        type: 'POST',
        dataType:"json",
        xhrFields: {
            withCredentials: true
        },
        success: function(data){
            if (data.data.result == 'ok') {
                alert('创建成功!');
                bnt.removeAttr('disabled');
                $("#reset").trigger("click");
            };
        }
    })
}); 

function formatOpt(row, i, max){
	 return('[' +row.product_id + ']' + row.product_name);
}

function getRawMaterialList(){
    $.ajax({
        url:  WEB_ROOT + "product/getProductList",
        type:"get",
        dataType:"json",
        data: {"product_type":"goods","product_sub_type":"raw_material"},
        xhrFields: {
            withCredentials: true
        }
    }).done(function(data){
        if(data.res == "success"){
        	autocoms($('#to_product_name'),data.product_list,formatOpt).result(function(event, row, formatted) {
                $('#to_product_id').val(row.product_id);
            });
        	autocoms($('#from_product_name'),data.product_list,formatOpt).result(function(event, row, formatted) {
                $('#from_product_id').val(row.product_id);
            });
        	$("#loadding").hide();
        }   
        else {
        	$("#loadding").hide();
        }
    }).fail(function(data){
        alert('内部服务器错误');
        $("#loadding").hide();
    });
}


$('#quantity').on('input propertychange', function(){
	$('#price_quantity').val($(this).val());
});
</script>
</body>
</html>