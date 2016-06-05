<?php
class Inquiry extends MModel {

	public $status = [
		1=> '等待选择货架',
		2=> '等待录入信息',
		3=> '等待上架',
		4=> '已经上架',
		5=> '等待出库',
		6=> '已经出库',
	];

	public $size = [
		1=> '大型货物',
		2=> '正常货物',
	];

	public function __construct() {
		$this->tableName = __CLASS__;
		$this->primKey   = 'stock_id';
	}

	public function LimitInfo($page, $limit) {
		$sql = 'SELECT COUNT(*) FROM inquiry';
		$num = $this->findBySql($sql);
		$num = (int) $num['COUNT(*)']/$limit;
		if ($num == 0) {
			$num = 1;
		}
		$num     = (int) $num;
		$query   = new QueryBuilder();
		$sql     = $query->select()->from('inquiry')->limit($page, $limit)->sqlVal();
		$results = $this->findBySql($sql);
		if ($results) {
			foreach ($results as $key => $value) {
				$results[$key]['status'] = $this->status[$value['status']];
				$results[$key]['size']   = $this->size[$value['size']];
			}
			$results['pagination'] = $num;
			return $results;
		}
		return false;
	}

	public function findOneRec($id) {
		$res = $this->findOneRecord($id);
		if ($res) {
			$res['statusInfo'] = $this->status[$res['status']];
			$res['sizeInfo']   = $this->size[$res['size']];
			return $res;
		}
		return false;
	}

	public function SelectGoodsWithStatus($status) {
		$sql = Merj::sql()->select(['stock_id'])->from('inquiry')->where([
				'status' => $status,
			])->sqlVal();
		$results = $this->findBySql($sql);
		$num     = count($results);
		return [$results, $num];
	}

	public function SelectAllRecStatus($status) {
		$sql = Merj::sql()->select()->from('inquiry')->where([
				'status' => $status,
			])->sqlVal();
		$results = $this->findBySql($sql);
		if ($results) {
			foreach ($results as $key => $value) {
				$results[$key]['size']   = $this->size[$value['size']];
				$results[$key]['status'] = $this->status[$value['status']];
			}
			$results = $this->jsonUtf8Out($results);
			$results = json_encode($results);
			return urldecode($results);
		}
		return false;
	}

	public function InsertGoods($arr) {
		return $this->insertNum(['size', 'status'], $arr);
	}

	public function InsertStock($arr) {
		$arr['time']   = date('Y-m-d');
		$arr['status'] = 1;
		if ($this->insertOne($arr)) {
			return true;
		}
		return false;
	}

	public function UpStockStatus($status, $id) {
		if ($this->updateOneRec([
					'status' => $status,
				], $id)) {
			return true;
		}
		return false;
	}

	public function GetOneInfo($stock_id) {
		$sql = 'SELECT inquiry.stock_id, inquiry.time, inquiry.weight, inquiry.describe, shelvies.letter, shelvies.num, shelvies.status  FROM inquiry JOIN shelvies WHERE inquiry.stock_id = \''.$stock_id.'\' AND inquiry.stock_id = shelvies.stock_id';
		$res = $this->findBySql($sql);
		if ($res) {
			$res = $this->jsonUtf8Out($res);
			$res = json_encode($res);
			return urldecode($res);
		}
	}

}