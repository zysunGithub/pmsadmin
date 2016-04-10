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
        tr {
            text-align: center;
            vertical-align:middle;
            height: 100%;
        }
        tr th{
            text-align: center;
            vertical-align:middle;
            height: 100%;
        }


      .currentPage{
       font-weight: bold;
       font-size: 120%; 
       }
    </style>
    <!--[if lt IE 9]>
        <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <![endif]-->
</head>
<body>
    <div class="container-fluid" style="margin-left: -18px;padding-left: 19px;" >
            <div class="col-md-12">
                <!-- Nav tabs -->
                <input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> >
                <!-- Tab panes -->
                <div class="tab-content">
                        <form style="width:100%;" method="post" action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>./purchaseForecastList">
                         <div style="width:100%;float: left;padding: 0px;">
                               <div style="width:100%;">
                                    <label for="start_time" style="width: 10%; text-align: right">创建时间：</label>
                                    <input style="width:12%" type="text" id="start_time" name="start_time" <?php if(isset($start_time)) echo "value='{$start_time}'"; ?> >
                                    <label for="end_time" style="width: 10%; text-align: right">到：</label>
                                    <input type="text" id="end_time" name="end_time"  <?php if(isset($end_time)) echo "value='{$end_time}'"; ?> >
                                </div> 
                                <div  style="width:100%;">
                                <label for="facility_id" style="width: 10%; text-align: right">仓库：</label>
								<select style="width:12%; height: 30px" id="facility_id" name="facility_id" >
									<option value="">全部</option>
                                	<?php foreach ( $facility_list as $facility ) {
										if (isset( $facility_id ) && $facility ['facility_id'] == $facility_id) {
											echo "<option value=\"{$facility['facility_id']}\" selected='true'>{$facility['facility_name']}</option>";
										} else {
											echo "<option value=\"{$facility['facility_id']}\">{$facility['facility_name']}</option>";
										}
									} ?>
                    			</select>
                    			<label for="pf_sn" style="width: 10%; text-align: right">采购预估单号：</label>
                                <input type="text" id="pf_sn" name="pf_sn" <?php if(isset($pf_sn)) echo "value={$pf_sn}"; ?> >
                                </div>
                                <div  style="width:100%;">
                    			<label for="created_user" style="width: 10%; text-align: right">创建者：</label>
                                <input type="text" id="created_user" name="created_user" <?php if(isset($created_user)) echo "value={$created_user}"; ?> >
                                </div>
                         </div>
                         <div style="width: 100%;float:left;">
                                <div style="width:66%;float:left;text-align: center;">
                                    <button type="button" class="btn btn-primary btn-sm"  id="query"  >搜索 </button> 
                                </div>
                                <!-- 隐藏的 input  start  -->
                                <input type="hidden"  id="page_current" name="page_current" <?php if(isset($page_current)) echo "value={$page_current}"; ?> /> 
                                <input type="hidden"  id="page_count" name="page_count" <?php if(isset($page_count)) echo "value={$page_count}"; ?> />
                                <input type="hidden"  id="page_limit" name="page_limit" <?php if(isset($page_limit)) echo "value={$page_limit}"; ?> /> 
                                <!-- 隐藏的 input  end  -->
                         </div>
                        </form>
                        <!-- list start -->
                        <div class="row col-sm-12 " style="margin-top: 10px;">
                            <table class="table table-striped table-bordered ">
                                <thead>
                                    <tr>
                                        <th>仓库</th>
                                        <th>采购预估单号</th>
                                        <th>创建时间</th>
                                        <th>创建者</th>
                                        <th>详情</th>
                                    </tr>
                                </thead>
                                                            
                                <?php if( isset($purchase_forecast_list) && is_array($purchase_forecast_list))  foreach ($purchase_forecast_list as $key => $purchase_forecast) { ?> 
                                <tbody >
                                    <tr>
                                        <td><?php echo $purchase_forecast['facility_name'] ?></td>
                                        <td><?php echo $purchase_forecast['pf_sn'] ?></td>
                                        <td><?php echo $purchase_forecast['created_time'] ?></td>
                                        <td><?php echo $purchase_forecast['created_user'] ?></td>
                                        <td><a href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>PurchaseForecastList/detail?pf_sn=<?php echo $purchase_forecast['pf_sn']?>&facility_name=<?php echo $purchase_forecast['facility_name']?>&created_time=<?php echo $purchase_forecast['created_time']?>&created_user=<?php echo $purchase_forecast['created_user']?>" class="btn btn-info" target="_blank">详情</a></td>
                                    </tr>
                                </tbody>
                                  <tr colspan="7" style="height: 13px;">
                                  </tr>
                                <?php } ?>

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
                        <!--  list end -->
                </div>
            </div>
    </div>

<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/lhgcalendar.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
    (function(config){
        config['extendDrag'] = true; // 注意，此配置参数只能在这里使用全局配置，在调用窗口的传参数使用无效
        config['lock'] = true;
        config['fixed'] = true;
        config['okVal'] = 'Ok';
        config['format'] = 'yyyy-MM-dd HH:mm:ss';
    })($.calendar.setting);

    $("#start_time").calendar({btnBar:true});
    $("#end_time").calendar({btnBar:true});
}) ;

 $("#query").click(function(){
     $("#page_current").val("1");
     $("form").submit();
 }); 
 Date.prototype.diff = function(date){
	  return (this.getTime() - date.getTime())/(24 * 60 * 60 * 1000);
	}
	
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

$("button#toggleShow").click(function(){
    $("div#searchDiv").toggle(); 
}); 
</script>
</body>
</html>