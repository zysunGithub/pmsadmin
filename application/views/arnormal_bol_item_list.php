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
        <div role="tabpanel" class="row tab-product-list tabpanel" >
            <div class="col-md-12">
                <!-- Nav tabs -->
                <input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> >
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="onsale">
                        <form style="width:100%;" method="post" action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>ArnormalBolItemList">
                         <div style="width:100%;float: left;padding: 0px;">
                               <div style="width:100%;">
                                    <label for="start_time" style="width: 10%; text-align: right">开始日期：</label>
                                    <input style="width:12%" type="text" id="start_time" name="start_time" <?php if(isset($start_time)) echo "value={$start_time}"; ?> >
                                    <label for="end_time" style="width: 10%; text-align: right">截止日期：</label>
                                    <input type="text" id="end_time" name="end_time" <?php if(isset($end_time)) echo "value={$end_time}"; ?> >
                                </div> 
                                <div  style="width:100%;">
                                <label for="facility_id" style="width: 10%; text-align: right">仓库：</label>
								<select style="width:12%; height: 30px" id="facility_id" name="facility_id" >
                                	<?php foreach ( $facility_list as $facility ) {
										if (isset( $facility_id ) && $facility ['facility_id'] == $facility_id) {
											echo "<option value=\"{$facility['facility_id']}\" selected='true'>{$facility['facility_name']}</option>";
										} else {
											echo "<option value=\"{$facility['facility_id']}\">{$facility['facility_name']}</option>";
										}
									} ?>
                    			</select>
                    			<label for="bol_sn" style="width: 10%; text-align: right">装车单：</label>
                                <input type="text"  id="bol_sn" name="bol_sn" <?php if(isset($bol_sn))  echo "value={$bol_sn}"; ?> >
                                <label><input name="is_arnormal" type="checkbox" <?php 
                                if(isset($is_arnormal) && $is_arnormal == 1)  echo "checked='checked'" ?> value="1" />异常</label> 
                         </div>
                         <div style="width: 100%;float:left;">
                            <div style="width:100%;">
                                <label for="facility_id" style="width: 10%; text-align: right">产品类型</label>
                                <select style="width:12%; height: 30px" id="product_type" name="product_type" >
                                    <option value="goods"<?php if( $product_type == "goods") echo " selected=\"true\"";?>>商品</option>
                                    <option value="supplies"<?php if( $product_type == "supplies") echo " selected=\"true\"";?>>耗材</option>
                                </select>
                                <label style="width: 10%; text-align: right; margin-left:10%">
                                <button type="button" class="btn btn-primary btn-sm"  id="query"  >搜索 </button>
                                </label>
                            </div>
                                <!-- 隐藏的 input  start  -->
                                <input type="hidden"  id="page_current" name="page_current" <?php if(isset($page_current)) echo "value={$page_current}"; ?> /> 
                                <input type="hidden"  id="page_count" name="page_count" <?php if(isset($page_count)) echo "value={$page_count}"; ?> />
                                <input type="hidden"  id="page_limit" name="page_limit" <?php if(isset($page_limit)) echo "value={$page_limit}"; ?> /> 
                                <!-- 隐藏的 input  end  -->
                         </div>
                        </form>
                        <!-- product list start -->
                        <div class="row  col-sm-10 " style="margin-top: 10px;">
                            <table class="table table-striped table-bordered ">
                                <thead>
                                    <tr>
                                        <th>仓库</th>
                                        <th>日期</th>
                                        <th>装车批次</th>
                                        <th>六联单</th>
                                        <th>PRODUCT_ID</th>
                                        <th>商品</th>
                                        <th>购买数量</th>
                                        <th>到货数量</th>
                                        <th>箱规</th>
                                        <th>单位</th>
                                    </tr>
                                </thead>
                                                            
                                <?php if( isset($bol_item_list) && is_array($bol_item_list))  foreach ($bol_item_list as $key => $bol_item) { ?> 
                                <tbody >
                                    <tr>
                                        <td class="product_cell">
                                            <?php echo $bol_item['facility_name'] ?> 
                                        </td>
                                        <td class="product_cell">
                                            <?php echo $bol_item['created_time'] ?> 
                                        </td>
                                        <td class="product_cell">
                                             <?php echo $bol_item['bol_sn'] ?>   
                                        </td>
                                        <td class="product_cell">
                                             <?php echo $bol_item['invoice_no'] ?>
                                        </td>
                                        <td class="product_cell">
                                             <?php echo $bol_item['product_id'] ?>   
                                        </td>
                                        <td class="product_cell">
                                             <?php echo $bol_item['product_name'] ?>   
                                        </td>
                                        <td class="product_cell">
                                             <?php echo $bol_item['purchase_case_num'] ?>   
                                        </td>
                                        <td class="product_cell">
                                             <?php echo $bol_item['finish_case_num'] ?>    
                                        </td>
                                        <td class="product_cell">
                                             <?php echo $bol_item['container_quantity'] ?>    
                                        </td>
                                         <td class="product_cell">
                                             <?php echo $bol_item['product_unit_code'] ?>    
                                        </td>
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

<script type="text/javascript">
	$(document).ready(function(){
	    (function(config){
	        config['extendDrag'] = true; // 注意，此配置参数只能在这里使用全局配置，在调用窗口的传参数使用无效
	        config['lock'] = true;
	        config['fixed'] = true;
	        config['okVal'] = 'Ok';
	        config['format'] = 'yyyy-MM-dd';
	    })($.calendar.setting);

	    $("#start_time").calendar({btnBar:true});
	    $("#end_time").calendar({btnBar:true});
	}) ;	
     $("#query").click(function(){
		if($.trim($('#end_time').val()) == '' || $.trim($('#start_time').val()) == '') {
			alert('日期不能为空');
			return;
		}
         
         var end_time = new Date($('#end_time').val());
         var start_time = new Date($('#start_time').val());
         if(end_time.diff(start_time) > 30) {
             alert('搜索不能超过30天');
             return;
         }
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
//
</script>
</body>
</html>
