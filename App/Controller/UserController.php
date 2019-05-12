<?php
namespace App\Controller;
use App\Controller\BaseController;
use App\Vendor\Nefu;

class UserController extends BaseController{ 

	public function login(){
		$account = input('post.account');
		$password = input('post.password');
		if (empty($account)) {
			$this->error('请输入账号');
		}
		if (empty($password)) {
			$this->error('请输入密码');
		}

		$nefuer = Nefu::getInstance($account, $password);
		if (false === $nefuer) {
			$this->error('账号密码错误或教务系统不可用');
		}

		$userDb = model('user');
		$userDb->query('SHOW TABLES');
		$user = $userDb->getByAcc($account);
		$id =  0;
		// p($user);die;
		if (count($user) > 0) {
			$id = $user[0]['id'];
			$userDb->updatePass($id, $password);
		} else {
			$info = $nefuer->userinfo();
			if (false == $info) {
				$this->error('学生请勿登录教师端系统');
			} else {
				$id = $userDb->set($account, $password, $info['name'], $info['college']);
			}
		}
		$user = $userDb->getById($id);
		session('teacher.id', $user[0]['id']);
		session('teacher.account', $user[0]['account']);
		session('teacher.password', $user[0]['password']);
		session('teacher.name', $user[0]['name']);
		session('teacher.college', $user[0]['college']);
		session('teacher.collegeId', $user[0]['college_id']);
		session('teacher.collegeValue', $user[0]['college_value']);
		session('teacher.cookie', $nefuer->getCookie());

		$this->success();
	}

	public function info(){
		$this->buildInfo();
		$this->display('info');
	}

	public function reload(){
		$info = $this->nefuerDo('userinfo');
		if (false == $info) {
			session_unset();
			$this->goLogin();
		}

		session('teacher.name', $info['name']);
		session('teacher.college', $info['college']);
		$userDb = model('user');
		$userDb->updateInfo(session('teacher.id'), session('teacher.name'), session('teacher.college'));
		$collegeId = $userDb->getById(session('teacher.id'))[0]['college_id'];
		session('teacher.collegeId', $collegeId);
		$this->success();
	}

	public function logout(){
		session_unset();
		$this->success();
	}
}
