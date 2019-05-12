<?php
namespace App\Model;
use \FF\Core\Model;

class UserModel extends Model{

	public function getByAcc($account) {
		$sql = '
			SELECT `id`
			FROM `user`
			WHERE `account` = ' . $account . '
		';
		return $this->query($sql);
	}

	public function getById($id) {
		$sql = '
			SELECT `user`.`id` `id`, `user`.`account` `account`, `user`.`password` `password`, `user`.`name` `name`, `college`.`id` `college_id`, `college`.`name` `college`, `college`.`value` `college_value`
			FROM `user`, `college`
			WHERE `user`.`id` = ' . $id . '
				AND `college`.`id` = `user`.`college`
		';
		return $this->query($sql);
	}

	public function set($account, $password, $name, $college) {
		$college = model('college')->get($college)['id'];
		$sql = '
			INSERT INTO `user`(`account`, `password`, `name`, `college`)
			VALUES(' . (int)$account . ', ?, ?, ' . $college . ')
		';
		$this->query($sql, array($password, $name));
		return $this->lastInsertId();
	}

	public function updatePass($id, $password) {
		$sql = '
			UPDATE `user`
			SET `password` = ?
			WHERE `id` = ' . $id . '
		';
		$this->query($sql, $password);
	}

	public function updateInfo($id, $name, $college) {
		$college = model('college')->get($college)['id'];
		$sql = '
			UPDATE `user`
			SET `name` = ?, `college` = ' . $college . '
			WHERE `id` = ' . $id . '
		';
		$this->query($sql, $name);
	}
	
}