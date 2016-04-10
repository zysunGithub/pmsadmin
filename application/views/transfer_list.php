<!doctype html>
<html>
<head>
	<meta charset="UTF-8"/>
	<title>拼好货WMS</title>
	<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/buttons.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.0.0/css/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/mobiscroll.core-2.5.2.css" />
	<link rel="stylesheet" type="text/css" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/mobiscroll.animation-2.5.2.css" />
    <style>
        .toolbar {
            float: left;
            
        }
        p{
            padding-right: 10px;
            padding-left: 10px;
        }
    </style>
</head>
<body>
<div style="width: 80%;margin: 0 auto;">
	<table id="list" class="table table-striped table-bordered ">
		<thead>
			<th>原仓库</th>
			<th>目的仓库</th>
			<th>PRODUCT_ID</th>
			<th>商品</th>
			<th>计划的转仓数量</th>
			<th>完成的转仓数量</th>
			<th>原快递方式</th>
			<th>目的快递方式</th>
			<th>创建时间</th>
			<th>创建者</th>
			<th>完成时间</th>
			<th>进程状态</th>
			<th>操作</th>
		</thead>
		<tbody>
			<?php 
				if (isset($transfer_list)){
					foreach ($transfer_list as $transfer){
						echo "<tr>";
						echo "<td>".$transfer['from_facility_name']."</td>";
						echo "<td>".$transfer['to_facility_name']."</td>";
						echo "<td>".$transfer['product_id']."</td>";
						echo "<td>".$transfer['product_name']."</td>";
						echo "<td>".$transfer['plan_quantity']."</td>";
						echo "<td>".$transfer['finish_quantity']."</td>";
						echo "<td>".$transfer['from_shipping_name']."</td>";
						echo "<td>".$transfer['to_shipping_name']."</td>";
						echo "<td>".$transfer['created_time']."</td>";
						echo "<td>".$transfer['user_name']."</td>";
						echo "<td>".$transfer['finish_time']."</td>";
						if($transfer['process_status'] == "WAIT"){
							echo "<td>待执行</td>";
						}else if ($transfer['process_status'] == "RUNNING"){
							echo "<td>执行中</td>";
						}else if ($transfer['process_status'] == "FINISH"){
							echo "<td>已完成</td>";
						}else{
							echo "<td></td>";
						}
						echo "<td>";
						echo "<a class='btn btn-primary' href='".$WEB_ROOT."transferList/detail?transfer_shipment_id=".$transfer['transfer_shipment_id']."' >详情</a>";
						echo "</td>";
						echo "</tr>";
					}
				}
			?>
		</tbody>
	</table>
