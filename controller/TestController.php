<?php
class TestController extends MController {

	public function RouterDbtest() {
		$users = new Users();
		$sql   = 'SELECT * FROM users';
		print_r(Merj::db()->createCommand($sql)->queryOne());
	}

	public function RouterAdminmaxtest() {
		$shelvies = new Shelvies();
		$shelvies->insertShelvies([
				'letter' => 'A',
			]);
	}

	public function RouterTestUpdateTwoTableAtTheSameTime() {
		$shelvies = new Shelvies();
		$shelvies->updateStocks(2);
	}
}