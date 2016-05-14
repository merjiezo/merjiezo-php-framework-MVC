<?php
class AjaxuserController extends MController {

	//connect mysql demo
	public function RouterUserbirthday() {
		$conn = new Connection();
		$res  = $conn->createCommand('SELECT username FROM modelTest WHERE id = \'1\'')->queryAll();
		;
		if ($res) {
			echo $res[0]['username'];
		} else {
			echo "No found";
		}
	}

}