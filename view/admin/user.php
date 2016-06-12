<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
		<link rel="stylesheet" href="../public/css/main.css">
		<link rel="stylesheet" href="../public/css/admin.css">
		<title>用户管理</title>
	</head>
	<body>
		<header class="admin_head">
			<ul>
				<li class="manager">管理员</li>
				<li class="admin_left left_sel"><a href="user"><span class="glyphicon glyphicon-user"></span>用户管理</a></li>
				<li class="admin_left"><a href="goods"><span class="glyphicon glyphicon-list-alt"></span>货架管理</a></li>
				<li class="admin_left"><a href="instock"><span class="glyphicon glyphicon-log-in"></span>入库管理</a></li>
				<li class="admin_left"><a href="outstock"><span class="glyphicon glyphicon-log-out"></span>出库管理</a></li>
				<li class="admin_left"><a href="barcode"><span class="glyphicon glyphicon-barcode"></span>一维码管理</a></li>
				<li class="admin_left"><a href="../user/Project"><span class="glyphicon glyphicon-shopping-cart"></span>待上架货物</a></li>
				<li class="admin_left"><a href="../user/outproject"><span class="glyphicon glyphicon-road"></span>待出库货物</a></li>
				<li class="admin_left"><a href="../user/logout"><span class="glyphicon glyphicon-eject"></span>退出</a></li>
			</ul>
		</header>
		<section class="admin_contents">
			<h3>用户管理</h3>
			<div class="admin_toolbar">
				<input class="admin_btn btn_ipt" type="text" id="search" placeholder="搜索">
				<button class="admin_btn btn_green" id="searchUser">搜索用户</button>
				<button class="admin_btn btn_red" id="addUser">添加用户</button>
			</div>
<?php echo "<table border=\"2\" cellpadding=\"0\" cellspacing=\"0\" class=\"admin_tb\" data-totle=\"".$model['pagination']."\">";?>
<tr>
					<th>用户ID</th>
					<th>用户姓名</th>
					<th>注册时间</th>
					<th>电话</th>
					<th>用户状态</th>
					<th>权限|重置|删除</th>
				</tr>
<?php foreach ($model as $key => $value) {
	if ($key !== 'pagination') {
		echo '<tr><td>'.$value['user_id'].'</td><td>'.$value['name'].'</td><td>'.$value['time'].'</td><td>'.$value['phone'].'</td><td>'.$value['status'].'</td>';
		echo '<td><span class="glyphicon glyphicon-cog admin_func" data-func="authority" data-id="'.$value['user_id'].'"></span>|<span class="glyphicon glyphicon-wrench admin_func" data-func="reset" data-id="'.$value['user_id'].'"></span>|<span class="glyphicon glyphicon-remove admin_func" data-func="delete" data-id="'.$value['user_id'].'"></span></td></tr>';
	}

}?>
			</table>
			<div id="page"></div>
		</section>
		<footer class="admin_foot">

		</footer>
		<section class="admin_cover" id="cover"></section>
		<section class="admin_motion">
			<h2 style="margin:33px 10% 20px 10%;">添加用户</h2>
			<p>用户名:</p>
			<input class="admin_btn btn_ipt" type="text" id="addUsername" placeholder="用户名">
			<p>联系方式:</p>
			<input class="admin_btn btn_ipt" type="text" id="addPhone" placeholder="联系方式">
			<div class="motion_btngrop">
				<button class="admin_btn btn_red" id="addcancel">取消</button>
				<button class="admin_btn btn_green" id="add">确定</button>
			</div>
		</section>
	</body>
	<script src="../public/js/jquery.min.js"></script>
	<script src="../public/js/admin.js"></script>
	<script>
		var nowPage = 1;
		ajaxVal.pagination('#page', 'URL', 1, $('.admin_contents>table').data('totle'));
		var btn = {
			searchUser: document.getElementById('searchUser'),
			addUser: document.getElementById('addUser'),
			addSlave: document.getElementById('addSlave'),
			addcancel: document.getElementById('addcancel'),
			add: document.getElementById('add'),
			cover: document.getElementById('cover'),
			hideMotion: function() {
				$('.admin_motion').removeClass('admin_motion_appear');
				$('.admin_cover').css('visibility', 'hidden');
				$('.authrity').remove();
			},
		};
		btn.addUser.addEventListener('click', function() {
			$('.admin_motion').toggleClass('admin_motion_appear');
			$('.admin_cover').css('visibility', 'visible');
		});
		btn.addcancel.addEventListener('click', function() { btn.hideMotion() });
		btn.cover.addEventListener('click', function() { btn.hideMotion() });
		btn.add.addEventListener('click', function() {
			var user = $('#addUsername').val(),
				phone = $('#addPhone').val(),
				data = {
					user: user,
					phone: phone,
				};
			if (user !== '' && phone !== '' && user.length <= 8 && phone.length <= 11) {
				ajaxVal.ajaxCall(ajaxVal.addUser, data);
			} else {
				alert('不能为空或者超过长度，用户名最大长度8位，电话最大长度11位');
			}
		});
	</script>
</html>