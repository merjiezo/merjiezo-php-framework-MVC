<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="../public/css/main.css">
		<link rel="stylesheet" href="../public/css/login.css">
		<title>登陆</title>
		<style>
			html,body {
				width: 100%;
				height:100%;
				background-image: url(../public/images/sues.png);
				background-size: percentage;
				background-position: 50% 50%;
				background-size: cover;
				background-repeat: no-repeat;
				overflow: hidden;
			}
		</style>
	</head>
	<body onload="loginGetIn()">
		<section class="loginhandle" id="Login">
			<form action="../user/loginhandle" method="POST">
				<h3 class="login_h3" id="log_h">Sues 仓储管理系统</h3><br>
				<input class="ipt" id="log_ipt1" type="text" placeholder="用户名" name="user"><br><br>
				<input class="ipt" id="log_ipt2" type="password" placeholder="密码" name="pass"><br><br>
				<input class="ipt ipt_btn" id="log_ipt3" type="submit" style="width: 300px;">
			</form>
		</section>
		<p class="ipt_p">©2016-2018 Merjiezo软件开发中心, All Rights Reserved.　　本站发布的所有内容，未经许可，不得转载，详见《知识产权声明》。</p>
		<script>
			function loginGetIn() {
				document.getElementById("Login").style.left = '50%';
				document.getElementById("log_ipt1").style.left = '50%';
				document.getElementById("log_ipt2").style.left = '50%';
				document.getElementById("log_ipt3").style.left = '50%';
			}
		</script>
	</body>
</html>