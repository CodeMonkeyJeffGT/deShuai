<?php
namespace App\Controller;
use FF\Core\Controller;
use FF\Core\Config;
use App\Vendor\Nefu;

class BaseController extends Controller{
	
	//code
	//1 常规错误
	//2 未登录

	public function __construct() {
		date_default_timezone_set('PRC');
	}

	protected function returnJson($json)
	{
		echo $json;
		die;
	}

	protected function success($data = array()) {
		$this->apiReturn($data, '', 0);
	}

	protected function error($message) {
		$this->apiReturn(array(), $message, 1);
	}

	protected function goLogin() {
		$this->apiReturn(array(), '请登录', 2);
	}

	private function apiReturn($data, $message, $code) {
		echo json_encode(array(
			'code' => $code,
			'data' => $data,
			'message' => $message,
		));
		die;
	}

	protected function doRequest($url)
	{
		$opts = array( 
			CURLOPT_HEADER => 0, 
			CURLOPT_URL => $url, 
			CURLOPT_RETURNTRANSFER => 1, 
			CURLOPT_FORBID_REUSE => 1, 
			// CURLOPT_TIMEOUT => 10, 
		); 
	
		$ch = curl_init(); 
		curl_setopt_array($ch, $opts); 
		if( ! $result = curl_exec($ch)) 
		{
			return false;
		} 
		curl_close($ch); 
		return $result; 
	}

}
