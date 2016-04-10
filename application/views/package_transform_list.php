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
#search_form { width: 1000px; margin: 0 auto; }
.package_list { padding: 20px; width: 1300px; margin: 0 auto; }
#package_list_table .checked ,#package_list_table .checkfail { background: #1C4D54; color: #fff; }
#package_list_table .receive_task { background: #ACAC39; color: #fff; }
#package_list_table .finish_task { background: #824D2B; color: #fff; }
#package_list_table .detail { background: #91CF6E; color: #fff; }
#transform_table input { width: 60px; }
</style>
</head>
<body>
    <form class="form-inline" id="search_form">
        <div class="row">
            <div class="form-group col-md-6">
                <label>仓库：</label>
                <select name="facility_id" id="facility_id" class="form-control">
                    <?php 
                        $str = '';
                        if( isset($facility_list) ){
                            foreach ($facility_list as $key => $facility_item) {
                                if( isset($facility_id) && $facility_item['facility_id']===$facility_id ){
                                    $str .= '<option value="'.$facility_item['facility_id'].'" selected="selected">'.$facility_item['facility_name'].'</option>'; 
                                }else{
                                    $str .= '<option value="'.$facility_item['facility_id'].'">'.$facility_item['facility_name'].'</option>';
                                } 
                            }
                        }
                        echo $str;
                    ?>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label>状态：</label>
                <select name="status" id="status" class="form-control">
                    <option value="" <?php if( empty($status) ) echo 'selected="selected"'; ?>>全部</option>
                    <option value="INIT" <?php if( !empty($status) && $status === 'INIT' ) echo 'selected="selected"'; ?>>已申请</option>
                    <option value="CHECKED" <?php if( !empty($status) && $status === 'CHECKED' ) echo 'selected="selected"'; ?>>审核通过</option>
                    <option value="CHECKFAIL" <?php if( !empty($status) && $status === 'CHECKFAIL' ) echo 'selected="selected"'; ?>>审核失败</option>
                    <option value="RECEIVE" <?php if( !empty($status) && $status === 'RECEIVE' ) echo 'selected="selected"'; ?>>已领取</option>
                    <option value="EXECUTED" <?php if( !empty($status) && $status === 'EXECUTED' ) echo 'selected="selected"'; ?>>已完成</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label>申请时间：</label>
                <input type="text" name="start_created_time" value="<?php if( isset($start_created_time) ) echo $start_created_time; ?>" id="start_created_time" class="form-control">
            </div>
            <div class="form-group col-md-6">
                <label>至：</label>
                <input type="text" name="end_created_time" value="<?php if( isset($end_created_time) ) echo $end_created_time; ?>" id="end_created_time" class="form-control">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label>包裹名称：</label>
                <input type="text" name="package_name" value="<?php if( !empty($package_name) ) echo $package_name; ?>" id="package_name" class="form-control">
            </div>
            <div class="form-group col-md-6">
                <label>
                    <button class="btn btn-primary" id="query">搜索</button>
                </label>
                <?php if($this->helper->chechActionList(array('createPackageTransformApply'))) {?>
                <a href="./index" class="btn btn-primary" id="apply">申请</a>
                <?php }?>
            </div>
        </div>
        <input type="hidden" name="from_product_id" id="from_product_id" value="<?php if( !empty($from_product_id) ) echo $from_product_id; ?>">
    </form>
    <div class="package_list">
        <table class="table table-striped table-bordered" id="package_list_table">
            <thead>
                <tr>
                    <th>仓库ID</th>
                    <th>仓库名</th>
                    <th>包裹ID</th>
                    <th>包裹名称</th>
                    <th class="from_quantity">转换数量</th>
                    <th>申请人</th>
                    <th>申请时间</th>
                    <th class="receive_user">任务领取人</th>
                    <th class="receive_time">领取时间</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
            </thead>
        </table>
    </div>
    <div class="modal fade" id="transform_modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">包裹转换信息</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-striped table-bordered table-condensed" id="transform_table">
                        <thead>
                            <tr>
                                <th>A果ID</th>
                                <th>A果名称</th>
                                <th>A果数量</th>
                                <th>B果ID</th>
                                <th>B果名称</th>
                                <th>B果数量</th>
                                <th class="quantity">B/A</th>
                                <th class="to_defective_quantity">次果</th>
                                <th class="to_bad_quantity">坏果</th>
                                <th class="to_good_quantity">好果</th>
                                <th class="to_container_quantity">箱规</th>
                                <th>单位</th>
                                <th class="to_case_num">箱数</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary sub">提交</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div class="modal fade" id="detail_modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">包裹转换信息</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-striped table-bordered table-condensed" id="detail_table">
                        <thead>
                            <tr>
                                <th>A果ID</th>
                                <th>A果名称</th>
                                <th>A果数量</th>
                                <th>B果ID</th>
                                <th>B果名称</th>
                                <th>B果数量</th>
                                <th class="quantity">B/A</th>
                                <th class="to_defective_quantity">次果</th>
                                <th class="to_bad_quantity">坏果</th>
                                <th class="to_good_quantity">好果</th>
                                <th class="to_container_quantity">箱规</th>
                                <th>单位</th>
                                <th class="to_case_num">箱数</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
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
var g_status = $('#status').val();
var g_username = '<?php if(isset($username)) echo $username; ?>';

