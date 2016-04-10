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
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/autocomplete.css">
    
    <style type="text/css">
        tr td.product_cell{
            text-align: center;
            vertical-align:middle;
            height: 100%;
        }
       .order{
            border: 1px solid gray;
            margin-top:2px;
            margin-bottom: 2px;
       }

       .order_head{
            background-color: #cccccc;
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
        <div role="tabpanel" class="row tab-product-list tabpanel" >
            <div class="col-md-12">
                <!-- Nav tabs -->
                <input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> >
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="onsale">
                        <form style="width:100%;" method="post" action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>badProduct/getBadProductList">

                         <div class="row">
								<label for="start_time" class="col-sm-2 control-label"><h4>录入开始时间</h4></label>
								<div class="col-sm-3">
									<input required="required" type="text" class="form-control" name="start_time" id="start_time" value="<?php if(isset($start_time)) echo "{$start_time}"; ?>">
								</div>
								<label for="end_time" class="col-sm-2 control-label"><h4>录入结束时间</h4></label>
								<div class="col-sm-3">
									<input required="required" type="text" class="form-control" name="end_time" id="end_time" value="<?php if(isset($end_time)) echo "{$end_time}"; ?>">
								</div>
							</div>
							<div class="row">
								<label for="start_time" class="col-sm-2 control-label"><h4>仓库</h4></label>
								<div class="col-sm-3">
									<select  style="width: 50%;" name="facility_id" id="facility_id" class="form-control">
                                    	<?php
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
								<label class="col-sm-2 control-label"><h4>商品名称</h4></label>
								<div class="col-sm-3">
									<input type="text" class="form-control" name="product_name" id="product_name" value="<?php if(isset($product_name)) echo "{$product_name}"; ?>">
								</div>
							</div>
                         <div style="width: 100%;float:left;">
                                <div style="width:66%;float:left;text-align: center;">
                                    <button type="button" class="btn btn-primary btn-sm"  id="query"  >搜索 </button> 
                                </div>
                                <!-- 隐藏的 input  start  -->
                                <input type="hidden"  <?php if(isset($record_start)) echo "value='{$record_start}'"; ?>  id="hide_start_time" >
                                <input type="hidden"  <?php if(isset($record_end)) echo "value='{$record_end}'"; ?>  id="hide_end_time" >
                                <input type="hidden"  id="page_current" name="page_current"    <?php if(isset($page_current)) echo "value={$page_current}"; ?> /> 
                                <input type="hidden"  id="page_count" name="page_count"   <?php if(isset($page_count)) echo "value={$page_count}"; ?> />
                                <input type="hidden"  id="page_limit" name="page_limit" <?php if(isset($page_limit)) echo "value={$page_limit}"; ?> /> 
                                <!-- 隐藏的 input  end  -->
                         </div>

                        </form>
        
<br/>
<br/>
<br/>

                        <!-- product list start -->
                        <div class="row col-sm-15 " style="margin-top: 10px;">
                            <table class="table table-striped table-bordered ">
                                <thead>
                                    <tr>
                                    	<th style="display: none;">id</th>
                                    	<th style="width: 5%;">PRODUCT_ID</th>
                                        <th style="width: 20%;">商品</th>
                                        <th style="width: 10%;">仓库</th>
                                        <th style="width: 5%;">坏果数</th>
                                        <th style="width: 5%;">次果数</th>
                                        <th style="width: 10%;">单位</th>
                                        <th style="width: 10%;">录入人</th>
                                        <th style="width: 20%;">录入时间</th>
                                        <th style="width: 30%;">备注</th>
                                    </tr>
                                </thead>
                            <?php if (! empty($product_list)) {
                            	foreach ($product_list as $badproduct) {
                            		?>
                            		<tr>
                            			<td class="product_cell" style="display: none;"><?php echo $badproduct['stocktake_bad_id']?></td>
                            			<td class="product_cell"><?php echo $badproduct['product_id']?></td>
                            			<td class="product_cell"><?php echo $badproduct['product_name']?></td>
                            			<td class="product_cell"><?php echo $badproduct['facility_name']?></td>
                            			<td class="product_cell"><?php echo $badproduct['bad_quantity']?></td>
                                        <td class="product_cell"><?php echo $badproduct['defective_quantity']?></td>
                            			<td class="product_cell"><?php echo $badproduct['unit_code']?></td>
                            			<td class="product_cell"><?php echo $badproduct['created_user']?></td>
                            			<td class="product_cell"><?php echo $badproduct['created_time']?></td>
                            			<td class="product_cell"><?php echo $badproduct['note']?></td>
                            		</tr>
                            		<?php } }?>
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
                        <!-- product list end -->
                    </div>
                    <div role="tabpanel" class="tab-pane" id="undercarriage">
                         
                    </div>
                </div>
            </div>
        </div>
    </div>
    
	<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
	<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/lhgcalendar.min.js"></script>
    <script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js"></script>
	<script type="text/javascript">
$(document).ready(function(){
    var WEB_ROOT = "<?php echo $WEB_ROOT; ?>",
        def = (function(){
        var pro = $.ajax({
            url: WEB_ROOT+'BadProduct/getProductList',
            type: 'GET',
            dataType: 'json'
        });
        return pro;
    })(jQuery);
    def.then(function(data){
        if(data['success'] === 'success' ){
            $('#product_name').autocomplete(data.product_list, {
                minChars: 0,
                width: 310,
                max: 100,
                matchContains: true,
                autoFill: false,
                formatItem: function(row, i, max) {
                    return row.product_id + "[" + row.product_name + "]";
                },
                formatMatch: function(row, i, max) {
                    return row.product_id + "[" + row.product_name + "]";
                },
                formatResult: function(row) {
                    return row.product_id + "[" + row.product_name + "]";
                }
            }).result(function(event, row, formatted){
                $(this).val(row.product_name);
            });
        }
    });
    (function(config){
        config['extendDrag'] = true; // 注意，此配置参数只能在这里使用全局配置，在调用窗口的传参数使用无效
        config['lock'] = true;
        config['fixed'] = true;
        config['okVal'] = 'Ok';
        config['format'] = 'yyyy-MM-dd';
    })($.calendar.setting);

    $("#start_time").calendar({btnBar:true,
                   minDate:'2010-05-01', 
                   maxDate:'2022-05-01'});
    $("#end_time").calendar({btnBar:true,
                   minDate:'2010-05-01', 
                   maxDate:'2022-05-01'});
});

 $("#query").click(function(){
     $("#act").val("query");
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
</script>
</body>
</html>
