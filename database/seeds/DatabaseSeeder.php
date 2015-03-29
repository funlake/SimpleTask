<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use SimpleTask\Models\Category;
class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->call('CategorySeeder');
		$this->command->info('Category table seeded!');
		//Model::unguard();
		// $this->call('UserTableSeeder');
	}

}

class CategorySeeder extends Seeder {

	public function run()
	{
		\DB::statement('SET FOREIGN_KEY_CHECKS = 0');
		Category::truncate();
		\DB::statement('SET FOREIGN_KEY_CHECKS = 1');
		$root = [];
		foreach(['工程'=>0,'生活服务'=>0,'商务'=>0,'汽车服务'=>0,'公益'=>0] as $cate=>$pid)
		{
			$data = Category::create([
				'PARENT_ID'			=> $pid,
				'CATAGORY_NAME' 	=> $cate,
				'CATAGORY_LEVEL'	=> 1,
			]);
			$root[$cate] = $data->id;

		}
		 foreach([	
		 	'工程' => [
		 		'智能中控','土建装修','安防工程'
		 	] 
		 ] as $cate=>$subCates){
		 	foreach($subCates as $item)
		 	{
		 		Category::create([
					'PARENT_ID'			=> $root[$cate],
					'CATAGORY_NAME' 	=> $item,
					'CATAGORY_LEVEL'	=> 2,
				]);
		 	}

		 }

		// Category::create([
		// 	'PARENT_ID'			=> 1,
		// 	'CATAGORY_NAME' 	=> '智能中控',
		// 	'CATAGORY_LEVEL'	=> 2,
		// ]);
	}
}
