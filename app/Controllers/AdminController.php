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
       return $response->withRedirect($this->router->pathFor('admin'));
     }else{
       $this->flash->addMessage('info','Limitot e postignat');
       return $response->withRedirect($this->router->pathFor('admin'));
     }

   }else if($drink->type == 'drugs') {

        $user = $this->auth->user();
        $user_zaliha = json_decode($user->mainProm->drugs_zaliha,true);
        if($user_zaliha[$drink->title] + $kolicina <= $drink->zaliha){
           $user_zaliha[$drink->title] += $kolicina;
           $user->mainProm->update(['pari' => $user->mainProm->pari - ($drink->price * $kolicina)]);
           $user->mainProm->update(['drugs_zaliha' => json_encode($user_zaliha) ]);

          $this->flash->addMessage('info','Uspesno nadopolni kokain');
          return $response->withRedirect($this->router->pathFor('admin'));
        }else{
          $this->flash->addMessage('info','Limitot e dostignat');
          return $response->withRedirect($this->router->pathFor('admin'));
        }
   }
      $this->flash->addMessage('info','Neyspesno');
      return $response->withRedirect($this->router->pathFor('admin'));
  }

}
