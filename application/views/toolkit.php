<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>状态修改</title>
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
<style>
body { font-family: Arial,'微软雅黑'; }
/*商品档案状态*/
#product { }
.info { font-size: 16px; }
.info .info_tl { width: 100px; text-align: center; font-size: 16px; font-weight: 700; line-height: 30px; }
.info .info_item { position: relative; padding: 0 0 0 120px; border: none; line-height: 24px; }
.info .info_item .attr { position: absolute; left: 0; width: 120px; text-align: right; overflow: hidden; } 
.info .info_item .val { padding-left: 10px; }
</style>
</head>
<body>
<div>
    <ul class="nav nav-pills nav-tabs" role="tablist">
        <li role="presentation" class="<?php if(empty($tab) || $tab=='product') echo 'active'; ?>"><a href="#product" aria-controls="product" role="tab" data-toggle="tab">商品档案状态</a></li>
        <li role="presentation" class="<?php if(isset($tab) && $tab=='finance') echo 'active'; ?>"><a href="#finance" aria-controls="finance" role="tab" data-toggle="tab">财务审核状态回退</a></li>
        <li role="presentation" class="<?php if(isset($tab) && $tab=='supplier') echo 'active'; ?>"><a href="#supplier" aria-controls="supplier" role="tab" data-toggle="tab">修改供应商状态</a></li>
        <li role="presentation" class="<?php if(isset($tab) && $tab=='in_transit') echo 'active'; ?>"><a href="#in_transit" aria-controls="in_transit" role="tab" data-toggle="tab">在途库盘盈</a></li>
        <li role="presentation" class="<?php if(isset($tab) && $tab=='new_action') echo 'active'; ?>"><a href="#new_action" aria-controls="new_action" role="tab" data-toggle="tab">新建权限</a></li>
    </ul>
    <div class="tab-content clearfix">
        <div role="tabpanel" class="tab-pane <?php if(empty($tab) || $tab=='product') echo 'active'; ?>" id="product">
            <div class="panel col-md-8">
                <div class="panel-heading">
                    <div class="filter">
                        <input class="filter_input" type="text" id="product_id" placeholder="请输入PRODUT_ID">
                        <input type="button" value="查询" id="product_filter" class="btn btn-primary btn-xs filter_btn" style="line-height: 26px;">
                    </div>
                </div>
                <div class="penel-body">
                    <div class="info">
                        <p class="info_tl bg-warning text-info">商品信息</p>
                        <ul class="info_list list-group bg-info clearfix">
                            <li class="info_item list-group-item">
                                <div class="attr">PRODUT_ID：</div>
                                <div class="val" id="product_id_info"></div>
                            </li>
                            <li class="info_item list-group-item">
                                <div class="attr">产品名称：</div>
                                <div class="val" id="product_name_info"></div>
                            </li>
                        </ul>
                    </div>
                    <div class="opetate">
                        <input type="button" class="btn btn-primary" value="至INIT" id="productToInitBtn">
                        <input type="button" class="btn btn-danger" value="强至INIT" id="productForceToInitBtn">
                    </div>
                </div>
            </div>
        </div>
       <div role="tabpanel" class="tab-pane <?php if(!empty($tab) && $tab=='finance') echo 'active'; ?>" id="finance">
            <div class="panel col-md-8">
                <div class="panel-heading">
                    <div class="filter">
                        <input class="filter_input" type="text" placeholder="请输入asn_item_id">
                        <input type="button" value="查询" id="finance_query" class="btn btn-primary btn-xs filter_btn" style="line-height: 26px;">
                    </div>
                </div>
                <div class="penel-body">
                    <div class="info">
                        <p class="info_tl bg-warning text-info">财务审核信息</p>
                        <ul class="info_list list-group bg-info clearfix">
                        </ul>
                    </div>
                    <div class="opetate">
                        <input type="button" class="btn btn-primary back" value="至INIT">
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="supplier">
            <div class="panel col-md-8">
                <div class="panel-heading">
                    <div class="filter">
                        <input class="filter_input" type="text" placeholder="请输入供应商ID">
                        <input type="button" value="查询" id="supplier_filter" class="btn btn-primary btn-xs filter_btn" style="line-height: 26px;">
                    </div>
                </div>
                <div class="penel-body">
                    <div class="info">
                        <p class="info_tl bg-warning text-info">供应商信息</p>
                        <ul class="info_list list-group bg-info clearfix">
                            <li class="info_item list-group-item">
                                <div class="attr">供应商ID：</div>
                                <div class="val">sdsdsd</div>
                            </li>
                            <li class="info_item list-group-item">
                                <div class="attr">供应商类型：</div>
                                <div class="val">西施在吗</div>
                            </li>
                        </ul>
                    </div>
                    <div class="opetate">
                        <input type="button" class="btn btn-primary" value="至INIT">
                        <input type="button" class="btn btn-danger" value="强至INIT">
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane row tab-goods-list <?php if(isset($tab) && $tab=='in_transit') echo 'active'; ?>" id="in_transit">
            <div class="well">
                <!-- Nav tabs -->
                <input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> >
                <?php if (isset($error_info)) echo "<h3 style='color:red;font-weight:bold;'>{$error_info}</h3>"; ?>
                <?php if (isset($message)) echo "<h3 style='font-weight:bold;'>{$message}</h3>"; ?>                
                <form id="from_transitVarianceIn" method="post" action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>toolkit/?tab=in_transit">
                        <input type="hidden" value="in_transit" name="tab">
                        <div class="">
                            <label class="control-label"><span class=" control-label label label-info">在途库盘盈</span><b>(应该追回的，误操作在途盘亏。把在途库存盘盈回来)</b></label>
                        </div>
                        <div class="row">
                            <label class="col-sm-1 control-label">bol_item_id</label>
                            <div  class="col-sm-2 control-label">
                                <input type="text" id="transitVarianceIn_bol_item_id" autocomplete="off" name="transitVarianceIn_bol_item_id" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-1 control-label">数量</label>
                            <div  class="col-sm-2 control-label">
                                <input type="text" id="transitVarianceIn_qoh" autocomplete="off" name="transitVarianceIn_qoh" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-1 control-label">备注</label>
                            <div  class="col-sm-2 control-label">
                                <input type="text" id="transitVarianceIn_note" autocomplete="off" name="transitVarianceIn_note" class="form-control">
                            </div>
                        </div>
                        <div class="row" style="margin-top:10px;">
                            <label class="col-sm-1 control-label"></label>
                            <div  class="col-sm-2 control-label">
                                <input type="hidden" name="act" value="transitVarianceIn"/>
                                <button type="submit" class="btn btn-primary btn-sm"  id="query"  >提交 </button> 
                            </div>
                        </div>
                </form>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane row tab-goods-list <?php if(isset($tab) && $tab=='new_action') echo 'active'; ?>" id="new_action">
            <div class="well">
                <!-- Nav tabs -->
                <form id="from_action" method="post" action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>toolkit/addAction">
                        <div class="row">
                            <label class="control-label"><span class=" control-label label label-info title">新建权限</span></label>
                        </div>
                        <div class="row">
                            <label class="col-sm-1 control-label">权限名：</label>
                            <div  class="col-sm-2 control-label">
                                <input type="text" id="action_name" autocomplete="off" name="action_name" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-1 control-label">action_code</label>
                            <div  class="col-sm-2 control-label">
                                <input type="text" id="action_code" autocomplete="off" name="action_code" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-1 control-label">title_action</label>
                            <div  class="col-sm-2 control-label title_action">
                                
                            </div>
                        </div>
                        <div class="row" style="margin-top:10px;">
                            <label class="col-sm-1 control-label"></label>
                            <div  class="col-sm-2 control-label">
                                
                                <button type="button" class="btn btn-primary btn-sm"  id="action_submit"  >提交 </button> 
                            </div>
                        </div>
                </form> 
            </div>
        </div>
    </div>
