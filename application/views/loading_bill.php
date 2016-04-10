<!doctype html>
<html>

<head>
    <title>装车单</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="Pragma" content="no-cache">   
    <meta http-equiv="Cache-Control" content="no-store">
    <meta http-equiv="Expires" content="0">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT ; ?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT ; ?>assets/css/global.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/mobiscroll.core-2.5.2.css" />
	<link rel="stylesheet" type="text/css" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/mobiscroll.animation-2.5.2.css" />
    <!--[if lt IE 9]>
            <script src="http://assets.yqphh.com/assets/js/html5shiv.min-3.7.2.js"></script>
        <![endif]-->
    <style type="text/css">
        .main {
            width: 100%;
            max-width: 640px;
            margin: 0 auto;
        }

        .date {
        	font-size:15pt;
            float: left;
            color: red;
        }
        table {
            text-align: left;
            border: 1px;
            border-spacing: 0;
        }

        .text span {
            float: right;
        }
    </style>
</head>
<body>
<div class="container-fluid" style="margin-left: -18px;padding-left: 19px;" >
	<div role="tabpanel" class="row tab-product-list tabpanel" >
	<div class="col-md-12">
		<input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> >
		<?php if(isset($from_p) && $from_p == 'INDEX') {?>
		<form method="post" class="form-inline" action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>loadingBill?product_type=<?php echo $product_type;?>">
				<div class="row">
                    <div class="form-group">
					   <label for="start_time" class="col-sm-2 control-label"><h4>仓库</h4></label>
						<select name="facility_id" id="facility_id" class="form-control">
                        	<?php
							foreach ($facility_list as $facility) {
								if (isset ($facility_id) && $facility['facility_id'] == $facility_id) {
									echo "<option data-facility_type=\"{$facility['facility_type']}\" data-area_type=\"{$facility['area_type']}\" value=\"{$facility['facility_id']}\" selected='true'>{$facility['facility_name']}</option>";
								} else {
									echo "<option data-facility_type=\"{$facility['facility_type']}\" data-area_type=\"{$facility['area_type']}\" value=\"{$facility['facility_id']}\">{$facility['facility_name']}</option>";
								}
							}
							?>
                        
                        </select>
					</div>
                    <div class="form-group asn_wrap">
                        <?php if( ($facility_type == 3 || $facility_type == 4 || $facility_type==5) && $area_type == 'national' && isset($asn_list) && is_array($asn_list) ){?>
                        <label class="col-sm-2 control-label asn_label"><h4>大区</h4></label>
                        <select name="asn_id" id="asn_id" class="form-control">
                        <?php  
                            foreach ($asn_list as $key => $val) {
                                if( $val['asn_id'] == $asn_id ){
                                    echo '<option value="'.$val['asn_id'].'" selected="selected">'.$val['area_name'].'</option>';
                                }else{
                                    echo '<option value="'.$val['asn_id'].'">'.$val['area_name'].'</option>';
                                }
                            }
                        ?>
                        </select>
                        <?php } ?>
                    </div>
				</div>
				
             <div style="width: 100%;float:left;margin-top:10px;">
                    <div style="width:66%;float:left;text-align: center;">
                        <button type="submit" class="btn btn-primary btn-sm"  id="query"  >搜索 </button> 
                    </div>
             </div>
     	</form>
     	<?php } else {?>
     	<input type="hidden" id="facility_id"  <?php if(isset($facility_id)) echo "value={$facility_id}"; ?> >
     	<?php }?>
		<?php if (isset($error_info)) {
			echo $error_info;
		} else {
			?>
		<input type="hidden" id="asn_id"  <?php if(isset($asn_id)) echo "value={$asn_id}"; ?> >
			<div class="tab-content">
				<div class="row col-sm-10 col-sm-offset-0" style="margin-top: 10px;">
					<div>日期：<?php echo $asn_date?><?php if(!empty($facility_name)) echo $facility_name ?>  </div>
					<?php if(isset($from_facility_name) && isset($to_facility_name)) {?>
					<div>出库仓库：<?php echo $from_facility_name?>，入库仓库：<?php echo $to_facility_name?>。创建装车单后，<?php echo $from_facility_name?>会减少相应库存</div>
					<?php }?>
					<div class='row' style="text-align: center;"><h1>装车单</h1></div>
					<div class="row" style="text-align: right;"><span class="required">*</span>如果该装车单没有某商品，可不输入</div>
					<table id="bol_item" class="table table-striped table-bordered "  style="width:100%" >
						<tr>
			            	<th>PRODUCT_ID</th>
			                <th width="30%">商品</th>
			                <th width="8%">承诺箱数</th>
			                <th width="8%">今日已发</th>
			                <th width="8%">已到箱数</th>
			                <th width="8%">装车箱数</th>
							<th width="10%">箱规</th>
							<th width="10%">单位</th>
						</tr>
						<?php if( isset($asn_item_list) && is_array($asn_item_list))  foreach ($asn_item_list as $key => $asn_item) { ?> 
						<?php if($asn_item['product_unit_code'] == 'kg') {?>
			            <tr class="content">
			                <td><input type="text" readonly="readonly" id="product_id[]" name="product_id[]" value="<?php echo !empty($asn_item['product_id'])?$asn_item['product_id']:'' ?>" ></td>
			                <td><?php if(!empty($asn_item['product_name'])) echo $asn_item['product_name'] ?></td>
			                <td><?php echo !empty($asn_item['commitment_case_num'])?$asn_item['commitment_case_num']:0 ?></td>
			                <td><?php echo !empty($asn_item['setoff_case_num'])?$asn_item['setoff_case_num']:0 ?></td>
			                <td><?php echo !empty($asn_item['arrival_case_num'])?$asn_item['arrival_case_num']:0 ?></td>
			                <td style='padding: 0px'><input type="tel" style="width:80px;" id="purchase_case_num[]" name="purchase_case_num[]" ></td>
			                <td><?php echo !empty($asn_item['quantity'])?$asn_item['quantity']*2:0 ?></td>
			                <td>斤</td>
			                <td hidden="true"><input type="hidden" id="container_id[]" name="container_id[]" value="<?php echo !empty($asn_item['container_id'])?$asn_item['container_id']:'' ?>" ></td>
			                <td hidden="true"><input type="hidden" id="container_code[]" name="container_code[]" value="<?php echo !empty($asn_item['container_code'])?$asn_item['container_code']:'' ?>" ></td>
			                <td hidden="true"><input type="hidden" id="asn_item_id[]" name="asn_item_id[]" value="<?php echo !empty($asn_item['asn_item_id'])?$asn_item['asn_item_id']:'' ?>" ></td>
						</tr>
						<?php } else {?>
						<tr class="content">
			                <td><input type="text" readonly="readonly" id="product_id[]" name="product_id[]" value="<?php echo !empty($asn_item['product_id'])?$asn_item['product_id']:'' ?>" ></td>
			                <td><?php if(!empty($asn_item['product_name'])) echo $asn_item['product_name'] ?></td>
			                <td><?php echo !empty($asn_item['commitment_case_num'])?$asn_item['commitment_case_num']:0 ?></td>
			                <td><?php echo !empty($asn_item['setoff_case_num'])?$asn_item['setoff_case_num']:0 ?></td>
			                <td><?php echo !empty($asn_item['arrival_case_num'])?$asn_item['arrival_case_num']:0 ?></td>
			                <td style='padding: 0px'><input type="tel" style="width:80px;" id="purchase_case_num[]" name="purchase_case_num[]" ></td>
			                <td><?php echo !empty($asn_item['quantity'])?$asn_item['quantity']:0 ?></td>
			                <td><?php echo !empty($asn_item['product_unit_code'])?$asn_item['product_unit_code']:'' ?></td>
			                <td hidden="true"><input type="hidden" id="container_id[]" name="container_id[]" value="<?php echo !empty($asn_item['container_id'])?$asn_item['container_id']:'' ?>" ></td>
			                <td hidden="true"><input type="hidden" id="container_code[]" name="container_code[]" value="<?php echo !empty($asn_item['container_code'])?$asn_item['container_code']:'' ?>" ></td>
			                <td hidden="true"><input type="hidden" id="asn_item_id[]" name="asn_item_id[]" value="<?php echo !empty($asn_item['asn_item_id'])?$asn_item['asn_item_id']:'' ?>" ></td>
						</tr>
						<?php }?>
	      				<?php }?>
      				</table>
      				<table>
						<tr>
							<td style="width: 30%;text-align: right"><span class="required">*</span> 车牌号：<input style="width: 50%;height:35px" type="text" id="car_num" required="true" name="car_num"  value='<?php if(!empty($default_car_num)) echo $default_car_num; ?>'></td>
							<td style="width: 30%;text-align: right"><span class="required">*</span> 司机电话：<input style="width: 50%;height:35px" type="tel" id="driver_mobile" required="true" name="driver_mobile" value='<?php if(!empty($default_driver_mobile)) echo $default_driver_mobile; ?>'></td>
                            <td style="width: 30%;text-align: right"><span class="required">*</span> 车队：<input style="width: 50%;height:35px" type="text" id="car_provider" required="true" name="car_provider" value='<?php if(!empty($default_car_provider)) echo $default_car_provider; ?>'></td>
						</tr>
						<tr>
							<td style="width: 30%;text-align: right"><span class="required">*</span> 司机名字：<input style="width: 50%;height:35px" type="text" id="driver_name" required="true" name="driver_name" value='<?php if(!empty($default_driver_name)) echo $default_driver_name; ?>'></td>
							<td style="width: 30%; text-align: right"><span class="required">*</span>预估到货时间：<input style="width: 50%;height:35px" type="text" id="estimated_arrival_time" required="true" name="estimated_arrival_time"></td>
                            <td style="width: 30%; text-align: right"><span class="required">*</span>实际发车时间：<input style="width: 50%;height:35px" type="text" id="setoff_time" required="true" name="setoff_time"></td>
                        </tr>
						<tr>
                            <td style="width: 30%;text-align: right"><span class="required">*</span> 车型：<input style="width: 50%;height:35px" type="text" id="car_model" required="true" name="car_model" value='<?php if(!empty($default_car_model)) echo $default_car_model; ?>'></td>
							<td style="width: 30%;text-align: right"><span class="required">*</span> 车费：<input style="width: 50%;height:35px" type="number" id="deliver_price" required="true" name="deliver_price"  value='<?php if(isset($default_deliver_price)) echo $default_deliver_price; ?>'></td>
							<td style="width: 30%; text-align: right"><span class="required">*</span>装车费：<input style="width: 50%;height:35px" type="number" id="loading_price" required="true" name="loading_price" value='<?php if(isset($default_loading_price)) echo $default_loading_price; ?>' ></td>
						</tr>
                        <tr>
                            <td style="width: 30%; text-align: right"><span class="required">*</span>六联单编号：<input style="width: 50%;height:35px" type="text" id="invoice_no" required="true" name="invoice_no"></td>
							<td style="width: 30%; text-align: right"><span class="required"></span>备注：<input style="width: 50%;height:35px" type="text" id="note" required="true" name="note"></td>
						</tr>
					</table>
                    <div style="position: relative">
						<button class="btn btn-primary" id="add_loading_bill_btn" style="float: right" <?php if(isset($readonly) && $readonly == true ) echo " disabled=\"disabled\""?>>
            				<i class="fa fa-check"></i>提交
        				</button>
        			</div>
    			</div>
    		</div>
    			<?php
		}?>
    	</div>
    </div>
