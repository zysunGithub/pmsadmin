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
    <script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/slider.js"></script>
    <script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/dataTables.buttons.js"></script>
    <script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/buttons.colVis.js"></script>
    <script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/buttons.flash.js"></script>
    <style type="text/css">
        .button_margin {
            margin: 8%;
        }
        .banner { position: relative; overflow: auto; text-align: center;}
        .banner li { list-style: none; }
        .banner ul li { float: left; }
    </style>
    <style>
        .flexslider {
            margin: 0px auto 20px;
            position: relative;
            width: 100%;
            height: 482px;
            overflow: hidden;
            zoom: 1;
        }

        .flexslider .slides li {
            width: 100%;
            height: 100%;
        }

        .flex-direction-nav a {
            width: 70px;
            height: 70px;
            line-height: 99em;
            overflow: hidden;
            margin: -35px 0 0;
            display: block;
            background: url(/assets/img/ad_ctr.png) no-repeat;
            position: absolute;
            top: 50%;
            z-index: 10;
            cursor: pointer;
            opacity: 0;
            filter: alpha(opacity=0);
            -webkit-transition: all .3s ease;
            border-radius: 35px;
        }

        .flex-direction-nav .flex-next {
            background-position: 0 -70px;
            right: 0;
        }

        .flex-direction-nav .flex-prev {
            left: 0;
        }

        .flexslider:hover .flex-next {
            opacity: 0.8;
            filter: alpha(opacity=25);
        }

        .flexslider:hover .flex-prev {
            opacity: 0.8;
            filter: alpha(opacity=25);
        }

        .flexslider:hover .flex-next:hover,
        .flexslider:hover .flex-prev:hover {
            opacity: 1;
            filter: alpha(opacity=50);
        }

        .flex-control-nav {
            width: 100%;
            position: absolute;
            bottom: 10px;
            text-align: center;
        }

        .flex-control-nav li {
            margin: 0 2px;
            display: inline-block;
            zoom: 1;
            *display: inline;
        }

        .flex-control-paging li a {
            background: url(/assets/img/dot.png) no-repeat 0 -16px;
            display: block;
            height: 16px;
            overflow: hidden;
            text-indent: -99em;
            width: 16px;
            cursor: pointer;
        }

        .flex-control-paging li a.flex-active,
        .flex-control-paging li.active a {
            background-position: 0 0;
        }

        .flexslider .slides a img {
            width: 100%;
            height: 482px;
            display: block;
        }
    </style>
    <script>
        function frameOnload(){
            $(window.frames['asn_list'].document).on('click','.checkbox',function(event){
                var id=$(event.target).attr('data-asn-item-id');
                if ($(event.target).is(":checked")) {
                    if ($('.checkbox[data-asn-item-id='+id+']').length == 0) {
                        var rows = $(window.frames['asn_list'].document).find('tr[data-id='+id+']');
                        var len = rows.length;
                        for (var i = 0; i < len; i++) {
                            if (i == 0) {
                                var row = $(rows[i]).clone();
                                var type = row.find('td:last').remove();
                                row.find('td:last').remove();
                                row.append(type);
                                $("#asn_items").append(row);
                            } else {
                                $("#asn_items").append($(rows[i]).clone());
                            }
                        }
                    }
                } else {
                    $('tr[data-id='+id+']').remove();
                }
            });
        }
    </script>
</head>
<body>
<?php  $CI =& get_instance();
$CI->load->library('session');?>

<iframe src="./index" id="asn_list" name="asn_list" frameborder="0" width="100%" height="800px" onload="frameOnload()"></iframe>
    <div style="height: 400px;overflow: scroll;">
        <table id="asn_items" class="table table-striped table-bordered ">

        </table>
    </div>
<div class="row">
    <input type="button" class="btn btn-primary col-md-offset-1" id="genPayment" value="生成付款单">
</div>
<!-- 上传Modal -->
<div>
    <div class="modal fade ui-draggable text-center" id="uploadModal" role="dialog"  >
        <div class="modal-dialog" style="display: inline-block; width: 600px">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" id="btnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">扫描件上传</h4>
                </div>
                <div class="modal-body" style="text-align: left; margin-left:15%">
                    <div class='row'>
                        <label  style="text-align: right;">扫描件：</label><input type="file"  name="uploaded_file" id="upload-file" >
                    </div>
                </div>
                <div class="modal-footer">
                    <input id="doUpload" type="button" class="btn btn-primary" style="text-align: right" value="提交">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal end  -->
