<?php

namespace App\Controllers;
use App\Models\User\User;
use App\Models\Missions;
use App\Models\Rabota;
use App\Models\Drzava;
use App\Models\Clan;
use App\Models\Shop;
use App\Models\Car;
use App\Models\DrinksDrugs;


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
      /*

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
        return $response->withRedirect($this->router->pathFor('home'));
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
        }*/
  }

  public function getRabota($request, $response)
  {
    $id = $request->getParam('id');
    $rabota = Rabota::find($id);
    $user = $this->auth->user();
    if($user->prom->rank >= $rabota->rank){
    if($user->task->add($rabota->time)){
      if($user->energy->check($rabota->energija)){
       if($rabota->calculate($user,$this->randomlib->generateInt(0, 100))){
          $this->flashres->addMessage('success','Rabotata e uspesna.');
          echo "<input type='hidden' value='$rabota->time'>";
          return $this->view->render($response, '/templates/partials/flash.twig');
        }
      }else{
      $this->flashres->addMessage('error','Nemas dovolno energija.');
      echo "<input type='hidden' value='1'>";
      return $this->view->render($response, '/templates/partials/flash.twig');
    }
    }}
    $this->flashres->addMessage('error','Rabotata e neuspesna.');
    echo "<input type='hidden' value='$rabota->time'>";
    return $this->view->render($response, '/templates/partials/flash.twig');

  }
  public function getCrime($request, $response)
  {
    $id = $request->getParam('id');
    $crime = Rabota::find($id);
    $user = $this->auth->user();
    if($user->prom->rank >= $crime->rank){
    if($user->task->add($crime->time)){
      if($user->energy->check($crime->energija)){
        $num = $crime->crime($user,$this->randomlib->generateInt(0, 100));
        switch ($num) {
          case 0:
            $this->flashres->addMessage('success','Kriminalot e uspesen.');
            echo "<input type='hidden' value='$crime->time'>";
            return $this->view->render($response, '/templates/partials/flash.twig');
            break;
          case 1:
            $this->flashres->addMessage('info','Kriminalot e neuspesen i ne te fati policija');
            echo "<input type='hidden' value='$crime->time'>";
            return $this->view->render($response, '/templates/partials/flash.twig');
            break;
          case 2:
            $this->flashres->addMessage('error','Kriminalot e neuspesen i  te fati policija');
            echo "<input type='hidden' value='$crime->time'>";
            return $this->view->render($response, '/templates/partials/flash.twig');
            break;
        }
      }else{
        $this->flashres->addMessage('error','Nemas dovolno energija');
        echo "<input type='hidden' value='1'>";
        return $this->view->render($response, '/templates/partials/flash.twig');
      }
    }}
    $this->flashres->addMessage('error','Kriminalot e neuspesen.');
    echo "<input type='hidden' value='1'>";
    return $this->view->render($response, '/templates/partials/flash.twig');
  }
  public function getDrinksDrugs($request, $response)
  {
    $id = $request->getParam('id');
    $kolicina = $request->getParam('kolicina');
    $user = $this->auth->user();
    $drink = DrinksDrugs::find($id);
    $kolicina -= $user->inventory->zaliha($drink->type,$drink->id);
    if($drink->add($user,$kolicina)){
     $this->flashres->addMessage('info','Uspesno nadopolni '.$drink->title);
     return $this->view->render($response, '/templates/partials/flash.twig');
    }
    $this->flashres->addMessage('info','Neuspeso nemate dovolno pari ili go postignavte limitot');
    return $this->view->render($response, '/templates/partials/flash.twig');
  }
  public function getCar($request, $response)
  {
    $id = $request->getParam('id');
    $car = Car::find($id);
    $user = $this->auth->user();
    if($user->task->add($car->time)){
      if($user->energy->check($car->energija)){
      $num = $car->steal($user,$this->randomlib->generateInt(0, 100),$this->randomlib->generateInt(0, 5));
      switch ($num) {
       case 0:
          $this->flashres->addMessage('success','Uspesno ja ukradovte kolata '.$car->title);
          echo "<input type='hidden' value='$car->time'>";
          return $this->view->render($response, '/templates/partials/flash.twig');
         break;
       case 1:
          $this->flashres->addMessage('info','Kriminalot e neuspesen i ne te fati policija');
          echo "<input type='hidden' value='$car->time'>";
          return $this->view->render($response, '/templates/partials/flash.twig');
         break;
       case 2:
          $this->flashres->addMessage('error','Kriminalot e neuspesen i  te fati policija');
          echo "<input type='hidden' value='$car->time'>";
          return $this->view->render($response, '/templates/partials/flash.twig');
         break;
      }
      }else{
        $this->flashres->addMessage('error','Nemas dovolno energija');
        echo "<input type='hidden' value='1'>";
        return $this->view->render($response, '/templates/partials/flash.twig');
      }
    }
    $this->flashres->addMessage('error','Error');
    echo "<input type='hidden' value='1'>";
    return $this->view->render($response, '/templates/partials/flash.twig');
  }
  public function getRace($request, $response)
  {
    $id = explode('_',$request->getParam('id'));
    $user = $this->auth->user();
    $car = Car::find($id[0]);
    if($user->task->add(90)){
      $num = $car->race($id[1],$user,$this->randomlib->generateInt(0, 100),$this->randomlib->generateInt(0, 5));
      switch ($num) {
        case 0:
          $this->flashres->addMessage('success','Uspea so kolata'.$car->title);
          echo "<input type='hidden' value='90'>";
          return $this->view->render($response, '/templates/partials/flash.twig');
        break;
        case 1:
          $this->flashres->addMessage('info','Neuspea i ne te fana policija');
          echo "<input type='hidden' value='90'>";
          return $this->view->render($response, '/templates/partials/flash.twig');
        break;
        case 2:
          $this->flashres->addMessage('info','Neuspea i te fati policija i kolata otide');
          echo "<input type='hidden' value='90'>";
          return $this->view->render($response, '/templates/partials/flash.twig');
        break;
        case 3:
          $this->flashres->addMessage('error','Kolata ti e unistena');
          echo "<input type='hidden' value='1'>";
          return $this->view->render($response, '/templates/partials/flash.twig');
        break;
        default:
          $this->flashres->addMessage('error','Ima greska obidete se povtorno');
          echo "<input type='hidden' value='1'>";
          return $this->view->render($response, '/templates/partials/flash.twig');
        break;
      }
    }
  }
  public function getTravel($request, $response)
  {
    $grad = $request->getParam('place');
    $user = $this->auth->user();
    if($user->task->add(180)){
    $from = Drzava::where('name',$user->prom->place)->first();
    $next = Drzava::where('name',$grad)->first();
    if($from->travel($user,$next)){
      $this->flashres->addMessage('success','Ke letate pocekajte 3 minuti');
      echo "<input type='hidden' value='180'>";
      return $this->view->render($response, '/templates/partials/flash.twig');
    }
    $this->flashres->addMessage('error','Neuspesno obidete se povtorno');
    echo "<input type='hidden' value='1'>";
    return $this->view->render($response, '/templates/partials/flash.twig');
    }
  }
  public function getBank($request, $response)
  {
    $user = $this->auth->user();
    $name = trim($request->getParam('name'));

    $money =(int)$request->getParam('kolicina');
    if($money >  $user->bank->stuff($name,'pari')){
      $money -= $user->bank->stuff($name,'pari');
      $btn = 'add';
    }else{
      $btn = 'retrive';
      $money = $user->bank->stuff($name,'pari') - $money;
    }

    $num = $user->bank->transfer($user,$money,$name,$btn);
   switch ($num) {
       case 1:
         $this->flashres->addMessage('info','Nemas dovolno pari ili nemas pravo');
         return $this->view->render($response, '/templates/partials/flash.twig');
         break;
       case 2:
         $this->flashres->addMessage('info','Limitot e dostignat');
         return $this->view->render($response, '/templates/partials/flash.twig');
         break;
       case 3:
         $this->flashres->addMessage('info','Yspesno gi prenesovte parite');
         return $this->view->render($response, '/templates/partials/flash.twig');
         break;
       case 4:
         $this->flashres->addMessage('info','Nemas dovolno pari vo banka');
         return $this->view->render($response, '/templates/partials/flash.twig');
         break;
       case 0:
         $this->flashres->addMessage('info','Ima greska obidete se povtorno');
         return $this->view->render($response, '/templates/partials/flash.twig');
         break;
   }
  }
 public function getShop($request, $response)
 {
   $id = $request->getParam('id');
   $kolicina = $request->getParam('kolicina');
   $user = $this->auth->user();
   $gun = Shop::find($id);
   if($gun->add_wepons($user,$kolicina)){
     $this->flashres->addMessage('success','Uspesno nadopolni gunovi');
     return $this->view->render($response, '/templates/partials/flash.twig');
   }
   $this->flashres->addMessage('error','Neuspeso nemate dovolno pari');
   return $this->view->render($response, '/templates/partials/flash.twig');
 }
 public function getAddFriend($request, $response)
 {
   $username = $request->getParam('username');
   $me = $this->auth->user();
   $user = User::where('username',trim($username))->first();
   if(!$me->contact->isFriend($user->id)){
     if($user->contact->add($me->id)){
       $this->flashres->addMessage('success','Isprati poraka za prijatelstvo na '.$user->username);
       return $this->view->render($response, '/templates/partials/flash.twig');
     }
     $this->flashres->addMessage('error','Veke imas prateno poraka za prijatelstvo');
     return $this->view->render($response, '/templates/partials/flash.twig');
   }else{
     $this->flashres->addMessage('info','Veke ste prijateli so '.$user->username);
     return $this->view->render($response, '/templates/partials/flash.twig');
   }
   $this->flashres->addMessage('error','Neyspesno prakanje na poraka');
   return $this->view->render($response, '/templates/partials/flash.twig');
  }
  public function getConfirmFriend($request, $response)
  {
    $username = $request->getParam('username');
    $me = $this->auth->user();
    $user = User::where('username',trim($username))->first();
    if(!$me->contact->isFriend($user->id)){
      if($me->contact->confirm($user)){
        $this->flashres->addMessage('success','Go prifati '.$user->username);
        return $this->view->render($response, '/templates/partials/flash.twig');
      }
    }else{
      $this->flashres->addMessage('info','Veke ste prijateli');
       return $this->view->render($response, '/templates/partials/flash.twig');
    }
    $this->flashres->addMessage('error','Neyspesno prifakanje');
     return $this->view->render($response, '/templates/partials/flash.twig');
  }
  public function getDeleteFriend($request, $response)
  {
    $username = $request->getParam('username');
    $me = $this->auth->user();
    $user = User::where('username',trim($username))->first();
    if($me->contact->isFriend($user->id)){
      if($me->contact->remove($user)){
        $this->flashres->addMessage('success','Go delitna '.$user->username);
        return $this->view->render($response, '/templates/partials/flash.twig');
      }
    }else{
      $this->flashres->addMessage('info','Ne ste prijateli');
       return $this->view->render($response, '/templates/partials/flash.twig');
    }
    $this->flashres->addMessage('error','Neyspesno deleteiranje');
     return $this->view->render($response, '/templates/partials/flash.twig');
  }
}
