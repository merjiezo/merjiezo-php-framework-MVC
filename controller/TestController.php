<?php
class TestController extends MController {

	public function RouterDbtest() {
		$users = new Users();
		$sql   = 'SELECT * FROM users';
		print_r(Merj::db()->createCommand($sql)->queryOne());
	}
}