<!-- 显示 modal -->
<div>
    <div class="modal fade ui-draggable text-center" id="viewModal" role="dialog"  >
        <div class="modal-dialog" style="display: inline-block; width: 600px">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" id="btnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">扫描件</h4>
                </div>
                <div class="modal-body" style="text-align: left;">
                    <div id="images" class="flexslider"></div>
                </div>
                <div class="modal-footer">
                    <input id="delete" class="btn btn-primary" type="button" value="删除">
                    <input id="view" data-dismiss="modal" type="button" class="btn btn-primary" style="text-align: right" value="确定">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal end-->
<!-- 付款申请 modal-->
<div>
    <div class="modal fade ui-draggable text-center" id="paymentModal" role="dialog"  >
        <div class="modal-dialog" style="display: inline-block; width: 900px">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" id="btnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">付款申请</h4>
                </div>
                <div class="modal-body" style="text-align: left;">
                    <div class="row"></div>
                    <div style="overflow: auto;">
                        <table  class="table table-striped table-bordered">
                            <tr>
                                <th rowspan="2">ASN ITEM ID</th>
                                <th rowspan="2">冻结</th>
                                <th rowspan="2">ASN日期</th>
                                <th rowspan="2">区域</th>
                                <th rowspan="2">仓库</th>
                                <th rowspan="2">商品名称</th>
                                <th rowspan="2">PRODUCT_ID</th>
                                <th rowspan="2">采购员</th>
                                <th rowspan="2">供应商</th>
                                <th rowspan="2">申请人</th>
                                <th colspan="6" style="text-align: center;">采购</th>
                                <th colspan="6" style="text-align: center;">调度</th>
                                <th colspan="9" style="text-align: center;">仓库</th>
                                <th rowspan="2">单位</th>
                                <th rowspan="2">入库含税总金额</th>
                                <th colspan="7" style="text-align: center;">供应商退货</th>
                                <th colspan="9" style="text-align: center;">供价调整</th>
                                <th rowspan="2">应付</th>
                            </tr>
                            <tr>
                                <th>时间</th>
                                <th>价格录入员</th>
                                <th>总数</th>
                                <th>箱数</th>
                                <th>录价格箱数</th>
                                <th>箱规</th>
                                <th>总箱数</th>
                                <th>虚拟仓在途盘亏数量</th>
                                <th>虚拟仓暂存盘亏数量</th>
                                <th>时间</th>
                                <th>箱数</th>
                                <th>入库员</th>
                                <th>总数</th>
                                <th>总箱数</th>
                                <th>时间</th>
                                <th>仓库</th>
                                <th>箱数</th>
                                <th>箱规</th>
                                <th>入库员</th>
                                <th>入库含税单价</th>
                                <th>进项税率</th>
                                <th>类型</th>
                                <th>单价</th>
                                <th>箱数</th>
                                <th>箱规</th>
                                <th>申请总金额</th>
                                <th>退货金额</th>
                                <th>收款总金额</th>
                                <th>采购数量</th>
                                <th>补货数量</th>
                                <th>调整时状态</th>
                                <th>含税总价</th>
                                <th>进项税率</th>
                                <th>扣除率</th>
                                <th>不含税单价</th>
                                <th>其他费用</th>
                                <th>调整率</th>
                            </tr>
                            <tbody id="resultTable"></tbody>
                        </table>
                    </div>
                    <div class="row">

                        <label for="note" class="control-label col-md-2">备注</label>
                        <div class="col-md-3">
                            <input id="note" type="text" class="form-control">
                        </div>
                        <label for="amount" class="control-label col-md-2">应付合计</label>
                        <div class="col-md-3">
                            <input id="amount" type="text" readonly="true" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <label for="unit" class="control-label col-md-2">收款单位</label>
                        <div class="col-md-3">
                            <input id="unit" type="text" class="form-control">
                        </div>
                        <label for="bank" class="control-label col-md-2">收款银行</label>
                        <div class="col-md-3">
                            <input id="bank" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <label for="account" class="control-label col-md-2">收款账号</label>
                        <div class="col-md-3">
                            <input id="account" type="text" class="form-control">
                        </div>
                        <label for="area" class="control-label col-md-2">所属大区</label>
                        <div class="col-md-3">
                            <select id="area" name="area" class="form-control">
                                <?php foreach ($area_list as $area) {
                                    echo "<option value=\"{$area['area_id']}\">{$area['area_name']}</option>";
                                }
                                ?>

                            </select>
                        </div>
                    </div>
                    <div id="images_holder"></div>
                    <div class="row">
                        <div class="col-md-offset-3">
                            <button class="btn btn-primary" id="add_image">添加扫描件</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input id="genRequest"  type="button" class="btn btn-primary" style="text-align: right" value="立即申请">
                </div>
            </div>
        </div>
    </div>
