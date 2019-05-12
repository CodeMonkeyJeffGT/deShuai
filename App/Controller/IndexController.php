<?php
namespace App\Controller;
use App\Controller\BaseController;

class IndexController extends BaseController{

	public function index()
	{
		$this->buildInfo();
		$this->display('score');
	}
}
