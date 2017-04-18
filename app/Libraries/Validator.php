<?php

/*!
 * 错误编号 & 错误信息
 */

namespace App\Libraries;

class Validator {

	static $regexp = array(

		1 => '用户未登录。',
		2 => '数据库错误。',

		//管理员错误
		101 => '管理员名称或密码不能为空',
		102 => '管理员名称不符合规范。',
		103 => '密码不符合规范。',
		104 => '管理员信息填写不完整。'

	);

	public static function check( $value, $rules) 
	{





		$new_data = array(
			'error' => $number,
			'message' => self::$errorMessage[$number]
		);

		if ( isset($data) ) {
			$new_data['data'] = $data;
		}

		return $new_data;
	}
}

