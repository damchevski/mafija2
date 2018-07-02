<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Drzava Extends Model
{
	protected $table = "drzavi";

	protected $fillable = [
		'name',
		'relacii',
	];
  public function travel($user,$destination)
  {
    if($this->id < $destination->id){
      $relacii = json_decode($this->relacii,true);
      foreach ($relacii as $key => $value) {
        if(strpos($key, $destination->name)){
          if($user->mainProm->hasMoney($value * 5)){
            $user->mainProm->update([ 'pari' => $user->mainProm->pari - $value * 5]);
            $user->mainProm->update([ 'place' => $destination->name]);
            return true;
          }
        }
      }
    }else{
      $relacii = json_decode($destination->relacii,true);
      foreach ($relacii as $key => $value) {
        if(strpos($key, $this->name)){
          if($user->mainProm->hasMoney($value * 5)){
            $user->mainProm->update([ 'pari' => $user->mainProm->pari - $value * 5]);
            $user->mainProm->update([ 'place' => $destination->name]);
            return true;
          }
        }
      }
    }
   return false;
  }

}
