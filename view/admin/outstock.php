<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
		<link rel="stylesheet" href="../public/css/main.css">
		<link rel="stylesheet" href="../public/css/admin.css">
		<title>出库管理</title>
	</head>
	<body>
		<header class="admin_head">
			<ul>
				<li class="manager" style="text-align: center;">管理员</li>
				<li class="admin_left"><a href="user"><span class="glyphicon glyphicon-user"></span>用户管理</a></li>
				<li class="admin_left"><a href="goods"><span class="glyphicon glyphicon-list-alt"></span>货架管理</a></li>
				<li class="admin_left"><a href="instock"><span class="glyphicon glyphicon-log-in"></span>入库管理</a></li>
				<li class="admin_left left_sel"><a href="outstock"><span class="glyphicon glyphicon-log-out"></span>出库管理</a></li>
				<li class="admin_left"><a href="barcode"><span class="glyphicon glyphicon-barcode"></span>一维码管理</a></li>
				<li class="admin_left"><a href="../user/logout"><span class="glyphicon glyphicon-eject"></span>退出</a></li>
			</ul>
		</header>
		<section class="admin_contents">
			<h3>出库管理</h3>
			<div class="admin_toolbar">
				<input class="admin_btn btn_ipt" type="text" id="search" placeholder="扫描时放置于此">
			</div>
			<div>
				<div class="admin_showCargo_detail"><br>
					<p><label>货物ID:</label></p>
					<p><label>货物描述:</label></p>
					<p><label>货物过期时间:</label></p>
					<p><label>货物重量:</label></p>
					<p><label>货架:</label></p>
					<p><label>二维码:</label></p>
				</div>
				<button class="admin_btn btn_red" id="outquiry">出库</button>
			</div>
		</section>
		<footer class="admin_foot">

		</footer>
	</body>
	<script src="../public/js/jquery.min.js"></script>
	<script src="../public/js/admin.js"></script>
	<script>
		var btn = {
			search: document.getElementById('search'),
			outquiry: document.getElementById('outquiry'),
		};
		btn.outquiry.addEventListener('click', function(e) {
			alert($('.admin_showCargo_detail').data('stock'));
		});
		btn.search.addEventListener('input', function(e) {
			if (e.target.value !== '') {
				var search = e.target.value,
					data = {
						cargo: search,
					};
				$('.admin_showCargo_detail').empty();
				ajaxVal.ajax(ajaxVal.showOneQuiry, function(data) {
					if (data.success) {
						var str = '<p><label>货物ID:</label>'+data.msg[0].stock_id+'</p>'+
								'<p><label>货物描述:</label>'+data.msg[0].describe+'</p>'+
								'<p><label>货物过期时间:</label>'+data.msg[0].time+'</p>'+
								'<p><label>货物重量:</label>'+data.msg[0].weight+'  kg</p>'+
								'<p><label>货架:</label>'+data.shelvies+'</p>'+
								'<p><label>二维码:</label><img src="codedraw?text='+data.barcode+'"></p>';
						$('.admin_showCargo_detail').data('stock', data.barcode);
						$('.admin_showCargo_detail').append(str);
					} else {
						alert(data.msg);
					}
				}, data);
				setTimeout(function() {
					e.target.value = '';
				}, 0);
			}
		});
	</script>
</html>