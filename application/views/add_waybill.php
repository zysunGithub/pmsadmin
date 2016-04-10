<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>拼好货WMS</title>
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/lhgcalendar.css"/>
    
    <style type="text/css">
        tr td.product_cell{
            text-align: center;
            vertical-align:middle;
            height: 100%;
        }
        th{
            text-align: center;
            vertical-align:middle;
            height: 100%;
        }
       .order{
            border: 1px solid gray;
            margin-top:2px;
            margin-bottom: 2px;
       }
}
    </style>
</head>
<body>  
    <div class="container-fluid" style="margin-left: -18px;padding-left: 19px;" >
        <div role="tabpanel" class="row tab-product-list tabpanel" >
            <div class="col-md-12">
                <!-- Nav tabs -->
                <input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> >
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="onsale">
                    <div class="row">
    				<div class="col-sm-offset-0 col-sm-3" style="font-size: 30px;text-align:center; color: red; ">
    						<?php  if(isset($message))  echo $message;  ?>
    					</div>
    				</div>
                        <form name="facility_form" style="width:100%;" method="get"  action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>./addWaybill">
                        	 <label for="facility_id" class="col-sm-2 control-label" style="width:120px"><h4>仓库</h4></label>
    					 	<select   class="col-sm-2" style="width:156px;height:26px" name="facility_id" id="facility_Sel" class="form-control" required="required">
                                    <?php 
                                    	if(!empty($facility_list)) {
                                    		foreach ($facility_list as $facility) {
                                    			if(!empty($facility_id) && $facility_id == $facility['facility_id']) { echo "<option value=\"{$facility['facility_id']}\" " . (" title=\"{$facility['facility_name']}\""). " selected=\"selected\">{$facility['facility_name']}</option>" ;}
                                    			else {
                                    				echo "<option value=\"{$facility['facility_id']}\" " . (" title=\"{$facility['facility_name']}\""). " >{$facility['facility_name']}</option>" ;
                                    			}
                                    		}
                                    	}
                                     ?>
                       		 </select>
                        </form>
                        <div class="row">
                        
                        </div>
<!--                         undistributedList  start-->
                        <div class="row  col-sm-6  col-sm-offset-0" style="margin-top: 10px;">
                            <table class="table table-striped table-bordered "  style="width:100%">
                                <thead>
                                    <tr>
                                        <th>快递名称</th>
                                        <th width="20%">操作人</th>
                                        <th width="20%">未生成发运单数量</th>
                                        <th width="10%">操作</th>
                                    </tr>
                                </thead>
                                <tbody >
                                <?php if( isset($waybill_list) && is_array($waybill_list))  foreach ($waybill_list as $key => $waybill) { 
                                	?> 
                                    <tr>
                                        <td class="product_cell">
                                             <?php echo $waybill['shipping_name']?>
                                        </td>
                                        <td class="product_cell">
                                             <?php echo $waybill['user_name']?>
                                        </td>
                                         <td class="product_cell">
                                             <?php if(!empty($waybill['num'])) echo $waybill['num']?>
                                        </td>
                                         <td class="product_cell">
                                        <a class="btn btn-warning" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>./addWaybill/createWaybill?shipping_id=<?php echo $waybill['shipping_id']?>&facility_id=<?php echo $facility_id?>&num=<?php echo $waybill['num']?>&user_id=<?php echo $waybill['user_id']?>"> 确认发运数量 </a>
                                        </td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                                 
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript">

$(document).ready(function(){
    $('#facility_Sel').change(function () {
   	 $("form[name='facility_form']").submit();
   });
});
</script>
</body>
</html>