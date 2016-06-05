<?php
class AjaxController extends MController {

	/*
	 * Users
	 */
	public function RouterAdduser() {
		$arr['name']  = $_POST['user'];
		$arr['phone'] = $_POST['phone'];
		$users        = new Users();
		if ($users->InsertUser($arr)) {
			echo '{"success": true, "msg": "用户姓名: '.$arr['name'].'"}';
		} else {
			echo '{"success": false}';
		}
	}

	public function RouterDeleteuser() {
		$id    = $_POST['id'];
		$users = new Users();
		if ($users->DeleteUser($id)) {
			echo '{"success": true, "msg": "用户ID: '.$id.'"}';
		} else {
			echo '{"success": false}';
		}
	}

	public function RouterUpdateStatus() {
		$status = $_POST['status'];
		$id     = $_POST['id'];
		$users  = new Users();
		if ($users->UpUserAuth($status, $id)) {
			echo '{"success": true, "msg": "用户ID: '.$id.'"}';
		} else {
			echo '{"success": false}';
		}
	}

	public function RouterUpdatepass() {
		$id    = $_POST['id'];
		$id    = '1';
		$users = new Users();
		if ($users->ResetUserPass($id)) {
			echo '{"success": true, "msg": "用户ID: '.$id.'"}';
		} else {
			echo '{"success": false}';
		}
	}

	public function RouterPageUser() {
		$page  = $GET[''];
		$users = new Users();
	}

	/*
	 * Shelvies
	 */
	public function RouterAddshelve() {
		$arr['letter'] = ucfirst($_POST['letter']);
		$arr['status'] = $_POST['status'];
		$shelvies      = new Shelvies();
		if ($shelvies->insertShelvies($arr)) {
			echo '{"success": true, "msg": "用户ID: '.$arr['letter'].'"}';
		} else {
			echo '{"success": false}';
		}
	}

	public function RouterUpStStatus() {
		$id       = $_POST['id'];
		$status   = $_POST['status'];
		$shelvies = new Shelvies();
		$res      = $shelvies->updateStatus($id, $status);
		echo $res;
	}

	public function RouterUpShelveStock() {

	}

	private function UpShelveStock($size) {
		$shelvies = new Shelvies();
		$res      = $shelvies->updateStocks($size);
		if ($res) {
			$res = json_encode($res[0]);
			echo '{"success":true, "msg":'.$res.'}';
		}
	}

	/*
	 * Inquiry
	 */
	public function RouterInsertGoods() {
		$num       = (int) $_POST['num'];
		$size      = (int) $_POST['size'];
		$inquiry   = new Inquiry();
		$insertArr = array();
		for ($i = 0; $i < $num; $i++) {
			$insertArr[] = [$size, 1];
		}
		if ($inquiry->InsertGoods($insertArr)) {
			return $this->UpShelveStock($size);
		} else {
			echo '{"success": false, "msg": "不能录入货物，生成编号"}';
		}
	}

	public function RouterOutquiryInfo() {
		$cargo    = $_POST['cargo'];
		$stock_id = substr($cargo, 0, 8);
		$num      = substr($cargo, 8);
		$inquiry  = new Inquiry();
		$res      = $inquiry->GetOneInfo($stock_id);
		if ($res) {
			echo '{"success":true, "msg":'.$res.', "barcode": "'.$cargo.'","shelvies":"'.$num.'"}';
		} else {
			echo '{"success":false, "msg":"找不到记录"}';
		}
	}

	public function RouterGetInquiryShow() {
		$status  = 2;
		$inquiry = new Inquiry();
		$res     = $inquiry->SelectAllRecStatus($status);
		if ($res) {
			echo '{"success": true, "msg": '.$res.'}';
		} else {
			echo '{"success": false, "msg": "无货物需要录入信息"}';
		}
	}
}