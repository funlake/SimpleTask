<?php namespace SimpleTask\Providers;

use Illuminate\Support\ServiceProvider;

class UtilsServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		// $this->app->bind(
		// 	'Illuminate\Contracts\Auth\Registrar',
		// 	'SimpleTask\Services\Rest'
		// );
		$this->app->singleton('DbQueryUtils',function($app){
			return new \SimpleTask\Services\DbQueryBuilder();
		});
		$this->app->singleton('ApiUtils',function($app){
			return new \SimpleTask\Services\ApiUtils();
		});
	}

}
