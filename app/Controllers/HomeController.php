<?php

namespace App\Controllers;
use App\Models\User;
use App\Models\Missions;
use App\Models\MainProm;

class HomeController extends Controller
{
  public function getPeople($request, $response)
  {
     //check na maissite koi se zavrseni
     $user = $this->auth->user();
     $mainProm = MainProm::where('user_id',$user->id)->first();
     Missions::checkMissions($user , $mainProm);
    return $this->view->render($response, 'home.twig');
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
