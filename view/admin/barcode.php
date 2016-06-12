<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
		<link rel="stylesheet" href="../public/css/main.css">
		<link rel="stylesheet" href="../public/css/admin.css">
		<title>一维码管理</title>
	</head>
	<body>
		<header class="admin_head">
			<ul>
				<li class="manager" style="text-align: center;">管理员</li>
				<li class="admin_left"><a href="user"><span class="glyphicon glyphicon-user"></span>用户管理</a></li>
				<li class="admin_left"><a href="goods"><span class="glyphicon glyphicon-list-alt"></span>货架管理</a></li>
				<li class="admin_left"><a href="instock"><span class="glyphicon glyphicon-log-in"></span>入库管理</a></li>
				<li class="admin_left"><a href="outstock"><span class="glyphicon glyphicon-log-out"></span>出库管理</a></li>
				<li class="admin_left left_sel"><a href="barcode"><span class="glyphicon glyphicon-barcode"></span>一维码管理</a></li>
				<li class="admin_left"><a href="../user/Project"><span class="glyphicon glyphicon-shopping-cart"></span>待上架货物</a></li>
				<li class="admin_left"><a href="../user/outproject"><span class="glyphicon glyphicon-road"></span>待出库货物</a></li>
				<li class="admin_left"><a href="../user/logout"><span class="glyphicon glyphicon-eject"></span>退出</a></li>
			</ul>
		</header>
		<section class="admin_contents">
			<h3>一维码管理</h3>
			<table border="2" cellpadding="0" cellspacing="0" class="admin_tb">
<?php
if (count($model) > 3) {
	for ($i = 0; $i < count($model);) {
		echo '<tr><td><img src="codedraw?text='.$model[$i]['bar_code'].'" alt=""></td><td><img src="codedraw?text='.isset($model[$i+1]['bar_code'])?$model[$i+1]['bar_code']:"".'" alt=""></td><td><img src="codedraw?text='.isset($model[$i+2]['bar_code'])?$model[$i+2]['bar_code']:"".'" alt=""></td></tr>';
		$i += 3;
	}
} else {
	echo "<tr>";
	foreach ($model as $value) {
		echo '<td><img src="codedraw?text='.$value['bar_code'].'" alt=""></td>';
	}
	echo "</tr>";
}
?>
			</table>
		</section>
		<footer class="admin_foot">

		</footer>
	</body>
	<script src="../public/js/jquery.min.js"></script>
</html>