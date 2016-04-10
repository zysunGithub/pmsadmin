<!doctype html>
<html>
<head>
<meta charset="UTF-8" />
<title>拼好货WMS</title>
<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/order.css">
<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/buttons.dataTables.css">
<link rel="stylesheet" type="text/css" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/lhgcalendar.css"/>
<style>
	.pl15{
		padding-left: 42px;
	}
	td input,td select{
    	width: 90%;
    	margin: 10px 5%;
    }
</style>
</head>
<body>
	<div style="width: 1000px; margin: 0 auto; height: 50px;">
		<form style="width:100%;" method="get" action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>OpenOrderList/index">
			<div class="row">
				<label for="start_time" class="col-sm-2 control-label">创建开始时间</label>
				<div class="col-sm-3">
					<input required="required" autocomplete='off' type="text" class="form-control" name="start_time" id="start_time" value="<?php if(isset($start_time)) echo "{$start_time}"; ?>">
				</div>
				<label for="end_time" class="col-sm-2 control-label">创建结束时间</label>
				<div class="col-sm-3">
					<input required="required" autocomplete='off' type="text" class="form-control" name="end_time" id="end_time" value="<?php if(isset($end_time)) echo "{$end_time}"; ?>">
				</div>
			</div>
			<div class="row">
				<label for="shipping_id" class="pl15 control-label">快递方式：</label>
				<select id="shipping_id" name="shipping_id" class="form-control" style="width:auto;display:inline-block;">
					<option value=''>全部</option>
					<?php 
						foreach ($CodShippingList as $OpenShipping) {
							if (isset ($shipping_id) && $OpenShipping['shipping_id'] == $shipping_id) {
								echo "<option value=\"{$OpenShipping['shipping_id']}\" selected='true'>{$OpenShipping['shipping_name']}</option>";
							} else {
								echo "<option value=\"{$OpenShipping['shipping_id']}\">{$OpenShipping['shipping_name']}</option>";
							}
						}
					?>
				</select>
				<label for="status" class="pl15 control-label">状态：</label>
				<select name="status" class="form-control" style="width:auto;display:inline-block;">
					<option value="4" <?php if ($status=='4') {echo "selected = true";} ?> >全部</option>
					<option value="0" <?php if ($status=='0') {echo "selected = true";} ?> >待推送</option>
					<option value="1" <?php if ($status=='1') {echo "selected = true";} ?> >推送成功</option>
					<option value="2" <?php if ($status=='2') {echo "selected = true";} ?> >推送失败</option>
					<option value="3" <?php if ($status=='3') {echo "selected = true";} ?> >推送中</option>
				</select> 
                <label for="order_status" class="pl15 control-label">签收状态：</label>
				<select name="order_status" class="form-control" style="width:auto;display:inline-block;">
                    <option value="" <?php if(!isset($order_status)) {echo "selected = true";} ?> >全部</option>
                    <option value="QS" <?php if(isset($order_status) && $order_status == 'QS') {echo "selected = true";} ?> >签收</option>
                    <option value="YN" <?php if(isset($order_status) &&$order_status == 'YN') {echo "selected = true";} ?> >异常</option>
				</select> 
                
				<label for="tracking_number" class="pl15 control-label">面单号：</label>
				<input type="text" id="tracking_number" class="form-control" name="tracking_number" placeholder="请输入面单号" value="<?php if(!empty($tracking_number)){echo $tracking_number;}?>" style="width:auto;display:inline-block;" />
				
				<input type="button" id="query" style="float: right;" class="btn btn-primary btn-search col-md-1"  value="搜索"> 
			
				<!-- 隐藏的 input  start  -->
		        <input type="hidden"  id="page_current" name="page_current" <?php if(isset($page_current)) echo "value={$page_current}"; ?> /> 
		        <input type="hidden"  id="page_count" name="page_count" <?php if(isset($page_count)) echo "value={$page_count}"; ?> />
		        <input type="hidden"  id="page_limit" name="page_limit" <?php if(isset($page_limit)) echo "value={$page_limit}"; ?> /> 
                <input type="hidden" name="act" id="act">
		        <!-- 隐藏的 input  end  -->
			</div>
		</form>
	</div>
	<hr />
