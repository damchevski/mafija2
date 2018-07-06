<?php

namespace App\Controllers;
use App\Models\User;
use App\Models\Missions;
use App\Models\Rabota;
use App\Models\Drzava;
use App\Models\Clan;
use App\Models\Shop;
use App\Models\Car;


class HomeController extends Controller
{
  public function getPeople($request, $response)
  {
    //missii check
     $user = $this->auth->user();
     if($user){
       Missions::checkMissions($user);
     }
    return $this->view->render($response, 'home.twig',[
      'user'  => $user,
    ]);
  }
  public function postPeople($request, $response)
  {
  /*  //rabota is done osven tajmerot za kolky da ceka final
    $job = $request->getParam('rabota');
     if($job == 'ok'){
       $rabota = Rabota::find(3);
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
       }else{
         $this->flash->addMessage('info','Nemas dovolno energija');
         return $response->withRedirect($this->router->pathFor('home'));
       }
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
     return $response->withRedirect($this->router->pathFor('home'));

     $kolicina = $request->getParam('kolicina');
     $user = $this->auth->user();
     $gun = Shop::find(1);
     if($gun->add_wepons($user,$kolicina)){
       $this->flash->addMessage('info','Uspesno nadopolni gunovi');
       return $response->withRedirect($this->router->pathFor('home'));
     }
     $this->flash->addMessage('error','Neuspeso nemate dovolno pari');
     return $response->withRedirect($this->router->pathFor('home'));

//isto ke bide i za dodavanje na clan
    $me = $this->auth->user();
    $name = $request->getParam('name');
    $user = User::where('username',$name)->first();
    if($me->contact->isFriend($user)){
      if($user->contact->add($me)){
        $this->flash->addMessage('info','Isprati poraka za prijatelstvo na '.$user->username);
        return $response->withRedirect($this->router->pathFor('home'));
        }
    }else{
      $this->flash->addMessage('info','Veke ste prijateli');
      return $response->withRedirect($this->router->pathFor('home'));
    }
    $this->flash->addMessage('info','Neyspesno prakanje na poraka');
    return $response->withRedirect($this->router->pathFor('home'));


      $me = $this->auth->user();
      $name = $request->getParam('name');
      $user = User::where('username',$name)->first();
      if($me->contact->isFriend($user)){
        if($me->contact->confirm($user)){
          $this->flash->addMessage('info','Go prifati '.$user->username);
          return $response->withRedirect($this->router->pathFor('home'));
        }
      }else{
        $this->flash->addMessage('info','Veke ste prijateli');
        return $response->withRedirect($this->router->pathFor('home'));
      }
      $this->flash->addMessage('info','Neyspesno prifakanje');
      return $response->withRedirect($this->router->pathFor('home'));


        $car = Car::find(1);
        $user = $this->auth->user();
        if($user->energy->check($car->energija)){
        $num = $car->steal($user,$this->randomlib->generateInt(0, 100),$this->randomlib->generateInt(0, 5));
        switch ($num) {
         case 0:
           $this->flash->addMessage('info','Uspesno ja ukradovte kolata '.$car->title);
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
        }else{
        $this->flash->addMessage('info','Nemas dovolno energija');
        return $response->withRedirect($this->router->pathFor('home'));
        }

        //trkanje gotovo oop se
        $user = $this->auth->user();
        $car = Car::find(1);
        $num = $car->race(1,$user,$this->randomlib->generateInt(0, 100),$this->randomlib->generateInt(0, 5));
        switch ($num) {
         case 0:
           $this->flash->addMessage('info','Uspea so kolata '.$car->title);
           return $response->withRedirect($this->router->pathFor('home'));
           break;
         case 1:
           $this->flash->addMessage('info','Neuspea i ne te fana policija');
           return $response->withRedirect($this->router->pathFor('home'));
           break;
         case 2:
           $this->flash->addMessage('info','Neuspea i te fati policija i kolata otide');
           return $response->withRedirect($this->router->pathFor('home'));
           break;
         default:
           $this->flash->addMessage('info','Ima greska obidete se povtorno');
           return $response->withRedirect($this->router->pathFor('home'));
           break;
        }

     //banka e gotova so transakcii se
     $btn = $request->getParam('oke');
     $money = $request->getParam('pari');
     $user = $this->auth->user();
     $num = $user->bank->transfer($user,$money,'big',$btn);
    switch ($num) {
        case 1:
          $this->flash->addMessage('info','Nemas dovolno pari ili nemas pravo');
          return $response->withRedirect($this->router->pathFor('home'));
          break;
        case 2:
          $this->flash->addMessage('info','Limitot e dostignat');
          return $response->withRedirect($this->router->pathFor('home'));
          break;
        case 3:
          $this->flash->addMessage('info','Yspesno gi prenesovte parite');
          return $response->withRedirect($this->router->pathFor('home'));
          break;
        case 0:
          $this->flash->addMessage('info','Ima greska obidete se povtorno');
          return $response->withRedirect($this->router->pathFor('home'));
          break;
    }*/

  }

}