(function(config){
    config['extendDrag'] = true; // 注意，此配置参数只能在这里使用全局配置，在调用窗口的传参数使用无效
    config['lock'] = true;
    config['fixed'] = true;
    config['okVal'] = 'Ok';
    config['format'] = 'yyyy-MM-dd HH:mm:ss';
})($.calendar.setting);

$("#start_created_time").calendar({btnBar:true,
               minDate:'2010-05-01', 
               maxDate:'2022-05-01'});
$("#end_created_time").calendar({btnBar:true,
               minDate:'2010-05-01', 
               maxDate:'2022-05-01'});  

var $package_list_table = $('#package_list_table'),
    $transform_modal = $('#transform_modal'),
    $transform_table = $('#transform_table'),
    getTransformInfoAjax = null,//获取包裹的包含原料请求
    $finishBtn = null,//用于保存完成任务按钮，方便提交成功之后更改状态
    $table = null;

(function($){
    var data = {
        "product_type" : "goods",
        "product_sub_type" : "finished"
    }
    $.ajax({
        url : WEB_ROOT+'Product/getProductList',
        type : 'GET',
        data : data,
        dataType : 'json'
    }).done(function(data){
        if( data.res === 'success' ){
            var format = function(row, i, max) {
                return('[' +row.product_id + ']' + row.product_name);
            };
            autocoms( $('#package_name'),data.product_list,format ).result(function(event,row,formatted){
                $('#package_name').val(row.product_name);
                $('#from_product_id').val(row.product_id);
            });
        }else{
            alert(data.error_info);
        }
    }).fail(function(xhr){
        alert(xhr.statusText+':获取产品列表请求失败');
    });
})(jQuery);
loadTableData();
$package_list_table.on('click','.checked',function(){
    var $this = $(this),
        transform_product_id = $this.closest('tr').data('transform_product_id'),
        data = {
            "transform_product_id" : transform_product_id
        };

    $this.attr('disabled','disabled');
    checkedAjax($this,data);
})
.on('click','.checkfail',function(){
    var $this = $(this),
        transform_product_id = $this.closest('tr').data('transform_product_id'),
        data = {
            "transform_product_id" : transform_product_id
        };
    $this.attr('disabled','disabled');
    checkfailAjax($this,data);
})
.on('click','.receive_task',function(){
    var $this = $(this),
        transform_product_id = $this.closest('tr').data('transform_product_id'),
        data = {
            "transform_product_id" : transform_product_id
        };

    $this.attr('disabled','disabled');
    receiveTaskAjax($this,data);
})
.on('click','.finish_task',function(){
    var $this = $(this),
        transform_product_id = $this.closest('tr').data('transform_product_id'),
        from_product_id = $this.closest('tr').find('.from_product_id').html(),
        from_product_name = $this.closest('tr').find('.from_product_name').html(),
        from_quantity = +$this.closest('tr').find('.from_quantity').html(),
        data = {
            "from_product_id" : from_product_id
        };
    $finishBtn = $this;
    createTransformInfoHtml(from_product_id,from_product_name,from_quantity,data);
    $transform_table.data('transform_product_id',transform_product_id);
    $transform_modal.modal('show');
})
.on('click','.detail',function(){
    var $this = $(this),
        transform_product_id = $this.closest('tr').data('transform_product_id'),
        from_product_id = $this.closest('tr').find('.from_product_id').html(),
        from_product_name = $this.closest('tr').find('.from_product_name').html(),
        from_quantity = +$this.closest('tr').find('.from_quantity').html(),
        data = {
            "transform_product_id" : transform_product_id
        };

    $this.attr('disabled','disabled');
    getTransformDetailAjax(from_product_id,from_product_name,from_quantity,$this,data);
})