</div>
	<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
	<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/mobiscroll.core-2.5.2.js"></script>
 	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/mobiscroll.core-2.5.2-zh.js"></script>
	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/mobiscroll.datetime-2.5.1.js"></script>
 	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/mobiscroll.datetime-2.5.1-zh.js"></script> 
    <script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/jquery.dataTables.js"></script>
	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/dataTables.bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/dataTables.buttons.js"></script>
	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/buttons.colVis.js"></script>
	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/buttons.flash.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/fixedheader/3.0.0/js/dataTables.fixedHeader.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function() {
	    var table = $('#list').DataTable({
            dom: 'lB<"toolbar">frtip',
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
                "url": "<?php if (isset($WEB_ROOT)) echo $WEB_ROOT; ?>assets/js/Chinese.lang"
            },
            fnInitComplete: function (sName, oData, sExpires, sPath) {
               
                setToolBar();
                initParams();   
                new $.fn.dataTable.FixedHeader( table );
                }
        });
        function setToolBar(){
                 str  = '<form action="<?php echo $WEB_ROOT; ?>transferList" method="GET" role="form" >';
                 str += '<div class="form-group"><label for="created_time"><p>开始时间</p></label><input type="text" value="" name="created_time" id="created_time"  class="form-control" />';
                 str += '<label for="end_time"><p>结束时间</p></label><input type="text" value="" name="end_time" id="end_time" class="form-control"  />';
                 str += '<label for="product_name"><p>商品名称</p></label><input type="text" value="" name="product_name" id="product_name" class="form-control" /></div>';
                 str += '<div class="form-group"><label for="from_facility_id"><p>原仓库</p></label><select name="from_facility_id" id="from_facility_id" class="form-control" >';
                 str += '<option value=\"\">请选择原仓库</option>';
                 str += '<?php
							foreach ($facility_list as $facility) {
								echo "<option value=\"{$facility['facility_id']}\">{$facility['facility_name']}</option>";
							}
							?>';
                 str += '</select>';
                 str += '<label for="to_facility_id"><p>目的仓库</p></label><select name="to_facility_id" id="to_facility_id" class="form-control" >';
                 str += '<option value=\"\">请选择目的仓库</option>';
                 str += '<?php
							foreach ($facility_list as $facility) {
								echo "<option value=\"{$facility['facility_id']}\">{$facility['facility_name']}</option>";
							}
							?>';
                 str += '</select></div>';
                 str += '<div class="form-group"><label for="from_shipping_id"><p>原快递</p></label><select name="from_shipping_id" id="from_shipping_id" class="form-control" >';
                 str += '<option value=\"\">请选择快递方式</option>';
                 str += '<?php
							foreach ($shipping_list as $shipping) {
								if (isset ($shipping['shipping_id']) && $shipping['shipping_id'] == $shipping['shipping_id']) {
									echo "<option value=\"{$shipping['shipping_id']}\">{$shipping['shipping_name']}</option>";
                                }
							}
							?>';
                 str += '</select>';
                 str += '<label for="to_shipping_id"><p>目的快递</p></label><select name="to_shipping_id" id="to_shipping_id" class="form-control" >';
                 str += '<option value=\"\">请选择快递方式</option>';
                 str += '<?php
							foreach ($shipping_list as $shipping) {
                                if (isset ($shipping['shipping_id']) && $shipping['shipping_id'] == $shipping['shipping_id']) {
									echo "<option value=\"{$shipping['shipping_id']}\">{$shipping['shipping_name']}</option>";
                                }
                            }
							?>';
                 str += '</select>';
                 str += '<input type="submit" class="form-control" value="搜索" style="float:right" /></div>';
                 str += '</form>';
                 $("div.toolbar").html(str);
        }
        function initParams(){
            $("#created_time").val('<?php 
            if(isset($params['created_time']) && $params['created_time']!=""){ 
                echo $params['created_time'];
            } ?>');
            $("#end_time").val('<?php 
            if(isset($params['end_time']) && $params['end_time']!=""){
                echo $params['end_time'];
            } ?>');
            <?php if(isset($params['to_facility_id']) && $params['to_facility_id']!=""){ ?>
            $('#to_facility_id').val(<?php echo $params['to_facility_id']; ?>);
            <?php } ?>
            <?php if(isset($params['from_facility_id']) && $params['from_facility_id']!=""){ ?> 
            $('#from_facility_id').val(<?php echo $params['from_facility_id']; ?>);
            <?php } ?>
            <?php if(isset($params['to_shipping_id']) && $params['to_shipping_id']!=""){ ?> 
            $('#to_shipping_id').val(<?php echo $params['to_shipping_id']; ?>);
            <?php } ?>
            <?php if(isset($params['from_shipping_id']) && $params['from_shipping_id']!=""){ ?> 
            $('#from_shipping_id').val(<?php echo $params['from_shipping_id']; ?>);
            <?php } ?>
                var currYear = (new Date()).getFullYear();	
                var opt = {
                        dateFormat : 'yy-mm-dd',
                        preset : 'date',
                        theme: 'android-ics light', //皮肤样式
                        display: 'modal', //显示方式
                        mode: 'scroller', //日期选择模式
                        preset: 'date', //日期
                        dateOrder: 'yymmdd', //面板中日期排列格
                        dateFormat: 'yy-mm-dd', // 日期格式
                        lang: 'zh',
                        setText: '确定', //确认按钮名称
                        cancelText: '取消',//取消按钮
                        dayText: '日', monthText: '月', yearText: '年', //面板中年月日文字    
                        endYear: currYear + 10 //结束年份
                    };
            $("#created_time").mobiscroll(opt).datetime(opt);
            $("#end_time").mobiscroll(opt).datetime(opt);
        }
	});
	</script>
</body>
</html>
