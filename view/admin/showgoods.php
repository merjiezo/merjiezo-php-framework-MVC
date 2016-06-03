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
		<section class="admin_form" style="margin: auto;">
			<label for="">货物个数:</label><input type="text" class="admin_btn btn_ipt" name="num" placeholder="货物个数"><br>
			<label for="">货物大小:</label><input type="text" class="admin_btn btn_ipt" name="size" placeholder="尺寸(1:大型 | 2:正常)"><br>
			<img src="../codedraw?text=<?php echo $model['bar_code'];?>" alt=""><br><br>
			<button class="admin_btn btn_green" id="">录入信息</button>
		</section>
<?php
print_r($model);
?>
	</body>
</html>