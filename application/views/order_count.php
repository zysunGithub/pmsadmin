<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>拼好货WMS</title>
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/order.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/lhgcalendar.css"/>
</head>
<body>
	<br>
    <div class="container">
        <table width="100%">
            <tr>
                <td>
                	<form method="get"  action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>orderCount">
                	<div class="row">
						<label for="area_id" class="col-sm-2 control-label"  class="form-control" style="width:120px"><h4>区域</h4></label>
    					<div class="col-sm-3">
	    					<select  style="width: 100%;" name="area_id" id="area_Sel" class="form-control" required="required" >
			                    		    <?php 
			                                foreach ($area_list as $area) {
	                                			 if( !empty($area_id) &&($area_id == $area['area_id'])){echo "<option value=\"{$area['area_id']}\"  selected=\"selected\">{$area['area_name']}</option>"; }
	                                			 else { echo "<option value=\"{$area['area_id']}\">{$area['area_name']}</option>"; }
	                                		}
	                                		?>
	                         </select>
    					</div>
						<label for="facility_id" class="col-sm-2 control-label"  class="form-control" style="width:120px"><h4>仓库</h4></label>
    					<div class="col-sm-3">
	    					<select  style="width: 100%;" name="facility_id" id="facility_Sel" class="form-control" required="required" >
	    					<option value=''>全部</option>
			                    		    <?php 
			                                foreach ($facility_list as $facility) {
	                                			 if( !empty($facility_id) &&($facility_id == $facility['facility_id'])){echo "<option value=\"{$facility['facility_id']}\"  selected=\"selected\">{$facility['facility_name']}</option>"; }
	                                			 else { echo "<option value=\"{$facility['facility_id']}\">{$facility['facility_name']}</option>"; }
	                                		}
	                                		?>
	                         </select>
    					</div>
    				</div>
    				</form>
    			</td>
                <td style="text-align: right;font-size: 20px;">日期：<?php echo date("Y-m-d",time());?></td>
            </tr>
            <tr><td>订单情况统计表</td></tr>
    </div>
    <div class="container">
        <table class="table table-striped table-bordered ">
            <thead>
            <tr>
                <th width="5%">  </th>
                <th class="text-center col-sm-1 ">总订单数</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>订单已确认</td>
                    <td><?php if (isset($count_result['ok_total_order_num'])) {echo $count_result['ok_total_order_num'];}else{echo "";}?></td>
                </tr>
            </tbody>
        </table>
        <div class="row  col-sm-5">
            <table class="table table-striped table-bordered " >
                <thead>
                    <div>按时间段单量统计</div>
                    <tr>
                        <th class="text-center col-sm-1">时间段</th>
                        <th class="text-center col-sm-1">公司订单数</th>
                        <th class="text-center col-sm-1">总订单数</th>                     
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $date_data = $count_result['date_data'];
                        foreach($date_data as $key => $row){?>
                            <tr>
                                <td><?php echo $row['time'];?></td>
                                <td><?php echo $row['company_orders']?></td>
                                <td><?php echo $row['number'];?></td>
                            </tr>
                        <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="row  col-sm-5  col-sm-offset-1">
            <table class="table table-striped table-bordered " >
                <thead>
                <div>按商品单量统计</div>
                <tr>
                	<th class="text-center col-sm-1">PRODUCT_ID</th>
                    <th class="text-center col-sm-1">商品名</th>
                    <th class="text-center col-sm-1">订单数</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $date_data = $count_result['product_data'];
                foreach($date_data as $key => $row){?>
                    <tr>
                    	<td><?php echo $row['product_id'];?></td>
                        <td><?php echo $row['product_name'];?></td>
                        <td><?php echo $row['number'];?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#facility_Sel').change(function () {
	    	$("form").submit();
	    });
	    
	    $('#area_Sel').change(function () {
	    	$('#facility_Sel').val("");
	    	$("form").submit();
	    });
	});
</script>
</html>