function checkedAjax($obj,data){
    $.ajax({
        url : WEB_ROOT+'productTransformApply/checkProductTransform',
        type : 'POST',
        data : data,
        dataType : 'json'
    }).done(function(data){
        if( data.success === 'success' ){
            alert('审核通过成功');
            <?php if( $this->helper->chechActionList(array('receiveProductTransform') ) ){ ?>
                $obj.removeClass('checked').addClass('receive_task').val('领取任务');
                $obj.closest('tr').find('td.status').html('审核通过');
                $obj.siblings('.checkfail').remove();
                $obj.removeAttr('disabled');
            <?php }else{ ?>
                $obj.parent().html('无领取权限');
            <?php }?>
            if( g_status!=='' && g_status!=='CHECKED' ){
//                 $obj.closest('tr').remove();
            }
        }else{
            alert(data.error_info);
            $obj.removeAttr('disabled');
        }
    }).fail(function(xhr){
        alert(xhr.statusText+':审核通过请求失败');
        $obj.removeAttr('disabled');
    });
}

function checkfailAjax($obj,data){
    $.ajax({
        url : WEB_ROOT+'productTransformApply/checkFailProductTransform',
        type : 'POST',
        data : data,
        dataType : 'json'
    }).done(function(data){
        if( data.success === 'success' ){
            alert('审核失败成功');
            $obj.parent().html('已审核失败');
            $obj.closest('tr').find('td.status').html('审核失败');
            $obj.removeAttr('disabled');
            if( g_status!=='' && g_status!=='CHECKFAIL' ){
//                 $obj.closest('tr').remove();
            }
        }else{
            alert(data.error_info);
            $obj.removeAttr('disabled');
        }
    }).fail(function(xhr){
        alert(xhr.statusText+':审核失败请求失败');
        $obj.removeAttr('disabled');
    });
}

function receiveTaskAjax($obj,data){
    $.ajax({
        url : WEB_ROOT+'productTransformApply/receiveTask',
        type : 'POST',
        data : data,
        dataType : 'json'
    }).done(function(data){
        if( data.success === 'success' ){
            alert('领取任务成功');
            <?php if( $this->helper->chechActionList(array('receiveProductTransform') ) ){ ?>
                $obj.removeClass('receive_task').addClass('finish_task').val('完成任务');
                $obj.closest('tr').find('td.status').html('已领取');
                $obj.closest('tr').find('td.receive_user').html(data.receive_info.receive_user);
                $obj.closest('tr').find('td.receive_time').html(data.receive_info.receive_time);
                $obj.removeAttr('disabled');
            <?php }else{ ?>
                $obj.parent().html('无完成权限');
            <?php }?>
            
            if( g_status!=='' && g_status!=='RECEIVE' ){
//                 $obj.closest('tr').remove();
            }
        }else{
            alert(data.error_info);
            $obj.removeAttr('disabled');
        }
    }).fail(function(xhr){
        alert(xhr.statusText+':领取任务请求失败');
        $obj.removeAttr('disabled');
    });
}

function getTransformDetailAjax(from_product_id,from_product_name,from_quantity,$obj,data){
    $.ajax({
        url : WEB_ROOT+'productTransformApply/getTransformDetail',
        type : 'GET',
        data : data,
        dataType : 'json'
    }).done(function(data){
        if( data.success === 'success' ){
            var str = '';
            console.log(data);
            $.each(data.product_transform_list,function(){
                str += '<tr><td>'+from_product_id+'</td><td>'+from_product_name+'</td><td>'+from_quantity+'</td><td class="to_product_id">'+this.to_product_id+'</td><td>'+this.to_product_name+'</td><td class="to_quantity">'+this.to_quantity+'</td><td class="quantity">'+this.quantity+'</td><td class="to_defective_quantity">'+this.to_defective_quantity+'</td><td class="to_bad_quantity">'+this.to_bad_quantity+'</td><td class="to_good_quantity">'+this.to_good_quantity+'</td><td class="to_container_quantity">'+this.to_container_quantity+'</td><td>'+this.to_unit_code+'</td><td class="to_case_num">'+this.to_case_num+'</td></tr>';
            });

            $('#detail_table').find('tbody').html(str);
            $('#detail_modal').modal('show');
            $obj.removeAttr('disabled');
        }else{
            alert(data.error_info);
            $obj.removeAttr('disabled');
        }
    }).fail(function(xhr){
        alert(xhr.statusText+':获取转换详情请求失败');
        $obj.removeAttr('disabled');
    });
}

