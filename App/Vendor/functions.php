<?php

function sql_to_php($arr) {
	foreach ($arr as $key => $value) {
		if(is_array($value)) {
			$value = sql_to_php($value);
		}
		unset($arr[$key]);
		$key = preg_replace_callback('/_(\w)/', function($matches) {
				return strtoupper($matches[1]);
			}, $key);
		$arr[$key] = $value;
	}
	return $arr;
}
