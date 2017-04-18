<?php

/*!
 * 错误编号 & 错误信息
 */

namespace App\Libraries;

class Error {
	/**
	 * return error message
	 * @param  [int] $number [description]
	 * @param  [array] $data   [description]
	 * @return [array]        [description]
	 */
	public static function make( $number, $datas=null)
	{
		$errorArray = config("error"); // get error array

		$new_data = array(
			'error' => $number,
			'message' => $errorArray[$number]
		);

		if ( isset($datas) ) {
			$new_data['data'] = $datas;
		}

		return $new_data;
	}
}
