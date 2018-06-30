<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MainProm Extends Model
{
	protected $table = "main_prom";

	protected $fillable = [
		'mok',
		'pocit',
		'pari',
		'iskustvo',
		'ubistva',
		'finished_missions',
		'drinks_zaliha',
		'drugs_zaliha',
		'crime_chance',
		'atack_points',
		'atack_wins',
    'atack_loses'
	];
	public static $defaults=[
    'mok' => 0,
		'pocit' => 0,
		'pari' => 0,
		'ubistva' => 0,
		'finished_missions' => 0,
		'atack_points' => 0,
		'atack_wins' => 0,
		'atack_loses' => 0
  ];

}
