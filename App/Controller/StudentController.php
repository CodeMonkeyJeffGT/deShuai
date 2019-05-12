<?php
namespace App\Controller;
use App\Controller\BaseController;
use App\Vendor\Nefu;

class StudentController extends BaseController{ 

	public function index(){
		$this->buildInfo();
		$this->display('student');
	}

	public function start(){
		$data = array(
			'grade' => input('post.grade', ''),
			'major' => input('post.major', ''),
			'class' => input('post.class', ''),
			'zzmm' => input('post.zzmm', ''),
			'sex' => input('post.sex', ''),
			'number' => input('post.number', ''),
			'name' => input('post.name', ''),
			'id' => input('post.id', ''),
			'college' => input('post.college', ''),
		);
		$dataV = array(
			'grade' => input('post.gradeV', ''),
			'major' => input('post.majorV', ''),
			'class' => input('post.classV', ''),
			'zzmm' => input('post.zzmmV', ''),
			'sex' => input('post.sexV', ''),
			'number' => input('post.numberV', ''),
			'name' => input('post.nameV', ''),
			'id' => input('post.idV', ''),
		);
		$title = input('post.title', '');
		$time = date('Y-m-d H:i', time());
		$teacher = $_SESSION['teacher']['account'];
		$history_dir = ROOT . '/store/teacher/' . $teacher . '/student/';
		$history = json_decode(file_get_contents($history_dir . 'history'), true);
		$id = count($history) == 0 ? 0 : $history[count($history) - 1]['id'] + 1;
		$info = array(
			'id' => $id,
			'title' => $title,
			'time' => $time,
			'status' => 1,
			'data' => $data,
			'dataV' => $dataV,
		);
		$history[] = $info;
		file_put_contents($history_dir . 'history', json_encode($history));
		file_put_contents($history_dir . $id,json_encode(array('info' => $info, 'detail' => [])));
		$url = 'http://' . $_SERVER['SERVER_NAME'] . '/?c=student&f=operateAuto';
		$data['id'] = $id;
		$this->doRequest($url, $data);
		$this->success(array(
			'id' => $id,
		));
	}

	public function operateAuto(){
		ignore_user_abort(true);
		set_time_limit(0);
		$data = array(
			'' => input('post.grade', ''),
			'' => input('post.major', ''),
			'' => input('post.class', ''),
			'' => input('post.zzmm', ''),
			'' => input('post.sex', ''),
			'' => input('post.number', ''),
			'' => input('post.name', ''),
			'' => input('post.id', ''),
		);
		$id = input('post.id', false);
		if (false === $id) {
			$this->error('非法访问');
		}
		$floor = input('post.floor', 0);
		
	}

	public function info(){
		$id = input('post.id');
		$teacher = $_SESSION['teacher']['account'];
		if ( ! is_file(ROOT . '/store/teacher/' . $teacher . '/student/' . $id)) {
			$this->error('记录不存在');
		}
		$info = file_get_contents(ROOT . '/store/teacher/' . $teacher . '/student/' . $id);
		$this->success(json_decode($info, true));
	}
}
