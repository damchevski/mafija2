<?php
namespace App\Middleware;

class AuthMiddleware extends Middleware
{
	public function __invoke($request, $response, $next)
	{
		if(!$this->auth->check()){
			$this->flash->addmessage('error', 'Треба да се логирате');
			return $response->withRedirect($this->router->pathFor('home'));
    }
		$response = $next($request, $response);
		return $response;
	}
}
