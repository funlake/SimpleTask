<?php 
namespace SimpleTask\Models;
class Category extends Base
{
	public static $searchFields = array(
			'CATAGORY_ID'					=> 'id',
			'CATAGORY_NAME' 				=> 'name'
	);
	public $timestamps = false;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'jdt_task_catagory';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['PARENT_ID','CATAGORY_NAME','CATEGORY_LEVEL'];


	public static function search($q,$start,$limit,$orderby)
	{
		$utils = app('DbQueryUtils');
		list($cdt,$val) = $utils->getSearch($q,self::$searchFields);
		$data =  self::take($limit)
				->skip($start)
				->whereRaw($cdt,$val)
				->select(array(\DB::raw('SQL_CALC_FOUND_ROWS *')))
				->orderByRaw($utils->getOrderBy($orderby,self::$searchFields))
				->get();
		return ['data'=>$data,'total'=>parent::getFoundTotal()];
	}

}