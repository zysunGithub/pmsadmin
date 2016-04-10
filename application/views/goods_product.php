<!doctype html>
<html>
<head>
    <title>拼好货WMS</title>
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/dataTables.bootstrap.min.css">
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
        <label>类别
           <select name="goods_status" class="form-control input-sm">
                <?php
                    foreach ($goods_status_list as $val) {
                        if (isset($goods_status) && $goods_status == $val['goods_status']) {
                            echo "<option value=\"{$val['goods_status']}\" selected='selected'>{$val['goods_status_name']}</option>";
                        } else {
                            echo "<option value=\"{$val['goods_status']}\">{$val['goods_status_name']}</option>";
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
    <table id="goods_table" class="table table-striped table-bordered " style="width: 100%;margin-top:10px;margin-right:10px;">
        <thead>
          <tr>
          	<th>平台</th>
            <th>商户id</th>
            <th>商户</th>
            <th>goods_id</th>
            <th>oms商品名称</th>
            <th>创建时间</th>
            <th>状态</th>
            <th>操作</th>
            </tr>
        </thead>
        <tbody> 
               <?php
               if (isset($data))
               {
                    foreach ($data as $v) {
                        echo "<tr>";
                        echo "<td>".$v['platform_name']."</td>";
                        echo "<td class='merchant_id'>".$v['merchant_id']."</td>";
                        echo "<td>".$v['merchant_name']."</td>";
                        echo "<td class='goods_id'>".$v['goods_id']."</td>";
                        echo "<td class='goods_name'>".$v['goods_name']."</td>";
                        echo "<td>".$v['created_time']."</td>";
                        if ($goods_status == 1) {
                            $product_status = "";
                            switch ($v['product_status']) {
                                case "INIT":
                                    $product_status = "未审核";
                                    break;
                                case "OK":
                                    $product_status = "已审核";
                                    break;
                            }
                ?>
                        <td><?php echo $product_status; ?></td>
                        <td><a href="<?php if (isset($WEB_ROOT)) echo $WEB_ROOT.'product/editIndex?product_id='.$v['product_id'] ?>">查看详情</a></td>
                <?php
                        } else {
                            if ($v['apply_status'] != 0) {
                ?>
                                <td>已申请</td>
                                <td>
                                    <input type="hidden" name="goods_apply_id" value="<?php echo $v['apply_status'];?>" />
                                    <a class="btn btn-danger btn-sm cancleApply" style="margin-right:30px" href="javascrip:;">取消申请</a>
                                </td>
                <?php
                            } else {
                ?>
                                <td>未申请</td>
                                <td><a class="btn btn-info btn-sm goodsApply" style="margin-right:30px" href="javascrip:;">申请</a></td>
                <?php
                            }
                        }
                        echo "</tr>";
                    }
                }
               ?>
        </tbody>
    </table>
</div>
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#goods_table').DataTable({
        language: {
            "url": "<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/Chinese.lang"
        },
        aLengthMenu: [[20, 10, 50, -1], [20, 10, 50, "所有"]], 
    }); 
});
$(".goodsApply").click(function() {
    ap_btn = $(this);
    merchant_id = ap_btn.parent().siblings(".merchant_id").html();
    goods_id = ap_btn.parent().siblings(".goods_id").html();
    goods_name = ap_btn.parent().siblings(".goods_name").html();
    var cf = confirm("是否申请？")
    if (cf == false)
        return;
    ap_btn.attr("disabled","disabled");
    $.ajax({
        url:"<?php if (isset($WEB_ROOT)) echo $WEB_ROOT;?>goodsApply/addGoodsApply",
        type:"post",
        data:{"goods_id":goods_id,"merchant_id":merchant_id,"goods_name":goods_name},
        dataType:"json",
        xhrFields: {
            withCredentials: true
        }
    }).done(function(data){
        if(data.success == "success"){
            alert('申请成功！');
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
$(".cancleApply").click(function() {
    ap_btn = $(this);
    goods_apply_id = ap_btn.siblings("input[name='goods_apply_id']").val();
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