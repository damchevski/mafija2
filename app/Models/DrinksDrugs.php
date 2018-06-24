<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class DrinksDrugs Extends Model
{
	protected $table = "drinks_drugs";

	protected $fillable = [
		'type',
		'rank',
		'title',
		'description',
		'price',
		'zaliha'
	];

}
