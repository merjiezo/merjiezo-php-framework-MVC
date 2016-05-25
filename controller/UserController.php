<?php
class UserController extends MController {

	public function RouterLogin() {
		return $this->router('index');
	}

	public function RouterLoginHandle() {
		$user  = $_POST['user'];
		$pass  = $_POST['pass'];
		$users = new Users();
		if ($users) {
			header('Location: admin/index');
		}
		echo $users->handlelogin($user, $pass);
	}

}