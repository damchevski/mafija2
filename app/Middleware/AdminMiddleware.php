<?php
namespace App\Middleware;
use App\Models\UserPermission;

class AdminMiddleware extends Middleware
{
	public function __invoke($request, $response, $next)
	{
    $permission = UserPermission::where('user_id', $this->auth->user()->id)->first();
		if(!$this->auth->check() || !$permission->hasPermission('is_admin')){
			return $response->withRedirect($this->router->pathFor('home'));
    }
		$response = $next($request, $response);
		return $response;
	}
}
