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
    $user = $this->auth->user();
    $drink = DrinksDrugs::find(2);
     //opp done zivis iod id so ke se odbere
     if($drink->add($user,$kolicina)){
       $this->flash->addMessage('info','Uspesno nadopolni kokanin');
       return $response->withRedirect($this->router->pathFor('admin'));
     }
     $this->flash->addMessage('info','Neuspeso nemate dovolno pari ili go postignavte limitot');
     return $response->withRedirect($this->router->pathFor('admin'));
  }

}
