<?php
/**
 *
 */

class Query extends Object {

	//this is only used in search sql
	protected $sql = [
		"select"  => "",
		"from"    => "",
		"where"   => "",
		"groupby" => "",
		"having"  => "",
		"between" => "",
		"orderby" => "",
		"join"    => "",
		"limit"   => "",

	];

	protected $where = '';

	public function select($select = '*') {
		if (!is_array($select)) {
			$this->sql['select'] = $select;
		} else {
			$this->sql['select'] = implode(',', $select);
		}
		return $this;
	}

	public function from($table) {
		if (!is_array($table)) {
			$this->sql['from'] = 'FROM '.$table;
		}
		return $this;
	}

	public function where($group) {
		$where = '';
		if (is_array($group)) {
			foreach ($group as $key => $value) {
				$where .= ' AND '.$key.'=\''.addslashes($value).'\'';
			}
			$where              = substr($where, 4);
			$where              = 'WHERE '.$where;
			$this->sql['where'] = $where;
			$this->where        = ' '.$where;

		}
		if (is_string($group)) {
			$this->sql['where'] = $group;
			$this->where        = $where;

		}
		return $this;
	}

	public function groupby() {

	}

	public function between() {

	}

	public function orderby($keyArr) {
		$orderby = 'ORDER BY ';
		if (is_array($keyArr)) {
			$orderby .= implode(', ', $keyArr);
		} elseif (is_string($keyArr)) {
			$orderby .= $keyArr;
		}
		$this->sql['orderby'] = $orderby;
		return $this;
	}

	public function join() {

	}

	public function limit($page, $count) {
		$limit = 'LIMIT ';
		$num   = $page*$count-$count;
		$limit .= $num.', '.$count;
		$this->sql['limit'] = $limit;
		return $this;
	}

	public function sum() {
		$this->sql['select'] = 'SUM('.$this->sql['select'].')';
		return $this;
	}

	public function num() {
		return $this;
	}

	public function min() {
		$this->sql['select'] = 'MIN('.$this->sql['select'].')';
		return $this;
	}

	public function max() {
		$this->sql['select'] = 'MAX('.$this->sql['select'].')';
		return $this;
	}

	public function count() {
		$this->sql['select'] = 'COUNT('.$this->sql['select'].')';
		return $this;
	}

	public function first() {
		$this->sql['select'] = 'FIRST('.$this->sql['select'].')';
		return $this;
	}

	public function last() {
		$this->sql['select'] = 'LAST('.$this->sql['select'].')';
		return $this;
	}

	public function search() {
		if ($this->sql['select'] && $this->sql['from']) {
			$this->haveVal();
			return 'SELECT '.implode(' ', $this->sql);
		}
		return false;
	}

	protected function haveVal() {
		$query = [];
		foreach ($this->sql as $key => $value) {
			if (!$value) {
				unset($this->sql[$key]);
			}
		}
	}

}