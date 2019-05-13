<?php
namespace App\Model;
use \FF\Core\Model;

class UserModel extends Model{

	public function getByAcc($account) {
		$sql = '
			SELECT `id`, `password`
			FROM `user`
			WHERE `account` = "' . $account . '"
		';
		return $this->query($sql);
	}

	public function getById($id) {
		$sql = '
			SELECT `user`.`password` `password`
			FROM `user`
			WHERE `user`.`id` = ' . $id . ';
		';
		return $this->query($sql);
	}

	public function changePass($id, $password) {
		$sql = '
			UPDATE `user`
			SET `password` = "' . $password . '"
			WHERE `id` = ' . $id . '
		';
		$this->query($sql);
	}
	
}