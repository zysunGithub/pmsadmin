<!doctype html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<title>乐微SHOP</title>
<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/order.css">
<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/buttons.dataTables.css">
<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/autocomplete.css">
<link rel="stylesheet" type="text/css" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/lhgcalendar.css"/>
<style type="text/css">
input[readonly] { background: #ccc; border: none; }
.package_list {  width: 640px; padding: 20px; }
.apply_list { width: 740px; padding: 20px; margin-top: 50px; }
#package_list_table th:nth-of-type(1) { width: 100px; }
#package_list_table th:nth-of-type(2) { width: 400px; }
#apply_list_table th:nth-of-type(2) { width: 100px; }
#apply_list_table th:nth-of-type(3) { width: 100px; }
#apply_list_table th:nth-of-type(4) { width: 400px;}
</style>
</head>
<body>
    <div class="package_list">
        <h4 class="s_18_b_7">包裹列表</h4>
        <div class="form-group" style="display:inline-block;">
            <label style="display: inline;">仓库：</label>
            <select name="facility_id" id="facility_id">
                <?php 
                    $str = '';
                    if( isset($facility_list) ){
                        foreach ($facility_list as $key => $facility_item) {
                            $str .= '<option value="'.$facility_item['facility_id'].'">'.$facility_item['facility_name'].'</option>'; 
                        }
                    }
                    echo $str;
                ?>
            </select>
        </div>
        <a href="<?php echo $WEB_ROOT; ?>productTransformApply/packageTransformList" class="pull-right">去申请列表查看</a>
        <table class="table table-striped table-bordered" id="package_list_table">
            <thead>
                <tr>
                    <th>包裹ID</th>
                    <th>包裹名称</th>
                    <th>转换数量</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    <div class="apply_list">
        <h4 class="s_18_b_7">转换申请列表</h4>
        <table id="apply_list_table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th class="hidden">仓库ID</th>
                    <th>仓库名称</th>
                    <th>包裹ID</th>
                    <th>包裹名称</th>
                    <th>转换包裹数量</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        <button class="btn btn-primary" id="sub">提交</button>
    </div>
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/lhgcalendar.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/dataTables.buttons.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/buttons.colVis.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/buttons.flash.js"></script>
<script src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/common.js"></script>
<script>
var WEB_ROOT = '<?php if(isset($WEB_ROOT)) echo $WEB_ROOT; ?>';

var $package_list = $('#package_list_table'),
    $apply_list = $('#apply_list_table'),
    facility_id = $('#facility_id').val(),
    $table = null;

createPackageListHtml(facility_id)
function createPackageListHtml(facility_id){
    $('#package_list_table').find('tbody').html('');
    getPackageListByFacilityId(facility_id).done(function(data){
        console.log( data );
        if( data.success === 'success' ){
            var str = '';
            $.each(data.package_list,function(){
                str += '<tr><td>'+this.product_id+'</td><td>'+this.product_name+'</td><td><input class="from_quantity" data-qoh="'+this.qoh+'" type="text" ></td><td><input type="button" class="btn btn-primary add" value="添加"></td></tr>';
            });
            if($table){
                $table.destroy();
            }
            $package_list.find('tbody').html(str);
            $table = $package_list.DataTable({
                language: {
                    "url": "<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/Chinese.lang"
                },
                "columnDefs": [
                        {
                            "searchable": false, 
                            "targets": [2,3] 
                        }
                    ],
                paging: false
            });
        }else{
            var error_info = data.error_info ? data.error_info : '后端获取包裹列表出错';
            alert(error_info);
        }
    });
}

function getPackageListByFacilityId(facility_id){
    return $.ajax({
        url : WEB_ROOT+'productTransformApply/getPackageListByFacilityId',
        type : 'GET',
        data : {'facility_id' : facility_id },
        dataType : 'json'
    }).fail(function(xhr){
        alert(xhr.statusText+':获取包裹列表请求失败');
    });
}

$('#facility_id').on('change',function(){
    var facility_id = $(this).val();
    createPackageListHtml(facility_id);
});

$package_list.on('click','.add',function(){
    var $this = $(this),
        $tr = $this.closest('tr'),
        facility_id = $('#facility_id').val(),
        facility_name = $('#facility_id').find('option:selected').text();
        product_id = $tr.find('td').eq(0).html(),
        product_name = $tr.find('td').eq(1).html(),
        from_quantity = $tr.find('.from_quantity').val(),
        str = '',
        flag = false;

    if( from_quantity == ''){
        alert('请先填写不能为零的转换数量');
        return;
    }
    $apply_list.find('tbody tr').each(function(){
        var $this = $(this),
            apply_facility_name = $(this).find('td:eq(1)').html();
            apply_product_id = $(this).find('td:eq(2)').html();
        if( apply_facility_name === facility_name && apply_product_id === product_id ){
            alert('该包裹已经添加过了');
            flag = true;
            return false;
        }
    });

    if(flag){
        $tr.find('.from_quantity').val('');
        return false;
    }

    str += '<tr><td class=hidden>'+facility_id+'</td><td>'+facility_name+'</td><td>'+product_id+'</td><td>'+product_name+'</td><td><input type="text" readonly="readonly" value="'+from_quantity+'"></td><td><input type="button" class="btn btn-danger del" value="删除"></td></tr>';
    $apply_list.find('tbody').html(  $apply_list.find('tbody').html()+str );
    $tr.find('.from_quantity').val('');
})
.on('change','.from_quantity',function(){
    var $this = $(this),
        from_quantity = +$this.val(),
        qoh = +$this.data('qoh');
    if( from_quantity < 1 ){
        alert('转换数量不能小于1');
        $this.val('');
        $this.focus();
    }
    if( from_quantity > qoh ){
        alert('转换数量不能大于库存');
        $this.val('');
        $this.focus();
    }
});

$apply_list.on('click','.del',function(){
    var $this = $(this),
        $tr = $this.closest('tr');
    $tr.remove();
});

$('#sub').on('click',function(){
    var $this = $(this);
    $this.attr('disabled','disabled');
    var data = getApplyData();
    if(data){
        packageTransformApply(data);
    }

});

function getApplyData(){
    var $tr = $apply_list.find('tbody tr'),
        data = {},
        from_product_info = [];
    if( $tr.length < 1 ){
        alert('没有要申请转换的包裹');
        $('#sub').removeAttr('disabled');
        return false;
    }else{
        $tr.each(function(){
            var facility_id = $(this).find('td:first').html(),
                from_product_id = $(this).find('td:eq(2)').html(),
                from_quantity = $(this).find('td:eq(4) input').val(),
                tempObj = {};

            tempObj['facility_id'] = facility_id;
            tempObj['from_product_id'] = from_product_id;
            tempObj['from_quantity'] = from_quantity;

            from_product_info.push(tempObj);
        });
        data['from_product_info'] = from_product_info;
        return data;
    }
}

function packageTransformApply(data){
    console.log(data);
    $.ajax({
        url : WEB_ROOT+'productTransformApply/packageTransformApply',
        type : 'POST',
        data : data,
        dataType : 'json'
    }).done(function(data){
        if( data.success === 'success' ){
            alert('提交成功');
            window.location.reload();
        }else{
            var error_info = data.error_info ? data.error_info : '提交包裹转换请求后端出错';
            alert(error_info);
            $('#sub').removeAttr('disabled');
        }
    }).fail(function(xhr){
        console.log(xhr);
        alert(xhr.statusText+':提交包裹转换请求失败');
        $('#sub').removeAttr('disabled');
    });
}
</script>
</body>
</html>