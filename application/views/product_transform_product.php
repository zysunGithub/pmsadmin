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
<style>
input[readonly] { background: #eee; border: none; }
#materiala_exchange_table td, #package_exchange_table td { padding: 1px; }
#materiala_exchange_table input, #package_exchange_table input { width: 100%; border: none; }
.introduce { color: #ccc; line-height: 18px; }
.collect .transform_from { width: 500px; }
.collect .transform_from input { display: inline-block; box-sizing: border-box; line-height: 22px; height: 22px; width: 300px; }
.collect .transform_from label { box-sizing: border-box; width: 140px; }
.collect .arrow { width: 100px; margin-top: 100px; margin-right: 50px; }
.collect .transform_to { box-sizing: border-box; width: 600px; }
#info_table th { width: 80px; }
#info_table th:first { width: 200px; }
#info_table input { width: 100%; }
</style>
</head>
<body>
    <div class="container-fluid tabpanel" style="margin-left: -18px;padding-left: 19px;" >
        <div class="col-md-12">
            <!-- Nav tabs -->
            <input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> >
            <!-- Tab panes -->
            <div class="tab-content tabpanel">
                <form>
                    <div class="row">
                        <label class="col-sm-2 control-label">类型</label>
                        <div class="col-sm-3">
                            <select  name="transform_type" id="transform_type_raw" class="form-control">
                                <option value="RAW2RAW">原料转原料</option>
                                <option value="FINISHED2RAW">包裹转原料</option>
                            </select>
                        </div>
                        <label for="facility_id_raw" class="col-sm-2 control-label">仓库</label>
                        <div class="col-sm-3">
                            <select  name="facility_id" id="facility_id_raw" class="form-control">
                                <?php
                                if($is_all_facility_action) {
                                    echo "<option value=''>全部</option>";
                                }
                                foreach ($facility_list as $facility) {
                                    if (isset ($facility_id) && $facility['facility_id'] == $facility_id) {
                                        echo "<option value=\"{$facility['facility_id']}\" selected='true'>{$facility['facility_name']}</option>";
                                    } else {
                                        echo "<option value=\"{$facility['facility_id']}\">{$facility['facility_name']}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row" style="position:relative;">
                        <input type="hidden" id="from_product_id_raw" name="from_product_id"/>
                        <label class="col-sm-2 control-label">A果</label>
                        <div class="col-sm-3">
                            <input required="required" type="text" class="form-control" name="from_product_name" id="from_product_name_raw">
                        </div>
                        <div class="arguments_wrap">
                            <label class="col-sm-2 control-label">A果参数</label>
                            <div class="col-sm-3">
                                <table class="table table-striped table-bordered" id="list_from_raw">
                                    <thead>
                                        <tr>
                                            <th>箱规</th>
                                            <th>个数</th>
                                            <th>箱数</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="width:30%;">
                                                <select id="from_quantity_raw" style="width: 100%;">
                                                </select>
                                            </td>
                                            <td style="width:35%;">
                                                <input type="number" style="width: 100%;" id="from_num_raw">
                                            </td>
                                            <td style="width:35%;">
                                                <input type="number" style="width: 100%;" id="from_case_num_raw" readonly="readonly">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="case_num_raw hidden">
                            <label for="from_case_num" class="col-sm-2 control-label">个数</label>
                            <div class="col-sm-3">
                                <input required="required" type="number" class="form-control" name="from_case_num" id="from_case_num_fin">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 control-label">备注</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="note" id="note">
                        </div>
                    </div>
                    <div class="row">
                        <input type="hidden" id="to_product_id_raw" name="to_product_id"/>
                        <div class="col-sm-2 text-right">
                            <input type="button" class="btn btn-primary" value="转换为" id="exchange_btn">
                        </div>
                    </div>
                    <div class="modal fade" id="exchange_modal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">B果</h4>
                                    <div class="introduce introduce1">
                                        <p class="intro_item">1.转换比例是指一个A果能转换成n个B果</p>
                                        <p class="intro_item">2.先填一行的箱规，再填个数</p>
                                        <p class="intro_item">3.填好箱规和个数，箱数会自动计算，且不允许修改</p>
                                    </div>
                                    <div class="introduce introduce2 hidden">
                                        <p class="intro_item">1.转换比例是指一个A果能转换后包含n个B果</p>
                                        <p class="intro_item">2.个数是转换比例乘以A果份数</p>
                                        <p class="intro_item">3.填好箱规会自动计算箱数密切不允许手动输入箱数</p>
                                    </div>
                                </div>
                                <div class="modal-body table-responsive">
                                    <table class="table table-bordered table-condensed" id="materiala_exchange_table">
                                        <thead>
                                            <tr>
                                                <th>商品</th>
                                                <th>箱规</th>
                                                <th>个数</th>
                                                <th>箱数</th>
                                                <th>转换比例</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                    <label class="loss_label">损耗个数:
                                        <input type="text" class="form-control" name="loss" id="loss" style="display: inline-block; width: 80px;">
                                    </label>
                                    <table class="table table-bordered table-condensed hidden" id="package_exchange_table">
                                        <thead>
                                            <tr>
                                                <th style="width:40%;">水果</th>
                                                <th>个数</th>
                                                <th>箱规</th>
                                                <th>箱数</th>
                                                <th>转换比例</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>
                                    <button type="button" class="btn btn-primary" id="exchange_save">保存</button>
                                </div>
                            </div><!-- /.mod关闭ntent -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                </form>
            </div>
        </div>
        <div class="col-md-12 well collect">
            <div class="clearfix">
                <div class="transform_from clearfix pull-left">
                    <h3 class="text-center">A果</h3>
                    <div class="col-md-12 transform_type">
                        <label>类型：</label>
                        <input type="text" name="transform_type" value="" readonly="readonly">
                    </div>
                    <div class="col-md-12 facility_id">
                        <label>仓库：</label>
                        <input type="text" name="facility_id" value="" readonly="readonly">
                    </div>
                    <div class="col-md-12 from_product_name">
                        <label>A果：</label>
                        <input type="text" name="from_product_name" value="" readonly="readonly">
                    </div>
                    <div class="col-md-12 from_quantity">
                        <label>A果箱规：</label>
                        <input type="text" name="from_quantity" value="" readonly="readonly">
                    </div>
                    <div class="col-md-12 from_num">
                        <label>A果个数：</label>
                        <input type="text" name="from_num" value="" readonly="readonly">
                    </div>
                    <div class="col-md-12 from_case_num">
                        <label>A果箱数：</label>
                        <input type="text" name="from_case_num" value="" readonly="readonly">
                    </div>
                    <div class="col-md-12 from_case_num_fin hidden">
                        <label>A果个数：</label>
                        <input type="text" name="from_case_num_fin" value="" readonly="readonly">
                    </div> 
                    <div class="col-md-12 note">
                        <label>备注：</label>
                        <input type="text" name="note" value="" readonly="readonly">
                    </div>                       
                </div>
                <div class="arrow pull-left">
                    <img src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT; ?>assets/img/arrow.jpg">
                </div>
                <div class="transform_to pull-left">
                    <h3 class="text-center">B果</h3>
                    <table class="table table-bordered table-condensed" id="info_table">
                    </table>
                    <label class="hidden loss">损耗个数：
                        <input type="text" name="loss" class="form-control" readonly="readonly" style="display: inline-block; width:80px;">
                    </label>            
                </div>
            </div>
            <div class="text-center">
                <button class="btn btn-primary" id="submit">提交</button>
            </div>
        </div>
    </div>
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript">
var WEB_ROOT = $("#WEB_ROOT").val();
var myurl = WEB_ROOT + "ProductTransformProduct/applyProductTransformProduct";
var productAjax = null;//获取可以被转换的商品请求
var toProductAjax = null;//获取转换为的商品请求
var inventoryAjax = null;//获取包裹库存的请求
(function(){
    $('.collect .transform_type input').val( $('#transform_type_raw').find('option:selected').text() );
    $('.collect .transform_type input').data('type',$('#transform_type_raw').val());
    $('.collect .facility_id input').val( $('#facility_id_raw').find('option:selected').text() );
    $('.collect .facility_id input').data('type',$('#facility_id_raw').val());
    completeProduct( $('#transform_type_raw').val(),$('#facility_id_raw').val() );
})();

$('#exchange_btn').click(function(){
    if(!validBeforeModal()){
        return;
    }
    $('#materiala_exchange_table').find('tbody tr').each(function(){
        $(this).find('td').eq(1).find('input').val('');
        $(this).find('td').eq(2).find('input').val('');
        $(this).find('td').eq(3).find('input').val('');
        $('#loss').val('');
    });

    $('#package_exchange_table').find('tbody tr').each(function(){
        $(this).find('td').eq(2).find('input').val('');
        $(this).find('td').eq(3).find('input').val('');
    });

    var type = $('#transform_type_raw').val();
    if( type === 'RAW2RAW' ){
        $('#package_exchange_table').addClass('hidden');
        $('.introduce2').addClass('hidden');
        $('#materiala_exchange_table').removeClass('hidden');
        $('.introduce1').removeClass('hidden');
        $('.loss_label').removeClass('hidden');
    }else if( type === 'FINISHED2RAW' ){
        $('#package_exchange_table').removeClass('hidden');
        $('.introduce2').removeClass('hidden');
        $('#materiala_exchange_table').addClass('hidden');
        $('.introduce1').addClass('hidden');
        $('.loss_label').addClass('hidden');
        var from_case_num_fin = $('#from_case_num_fin').val();//份数
        var $tr = $('#package_exchange_table').find('tbody tr');
        $tr.each(function(){
            var $this = $(this);
            $this.find('td').eq(1).find('input').val( $this.find('td').eq(4).find('input').val()*from_case_num_fin );
        });
    }
    $('#exchange_modal').modal('show');    
});

function getTransfromProductList(transform_type,product_id){//根据product_id获取可以转换为的商品列表
    if(toProductAjax){
        toProductAjax.abort();
    }
    var data = {
        'transform_type' : transform_type,
        'from_product_id' : product_id
    };
    console.log(data);
    toProductAjax = $.ajax({
        url : WEB_ROOT+'ProductTransformProduct/getTransfromProductList',
        type : 'GET',
        data : data,
        dataType : 'json'
    }).fail(function(xhr){
        if( xhr.statusText !== 'abort' ){
            alert('获取可转换为商品列表请求失败');
        }
    });

    return toProductAjax;
}

function validBeforeModal(){
    var type = $('#transform_type_raw').val()
        from_product_name = $('#from_product_name_raw').val(),
        from_quantity = $('#from_quantity_raw').val(),//被转换商品箱柜
        from_case_num = $('#from_case_num_raw').val(),//被转换商品箱数
        inventoryQoh = $('#from_quantity_raw').find('option:selected').data('inventoryqoh');
        from_case_num_fin = $('#from_case_num_fin').val();
    if( type === '' ){
        alert('请先选择转换类型');
        return false;
    }
    if( from_product_name === '' ){
        alert('请先填好被转换商品');
        return false;
    }
    if( type === 'RAW2RAW' ){
        if( from_quantity === '' ){
            alert('请先填好被转换商品箱柜');
            return false;
        }
        if( from_case_num === '' ){
            alert('请先填好被转换商品箱数');
            return false;
        }
        if( +from_case_num > +inventoryQoh ){
            alert('箱数不能大于库存');
            return false;
        }
    }else if( type === 'FINISHED2RAW' ){
        if( from_case_num_fin === '' ){
            alert('请先填好份数');
            return false;
        }
    }/*modal show之前验证结束*/

    return true;
}

$('#exchange_save').click(function(){
    if(!checkData()){
        return;
    }
    var $table = $('#exchange_modal').find('table:visible');
    var $clone_head = $table.find('thead').clone();
    var $clone_body = $table.find('tbody').clone();
    $('#info_table').html('');
    $('#info_table').append($clone_head);

    if( $('#transform_type_raw').val() === 'RAW2RAW' ){
        $clone_body.find('tr').each(function(){
            var $this = $(this),
                to_container_quantity = +$this.find('input').eq(1).val(),
                to_num = +$this.find('input').eq(2).val();
            if( !(to_container_quantity && to_num) ){
                $this.remove();
            }
        });
    }else if( $('#transform_type_raw').val() === 'FINISHED2RAW' ){
        var flag = true;
        $clone_body.find('input').each(function(){
            if( $(this).val()=='' ){
                flag = false;
                return false;
            }
        });
        if( !flag ){
            alert('包裹转原料，转换后不允许为空');
            return;
        }
    }
          
    $('#info_table').append($clone_body);    
    $('#info_table').find('input').attr('readonly','readonly');
    if( $('#transform_type_raw').val() === 'RAW2RAW' ){
        $('.transform_to input[name=loss]').val( $('#loss').val() );
        $('.transform_to .loss').removeClass('hidden');
    }else if( $('#transform_type_raw').val() === 'FINISHED2RAW' ){
        $('.transform_to input[name=loss]').val('');
        $('.transform_to .loss').addClass('hidden');
    }
    $('#exchange_modal').modal('hide');
});

function isInt(str){
    var re = /^\d+$/;
    return re.test(str);
}

function checkData(){//检测被转换和转换为的值是否相等
    var transform_type = $('#transform_type_raw').val(),
        $table = $('#exchange_modal').find('table:visible');
    if( transform_type === 'RAW2RAW' ){
        var fromNum = ($('#from_quantity_raw').find('option:selected').text())*($('#from_case_num_raw').val());
        var toNum = 0;
        var lossNum = +$('#loss').val();
        var flag = true;
        $table.find('tbody tr').each(function(){
            var $this = $(this);
            var to_num = +$this.find('input').eq(2).val();
            var scale = +$this.find('input').eq(4).val();
            if( !isInt(to_num/scale) ){
                alert('转换后的个数除以比例必须为整数');
                flag = false;
                return false;
            }
            toNum += (to_num/scale);
        });
        if(!flag){
            return false;
        }
        if( Math.abs(fromNum-toNum-lossNum)>=1 ){
            alert('被转换和转换为的值不相等');
            return false;
        }else {
            return true;
        }
    }else if( transform_type === 'FINISHED2RAW' ){
        var flag = true;
        /*$table.find('tbody tr').each(function(){
            var $this = $(this),
                $input = $this.find('input');

            if( +$input.eq(1).val() !== $input.eq(2).val()*$input.eq(3).val() ){
                flag = false;
                alert('被转换和转换为的值不相等');
                return false;
            }
        });*/
        return flag;
    }

}

$('#facility_id_raw').on('change',function(){
    completeProduct( $('#transform_type_raw').val(),$('#facility_id_raw').val() );
    $('.collect .facility_id input').val( $('#facility_id_raw').find('option:selected').text() );
    $('.collect .facility_id input').data('type',$('#facility_id_raw').val());
    $('#from_case_num_raw').val('');
    $('#note').val('');
    $('.collect .from_product_name input').val('');
    $('.collect .from_quantity input').val('');
    $('.collect .from_case_num input').val('');
    $('.collect .note input').val('');
    $('#from_case_num_fin').val('');
    $('.collect .from_case_num_fin input').val('');
    $('#from_num_raw').val('');
    $('.collect .from_num input').val('');
    $('#info_table').html('');
    $('#loss').val('');
    $('.collect .loss input').val('');
});

$('#transform_type_raw').on('change',function(){
    var type = $(this).val();
    if( type === 'RAW2RAW' ){
        $('.case_num_raw').addClass('hidden');
        $('.arguments_wrap').removeClass('hidden');
        $('.position_show').removeClass('hidden');
        $('#from_case_num_fin').val('');
        $('.collect .from_case_num_fin input').val('');
        $('.collect .from_case_num_fin').addClass('hidden');
        $('.collect .from_product_name').removeClass('hidden');
        $('.collect .from_quantity').removeClass('hidden');
        $('.collect .from_case_num').removeClass('hidden');
        $('.collect .from_num').removeClass('hidden');
        $('#loss').removeClass('hidden');
        $('.collect .loss input').removeClass('hidden');
    }else if( type === 'FINISHED2RAW' ){
        $('.arguments_wrap').addClass('hidden');
        $('.position_show').addClass('hidden');
        $('.case_num_raw').removeClass('hidden');
        $('#from_case_num_raw').val('');
        $('.collect .from_product_name input').val('');
        $('.collect .from_quantity input').val('');
        $('.collect .from_case_num input').val('');
        $('#from_num_raw').val('');
        $('.collect .from_num input').val('');
        $('.collect .from_quantity').addClass('hidden');
        $('.collect .from_case_num').addClass('hidden');
        $('.collect .from_num').addClass('hidden');
        $('.collect .from_case_num_fin').removeClass('hidden');
        $('#loss').val('');
        $('.collect .loss input').val('');
        $('#loss').addClass('hidden');
        $('.collect .loss input').addClass('hidden');
    }
    $('#info_table').html('');
    $('#note').val('');
    $('.collect .note input').val('');
    completeProduct( type,$('#facility_id_raw').val() );
    $('.collect .transform_type input').val( $('#transform_type_raw').find('option:selected').text() );
    $('.collect .transform_type input').data('type',$('#transform_type_raw').val());
});

$('#from_product_name_raw').focus(function(){
    var val = $(this).val();
    $(this).data('oval',val);
}).blur(function(){
    var $this = $(this),
        val = $this.val(),
        oval = $this.data('oval');
    if(oval===val && val!==''){
        return;
    }
    $('#from_case_num_raw').val('');
    $('#from_case_num_fin').val('');
    $('#from_num_raw').val('');
    $('.collect .from_product_name input').val(val);
    $('.collect .from_case_num input').val('');
    $('.collect .from_num input').val('');
    $('.collect .from_quantity input').val( $('#from_quantity_raw').find('option:selected').text() );
});

$('#from_quantity_raw').on('change',function(){
    var from_quantity = $(this).find('option:selected').text();
    var from_num = $('#from_num_raw').val();
    $('#from_num_raw').val('');
    $('#from_case_num_raw').val('');
});

$('#from_num_raw').on('change',function(){
    var from_quantity_raw = $('#from_quantity_raw').find('option:selected').text();
    var from_num = $(this).val();
    var inventoryQoh = $(this).closest('tr').find('td option:selected').data('inventoryqoh');
    if( from_num !== '' ){
        if( from_quantity_raw === '' ){
            alert('请先选择箱规');
            return;
        }
        var caseNum = (from_num/from_quantity_raw).toFixed(2);
        if( +caseNum > +inventoryQoh ){
            alert('不能大于库存');
            return;
        }
        $('#from_case_num_raw').val( caseNum );
        $('.collect .from_case_num input').val( caseNum );
        $('.collect .from_num input').val( from_num );
    }else{
        $('#from_case_num_raw').val('');
    }
    $('#info_table').html('');
});

$('#from_case_num_raw').on('change',function(){
    var from_quantity_raw = $('#from_quantity_raw').find('option:selected').text();
    var inventoryQoh = $(this).closest('tr').find('td option:selected').data('inventoryQoh');
    var caseNum = $(this).val();
    if( caseNum === '' ){
        $('#from_num_raw').val('');
    }else{
        if( +caseNum > +inventoryQoh ){
            alert('不能大于库存');
            return;
        }    
        $('.collect .from_case_num input').val( $('#from_case_num_raw').val() );
        $('.collect .from_num input').val( from_quantity_raw );
    }
    $('#info_table').html('');
});

$('#from_case_num_fin').on('change',function(){
    var case_num = $(this).val();
    var inventoryQoh = $(this).data('inventoryQoh');
    if( case_num !== '' ){
        if( +case_num > +inventoryQoh ){
            alert('不能大于库存');
            return;
        }
    }
    $('.collect .from_case_num_fin input').val( case_num );
    $('#info_table').html('');
});

$('#note').on('change',function(){
    $('.collect .note input').val( $('#note').val() );
});

$('#materiala_exchange_table tbody').on('change','tr',function(ev){
    var $to_quantity_input = $(this).find('td').eq(1).find('input');
    var $to_num_input = $(this).find('td').eq(2).find('input');
    var $to_case_num_input = $(this).find('td').eq(3).find('input');

    if( ev.target === $to_quantity_input[0] ){
        if( $to_quantity_input.val() === '' ){
            $to_num_input.val('');
            $to_case_num_input.val('');
        }else if( $to_quantity_input.val() === '0' ){
            $to_num_input.val(0);
            $to_case_num_input.val(0);
        }else{
            $to_case_num_input.val( ($to_num_input.val()/$to_quantity_input.val()).toFixed(2) );
        }
    }else if( ev.target === $to_num_input[0] ){
        if( $to_num_input.val() === '' ){
            $to_quantity_input.val('');
            $to_case_num_input.val('');
        }else if( $to_num_input.val() === '0' ){
            $to_quantity_input.val(0);
            $to_case_num_input.val(0);
        }else{
            if( $to_quantity_input.val() == 0 ){
                $to_num_input.val( $to_quantity_input.val() );
                $to_case_num_input.val( $to_quantity_input.val() );
            }else{
                $to_case_num_input.val( ($to_num_input.val()/$to_quantity_input.val()).toFixed(2) );   
            }
        }
    }
});

$('#package_exchange_table tbody').on('change','tr',function(ev){
    var $to_num_input = $(this).find('td').eq(1).find('input');
    var $to_quantity_input = $(this).find('td').eq(2).find('input');
    var $to_case_num_input = $(this).find('td').eq(3).find('input');

    if( ev.target === $to_quantity_input[0] ){
        if( $to_quantity_input.val() === '' ){
            $to_case_num_input.val('');
        }else if( $to_quantity_input.val() === '0' ){
            $to_case_num_input.val(0);
        }else{
            $to_case_num_input.val( ($to_num_input.val()/$to_quantity_input.val()).toFixed(2) );
        }
    }/*else if( ev.target === $to_case_num_input[0] ){
        if( $to_case_num_input.val() === '' ){
            $to_quantity_input.val('');
        }else if( $to_case_num_input.val() == 0 ){
            $to_quantity_input.val( $to_case_num_input.val() );
        }else{
            $to_case_num_input.val( ($to_num_input.val()/$to_quantity_input.val()).toFixed(2) );
        }
    }*/
});

function getProductRelatedList(product_type,facility_id){
    if(productAjax){
        productAjax.abort();
    }
    productAjax = $.ajax({
        url : WEB_ROOT + "ProductTransformProduct/getRawFinList?product_type=" + product_type+"&facility_id="+facility_id,
        type : "GET",
        dataType : "json"
    }).fail(function(xhr){
        if(xhr.statusText !== 'abort'){
            alert('获取产品列表请求失败');
        }
    });

    return productAjax;
}

function autoComplete($obj,opts,data){
    $obj.unautocomplete();
    var defaults = {
        minChars: 0,
        width: 310,
        max: 100,
        matchContains: true,
        autoFill: false,
        cacheLength: 0
    };

    var settings = $.extend({},defaults,opts,true);
    return $obj.autocomplete(data,settings);
}

function completeProduct(product_type,facility_id){//得到商品列表及其相关信息
    var data_list = [];
    $('#from_product_name_raw').val('');
    $('#from_quantity_raw').html('');
    $('#from_product_name_raw').attr('disabled','disabled');

    getProductRelatedList(product_type,facility_id).done(function(data){
        if( data.success === 'success' ){
            console.log( data );
            $('#from_product_name_raw').removeAttr('disabled');
            var $from_product_name = $('#from_product_name_raw');
            var opts = {
                    formatItem: function(row, i, max) {
                        return('[' +row.from_product_id + ']' + row.from_product_name);
                    },
                    formatMatch: function(row, i, max) {
                        return('[' +row.from_product_id + ']' + row.from_product_name);
                    },
                    formatResult: function(row) {
                        return('[' +row.from_product_id + ']' + row.from_product_name);
                    }
                };

            data_list = data.product_transform_mapping_list;
            autoComplete( $from_product_name,opts,data_list ).result(function(event,row,formatted){
                $('.collect .from_product_name input').val( row.from_product_name );
                if( product_type === 'RAW2RAW' ){
                    var $from_quantity_raw = $('#from_quantity_raw'),
                        str = '';
                    $.each(row.product_container_list,function(i,ele){
                        str += '<option value="'+this.container_id+'" data-inventoryQoh="'+this.inventoryQoh+'">'+this.quantity+'</option>';
                    });
                    $from_quantity_raw.html(str);
                }else if( product_type === 'FINISHED2RAW' ){
                    $('#from_case_num_fin').data('inventoryQoh',row.inventoryQoh);
                }

                $from_product_name.data('from_product_id',row.from_product_id);
                $from_product_name.val( row.from_product_name );
                var type = $('#transform_type_raw').val();
                var from_product_id = $('#from_product_name_raw').data('from_product_id');
                $('#materiala_exchange_table').find('tbody').html('');
                $('#package_exchange_table').find('tbody').html('');
                getTransfromProductList(type,from_product_id).done(function(data){
                    var str = '';
                    if(data.success === 'success'){
                        console.log(data);
                        $.each(data.product_list,function(){
                            if(type==='RAW2RAW'){
                                str += '<tr><td style="width:40%;"><input type="text" readonly="readonly" value="'+this.to_product_name+'" data-to_product_id="'+this.to_product_id+'"></td><td><input type="text"></td><td><input type="text"></td><td><input type="text" readonly="readonly"></td><td><input type="text" value="'+this.quantity+'" readonly="readonly"></td></tr>';
                            }else if(type==='FINISHED2RAW'){
                                str += '<tr><td style="width:40%;"><input type="text" readonly="readonly" value="'+this.to_product_name+'" data-to_product_id="'+this.to_product_id+'"></td><td><input type="text" value="'+this.quantity+'" readonly="readonly"></td><td><input type="text"></td><td><input type="text" readonly="readonly"></td><td><input type="text" value="'+this.quantity+'" readonly="readonly"></td></tr>';
                            }
                        });
                        if(type==='RAW2RAW'){
                            $('#materiala_exchange_table').find('tbody').html(str);
                        }else if(type==='FINISHED2RAW'){
                            $('#package_exchange_table').find('tbody').html(str);
                        }
                    }else{
                        alert(data.error_info);
                    }
                });
            });
        }
    });
}

$('#submit').on('click',function(){
    var $collect = $('.collect'),
        $info_table = $('#info_table'),
        transform_type = $('#transform_type_raw').val(),
        facility_id = +$('#facility_id_raw').val(),
        from_product_id = $('#from_product_name_raw').data('from_product_id'),
        from_case_num_raw = $('#from_case_num_raw').val(),
        from_case_num_fin = $('#from_case_num_fin').val();
        from_container_id = $('#from_quantity_raw').val();
        from_container_quantity = $('#from_quantity_raw').find('option:selected').text();
        from_quantity = $('#from_num_raw').val();
        note = $('#note').val(),
        loss_quantity = +$('.loss input').val();

    if( transform_type === 'RAW2RAW' ){
        if( from_product_id === '' ){
            alert('请先选择被转换商品');
            return;
        }
        if( from_container_quantity === '' ){
            alert('请先选择箱规');
            return;
        }
        if( from_case_num_raw === '' ){
            alert('请先选择箱数');
            return;
        }
    }else if( transform_type === 'FINISHED2RAW' ){
        if( from_case_num_fin === '' ){
            alert('请先选择份数');
            return;
        }
    }

    if( $('#info_table tbody').html() === '' ){
        alert('没有要转换的数据');
        return;
    }

    var to_product_info = [];
    if( transform_type === 'RAW2RAW' ){
        var $tr = $info_table.find('tbody tr');
        $tr.each(function(){
            var $this = $(this),
                tempData = {};
            tempData['to_product_id'] = $this.find('td').eq(0).find('input').data('to_product_id');
            tempData['to_container_quantity'] = $this.find('td').eq(1).find('input').val();
            tempData['to_quantity'] = $this.find('td').eq(2).find('input').val();
            tempData['to_case_num'] = $this.find('td').eq(3).find('input').val();
            to_product_info.push(tempData);
        });
    }else if( transform_type === 'FINISHED2RAW' ){
        var $tr = $info_table.find('tbody tr');
        $tr.each(function(){
            var $this = $(this),
                tempData = {};
            tempData['to_product_id'] = $this.find('td').eq(0).find('input').data('to_product_id');
            tempData['to_quantity'] = $this.find('td').eq(1).find('input').val();
            tempData['to_container_quantity'] = $this.find('td').eq(2).find('input').val();
            tempData['to_case_num'] = $this.find('td').eq(3).find('input').val();
            to_product_info.push(tempData);
        });
    }

    var data = {};
    facility_id && (data['facility_id']=facility_id);
    transform_type && (data['transform_type']=transform_type);
    from_product_id && (data['from_product_id']=from_product_id);
    from_container_id && (data['from_container_id']=from_container_id);
    from_container_quantity && (data['from_container_quantity']=from_container_quantity);
    from_quantity && (data['from_quantity']=from_quantity);
    to_product_info && (data['to_product_info']=to_product_info);

    if( transform_type === 'RAW2RAW' ){
        from_case_num_raw && (data['from_case_num']=from_case_num_raw);
        data['loss_quantity'] = loss_quantity;
    }else if( transform_type === 'FINISHED2RAW' ){
        from_case_num_fin && (data['from_quantity']=from_case_num_fin);
    }
    console.log( data );
    submitAjax.call( $('#submit'),data );
});

function submitAjax(data){
    $(this).attr('disabled','disabled');
    $.ajax({
        url : WEB_ROOT+'ProductTransformProduct/applyProductTransformProduct',
        type : 'POST',
        data : data,
        dataType : 'json'
    }).done(function(data){
        if(data.success === 'success'){
            alert('提交成功');
            $(this).removeAttr('disabled');
            window.location.reload();
        }else{
            alert(data.error_info);
            $(this).removeAttr('disabled');
        }
    }).fail(function(xhr,textStatus,errorThrown){
        alert(textStatus+':提交转换信息请求失败');
        $(this).removeAttr('disabled');
    });
}
</script>
</body>
</html>