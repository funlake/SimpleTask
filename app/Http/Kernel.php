<?php namespace SimpleTask\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel {

	/**
	 * The application's global HTTP middleware stack.
	 *
	 * @var array
	 */
	protected $middleware = [
		'Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode',
		'Illuminate\Cookie\Middleware\EncryptCookies',
		'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
		'Illuminate\Session\Middleware\StartSession',
		'Illuminate\View\Middleware\ShareErrorsFromSession'
		//'SimpleTask\Http\Middleware\VerifyCsrfToken',
	];

	/**
	 * The application's route middleware.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [
		'auth' 					=> 'SimpleTask\Http\Middleware\Authenticate',
		'auth.basic' 			=> 'Illuminate\Auth\Middleware\AuthenticateWithBasicAuth',
		'guest' 				=> 'SimpleTask\Http\Middleware\RedirectIfAuthenticated',
		'api.token'				=> 'SimpleTask\Http\Middleware\VerifyAccessToken'
	];

}