function createTransformInfoHtml(from_product_id,from_product_name,from_quantity,data){
    if(getTransformInfoAjax){
        getTransformInfoAjax.abort();
    }
    $transform_table.find('tbody').html('');
    getTransformInfoAjax = $.ajax({
        url : WEB_ROOT+'productTransformApply/getTransformInfo',
        type : 'GET',
        data : data,
        dataType : 'json'
    }).done(function(data){
        if( data.success === 'success' ){
            console.log( data );
            var str = '';
            $.each(data.to_product_info,function(){
            	optionStr = "";
            	optionStr += '<option value="">'+'请选择箱规'+'</option>';
            	for(var item in this.container_list) {
            		optionStr += '<option value=' + this.container_list[item].quantity +'>' + this.container_list[item].quantity + '</option>';
            	}
                
                str += '<tr><td>'+from_product_id+'</td><td>'+from_product_name+'</td><td>'+from_quantity+'</td><td class="to_product_id">'+this.to_product_id+'</td><td>'+this.to_product_name+'</td><td class="to_quantity">'+from_quantity*this.quantity+'</td><td class="quantity">'+this.quantity+'</td><td><input type="text" class="to_defective_quantity" value="0" /></td><td><input type="text" class="to_bad_quantity" value="0" /></td><td class="to_good_quantity">'+from_quantity*this.quantity+'</td><td>' +
                 '<select class="to_container_quantity">' + 
                 optionStr +
                 '</select><td>' + this.unit_code + '</td>' +
                 '</td><td class="to_case_num"></td></tr>';
            });
            $transform_table.find('tbody').html(str);
        }else{
            alert(data.error_info);
        }
    }).fail(function(xhr){
        if( xhr.statusText !== 'abort' ){
            alert( xhr.statusText+':获取包裹包含原料信息请求失败' );
        }
    });
}

$transform_modal.on('click','.sub',function(){
    if( !checkData() ){
        return;
    }
    $('.sub').attr('disabled','disabled');
    var $tr = $transform_modal.find('tbody tr'),
        transform_product_id = $transform_table.data('transform_product_id'),
        to_product_info = [],
        data = {};
    $tr.each(function(){
        var $this = $(this),
            tempObj = {};
        tempObj['to_product_id'] = $this.find('.to_product_id').html();
        tempObj['to_quantity'] = $this.find('.to_quantity').html();
        tempObj['to_defective_quantity'] = $this.find('.to_defective_quantity').val();
        tempObj['to_bad_quantity'] = $this.find('.to_bad_quantity').val();
        tempObj['to_good_quantity'] = $this.find('.to_good_quantity').html();
        tempObj['to_container_quantity'] = $this.find('.to_container_quantity').val();
        tempObj['to_case_num'] = $this.find('.to_case_num').html();
        to_product_info.push(tempObj);
    });
    data['transform_product_id'] = transform_product_id;
    data['to_product_info'] = to_product_info;
    finishProductTransform(data);
})
.on('change','.to_defective_quantity',function(){
    var $this = $(this),
        to_defective_quantity = +$this.val(),
        to_bad_quantity = +$this.closest('tr').find('.to_bad_quantity').val(),
        $to_good_quantity = $this.closest('tr').find('.to_good_quantity'),
        $to_case_num = $this.closest('tr').find('.to_case_num'),
        to_quantity = +$this.closest('tr').find('.to_quantity').html(),
        to_container_quantity = +$this.closest('tr').find('.to_container_quantity').val();

    if( $this.val()==='' ){
        alert('不能为空');
        $this.focus();
        return;
    }
    if( to_defective_quantity < 0 ){
        alert('不能为负数');
        $this.val('');
        $this.focus();
        return;
    }
    var tempNum1 = +to_defective_quantity.sub(to_quantity);
    var to_good_quantity = +to_bad_quantity.sub(tempNum1);
    if( to_good_quantity < 0 ){
        alert('次果和坏果总和不能大于B果总数');
        $this.val('');
        $this.focus();
        return;
    }
    if( to_container_quantity ){
        $to_case_num.html( (to_good_quantity/to_container_quantity).toFixed(2) );  
    }
    $to_good_quantity.html( to_good_quantity );
})
.on('change','.to_bad_quantity',function(){
    var $this = $(this),
        to_bad_quantity = +$this.val(),
        to_defective_quantity = +$this.closest('tr').find('.to_defective_quantity').val(),
        $to_good_quantity = $this.closest('tr').find('.to_good_quantity'),
        $to_case_num = $this.closest('tr').find('.to_case_num'),
        to_quantity = +$this.closest('tr').find('.to_quantity').html(),
        to_container_quantity = +$this.closest('tr').find('.to_container_quantity').val();

    if( $this.val()==='' ){
        alert('不能为空');
        $this.focus();
        return;
    }
    if( to_bad_quantity < 0 ){
        alert('不能为负数');
        $this.val('');
        $this.focus();
        return;
    }
    var tempNum1 = +to_defective_quantity.sub(to_quantity);
    var to_good_quantity = +to_bad_quantity.sub(tempNum1);
    if( to_good_quantity < 0 ){
        alert('坏果和次果总和不能大于B果总数');
        $this.focus();
        return;
    }
    if( to_container_quantity ){
        $to_case_num.html( (to_good_quantity/to_container_quantity).toFixed(2) );  
    }
    $to_good_quantity.html( to_good_quantity );
})
.on('change','.to_container_quantity',function(){
    var $this = $(this),
        to_container_quantity = +$this.val(),
        to_quantity = +$this.closest('tr').find('.to_quantity').html(),
        to_good_quantity = +$this.closest('tr').find('.to_good_quantity').html(),
        $to_case_num = $this.closest('tr').find('.to_case_num');
    if( to_good_quantity === '' ){
        alert('请先填好次果和坏果来计算出好果');
        $this.val('');
        return;
    }
    if( to_container_quantity == 0 ){
        alert('箱规不能为空和零');
        $this.val('');
        $this.focus();
        return;
    }else{
        var to_case_num = (to_good_quantity/to_container_quantity).toFixed(2);
        if(to_case_num){
            $to_case_num.html(to_case_num);
        }
    }
});

