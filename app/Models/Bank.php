<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Bank Extends Model
{
	protected $table = "users_banks";

	protected $fillable = [
		'drzavna',
		'svetska',
    'small',
    'big'
	];
  public function hasPermission($bank)
  {
    return (bool)json_decode($this->{$bank},true)['permission'];
  }
  public function hasMoney($bank,$val){
		return (json_decode($this->{$bank},true)['pari'] >= $val ? true:false);
	}
  public function transfer($user,$money,$type,$operation)
  {
    if($user->bank->hasPermission($type) && $user->mainProm->hasMoney($money)){
        $bank =  json_decode($user->bank->{$type},true);
        if( ($type == "big" || $type == "small")){
          if($bank['limit'] <= $bank['pari'] + $money){ return 2;}
        }else{
           $bank['transakcii']--;
        }
        if($operation == "add"){
          $user->mainProm->pari -= $money;
          $bank['pari']+=$money;
        }else{
          $user->mainProm->pari += $money;
          $bank['pari']-=$money;
        }
        $user->bank->update([$type=> json_encode($bank,true)]);
        $user->mainProm->save();//za poubav kod
        return 3;
    }else{
      return 1;
    }
    return 0;
  }
}
