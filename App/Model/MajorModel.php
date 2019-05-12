<?php
namespace App\Model;
use \FF\Core\Model;

class MajorModel extends Model{

	public function get($name, $college, $value = '') {
		$sql = '
			SELECT `id`, `value`
			FROM `major`
			WHERE `value` = ?
		';
		$major = $this->query($sql, $value);
		if (count($major) === 0) {
			$sql = '
				INSERT INTO `major`(`name`, `value`, `college`)
				VALUES(?, ?, ' . $college . ')
			';
			$this->query($sql, array($name, $value));
			$major = array(
				'id' => $this->lastInsertId(),
			);
		} else {
			$major = $major[0];
			if ($major['value'] === '' && $value !== '') {
				$sql = '
					UPDATE `major`
					SET `value` = ?
					WHERE `id` = ' . $major['id'];
				$this->query($sql, $value);
			}
		}
		return $major;
	}
	
}