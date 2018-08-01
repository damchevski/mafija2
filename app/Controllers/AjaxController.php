<?php

namespace App\Controllers;
use App\Models\Missions;
use App\Models\Rabota;
use App\Models\Drzava;
use App\Models\Clan;
use App\Models\Shop;
use App\Models\Car;
use App\Models\DrinksDrugs;
use App\Models\User\User;

class AjaxController extends Controller
{
  public function getSearch($request, $response)
  {
    $key = $request->getParam('key');
    if (isset($key) && !empty($key)){
      $user = $this->auth->user();
      $users = User::where('username','LIKE', $key.'%')->where('id','<>',$user->id)->limit(5)->get();
      if($users->count() > 0){
        echo"  <label for='people'>МАФИЈАШИ</label>
        <ul name='people' class='people'> ";
        foreach ($users as $val){
          echo "<li><img src='".$user->get_gravatar($val->email,40)."'><span>".$val->username."</span><span style='".$user->displayStatus($val->energy->status)."'></span> </li>";
        }
        echo"</ul>";
      }
      $clans = Clan::where('name','LIKE', $key.'%')->limit(5)->get();
        if($clans->count() > 0){
        echo"  <label for='clans'>ФАМИЛИИ</label>
        <ul name='clans' class='clans'> ";
        foreach ($clans as $id => $clan) {
        echo "<li><img src='".$user->get_gravatar($clan->email,40)."'><span>".$clan->name."</span><span style='background:var(--gray-dark)'></span> </li>";
        }
        echo"</ul>";
      }
    }
  }
  public function getStatus($request, $response)
  {
    $val = $request->getParam('val');
    $user = $this->auth->user();
    $user->prom->updateRank();
    $user->energy->update(['status' => $val ]);
  }
  public function getStats($request, $response)
  {
    $user = $this->auth->user();
    return"
      <li>Моќ: {$user->prom->mok}</li>
      <li>Почит: {$user->prom->pocit}</li>
      <li>Пари: {$user->prom->pari}</li>
      <li>Држава: {$user->prom->place}</li>
      <li>
        <div class='progress'>
          <div class='progress-bar  bg-warning' role='progressbar' style='width:{$user->energy->energija}%'>{$user->energy->energija}%
            <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill=' #ffc107'style='left:".($user->energy->energija - 10)."%'>
              <path d='M0 0h24v24H0z' fill='none'/>
              <path d='M7 2v11h3v9l7-12h-4l4-8z' stroke='#e9ecef'/>
            </svg>
          </div>
        </div>
      </li>
      <li>
        <div class='progress'>
          <div class='progress-bar bg-danger' role='progressbar' style='width:{$user->prom->health}%'>{$user->prom->health}%
            <svg version='1.1' id='Capa_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'
               viewBox='0 0 51.997 51.997' xml:space='preserve' fill='#dc3545' style='left:".($user->prom->health - 10)."%'>
            <path d='M51.911,16.242C51.152,7.888,45.239,1.827,37.839,1.827c-4.93,0-9.444,2.653-11.984,6.905
              c-2.517-4.307-6.846-6.906-11.697-6.906c-7.399,0-13.313,6.061-14.071,14.415c-0.06,0.369-0.306,2.311,0.442,5.478
              c1.078,4.568,3.568,8.723,7.199,12.013l18.115,16.439l18.426-16.438c3.631-3.291,6.121-7.445,7.199-12.014
              C52.216,18.553,51.97,16.611,51.911,16.242z' stroke='#e9ecef'/>
            </svg>
          </div>
        </div>
      </li>";
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
    if ($type == 'rabota') {
      $options = array(1=>'Ниско платени', 2=>'Просечно платени', 3=>'Високо платени', 4 =>'[none]',5=>'РАБОТИ');
    }else{
      $options = array(1=>'ПОЧЕТНИК', 2=>'ЗАВИСНИК', 3=>'ГУРУ', 4 =>'png',5=>'ИЗВРШИ');
    }
    $row1 = $row2 = $row3 = array();
    foreach ($raboti as $rabota) {
      switch (true) {
        case $rabota->rank >= 1 && $rabota->rank <=3:
          array_push($row1,$rabota);
          break;
        case $rabota->rank >= 4 && $rabota->rank <=7:
          array_push($row2,$rabota);
          break;
        case $rabota->rank >= 8 && $rabota->rank <=10:
          array_push($row3,$rabota);
          break;
      }
    }
    return $this->view->render($response, '/templates/cards/rabota.twig',[
      'row1'  => $row1,
      'row2'  => $row2,
      'row3'  => $row3,
      'x' => $options
    ]);
  }
  public function getDrinks($request, $response)
  {
    $type = $request->getParam('type');
    $drinks_drugs = DrinksDrugs::where('type',$type)->get();
    $options = array(1=>'[none]');
    $row1 = $row2 = $row3 = array();
    foreach ($drinks_drugs as $drink_drug) {
          array_push($row1,$drink_drug);
    }
    return $this->view->render($response, '/templates/cards/drinks_drugs.twig',[
      'row1'  => $row1,
      'row2'  => $row2,
      'row3'  => $row3,
      'x' => $options
    ]);
  }
  public function getCars($request, $response)
  {
    $cars = Car::all();
    $row1 = $row2 = $row3 = array();
    $options = array(1=>'Ниска класа', 2=>'Средна класа', 3=>'Висока класа',4=>'car',5=>"УКРАДИ");
    foreach ($cars as $car) {
      switch ($car->type) {
        case "middle":
          array_push($row1,$car);
          break;
        case "fast":
          array_push($row2,$car);
          break;
        case "top":
          array_push($row3,$car);
          break;
      }
    }
    return $this->view->render($response, '/templates/cards/cars.twig',[
      'row1'  => $row1,
      'row2'  => $row2,
      'row3'  => $row3,
      'x' => $options
    ]);
  }
  public function getTrki($request, $response)
  {
    $row1 = $row2 = $row3 = $car_id = array();
    $options = array(1=>'Ниска класа', 2=>'Средна класа', 3=>'Висока',4=>'race',5=>"ТРКАЈ СЕ",6=>true);
    $user = $this->auth->user();
    $carsIds = json_decode($user->inventory->cars,true);
    foreach ($carsIds as $id=>$val) {
        $car = Car::find($id);
        $dmg = explode('_', $val);
        for ($i=1; $i <= $dmg[0] ; $i++) {
          if($dmg[$i]>50){
            //ne e skros napraveno
            switch ($car->type) {
              case "middle":
                array_push($row1,$car);
                array_push($car_id,"$id"."_"."$i");
                break;
              case "fast":
                array_push($row2,$car);
                break;
              case "top":
                array_push($row3,$car);
                break;
            }

        }
      }
    }
    return $this->view->render($response, '/templates/cards/cars.twig',[
      'row1'  => $row1,
      'row2'  => $row2,
      'row3'  => $row3,
      'x' => $options,
      'car_id'=>$car_id
    ]);
  }
  public function getTravel($request, $response)
  {
    $html = "<div class='card bg-light''>
    <div class='card-body'>
    <h4 class='card-title'>Купи билет за патување во:</h4> ";
        $html.= "
             <select name='grad' style='margin-right:20px'>
                 <option value='MK'>Македонија</option>
                   <option value='SR'>Србија</option>
                     <option value='AL'>Албанија</option>
                       <option value='BG'>Бугарија</option>
                         <option value='GER'>Германија</option>
                           <option value='US'>САД</option>
                             <option value='IT'>Италија</option>
             </select>
          <span class='input-group-btn'>
            <button class='btn btn-secondary travel' type='button'>ПАТУВАЈ</button>
          </span>";

        $html .=" </div> </div>";

   echo $html;

  }
  public function getGaraza($request, $response)
  {
    $row1 = $row2 = $row3 = $car_id = array();
    $options = array(1=>'Ниска класа', 2=>'Средна класа', 3=>'Висока класа',4=>'sellCar',5=>"ПРОДАЈ",6=>true);
    $user = $this->auth->user();
    $carsIds = json_decode($user->inventory->cars,true);
    foreach ($carsIds as $id=>$val) {
      $car = Car::find($id);
      $dmg = explode('_', $val);
      for ($i=1; $i <= $dmg[0] ; $i++) {
        if($dmg[$i]>50){
          //ne e skros napraveno
          switch ($car->type) {
            case "middle":
              array_push($row1,$car);
              array_push($car_id,"$id"."_"."$i");
              break;
            case "fast":
              array_push($row2,$car);
              break;
            case "top":
              array_push($row3,$car);
              break;
          }
        }
      }
    }
    return $this->view->render($response, '/templates/cards/cars.twig',[
      'row1'  => $row1,
      'row2'  => $row2,
      'row3'  => $row3,
      'x' => $options,
      'car_id'=>$car_id
    ]);
  }
  public function getBank($request, $response)
  {
    $user = $this->auth->user();
    $name = array('drzavna','svetska','small','big');
    $title = array('ДРЖАВНА БАНКА','СВЕТСКА БАНКА','МАЛ СЕФ','ГОЛЕМ СЕФ');
    return $this->view->render($response, '/templates/cards/bank.twig',[
      'name'  => $name,
      'title' => $title
    ]);
  }
  public function getShop($request, $response)
  {
    $weapons = Shop::where('type','weapons')->get();
    $options = array(1=>'so da napravi');
    $row1 = $row2 = $row3 = array();
    foreach ($weapons as $weapon) {
          array_push($row1,$weapon);
    }
    return $this->view->render($response, '/templates/cards/shop.twig',[
      'row1'  => $row1,
      'row2'  => $row2,
      'row3'  => $row3,
      'x' => $options
    ]);
  }
  public function getCrime($request, $response)
  {
    $row1 = $row2 = $row3 = $options = array();
    return $this->view->render($response, '/templates/cards/crime.twig',[
      'row1'  => $row1,
      'row2'  => $row2,
      'row3'  => $row3,
      'x' => $options
    ]);
  }


}
