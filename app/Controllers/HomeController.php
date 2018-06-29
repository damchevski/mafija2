<?php

namespace App\Controllers;
use App\Models\User;
use App\Models\Missions;
use App\Models\Rabota;

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
    //rabota is done osven tajmerot za kolky da ceka
    $job = $request->getParam('rabota');
     if($job == 'ok'){
       $rabota = Rabota::where('id',2)->first();
     if($rabota->type == 'rabota'){
         if( $this->randomlib->generateInt(0, 100) <= $rabota->chance){
            $user = $this->auth->user();
          	$prices = json_decode($rabota->price,true);

            if($user->energy->energija >= $rabota->energija){
                foreach ($prices as $key => $value) {
                  $user->mainProm->update([ $key => $user->mainProm->{$key} + $value ]);
                }
                $user->energy->update([ 'energija' => $user->energy->energija - $rabota->energija ]);

                $this->flash->addMessage('info','Rabotata e uspesna. Pocekajte '.$rabota->complete_time.' sekundi');
                return $response->withRedirect($this->router->pathFor('home'));
              }else{
                $this->flash->addMessage('info','Nemas dovolno energija');
                return $response->withRedirect($this->router->pathFor('home'));
              }
         }else{
           $this->flash->addMessage('info','Rabotata e neuspesna');
           return $response->withRedirect($this->router->pathFor('home'));
         }
     }else if($rabota->type == 'crime'){
       //kriminal opija da te fatat nema i tajmer
          $user = $this->auth->user();
       if( $user->energy->energija >= $rabota->energija){
          $prices = json_decode($rabota->price,true);
         	$crime_chances = explode('_', $user->mainProm->crime_chance);
          //treba ubavo da se stavat idta za criminal za bava spredba
          if($this->randomlib->generateInt(0, 100) <= (int)$crime_chances[$rabota->id-2]){
              foreach ($prices as $key => $value) {
                $user->mainProm->update([ $key => $user->mainProm->{$key} + $value ]);
              }
              $user->energy->update([ 'energija' => $user->energy->energija - $rabota->energija ]);

              $this->flash->addMessage('info','Kriminalot e uspesen. Pocekajte '.$rabota->complete_time.' sekundi');
              return $response->withRedirect($this->router->pathFor('home'));
            }else{
              $this->flash->addMessage('info','Kriminalot e neuspesen');
              return $response->withRedirect($this->router->pathFor('home'));
            }
       }else{
         $this->flash->addMessage('info','Nemas dovolno energija');
         return $response->withRedirect($this->router->pathFor('home'));
       }
     }

     }
  }

}
