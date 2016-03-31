<?php
class AjaxuserController extends MController {

	public function userbirthday() {
		$modeltest = new modelTest();
		$res       = $modeltest->findUsername('1');
		if ($res) {
			echo $res;
		} else {
			echo "No found";
		}
	}

}