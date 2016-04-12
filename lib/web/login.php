<?php
/**
 * log in method
 */
class login extends MModel {

	private $user            = '';
	private $pass            = '';
	private $table           = '';
	private $userKeyName     = '';
	private $passwordKeyName = '';
	private $wrongTime       = 5;
	protected $error         = '';

	protected function getLoginData($user, $pass, $userKeyName, $passwordKeyName, $wrongTime = 5) {
		$this->user            = $user;
		$this->pass            = $pass;
		$this->userKeyName     = $userKeyName;
		$this->passwordKeyName = $passwordKeyName;
		$this->wrongTime       = (int) $wrongTime;
	}

	public function loginFact() {
		if (!$this->logSession()) {
			$this->error = 'Log Time Out! Place try it tomorrow!';
			return ['failed', $this->error];
		}
		if (($result = $this->checkExist()) && $this->checkEmpty()) {
			if ($this->checkPass($result[$this->passwordKeyName])) {
				$this->setlogSession($result);
				return true;
			} else {
				$this->addloginTime();
				return ['failed', $this->error];
			}
		} else {
			return ['failed', $this->error];
		}
	}

	private function checkEmpty() {
		if (!$this->user && !$this->pass) {
			$this->error = 'username or password is empty';
			return false;
		}
		return true;
	}

	private function checkExist() {
		$result = $this->findOneRecord($this->userKeyName, $this->user);
		if ($result) {
			return $result;
		}
		$this->error = 'not Exist!';
		return false;
	}

	private function addloginTime() {
		$session = new Session();
		$session->open();
		if (isset($_SESSION['loginTime'])) {
			$_SESSION['loginTime'] += 1;
		} else {
			session_cache_expire(60*24);
			$session->set('loginTime', 1);
		}
	}

	private function checkPass($pass) {
		if ($pass == $this->pass) {
			return true;
		} else {
			$this->error = 'Wrong password';
			return false;
		}
	}

	private function logSession() {
		$session = new Session();
		$session->open();
		if ($_SESSION['loginTime'] >= $this->wrongTime) {
			return false;
		}
		return true;
	}

	private function setlogSession($result) {
		$session = new Session();
		$session->initWebSiteSession(5, $result);
	}

	//Not suppose to use, I suggest use checkExist
	public function checkExistWithSql($sql) {
		$result = $this->Search($sql);
		$this->EmptySearch($result);
	}

}