<?php
namespace SimpleTask\Http\Controllers\Api\Drives;
class Xml
{
	public static function response($data)
	{
		$xml = '<?xml version="1.0" encoding="UTF-8"?><Records>';
		//$xml .= '<![CDATA['.$data['code'].']]>';
		$xml .= '<Code>'.$data['code'].'</Code>';
		//if($data['code'] === 'error'){
		$xml .= '<Message>'.@$data['msg'].'</Message>';
		//}
		$xml .= '<Items>';
		foreach((array)$data['data'] as $items){
			$xml .= '<Item>';
			foreach($items as $key => $item){
				$xml .= '<'.$key.'>'.$item.'</'.$key.'>';
			}
			$xml .= '</Item>';
		}
		$xml .= '</Items>';
		$xml .= '</Records>';
		return $xml;
	}
}