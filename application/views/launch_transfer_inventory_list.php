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
                        <form style="width:100%;" method="post" action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>launchTransferInventoryList/<?php if(isset($product_type) && $product_type=='supplies')  echo 'suppliesIndex'; if(isset($product_type) && $product_type=='goods') echo "index"; ?>">
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
                    			<label for="ti_sn" style="width: 10%; text-align: right">包含<?php if(isset($product_type_name)) echo $product_type_name; ?>：</label>
                                <input type="text" id="product_name" name="product_name" <?php if(isset($product_name)) echo "value={$product_name}"; ?> >
                                <input type="hidden" id="product_id" name="product_id" <?php if(isset($product_id)) echo "value={$product_id}"; ?>/>
                         	</div>
                         <div style="width: 100%;float:left;">
                                <div style="width:66%;float:left;text-align: center;">
                                    <button type="button" class="btn btn-primary btn-sm"  id="query"  >搜索 </button> 
                                </div>
                                <!-- 隐藏的 input  start  -->
                                <input type="hidden" id="page_current" name="page_current" <?php if(isset($page_current)) echo "value={$page_current}"; ?> /> 
                                <input type="hidden" id="page_count" name="page_count" <?php if(isset($page_count)) echo "value={$page_count}"; ?> />
                                <input type="hidden" id="page_limit" name="page_limit" <?php if(isset($page_limit)) echo "value={$page_limit}"; ?> /> 
                                <input type="hidden" id="product_type" name="product_type" <?php if(isset($product_type)) echo "value={$product_type}"; ?> />
                                <!-- 隐藏的 input  end  -->
                         </div>
                        </form>
                        <!-- list start -->
                        <div class="row col-sm-12 " style="margin-top: 10px;">
                        	<?php if($this->helper->chechActionList(array('editTransferInventory'))) {?>
                        		<div> <button type="button" class="btn btn-primary" id="addTransferInventory">添加调拨单 </button> </div>
                        	<?php }?>
                        	<div style="color: red;">装车出库会减少出库仓库库存，并创建装车单</div>
                            <table class="table table-striped table-bordered ">
                                <thead>
                                    <tr>
                                        <th>出库仓库</th>
                                        <th>入库仓库</th>
                                        <th>创建时间</th>
                                        <th>调拨单批次</th>
                                        <th>状态</th>
                                        <th>备注</th>
                                        <th>详情</th>
                                        <th>装车出库</th>
                                        <th>删除</th>
                                    </tr>
                                </thead>
                                                            
                                <?php if( isset($item_list) && is_array($item_list))  foreach ($item_list as $key => $item) { ?> 
                                <tbody >
                                    <tr>
                                        <td class="from_facility_name"><?php echo $item['from_facility_name'] ?></td>
                                        <td class="to_facility_name"><?php echo $item['to_facility_name'] ?></td>
                                        <td class="created_time"><?php echo $item['created_time'] ?></td>
                                        <td class="ti_sn"><?php echo $item['ti_sn'] ?></td>
                                        <td class="process_status"><?php 
                                       		if($item['process_status'] == 'INIT') {
                                       			echo '未装车出库';
                                       		} else if($item['process_status'] == 'SETOFF') {
                                       			echo '已装车出库';
                                       		} else if($item['process_status'] == 'ARRIVAL') {
                                       			echo '目的仓库已入库';
                                       		} else {
                                       			echo '状态错误';
                                       		}
                                        ?>
                                        
                                        </td>
                                        <td class="note"><?php echo $item['note']?></td>
                                        <td><input type="button" class="btn btn-info detail_b" id="detail_btn" value="详情"></td>
                                        <td>
                                        <?php if($this->helper->chechActionList(array('transferOut'))) {?>
                                        <a class="btn btn-primary" href="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT ; ?>./loadingBill/tiIndex?asn_id=<?php echo $item['asn_id']?>&from_facility_name=<?php echo $item['from_facility_name'] ?>&to_facility_name=<?php echo $item['to_facility_name'] ?>">装车出库</a>
                                        <?php }?>
                                        </td>
                                        <?php if($this->helper->chechActionList(array('editTransferInventory'))) {?>
                                        <td><input type="button" class="btn btn-danger remove_b" id="del_btn" value="删"></td>
                                        <?php }?>
                                        <td hidden="hidden" class="ti_id"><?php echo $item['ti_id']?></td>
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
    
<!-- Modal -->
<div>
<div class="modal fade ui-draggable" id="add_modal" role="dialog"  >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" id="btnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">添加调拨单</h4>
      </div>
      <div class="modal-body ">
      	<div class='row'>
      		 <div  style="width:100%;">
                 <label for="add_modal_from_facility_id" style="width: 10%; text-align: right"><span class="required">*</span>出库仓库：</label>
				 <select style="width:20%; height: 30px;" id="add_modal_from_facility_id" name="add_modal_from_facility_id" >
		            <?php foreach ( $user_facility_list as $facility ) {
						echo "<option value=\"{$facility['facility_id']}\">{$facility['facility_name']}</option>";
					} ?>
                 </select>
            	<label for="add_modal_to_facility_id" style="width: 10%; text-align: right"><span class="required">*</span>入库仓库：</label>
				<select style="width:20%; height: 30px;" id="add_modal_to_facility_id" name="add_modal_to_facility_id" >
                    <option value="0" selected="true">请选择入库仓库</option>
                   	<?php foreach ( $facility_list as $facility ) {
						if (isset( $to_facility_id ) && $facility ['facility_id'] == $to_facility_id) {
							echo "<option value=\"{$facility['facility_id']}\" selected='true'>{$facility['facility_name']}</option>";
						} else {
							echo "<option value=\"{$facility['facility_id']}\">{$facility['facility_name']}</option>";
						}
					} ?>
              	</select>
              </div>
              <div style="width:100%">
	              <label for="add_modal_note" style="width: 10%; text-align: right">备注：</label>
	              <textarea rows="3" cols="60" id="add_modal_note" name="add_modal_note"></textarea>
              </div>
      	</div>
      	<div class='row'><input id="add_modal_recent_purchase_product_btn" type="button" class="btn btn-primary btn-sm" style="text-align: left;margin-left: 35px" value="添加<?php if(isset($product_type_name)) echo $product_type_name; ?>">
      	<table id="add_modal_table" name="add_modal_table" border=3 style="width:100%">
			<tr>
				<th style="width:30%;"><?php if(isset($product_type_name)) echo $product_type_name; ?></th>
				<th style="width:13%;">调拨箱数 </th>
				<th style="width:15%;">箱规</th>
				<th style="width:15%;">单位</th>
				<th style="width:15%;">操作</th>
			</tr>
		</table>
      </div>
      <div class="modal-footer">
      	<input id="add_modal_submit" type="button" class="btn btn-primary" style="text-align: right" value="提交">
      </div>
    </div>
  </div>
</div>
</div>
<!-- modal end  -->
    
    <!-- Modal -->
<div>
<div class="modal fade ui-draggable" id="detail_modal" role="dialog"  >
  <div class="modal-dialog" style="width:980px">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" id="btnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">调拨单详情</h4>
      </div>
      <div class="modal-body ">
      	<div class='row'>
      	<table id="detail_modal_table" name="detail_modal_table" border=3 style="width:100%">
			<tr>
				<th style="width:10%;">装车时间</th>
				<th style="width:5%;">装车批次</th>
                <th style="width:5%;">六联单</th>
				<th style="width:5%;">车牌号</th>
				<th style="width:5%;">司机名字</th>
				<th style="width:5%;">司机电话</th>
                <th style="width:5%;">车队</th>
                <th style="width:5%;">车型</th>
				<th style="width:30%;"><?php if(isset($product_type_name)) echo $product_type_name; ?></th>
				<th style="width:5%;">调拨箱数 </th>
				<th style="width:5%;">出库箱数 </th>
				<th style="width:5%;">入库箱数 </th>
				<th style="width:5%;">箱规</th>
				<th style="width:5%;">单位</th>
			</tr>
		</table>
      </div>
    </div>
  </div>
</div>
</div>
</div>
<!-- modal end  -->

<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/lhgcalendar.min.js"></script>
<script type="text/javascript">
var product_type = $("#product_type").val();
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
	    getRawMaterialList();
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
    //存库存sku列表
	var addModalProductList;

    function addModalProductChange(e){
        container_id = $(this).find("option:selected").val();
		$(this).parent().next().find('input').attr('placeholder',addModalProductList[container_id]['qoh']).val('');
		$(this).parent().next().next().html(addModalProductList[container_id]['quantity']);
		$(this).parent().next().next().next().html(addModalProductList[container_id]['unit_code']);
		$(this).parent().next().next().next().next().html(addModalProductList[container_id]['product_id']);
		$(this).parent().next().next().next().next().next().next().html(addModalProductList[container_id]['qoh']);
        return false;
    }

	//获取库存sku列表
	function getAddModalProductList(facility_id){
		addModalProductList = [];
		postUrl = $('#WEB_ROOT').val() + 'launchTransferInventoryList/getCanSaleProductList';
		var submit_data = { "facility_id":facility_id,"product_type":product_type};
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
	 	 	    data.product_list.forEach(function(e){
			  	product = {'product_id': e.product_id,'product_name':e.product_name,'container_id':e.container_id,'quantity':e.quantity,'unit_code':e.unit_code,'qoh':e.qoh};
			  	addModalProductList[e.container_id] = product;
	 	 	  })
 	      } else {
 	    	 alert('error,获取<?php if(isset($product_type_name)) echo $product_type_name; ?>列表错误');
 	      }
 	  }).fail(function(data){
 	 	  alert('fail,获取<?php if(isset($product_type_name)) echo $product_type_name; ?>列表错误');
 	  });
	}

    //添加调拨单
    $('#addTransferInventory').click(function(){
    	$("tr.transferInventoryProduct").remove();
    	facility_id = $('#add_modal_from_facility_id').val();
    	getAddModalProductList(facility_id);
        $('#add_modal').modal('show').on();
    });


    //添加sku
    $("#add_modal_recent_purchase_product_btn").click(function() {
        if(!addModalProductList || addModalProductList.length <= 0) {
            alert('该仓库无库存')
            return false;
        }
        var lineIndex = $("#add_modal_table tr.transferInventoryProduct").size();
		var tr = $("<tr>");
		tr.addClass('transferInventoryProduct');
		
		productSelect = $("<select>");
		addModalProductList.forEach(function(e){
			productOption = $("<option>");
			productOption.val(e.container_id);
			productOption.text(e.product_name + "(" + e.quantity +")");
			productSelect.append(productOption);
		});
		productSelect.change(addModalProductChange);
		td = $("<td>");
		td.append(productSelect);
		tr.append(td);

		
        planCaseNumInput = $("<input>");
        planCaseNumInput.attr('placeholder',addModalProductList[productSelect.find("option:selected").val()].qoh);
        td = $("<td>");
        td.append(planCaseNumInput);
        tr.append(td);
        
        td = $("<td>");
        td.html(addModalProductList[productSelect.find("option:selected").val()].quantity);
		tr.append(td);

		td = $("<td>");
		td.html(addModalProductList[productSelect.find("option:selected").val()].unit_code);
		tr.append(td);

		td = $("<td>");
		td.attr("hidden","hidden");
		td.html(addModalProductList[productSelect.find("option:selected").val()].product_id);
		tr.append(td);

 		delbtn = $("<input>");
 		delbtn.val('删');
 		delbtn.attr("type","button");
 		delbtn.addClass("btn-danger");
 		delbtn.addClass("add_modal_deltr");
 		delbtn.click(deltr);
 		td = $("<td>");
		td.append(delbtn);
		tr.append(td);


        td = $("<td>");
        td.html(addModalProductList[productSelect.find("option:selected").val()].qoh);
        td.attr('hidden','hidden');
        tr.append(td);
		$("#add_modal_table tr").eq(lineIndex).after(tr);
	});

	//删除行
	function deltr(){
		$(this).parent().parent().remove();
	}

	//改变仓库
	$('#add_modal_from_facility_id').change(function(e){
		$("tr.transferInventoryProduct").remove();
		facility_id = $('#add_modal_from_facility_id').val();
		getAddModalProductList(facility_id);

	});

	//提交调拨单
	$('#add_modal_submit').click(function(){
		note = $.trim($('#add_modal_note').val());
		from_facility_id = $('#add_modal_from_facility_id').val();
		to_facility_id = $('#add_modal_to_facility_id').val();
		if(from_facility_id == to_facility_id ){
			alert('出入库仓库不能相同');
			return;
		}
        if ( $("#add_modal_to_facility_id option:selected").val() == 0) {
            alert('调拨单必须指定入库仓库');
            return;
        }

		checkReContainers = new Array();
		available = true;
		var ti_items = new Array();
		$("tr.transferInventoryProduct").each(function(){
			container_id = $(this).find('td').eq(0).find('select').find('option:selected').val();
			if($.inArray(container_id,checkReContainers) > -1){
				alert('重复添加');
				available = false;
				return false;
			}
			plan_case_num = $.trim($(this).find('td').eq(1).find('input').val());
			if(plan_case_num == '' || (isNaN(plan_case_num) || plan_case_num <= 0)){
				alert("数量必填，且大于0 ！");
				available = false;
				return false;
			}

			qoh = $.trim($(this).find('td').eq(6).html());
			if(parseFloat(qoh) < parseFloat(plan_case_num)){
				alert("转仓数量不能超过仓库库存");
				available = false;
				return false;
			}
			
			container_quantity = $.trim($(this).find('td').eq(2).html());
			product_unit_code = $.trim($(this).find('td').eq(3).html());

			product_id = $.trim($(this).find('td').eq(4).html());
			var ti_item = {
		   			"container_id":container_id,
		   			"container_quantity":container_quantity,
				   	"plan_case_num":plan_case_num,
				   	"product_unit_code":product_unit_code,
				   	"product_id":product_id
				};
			ti_items.push(ti_item);
			checkReContainers.push(container_id);
		});

		var submit_data = {
        "product_type":product_type,
				"from_facility_id":from_facility_id,
				"to_facility_id":to_facility_id,
				"note":note,
				"ti_items":ti_items
			};
		if(available == false) {
			return false;
		}
		var cf=confirm( '是否提交' )
		if (cf==false)
			return false ;

		postUrl = $('#WEB_ROOT').val() + 'launchTransferInventoryList/addTransferInventory';
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
 	    	  alert("提交成功");
		      location.reload();
 	      } else {
 	    	 alert(data.error_info);
 	    	 $('#add_modal_submit').removeAttr('disabled');
 	      }
 	  }).fail(function(data){
 	 	  alert('提交失败');
 	 		$('#add_modal_submit').removeAttr('disabled');
 	  });
      $('#add_modal_submit').attr('disabled',"true");
});
	//详情
	$('.detail_b').click(function(e){
		$('tr.detailmodalproductlist').remove();
	 	ti_id = $(this).parent().siblings('.ti_id').html();

		$('#detail_modal').modal('show').on();
	 	if(ti_id == ''){
	 		alert('获取详情失败');
	 		return false;
	 	}
	 	submit_data= {'ti_id':ti_id};
	 	postUrl = $('#WEB_ROOT').val() + 'launchTransferInventoryList/detail';
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
	           data.item_list.forEach(function(e){
	        	   detail_modal_product_list(e);
	           });
	       } else {
	     	 alert(data.error_info);
	       }
	  }).fail(function(data){
	  	  alert('获取详情失败');
	  });
	});
	WEB_ROOT = $("#WEB_ROOT").val();
	function getRawMaterialList(){
		$.ajax({
			url:WEB_ROOT + "launchTransferInventoryList/getProductListBysubTypes",
			type:"post",
			dataType:"json",
      		data:{"product_type":product_type},
			xhrFields: {
	            withCredentials: true
	        }
		}).done(function(data){
			if(data.success == "success"){
        
				$('#product_name').autocomplete(data.product_list, {
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
			}	
		});
	}
	
 	function detail_modal_product_list(e){
 			var lineIndex = $("#detail_modal_table tr.detailmodalproductlist").size();
 			var tr = $("<tr>");
 			tr.addClass('detailmodalproductlist');
 			td = $("<td>");
 	        td.html(e.bol_created_time);
 	        tr.append(td);
 	        td = $("<td>");
 	        td.html(e.bol_sn);
 	        tr.append(td);
            td = $("<td>");
            td.html(e.invoice_no);
            tr.append(td);
 	        td = $("<td>");
 	        td.html(e.car_num);
 	        tr.append(td);
 	        td = $("<td>");
 	       	td.html(e.driver_name);
 	        tr.append(td);
 	        td = $("<td>");
 	        td.html(e.driver_mobile);
 	        tr.append(td);
            td = $("<td>");
            td.html(e.car_provider);
            tr.append(td);
            td = $("<td>");
            td.html(e.car_model);
            tr.append(td);
 	        td = $("<td>");
 	        td.html(e.product_name);
 	        tr.append(td);
 	        td = $("<td>");
 	        td.html(e.plan_case_num);
 	        tr.append(td);
 	        td = $("<td>");
 	        td.html(e.purchase_case_num);
 	        tr.append(td);
 	        td = $("<td>");
 	        td.html(e.finish_case_num);
 	        tr.append(td);
 	        td = $("<td>");
 	        td.html(e.quantity);
 	        tr.append(td);
 	        td = $("<td>");
 	        td.html(e.unit_code);
 	        tr.append(td);
 			$("#detail_modal_table tr").eq(lineIndex).after(tr);
 		}

	$('.remove_b').click(function(e){
		ti_id = $(this).parent().next().html();
		if(ti_id == '') {
			alert('无法删除，请联系erp');
			return false;
		}
		var cf=confirm( '是否删除' )
		if (cf==false)
			return false ;
		submit_data= {'ti_id':ti_id};
		postUrl = $('#WEB_ROOT').val() + 'launchTransferInventoryList/remove';
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
	           alert('删除成功')
	           location.reload();
	       } else {
	     	 alert(data.error_info);
	       }
	  }).fail(function(data){
	  	  alert('删除失败');
	  });
	});
</script>
</body>
</html>