</div>

    <script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
	<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/mobiscroll.core-2.5.2.js"></script>
 	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/mobiscroll.core-2.5.2-zh.js"></script>
	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/mobiscroll.datetime-2.5.1.js"></script>
 	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/mobiscroll.datetime-2.5.1-zh.js"></script> 
	<script type="text/javascript">
	$(document).ready(function(){
		   $("#estimated_arrival_time").val('<?php echo date('Y-m-d H:i',time() + 3600) ?>');
           $("#setoff_time").val('<?php echo date('Y-m-d H:i', time() + 3600) ?>');
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
		     $("#estimated_arrival_time").mobiscroll(opt).datetime(opt);
             $("#setoff_time").mobiscroll(opt).datetime(opt);
		}) ; 

	$('#add_loading_bill_btn').click(function() {
		
		var facility_id = $('#facility_id').val();
		var asn_id = $('#asn_id').val();
		var car_num = $('#car_num').val();
		var driver_name = $('#driver_name').val();
		var driver_mobile = $('#driver_mobile').val();
		var estimated_arrival_time = $('#estimated_arrival_time').val();
        var setoff_time = $('#setoff_time').val();
        var car_provider = $('#car_provider').val();
        var car_model = $('#car_model').val();
		var deliver_price = $('#deliver_price').val();
		var loading_price = $('#loading_price').val();
        var invoice_no = $('#invoice_no').val();
		var note = $('#note').val();
		var bol_items = [];
		if(car_num == ''){
			alert('车牌号码不能为空');
			return ;
		}

		if(!(/^1[3|4|5|7|8]\d{9}$/.test(driver_mobile))){
			alert("手机号码格式不正确"); 
			return ;
		}

        if(driver_name == ''){
            alert('司机姓名不能为空');
            return ;
        }

        if(car_provider == ''){
            alert('车队信息不能为空');
            return ;
        }

        if(car_model == ''){
            alert('车型信息不能为空');
            return ;
        }

		if(estimated_arrival_time == ''){
			alert('到货预估时间不能为空');
			return ;
		}
        
        if(setoff_time == ''){
			alert('实际到货时间不能为空');
			return ;
		}

		if(deliver_price == ''){
			alert('车费不能为空');
			return ;
		}
		
		if(loading_price == ''){
			alert('装车费不能为空');
			return ;
		}

        if(invoice_no == ''){
            alert('六联单编号不能为空');
            return ;
        }
		
		var available = true;
		var tips = "";
        var errors = "";
	   	$('#bol_item tr.content').each(function(){
			product_id = $(this).find("td").eq(0).find("input").val();
            commitment_case_num= $(this).find("td").eq(2).html();
            setoff_case_num = $(this).find("td").eq(3).html();
            arrival_case_num = $(this).find("td").eq(4).html();
			purchase_case_num = $(this).find("td").eq(5).find("input").val();
			container_quantity = $(this).find("td").eq(6).html();
			product_unit_code = $(this).find("td").eq(7).html();
			container_id = $(this).find("td").eq(8).find("input").val();
			container_code = $(this).find("td").eq(9).find("input").val();
			asn_item_id = $(this).find("td").eq(10).find("input").val();
			product_name = $(this).find("td").eq(1).html();

			//如果是0或者空，自动过滤
			if(purchase_case_num == 0 || purchase_case_num == "") {
				return true;
			}
		 	if ((Number(purchase_case_num) + Number(setoff_case_num)) > Number(commitment_case_num)) {
                tips += "商品：" + product_name + "  箱规:" + container_quantity + "  （装车数量+今日已发）大于承诺数量！！！"  + "\n";
                errors += "商品：" + product_name + "  箱规:" + container_quantity + "  （装车数量+今日已发）大于承诺数量"  + "\n";
                return;
            }
            if ((Number(purchase_case_num) + Number(arrival_case_num)) > Number(commitment_case_num)) {
                errors += "商品：" + product_name + "  箱规:" + container_quantity + "  （装车数量+已到箱数）无法大于承诺数量"  + "\n";
                return; 
            }

			if(product_unit_code == '斤'){
				product_unit_code = 'kg';
				container_quantity = container_quantity / 2;
			}
		   	
		   	var bol_item = {
				   	"product_id":product_id,
				   	"purchase_case_num":purchase_case_num,
				   	"container_quantity":container_quantity,
				   	"product_unit_code":product_unit_code,
				   	"container_id":container_id,
				   	"container_code":container_code,
				   	"asn_item_id":asn_item_id,
				   	"product_name":product_name
				};
		   	tips = tips + "商品：" + product_name + "  采购数量:" + purchase_case_num + "  箱规:" + container_quantity + "\n";
		   	bol_items.push(bol_item);
		});
        
        if(errors !== '') {
            alert(errors);
            return;
        }

		if(available == false ) {
			return ;
		}
	   	if( bol_items.length ==0){
	   		alert("没有添加商品");
	   		return ;
	   	}
		tips = tips + "是否确认?";
		var cf=confirm( tips )
		if (cf==false)
			return ;
		
		var submit_data = {
					"facility_id":facility_id,
					"asn_id":asn_id,
					"car_num":car_num,
					"driver_name":driver_name,
					"driver_mobile":driver_mobile,
					"estimated_arrival_time":estimated_arrival_time,
                    "setoff_time": setoff_time,
                    "car_provider":car_provider,
                    "car_model":car_model,
					"loading_price":loading_price,
					"deliver_price":deliver_price,
                    "invoice_no":invoice_no,
					"note":note,
					"bol_items":bol_items
				};
		var postUrl = $('#WEB_ROOT').val() + 'loadingBill/addLoadingBill';
	    $.ajax({
            url: postUrl,
            type: 'POST',
            data:submit_data, 
            dataType: "json", 
            xhrFields: {
              withCredentials: true
            }
	  }).done(function(data){
	      if(data.success == "success"){
		      alert("提交成功");
			  <?php if(!empty($asn_type) && $asn_type == 'TI') {?>
		      history.back();
		      <?php } else {?>
		      location.reload();
		      <?php }?>
	      }else{
	    	  $('#add_loading_bill_btn').removeAttr('disabled');
	          alert(data.error_info);
	        }
	    }).fail(function(data){
	    	$('#add_loading_bill_btn').removeAttr('disabled');
	        alert(data);
	    });
	    $('#add_loading_bill_btn').attr('disabled',"true");
	});

