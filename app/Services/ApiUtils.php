<?php
namespace SimpleTask\Services;
//only convert items we specified
define('API_CONVERT_KEEP'	,1);
//convert items we specified,keep table fields also
define('API_CONVERT_ALL'  	,2);
//remove items we specified,return rest fields in databse table
define('API_CONVERT_REMOVE' ,3);
class ApiUtils
{
	/**
	** Format the response array .
	** 1.key converting
	** 2.response sorting
	**/
	public function convert($result,$convert,$dimens=1,$flag = API_CONVERT_ALL)
	{		
		//if got empty records return an empty array(if $result was a collection object)
		if(gettype($result) == "object")
		{
			if($result instanceof stdClass)
			{
				$result = (array)$result;
			}
			else if(method_exists($result, "isEmpty") and $result->isEmpty())
			{
				return array();
			}
			else
			{
				$result = $result->toArray();
			}
		}
		//if got empty records return an empty array(if $result was a normal array)
		else if(empty($result))
		{
			return array();
		}
		//module page call,don't need to convert the return array
		//if(!$this->mode) return $result;

		if($dimens >= 2)
		{//2 dimension recordsets,generally those recordsets from database.
			foreach($result as $key=>$sets)
			{
				$result[$key] = $this->convertItem($sets,$convert,$flag);
			}
		}
		else
		{
			$result = $this->convertItem($result,$convert,$flag);
		}
		return $result;
	}

	public function convertItem($result,$convert,$flag)
	{
		$data = array();
		$result = (array)$result;
		switch($flag)
		{
			case API_CONVERT_ALL :
			foreach($convert as $key=>$alter)
			{
				if(array_key_exists($key,$result))
				{
					if($alter !== false)
					{
						list($k,$f) = $this->convertKey($alter);

						if(!empty($f) ){
							if(strpos($f,">") === 0)
							{
								$data[$k] = settype($result[$key], substr($f,1));
							}
							else if(function_exists($f))
							{
								$data[$k] = $f($result[$key]);
							}
							else
							{
								$data[$alter] = $result[$key];
							}
						}
						else
						{
							$data[$alter] = $result[$key];
						}
					}
					unset($result[$key]);
				}
			}
			$data = array_merge($data,$result);			
			break;

			case API_CONVERT_KEEP:
			foreach($convert as $key=>$alter)
			{
				if(array_key_exists($key,$result))
				{
					list($k,$f) = $this->convertKey($alter);
					if(!empty($f)){
						if(strpos($f,">") === 0)
						{
							$data[$k] = settype($result[$key], substr($f,1));
						}
						elseif(function_exists($f))
						{
							$data[$k] = $f($result[$key]);
						}
						else
						{
							$data[$alter] = $result[$key];
						}
					}
					else
					{
						$data[$alter] = $result[$key];
					}
				}
			}
			break;

			case API_CONVERT_REMOVE:
			foreach($convert as $item)
			{
				unset($result[$item]);
			}
			$data = $result;
			break;
		}

		return $data;		
	}

	public function convertKey($key)
	{
		$func = $tk = "";
		if(strpos($key,":") > 0)
		{
			list($func,$tk) = explode(":",$key);
		}
		else
		{
			$tk = $key;
		}
		return array($tk,$func);
	}
}