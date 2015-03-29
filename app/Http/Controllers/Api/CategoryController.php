<?php namespace SimpleTask\Http\Controllers\Api;
use SimpleTask\Http\Controllers\Api\BaseController;
use SimpleTask\Contracts\RestContract;
use SimpleTask\Models\Category;
class CategoryController extends BaseController implements RestContract
{
	public function __construct()
	{
		//$this->restHelper = $restHelper;
		$this->apiUtils = app('ApiUtils');
	}
	//get
	public function find($q,$start=0,$limit=20,$orderby='')
	{
		$result = Category::search($q,$start,$limit,$orderby);	
		return parent::response([
				'code' 	=> 'success',
				'total' => $result['total'],
				'data'	=> $this->apiUtils->convert(
					$result['data'],
					[
						'CATAGORY_ID' 		=> 'id',
						'PARENT_ID' 		=> 'pid',
						'CATAGORY_NAME'		=> 'name',
						'CATAGORY_LEVEL'	=> 'level',
						'CREATE_TIME'		=> 'created_time'
					],
					2
				)
		]);
	}
	//put
	public function update($id)
	{
		return $id;
		//return id;
	}
	//post
	public function add($data)
	{

	}
	//delete
	public function delete($id)
	{

	}
}