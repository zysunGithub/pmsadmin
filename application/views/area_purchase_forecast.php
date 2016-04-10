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
				<div class="row col-sm-12 col-sm-offset-0" style="margin-top: 10px;">
					<form style="width:100%;" method="post" action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>AreaPurchaseForecast">
					<div class="row">
					<label for="area_id">大区：</label>
					<select style="width:12%; height: 30px" id="area_id" name="area_id" >
	                   <?php foreach ( $area_list as $area ) {
						if (isset( $area ) && $area ['area_id'] == $area_id) {
							echo "<option value=\"{$area ['area_id']}\" selected='true'>{$area ['area_name']}</option>";
						} else {
							echo "<option value=\"{$area ['area_id']}\">{$area ['area_name']}</option>";
						}
					} ?>
                    </select>
					</div>
					<div id="myPrintArea">
					<div class='row' style="font-size: 10px;color: red"></div>
					<table id="pf_item_table" class="table table-striped table-bordered "  style="width:100%" >
						<tr>
							<th>商品</th>
							<th width="10%">箱规</th>
							<?php if(isset($available_facility_list) && is_array($available_facility_list)) foreach ($available_facility_list as $available_facility) {?>
			            	<th><?php echo $available_facility['facility_name']?></th>
			            	<th><?php echo $available_facility['facility_name']?>(箱数)</th>
			            	<?php }?>
			            	<th>总数(个数)</th>
			            	<th>总数(箱数)</th>
			            	<th>单位</th>
						</tr>
						<?php if( isset($item_list) && is_array($item_list))  foreach ($item_list as $key => $item) { ?> 
			            <tr class="content">
			            	<?php if(isset($item) && is_array($item)) foreach ($item as $key2=>$item2) {?> 
			            	<?php if($key2 == 'default_container_quantity') {?>
			            	<td><input class="<?php echo $key2?>" type="number" value="<?php echo $item2?>"></td>
			            	<?php } else {?>
			            	<?php if(strpos($key2,'inventory' ) >= 1){$addClass = 'inventory';} elseif(strpos($key2,'case_num' ) >= 1){$addClass = 'case_num';} else{$addClass = '';}?>
			            	<td class="<?php echo $key2.' '.$addClass?> "><?php echo $item2?></td>
			            	
			            	<?php }?>
			            	<?php }?>
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
	<script type="text/javascript">
	$('.default_container_quantity').on('input',function(e){
		if($(this).val() == ''){
			return;
		}
		if(isNaN($(this).val())){
			return;
		}
		changeCaseNum($(this).parent().parent(),$(this).val());
	});

	function changeCaseNum(tr,val){
		tr.find('td.case_num').each(function(){
			inventory = $(this).prev().html();
			case_num = inventory / val;
			$(this).html(Math.ceil(case_num));
		});
	}

	$('#area_id').change(function(){
		$('form').submit();
	});
	</script>
</body>
</html>