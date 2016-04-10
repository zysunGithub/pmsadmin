<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>拼好货WMS</title>
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/autocomplete.css">
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
                        <form style="width:100%;" method="post" action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>./launchTransferInventoryList/<?php if(isset($product_type) && $product_type=='goods'){ echo 'goodsDetailIndex';} if(isset($product_type) && $product_type=='supplies'){ echo "suppliesDetailIndex"; } ?>">
                         <div style="width:100%;float: left;padding: 0px;">
                               <div style="width:100%;">
                                    <label for="start_time" style="width: 10%; text-align: right">创建时间：</label>
                                    <input style="width:12%" type="text" id="start_time" name="start_time" <?php if(isset($start_time)) echo "value='{$start_time}'"; ?> >
                                    <label for="end_time" style="width: 10%; text-align: right">到：</label>
                                    <input type="text" id="end_time" name="end_time"  <?php if(isset($end_time)) echo "value='{$end_time}'"; ?> >
                                </div> 
                       		<div  style="width:100%;">
                                <label for="from_facility_id" style="width: 10%; text-align: right">出库仓库：</label>
								<select style="width:12%; height: 30px" id="from_facility_id" name="from_facility_id" >
                                	<?php foreach ( $user_facility_list as $facility ) {
										if (isset( $from_facility_id ) && $facility ['facility_id'] == $from_facility_id) {
											echo "<option value=\"{$facility['facility_id']}\" selected='true'>{$facility['facility_name']}</option>";
										} else {
											echo "<option value=\"{$facility['facility_id']}\">{$facility['facility_name']}</option>";
										}
									} ?>
                    			</select>
                    			<label for="ti_sn" style="width: 10%; text-align: right">调拨单批次：</label>
                                <input type="text" id="ti_sn" name="ti_sn" <?php if(isset($ti_sn)) echo "value={$ti_sn}"; ?> >
                        	 </div>
                         	<div style="width:100%">
                                <label for="to_facility_id" style="width: 10%; text-align: right">入库仓库：</label>
								<select style="width:12%; height: 30px" id="to_facility_id" name="to_facility_id" >
								 <option value="">全部</option>
                                	<?php foreach ( $facility_list as $facility ) {
										if (isset( $to_facility_id ) && $facility ['facility_id'] == $to_facility_id) {
											echo "<option value=\"{$facility['facility_id']}\" selected='true'>{$facility['facility_name']}</option>";
										} else {
											echo "<option value=\"{$facility['facility_id']}\">{$facility['facility_name']}</option>";
										}
									} ?>
                    			</select>
                    			<label for="ti_sn" style="width: 10%; text-align: right">
                                    <select name="product_type" id="product_type" disabled="disabled">
                                        <option value="goods" <?php if($product_type=='goods') echo "selected=selected"; ?> >商品</option>
                                        <option value="supplies" <?php if($product_type=='supplies') echo "selected=selected"; ?> >耗材</option>
                                    </select>
                                </label>
                                <input type="text" id="product_name" name="product_name" <?php if(isset($product_name)) echo "value={$product_name}"; ?> >
                                <input type="hidden" id="product_id" name="product_id" <?php if(isset($product_id)) echo "value={$product_id}"; ?>/>
                         	</div>
                         <div style="width: 100%;float:left;">
                                <div style="width:66%;float:left;text-align: center;">
                                	<input type="hidden" name="act" id="act" value="query">
                                    <button type="button" class="btn btn-primary btn-sm"  id="query"  >搜索 </button> 
                                    <span>&nbsp;</span>
                                    <button type="button" class="btn btn-primary btn-sm"  id="download" >导出</button>
                                </div>
                                <!-- 隐藏的 input  start  -->
                                <input type="hidden" id="page_current" name="page_current" <?php if(isset($page_current)) echo "value={$page_current}"; ?> /> 
                                <input type="hidden" id="page_count" name="page_count" <?php if(isset($page_count)) echo "value={$page_count}"; ?> />
                                <input type="hidden" id="page_limit" name="page_limit" <?php if(isset($page_limit)) echo "value={$page_limit}"; ?> /> 
                                <!-- 隐藏的 input  end  -->
                         </div>
                        </form>
                        <!-- list start -->
                        <div class="row col-sm-12 " style="margin-top: 10px;">
                            <table class="table table-striped table-bordered ">
                                <thead>
                                    <tr>
                                        <th>出库仓库</th>
                                        <th>入库仓库</th>
                                        <th>调拨批次</th>
                                        <th>状态</th>
                                        <th>PRODUCT_ID</th>
                                        <th>商品</th>
                                        <th>箱规</th>
                                        <th>供应商</th>
                                        <th>装车批次</th>
                                        <th>六联单</th>
                                        <th>车牌号</th>
                                        <th>司机电话</th>
                                        <th>司机名字</th>
                                        <th>车队</th>
                                        <th>车型</th>
                                        <th>创建时间</th>
                                        <th>装车时间</th>
                                        <th>入库时间</th>
                                        <th>计划调拨数量</th>
                                        <th>装车数量</th>
                                        <th>入库数量</th>
                                        <th>盘亏数量</th>
                                        <th>追回数量</th>
                                        <th>差异</th>
                                        <th>备注</th>
                                    </tr>
                                </thead>
                                                            
                                <?php if( isset($item_list) && is_array($item_list))  foreach ($item_list as $key => $item) { ?> 
                                <tbody >
                                    <tr>
                                        <td class="product_cell"><?php echo $item['from_facility_name']?></td>
                            			<td class="product_cell"><?php echo $item['to_facility_name']?></td>
                            			<td class="product_cell"><?php echo $item['ti_sn']?></td>
                            			<td class="product_cell"><?php echo $item['inventory_status'] == "FINISH" ? "已入库" : "未入库"?></td>
                            			<td class="product_cell"><?php echo $item['product_id']?></td>
                            			<td class="product_cell"><?php echo $item['product_name']?></td>
                            			<td class="product_cell"><?php echo $item['container_quantity'] .  $item['unit_code']?>/箱</td>
                            			<td class="product_cell"><?php echo $item['product_supplier_name']?></td>
                            			<td class="product_cell"><?php echo $item['bol_sn']?></td>
                                        <td class="product_cell"><?php echo $item['invoice_no']?></td>
                            			<td class="product_cell"><?php echo $item['car_num']?></td>
                            			<td class="product_cell"><?php echo $item['driver_mobile']?></td>
                            			<td class="product_cell"><?php echo $item['driver_name']?></td>
                                        <td class="product_cell"><?php echo $item['car_provider']?></td>
                                        <td class="product_cell"><?php echo $item['car_model']?></td>
                            			<td class="product_cell"><?php echo $item['ti_created_time']?></td>
                            			<td class="product_cell"><?php echo $item['bol_created_time']?></td>
                            			<td class="product_cell"><?php echo $item['finish_time']?></td>
                            			<td class="product_cell"><?php echo $item['plan_case_num']?></td>
                            			<td class="product_cell"><?php echo $item['from_quantity']?></td>
                            			<td class="product_cell"><?php echo $item['to_quantity']?></td>
                            			<td class="product_cell"><?php echo $item['variance_quantity']?></td>
                            			<td class="product_cell"><?php echo $item['return_quantity']?></td>
                            			<td class="product_cell transit_quantity"><?php echo $item['transit_quantity']?></td>
                            			<td class="product_cell"><?php echo $item['note']?></td>
                                    </tr>
                                </tbody>
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
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/lhgcalendar.min.js"></script>
<script type="text/javascript">
    (function(config){
        config['extendDrag'] = true; // 注意，此配置参数只能在这里使用全局配置，在调用窗口的传参数使用无效
        config['lock'] = true;
        config['fixed'] = true;
        config['okVal'] = 'Ok';
        config['format'] = 'yyyy-MM-dd HH:mm:ss';
    })($.calendar.setting);

    $("#start_time").calendar({btnBar:true});
    $("#end_time").calendar({btnBar:true});

    function product_name_complete(autocompleteList){
        $('#product_name').autocomplete(autocompleteList, {
            minChars: 0,
            width: 310,
            max: 100,
            matchContains: true,
            autoFill: false,
            formatItem: function(row, i, max) {
                return(row.product_name);
            },
            formatMatch: function(row, i, max) {
                return(row.product_name);
            },
            formatResult: function(row) {
                return(row.product_name);
            }
        }).result(function(event, row, formatted) {
            $('#product_id').val(row.product_id);
        });
    };

    var WEB_ROOT = $("#WEB_ROOT").val(),
        product_type = '<?php echo $product_type ?>';
    (function($){//获取autocomplete的数据
        $.ajax({
            url:WEB_ROOT + "launchTransferInventoryList/getProductListBysubTypes",
            type:"post",
            dataType:"json",
            data:{"product_type":product_type},
            xhrFields: {
                withCredentials: true
            }
        })
        .done(function(data){
            if(data.success == "success"){
        
                $('#product_name').autocomplete(data.product_list, {
                    minChars: 0,
                    width: 310,
                    max: 100,
                    matchContains: true,
                    autoFill: false,
                    formatItem: function(row, i, max) {
                        return(row.product_id + "【" +row.product_name + "】");
                    },
                    formatMatch: function(row, i, max) {
                    	return(row.product_id + "【" +row.product_name + "】");
                    },
                    formatResult: function(row) {
                    	return(row.product_id + "【" +row.product_name + "】");
                    }
                }).result(function(event, row, formatted) {
                    $('#product_id').val(row.product_id);
                });
            }    
        })
        .fail(function(){
            alert('ajax发送失败');
        });
    })(jQuery);    
	
    $("#query").click(function(){
        $("#page_current").val("1");
        $("#act").val("query");
        $("form").submit();
    }); 
     
     // 点击下载 excel 按钮 
     $('#download').click(function(){
        $("#act").val("download");
        $("form").submit();
     }); 

    // 分页 
    $('a.page').click(function(){
        var page =$(this).attr('p');
        $("#page_current").val(page); 
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

</script>
</body>
</html>
