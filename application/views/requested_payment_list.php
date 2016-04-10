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
    <style type="text/css">
        .button_margin {
            margin: 8%;
        }
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
</head>
<body>
<?php  $CI =& get_instance();
$CI->load->library('session');?>
<div style="width: 98%;margin: 10px;">
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active">
            <form method="get" action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>purchasePayment/requestList">
                <div class="row">
                    <label for="request_type" class="col-sm-2 control-label">申请单类型:</label>
                    <div class="col-sm-3">
                        <select class="form-control" name="request_type" id="request_type">
                            <option value="ALL">全部</option>
                            <option value="G" <?php if(isset($request_type) && $request_type=='G') echo 'selected';?>>对公</option>
                            <option value="S" <?php if(isset($request_type) && $request_type=='S') echo 'selected';?>>对私</option>
                        </select>
                    </div>
                    <label for="request_sn" class="col-sm-2 control-label">申请单编号:</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control"  style="width: 50%;" name="request_sn" id="request_sn"
                            value="<?php if (isset($request_sn)) echo $request_sn;?>">
                    </div>
                </div>
                <div class="row">
                    <label for="start_time" class="col-sm-2 control-label">申请开始时间:</label>
                    <div class="col-sm-3">
                        <input class="form-control"  id="start_time" name="start_time" autocomplete="off"
                            value="<?php if (isset($start_time)) echo $start_time;?>">
                    </div>
                    <label for="end_time" class="col-sm-2 control-label">申请结束时间:</label>
                    <div class="col-sm-3">
                        <input class="form-control"  id="end_time" name="end_time"  autocomplete="off"
                            value="<?php if (isset($end_time)) echo $end_time;?>" />
                    </div>
                </div>
                <div class="row">
                    <label for="request_user" class="col-sm-2 control-label">申请人:</label>
                    <div class="col-sm-3">
                        <input style="width:200px" name="request_user" id="request_user" class="form-control"
                            value="<?php if (isset($request_user)) echo $request_user;?>">
                    </div>
                    <label for="status" class="col-sm-2 control-label">申请状态:</label>
                    <div class="col-sm-3">
                        <select style="width:200px" name="status" id="status" class="form-control">
                            <option value="ALL" <?php if(isset($status) && $status == "ALL") echo "selected";?>>全部</option>
                            <option value="INIT" <?php if(isset($status) && $status == "INIT") echo "selected";?>>待申请</option>
                            <option value="APPLIED" <?php if(isset($status) && $status == "APPLIED") echo "selected";?>>已申请</option>
                            <option value="MANAGERCHECKED" <?php if(isset($status) && $status == "MANAGERCHECKED") echo "selected";?>>区总成功</option>
                            <option value="MANAGERCHECKFAIL" <?php if(isset($status) && $status == "MANAGERCHECKFAIL") echo "selected";?>>区总失败</option>
                            <option value="DIRECTORCHECKED" <?php if(isset($status) && $status == "DIRECTORCHECKED") echo "selected";?>>主管审批成功</option>
                            <option value="DIRECTORCKFAIL" <?php if(isset($status) && $status == "DIRECTORCKFAIL") echo "selected";?>>主管审批失败</option>

                            <option value="CHECKED" <?php if(isset($status) && $status == "CHECKED") echo "selected";?>>财务已确认</option>
                            <option value="CHECKFAIL" <?php if(isset($status) && $status == "CHECKFAIL") echo "selected";?>>审核作废</option>
                            <option value="PAID" <?php if(isset($status) && $status == "PAID") echo "selected";?>>财务已支付</option>
                        </select>
                    </div>
                </div>
                <div class="row" style="text-align: center;">
                    <input type="button" class="btn btn-primary" id="search" name="search" value="搜索"/>
                    <input type="button" class="btn btn-primary" id="export" name="export" value="导出" />
                </div>

                <div style="width: 100px;margin: 0 auto;">
                    <input type="hidden"  id="act" name="act"  >
                    <input type="hidden"  id="page_current" name="page_current"
                        <?php if(isset($page_current)) echo "value={$page_current}"; ?> />
                    <input type="hidden"  id="page_count" name="page_count"
                        <?php if(isset($page_count)) echo "value={$page_count}"; ?> />
                    <input type="hidden"  id="page_limit" name="page_limit"
                        <?php if(isset($page_limit)) echo "value={$page_limit}"; ?> />
                    <!-- 隐藏的 input  end  -->
                </div>
            </form>
        </div>
    </div>
    <table class="table table-striped table-bordered " style="width: 100%;margin-top:10px;margin-right:10px;">
        <tr>
            <th>申请单号</th>
            <th>申请日期</th>
            <th>申请人</th>
            <th>所属大区</th>
            <th>申请单状态</th>
            <th>申请单详情</th>
        </tr>
        <tbody>
        <?php
        foreach ($list as $item) {
            echo "<tr data-id='$item[payment_request_id]'>";
            echo "<td class='request_sn'>$item[request_type]".date("Ymd", strtotime($item['request_time'])).sprintf('%04d',$item['request_sn'])."</td>";
            echo "<td class='request_time'>$item[request_time]</td>";
            echo "<td class='request_user'>$item[request_user]</td>";
            echo "<td class='area_name'>$item[area_name]</td>";
            echo "<td class='status'>{$financeStatus[$item['status']]}</td>";
            echo '<td><input type="button" class="btn btn-primary view-details" data-id="'.$item['payment_request_id'].'" value="详情"></td>';
            echo "<td hidden='true' class='raw-status'>$item[status]</td>";
            echo "<td hidden='true' class='note'>$item[note]</td>";
            echo "<td hidden='true' class='manager-comments'>$item[manager_comments]</td>";
            echo "<td hidden='true' class='director-comments'>$item[director_comments]</td>";
            echo "<td hidden='true' class='comments'>$item[comments]</td>";
            echo "<td hidden='true' class='unit'>$item[unit]</td>";
            echo "<td hidden='true' class='bank'>$item[bank]</td>";
            echo "<td hidden='true' class='account'>$item[account]</td>";
            echo "<td hidden='true' class='image-urls'>$item[image_urls]</td>";
            echo '</tr>';

        }
        ?>

        </tbody>
    </table>
    <div class="row">
        <nav style="float: right;margin-top: -7px;">
            <ul class="pagination">
                <li>
                    <a href="#"   id="page_prev">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php if(isset($page)) echo $page; ?>
                <li>
                    <a href="#" id="page_next" >
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
                <li><a href='#'>
                        <?php if(isset($page_count)) echo "共{$page_count}页 &nbsp;";
                        if(isset($record_total))  echo  "共{$record_total}条记录";
                        ?>
                    </a></li>
            </ul>
        </nav>
    </div>
