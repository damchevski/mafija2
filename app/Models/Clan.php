<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Clan Extends Model
{
	protected $table = "clans";

	protected $fillable = [
		'owner',
		'moto',
    'name',
    'members',
    'members_ids',
		'pending_members',
    "mok",
    "pari"
	];


}
