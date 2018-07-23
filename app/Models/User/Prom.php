<?php

namespace App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Prom Extends Model
{
	protected $table = "users_prom";

	protected $fillable = [
		'mok',
		'place',
		'pocit',
		'pari',
		'rank',
		'iskustvo',
		'ubistva',
		'friends',
		'pending',
		'points',
		'atack_wins',
    'atack_loses'
	];
	public static $defaults=[
    'mok' => 0,
		'pocit' => 0,
		'pari' => 0,
		'ubistva' => 0,
		'points' => 0,
		'atack_wins' => 0,
		'atack_loses' => 0
  ];
	public function hasMoney($val){
		return ($this->pari >= $val ? true:false);
	}
	public function updateRank()
	{
		$i = $this->iskustvo;
		switch (true) {
			case $i >= 0 && $i <= 2200:
				$this->update(['rank'=>1]);
				break;
			case $i > 2200 && $i <= 5000:
				$this->update(['rank'=>2]);
				break;
			case $i > 5000 && $i <= 9000:
				$this->update(['rank'=>3]);
				break;
			case $i > 9000 && $i <= 14500:
				$this->update(['rank'=>4]);
				break;
			case $i > 14500 && $i <= 21500:
				$this->update(['rank'=>5]);
				break;
			case $i > 21500 && $i <= 30000:
				$this->update(['rank'=>6]);
				break;
			case $i > 30000 && $i <= 40000:
				$this->update(['rank'=>7]);
				break;
			case $i > 40000 && $i <= 54500:
				$this->update(['rank'=>8]);
				break;
			case $i > 54500 && $i <= 72000:
				$this->update(['rank'=>9]);
				break;
			case $i > 72000:
				$this->update(['rank'=>10]);
				break;
		}
	}

}