</div>
<!--  end -->
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/lhgcalendar.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js"></script>
<script type="text/javascript">
    var property={
        divId:"demo1",
        needTime:true,
        yearRange:[1970,2030],
        week:['日','一','二','三','四','五','六'],
        month:['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月'],
        format:"yyyy-MM-dd hh:mm:00"
    };


    var WEB_ROOT = "<?php if(isset($WEB_ROOT)) echo $WEB_ROOT; ?>";
    var upload_path = "<?php echo $upload_path;?>";;

    // 点击下载 excel 按钮
    $('#download').click(function(){
        $("#act").val("download");
        $("form").submit();
        $("#act").val("query");
    });
    $("#add_image").click(function(){
        var image = $('<input type="file" class="form-control image">');
        var div1 = $('<div class="row"></div>');
        var div2 = $('<div class="col-md-5"></div>');
        var div3 = $('<div class="col-md-5"></div>');
        var deleteButton = $('<input class="btn btn-danger delete" type="button" value="删除">');
        div2.append(image);
        div3.append(deleteButton);
        div1.append(div2);
        div1.append(div3);
        image.trigger('click');
        $("#images_holder").append(div1);
    });
    $(document).on('click', '.delete', function(){
        $(this).parent().parent().remove();

    });


    $("#search").click(function(){
        $("#page_current").val("1");
        $("form").submit();
    });

    // 分页
    $('a.page').click(function(){
        var page =$(this).attr('p');
        $("#page_current").val(page);
        $("form").submit();
    });

    // 上一页
    $('a#page_prev').click(function(){
        var page = $("#page_current").val();
        if(page != parseInt(page) ) {
            $('#page_current').val(1);
            page = 1;
        }else{
            page = parseInt(page);
            if(page > 1 ){
                page = page - 1;
                $('#page_current').val(page);
                $("form").submit();
            }
        }
    });

    // 下一页
    $('a#page_next').click(function(){
        var page = $("#page_current").val();
        page = parseInt(page);
        var page_count = $("#page_count").val();
        page_count = parseInt(page_count);
        if(page < page_count ){
            page = page + 1;
            $("#page_current").val(page);
            $("form").submit();
        }
    });
    var requestType;
    $("#genPayment").click(function(){
        paymentRequest();
    });
    var items;
    function paymentRequest(){
        items = [];
        var checked = $('#asn_items .checkbox:checked');
        var sum = 0;
        if (!checked.length) {
            alert('请勾选数据');
            return;
        }
        supplierId = $(checked[0]).attr('data-supplier-id');
        requestType = 'G';
        var first = true;
        for (var i = 0; i < checked.length; i++) {
            var tr = $(checked[i]).parent().parent();
            var supplier = tr.find('.supplier-name').html();
            if (!(parseFloat(tr.find('.arrival-case-num').html())>0)) {
                alert("未入库不能申请");
                return
            }
            if (supplier.indexOf('PO调整')!=-1 || supplier.indexOf('规格转换')!=-1) {
                items.push($(checked[i]).attr('data-asn-item-id'));
                continue;
            }
            if (first) {
                type = tr.find('.supplier-type').html();
                supplierId = $(checked[i]).attr('data-supplier-id');
                if (type=='company'||type=='cooperative') {
                    requestType = 'G';
                } else if (type=='market') {
                    requestType = 'S';
                } else {
                    alert("请确保供应商类型正确");
                    return;
                }
                first = false;
            }

            if (type == 'company' || type == 'cooperative') {
                if ($(checked[i]).attr('data-supplier-id') != supplierId) {
                    alert("生成对公付款申请时除PO调整外供应商必须相同");
                    return;
                }
            } else if (type == 'market') {
                if (tr.find('.supplier-type').html()!='market') {
                    alert("供应商类型不同不能生成付款申请");
                    return;
                }
            } else {
                alert("请确保供应商类型正确");
                return;
            }


            items.push($(checked[i]).attr('data-asn-item-id'));
            sum += parseFloat($(checked[i]).parent().parent().find('.amount').html());
        }
        if (first) {
            alert('不能全为PO调整或规格转换');
            return;
        }
        $("#resultTable").html('');
        var head1 = $('#thead1').clone();
        head1.find(':first').remove();
        head1.find(':last').remove();
        $('#resultTable').append(head1);
        $('#resultTable').append($('#thead2').clone());
        var row;
        for (var i = 0; i <checked.length; i++) {
//            row = $(checked[i]).parent().parent().clone();
//            row.find(":first").remove();
//            row.find("td:last").remove();
//            row.find("td:last").remove();
            var id = $(checked[i]).attr('data-asn-item-id');
            var rows = $("tr[data-id="+id+"]");
            var len = rows.length;
            for (var j = 0; j<len;j++) {
                if (j == 0) {
                    row = $(rows[j]).clone();
                    row.find(":first").remove();
                    row.find("td:last").remove();
                    row.find("td:last").remove();
                } else {
                    row = $(rows[j]).clone();
                }
                $('#resultTable').append(row);
            }
        }
        $("#amount").val(sum);
        $("#paymentModal").modal("show");
        if (requestType == 'S') {
            $("#unit").attr('readonly','readonly');
            $("#bank").attr('readonly','readonly');
            $("#account").attr('readonly','readonly');
        } else {
            $("#unit").removeAttr('readonly');
            $("#bank").removeAttr('readonly');
            $("#account").removeAttr('readonly');
        }
    }
    $(document).on('click','.btn-upload',function(){
        $("#uploadModal").modal("show");
        $("#upload-file").val('');
        asnItemId = $(this).parent().parent().find(".checkbox").attr("data-asn-item-id");
        uploadTd = $(this).parent();
    });
    $(document).on('click','#doUpload',function(){
        var formData = new FormData();
        formData.append('asnItemId', asnItemId);
        formData.append('file',document.getElementById("upload-file").files[0]);
        $.ajax({
            type:'POST',
            url:WEB_ROOT+'purchasePayment/upload',
            data:formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            success:function(data) {
                if (data.success == 'true') {
                    alert("上传成功");
                    if (!uploadTd.find('.btn-view').length) {
                        $('<input type="button" class="btn btn-success btn-view" value="查看">').appendTo(uploadTd);
                        $('<input type="hidden" class="image-url" value="'+data.path+'">').appendTo(uploadTd);
                    } else {
                        var imageURL = uploadTd.find('.image-url');
                        imageURL.val(imageURL.val()+','+data.path);
                    }
                    $(window.frames['asn_list'].document).find('tr[data-id='+asnItemId+']').find('.image-operation').html(uploadTd.html());
                } else {
                    alert("上传失败："+data.error_info);
                }
            }
        });
        $("#uploadModal").modal("hide");
    })
    function genUl(urls) {
        var element = '<ul class="slides">';
        var len = urls.length;
        for (var i = 0; i < len; i++) {
            element += '<li id="i'+urls[i].substring(0,urls[i].lastIndexOf('.'))+'"><a><img height="400px" width="600px" style="background: url('+WEB_ROOT+upload_path+urls[i]+') no-repeat center;" src="/assets/img/alpha.png"></a></li>';
        }
        element += '</ul>'
        element += '<ul class="flex-direction-nav">';
        element += '<li><a class="flex-prev" href="javascript:;">Previous</a></li>';
        element += '<li><a class="flex-next" href="javascript:;">Next</a></li>';
        element += '</ul>';
        element += '<ol id="bannerCtrl" class="flex-control-nav flex-control-paging">';
        for(var i = 0; i < len; i++) {
            if (i==0) {
                element +='<li class="active" data-ordinal="'+i+'"><a>'+urls[i]+'</a></li>';
            } else {
                element +='<li data-ordinal="'+i+'"><a>'+urls[i]+'</a></li>';
            }
        }
        return element + '</ol>';
    }
    $(document).on('click','.btn-view',function(){
        var urls = $(this).parent().find(".image-url").val().split(',');
        asnItemId = $(this).parent().parent().find(".checkbox").attr("data-asn-item-id");
        $("#images").html(genUl(urls));
        var bannerSlider = new Slider($('#images'), {
            time: 5000,
            delay: 400,
            event: 'hover',
            auto: true,
            mode: 'fade',
            controller: $('#bannerCtrl'),
            activeControllerCls: 'active'
        });
        $('#images .flex-prev').click(function() {
            bannerSlider.prev()
        });
        $('#images .flex-next').click(function() {
            bannerSlider.next()
        });
        $("#viewModal").modal("show");
    });
    $("#delete").click(function() {
        var active = $("#bannerCtrl").find("li.active");
        var url = active.find('a').html();
        var ordinal = active.attr("data-ordinal");
        $.ajax({
            url: WEB_ROOT+'purchasePayment/deleteImage',
            type: "GET",
            dataType:'json',
            data: {url:url,asn_item_id:asnItemId},
            success: function(data) {
                if (data.success=='true') {
                    active.remove();
                    $("#i"+url.substring(0,url.lastIndexOf('.'))).remove();
                    var urls = $("tr[data-id="+asnItemId+"]").find('.image-url').val();
                    var urlsArray = urls.split(',');
                    var len = urlsArray.length;
                    for (var i = 0; i < len; i++) {
                        if (urlsArray[i]==url) {
                            urlsArray.splice(i,1);
                            break;
                        }
                    }
                    if (urlsArray.length == 0) {
                        $("tr[data-id="+asnItemId+"]").find('.image-url').remove();
                        $("tr[data-id="+asnItemId+"]").find('.btn-view').remove();
                    } else {
                        $("tr[data-id="+asnItemId+"]").find('.image-url').val(urlsArray.join(','));
                    }

                }
                console.log(data)
            }
        })
        console.log(url);
        console.log(ordinal);
    });
    $("#genRequest").click(function(){
        var unit = $("#unit").val();
        var bank = $("#bank").val();
        var account = $("#account").val();
        var area = $("#area").val();
        if (requestType == 'G' && (unit == '' || bank == '' || account == '')) {
            alert("请填写收款方信息");
            return;
        }
        var formData = new FormData();
        formData.append('requestType',requestType);
        formData.append('area',area);
        formData.append('unit',unit);
        formData.append('bank',bank);
        formData.append('account',account);
        formData.append('asn_items',items);
        formData.append('supplier_id',supplierId);
        formData.append('note',$("#note").val());
        var len = $(".image").length;
        for (var i = 0; i < len; i++) {
//            console.log($(".image")[i].files[0])
            formData.append('images[]',$(".image")[i].files[0]);
        }
        $.ajax({
            url: WEB_ROOT+'purchasePayment/genRequest',
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType:'json',
            success: function(data) {
                if (data.error_info) {
                    alert(data.error_info);
                } else if (data.data.message=='success'){
                    alert('生成付款申请成功');
                    var len = items.length;
                    for (var i = 0; i < len; i++) {
                        $("tr[data-id="+items[i]+"]").remove();
                        $(window.frames['asn_list'].document).find('tr[data-id='+items[i]+']').remove();
                    }
                    $("#paymentModal").modal('hide');
                }
            }
        });


    });
    $(document).on('click','.checkbox', function(event){
        if (!$(event.target).is(":checked")) {
            var id = $(event.target).attr('data-asn-item-id');
            $("tr[data-id="+id+']').remove();
            $(window.frames['asn_list'].document).find('.checkbox[data-asn-item-id='+id+']').attr('checked',false);
        }
    })
</script>
</body>
</html>
