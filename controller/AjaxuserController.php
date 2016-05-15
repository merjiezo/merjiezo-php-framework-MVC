<?php
class AjaxuserController extends MController {

	//connect mysql demo
	public function RouterUserbirthday() {
		$model   = new modelTest();
		$results = $model->findOneRecord('1');
		$res     = Merj::db()->createSlavesComm(0, 'SELECT * FROM content')->queryAll();
		print_r($res);
		if ($results) {
			print_r($results);
			// echo $results;
		} else {
			echo "No found";
		}
	}

	public function RouterInsert() {
		$arr['username'] = 'mike';
		$arr['password'] = '123456';
		$arr['status']   = '1';
		$model           = new modelTest();
		var_dump($model->insertOne($arr));
	}

	public function RouterUpdate() {
		$arr['username'] = 'alice';
		$model           = new modelTest();
		var_dump($model->updateOneRec($arr, 3));
	}

	public function RouterUpdateTrans() {
		// $arr['username'] = 'alice';
		$model = new modelTest();
		var_dump($model->changeName());
	}

	public function RouterDelete() {
		$arr['id'] = '2';
		$model     = new modelTest();
		var_dump($model->deleteOne($arr, '1'));
	}

}