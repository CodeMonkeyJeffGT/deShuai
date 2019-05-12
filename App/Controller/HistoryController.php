<?php
namespace App\Controller;
use App\Controller\BaseController;

class HistoryController extends BaseController{

	public function __construct(){}

	public function index()
	{
		$type = input('post.type', 'score');
		$teacher = session('teacher.id');
		$db = model('task' . ucfirst($type));
		$list = $db->lists($teacher);
		$this->success($list);
	}

	public function remove(){
		$id = input('post.id', null);
		if(is_null($id))
			$this->error('请指定id');
		$type = input('post.type', 'score');
		$teacher = session('teacher.id');
		$db = model('task' . ucfirst($type));
		if (count($db->get($id)) === 0) {
			$this->error('该记录不存在');
		}
		$db->delete($id);
		$this->success();
	}
}
