/**
 * 
 * 商品档案公共js
 */

function ajaxProductList(params, donecallback, failcallback) {
	var url_base = $('#WEB_ROOT').val();
	 var gp = $.ajax({
	       url: url_base+"product/getProductList",
	       type: 'GET',
	       data: params,
	       dataType: "json", 
	       xhrFields: {
	         withCredentials: true
	       }
	  }).done(donecallback);
	 if(typeof failcallback != 'undefined') {
		 gp.fail(failcallback);
	 }
}