$('#facility_id').change(function(){
    var facility_type = $(this).find('option:selected').data('facility_type'),
        area_type = $(this).find('option:selected').data('area_type');
    if( (facility_type==3 || facility_type==4 || facility_type==5) && area_type=='national' ){
        $('.asn_wrap').html('');
        $('.asn_label').show()
        var facility_id = $(this).val(),
            po_date = '<?php if(isset($po_date)) echo $po_date; ?>';

        var data = {
            "facility_id" : facility_id,
            "facility_type" : facility_type,
            "area_type" : area_type,
            "po_date" : po_date
        };
        getAsnList(data).done(function(data){
            if( data.success === 'success' ){
                var str = '<label class="col-sm-2 control-label asn_label"><h4>大区</h4></label><select name="asn_id" id="asn_id" class="form-control">';
                $.each(data.asn_list,function(){
                    str += '<option value="'+this.asn_id+'">'+this.area_name+'</option>';
                });
                str += '</select>';
                $('.asn_wrap').html(str);
            }else{
                alert(data.error_info);
            }
        });
    }else{
        $('.asn_wrap').html('');
        $('.asn_label').hide();
    }
});

function getAsnList(data){
    return $.ajax({
        url : '<?php echo $WEB_ROOT; ?>loadingBill/getAsnList',
        type : 'GET',
        data : data,
        dataType : 'json'
    }).fail(function(xhr){
        alert(xhr.responseText);
    });
}
</script>
</body>
</html>
