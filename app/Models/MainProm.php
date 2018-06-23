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
		'ubistva',
		'atack_points',
		'atack_wins',
    'atack_loses'
	];

}
