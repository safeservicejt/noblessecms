<?php

class Render
{
	public static function dateFormat($inputData='')
	{
		$inputData=date('M d, Y H:i',strtotime($inputData));

		return $inputData;
	}
}