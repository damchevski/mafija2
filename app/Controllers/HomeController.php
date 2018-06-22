<?php

namespace App\Controllers;
use App\Models\User;

class HomeController extends Controller
{
  public function getPeople($request, $response)
  {
    $users = User::where('active',true)->get();
    return $this->view->render($response, 'home.twig',[
      'users'  => $users
    ]);
  }
  public function postPeople($request, $response)
  {
    //not in use
    $name = $request->getParam('name');

    $user = $this->auth->user();
    $user->update([
      'people' => $user->people + 1
    ]);
    $user->addPerson()->create([
      'name' => trim($name),
      'balance' => 0
    ]);
    $this->flash->addMessage('info','You added a person');
    return $response->withRedirect($this->router->pathFor('home'));

  }

}
