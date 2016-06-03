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
		$insert       = 'INSERT INTO ';
		$this->insert = $insert.$table;
		return $this;
	}

	public function value($arr) {
		$value       = $this->insertArrToString($arr);
		$this->value = ' '.$value;
		return $this;
	}

	public function servalValue(array $key, array $value = array()) {
		$str = '(`'.implode("`, `", $key).'`) VALUE ';
		$sql = "";
		foreach ($value as $key => $val) {
			$value[$key] = '(\''.implode('\', \'', $value[$key]).'\')';
		}
		$str .= implode(', ', $value);
		$this->value = ' '.$str;
		return $this;
	}

	public function update($table) {
		$this->update = 'UPDATE '.$table;
		return $this;

	}

	public function set($arr) {
		$this->set = 'SET '.$this->sqlArrToString($arr);
		return $this;
	}

	public function delete($table) {
		$delete       = 'DELETE FROM '.$table;
		$this->delete = $delete;
		return $this;
	}

	private function insertArrToString($arr) {
		foreach ($arr as $key => $value) {
			$keyArr[]   = '`'.$key.'`';
			$keyValue[] = '\''.addslashes($value).'\'';
		}
		$keys   = implode(',', $keyArr);
		$values = implode(',', $keyValue);
		return '('.$keys.') VALUE ('.$values.')';
	}

	private function sqlArrToString($group) {
		$str = '';
		if (is_array($group)) {
			foreach ($group as $key => $value) {
				$str .= ', '.$key.'=\''.addslashes($value).'\'';
			}
			$str = substr($str, 2);
			$str = $str;
		}
		if (is_string($group)) {
			$str = $group;
		}
		return $str;
	}

	public function sqlVal() {
		if ($this->insert && $this->value) {
			return $this->insert.' '.$this->value;
		} elseif ($this->update && $this->set) {
			$result = $this->where?$this->where:'';
			return $this->update.' '.$this->set.$this->where;
		} elseif ($this->delete) {
			return $this->delete.' '.$this->where;
		} else {
			return $this->search();
		}
	}

}