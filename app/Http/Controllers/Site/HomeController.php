<?php
namespace SimpleTask\Http\Controllers\Site;
Use SimpleTask\Models\Category;
class HomeController extends BaseController
{
	public function index()
	{
		return '首页';
	}
}