function checkData(){
    var $tr = $transform_table.find('tbody tr'),
        flag = true;
    if( $tr.length < 1 ){
        alert('没有可以转换的数据');
        flag = false;
    }else{
        $tr.each(function(){
            var $this = $(this),
                to_container_quantity = +$this.find('.to_container_quantity').val(),
                to_quantity = +$this.find('.to_quantity').html(),
                to_defective_quantity = $this.find('.to_defective_quantity').val(),
                to_bad_quantity = $this.find('.to_bad_quantity').val(),
                to_good_quantity = $this.find('.to_good_quantity').html();

            if( !to_container_quantity ){
                alert('箱规不能为零或空');
                flag = false;
                return false;
            }
            if( to_defective_quantity ==='' || (+to_defective_quantity) < 0 ){
                alert('次果不能为空或小于零');
                flag = false;
                return false;
            }
            if( to_bad_quantity ==='' || (+to_bad_quantity) < 0 ){
                alert('坏果不能为空或小于零');
                flag = false;
                return false;
            }
            if( to_good_quantity ==='' || (+to_good_quantity) < 0 ){
                alert('好果不能为空或小于零');
                flag = false;
                return false;
            }
            if( (+to_defective_quantity)+(+to_bad_quantity)+(+to_good_quantity) !== to_quantity ){
                alert('好果次果坏果之和与B果总数不相等');
                flag = false;
                return false;
            }
        });
    }
    return flag;
}

function finishProductTransform(data){
    console.log(data);
    $.ajax({
        url : WEB_ROOT+'productTransformApply/finishProductTransform',
        type : 'POST',
        data : data,
        dataType : 'json'
    }).done(function(data){
        if( data.success === 'success' ){
            alert('提交成功');
            $finishBtn.removeClass('finish_task').addClass('detail').val('查看详情');
            $finishBtn.closest('tr').find('td.status').html('已完成');
            if( g_status!=='' && g_status!=='EXECUTED' ){
//                 $finishBtn.closest('tr').remove();
            }
            $('.sub').removeAttr('disabled');
            $transform_modal.modal('hide');
        }else{
            alert(data.error_info);
            $('.sub').removeAttr('disabled');
        }
    }).fail(function(xhr){
        alert(xhr.statusText+':提交转换信息请求失败');
        $('.sub').removeAttr('disabled');
    });
}

