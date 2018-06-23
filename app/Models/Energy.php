<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Energy Extends Model
{
	protected $table = "energy_status";

	protected $fillable = [
		'energija',
    'status'
	];

}
