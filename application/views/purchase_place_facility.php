<!doctype html>
<html>
<head>
	<title>拼好货WMS</title>
	<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/order.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
</head>
<body>
<div style="width: 1000px;margin: 0 auto;">
	<table	class="table table-striped table-bordered ">
		<tr>
			<td	colspan="3">
				<div style="width: 100px;margin:0;">
					<p style="font-weight: bold;padding-top: 4px;font-size: 20px;">采购地仓库对应关系</p>
				</div>
			</td>
		</tr>
		<tr>
			<td colspan="3" style="text-align: center;width: 35%">采购地</td>
			<td colspan="3" style="text-align: center;width: 35%">仓库</td>
			<td colspan="3" style="text-align: center;width: 30%">操作</td>
		</tr>
		<?php 
			if(isset($list)){
				foreach ($list as $row){ 
					echo "<tr>";
					echo "<td colspan='3'>".$row['purchase_place_name']."</td>";
					if(intval($row['enable']) === 0){
						echo "<td colspan='3'>未设置仓库</td>";
					}else {
//						echo "<td colspan='3'>".$row['facility_name']."</td>";
						echo "<td colspan='3'>";
						$facilities = array();
						foreach ($row['facilities'] as $facility) {
							 $facilities[] = "<i facility_id=\"$facility[facility_id]\">$facility[facility_name]</i>";
						}
						echo implode(', ', $facilities);
						echo "</td>";

					}
					echo "<td colspan='3'>";
					echo "<input type='button' id='addFacility' onclick='javascript:enablefacility(".$row['purchase_place_id'].",this)' class='btn btn-primary btn-sm' style='margin-left: 20px;' value='设置仓库'/>";
					echo "</td>";
					echo "</tr>";
				}
			}
		?>
	</table>
	<input type="hidden" id="purchase_place_id" name="purchase_place_id" type="hidden">
</div>
<!-- modal begin  -->
<div class="modal fade" id="add-facility-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">厂地仓库设置</h4>
      </div>
      
      <div class="modal-body">
        <div>
			<div class="row">
				<div class="col-md-offset-2">
				<button type="button" class="btn btn-primary" id="insert_facility">添加</button>
					</div>
			</div>
			<br>
				<div>
				<table id="facilities" class="table table-bordered table-striped">
				</table>



			</div>

			<div style="display: none" id="facilityOptions"></div>
<!--					</div>-->
<!--			</div>-->
        </div>
      </div>
      <div class="modal-footer">
       <button type="button" class="btn btn-primary" id="add_facility" data-dismiss="modal">确定</button>
      </div>
    </div>
  </div>
</div>
<!-- modal end  -->
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript">
var WEB_ROOT = "<?php if(isset($WEB_ROOT)) echo $WEB_ROOT; ?>";
var storageFacilities = [];
function isNullOrEmpty(strVal) {
	if (strVal == '' || strVal == null || strVal == undefined) {
		return true;
	} else {
		return false;
	}
}

$("#insert_facility").click(function(){
	$("#facilities").append("<tr><td><select  style=\"width: 80%;\" name=\"facility_id\" id=\"facilitySel\">"+$("#facilityOptions").html()+
	"</select></td><td></td></tr>");
});
$("#add_facility").click(function(){
	var purchase_place_id = $("#purchase_place_id").val();
    var facility_id = $("#facilitySel").val();
//	console.log("faci_id "+facility_id)
//	console.log(storageFacilities)

	for (var i = 0; i < storageFacilities.length; i++) {
		if (storageFacilities[i] == ""+facility_id) {
			alert("该仓库已添加");
			return false;
		}
	}


    if(facility_id != null){
        $("#add_facility").attr("disabled","disabled");
    	$.ajax({
	        url: WEB_ROOT+"purchasePlaceFacility/addPurchasePlaceFacility",
	        type: 'POST',
	        data : {"facility_id":facility_id,"purchase_place_id":purchase_place_id}, 
	        dataType: "json", 
	        xhrFields: {
	             withCredentials: true
	        }
	    }).done(function(data){
	    	  console.log(data);
	          if(data.success == "OK"){
	            alert("添加成功！");
	            window.location.reload();
	          }else{
	            alert(data.error_info);
	          }
	          $("#add_facility").removeAttr("disabled");
	    });
    }
});
function closefacility(purchasePlaceId, facilityId){
	if (!confirm('确认删除此仓？')) {
		return false;
	}
	$.ajax({
        url: WEB_ROOT+"purchasePlaceFacility/deletePurchasePlaceFacility",
        type: 'POST',
        data : {"purchase_place_id":purchasePlaceId, "facility_id":facilityId},
        dataType: "json", 
        xhrFields: {
             withCredentials: true
        }
    }).done(function(data){
    	  console.log(data);
          if(data.success == "OK"){
            window.location.reload();
          }else{
            alert(data.error_info);
          }
    });
}
function enablefacility(id, button){
	storageFacilities = [];
	var facilities = $(button).parent().prev().find('i');
	$("#facilities").html("");
	for (var i = 0; i < facilities.length; i++) {
		console.log(facilities[i].innerHTML);
		$("#facilities").append('<tr><td>'+facilities[i].innerHTML+
			'</td><td><input type="button" onclick="closefacility('+id+','+facilities[i].getAttribute("facility_id")+')" class="btn btn-danger del-purchase-place" value="删除"></td> </tr>');
		storageFacilities.push(facilities[i].getAttribute('facility_id'));

	}

	$.ajax({
        url: WEB_ROOT+"purchasePlaceFacility/getFacilityList",
        type: 'GET',
        dataType: "json", 
        xhrFields: {
             withCredentials: true
        }
    }).done(function(data){
    	console.log(data);
          if(data.success == "OK"){
          	  $("#purchase_place_id").val(id);
			  $("#add-facility-modal").modal('show');
			  var html = "";
			  for(var i=0;i < data.data.list.length;i++){
			  	  var facility_id = data.data.list[i].facility_id;
			  	  var facility_name = data.data.list[i].facility_name;
			  	  var tr = "<option value="+ facility_id +">"+ facility_name +"</option>";
			  	  html+=tr;
			  }
			  $("#facilityOptions").html(html);
          }else{
            alert(data.error_info);
          }
    });
}
</script>
</body>
</html>