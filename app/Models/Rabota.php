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


}
