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
</head>
<body>
    <!-- <div id="loadding" class="loadding" style="display:none;"><img src="<?//php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/img/loadding.gif" ></div> -->
    <div class="container-fluid" style="margin-left: -18px;padding-left: 19px;" >
        <div role="tabpanel" class="row tab-product-list tabpanel" >
            <div class="col-md-12">
                <!-- Nav tabs -->
                <input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> >
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="onsale">
                        <form style="width:100%;" method="get" 
                                action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>ProductTransformProduct/query">
                            <div class="row">
                                <label for="start_time" class="col-sm-2 control-label">创建开始时间</label>
                                <div class="col-sm-3">
                                    <input required="required" type="text" class="form-control" autocomplete="off" name="start_apply_time" id="start_apply_time" value="<?php if(isset($start_apply_time)) echo "{$start_apply_time}"; ?>">
                                </div>
                                <label for="end_time" class="col-sm-2 control-label">截止时间</label>
                                <div class="col-sm-3">
                                    <input required="required" type="text" class="form-control" autocomplete="off" name="end_apply_time" id="end_apply_time" value="<?php if(isset($end_apply_time)) echo "{$end_apply_time}"; ?>">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                            	<label for="facility_id"  class="col-sm-2 control-label">仓库：</label>
                            	<div class="col-sm-3">
                                    <select id="facility_id" name="facility_id" class="form-control">
                                    
                                		<?php foreach ( $facility_list as $facility ) {
											if (isset( $facility_id ) && $facility ['facility_id'] == $facility_id) {
												echo "<option value=\"{$facility['facility_id']}\" selected='true'>{$facility['facility_name']}</option>";
											} else {
												echo "<option value=\"{$facility['facility_id']}\">{$facility['facility_name']}</option>";
											}
										} ?>
									</select>
									</div>
                            </div>
                            <div class="row">
                                <label for="transform_type" class="col-sm-2 control-label">转换类型</label>
                                <div class="col-sm-3">
                                    <select  name="transform_type" id="transform_type" class="form-control">
                                        <option value="">全部</option>
                                        <option value="RAW2RAW"  <?php if(isset($transform_type) && $transform_type == 'RAW2RAW') echo "selected='true'" ?>>原料转原料</option>
                                        <option value="FINISHED2RAW"  <?php if(isset($transform_type) && $transform_type == 'FINISHED2RAW') echo "selected='true'" ?>>成品转原料</option>
                                    </select>
                                </div>
                                <label class="col-sm-2 control-label">状态</label>
                                <div class="col-sm-3">
                                    <select  name="status" id="status" class="form-control">
                                        <option value="" <?php if(empty($status)) echo 'selected="selected"'; ?> >全部</option>
                                        <option value="INIT" <?php if(!empty($status) &&$status==='INIT') echo 'selected="selected"'; ?> >申请</option>
                                        <option value="CHECKED" <?php if(!empty($status) &&$status==='CHECKED') echo 'selected="selected"'; ?> >审核通过</option>
                                        <option value="CHECKFAIL" <?php if(!empty($status) &&$status==='CHECKFAIL') echo 'selected="selected"'; ?> >审核失败</option>
                                        <option value="EXECUTED" <?php if(!empty($status) &&$status==='EXECUTED') echo 'selected="selected"'; ?> >已执行</option>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="row">
								<label for="from_product_name" class="col-sm-2 control-label">A果</label>
								<div class="col-sm-3">
									<input required="required" type="text" class="form-control" name="from_product_name" id="from_product_name" value="<?php if(isset($from_product_name)) echo "{$from_product_name}"; ?>">
								</div>
                                <input type="hidden" id="from_product_id" name="from_product_id" <?php if(isset($from_product_id)) echo "value=\"{$from_product_id}\""; ?>/>
								<label for="to_product_name" class="col-sm-2 control-label">B果</label>
								<div class="col-sm-3">
									<input required="required" type="text" class="form-control" name="to_product_name" id="to_product_name" value="<?php if(isset($to_product_name)) echo "{$to_product_name}"; ?>">
								</div>
                                <input type="hidden" id="to_product_id" name="to_product_id" <?php if(isset($to_product_id)) echo "value=\"{$to_product_id}\""; ?>/>
							</div>
                            <br>
                             <div style="width: 100%;float:left;">
                                    <div style="width:38%;float:right;text-align: center;">
                                        <button type="button" class="btn btn-primary"  id="creat">
                                            <a href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>ProductTransformProduct/index" style="color:#fff;">新建</a> 
                                        </button> 
                                        <button type="button" class="btn btn-primary"  id="query">搜索 </button> 
                                    </div>
                                    <!-- 隐藏的 input  start  -->
                                    <input type="hidden" name="act" id="act">
                                    <input type="hidden" name="page_num" id="page_num" value="1">
                                    <!-- 隐藏的 input  end  -->
                             </div>

                        </form>
        
