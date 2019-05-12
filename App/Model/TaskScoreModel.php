<?php
namespace App\Model;
use \FF\Core\Model;

class TaskScoreModel extends Model{

	public function lists($teacher) {
		$sql = '
			SELECT `t`.`id` `id`, `title`, `time`, `t`.`count` `count`, `s`.`count` `num`
			FROM `task_score` `t`
			LEFT JOIN (
				SELECT `task_id`, count(`id`) `count`
				FROM `score`
				GROUP BY `task_id`
			) `s`
			ON `t`.`id` = `s`.`task_id`
			WHERE `t`.`u_id` = ' . $teacher;
		$list = $this->query($sql);
		for ($i = 0, $iLoop = count($list); $i < $iLoop; $i++) {
			if ($list[$i]['count'] === -1 || is_null($list[$i]['num']) || $list[$i]['num'] < $list[$i]['count']) {
				if (time() - $list[$i]['time'] < 86400) {
					$list[$i]['status'] = 'doing';
				} else {
					$list[$i]['status'] = 'fail';
				}
			} else {
					$list[$i]['status'] = 'done';
			}
			$list[$i]['time'] = date('Y-m-d H:i:s', $list[$i]['time']);
			unset($list[$i]['count']);
			unset($list[$i]['num']);
		}
		$result['list'] = $list;
		return $result;
	}

	public function set($u_id, $college, $grade, $major, $majorV, $class, $classV, $term, $type, $lesson, 
		$student, $showWay, $time, $title) {
		$major = model('major')->get($majorV, $college, $major)['id'];
		$class = model('class')->get($classV, $major, $grade, $class)['id'];
		$sql = '
			INSERT INTO `task_score`(`u_id`, `college`, `grade`, `major`, `class`, `term`, `type`, `lesson`,
				`student`, `show_way`, `time`, `title`, `count`)
			VALUES(' . $u_id . ', ' . $college . ', ' . (int)$grade . ', ' . $major . ', ' . $class . ', ?, ?, ?, ?, ' . (int)$showWay . ', ' . $time . ', ?, -1)
		';
		$this->query($sql, array($term, $type, $lesson, $student, $title));
		return $this->lastInsertId();
	}

	public function get($id) {
		$sql = '
			SELECT `t`.`grade` `grade`, `m`.`name` `major_v`, `m`.`value` `major`, `c`.`name` `class_v`,
				`c`.`value` `class`, `t`.`term` `term`, `t`.`type` `type`, `t`.`lesson` `lesson`,
				`t`.`student` `student`, `t`.`show_way` `show_way`, `t`.`count` `count`, `s`.`num` `num`
			FROM `task_score` `t`
			JOIN (
				SELECT count(`score`.`id`) `num`
				FROM `score`
				WHERE `task_id` = ' . $id . '
			) `s`
			JOIN `major` `m`
			ON `t`.`major` = `m`.`id`
			JOIN `class` `c`
			ON `t`.`class` = `c`.`id`
			WHERE `t`.`id` = ' . $id;
		$info = $this->query($sql);
		if (count($info) === 0) {
			return false;
		} else {
			$info = sql_to_php($info[0]);
		}
		$types = array(
			'' => '全部',
			'01' => '公共课',
			'02' => '公共基础课',
			'03' => '专业基础课',
			'04' => '专业课',
			'05' => '专业选修课',
			'06' => '通识教育选修课',
			'07' => '通识教育必修课',
			'09' => '学科基础课',
			'10' => '实践教学',
			'11' => '通识教育课',
		);
		$showWays = array(
			'显示最后成绩',
			'显示最好成绩',
			'显示全部成绩',
		);
		$result = array(
			'dataV' => array(
				'grade' => ($info['grade'] == 0 ? '全部
' : $info['grade']) . '<i></i>',
				'major' => $info['majorV'] . '<i></i>',
				'class' => $info['classV'] . '<i></i>',
				'term' => ($info['term'] == '' ? '全部
' : $info['term']) . '<i></i>',
				'type' => $types[$info['type']] . '<i></i>',
				'showWay' => $showWays[$info['showWay']] . '<i></i>',
			),
			'data' => array(
				'grade' => ($info['grade'] == 0 ? '' : $info['grade']),
				'major' => $info['major'],
				'class' => $info['class'],
				'lesson' => $info['lesson'],
				'student' => $info['student'],
				'type' => $info['type'],
				'showWay' => $info['showWay'],
				'term' => $info['term'],
			),
		);
		return $result;
		// $result['detail'] = model('score')->list($id);
	}

	public function delete($id) {
		
	}

}