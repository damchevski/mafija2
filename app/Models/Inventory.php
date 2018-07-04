<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Inventory Extends Model
{
	protected $table = "users_inventories";

	protected $fillable = [
		'drinks',
		'drugs',
    'finished_missions',
    'crime_chance'
	];
	public static $defaults=[
		'drinks' => "{'pivo':0,'rakija':0}",
		'drugs' => "{'kokain':0,'marihuana':0}",
		'finished_missions' => "",
		'crime_chance' => "0_0_0"
	];


}
