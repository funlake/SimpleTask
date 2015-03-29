<?php
namespace SimpleTask\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
use Config;
class Base extends Model
{
	public static function getFoundTotal($connection=null)
	{
		 $connection = $connection?:Config::get('database.default');
		 $amount = DB::connection($connection)->select(
		 		DB::raw('select found_rows() as amount')
		 );
		 return $amount[0]->amount;
	}
}