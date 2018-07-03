<?php

namespace App\Controllers;
use App\Models\User;
use App\Models\Missions;
use App\Models\Rabota;
use App\Models\Drzava;
use App\Models\Clan;

class HomeController extends Controller
{
  public function getPeople($request, $response)
  {
    //missii check
     $user = $this->auth->user();
     if($user){
       Missions::checkMissions($user , $user->mainProm);
     }
    return $this->view->render($response, 'home.twig',[
      'user'  => $user,
    ]);
  }
  public function postPeople($request, $response)
  {
    /*rabota is done osven tajmerot za kolky da ceka final
    $job = $request->getParam('rabota');
     if($job == 'oks'){
       $rabota = Rabota::find(2);
        $user = $this->auth->user();
     if($rabota->type == 'rabota'){
          if($user->energy->check($rabota->energija)){
            if($rabota->calculate($user,$this->randomlib->generateInt(0, 100))){
                $this->flash->addMessage('info','Rabotata e uspesna. Pocekajte '.$rabota->complete_time.' sekundi');
                return $response->withRedirect($this->router->pathFor('home'));
              }
         }else{
           $this->flash->addMessage('info','Nemas dovolno energija.');
           return $response->withRedirect($this->router->pathFor('home'));
         }
           $this->flash->addMessage('info','Rabotata e neuspesna.');
           return $response->withRedirect($this->router->pathFor('home'));

     }else if($rabota->type == 'crime'){
       //kriminal opija da te fatat nema i tajmer
          $user = $this->auth->user();
       if($user->energy->check($rabota->energija)){
         $num = $rabota->crime($user,$this->randomlib->generateInt(0, 100));
         switch ($num) {
           case 0:
             $this->flash->addMessage('info','Kriminalot e uspesen. Pocekajte '.$rabota->complete_time.' sekundi');
             return $response->withRedirect($this->router->pathFor('home'));
             break;
           case 1:
             $this->flash->addMessage('info','Kriminalot e neuspesen i ne te fati policija');
             return $response->withRedirect($this->router->pathFor('home'));
             break;
           case 2:
             $this->flash->addMessage('info','Kriminalot e neuspesen i  te fati policija');
             return $response->withRedirect($this->router->pathFor('home'));
             break;
         }
       }
     $this->flash->addMessage('info','Nemas dovolno energija');
     return $response->withRedirect($this->router->pathFor('home'));
     }
   }
   //premestuvanje gradovi gotovo
    $grad = $request->getParam('grad');
      $user = $this->auth->user();
      $from = Drzava::where('name',$user->mainProm->place)->first();
      $next = Drzava::where('name',$grad)->first();
      if($from->travel($user,$next)){
        $this->flash->addMessage('info','Ke letate pocekajte 3 minuti');
        return $response->withRedirect($this->router->pathFor('home'));
      }

      $this->flash->addMessage('info','Neuspesno obidete se povtorno');
      return $response->withRedirect($this->router->pathFor('home'));
      //creiranje na clan
     $name = $request->getParam('name');
     $moto = $request->getParam('moto');
     $user = $this->auth->user();
     $user = Clan::create([
     'owner'    => $user->id,
     'name'       => $name,
     'moto'      => $moto
     ]);

     $this->flash->addMessage('info','Uspesno go napravi clanot '.$user->name);
     return $response->withRedirect($this->router->pathFor('home'));  */
     //isto ke bide i za dodavanje na clan
     //akcept ke bide opp sega treba da se pravi
     $me = $this->auth->user();
     $name = $request->getParam('name');
     $user = User::where('username',$name)->first();
     $user->mainProm->update(['pending' => $me->id.'_']);
     $this->flash->addMessage('info','Isprati poraka za prijatelstvo na '.$user->username);
     return $response->withRedirect($this->router->pathFor('home'));
  }

}
