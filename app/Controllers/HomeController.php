<?php

namespace App\Controllers;
use App\Models\User\User;
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
    /*//rabota is done osven tajmerot za kolky da ceka final
    $job = $request->getParam('rabota');
       $rabota = Rabota::find(1);
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


   //premestuvanje gradovi gotovo
    $grad = $request->getParam('grad');
      $user = $this->auth->user();
      $from = Drzava::where('name',$user->prom->place)->first();
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

/*
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
/*

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
         case 3:
           $this->flash->addMessage('info','Kolata ti e unistena');
           return $response->withRedirect($this->router->pathFor('home'));
           break;
         default:
           $this->flash->addMessage('info','Ima greska obidete se povtorno');
           return $response->withRedirect($this->router->pathFor('home'));
           break;
        }
/*
     //banka e gotova so transakcii se
     $btn = $request->getParam('oke');
     $money = $request->getParam('pari');
     $user = $this->auth->user();
     $num = $user->bank->transfer($user,$money,'drzavna',$btn);
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
        case 4:
          $this->flash->addMessage('info','Nemas dovolno pari vo banka');
          return $response->withRedirect($this->router->pathFor('home'));
          break;
        case 0:
          $this->flash->addMessage('info','Ima greska obidete se povtorno');
          return $response->withRedirect($this->router->pathFor('home'));
          break;
    }
*//*

     $sofer = $request->getParam('sofer');
     $hitmen = $request->getParam('hitmen');
     $pari = $request->getParam('pari');
     $user = $this->auth->user();
     $user1 = User::where('username',$sofer)->first();
     $user2 = User::where('username',$hitmen)->first();
     if(!$user->contact->isFriend($user1)){
          $crimes = json_decode($user->contact->crime_pending,true);
          if($crimes[$user->id] == null){
            $crimes[$user->id] = 'sofer';
            $user1->contact->update(['crime_pending' => json_encode($crimes)]);
          }else{
            $this->flash->addMessage('info','go godadovte za kriminal '.$user1->username);
          }

     }
     if(!$user->contact->isFriend($user2)){
          $crimes = json_decode($user->contact->crime_pending,true);
          if($crimes[$user->id] == null){
            $crimes[$user->id] = 'hitmen';
            $user2->contact->update(['crime_pending' => json_encode($crimes)]);
          }else{
            $this->flash->addMessage('info','go godadovte za kriminal'.$user2->username);
          }
     }
    $user->crime()->create([
     'type'    => 'kill',
     'sofer'       =>'{"accept":0,"id":'.$user1->id.',"car":""}',
     'hitmen'      => '{"accept":0,"id":'.$user2->id.',"guns":""}',
     'invest'         => $pari
     ]);
       return $response->withRedirect($this->router->pathFor('home'));

   //za prifakanje e gotovo osnovno samo
      $user = $this->auth->user();
      $crimes = json_decode($user->contact->crime_pending,true);
      foreach ($crimes as $key => $value) {
        if($key == 1){//1 e id na userot koj ima prateno za kriminal
            $user1 = User::find(1);
            $vals = json_decode($user1->crime->{$value},true);
            $vals['accept'] = 1;
            if($value == "sofer"){
              $cars =  json_decode($user->inventory->cars,true);
              $car = explode('_', $cars[1]);
              $vals['car'] = '1_'.$car[1];//eden e id na kolata a drugiot e koj broj na kola steta
              $user1->crime->update([$value => json_encode($vals,true)]);
              $user->inventory->removeCar(1,1);
              unset($crimes[$key]);
              break;
            }else{
              //zavisi koe go odbira
                $weapons =  json_decode($user->inventory->weapons,true);
                if($weapons[1]>=1 && $weapons[2]>=2){//ako ima poveke puski od 4
                   $weapons[1]--;
                   $weapons[2] -= 2;
                   $vals['guns'] = 5;
                   $user1->crime->update([$value => json_encode($vals,true)]);
                   $user->inventory->update(['weapons'=>json_encode($weapons,true)]);
                   unset($crimes[$key]);
                   break;
                }

            }
        }
      }
      $user->contact->update(['crime_pending'=>json_encode($crimes,true)]);
      return $response->withRedirect($this->router->pathFor('home'));*/
       //ima nedostatoci ama okej e
      $user = $this->auth->user();
      if($user->crime->accepted('sofer')&&$user->crime->accepted('hitmen')){
        $sofer = User::find($user->crime->prom('sofer','id'));
        $hitmen = User::find($user->crime->prom('hitmen','id'));
        if($user->prom->points >=10 && $sofer->prom->points >=10 && $hitmen->prom->points >=10){
          $chance =$this->randomlib->generateInt(0, 100);
          $car = explode("_",$user->crime->prom('sofer','car'));
          $first =(($car[0]-1) * 2) + 20 + $user->crime->prom('hitmen','guns');
            switch (true) {
              case $chance <= $first:
                  $user->prom->update(['pari'=> $user->prom->pari + $user->crime->invest * 2 ]);
                  $sofer->prom->update(['pari'=>$sofer->prom->pari  +$user->crime->invest / 2 ]);
                  $sofer->inventory->addCar($car[0],$car[1]);
                  $hitmen->prom->update(['pari'=> $hitmen->prom->pari +$user->crime->invest / 2 ]);
                  //za hitmen treba rabota dopolnitelna
                  $user->crime->delete();
                  $this->flash->addMessage('info','Uspeavte');
                  return $response->withRedirect($this->router->pathFor('home'));
                break;
              case $chance > $first   &&  $chance <= $first + 15 + $user->crime->prom('hitmen','guns') :
                  $this->flash->addMessage('info','Ve fanaa');
                  return $response->withRedirect($this->router->pathFor('home'));
                break;
              default:
                $this->flash->addMessage('info','Neuspeavte no ne ve fanaa');
                return $response->withRedirect($this->router->pathFor('home'));
                break;
            }

        }
        $this->flash->addMessage('info','Imaat prifanato spremni za napad');
        return $response->withRedirect($this->router->pathFor('home'));
      }
  }

}
