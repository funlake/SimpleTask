<?php
namespace SimpleTask\Http\Controllers\Api\Drives;
class Json
{
	public static function response($data,$callback=null)
	{
		return response()->json($data)->setCallback($callback);
	}
}