</div>


<!-- details modal -->
<div>
    <div class="modal fade ui-draggable text-center" id="detailsModal" role="dialog"  >
        <div class="modal-dialog" style="display: inline-block; width: 900px">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" id="btnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">付款申请详情</h4>
                </div>
                <div class="modal-body" style="text-align: left;">
                    <div class="row">
                        <label for="details_request_sn" class="col-md-2 control-label">申请单号</label>
                        <div class="col-md-3">
                            <input type="text" id="details_request_sn" readonly="readonly" class="form-control">
                        </div>
                        <label for="details_request_user" class="col-md-2 control-label">申请人</label>
                        <div class="col-md-3">
                            <input type="text" id="details_request_user" readonly="readonly" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <label for="details_request_time" class="col-md-2 control-label">申请时间</label>
                        <div class="col-md-3">
                            <input type="text" id="details_request_time" readonly="readonly" class="form-control">
                        </div>
                        <label for="details_status" class="col-md-2 control-label">申请单状态</label>
                        <div class="col-md-3">
                            <input type="text" id="details_status" readonly="readonly" class="form-control">
                            <input type="text" id="details_raw_status" hidden="true">
                        </div>
                    </div>
                    <div class="row"></div>
                    <div style="overflow: scroll;height: 500px;" >
                        <table  class="table table-striped table-bordered " style="width: 100%;margin-top:10px;margin-right:10px;">
                            <tr>
                                <th rowspan="2">ASN ITEM ID</th>
                                <th rowspan="2">状态</th>
                                <th rowspan="2">冻结</th>
                                <th rowspan="2">ASN日期</th>
                                <th rowspan="2">区域</th>
                                <th rowspan="2">仓库</th>
                                <th rowspan="2">商品名称</th>
                                <th rowspan="2">PRODUCT_ID</th>
                                <th rowspan="2">采购员</th>
                                <th rowspan="2">供应商</th>
                                <th rowspan="2">申请人</th>
                                <th colspan="9" style="text-align: center;">仓库</th>
                                <th rowspan="2">单位</th>
                                <th rowspan="2">入库含税总金额</th>
                                <th colspan="7" style="text-align: center;">供应商退货</th>
                                <th colspan="8" style="text-align: center;">供价调整</th>
                                <th rowspan="2">应付</th>
                                <th rowspan="2">坏次果退货</th>
                            </tr>
                            <tr>
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
                            </tr>
                            <tbody id="details_table">

                            </tbody>
                        </table>

                    </div>
                    <div class="row">
                        <label for="note" class="col-md-2 control-label">备注</label>
                        <div class="col-md-3">
                            <input id="note" type="text" class="form-control">
                        </div>
                        <label for="amount" class="col-md-2 control-label">应付合计</label>
                        <div class="col-md-3">
                            <input id="amount" type="text" readonly="true" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <label for="unit" class="col-md-2 control-label">收款单位</label>
                        <div class="col-md-3">
                            <input id="unit" type="text" class="form-control">
                        </div>
                        <label for="bank" class="col-md-2 control-label">收款银行</label>
                        <div class="col-md-3">
                            <input id="bank" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <label for="account" class="col-md-2 control-label">收款账户</label>
                        <div class="col-md-3">
                            <input id="account" type="text" class="form-control">
                        </div>
                        <label for="comments" class="col-md-2 control-label">批注</label>
                        <div class="col-md-3">
                            <input id="comments" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-offset-2">
                            <input type="button" class="btn btn-primary btn-view" value="查看扫描件">
                            <input type="button" class="btn btn-primary btn-upload"  value="上传扫描件">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row" id="cancelRequestButton">
                        <input id="cancelRequest" type="button" class="btn btn-primary btn-danger" value="申请作废">
                        </div>
                    <div class="row" id="reRequestButton">
                        <input type="button" class="btn btn-primary check-status" style="text-align: right" value="重新申请">
                    </div>
                    <br>
                    <div class="row" id="checkButtons">
                        <input id="reject" type="button" class="btn btn-primary btn-danger" value="审核作废">
                        <input type="button" class="btn btn-primary check-status" style="text-align: right" value="审核通过">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- details modal end -->
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
<!--return modal-->
<div>
    <div class="modal fade ui-draggable text-center" id="returnModal" role="dialog"  >
        <div class="modal-dialog" style="display: inline-block; width: 600px">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" id="btnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">坏次果退货</h4>
                </div>
                <div class="modal-body" style="text-align: left; margin-left:15%">
                        <div class='row'>
                            <label  class="control-label col-md-2" style="text-align: right;">RETURN_ID：</label>
                            <div class="col-md-5">
                                <input type="text" placeholder="多个ID以逗号隔开" class="form-control" name="return_id" id="return_id" >
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <input id="return_submit" type="button" class="btn btn-primary" style="text-align: right" value="提交">
                </div>
            </div>
        </div>
    </div>
