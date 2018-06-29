<?php

namespace App\Controllers;
use App\Models\User;
use App\Models\DrinksDrugs;

class AdminController extends Controller
{
  public function getAdmin($request, $response)
  {
    $user = $this->auth->user();
    return $this->view->render($response, 'admin.twig',[
      'user'  => $user,
    ]);
  }
  public function postAdmin($request, $response)
  {
    $kolicina = $request->getParam('kolicina');
    $drink = DrinksDrugs::find(2);
    if($drink->type == 'drinks'){
     $user = $this->auth->user();
     $user_zaliha = json_decode($user->mainProm->drinks_zaliha,true);
     if($user_zaliha[$drink->title] + $kolicina <= $drink->zaliha){

        $user_zaliha[$drink->title] += $kolicina;
        $user->mainProm->update(['pari' => $user->mainProm->pari - ($drink->price * $kolicina)]);
        $user->mainProm->update(['drinks_zaliha' => json_encode($user_zaliha) ]);

       $this->flash->addMessage('info','Uspesno nadopolni alhohol');
       return $response->withRedirect($this->router->pathFor('home'));
     }

   }else if($drink->type == 'drugs') {
     //istazuvanje
        $user = $this->auth->user();
        $user->mainProm->update(['pari' => $user->mainProm->pari - ($drink->price * $kolicina)]);

       $this->flash->addMessage('info','Uspesno nadopolni kokain');
       return $response->withRedirect($this->router->pathFor('home'));

   }
      $this->flash->addMessage('info','Neyspesno');
      return $response->withRedirect($this->router->pathFor('home'));
  }

}
