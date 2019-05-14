<?php
namespace App\Controller;
use App\Controller\BaseController;
use App\Vendor\Nefu;

class UserController extends BaseController{ 

	public function login(){
		$account = input('post.username', '');
		$password = input('post.password', '');
		if (empty($account)) {
			$this->error('请输入账号');
		}
		if (empty($password)) {
			$this->error('请输入密码');
		}

		$userDb = model('user');
		$user = $userDb->getByAcc($account);
		if (count($user) > 0) {
			if ($user[0]['password'] == $password) {
				session('id', $user[0]['id']);
				$this->success();
			} else {
				$this->error('密码错误');
			}
		} else {
			$this->error('账号不存在');
		}
	}

	public function changePassword()
	{
		$username = input('post.username', '');
		$password = input('post.password', '');
		$pass = input('post.pass', '');
		$checkPass = input('post.checkPass', '');
		if (empty($password)) {
			$this->error('请输入密码');
		}
		if (empty($pass)) {
			$this->error('请输入新密码');
		}
		if ($checkPass != $pass) {
			$this->error('两次输入的新密码不同');
		}
		$userDb = model('user');
		$user = $userDb->getByAcc($username);
		if ($user[0]['password'] == $password) {
			$userDb->changePass($username, $pass);
			$this->success();
		} else {
			$this->error('密码错误');
		}
	}

	public function logout(){
		session_unset();
		$this->success();
	}
}
