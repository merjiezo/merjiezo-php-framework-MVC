<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
		<link rel="stylesheet" href="../public/css/main.css">
		<link rel="stylesheet" href="../public/css/admin.css">
		<title>入库管理</title>
	</head>
	<body>
		<header class="admin_head">
			<ul>
				<li class="manager" style="text-align: center;">管理员</li>
				<li class="admin_left"><a href="user"><span class="glyphicon glyphicon-user"></span>用户管理</a></li>
				<li class="admin_left"><a href="goods"><span class="glyphicon glyphicon-list-alt"></span>货架管理</a></li>
				<li class="admin_left left_sel"><a href="instock"><span class="glyphicon glyphicon-log-in"></span>入库管理</a></li>
				<li class="admin_left"><a href="outstock"><span class="glyphicon glyphicon-log-out"></span>出库管理</a></li>
				<li class="admin_left"><a href="barcode"><span class="glyphicon glyphicon-barcode"></span>一维码管理</a></li>
				<li class="admin_left"><a href="../user/logout"><span class="glyphicon glyphicon-eject"></span>退出</a></li>
			</ul>
		</header>
		<section class="admin_contents">
			<h3>入库管理</h3>
			<section class="admin_form">
				<label for="">货物个数:</label><input type="text" class="admin_btn btn_ipt" name="num" placeholder="货物个数"><br>
				<label for="">货物大小:</label><input type="text" class="admin_btn btn_ipt" name="size" placeholder="尺寸(1:大型 | 2:正常)">
				<button class="admin_btn btn_red" id="">生成二维码</button>
				<button class="admin_btn btn_green" id="">录入信息</button>
			</section><br>
<?php echo "<table border=\"2\" cellpadding=\"0\" cellspacing=\"0\" class=\"admin_tb\" data-totle=\"".$model['pagination']."\">";?>
<tr>
					<th>货物ID</th>
					<th>货物状态</th>
					<th>货物类型</th>
					<th>货物描述</th>
					<th>重量(kg)</th>
					<th>过期时间</th>
					<th>编辑</th>
				</tr>
<?php foreach ($model as $key => $value) {
	if ($key !== 'pagination') {
		echo '<tr><td>'.$value['stock_id'].'</td><td>'.$value['status'].'</td><td>'.$value['size'].'</td><td>'.$value['describe'].'</td><td>'.$value['weight'].'</td><td>'.$value['time'].'</td>';
		echo '<td><a href="showgoods/'.$value['stock_id'].'" target="_blank"><span class="glyphicon glyphicon-pencil admin_func" data-func="authority"></span></a></td></tr>';
	}

}?>
			</table>
		<footer class="admin_foot">
		</footer>
	</body>
	<script src="../public/js/jquery.min.js"></script>
	<script>
		function test() {
			$('.admin_contents').append('<img src="../index.php?r=admin/codedraw&text=A0112345678">');
		}
	</script>
</html>