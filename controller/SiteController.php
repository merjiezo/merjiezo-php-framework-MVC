<?php
class SiteController extends MController {

	//rules is the function that cannot into this website page
	//Guest is can show method
	public function behaviors() {
		return [
			'rules' => [
				[
					'actions'        => ['act22'],
					'matchAuthority' => $this->getSession('status', 1),
				],
				[
					'actions'        => ['authority1'],
					'matchAuthority' => $this->getSession('status', 2),
				],
				[
					'actions'        => ['authority1', 'act22'],
					'matchAuthority' => $this->getSession('status', 0),
				],
			],
		];
	}

	public function RouterIndex() {
		return $this->router('index');
	}

	public function RouterHandlelogin() {
		$user   = $_POST['user'];
		$pass   = $_POST['pass'];
		$log    = new modelTest();
		$result = $log->handlelogin($user, $pass);
		if ($result == 'success') {

			echo "<script>alert('success')</script>";
		} else {
			echo $result;
		}
	}

	public function RouterAuthority1() {
		echo "权限1";
	}

	public function RouterAct22() {
		echo "权限2";
	}

	public function RouterUpload() {
		$file   = new upload('upfile', 'files');
		$upFile = $file->uploadFile();
		if ($upFile) {
			print_r($upFile);
			echo "<script>alert('success')</script>";
			// return $this->router('index');
		} else {
			echo "<script>alert('failed')</script>";
		}
	}
}