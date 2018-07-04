<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Rabota Extends Model
{
	protected $table = "raboti";

	protected $fillable = [
		'type',
		'rank',
		'title',
		'chance',
		'complete_time',
		'energija',
		'price'
	];
	public function calculate($user,$chance)
	{
		$user->energy->update([ 'energija' => $user->energy->energija - $this->energija ]);
		if($chance <= $this->chance){
       $prices = json_decode($this->price,true);
			 foreach ($prices as $key => $value) {
			 	$user->mainProm->update([ $key => $user->mainProm->{$key} + $value ]);
			 }
       return true;
		}
    return false;
	}
	public function crime($user,$chance)
	{
		$user->energy->update([ 'energija' => $user->energy->energija - $this->energija ]);
		$prices = json_decode($this->price,true);
		$crime_chances = explode('_', $user->inventory->crime_chance);
		//treba ubavo da se stavat idta za criminal za bava spredba
    switch (true) {
    	case $chance <= $crime_chances[$this->id-2]:
		  	$user->mainProm->update([ 'pari' => $user->mainProm->pari + $prices['pari'] ]);
    		$num = 0;
    		break;
			case $chance > $crime_chances[$this->id-2] && $chance <= $crime_chances[$this->id-2] + 20 :
				$num = 1;
				break;
    	default:
    		$num = 2;
    		break;
    }
		foreach ($prices as $key => $value) {
			if(!is_numeric($value)){
				if($key == "crime_chance"){
						$values = explode('_', $value);
						//dodava na sansata dobivkata
					if($crime_chances[$this->id-2] + $values[$num] <100){
					$crime_chances[$this->id-2] += $values[$num];
					$val = (string) implode("_", $crime_chances);
					$user->inventory->update([ $key => $val ]);
				}
				}else{
					$values = explode('_', $value);
					$user->mainProm->update([ $key => $user->mainProm->{$key} + $values[$num]]);
				}
			}
		}
		return $num;
	}

}
