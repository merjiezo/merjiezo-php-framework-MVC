<?php
class Shelvies extends MModel {

	private $status = [
		1=> '(空)',
		2=> '(满)',
		3=> '(清理中)',
		4=> '(不能使用)',
	];

	private $showSt = [
		1=> 'cargle_free',
		2=> 'cargle_full',
		3=> 'cargle_clean',
		4=> 'cargle_useless',
	];

	private $size = [
		1=> 'big_cargle',
		2=> 'cargle',
		3=> 'sm_cargle',
	];

	public function __construct() {
		$this->tableName = __CLASS__;
		$this->primKey   = 'storshelve_id';
	}

	public function findAllSl() {
		$sql     = 'SELECT * FROM shelvies';
		$results = $this->findBySql($sql);
		return $this->orderRes($results);
	}

	public function findFree($num, $size) {
		$sql = Merj::sql()->select(['storshelve_id', 'letter', 'num'])->from('shelvies')->where([
				'status' => '1',
				'size'   => $size,
			])->limit(1, $num)->sqlVal();
		$results = $this->findBySql($sql);
		return $results;
	}

	public function insertShelvies($arr) {
		$sql         = 'SELECT MAX(num) FROM shelvies WHERE letter=\''.$arr['letter'].'\'';
		$arr['num']  = (int) $this->findBySql($sql)[0]['MAX(num)']+1;
		$arr['time'] = date('Y-m-d');
		if ($arr['letter'] == 'A') {
			$arr['size'] = 1;
		} else {
			$arr['size'] = 2;
		}
		if ($this->insertOne($arr)) {
			return true;
		}
		return false;
	}

	public function updateStocks($size) {
		$sql          = array();
		$inquiry      = new Inquiry();
		$res          = $inquiry->SelectGoodsWithStatus(1);
		$freeShelvies = $this->findFree($res[1], $size);
		for ($i = 0; $i < $res[1]; $i++) {
			$stock_id     = $res[0][$i]['stock_id'];
			$stockPostion = $freeShelvies[$i]['letter'].$freeShelvies[$i]['num'];
			$sql[]        = 'UPDATE shelvies SET stock_id = \''.$stock_id.'\', status = \'2\' WHERE storshelve_id = \''.$freeShelvies[$i]['storshelve_id'].'\'';
			$sql[]        = 'UPDATE inquiry SET bar_code = \''.$stock_id.$stockPostion.'\', status = \'2\' WHERE stock_id = \''.$stock_id.'\'';
		}
		if (Merj::db()->createCommand()->updateTrans($sql)) {
			return $res[0];
		}
		return false;
	}

	public function updateStockId($id, $StockId) {
		if ($this->updateOneRec([
					'stock_id' => $StockId,
				], $id)) {
			return true;
		}
	}

	public function updateStatus($id, $status) {
		if ($this->updateOneRec([
					'status' => $status,
				], $id)) {
			return $this->jsonGet(true, 'ID: '.$id);
		}
		return $this->jsonGet(false, '状态更新失败，失败ID: '.$id);
	}

	private function orderRes($results) {
		$msg = array();
		foreach ($results as $value) {
			$res['id']               = $value['storshelve_id'];
			$res['box_num']          = $value['box_num'];
			$res['cargle_num']       = $value['letter'].$value['num'].$this->status[$value['status']];
			$res['size']             = $this->size[$value['size']];
			$res['status']           = $this->showSt[$value['status']];
			$msg[$value['letter']][] = $res;
		}
		return $msg;
	}

}
