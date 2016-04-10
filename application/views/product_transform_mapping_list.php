<!doctype html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<title>乐微SHOP</title>
<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/order.css">
<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/buttons.dataTables.css">
<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/autocomplete.css">
</head>
<body>
    <!-- <div id="loadding" class="loadding" style="display:none;"><img src="<?//php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/img/loadding.gif" ></div> -->
    <div class="container-fluid" style="margin-left: -18px;padding-left: 19px;" >
        <div role="tabpanel" class="row tab-product-list tabpanel" >
            <div class="col-md-12">
                <!-- Nav tabs -->
                <input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> >
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="onsale">
                        <form style="width:100%;" method="post" 
                                action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>ProductTransformMappingList/query">
                            <div class="row">
                                <label for="transform_type" class="col-sm-2 control-label">类型</label>
                                <div class="col-sm-3">
                                    <select  name="transform_type" id="transform_type" class="form-control" onchange="change()">
                                        <option value="">全部</option>
                                        <option value="RAW2RAW"  <?php if(isset($transform_type) && $transform_type == 'RAW2RAW') echo "selected='true'" ?>>原料转原料</option>
                                        <option value="FINISHED2RAW"  <?php if(isset($transform_type) && $transform_type == 'FINISHED2RAW') echo "selected='true'" ?>>成品转原料</option>
                                    </select>
                                </div>
                               <!--  <label class="col-sm-2 control-label">数量</label>
                                <div class="col-sm-3">
                                    <input required="required" type="number" class="form-control" name="quality" id="quality" value="<?//php if(isset($quality)) echo "{$quality}"; ?>">
                                </div> -->
                            </div>
                            <br>
                            <div class="row">
								<label for="from_product_name" class="col-sm-2 control-label">A果</label>
								<div class="col-sm-3">
									<input required="required" type="text" class="form-control" name="from_product_name" id="from_product_name" value="<?php if(isset($from_product_name)) echo "{$from_product_name}"; ?>">
								</div>
                                <input type="hidden" id="from_product_id" name="from_product_id" <?php if(isset($from_product_id)) echo "value=\"{$from_product_id}\""; ?>/>
								<label for="to_product_name" class="col-sm-2 control-label">B果</label>
								<div class="col-sm-3">
									<input required="required" type="text" class="form-control" name="to_product_name" id="to_product_name" value="<?php if(isset($to_product_name)) echo "{$to_product_name}"; ?>">
								</div>
                                <input type="hidden" id="to_product_id" name="to_product_id" <?php if(isset($to_product_id)) echo "value=\"{$to_product_id}\""; ?>/>
							</div>
                            <br>
                             <div style="width: 100%;float:left;">
                                    <div style="width:38%;float:right;text-align: center;">
                                        <button type="button" class="btn btn-primary"  id="creat">
                                            <a href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>ProductTransformMappingList/index" style="color:#fff;">新建</a> 
                                        </button> 
                                        <button type="button" class="btn btn-primary"  id="query">搜索 </button> 
                                    </div>
                                    <!-- 隐藏的 input  start  -->
                                    <input type="hidden" name="act" id="act">
                                    <input type="hidden"  id="page_current" name="page_current"  
                                            <?php if(isset($page_current)) echo "value={$page_current}"; ?> /> 
                                    <input type="hidden"  id="page_count" name="page_count"  
                                            <?php if(isset($page_count)) echo "value={$page_count}"; ?> />
                                    
                                    <input type="hidden"  id="page_limit" name="page_limit"
                                            <?php if(isset($page_limit)) echo "value={$page_limit}"; ?> /> 
                                    <!-- 隐藏的 input  end  -->
                             </div>

                        </form>
        
