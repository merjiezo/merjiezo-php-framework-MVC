<?php
require ('composer/loadArray.php');
/**
 * 自动加载require
 */
class autoLoad {

	public function getLoad($Arrdir) {
		$allReq = [];
		foreach ($Arrdir as $value) {
			$handle = $this->openDIR($value);
			$list   = $this->readdir($value, $handle);
			foreach ($list as $value) {
				array_push($allReq, $value);
			}
		}
		if ($list) {
			return $allReq;
		} else {
			return false;
		}
	}

	private function openDIR($dir) {
		return opendir($dir);
	}

	private function readdir($dir, $handle) {
		while ($filename = readdir($handle)) {
			if (substr($filename, -4, 4) == '.php') {
				$list[] = $dir.'/'.$filename;
			}
		}
		return isset($list)?$list:"";
	}
}
$load   = new autoLoad();
$allReq = $load->getLoad($list);
foreach ($allReq as $requireDIR) {
	require ($requireDIR);
}
