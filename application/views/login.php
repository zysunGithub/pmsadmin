<!doctype html>
<html lang="zh-CN">
<head>
<title>拼好货WMS</title>
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="format-detection" content="telephone=no">
<link rel="stylesheet" type="text/css" href="assets/css/normalize.css">
<link rel="stylesheet" type="text/css" href="assets/css/global.css">
</head>
<body id="body-login">

  <div class="loginMain">
    <h1>
      <img src="assets/img/logo.png" alt="拼好货WMS" />
    </h1>
    
    <form method="post" action="./login" name='theForm' id='theForm'>
        <p class="error-tips"><?php echo $info; ?> </p>
        <div class="input-wrap">
          <img src="assets/img/admin.png" class="icon-input" />
          <input type="text" name="username" id='username' placeholder="Username"/>
        </div>
        <div class="input-wrap">
          <img src="assets/img/password.png" class="icon-input" />
          <input type="password" name="password" id="password" placeholder="Password"/>
        </div>
	   <input type="hidden" name="return_url" value="<?php echo $_SERVER['QUERY_STRING'];?>"/>
       <input type="submit" value="" class="signInBtn" />  
      <!--  <a href="./facade" class="signInBtn"></a>  -->
        <input type="hidden" name="act" value="signin" />
        
    </form>
  </div>
</body>
</html>