<br/>
<br/>

                        <!-- product list start -->
                        <div class="row col-sm-15 " style="margin-top: 10px;">
                            <table class="table table-striped table-bordered " id="list">
                                <thead>
                                    <tr>
                                        <th>form_product_id</th>
                                        <th>A果</th>
                                        <th>to_product_id</th>
                                        <th>B果</th>
                                        <th>类型 </th>
                                        <th>转化比例</th>
                                        <th>单价比例</th>
                                        <th>创建时间</th>
                                        <th>创建人</th>
                                        <th>备注</th>
                                    </tr>
                                </thead>
                            <?php if (is_array($product_transform_mapping_list)) {
                            	foreach ($product_transform_mapping_list as $product_transform_mapping) {
                            		?>
                            		<tr>
                                        <td class="product_cell">
                                            <?php echo $product_transform_mapping['from_product_id']?>
                                        </td>
                            			<td class="product_cell">
                                            <?php echo $product_transform_mapping['from_product_name']?>
                                        </td>
                                        <td class="product_cell">
                                            <?php echo $product_transform_mapping['to_product_id']?>
                                        </td>
                                        <td class="product_cell">
                                        	<?php echo $product_transform_mapping['to_product_name']?>
                                        </td>
                            			<td class="product_cell">
                            				<?php 
                            					if($product_transform_mapping['transform_type'] == 'RAW2RAW') {
                            						echo "原料转原料"; 
                            					}else {
                            						echo "成品转原料";
                            				}?>
                            			</td>
                            			<td class="product_cell">
                                            <?php echo $product_transform_mapping['quantity']?>
                                        </td>
                                        <td class="product_cell">
                                            <?php echo $product_transform_mapping['price_quantity']?>
                                        </td>
                                        <td class="product_cell">
                                            <?php echo $product_transform_mapping['created_time']?>
                                        </td>
                                        <td class="product_cell">
                                            <?php echo $product_transform_mapping['created_user']?>
                                        </td>
                                        <td class="product_cell">
                                            <?php echo $product_transform_mapping['note']?>
                                        </td>
                            		</tr>
                            		<?php
                            	}
                            }?>
                                                            
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
                </div>
            </div>
        </div>
    </div>
    
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/dataTables.buttons.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/buttons.colVis.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/buttons.flash.js"></script>
<script type="text/javascript">
$(document).ready(function(){         
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
    var value = $('#transform_type').val();
    getChangeList(value);
});

var WEB_ROOT = $("#WEB_ROOT").val();
var listArray1 = [],
listArray2 = [];

 $("#query").click(function(){
     $("#act").val("query");
     $("form").submit();
 });

function getChangeList(transform_type){
    $.ajax({
        url:WEB_ROOT + "ProductTransformProduct/getProductList",
        type:"get",
        dataType:"json",
        xhrFields: {
            withCredentials: true
        }
    }).done(function(data){
        if(data.success == "success"){
            $('#from_product_name').autocomplete(data.product_list, {
                minChars: 0,
                width: 310,
                max: 100,
                matchContains: true,
                autoFill: false,
                cacheLength: 0,
                formatItem: function(row, i, max) {
                    return("[" + row.product_id + "]" + row.product_name);
                },
                formatMatch: function(row, i, max) {
                    return("[" + row.product_id + "]" + row.product_name);
                },
                formatResult: function(row) {
                    return("[" + row.product_id + "]" + row.product_name);
                }
            }).result(function(event, row, formatted) {
                $('#from_product_id').val(row.product_id);
            });
            $('#to_product_name').autocomplete(data.product_list, {
                minChars: 0,
                width: 310,
                max: 100,
                matchContains: true,
                autoFill: false,
                cacheLength: 0,
                formatItem: function(row, i, max) {
                    return("[" + row.product_id + "]" + row.product_name);
                },
                formatMatch: function(row, i, max) {
                    return("[" + row.product_id + "]" + row.product_name);
                },
                formatResult: function(row) {
                    return("[" + row.product_id + "]" + row.product_name);
                }
            }).result(function(event, row, formatted) {
                $('#to_product_id').val(row.product_id);
            });
        }
    });
}

function change(){
    // $("#loadding").show();
    $("#from_product_name").val('');
    var value = $('#transform_type').val();
    console.log(value);
    getChangeList(value);
}


</script>
</body>
</html>