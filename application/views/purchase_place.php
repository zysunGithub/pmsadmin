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
        <div role="tabpanel" class="row tab-product-list tabpanel" >
            <div class="col-md-12">
                <!-- Nav tabs -->
                <input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> >
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="onsale">
                        <form style="width:100%;" method="post" action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>./purchasePlace">
                         <div style="width:100%;float: left;padding: 0px;">
                               <div style="width:100%;">
                                    <label for="start_time" style="width: 10%; text-align: right">开始日期：</label>
                                    <input style="width:12%" type="text" id="start_time" name="start_time" <?php if(isset($start_time)) echo "value='{$start_time}'"; ?> >
                                    <label for="end_time" style="width: 10%; text-align: right">截止日期：</label>
                                    <input type="text" id="end_time" name="end_time" <?php if(isset($end_time)) echo "value='{$end_time}'"; ?> >
                                </div> 
                                <div  style="width:100%;">
                                <label for="area_id" style="width: 10%; text-align: right">大区：</label>
								<select style="width:12%; height: 30px" id="area_id" name="area_id" >
									<option value="">全部</option>
                                	<?php foreach ( $area_list as $area ) {
										if (isset( $area ) && $area ['area_id'] == $area_id) {
											echo "<option value=\"{$area ['area_id']}\" selected='true'>{$area['area_name']}</option>";
										} else {
											echo "<option value=\"{$area ['area_id']}\">{$area['area_name']}</option>";
										}
									} ?>
                    			</select>
                    			 <label for="purchase_place_name" style="width: 10%; text-align: right">采购地点：</label>
                                    <input style="width:12%" type="text" id="purchase_place_name" name="purchase_place_name" <?php if(isset($purchase_place_name)) echo "value='{$purchase_place_name}'"; ?> >
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
                        <!-- product list start -->
                        <div class="row  col-sm-10 " style="margin-top: 10px;">
                        	<input type="button" class="btn btn-primary" value="添加" id="add_modal_btn">
                            <table id='purchase_place_table' class="table table-striped table-bordered ">
                                <thead>
                                    <tr>
                                    	<th>采购地点类型</th>
                                        <th>采购地点</th>
                                        <th>大区</th>
                                        <th>创建时间</th>
                                        <th width="10%">操作</th>
                                    </tr>
                                </thead>
                                                            
                                <?php if( isset($purchase_place_list) && is_array($purchase_place_list))  foreach ($purchase_place_list as $key => $purchase_place) { ?> 
                                <tbody >
                                    <tr class="content">
                                    	<td>
                                            <?php if($purchase_place['type'] === 'MARKET'){ echo "水果市场";}else if($purchase_place['type'] === 'ORIGIN'){echo "产地直采";}else if($purchase_place['type'] === 'SUPPLIER'){echo "供应商直采";}?>
                                        </td>
                                        <td>
                                            <?php echo !empty($purchase_place['purchase_place_name'])?$purchase_place['purchase_place_name']:'' ?> 
                                        </td>
                                        <td>
                                            <?php echo !empty($purchase_place['area_name'])?$purchase_place['area_name']:'' ?> 
                                        </td>
                                        <td><?php echo !empty($purchase_place['created_time'])?$purchase_place['created_time']:''?></td>
                                        <td>
                                        	<input type="button" class="btn btn-danger del-purchase-place" value="删">
                                        </td>
                                        <td class="purchase_place_id" hidden="true"><?php echo $purchase_place['purchase_place_id']?></td>
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

<!-- Modal -->
<div>
<div class="modal fade ui-draggable" id="add_modal" role="dialog"  >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" id="btnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">添加采购地点</h4>
      </div>
      <div class="modal-body ">
      	<div class='row'>
      	    <label for="add_area_id" style="width: 10%; text-align: right">类型：</label>
			<select style="width:20%; height: 30px" id="place_type" name="place_type" >
				<option value="MARKET">水果市场</option>
				<option value="ORIGIN">原产地直采</option>
				<option value="SUPPLIER">供应商直采</option>
	        </select>
      		<label for="add_area_id" style="width: 10%; text-align: right">大区：</label>
			<select style="width:20%; height: 30px" id="add_area_id" name="add_area_id" >
	            <?php foreach ( $area_list as $area ) {
					echo "<option value=\"{$area ['area_id']}\">{$area['area_name']}</option>";
				} ?>
	        </select>
	        
      	</div>
      	<div class='row'>
      		<label for="add_purchase_place_name" style="width: 10%; text-align: right">采购地点：</label>
        	<input style="width:50%" type="text" id="add_purchase_place_name" name="add_purchase_place_name" >
        </div>
      </div>
    <div class="modal-footer">
      	<input id="add_purchase_place_sub" type="button" class="btn btn-primary" style="text-align: right" value="添加">
      </div>
    </div>
  </div>
</div>
</div>
<!-- modal end  -->
    
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

    $('#add_modal_btn').click(function(){
        $('#add_modal').modal('show').on();
    });

    $('#add_purchase_place_sub').click(function(){

		var cf=confirm( '是否确认添加采购地点 ');
   		
		if (cf==false)
			return false;
        btn = $(this);

        purchase_place_name = $('#add_purchase_place_name').val();
        area_id = $('#add_area_id').val();
        place_type = $('#place_type').val();
        submit_data = {
                'purchase_place_name':purchase_place_name,
                'type':place_type,
                'area_id':area_id                
        };
        var postUrl = $('#WEB_ROOT').val() + 'purchasePlace/addPurchasePlace';
        btn.attr('disabled','true');
	    $.ajax({
            url: postUrl,
            type: 'POST',
            data: submit_data, 
            dataType: "json", 
            xhrFields: {
              withCredentials: true
            }
	  }).done(function(data){
	      if(data.success == "success"){
	    	  alert("添加成功");
	    	  location.reload();
	      }else{
	    	  btn.removeAttr('disabled');
	          alert(data.error_info);
	        }
	    }).fail(function(data){
	    	btn.removeAttr('disabled');
		    alert('error');
	    });
	    
    });

    $('.del-purchase-place').click(function(){
		var cf=confirm( '是否确认删除采购地点 ');
   		
		if (cf==false)
			return false;
        btn = $(this);
        purchase_place_id = $(this).parent().parent().find("td.purchase_place_id").html();

        submit_data = {
                'purchase_place_id':purchase_place_id 
        };
        var postUrl = $('#WEB_ROOT').val() + 'purchasePlace/removePurchasePlace';
        btn.attr('disabled','true');
	    $.ajax({
            url: postUrl,
            type: 'POST',
            data: submit_data, 
            dataType: "json", 
            xhrFields: {
              withCredentials: true
            }
	  }).done(function(data){
	      if(data.success == "success"){
	    	  alert("删除成功");
	    	  btn.parent().parent().remove();
	    	  $('#add_modal').modal('hide');
	      }else{
	    	  btn.removeAttr('disabled');
	          alert(data.error_info);
	        }
	    }).fail(function(data){
	    	btn.removeAttr('disabled');
		    alert('error');
	    });
    });
</script>
</body>
</html>
