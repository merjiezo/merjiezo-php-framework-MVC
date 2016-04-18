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
		$this->insert = $insert.addslashes($table);
		return $this;
	}

	public function value($arr) {
		$value       = $this->insertArrToString($arr);
		$this->value = ' '.$value;
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
			$keyValue[] = '\''.$value.'\'';
		}
		$keys   = implode(',', $keyArr);
		$values = implode(',', $keyValue);
		return '('.$keys.') VALUE ('.$values.')';
	}

	private function sqlArrToString($group) {
		$str = '';
		if (is_array($group)) {
			foreach ($group as $key => $value) {
				$str .= ', '.$key.'=\''.$value.'\'';
			}
			$str = substr($str, 2);
			$str = addslashes($str);
		}
		if (is_string($group)) {
			$str = addslashes($group);
		}
		return $str;
	}

	public function sqlVal() {
		if ($this->insert && $this->value) {
			return $this->insert.' '.$this->value;
		} elseif ($this->update && $this->set) {
			// $result = $this->where?' '.$this->where:'';
			echo $this->where;
			return $this->update.' '.$this->set.$this->where;
		} elseif ($this->delete) {
			return $this->delete.' '.$this->where;
		} else {
			return $this->search();
		}
		return false;
	}

}

//update 测试有问题，下次解决，现在要复习！！！！

$query = new QueryBuilder();
echo $query->update('qwe')->set([
		'qwe' => 'qwe',
		'rty' => 'rty',
	])->where([
		'qwe' => 'qwe',
		'rty' => 'rty',
	])->sqlVal();