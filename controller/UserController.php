<?php
class UserController extends MController {

	public $status = [
		'1' => '../user/project',
		'2' => '../admin/user',
	];

	//rules is the function that cannot into this website page
	//Guest is can show method
	public function behaviors() {
		return [
			'rules' => [
				[
					'actions'        => [],
					'matchAuthority' => $this->getSession('status', 1),
				],
				[
					'actions'        => [],
					'matchAuthority' => $this->getSession('status', 2),
				],
				[
					'actions'        => ['RouterProject'],
					'matchAuthority' => $this->getSession('status', 0),
				],
			],
		];
	}

	public function RouterLogin() {
		if ($this->getSession('status', 0)) {
			return $this->router('index');
		} else {
			echo "<script>alert('您已登陆');window.history.go(-1);</script>";
		}

	}

	public function RouterLoginHandle() {
		$user  = $_POST['user'];
		$pass  = sha1($_POST['pass']);
		$users = new Users();
		$res   = $users->handlelogin($user, $pass);
		if ($res == 'success') {
			header('Location: '.$this->status[Merj::session('status')]);
		} else {
			echo "<script>alert('".$res."');window.history.go(-1);</script>";
		}
	}

	public function RouterLogout() {
		$session = new Session();
		$session->open();
		$session->destory();
		header('Location: login');
	}

	public function RouterProject() {
		return $this->router('Instock');
	}

	public function RouterOutProject() {
		return $this->router('outproject');
	}

	public function RouterFile() {
		return $this->router('fileup');
	}

	public function RouterFilehandle() {
		var_dump($_FILE);
		$uploadfile = new Upload('photo');
		if ($uploadfile->uploadFile()) {
			echo '{"success":true}';
		} else {
			echo '{"success": false}';
		}
	}

}