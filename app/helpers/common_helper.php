<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function strexists($string, $find) {

	return !(false === strpos($string, $find));

}

//获取上传文件真实路径
function tomedia($src, $is_cahce = false) {
	$src = trim($src);
	if (empty($src)) {
		return '';
	}
	if ($is_cahce) {
		$src .= '?v=' . time();
	}

	if (strexists($src, 'http://') || strexists($src, 'https://')) {
		return $src;
	}
	
	return base_url().$src;
}