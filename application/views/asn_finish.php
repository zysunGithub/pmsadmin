<!doctype html>
<html>
<head>
    <title>拼好货WMS</title>
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
	<link rel="stylesheet" type="text/css" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/lhgcalendar.css"/>
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
        
        .cyan {
        	background: cyan;
        }
        .green {
        	background: rgb(56, 231, 151);
        }
        .red {
        	background: red;
        }
    </style>
</head>
<body>
<div class="container-fluid" style="margin-left: -18px;padding-left: 19px;" >
	<div role="tabpanel" class="row tab-product-list tabpanel" >
		<div class="col-md-12">
		<input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> >
		<input type="hidden" id="asn_id"  <?php if(isset($asn_id)) echo "value={$asn_id}"; ?> >
			<div class="tab-content">
				<div class="row col-sm-10 col-sm-offset-0" style="margin-top: 10px;">
					<form style="width:100%;" method="post" action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>asnFinish<?php if( !empty( $product_type ) && $product_type == "supplies" ) echo '/suppliesIndex'; ?>">
					<div class="row">
					<label for="facility_id" style="width: 150px">仓库：</label>
					<select style="width:12%; height: 30px" id="facility_id" name="facility_id" >
                                <?php foreach ( $facility_list as $facility ) {
									if (isset( $facility_id ) && $facility ['facility_id'] == $facility_id) {
										echo "<option value=\"{$facility['facility_id']}\" selected='true'>{$facility['facility_name']}</option>";
									} else {
										echo "<option value=\"{$facility['facility_id']}\">{$facility['facility_name']}</option>";
									}
								} ?>
                    </select>
                    <label>日期</label><input type="text" id="asn_date" name="asn_date" value="<?php echo $asn_date?>"  style="width:12%; height: 30px">
                    <input type="button" class="btn btn-primary btn-sm" id="query"  value="搜索">
                    <input type="button" class="btn btn-primary btn-sm" id="print_btn" value="打印 ">
					</div>
					<div id="myPrintArea">
					<table id="bol_item" class="table table-striped table-bordered "  style="width:100%" >
						<tr>
							<th width="10%">ASN ITEM ID</th>
			            	<th width="5%">PRODUCT_ID</th>
			                <th width="10%">商品</th>
			                <th width="5%">承诺箱数</th>
			                <th width="5%">发货箱数</th>
			                <th width="5%">到货箱数</th>
							<th width="7%">箱规</th>
							<th width="4%">单位</th>
						</tr>
						<?php if( isset($asn_item_list) && is_array($asn_item_list))  foreach ($asn_item_list as $key => $asn_item) { ?> 
			            <tr class="content">
			            	<td><?php echo $asn_item['asn_item_id']?></td>
			                <td><?php echo !empty($asn_item['product_id'])?$asn_item['product_id']:'' ?></td>
			                <td><?php echo !empty($asn_item['product_name'])?$asn_item['product_name']:'' ?></td>
			                <td><?php echo !empty($asn_item['commitment_case_num'])?$asn_item['commitment_case_num']:0 ?></td>
			                <td><?php echo isset($asn_item['setoff_case_num'])?$asn_item['setoff_case_num']:0 ?></td>
			                <td><?php echo !empty($asn_item['arrival_case_num'])?$asn_item['arrival_case_num']:0 ?></td>
			                <td><?php echo !empty($asn_item['quantity'])?$asn_item['quantity']:0 ?></td>
			                <td><?php echo !empty($asn_item['product_unit_code'])?$asn_item['product_unit_code']:'' ?></td>
			                <td hidden="true"><input type="hidden" id="container_id[]" name="container_id[]" value="<?php echo !empty($asn_item['container_id'])?$asn_item['container_id']:'' ?>" ></td>
			                <td hidden="true"><input type="hidden" id="container_code[]" name="container_code[]" value="<?php echo !empty($asn_item['container_code'])?$asn_item['container_code']:'' ?>" ></td>
			                <td hidden="true"><input type="hidden" id="asn_item_id[]" name="asn_item_id[]" value="<?php echo !empty($asn_item['asn_item_id'])?$asn_item['asn_item_id']:'' ?>" ></td>
						</tr>
	      				<?php }?>
      				</table>
      				</div>
    				</form>
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

	    $("#asn_date").calendar({btnBar:true,
	                   minDate:'2010-05-01', 
	                   maxDate:'2022-05-01'});

	    checkQuantity();
	}) ;

	function checkQuantity(){
		$('#bol_item tr.content').each(function(){
			if($(this).find("td").eq(4).html() == 0){
				$(this).find("td").eq(4).addClass('red');
				return true;
			}
		   	if($(this).find("td").eq(4).html() != $(this).find("td").eq(5).html() ){
		   		$(this).find("td").eq(4).addClass('cyan');
		   		$(this).find("td").eq(5).addClass('cyan');
				return true;
			}
			if(parseInt($(this).find("td").eq(3).html()) != $(this).find("td").eq(4).html()){
				$(this).find("td").eq(3).addClass('green');
				$(this).find("td").eq(4).addClass('green');
				return true;
			}
		});
	}
	
	$("#print_btn").click(function(){  
		  window.print();
		}); 
	$("#query").click(function(){
        $("form").submit();
    }); 
</script>
</body>
</html>