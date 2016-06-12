<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
				<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
		<title>Document</title>

	</head>
	<body>
		<input type="file" name="photo" id="photo"><br>
		<button id="cl">提交</button>
	</body>
	<script src="../public/js/jquery.min.js"></script>
	<script src="../public/js/admin.js"></script>
	<script>
		$('#cl').click(function(e) {
			var data = new FormData();
			data.append("photo", document.getElementById("photo"));
			$.ajax({
				url: 'filehandle',
				type: 'POST',
				dataType: 'json',
				data: data,
				processData: false,
				contentType: false,
			})
			.done(function(json) {
				alert(json);
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});

		});
	</script>
</html>