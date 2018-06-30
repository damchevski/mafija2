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
    //rabota is done osven tajmerot za kolky da ceka final
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
          $sansi = $this->randomlib->generateInt(0, 100);
          if($sansi <= $crime_chances[$rabota->id-2]){
            foreach ($prices as $key => $value) {
              if(!is_numeric($value)){
                if($key == "crime_chance"){
                    $values = explode('_', $value);
                    //dodava na sansata dobivkata
                  if($crime_chances[$rabota->id-2] + $values[0] <100){
                  $crime_chances[$rabota->id-2] += $values[0];
                  $val = (string) implode("_", $crime_chances);

                  $user->mainProm->update([ $key => $val ]);
                }
                }else{
                  $values = explode('_', $value);
                  $user->mainProm->update([ $key => $user->mainProm->{$key} + $values[0]]);
                }
              }else{

              $user->mainProm->update([ $key => $user->mainProm->{$key} + $value ]);
               }
            }
            $user->energy->update([ 'energija' => $user->energy->energija - $rabota->energija ]);
            $this->flash->addMessage('info','Kriminalot e uspesen. Pocekajte '.$rabota->complete_time.' sekundi');
            return $response->withRedirect($this->router->pathFor('home'));

          }else if ($sansi > $crime_chances[$rabota->id-2] && $sansi <= $crime_chances[$rabota->id-2] + 20 ) {
            $prices = json_decode($rabota->price,true);
            $crime_chances = explode('_', $user->mainProm->crime_chance);
            $values = explode('_', $prices["crime_chance"]);
              if($crime_chances[$rabota->id-2] + $values[0] <100){
            $crime_chances[$rabota->id-2] += $values[1];
            $val = (string) implode("_", $crime_chances);
            $user->mainProm->update([ "crime_chance" => $val ]);
            }
            $this->flash->addMessage('info','Kriminalot e neuspesen i ne te fati policija');
            return $response->withRedirect($this->router->pathFor('home'));
          }else{
            $prices = json_decode($rabota->price,true);
           	$crime_chances = explode('_', $user->mainProm->crime_chance);
            $values = explode('_', $prices["crime_chance"]);
            if($crime_chances[$rabota->id-2] + $values[0] <100){
            $crime_chances[$rabota->id-2] += $values[2];
            $val = (string) implode("_", $crime_chances);
            $user->mainProm->update([ "crime_chance" => $val ]);
          }
            $this->flash->addMessage('info','Kriminalot e neuspesen i  te fati policija');
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
