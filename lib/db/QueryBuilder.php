<?php
/**
 * update / insert / delete sql
 */
class QueryBuilder extends Query {

	private $insert;

	private $value;

	private $update;

	private $set;

	private $delete;

	public function insert($table) {
		$insert = 'INSERT INTO ';
		$insert .= $table;
		$this->insert = addslashes($table);
		return $this;
	}

	public function value($arr) {
		$value       = $this->insertArrToString($arr);
		$this->value = ' '.$value;
		return $this;
	}

	public function update($table) {
		$update = 'UPDATE '.$table;
		return $this;

	}

	public function set($arr) {
		$set = ' SET '.$this->sqlArrToString($arr);
		return $this;
	}

	public function delete() {
		$delete       = 'DELETE';
		$this->delete = $delete;
		return $this;
	}

	private function insertArrToString($arr) {
		foreach ($arr as $key => $value) {
			$keyArr[]   = '`'.$key.'`';
			$keyValue[] = '\''.$value.'\'';
		}
		$keys   = implode(',', $keyArr);
		$values = implode(',', $keyValue);
		return '('.$key.') VALUE ('.$keyValue.')';
	}

	private function sqlArrToString($group) {
		$str = '';
		if (is_array($group)) {
			foreach ($group as $key => $value) {
				$str .= ', `'.$key.'`=\''.$value.'\'';
			}
			$str = substr($str, 2);
			$str = addslashes($str);
		}
		if (is_string($group)) {
			$str = addslashes($group);
		}
		return $str;
	}

	public function createCommend() {
		if ($this->select || $this->insert || $this->update || $this->delete) {
			return false;
		} else {

		}
	}

}