<div style="width: 1000px; margin: 0 auto;">
	<table class="table table-striped table-bordered " id="list">
		<thead>
			<th><input type="button" value="全选" onclick="checkAll()" ></th>
			<th>订单号</th>
			<th>快递名</th>
			<th>面单号</th>
			<th>创建时间</th>
			<th>最后更新时间</th>
			<th>收货者</th>
			<th>收货地址</th>
			<th>省</th>
			<th>市</th>
			<th>区</th>
			<th>订单状态</th>
            <th>签收状态</th>
			<th style="display:none;"></th>
			<th>发送次数</th>
			<th>错误信息</th>
			<th>修改状态</th>
		</thead>
		<tbody>
		<?php if(isset($OpenOrderList)) { foreach($OpenOrderList as $record){?>
			<tr>
				<td><input type="checkbox" name="shipping_id"></td>
				<td id="open_order_id"><?php echo $record['open_order_id'];?></td>
				<td><?php echo $record['shipping_name'];?></td>
				<td id="tracking_num"><?php echo $record['tracking_number'];?></td>
				<td><?php echo $record['created_time'];?></td>
				<td><?php echo $record['last_updated_time'];?></td>
				<td><?php echo $record['receive_name'];?></td>
				<td><?php echo $record['shipping_address'];?></td>
				<td><?php echo $record['province_name'];?></td>
				<td><?php echo $record['city_name'];?></td>
				<td><?php echo $record['district_name'];?></td>
				<td id="status" style="display:none;"><?php echo $record['status'];?></td>
				<td><?php 
					if($record['status']==0) {
						echo '待推送';
					}elseif ($record['status']==1) {
						echo '成功';
					}elseif ($record['status']==2) {
						echo '失败';
					}elseif ($record['status']==3) {
						echo '推送中';
					}
				?></td>
                <td><?php
                    if($record['order_status'] == 'QS'){
                        echo '签收';
                    } elseif ($record['order_status'] == 'YN'){
                        echo '异常';
                    }
                    ?>
                </td>
				<td><?php echo $record['send_counts'];?></td>
				<td style="word-wrap:break-word;"><?php echo $record['error_info'];?></td>
				<td>
					<?php 
						if($record['status']==1) {
							echo "<a class=\"btn btn-danger btn-sm remove\" href=\"#\" status='2' onclick='on_submit(this);'>改为失败</a>";
						}elseif ($record['status']==2) {
							echo "<a class=\"btn btn-success btn-sm remove\" href=\"#\" status='1' onclick='on_submit(this);'>改为成功</a>";
						}
					?>
				</td>
			</tr>
		<?php }}?>
		</tbody>
	</table>
</div>
<div style="text-align:right;width:100%;padding-right: 160px;" class="row clearfix">
	<button class="btn btn-success btn-sm remove remove_arr" status='1' onclick='on_submit(this);'>批量改成功</button>  
	<button class="btn btn-danger btn-sm remove remove_arr" status='2' onclick='on_submit(this);'>批量改失败</button>
</div>
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
                    if(isset($record_total))  echo "共{$record_total}条记录"; ?>
                </a>
            </li>
        </ul>
    </nav>
</div>
              
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/lhgcalendar.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/dataTables.buttons.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/buttons.colVis.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/buttons.flash.js"></script>
<script type="text/javascript">
var url_base = "<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>";
function isNullOrEmpty(strVal) {
	if (strVal == '' || strVal == null || strVal == undefined) {
		return true;
	} else {
		return false;
	}
}
$(document).ready(function(){
	(function(config){
	    config['extendDrag'] = true; // 注意，此配置参数只能在这里使用全局配置，在调用窗口的传参数使用无效
	    config['lock'] = true;
	    config['fixed'] = true;
	    config['okVal'] = 'Ok';
	    config['format'] = 'yyyy-MM-dd HH:mm:ss';
	})($.calendar.setting);

	$("#start_time").calendar({btnBar:true,
	               minDate:'2010-05-01', 
	               maxDate:'2022-05-01'});
	$("#end_time").calendar({btnBar:true,
	               minDate:'2010-05-01', 
	               maxDate:'2022-05-01'});
	var table = $('#list').DataTable({
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
	    language: {
	        "url": "<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/Chinese.lang"
	    },
	    "lengthMenu": [[30, 10, 60, 100, -1], [30, 10, 60, 100, "全部"]]
	});
})
//分页 
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

function on_submit(obj){
	btn = $(obj);
	btn.attr('disabled','disabled');
	var check_same = true;
	var status = btn.attr('status').trim();
	var open_order_id = [];
	if (btn.hasClass('remove_arr')) {
		var input_checked = $("input[name='shipping_id']").filter(":checked");
		if (input_checked.length == 0) {
			alert("至少选中一个");
			btn.removeAttr('disabled');
			return;
		};
		input_checked.each(function(){
			var status_now = parseInt($(this).parent().parent().find("#status").html().trim());
			if (check_same) {
				if (status_now !==1 && status_now !==2) {
					alert('该状态不能修改');
					btn.removeAttr('disabled');
					check_same = false;
					return;
				};
				if(status_now == status){
					alert("被选中的状态有不符合");
					btn.removeAttr('disabled');
					check_same = false;
					return;
				}
			};
			open_order_id.push($(this).parent().parent().find("#open_order_id").html().trim());
		})
	}else{
		open_order_id.push(btn.parent().parent().find('#open_order_id').html().trim());
	}
	if (!check_same) {
		return;
	};
	var cf = confirm( '确认吗?' );
	if (cf==false){
		btn.removeAttr('disabled');
		return;
	}else{
		$.ajax({
			url:url_base+"OpenOrderList/updateStatus",
			type:"post",
			data:{
				"open_order_id":open_order_id,
				"status":status
			},
			dataType:"json",
			xhrFields: {
	            withCredentials: true
	        }
		}).done(function(data){
			console.log(data);
			if(data.data.result == "ok"){
				alert('操作成功');
				window.location.reload();
			}
			else{
				alert(data.error_info);
				btn.removeAttr('disabled');
			}
		}).fail(function(data){
			alert(JSON.stringify(data));
			btn.removeAttr('disabled');
		});
	}
};

 $("#query").click(function(){
     $("#act").val("query");
     $("#page_current").val("1");
     $("form").submit();
 }); 


var is_select_all = true;
function checkAll() {
	$('input[name="shipping_id"]').prop("checked",is_select_all);
	is_select_all = !is_select_all;
}
</script>
</body>
</html>