<br/>
<br/>

                        <!-- product list start -->
                        <div class="row col-sm-15 " style="margin-top: 10px;">
                            <table class="table table-striped table-bordered " id="list">
                                <thead>
                                    <tr>
                                    	<th>A product_id</th>
                                        <th>A果</th>
                                        <th>A果箱规</th>
                                        <th>A果箱数</th>
                                        <th>A果个数</th>
                                        <th>损耗个数</th>
                                        <th>状态</th>
                                        <th>B product_id</th>
                                        <th>B果</th>
                                        <th>B果箱规</th>
                                        <th>B果箱数</th>
                                        <th>B果个数</th>
                                        <th>转换类型 </th>
                                        <th>申请时间</th>
                                        <th>申请人</th>
                                        <th>备注</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($transform_product_list)) {
                                    $str0 = '';
                                	foreach ($transform_product_list as $key1 => $transform_product_item) {
                                        $from = $transform_product_item['from'];
                                        $to = $transform_product_item['to'];
                                        $count = count($to);
                                        $str1 = '';
                                        foreach ($to as $key2 => $value) {
                                            $str1 .= '<tr>';
                                            if($key2 % $count == 0){
                                                $str1 .= '<td rowspan="'.$count.'">'.$from['from_product_id'].'</td><td rowspan="'.$count.'">'.$from['from_product_name'].'</td><td rowspan="'.$count.'">'.$from['from_container_quantity'].'</td><td rowspan="'.$count.'">'.$from['from_case_num'].'</td><td rowspan="'.$count.'">'.$from['from_quantity'].'</td><td rowspan="'.$count.'">'.$from['loss_quantity'].'</td>';
                                                if( $from['status'] === 'INIT' ){
                                                    $str1 .= '<td rowspan="'.$count.'">'.'申请'.'</td>';
                                                }else if( $from['status'] === 'CHECKED' ){
                                                    $str1 .= '<td rowspan="'.$count.'">'.'审核通过'.'</td>';
                                                }else if( $from['status'] === 'CHECKFAIL' ){
                                                    $str1 .= '<td rowspan="'.$count.'">'.'审核失败'.'</td>';
                                                }else if( $from['status'] === 'EXECUTED' ){
                                                    $str1 .= '<td rowspan="'.$count.'">'.'已执行'.'</td>';
                                                }else{
                                                    $str1 .= '<td rowspan="'.$count.'"></td>';
                                                }
                                            }
                                            $str1 .= '<td>'.$value['to_product_id'].'</td><td>'.$value['to_product_name'].'</td><td>'.$value['to_container_quantity'].'</td><td>'.$value['to_case_num'].'</td><td>'.$value['to_quantity'].'</td><td>';
                                            if( $from['transform_type'] === 'FINISHED2RAW' ){
                                                $str1 .= '包裹转原料';
                                            }else if( $from['transform_type'] === 'RAW2RAW' ){
                                                $str1 .= '原料转原料';
                                            }
                                            $str1 .= '</td><td>'.$from['created_time'].'</td><td>'.$from['created_user'].'</td><td>'.$from['note'].'</td>';
                                            if($key2 % $count ==0){
                                                if( $from['status'] == 'INIT' ){
                                                    $str1 .= '<td rowspan="'.$count.'"><button type="button" class="btn btn-success btn-sm"  onClick="checkSupplierReturn(this, '.$from['transform_product_id'].',\'CHECKED\' );" >审核通过</button><br/><button type="button" class="btn btn-danger btn-sm"  onClick="checkSupplierReturn(this, '.$from['transform_product_id'].',\'CHECKFAIL\');" >审核拒绝 </button><br/></td>';
                                                }else if( $from['status'] == 'CHECKED' ){
                                                    $str1 .= '<td rowspan="'.$count.'"><button type="button" class="btn btn-primary btn-sm"  onClick="executeProductTransform(this, '.$from['transform_product_id'].');" > 执行换货 </button></td>';
                                                }else {
                                                    $str1 .= '<td rowspan="'.$count.'"></td>';
                                                }
                                            }
                                            $str1 .= '</tr>';
                                        }
                                        $str0 .= $str1;
                                    }
                                    echo $str0;
                                }?>
                                </tbody>                            
                            </table> 
                            <div class="page">
                                <button class="btn btn-default page_now">当前第<?php if(isset($page_now)){ echo $page_now; } ?>页</button>
                                <?php if( isset($page_now) && ($page_now>1) ){
                                    echo '<a href="javascript:;" class="btn btn-info page_prev">上一页</a>';
                                } ?>
                                <input type="text" class="page_enter" name="page_enter" style="width: 60px;">
                                <button class="btn btn-primary page_skip">跳转</button>
                                <?php if( isset($page_now) && isset($page_all) && ($page_now<$page_all) ){
                                    echo '<a href="javascript:;" class="btn btn-info page_next">下一页</a>';
                                } ?>
                                <button class="btn btn-default page_all">共<?php if(isset($page_all)) { echo $page_all; } ?>页</button>
                            </div>                                     
                        </div>
                        <!-- product list end -->
                    </div>
                </div>
            </div>
        </div>
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
<script type="text/javascript">
$(document).ready(function(){  
    (function(config){
        config['extendDrag'] = true; // 注意，此配置参数只能在这里使用全局配置，在调用窗口的传参数使用无效
        config['lock'] = true;
        config['fixed'] = true;
        config['okVal'] = 'Ok';
        config['format'] = 'yyyy-MM-dd HH:mm:ss';
    })($.calendar.setting);

    $("#start_apply_time").calendar({btnBar:true,
                   minDate:'2010-05-01', 
                   maxDate:'2022-05-01'});
    $("#end_apply_time").calendar({btnBar:true,
                   minDate:'2010-05-01', 
                   maxDate:'2022-05-01'});      
    var transform_type = $('#transform_type').val();
    getAbProductList();
});

