<?php

namespace App\Controllers;
use App\Models\Rabota;
use App\Models\DrinksDrugs;
use App\Models\Car;

class AjaxController extends Controller
{
  public function getStatus($request, $response)
  {
      $val = $request->getParam('val');
      $user = $this->auth->user();
      $user->energy->update(['status' => $val ]);
  }
  public function getValidation($request, $response)
  {
    $type = $request->getParam('type');
    $val = $request->getParam('val');
    $password = $request->getParam('password');
    switch ($type) {
      case 'username':
      $v = $this->Validator->validate(['username' => [$val,'required|alnumDash|max(50)|min(4)|uniqueUsername'] ]);
      break;

      case 'email':
      $v = $this->Validator->validate(['email' => [$val,'required|max(100)|email|uniqueEmail'] ]);
      break;

      case 'password':
      $v = $this->Validator->validate(['password' => [$val,'required|min(8)|alnumDash'] ]);
      break;

      case 'password_confirm':
      $v = $this->Validator->validate([
        'password' => [$password,'required'],
        'password_confirm' => [$val,'required|matches(password)'] ]);
      break;
    }
    return ($v->passes() ? 'true':$v->errors()->first());
  }

  public function getRabota($request, $response)
  {
    $type = $request->getParam('type');
    $raboti = Rabota::where('type',$type)->get();
    foreach ($raboti as $id=>$rabota) {
      $html = "<div class='card bg-light'>
      <div class='card-body'>
      <h4 class='card-title'> ".$rabota->title."</h4> ";
          $html.= "<div class='row'>
            <div class='col'>
           <span id='dolg'> Sansi na uspees: ".$rabota->chance." </span>  </div>
            <div class='col'>
              </svg> <span id='dolg'> Energija potrebno: ".$rabota->energija."</span>  </div>
            <div class='col'>
             <span id='dolg'>Vreme na izvrsuvanje ".$rabota->complete_time." </span></div>
            </div>
            <span class='input-group-btn'>
               <button class='btn btn-secondary $rabota->type' type='button'>Raboti</button>
               </span>
            ";
         if($type == 'rabota'){$id +=3;}  $id++;
          $html .="  <input type='hidden' value='$id'> </div> </div>";

     echo $html;
    }
  }
  public function getDrinks($request, $response)
  {
    $type = $request->getParam('type');
    $drinks = DrinksDrugs::where('type',$type)->get();
    foreach ($drinks as $id=>$drink) {
      $html = "<div class='card bg-light''>
      <div class='card-body'>
      <h4 class='card-title'> ".$drink->title."</h4> ";
          $html.= "<div class='row'>
            <div class='col'>
           <span id='dolg'>Cena: ".$drink->price." </span>  </div>
            <div class='col'>
              </svg> <span id='dolg'>Zalixa: ".$drink->zaliha."</span>  </div>
            </div>
            <div class='row'>
              <div class='col'>
             <span id='dolg'>".$drink->description." </span></div>
            </div>
            <input type='number' name='kolicina'>
            <span class='input-group-btn'>
              <button class='btn btn-secondary add' type='button'>Dodadi</button>
            </span>
            ";
         if($type == 'drinks'){$id +=8;}  $id++;
          $html .=" <input type='hidden' value='$id'> </div> </div>";

     echo $html;
    }
  }
  public function getCars($request, $response)
  {
    $cars = Car::all();
    foreach ($cars as $id=>$car) {
      $html = "<div class='card bg-light''>
      <div class='card-body'>
      <h4 class='card-title'> ".$car->title."</h4> ";
          $html.= "<div class='row'>
            <div class='col'>
           <span id='dolg'>Cena: ".$car->price." </span>  </div>
            <div class='col'>
              </svg> <span id='dolg'>Energija potrebno: ".$car->energija."</span>  </div>
            <div class='col'>
             <span id='dolg'>Brzina: ".$car->speed." </span></div>
             <div class='col'>
              <span id='dolg'>Moknost: ".$car->power." </span></div>
            </div>
            <span class='input-group-btn'>
              <button class='btn btn-secondary car' type='button'>Ukradi</button>
            </span>";
            $id++;
          $html .=" <input type='hidden' value='$id'> </div> </div>";

     echo $html;
    }
  }
  public function getTrki($request, $response)
  {
    $user = $this->auth->user();
    $carsIds = json_decode($user->inventory->cars,true);
    foreach ($carsIds as $id=>$val) {
        $car = Car::find($id);
        $dmg = explode('_', $val);
        for ($i=1; $i <= $dmg[0] ; $i++) {
          if($dmg[$i]>50){
          $html = "<div class='card bg-light''>
          <div class='card-body'>
          <h4 class='card-title'> ".$car->title."</h4> ";
              $html.= "<div class='row'>
                <div class='col'>
               <span id='dolg'>Cena: ".$car->price." </span>  </div>
                <div class='col'>
                  </svg> <span id='dolg'>Energija potrebno: ".$car->energija."</span>  </div>
                <div class='col'>
                 <span id='dolg'>Brzina: ".$car->speed." </span></div>
                 <div class='col'>
                  <span id='dolg'>Moknost: ".$car->power." </span></div>
                  <div class='col'>
                   <span id='dolg'>Steta: ".$dmg[$i]." </span></div>
                </div>
                <span class='input-group-btn'>
                  <button class='btn btn-secondary race' type='button'>Trkaj</button>
                </span>";

              $html .=" <input type='hidden' value='".$id."_".$i."'> </div> </div>";

         echo $html;
        }
      }
    }
  }
  public function getTravel($request, $response)
  {
    $html = "<div class='card bg-light''>
    <div class='card-body'>
    <h4 class='card-title'>Smeni mesto na ziveenje:</h4> ";
        $html.= "
             <select name='grad' style='margin-right:20px'>
                 <option value='MK'>Makegonija</option>
                   <option value='SR'>Srbija</option>
                     <option value='AL'>Alabanija</option>
                       <option value='BG'>Bugarija</option>
                         <option value='GR'>Germanija</option>
                           <option value='US'>Amerika</option>
                             <option value='IT'>Italija</option>
             </select>
          <span class='input-group-btn'>
            <button class='btn btn-secondary travel' type='button'>Patuvaj</button>
          </span>";

        $html .=" </div> </div>";

   echo $html;

  }
  public function getGaraza($request, $response)
  {
    $user = $this->auth->user();
    $carsIds = json_decode($user->inventory->cars,true);
    foreach ($carsIds as $id=>$val) {
        $car = Car::find($id);
        $dmg = explode('_', $val);
        for ($i=1; $i <= $dmg[0] ; $i++) {
          $html = "<div class='card bg-light''>
          <div class='card-body'>
          <h4 class='card-title'> ".$car->title."</h4> ";
              $html.= "<div class='row'>
                <div class='col'>
               <span id='dolg'>Cena: ".$car->price." </span>  </div>
                <div class='col'>
                  </svg> <span id='dolg'>Energija potrebno: ".$car->energija."</span>  </div>
                <div class='col'>
                 <span id='dolg'>Brzina: ".$car->speed." </span></div>
                 <div class='col'>
                  <span id='dolg'>Moknost: ".$car->power." </span></div>
                  <div class='col'>
                   <span id='dolg'>Steta: ".$dmg[$i]." </span></div>
                </div>";
              $html .=" <input type='hidden' value='".$id."_".$i."'> </div> </div>";
         echo $html;
      }
    }
  }


}
