<?php 
/**
* Api access token check process.
*/
namespace SimpleTask\Http\Middleware;
use Closure;
use Config;
class VerifyAccessToken{

	public function __construct()
	{
		Config::set('debugbar.enabled',false);

	}
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		//return parent::handle($request, $next);
		return $next($request);
	}

}