</div>
<!--return modal end-->

<!-- return 显示 modal -->
<div>
    <div class="modal fade ui-draggable text-center" id="returnViewModal" role="dialog"  >
        <div class="modal-dialog" style="display: inline-block; width: 600px">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" id="btnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">坏次果退款</h4>
                </div>
                <div class="modal-body" style="text-align: left;">
                    <div>
                        <table class="table table-striped table-bordered">
                            <tr><td>RETURN_ID</td><td>类型</td><td>商品名</td><td>金额</td></tr>
                            <tbody id="return_list">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <input id="view" data-dismiss="modal" type="button" class="btn btn-primary" style="text-align: right" value="确定">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal end-->
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
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/lhgcalendar.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/slider.js"></script>
<script type="text/javascript">
    var upload_path = "<?php echo $upload_path;?>";;
    var property={
        divId:"demo1",
        needTime:true,
        yearRange:[1970,2030],
        week:['日','一','二','三','四','五','六'],
        month:['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月'],
        format:"yyyy-MM-dd hh:mm:00"
    };

    (function(config){
        config['extendDrag'] = true; // 注意，此配置参数只能在这里使用全局配置，在调用窗口的传参数使用无效
        config['lock'] = true;
        config['fixed'] = true;
        config['okVal'] = 'Ok';
        config['format'] = 'yyyy-MM-dd HH:mm:ss';
        // [more..]
    })($.calendar.setting);


    $(document).ready(function(){
        $("#start_time").calendar({btnBar:true,
            minDate:'2010-05-01',
            maxDate:'2022-05-01'});
        $("#end_time").calendar({  btnBar:true,
            minDate:'#start_time',
            maxDate:'2022-05-01'});
        $("#asn_date_start").calendar({  btnBar:true,
            minDate:'2010-05-01',
            maxDate:'2022-05-01',
            format:'yyyy-MM-dd'});
        $("#asn_date_end").calendar({  btnBar:true,
            minDate:'2010-05-01',
            maxDate:'2022-05-01',
            format:'yyyy-MM-dd'});
        $("#download").popover({"trigger":"hover"});
    }) ;  // end document ready function

    var WEB_ROOT = "<?php if(isset($WEB_ROOT)) echo $WEB_ROOT; ?>";

    // 点击下载 excel 按钮
    $('#download').click(function(){
        $("#act").val("download");
        $("form").submit();
        $("#act").val("query");
    });

    var financeStatus = <?php echo json_encode($financeStatus);?>;
    var username = '<?php echo $CI->session->userdata('username');?>';
    <?php
    if ($this->helper->chechActionList(array('purchaseFinanceApply'))) {
    echo 'var applyPermission = true;';
    } else {
    echo 'var applyPermission = false;';
    }
    if ($this->helper->chechActionList(array('purchaseManagerCheckPurchaseFinance'))) {
    echo 'var managerPermission = true;';
    } else {
        echo 'var managerPermission = false;';
    }
     if($this->helper->chechActionList(array('purchaseDirectorCheckPurchaseFinance'))) {
        echo 'var directorPermission = true;';
     } else {
        echo 'var directorPermission = false;';
     }
     if ($this->helper->chechActionList(array('purchaseFinance'))) {
        echo 'var financePermission = true;';
     } else {
        echo 'var financePermission = false;';
     }
    ?>

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
    $(".btn-upload").click(function () {
        $("#uploadModal").modal("show");
        $("#upload-file").val('');
        asnItemId = $(this).parent().parent().find(".checkbox").attr("data-asn-item-id");
        uploadTd = $(this).parent();
    });
    $("#doUpload").click(function(){
        var formData = new FormData();
        formData.append('id', id);
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
                        var imageURL = $("tr[data-id="+id+"]").find('.image-urls');
                    if (imageURL.html() == '') {
                        imageURL.html(data.path);
                    } else {
                        imageURL.html(imageURL.html()+','+data.path);
                    }
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
//        var urls = $(this).parent().find(".image-url").val().split(',');
        asnItemId = $(this).parent().parent().find(".checkbox").attr("data-asn-item-id");
        urls = $("tr[data-id="+id+"]").find('.image-urls').html().split(',');
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

    function LCM(a, b) {
        var i = a;
        var j = b;
        while (b != 0) {
            var p = a % b;
            a = b;
            b = p;
        }
        return i * j / a;
    }
    function genRow(data, keys, valueMap) {
        var inventoryLength = data.inventory_list.length || 1;
        var virtualInventoryLength = data.virtual_inventory_list.length || 1;
        var supplierReturnLength = data.supplier_return_list.length || 1;
        var historyLength = data.history.length || 1;
        var rowspan = LCM(inventoryLength,virtualInventoryLength);
        rowspan = LCM(rowspan, supplierReturnLength);
        rowspan = LCM(rowspan, historyLength);
        var historyRowspan = rowspan/historyLength;
        var virtualRowspan = rowspan/virtualInventoryLength;
        var generalRowspan = rowspan/inventoryLength;
        var supplierRowsapn = rowspan/supplierReturnLength;
        var getRowsapn = function(key) {
            switch (key) {
                case 'inventory_list':
                    return generalRowspan;
                case 'virtual_inventory_list':
                    return virtualRowspan;
                case 'history':
                    return historyRowspan;
                case 'supplier_return_list':
                    return supplierRowsapn;
                default :
                    return rowspan;
            }
        };
        var len = keys.length;
        var row = '<tr>';
        var list = [];
        var item;
        for (var i = 0; i < len; i++) {
            if (keys[i] instanceof Array) {
//                list.push([keys[i][0],keys[i][1]]);
                list.push(keys[i]);
//                item = data[keys[i]][0];
                var sublen = keys[i][1].length;
                for (var j = 0; j < sublen; j++) {
                    row += '<td style="vertical-align: middle;" rowspan="'+getRowsapn(keys[i][0])+'" class="product_cell">';
                    if (data[keys[i][0]][0] != undefined) {
                        if (valueMap[keys[i][1][j]] != undefined) {
                            row += valueMap[keys[i][1][j]](data[keys[i][0]][0]);
                        } else {
                            row += data[keys[i][0]][0][keys[i][1][j]];
                        }
                    }
                    row += '</td>';
                }
            } else {
                row += '<td style="vertical-align: middle;" rowspan="'+getRowsapn(keys[i])+'" class="product_cell">';
                if (valueMap[keys[i]] != undefined) {
                    row += valueMap[keys[i]](data);
                } else {
                    row += data[keys[i]];
                }
                row += '</td>';
            }
        }
        for (var i = 1; i < rowspan; i++) {
            row += '<tr>';
            var length = list.length;
            for (var j = 0; j < length; j++) {
                if (i % getRowsapn(list[j][0]) == 0) {
                    var sslen = list[j][1].length;
                    for (var k = 0; k <sslen; k++) {
                        row += '<td rowspan="'+getRowsapn(list[j][0])+'" class="product_cell">'
                        ordinal = i/getRowsapn(list[j][0]);
                        if (valueMap[list[j][1][k]] != undefined) {
                            row += valueMap[list[j][1][k]](data[list[j][0]][ordinal]);
                        } else {
                            row += data[list[j][0]][ordinal][list[j][1][k]];

                        }
                        row += '</td>';
                    }
                }
            }
            row += '</tr>';
        }
        row += '</tr>';
        return row;
    }
    $(".view-details").click(function(event){
        id = $(event.target).attr('data-id');
        var grandpa = $(event.target).parent().parent();
        var request_sn = grandpa.find('.request_sn').html();
        request_type = request_sn.charAt(0);
        var request_user = grandpa.find('.request_user').html();
        var request_time = grandpa.find('.request_time').html();
        var status = grandpa.find('.status').html();
        var rawStatus = grandpa.find('.raw-status').html();
        var note = grandpa.find('.note').html();
        var unit = grandpa.find('.unit').html();
        var bank = grandpa.find('.bank').html();
        var account = grandpa.find('.account').html();
        if (applyPermission && request_user == username && (rawStatus == 'INIT' || rawStatus== 'DIRECTORCKFAIL' ||
            rawStatus == 'MANAGERCHECKFAIL' || rawStatus == 'CHECKFAIL')) {
            $("#reRequestButton").css("display","block");
            $("#cancelRequestButton").css("display","block");

            $(".btn-upload").css("display","inline");
            $("#delete").css("display","inline");
        } else {
            $("#reRequestButton").css("display","none");
            $("#cancelRequestButton").css("display","none");

            $(".btn-upload").css("display","none");
            $("#delete").css("display","none");
        }
        if (applyPermission && request_user == username && rawStatus=='APPLIED') {
            $("#cancelRequestButton").css("display","block");
        }
        if ((managerPermission && rawStatus=='APPLIED') ||
            (directorPermission && rawStatus=='MANAGERCHECKED') ||
            (financePermission && (rawStatus =='DIRECTORCHECKED' || rawStatus=='CHECKED'))  ) {
            $("#checkButtons").css("display","block");
        } else {
            $("#checkButtons").css("display","none");
        }
        if (rawStatus == 'MANAGERCHECKFAIL') {
            $("#comments").val(grandpa.find('.manager-comments').html());
        } else if (rawStatus == 'DIRECTORCKFAIL') {
            $("#comments").val(grandpa.find('.director-comments').html());
        } else if (rawStatus == 'CHECKFAIL') {
            $("#comments").val(grandpa.find('.comments').html());
        } else {
            $("#comments").val('');
        }
        $("#unit").val(unit);
        $("#bank").val(bank);
        $("#account").val(account);

        $.ajax({
            type:'GET',
            url:WEB_ROOT+'purchasePayment/requestDetails',
            data:{id:id},
            dataType:'json',
            success:function(data) {
                $('#details_request_sn').val(request_sn);
                $('#details_request_user').val(request_user);
                $('#details_request_time').val(request_time);
                $('#details_status').val(status);
                $('#details_table').html('');
                $('#note').val(note);
                $('#details_raw_status').val(rawStatus);
                if (data.data != undefined && data.data.purchase_finance_price_list != undefined) {
                    originalAmount = {};
                    defectiveReturnList = {};
                    var item = data.data.purchase_finance_price_list;
                    var len = item.length;
                    sum = 0;
                    for (var i = 0; i < len; i++) {
                        $(genRow(item[i],
                        ['asn_item_id', 'status', 'frozen','asn_date', 'area_name', 'facility_name', 'product_name',
                            'product_id', 'purchase_user', 'product_supplier_name', 'apply_user',

                                'arrival_real_quantity', 'arrival_case_num',
                               [ 'inventory_list', ['created_time', 'facility_name', 'quantity', 'unit_quantity', 'created_user', 'unit_price']],
                            'tax_rate', 'product_unit_code', 'purchase_total_price',
                            ['supplier_return_list', ['return_type', 'unit_price', 'quantity', 'container_quantity', 'apply_amount', 'transaction_amount', 'finance_amount']],
                            ['history', ['history_case_num', 'history_replenish_case_num', 'modified_finance_status', 'total_price', 'tax_rate','deduction_rate', 'clean_unit_price','other_price']],
                            'pay','defective'],
                            {
                                frozen: function(data) {
                                    if (data['frozen']==1) {
                                        return '已冻结';
                                    } else {
                                        return '未冻结';
                                    }
                                },
                                status:function (data) {
                                    return financeStatus[data['status']];
                                },
                                modified_finance_status: function(data) {
                                    return financeStatus[data['modified_finance_status']];
                                },
                                return_type: function(data) {
                                    if (data['return_type'] == 'exchange') {
                                        return '换货';
                                    } else if (data['return_type'] == 'return') {
                                        return '退货';
                                    } else if (data['return_type'] == 'sale') {
                                        return '销售';
                                    } else {
                                        return '';
                                    }
                                },
                                history_case_num: function(data) {
                                    if (data['purchase_unit'] == 'case') {
                                        return data['case_num'];
                                    } else {
                                        return data['kg_num'];
                                    }
                                },
                                history_replenish_case_num: function(data) {
                                    if (data['purchase_unit'] == 'case') {
                                        return data['replenish_case_num'];
                                    } else {
                                        return data['replenish_kg_num'];
                                    }
                                },
                                pay: function(data) {
                                    var return_sum = 0;
                                    var len = data['supplier_return_list'].length;
                                    for (var i = 0; i < len; i++) {
                                        if (data['supplier_return_list'][i]['return_type']=='return' && data['supplier_return_list'][i]['transaction_amount'] != '')
                                        return_sum += parseFloat(data['supplier_return_list'][i]['transaction_amount']);
                                        console.log(return_sum);
                                    }
                                    var amount = parseFloat(data['purchase_total_price'])-return_sum;
                                    originalAmount[data['asn_item_id']] = amount;
                                    defectiveReturnList[data['asn_item_id']] = data['defectiveReturnList'];
                                    len = data['defectiveReturnList'].length;
                                    var defectiveSum = 0;
                                    for (var i = 0; i < len; i++) {
                                        defectiveSum += parseFloat(data['defectiveReturnList'][i]['total_price']);
                                    }
                                    var fa = amount-defectiveSum;
                                    sum += fa;
//                                    return fa.toFixed(2);
                                    return fa;
                                },
                                clean_unit_price: function(data) {
                                    var amount = 0;
                                    if (data['purchase_unit'] == 'case') {
                                        amount = parseFloat(data['case_num']) + parseFloat(data['replenish_case_num']);
                                    } else {
                                        amount = parseFloat(data['kg_num'])*2+parseFloat(data['replenish_kg_num'])*2;
                                    }
                                    if (amount == 0) return 0;
                                    var taxRate = data['tax_rate'] == '' ? 0 : parseFloat(data['tax_rate']);
                                    var deductionRate = data['deduction_rate'] == '' ? 0 : parseFloat(data['deduction_rate']);
                                    var unitPrice = (parseFloat(data['total_price']) - parseFloat(data['total_price'])/(1+taxRate)*deductionRate)/amount;
                                    return unitPrice.toFixed(2);
                                },
                                defective: function(data) {
                                    return '<input type="button" class="btn btn-success btn-view-return" value="查看"><br>';
                                }
                            })).appendTo($("#details_table"));

                    }
                }

                $("#amount").val(sum);
                $("#detailsModal").modal('show');
            }
        })
    });

    $(".check-status").click(function(){
        var status = $("#details_raw_status").val();
        var next = {APPLIED:'MANAGERCHECKED',MANAGERCHECKED:'DIRECTORCHECKED',DIRECTORCHECKED:'CHECKED',
            CHECKED:'PAID',INIT:'APPLIED',MANAGERCHECKFAIL:'APPLIED',DIRECTORCKFAIL:'APPLIED',CHECKFAIL:'APPLIED'};
        var unit = $("#unit").val();
        var bank = $("#bank").val();
        var account = $("#account").val();
        var note = $("#note").val();
        var request_sn = $("#")
        if (next[status] == 'APPLIED' && request_type == 'G') {
            if (unit==''||bank==''||account=='') {
                alert('请填写收款方信息');
                return false;
            }
        }
        $.ajax({
            type:'GET',
            url:WEB_ROOT+'purchasePayment/check',
            data:{id:id,status:status,action:'pass',unit:unit,bank:bank,account:account,note:note},
            dataType: 'json',
            success: function(data) {
                if (data.message == 'success') {
                    var row = $("tr[data-id="+id+"]");
                    row.find(".raw-status").html(next[status]);
                    row.find('.status').html(financeStatus[next[status]]);
                    if (next[status] == 'APPLIED') {
                        if (request_type == 'G') {
                            row.find('.unit').html(unit);
                            row.find('.bank').html(bank);
                            row.find('.account').html(account);
                        }
                        row.find('.note').html(note);
                    }
                }
                $("#detailsModal").modal("hide");
            }
        });
    });
    $(document).on('click','.btn-view-return',function(){
        asn_item_id = $(this).parent().parent().find('td:first').html();
        var returnItems = defectiveReturnList[asn_item_id];
        var len = defectiveReturnList[asn_item_id].length;
        var items = '';
        for (var i = 0; i < len; i++) {
            items += '<tr><td>'+returnItems[i]['supplier_return_id']+'</td>';
            items += '<td>'+returnItems[i]['type']+'</td>';
            items += '<td>'+returnItems[i]['product_name']+'</td>';
            items += '<td>'+returnItems[i]['total_price']+'</td>';

        }
        $("#return_list").html(items);
        $("#returnViewModal").modal('show');
    });
    $(document).on('click','.btn-add-return',function(){
        asn_item_id = $(this).parent().parent().attr('data-id');
        $("#returnModal").modal('show');
    });
    $("#return_submit").click(function(){
        var ids = $("#return_id").val();
        $("")
        if (ids == '') {
            alert("请输入RETURN ID");
            return false;
        }
        ids = ids.replace(/，/g,',');
        $.ajax({
            url:WEB_ROOT+'purchasePayment/addDefectiveReturn',
            type:'GET',
            dataType:'json',
            data:{ids:ids,asn_item_id:asn_item_id},
            success:function(data){
                if (data.message == 'success') {
                    var len = data.data.length;
                    var rows = '';
                    var defectiveSum = 0;
                    for (var i = 0; i < len; i++) {
                        rows += '{{tr data-id="'+data.data[i].supplier_return_id+'"}}';
                        rows += '{{td}}'+data.data[i].supplier_return_id+'{{/td}}';
                        rows += '{{td}}'+data.data[i].type+'{{/td}}';
                        rows += '{{td}}'+data.data[i].product_name+'{{/td}}';
                        rows += '{{td}}'+data.data[i].total_price+'{{/td}}';
                        rows += '{{td}}{{button class="btn btn-danger btn-delete" value="删除"}}{{/td}}';
                        rows += '{{tr}}';
                        defectiveSum += parseFloat(data.data[i].total_price);
                    }
                    $("tr[data-id="+asn_item_id+"]").find('.defective-return-list').html(rows);
                    var amount = parseFloat($("tr[data-id="+asn_item_id+"]").find('.original-amount').html())-defectiveSum;
                    console.log(amount);
                    $("tr[data-id="+asn_item_id+"]").find('.amount').html(amount);
                    $("#returnModal").modal('hide');
                } else {
                    alert(data.error_info);
                }

            }
        })
    });
    $(document).on('click','.btn-delete',function(){
        var returnId = $(this).parent().parent().attr('data-id');
        $.ajax({
            url:WEB_ROOT+'purchasePayment/removeDefectiveReturn',
            type:'GET',
            dataType:'json',
            data:{id:returnId,asn_item_id:asn_item_id},
            success:function(data){
                if (data.message == 'success') {
                    var len = data.data.length;
                    var rows = '';
                    var defectiveSum = 0;
                    for (var i = 0; i < len; i++) {
                        rows += '{{tr data-id="'+data.data[i].supplier_return_id+'"}}';
                        rows += '{{td}}'+data.data[i].supplier_return_id+'{{/td}}';
                        rows += '{{td}}'+data.data[i].type+'{{/td}}';
                        rows += '{{td}}'+data.data[i].product_name+'{{/td}}';
                        rows += '{{td}}'+data.data[i].total_price+'{{/td}}';
                        rows += '{{td}}{{input class="btn btn-danger btn-delete" type="button" value="删除"}}{{/td}}';
                        rows += '{{tr}}';
                        defectiveSum += parseFloat(data.data[i].total_price);
                    }
                    $("tr[data-id="+asn_item_id+"]").find('.defective-return-list').html(rows);
                    var amount = parseFloat($("tr[data-id="+asn_item_id+"]").find('.original-amount').html())-defectiveSum;
                    console.log(amount);
                    $("tr[data-id="+asn_item_id+"]").find('.amount').html(amount);
                    $("#viewModal").modal('hide');
                } else {
                    alert(data.error_info);
                }
            }
        })
    });

    $("#delete").click(function() {
        var active = $("#bannerCtrl").find("li.active");
        var url = active.find('a').html();
        var ordinal = active.attr("data-ordinal");
        $.ajax({
            url: WEB_ROOT+'purchasePayment/deleteImage',
            type: "GET",
            dataType:'json',
            data: {url:url,id:id},
            success: function(data) {
                if (data.success=='true') {
                    active.remove();
                    $("#i"+url.substring(0,url.lastIndexOf('.'))).remove();
                    var urls = $("tr[data-id="+id+"]").find('.image-urls').html();
                    var urlsArray = urls.split(',');
                    var len = urlsArray.length;
                    for (var i = 0; i < len; i++) {
                        if (urlsArray[i]==url) {
                            urlsArray.splice(i,1);
                            break;
                        }
                    }
                    $("tr[data-id="+id+"]").find('.image-urls').html(urlsArray.join(','));

                }
                console.log(data)
            }
        })
        console.log(url);
        console.log(ordinal);
    });
    $("#cancelRequest").click(function(){
        $.ajax({
            type:'GET',
            url:WEB_ROOT+'purchasePayment/deleteRequest',
            data:{id:id},
            dataType:'json',
            success: function(data) {
                if (data.data.message == 'success') {
                    $("tr[data-id="+id+"]").remove();
                    alert('删除成功');
                } else {
                    alert(data.error_info);
                }
                $("#detailsModal").modal("hide");
            }
        })
    })
    $("#reject").click(function(){
        var status = $("#details_raw_status").val();
        var next = {APPLIED:'MANAGERCHECKFAIL',MANAGERCHECKED:'DIRECTORCKFAIL',DIRECTORCHECKED:'CHECKFAIL',CHECKED:'CHECKFAIL'};
        var comment = $("#comments").val();
        if (comment == '') {
            alert('批注不能为空');
            return;
        }
        $.ajax({
            type:'GET',
            url:WEB_ROOT+'purchasePayment/check',
            data:{
                id : id,
                status : status,
                action : 'reject',
                comment:comment
            },
            dataType: 'json',
            success: function(data) {
                if (data.message == 'success') {
                    var row = $("tr[data-id="+id+"]");
                    row.find(".raw-status").html(next[status]);
                    row.find('.status').html(financeStatus[next[status]]);
                }
                $("#detailsModal").modal("hide");
            }
        });
    })
</script>
</body>
</html>