</div>
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script>
var WEB_ROOT = '<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>';
$(function(){
    $.ajax({
            url: '<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>toolkit/getdata',
            type: 'GET',
            dataType: 'json',
        })
        .done(function(data){
            console.log(data);
            var html ="";
            $.each(data["action_title_list"],function(index,elem){
                html += '<label><input type="checkbox" name="action_id" class="check-action" value='+elem["action_id"]+' />'+elem["action_name"]+'</label>';
            });
            $(".title_action").append(html);
        });

});

$("#action_submit").click(function(){
    var title_action = [];
    $(".check-action").each(function(){
        if($(this).prop("checked")==true){
            title_action.push($(this).val());
        }
    });
    
    var action_name = $('#action_name').val();
    if(action_name==''){
        alert("请选择权限名");
        return false;
    }
    var action_code = $('#action_code').val();
    if(action_code==''){
        alert("请选择title_code");
        return false;
    }
    // if(title_action.length==0){
    //     alert("请选择title_action");
    //     return false;
    // }
    var submit_data = {
        "action_name":action_name,
        "action_code":action_code,
        "action_id":title_action
    }
    console.log(submit_data);
    var postUrl = $("#from_action").attr("action");
        $.ajax({
         url: postUrl,
         type: 'POST',
         data:submit_data, 
         dataType: "json", 
         xhrFields: {
           withCredentials: true
         },
      }).done(function(data){
            if(data['success']){
                alert("新建成功！");
                //location.reload();
                window.location.href = window.location.href+'?tab=new_action';
            }else {
                alert("新建失败：错误原因"+data['error_info']+"");
            }
      });
});

