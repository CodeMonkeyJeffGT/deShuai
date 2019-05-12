<?php
namespace App\Model;
use \FF\Core\Model;

class ClassModel extends Model{

	public function get($name, $major, $grade, $value = '') {
		$sql = '
			SELECT `id`, `value`
			FROM `class`
			WHERE `value` = ?
		';
		$class = $this->query($sql, $value);
		if (count($class) === 0) {
			$sql = '
				INSERT INTO `class`(`name`, `value`, `grade`, `major`)
				VALUES(?, ?, ' . (int)$grade . ', ' . $major . ')
			';
			$this->query($sql, array($name, $value));
			$class = array(
				'id' => $this->lastInsertId(),
			);
		} else {
			$class = $class[0];
			if ($class['value'] === '' && $value !== '') {
				$sql = '
					UPDATE `class`
					SET `value` = ?
					WHERE `id` = ' . $class['id'];
				$this->query($sql, $value);
			}
		}
		return $class;
	}
	
}