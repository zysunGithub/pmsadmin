<!doctype html>
<html>
<head>
<meta charset="UTF-8" />
<title>拼好货WMS</title>
<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
<style type="text/css">
body { padding: 10px 20px 0; }
form { padding-left: 10px; }
.res_table { border: 3px solid #3C60B4; width: 100%; margin-top: 5px; }
.res_table tr { border: 2px solid #3C60B4; }
.res_table th,.res_table td { text-align: center; border: 2px solid #bbb; line-height: 30px; }
</style>
</head>
<body>
	<form class="form-inline" method="GET">
		<div class="form-group">
			<label>商城
				<select name="merchant_id" class="form-control input-sm">
					<option value="">全部</option>
					<?php foreach ($merchant_list['list'] as $key => $val) {
						if(!empty($req['merchant_id']) && $req['merchant_id']==$val['merchant_id']){
							echo "<option value=\"{$val['merchant_id']}\" selected='selected'>{$val['merchant_name']}</option>";
						}else{
							echo "<option value=\"{$val['merchant_id']}\">{$val['merchant_name']}</option>";
						}
					} ?>
				</select>
			</label>
		</div>
		<div class="form-group">
			<label>商品：
				<input type="text" class="form-control input-sm" name="goods_name" value="<?php if(isset($req['goods_name'])) echo $req['goods_name']; ?>">
			</label>
		</div>
		<div class="form-group">
			<label>成品：
				<input type="text" class="form-control input-sm" name="product_name" value="<?php if(isset($req['product_name'])) echo $req['product_name']; ?>">
			</label>
		</div>
		<div class="form-group">
			<label>原料：
				<input type="text" class="form-control input-sm" name="component_name" value="<?php if(isset($req['component_name'])) echo $req['component_name']; ?>">
			</label>
		</div>
		<input type="submit" value="查询" class="btn btn-primary btn-sm query">
	</form>
	<table class="res_table">
		<thead>
			<tr>
				<th>平台(platform)</th>
				<th>商城(merchant)</th>
				<th style='border-right: 3px solid #3C60B4;' colspan="2">成品(product_ID_Name)</th>
                <th style='border-right: 3px solid #3C60B4;' colspan="2">oms商品(goods_ID_Name)</th>
				<th colspan="2">原料(component_ID_Name)</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			function commFn($a,$b){
				$res = $a * $b;
				while($a!=$b){
					if($a>$b){
						$a = $a-$b;
					}else{
						$b = $b-$a;
					}
				}
				return $res/$a;
			}
			if(isset($result)){
				foreach ($result as $key => $pro_list) {
					$goods_num = count($pro_list['goods']);
					$components_num = count($pro_list['components']);
					$comm = commFn($goods_num,$components_num);
					$goods_line = $comm/$goods_num;
					$components_line = $comm/$components_num;

					for($i = 0; $i < $comm; $i++){
						$str = '<tr>';
						$str.= $i%$comm ? "" : "<td rowspan='{$comm}'>{$pro_list['platform_name']}</td>";
						$str.= $i%$comm ? "" : "<td rowspan='{$comm}'>{$pro_list['merchant_name']}</td>";
						$str.= $i%$comm ? "" : "<td rowspan='{$comm}'>{$pro_list['product_id']}</td><td style='border-right: 3px solid #3C60B4;' rowspan='{$comm}'>{$pro_list['product_name']}</td>";
                        $str.= $i%$goods_line ? "" : "<td rowspan='{$goods_line}'>".$pro_list['goods'][$i/$goods_line]['goods_id']."</td><td style='border-right: 3px solid #3C60B4;' rowspan='{$goods_line}'>".$pro_list['goods'][$i/$goods_line]['goods_name']."</td>";
						$str.= $i%$components_line ? "" : "<td rowspan='{$components_line}'>".$pro_list['components'][$i/$components_line]['component_id']."</td><td rowspan='{$components_line}'>".$pro_list['components'][$i/$components_line]['component_name']."</td>";
						$str.='</tr>';

						echo $str;
					}
					
				}
			} ?>
			
		</tbody>
	</table>
	<nav style="float: right;">
    	<ul class="pagination">
    		<?php
        	if(isset($req['page_current'])){ ?>
        	<li>
            	<a href="javascript:;" id="page_current">
                	<span aria-hidden="true">第<?php echo $req['page_current']; ?>页</span>
            	</a>
       		</li>
       		<?php } ?>
    		<?php 
    		if(isset($req['page_current']) && $req['page_current']>1){ ?>
        	<li>
            	<a href="javascript:;"   id="page_prev">
           			<span aria-hidden="true">上一页</span>
        		</a>
        	</li>
        	<?php } ?>
        	<?php
        	if(isset($req['page_current']) && $req['page_current']<$page_total){ ?>
        	<li>
            	<a href="javascript:;" id="page_next">
                	<span aria-hidden="true">下一页</span>
            	</a>
       		</li>
       		<?php } ?>
         	<li>
	         	<a href='javascript:;'>
	         	<?php 
	         		if(isset($page_total)) echo "共{$page_total}页 &nbsp;"; 
	         	?>
	        	</a>
        	</li>
     	</ul>
  		</nav>
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script>
var WEB_ROOT = "<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>",
	req = <?php echo json_encode($req); ?>,
	reqArr = [],
	reqStr = '';
console.log(WEB_ROOT);
$.each(req,function(key,val){
	key!='page_current' && reqArr.push(key+'='+val);
});
reqStr = reqArr.join('&');
console.log(reqStr);
$('#page_prev').on('click',function(){	
	window.location.href = WEB_ROOT+'GoodsFinishedMaterial/?'+reqStr+'&page_current='+(+req.page_current-1);
});	
$('#page_next').on('click',function(){	
	console.log(reqStr);
	window.location.href = WEB_ROOT+'GoodsFinishedMaterial/?'+reqStr+'&page_current='+(+req.page_current+1);
});	
</script>
</body>
</html>