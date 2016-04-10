// 从url中分离所有的参数，返回数组
function GetRequests() {
  var url = location.search, // 获取url中"?"符后的字串
      key = [],
      val = [],
      strs,
      _strs,
      params = {};
  if (url.indexOf("?") != -1) {   // 判断是否有参数
    var str = url.substr(1);      // 从第一个字符开始 因为第0个是?号 获取所有除问号的所有符串
    if (str.indexOf("&") != -1) {
      strs = str.split("&");
      for (var i = 0; i < strs.length; i++) {
        _strs = strs[i].split("=");
        key[i] = _strs[0];
        val[i] = _strs[1];
      }
    } else {
      strs = str.split("=");
      key[0] = strs[0];
      val[0] = strs[1];  
    }
    for(i = 0 ; i < key.length ; i++){
      params[key[i]] = val[i];            //转换成数组形式
    }
   // params = JSON.stringify(params); 
  return params;      
  }else {
    return false;
  }
}


function isNullOrEmpty(strVal) {
	if ( strVal == null ||  strVal == undefined || strVal == '') {
		return true;
	} else {
		return false;
	}
}

function autocom(obj, list, formatItem, formatMatch, formatResult){
    obj.autocomplete(list, {
        minChars: 0,
        width: 310,
        max: 100,
        matchContains: true,
        autoFill: false,
        formatItem: formatItem,
        formatMatch: formatMatch,
        formatResult: formatResult
    });
    return obj;
}

function autocoms(obj, list, format) {
	return autocom(obj, list, format, format, format)
}

function accSub(arg1, arg2) {//减法函数
    var r1, r2, m, n;
    try {
        r1 = arg1.toString().split(".")[1].length;
    }
    catch (e) {
        r1 = 0;
    }
    try {
        r2 = arg2.toString().split(".")[1].length;
    }
    catch (e) {
        r2 = 0;
    }
    m = Math.pow(10, Math.max(r1, r2)); //last modify by deeka //动态控制精度长度
    n = (r1 >= r2) ? r1 : r2;
    return ((arg1 * m - arg2 * m) / m).toFixed(n);
}

Number.prototype.sub = Number.prototype.sub || function (arg) {
    return accSub(arg, this);
};

//js本地图片预览，兼容ie[6-9]、火狐、Chrome17+、Opera11+、Maxthon3
function PreviewImage(fileObj, imgPreviewId, divPreviewId) {
    var allowExtention = ".jpg,.bmp,.gif,.png"; //允许上传文件的后缀名document.getElementById("hfAllowPicSuffix").value;
    var extention = fileObj.value.substring(fileObj.value.lastIndexOf(".") + 1).toLowerCase();
    var browserVersion = window.navigator.userAgent.toUpperCase();
    if (allowExtention.indexOf(extention) > -1) {
        if (fileObj.files) {//HTML5实现预览，兼容chrome、火狐7+等
            if (window.FileReader) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById(imgPreviewId).setAttribute("src", e.target.result);
                }
                reader.readAsDataURL(fileObj.files[0]);
            } else if (browserVersion.indexOf("SAFARI") > -1) {
                alert("不支持Safari6.0以下浏览器的图片预览!");
            }
        } else if (browserVersion.indexOf("MSIE") > -1) {
            if (browserVersion.indexOf("MSIE 6") > -1) {//ie6
                document.getElementById(imgPreviewId).setAttribute("src", fileObj.value);
            } else {//ie[7-9]
                fileObj.select();
            if (browserVersion.indexOf("MSIE 9") > -1)
                fileObj.blur(); //不加上document.selection.createRange().text在ie9会拒绝访问
                var newPreview = document.getElementById(divPreviewId + "New");
                if (newPreview == null) {
                    newPreview = document.createElement("div");
                    newPreview.setAttribute("id", divPreviewId + "New");
                }
                var a = document.selection.createRange().text;
                newPreview.style.height = 390 + "px";
                newPreview.style.border = "solid 1px #eeeeee";
                newPreview.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod='scale',src='" + document.selection.createRange().text + "')";
                var tempDivPreview = document.getElementById(divPreviewId);
                newPreview.style.display = "block";
                tempDivPreview.style.display = "none";
                
                }
            } else if (browserVersion.indexOf("FIREFOX") > -1) {//firefox
                var firefoxVersion = parseFloat(browserVersion.toLowerCase().match(/firefox\/([\d.]+)/)[1]);
                if (firefoxVersion < 7) {//firefox7以下版本
                    document.getElementById(imgPreviewId).setAttribute("src", fileObj.files[0].getAsDataURL());
                } else {//firefox7.0+ 
                    document.getElementById(imgPreviewId).setAttribute("src", window.URL.createObjectURL(fileObj.files[0]));
                }
            } else {
                document.getElementById(imgPreviewId).setAttribute("src", fileObj.value);
            }
            $("#" + divPreviewId ).removeAttr('hidden');
            imgDiv = $("#" + divPreviewId ).parents('.imgDiv').next('.imgDiv');
            if(imgDiv && imgDiv.length == 0) {
                imgDiv = $("#" + divPreviewId ).parents('.imgDiv').parent().next().find('.imgDiv').eq(0);
            }
//          imgDiv.removeAttr('hidden');
        } else {
            alert("仅支持" + allowExtention + "为后缀名的文件!");
            fileObj.value = ""; //清空选中文件
            if (browserVersion.indexOf("MSIE") > -1) {
                fileObj.select();
                document.selection.clear();
            }
//          fileObj.outerHTML = fileObj.outerHTML;
        }
}

(function($){//提示器基于jquery,一个页面只能有一个，用法参考merchant_edit.php
    $.extend({
        prompter : function(str){
            if( str === '' ){
                alert('您到底要什么提示词？');
                return;
            }
            (function (str){
                var $prompter = $('#prompter');
                if( $prompter.length == 1 ){
                    $prompter.html(str);
                }else{
                    var html = '<div id="prompter">'+str+'</div>';
                    $('body').append(html);
                }
            })(str);
            function show(){
                $('#prompter').addClass('prompter_show');
            }
            function hide(){
                $('#prompter').removeClass('prompter_show');
            }
            function remove(){
                $('#prompter').remove();
            }
            return {
                show : show,
                hide : hide,
                remove : remove
            };
        }
    });
})(jQuery);