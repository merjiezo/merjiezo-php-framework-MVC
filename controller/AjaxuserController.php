<?php
class AjaxuserController extends MController {

	public function RouterUserbirthday() {
		$modeltest = new modelTest();
		$res       = $modeltest->findUsername('1');
		if ($res) {
			echo $res;
		} else {
			echo "No found";
		}
	}

}