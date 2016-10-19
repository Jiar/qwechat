<?php
	error_reporting ( 0 );
	header ( "Content-type: text/html; charset=utf-8" );
	$ip=$_SERVER["SERVER_NAME"];
	$ico="http://".$ip."/shakeperiphery/shake_webPL/images/bitbug_favicon.ico";
	$error_bg="http://".$ip."/shakeperiphery/shake_webPL/images/error_bg.jpg";
	$error_img="http://".$ip."/shakeperiphery/shake_webPL/images/error_img.png";
	$loginurl="http://".$ip."/shakeperiphery/shake_webPL/login.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><head>
<!-- base href="http://www.ztnet.com.cn:8080/CScreenHtml/" -->
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"> 
<link rel="shortcut icon" href="<?php echo $ico ?>"> 
<title>哎呀…Sorry</title>
<link rel="stylesheet" type="text/css">

<style>
*{margin:0;padding:0}
body{font-family:"微软雅黑";background:#DAD9D7}
img{border:none}
a *{cursor:pointer}
ul,li{list-style:none}
table{table-layout:fixed;}
table tr td{word-break:break-all; word-wrap:break-word;}

a{text-decoration:none;outline:none}
a:hover{text-decoration:underline}
.cf:after{content: ".";display: block;height: 0;font-size: 0;clear:both;visibility: hidden;}
.cf{zoom: 1;clear:both}

.bg{width:100%;background:url("<?php echo $error_bg ?>") no-repeat center top #DAD9D7;position:absolute;top:0;left:0;height:600px;overflow:hidden}
.cont{margin:0 auto;width:500px;line-height:20px;}
.c1{height:360px;text-align:center}
.c1 .img1{margin-top:180px}
.c1 .img2{margin-top:165px}
.cont h2{text-align:center;color:#555;font-size:18px;font-weight:normal;height:35px}

</style>

</head>
<body>
<div class="bg">
	<div class="cont">
		<div class="c1"><img src="<?php echo $error_img ?>" class="img1"></div>
		<h2>哎呀…出错了T.t！
			<br><br>
		
		
		
			不要调皮,请先登陆哦！
		
		
		
		
		
			
	
		<br><br><a href="<?php echo $loginurl ?>">点我返回登录页面^.^</a>
		</h2>
	</div>
</div>

</body></html>