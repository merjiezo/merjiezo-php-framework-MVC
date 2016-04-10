<?php
class AjaxuserController extends MController {

	//connect mysql demo
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