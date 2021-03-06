<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>货物详细</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
		<link rel="stylesheet" href="../../public/css/main.css">
		<link rel="stylesheet" href="../../public/css/admin.css">
	</head>
	<body>
		<section class="admin_form" style="margin: 20px;">
			<div class="admin_showCargo_detail"><br>
				<p><label>货物ID:</label><?php echo $model['stock_id'];?></p>
				<p><label>货物状态:</label><?php echo $model['statusInfo'];?></p>
				<p><label>货物种类:</label><?php echo $model['sizeInfo'];?></p>
				<p><label>货架:</label><?php echo substr($model['bar_code'], 8);?></p>
			</div>
			<label for="">货物大小:</label><input type="text" class="admin_btn btn_ipt" id="size" placeholder="尺寸(1:大型 | 2:正常)" value="<?php echo $model['size'];?>"><br>
			<label for="">货物描述:</label><input type="text" class="admin_btn btn_ipt" id="describe" placeholder="货物" value="<?php echo $model['describe'];?>"><br>
			<label for="">货物重量:</label><input type="text" class="admin_btn btn_ipt" id="weight" placeholder="kg" value="<?php echo $model['weight'];?>"><br>
			<label for="">过期时间:</label><input type="text" class="admin_btn btn_ipt" id="time" placeholder="时间" value="<?php echo $model['time'];?>"><br>
			<label for="">一维码:</label><img src="../codedraw?text=<?php echo $model['bar_code'];?>" alt=""><br><br>
			<button class="admin_btn btn_green" id="IntoInfo" data-stock="<?php echo $model['stock_id'];?>">录入信息</button>
		</section>
	</body>
	<script src="../../public/js/jquery.min.js"></script>
	<script src="../../public/js/admin.js"></script>
	<script>
		var btn = {
			IntoInfo: document.getElementById('IntoInfo'),
		};
		IntoInfo.addEventListener('click', function(e) {
			var data = {
				stock: $('#IntoInfo').data('stock'),
				size: $('#size').val(),
				describe: $('#describe').val(),
				weight: $('#weight').val(),
				time: $('#time').val(),
			};
			ajaxVal.ajaxCall(ajaxVal.goodsInfoInsert, data);
		});
	</script>
</html>