<?php
namespace SimpleTask\Services;
class DbQueryBuilder
{
	public function makeSearch($qs,$convert,$combine = ' and ')
	{
		$convert 	= array_flip($convert);
		$boolean    = strtolower(trim($combine));
		if( $boolean == 'and')
		{
			$where 		= array(" 1 ");
		}
		else if($boolean == 'or')
		{
			$where 		= array(" 0 ");
		}
		else
		{
			$where  	= array(" 1 ");
		}
		$val 		= array();
		foreach($qs as $k=>$v)
		{
			//Since parse_str function will replace [.] to [_]
			//and we did some replacement before which from [.] to [___]
			//now we put real thing back.
			$field = str_replace('___', '.', $k);
			$op    = "=";

			if(array_key_exists($k,$convert))
			{
				$field = $convert[$k];
			}
			else
			{
				//Restrict searching fields for api requeset
				//if($this->mode === true) continue;
			}

			// =======================

			if(strpos($v,"@") === 0)
			{
				$op = " like ";
				$v = substr($v,1);
			}
			else if(strpos($v, "~") === 0)
			{
				$op = " between ";
				$v  = substr($v, 1);
			}
			else if(strpos($v, "(") === 0)
			{
				$op = " in ";
				$v  = substr($v, 1,-1);
			}
			else if(strpos($v, ">") === 0)
			{
				$op = " > ";
				$v  = \DB::raw(substr($v, 1));
			}
			else if(strpos($v, "<") === 0)
			{
				$op = " < ";
				$v  = \DB::raw(substr($v, 1));				
			}
			else if(strpos($v, "!") === 0) {
				$op = " <> ";
				$v = \DB::raw(substr($v, 1));
			}

			// ==================
			
			switch($op)
			{
				case ' like ':
				$where[] = $field.$op." binary ? ";
				$val[] = '%'.urldecode($v).'%';
				break;

				case ' between ':
				$where[] = $field.$op." ? and ? ";
				list($from,$to) = explode(",",$v);
				$val[] = is_numeric($from) ? \DB::raw($from*1) : $from;
				$val[] = is_numeric($to) ? \DB::raw($to*1) : $to;
				break;

				case ' in ':
				$ins = array_map('trim',explode(",", $v));
				$cdt = array_fill(0, count($ins), '?');
				$where[] = $field.$op."(".implode(',',$cdt).")";
				$val	 = array_merge($val,$ins);
				break;

				default:
				$where[] = $field.$op."?";
				$val[] = urldecode($v);
				break;
			}
		}
		return array(
			'('.implode($combine,$where).')',
			$val
			);
	}

	public function getSearch($q,$searchFields)
	{
		$bindings = array();
		if(!empty($q) and (strpos($q,'=') !== false))
		{
			$cdt = array();
			$val = array();
			$q = str_replace('.', '___', $q);
			//parse_str($q,$s);
			foreach(explode('&',$q) as $statement)
			{
				$boolean	   = ' AND ';
				if(strpos($statement, '|') !== false)
				{
					$statement = str_replace('|','&',$statement);
					$boolean   = ' OR ';
				}
				parse_str($statement,$s);
				$bd[] =  $this->makeSearch($s,$searchFields,$boolean);
			}
			foreach((array)$bd as $citem)
			{
				$cdt[] = $citem[0];
				$val =  array_merge($val,$citem[1]);
			}
			$bindings = array(implode(' AND ', $cdt),$val);
			
		}
		else if($q == 'all')
		{
			$cdt = "1";
			$val = array();
			$bindings = array($cdt,$val);
		}
		else
		{
			$cdt = "0";
			$val = array();
			$bindings = array($cdt,$val);			
		}
		return $bindings;
	}
	public function getOrderBy($raw,$convert)
	{
		if(empty($raw)) return -1;
		$c = array_flip($convert);
		$regRep = array();
		foreach($c as $key=>$val)
		{
			$regRep['#\b'.$key.'\b#'] = $val;
		}
		return preg_replace(array_keys($regRep), array_values($regRep), $raw);
		//return strtr($raw, array_flip($convert));
	}
}