var WEB_ROOT = $("#WEB_ROOT").val();
var page_now = +'<?php if(isset($page_now)) echo $page_now; ?>';
var page_all = +'<?php if(isset($page_all)) echo $page_all; ?>';

 $("#query").click(function(){
     $("#act").val("query");
     $('#page_num').val(1);
     $("form").submit();
 }); 

 $('.page').on('click','.page_prev',function(){
    $('#page_num').val( page_now-1 );
    $("form").submit();
 })
 .on('click','.page_next',function(){
    $('#page_num').val( page_now+1 );
    $("form").submit();
 })
 .on('click','.page_skip',function(){
    var page_num = +$('.page_enter').val();
    if( page_num ){
        $('#page_num').val( page_num );
        $("form").submit();
    }
 })
 .on('keyup','.page_enter',function(ev){
    if( ev.keyCode == 13 ){
        var page_num = +$('.page_enter').val();
        if( page_num && (page_num<page_all) ){
            $('#page_num').val( page_num );
            $("form").submit();
        }
    }
 });

function getAbProductList(){
    $.ajax({
        url : WEB_ROOT + "ProductTransformProduct/getAbProductList",
        type : 'GET',
        dataType : 'json',
        beforeSend : function(){
            $('#from_product_name').attr('disabled','disabled');
            $('#to_product_name').attr('disabled','disabled');
            $('#from_product_name').attr('placeholder','正在获取数...');
            $('#to_product_name').attr('placeholder','正在获取数...');
        } 
    }).done(function(data){
        $('#from_product_name').removeAttr('disabled');
        $('#to_product_name').removeAttr('disabled');
        $('#from_product_name').removeAttr('placeholder');
        $('#to_product_name').removeAttr('placeholder');
        if( data.success === 'success' ){
            var data = data.abProductList,
                from_product_list = data.from_mapping,
                to_product_list = data.to_mapping;

            var fromFormat = function(row, i, max) {
                    return("[" + row.from_product_id + "]" + row.from_product_name);
                };
            var toFormat = function(row, i, max) {
                    return("[" + row.to_product_id + "]" + row.to_product_name);
                };
            autocoms( $('#from_product_name'),from_product_list,fromFormat ).result(function(event, row, formatted){
                $('#from_product_id').val(row.from_product_id);
            });
            autocoms( $('#to_product_name'),to_product_list,toFormat ).result(function(event, row, formatted){
                $('#to_product_id').val(row.to_product_id);
            });
        }else{
            alert(data.error_info);
        }
    }).fail(function(xhr){
        alert('获取可转换商品列表ajax报错：'+xhr.statusText);
    });
}

function checkSupplierReturn(button, transform_product_id, check) {
    if (check == "CHECKFAIL") {
        if (! confirm("真的要拒绝吗？")) {
            return ;
        }
    }
    $(button).attr("disabled", true);
    var myurl;
    if (check == "CHECKED") {
        myurl = $("#WEB_ROOT").val()+"ProductTransformProduct/checkedProductTransform";
    }else{
        myurl = $("#WEB_ROOT").val()+"ProductTransformProduct/checkfailProductTransform";
    }
    var mydata = {
      "transform_product_id":transform_product_id
    }; 
    $.ajax({
        url: myurl,
        type: 'POST',
        data:mydata, 
        dataType: "json", 
        xhrFields: {
             withCredentials: true
        }
      }).done(function(data){
          console.log(data);
          if(data.success == "success"){
            window.location.reload();
          }else{
            alert("操作失败"+data.error_info);
            $(button).removeAttr("disabled");
          }
      });
} 

function executeProductTransform(button, transform_product_id){
    $(button).attr("disabled", true);
    var myurl = $("#WEB_ROOT").val()+"ProductTransformProduct/executeProductTransform";
    
    $.ajax({
        url: myurl,
        type: 'POST',
        data: {
            "transform_product_id":transform_product_id
          }, 
        dataType: "json", 
        xhrFields: {
             withCredentials: true
        }
      }).done(function(data){
          console.log(data);
          if(data.success == "success"){
              alert('操作成功');
            window.location.reload();
          }else{
            alert("操作失败"+data.error_info);
            $(button).removeAttr("disabled");
          }
      }).fail(function(data){
          alert('操作失败');
          $(button).removeAttr("disabled");
      });
}

</script>
</body>
</html>