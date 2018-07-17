<?php

namespace App\Models\User;
use Illuminate\Database\Eloquent\Model;

class MainProm Extends Model
{
	protected $table = "users_prom";

	protected $fillable = [
		'mok',
		'place',
		'pocit',
		'pari',
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

}
