<?php namespace SimpleTask\Http\Controllers\Api;
use Illuminate\Routing\Controller;
use Input;
class BaseController extends Controller
{
	public function response($data)
	{
		$callback = Input::get('callback');
		$type      = Input::get('type','json');
		//for jsonp request,only work for javascript request
		if(!empty($callback))
		{
			$return = json_encode($data);
			return $callback."(".$return.")";
		}
		else
		{
			$drive = '\SimpleTask\Http\Controllers\Api\Drives\\'.ucwords($type);
			return $drive::response($data);
		}
	}	
}

?>