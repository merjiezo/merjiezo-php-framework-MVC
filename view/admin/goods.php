<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
		<link rel="stylesheet" href="../public/css/main.css">
		<link rel="stylesheet" href="../public/css/admin.css">
		<title>货架管理</title>
	</head>
	<body>
		<header class="admin_head">
			<ul>
				<li class="manager" style="text-align: center;">管理员</li>
				<li class="admin_left"><a href="user"><span class="glyphicon glyphicon-user"></span>用户管理</a></li>
				<li class="admin_left left_sel"><a href="goods"><span class="glyphicon glyphicon-list-alt"></span>货架管理</a></li>
				<li class="admin_left"><a href="instock"><span class="glyphicon glyphicon-log-in"></span>入库管理</a></li>
				<li class="admin_left"><a href="outstock"><span class="glyphicon glyphicon-log-out"></span>出库管理</a></li>
				<li class="admin_left"><a href="barcode"><span class="glyphicon glyphicon-barcode"></span>一维码管理</a></li>
				<li class="admin_left"><a href="../user/Project"><span class="glyphicon glyphicon-shopping-cart"></span>待上架货物</a></li>
				<li class="admin_left"><a href="../user/outproject"><span class="glyphicon glyphicon-road"></span>待出库货物</a></li>
				<li class="admin_left"><a href="../user/logout"><span class="glyphicon glyphicon-eject"></span>退出</a></li>
			</ul>
		</header>
		<section class="admin_contents">
			<h3>货架管理</h3>
			<div class="admin_toolbar">
				<input class="admin_btn btn_ipt" type="text" id="search" placeholder="搜索">
				<button class="admin_btn btn_green" id="searchUser">搜索架子</button>
				<button class="admin_btn btn_red" id="addSlave">添加架子</button>
			</div>
			<div class="cargle_con">
				<p style="font-size: 16px; margin: 10px 0;">空闲中(1):<span id="free"></span>已满(2):<span id="full"></span>清理中(3):<span id="clean"></span>不能使用(4):<span id="useless"></span></p>
<?php
$nowKey = 'A';
foreach ($model as $key => $value) {
	echo "<p>$key</p>";
	foreach ($value as $val) {
		echo "<section data-id=\"{$val['id']}\" data-box=\"{$val['box_num']}\" class=\"cargle_click {$val['size']}\"><span class=\"glyphicon glyphicon-th-large {$val['status']}\"></span><p class=\"big_cargle_word\">{$val['cargle_num']}</p></section>";
	}
}
?>
			</div>
		</section>
		<footer class="admin_foot">

		</footer>
		<section class="admin_cover" id="cover"></section>
		<section class="admin_motion">
			<h2 style="margin:33px 10% 20px 10%;">添加用户</h2>
			<p>字母:</p>
			<input class="admin_btn btn_ipt" type="text" id="addLetter" placeholder="字母">
			<p>状态:</p>
			<input class="admin_btn btn_ipt" type="text" id="addSt" placeholder="状态">
			<div class="motion_btngrop">
				<button class="admin_btn btn_red" id="addcancel">取消</button>
				<button class="admin_btn btn_green" id="addSl">确定</button>
			</div>
		</section>
	</body>
	<script src="../public/js/jquery.min.js"></script>
	<script>
		var btn = {
			addSlave: document.getElementById('addSlave'),
			addcancel: document.getElementById('addcancel'),
			addSl: document.getElementById('addSl'),
			cover: document.getElementById('cover'),
			hideMotion: function() {
				$('.admin_motion').removeClass('admin_motion_appear');
				$('.admin_cover').css('visibility', 'hidden');
				$('.authrity').remove();
			},
		};
		btn.addSlave.addEventListener('click', function() {
			$('.admin_motion').toggleClass('admin_motion_appear');
			$('.admin_cover').css('visibility', 'visible');
		});
		$('#useless').append($('.cargle_useless').length);
		$('#clean').append($('.cargle_clean').length);
		$('#free').append($('.cargle_free').length);
		$('#full').append($('.cargle_full').length);
		btn.addcancel.addEventListener('click', function() { btn.hideMotion() });
		btn.cover.addEventListener('click', function() { btn.hideMotion() });
		btn.addSl.addEventListener('click', function() {
			var letter = $('#addLetter').val(),
				status = $('#addSt').val(),
				data = {
					letter: letter,
					status: status,
				};
			if (letter !== '' && status !== '' && letter.length == 1 && status.length == 1) {
				ajaxVal.ajaxCall(ajaxVal.addShelve, data);
			} else {
				alert('不能为空或者超过长度，字母最大长度1位，状态最大长度1位');
			}
		});
	</script>
	<script src="../public/js/admin.js"></script>
</html>