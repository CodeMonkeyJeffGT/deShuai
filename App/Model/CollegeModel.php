<?php
namespace App\Model;
use \FF\Core\Model;

class CollegeModel extends Model{

	public function get($name) {
		$sql = '
			SELECT *
			FROM `college`
			WHERE `name` = ?
		';
		$college = $this->query($sql, $name);
		if (count($college) === 0) {
			$sql = '
				INSERT INTO `college`(`name`, `value`)
				VALUES(?, "")
			';
			$this->query($sql, $name);
			$college = array(
				'id' => $this->lastInsertId(),
				'name' => $name,
				'value' => '',
			);
		} else {
			$college = $college[0];
		}
		return $college;
	}

	public function update($id, $value) {
		$sql = '
			UPDATE `college`
			SET `value` = ?
			WHERE `id` = ' . $id;
		$this->query($sql, $value);
	}
	
}