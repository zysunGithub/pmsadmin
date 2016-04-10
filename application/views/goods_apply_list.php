<!doctype html>
<html>
<head>
    <title>拼好货WMS</title>
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
</head>
<body>
   <form class="form-inline" method="GET">
    <div class="form-group">
        <label>商城
            <select name="merchant_id" class="form-control input-sm">
                <option value="">全部</option>
                <?php
                    foreach ($merchant_list['list'] as $val) {
                        if(isset($merchant_id) && $merchant_id == $val['merchant_id']) {
                            echo "<option value=\"{$val['merchant_id']}\" selected='selected'>{$val['merchant_name']}</option>";
                        } else {
                            echo "<option value=\"{$val['merchant_id']}\">{$val['merchant_name']}</option>";
                        }
                    }
                ?>
            </select>
        </label>
    </div>
    <div class="form-group">
        <label>商品名称
           <input type="text" class="form-control" name="goods_name" value="<?php echo $goods_name;?>"/>
        </label>
    </div>
    <input type="submit" value="查询" class="btn btn-primary btn-sm query">
</form>
<div style="width: 98%;margin: 10px;">
    <table class="table table-striped table-bordered " style="width: 100%;margin-top:10px;margin-right:10px;">
          <tr>
            <th>申请ID</th>
            <th>平台</th>
            <th>商户id</th>
            <th>商户</th>
            <th>goods_id</th>
            <th>oms商品名称</th>
            <th>创建时间</th>
            <th>操作</th>
            </tr>
            <tbody> 
               <?php
               if (isset($goods_product_list[0])) {
                    foreach ($goods_product_list as $v) {
                        echo "<tr>";
                        echo "<td class='goods_apply_id'>".$v['goods_apply_id']."</td>";
                        echo "<td>".$v['platform_name']."</td>";
                        echo "<td>".$v['merchant_id']."</td>";
                        echo "<td>".$v['merchant_name']."</td>";
                        echo "<td>".$v['goods_id']."</td>";
                        echo "<td>".$v['goods_name']."</td>";
                        echo "<td>".$v['created_time']."</td>";
                ?>
                        <td><a class="btn btn-info btn-sm" style="margin-right:30px" href="<?php if (isset($WEB_ROOT)) echo $WEB_ROOT.'productNew?goods_apply_id='.$v['goods_apply_id'] ?>">添加</a>
                        <a class="btn btn-warning btn-sm cancleApply" style="margin-right:30px" href="javascrip:;">取消申请</a></td>
                <?php
                        echo "</tr>";
                    }
                }
               ?>
        </tbody>
    </table>
</div>
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript">
$(".cancleApply").click(function() {
    ap_btn = $(this);
    goods_apply_id = ap_btn.parent().siblings(".goods_apply_id").html();
    var cf = confirm("确认取消申请？")
    if (cf == false)
        return;
    ap_btn.attr("disabled","disabled");
    $.ajax({
        url:"<?php if (isset($WEB_ROOT)) echo $WEB_ROOT;?>goodsApply/removeGoodsApply",
        type:"post",
        data:{"goods_apply_id":goods_apply_id},
        dataType:"json",
        xhrFields: {
            withCredentials: true
        }
    }).done(function(data){
        if(data.success == "success"){
            alert('取消申请成功！');
            ap_btn.parent().parent().remove();
        }
        else{
            alert(data.error_info);
            ap_btn.removeAttr('disabled');
        }
    }).fail(function(data){
        alert(data.success);
        ap_btn.removeAttr('disabled');
    });
});
</script>
</body>
</html>