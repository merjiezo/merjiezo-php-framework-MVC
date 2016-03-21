<?php
include ('lib/MController.php');
class SiteController extends MController {

	public function Index() {
		return $this->router('index');
	}
}