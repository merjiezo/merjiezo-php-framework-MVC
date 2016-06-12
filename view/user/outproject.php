<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
		<link rel="stylesheet" href="../public/css/main.css">
		<link rel="stylesheet" href="../public/css/user.css">
		<title>出库</title>
	</head>
	<body>
		<a href="logout">退出</a><br><a href="../admin/goods">管理员界面</a>
		<section class="user_contents">
		</section>
	</body>
	<script src="../public/js/jquery.min.js"></script>
	<script src="../public/js/admin.js"></script>
	<script>
		$(document).ready(function() {
			getStockJson();
		});

		setInterval(function() {
			getStockJson();
		}, 10000);

		function getStockJson() {
			$.getJSON('../ajax/InquiryShowWithStatusFive', function(json, textStatus) {
				if (textStatus == 'success') {
					var str = '';
					$('.user_contents').empty();
					if (json.success) {
						for (prop in json.msg) {
							if (json.msg.hasOwnProperty(prop)) {
								str += '<div class="user_block"><div class="user_pic"><p>货架: '+json.msg[prop].shelvies+'<br>货物ID: '+json.msg[prop].stock_id+'</p></div><button onclick="Inquiry(event)" data-stock="'+json.msg[prop].stock_id+'">出库</button></div>';
							}
						}
					} else {
						str += '<p style="text-align: center;">'+json.msg+'</p>';
					}
					$('.user_contents').append(str);
				} else {
					alert('获取失败 '+textStatus);
				}
			});
		}
		//user
		function Inquiry(event) {
			var data = {
				stock: event.target.dataset.stock,
				status: '6',
			};
			ajaxVal.ajax(ajaxVal.UpdateQuiryAndShelvies, function(data) {
				if (data.success) {
					event.target.parentElement.style.transform = 'scale(0)';
					setTimeout(function() {
						event.target.parentElement.style.display = 'none';
					}, 500);
				} else {
					alert(data.msg);
				}
			}, data);
		}
	</script>
</html>