var page_now = +'<?php if(isset($page_now)) echo $page_now; ?>';
var page_all = +'<?php if(isset($page_all)) echo $page_all; ?>';

$("#query").click(function(ev){
    ev.preventDefault();
    loadTableData();
}); 

function loadTableData(){
    var url = WEB_ROOT+'productTransformApply/getQohPackageList',
        facility_id = $('#facility_id').val(),
        status = $('#status').val(),
        start_created_time = $('#start_created_time').val(),
        end_created_time = $('#end_created_time').val(),
        from_product_id = $('#from_product_id').val();
    var params = {
        "facility_id" : facility_id,
        "status" : status,
        "start_created_time" : start_created_time,
        "end_created_time" : end_created_time,
        "from_product_id" : from_product_id
    };

    if($table){
        $table.destroy();
    }

    $table = $('#package_list_table').DataTable({
        "processing": true,
        "serverSide": true,
        "searching" : false,
        "bSort": true,
        "ordering": true,
        "DeferRender": true,
        "StateSave": true,
        "bDestroy": true,
        "ajax": {
            "url": url,
            "type": 'get',
            "dataSrc": "list",
            "data": params
        },
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
        aLengthMenu: [[30, 50, 100], [30, 50, 100]], 
        "columns": [
            { "data": "facility_id"},
            { "data": "facility_name", "orderable":false },
            { "data": "from_product_id","className": "from_product_id" },
            { "data": "product_name","className": "from_product_name", "orderable":false },
            { "data": "from_quantity","className": "from_quantity", "orderable":false },
            { "data": "created_user" },
            { "data": "created_time" },
            { "data": "receive_user","className": "receive_user" },
            { "data": "receive_time","className": "receive_time" },
            { "data": "status","className": "status" }
        ],
        "columnDefs": [
            // 动态绚烂
            /*{
                "targets": [0],
                "visible": false
            },*/
            {
                "targets": [9], // 目标列位置，下标从0开始
                "data": "status", // 数据列名
                "render": function(status,type,row){ // 返回自定义内容
                    var str;
                    if( status === 'INIT' ){ 
                        str =  '已申请'; 
                    }else if( status === 'CHECKED' ){
                        str =  '审核通过';
                    }else if( status === 'CHECKFAIL' ){
                        str =  '审核失败';
                    }else if( status === 'RECEIVE' ){
                        str = '已领取';
                    }else if( status === 'EXECUTED' ){
                        str =  '已完成';
                    }else{
                        str =  '不知名状态';
                    }
                    return str;
                }
            },
            {
                "targets": [10], // 目标列位置，下标从0开始
                "data": "status", // 数据列名
                "render": function(status,type,row){ // 返回自定义内容
                    var str;
                    if( status === 'INIT' ){
                        <?php  
                        if( $this->helper->chechActionList(array('checkProductTransform') ) ){ 
                            echo 'str = \'<input type="button" class="btn checked" value="审核通过"> <input type="button" class="btn checkfail" value="审核失败">\'';    
                        }else{
                            echo 'str = \'无审核权限\'';
                        }
                        ?>
                    }else if( status === 'CHECKED' ){
                        <?php 
                        if( $this->helper->chechActionList(array('receiveProductTransform') ) ){
                            echo 'str = \'<input type="button" class="btn receive_task" value="领取任务">\'';    
                        }else{
                            echo 'str = \'无领取权限\'';
                        }
                        ?>
                    }else if( status === 'CHECKFAIL' ){
                        str = '已审核失败';
                    }else if( status === 'RECEIVE' ){
                        <?php 
                        if( $this->helper->chechActionList(array('finishProductTransform') ) ){ ?>
                            if( (row.receive_user) && (g_username) && (g_username === row.receive_user) ){
                                str = '<input type="button" class="btn finish_task" value="完成任务">';    
                            }else{
                                str = '非领取者不可操作';
                            }
                        <?php  
                        }else{
                            echo 'str = \'无完成权限\'';
                        } ?> 
                    }else if( status === 'EXECUTED' ){
                        str = '<input type="button" class="btn detail" value="查看详情">';
                    }else {
                        str = '不知名状态';
                    }
                    return str;
                }
            }
        ],
        "createdRow": function (row,data,index){
            $(row).data('transform_product_id',data.transform_product_id);
        },
        "initComplete": function(){
            flag = false;
        }
    });
}

</script>
</body>
</html>