$("#from_transitVarianceIn").submit(function() {
    var qoh = $("#transitVarianceIn_qoh").val().trim();
    if (! checkQoh(qoh)) {
        return false;
    }
    return confirm("确定吗？");
});

function checkQoh(qoh) {
    if(!/^(\+|-)?(\d+)(\.\d*)?$/g.test(qoh)){
        alert('请输入数字');
        return false;
    }
    qoh = parseFloat(qoh);
    if (qoh <= 0) {
        alert("请输入正数");
        return false;
    }
    return true;
}

$('#product_filter').click(function(){
	product_id = $('#product_id').val();
	submit_data = {'product_id': product_id};

	var postUrl = "<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>Toolkit/getProduct";
    $.ajax({
     url: postUrl,
     type: 'POST',
     data: submit_data, 
     dataType: "json", 
     xhrFields: {
       withCredentials: true
     },
  }).done(function(data){
	  $('#product_id_info').html(data.product_id);
	  $('#product_name_info').html(data.product_name);
  }).fail(function(data){
	  console.log(data);
  });
});

$('#productToInitBtn').click(function(){
	$product_id = $('#product_id').val();
	submit_data = {'product_id': product_id};
	var postUrl = "<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>Toolkit/productToInit";
    $.ajax({
     url: postUrl,
     type: 'POST',
     data: submit_data, 
     dataType: "json", 
     xhrFields: {
       withCredentials: true
     },
	  }).done(function(data){
		  if(data.success == 'success') {
			  alert('成功');
		  } else {
			  alert('失败' + data.error_info);
		  }
	  }).fail(function(data){
		  console.log(data);
	  });
});

$('#productForceToInitBtn').click(function(){
	$product_id = $('#product_id').val();
	submit_data = {'product_id': product_id};
	var postUrl = "<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>Toolkit/productForceToInit";
    $.ajax({
     url: postUrl,
     type: 'POST',
     data: submit_data, 
     dataType: "json", 
     xhrFields: {
       withCredentials: true
     },
	  }).done(function(data){
		  if(data.success == 'success') {
			  alert('成功');
		  } else {
			  alert('失败' + data.error_info);
		  }
	  }).fail(function(data){
		  console.log(data);
	  });
});

var finance = (function(){//财务审核状态回退
    function init(){
        bindEvent();
    }

    function bindEvent(){
        $('#finance_query').on('click',function(){
            var $this = $(this),
                asn_item_id = $('#finance').find('.filter_input').val();
            if( asn_item_id === '' ){
                alert('asn_item_id不能为空');
                $this.focus();
                return;
            }else{
                var data = {
                    "asn_item_id" : asn_item_id
                };
                financeQuery(data).done(function(data){
                    if(data.asn_item){
                        var str = createFinanceHtml(data.asn_item);
                        $('#finance .info_list').html(str);                        
                    }
                });
            }
        });

        $('#finance .filter_input').on('keyup',function(ev){
            if(ev.keyCode==13){
                $('#finance_query').trigger('click');
            }
        });

        $('.opetate .back').on('click',function(){
            var $this = $(this),
                asn_item_id = asn_item_id = $('#finance').find('.filter_input').val();
            if( asn_item_id === '' ){
                alert('asn_item_id不能为空');
                $this.focus();
                return;
            }else{
                var data = {
                    "asn_item_id" : asn_item_id
                };
                financeBack(data).done(function(data){
                    if(data.error_info){
                        alert(data.error_info);    
                    }else{
                        alert('修改成功');
                        window.location.href = WEB_ROOT+'Toolkit/?tab=finance';
                    }
                });
            }
        });
    }

    function createFinanceHtml(asn_item_list){
        var str = '';
        $.each(asn_item_list,function(key,val){
            str += '<li class="info_item list-group-item"><div class="attr">'+key+'：</div><div class="val">'+val+'</div></li>';
        });
        return str;
    }

    function financeQuery(data){
        return $.ajax({
            url : WEB_ROOT+'Toolkit/getPurchaseFinanceInfoByAsnItemId',
            type : 'GET',
            data : data,
            dataType : 'json'
        }).fail(function(){
            alert('查询财务审核信息请求失败');
        });
    }

    function financeBack(data){
        return $.ajax({
            url : WEB_ROOT+'Toolkit/purchaseFinanceInfoByForce',
            type : 'POST',
            data : data,
            dataType : 'json'
        }).fail(function(){
            alert('财务审核状态back请求失败');
        });
    }

    return {
        init : init
    };

})();
finance.init();
</script>
</body>
</html>