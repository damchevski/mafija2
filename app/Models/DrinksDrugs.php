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
	public function add($user,$kolicina)
	{
		$user_zaliha = json_decode($user->mainProm->{$this->type.'_zaliha'},true);
		if($user_zaliha[$this->title] + $kolicina <= $this->zaliha){
			$user_zaliha[$this->title] += $kolicina;
			$user->mainProm->update(['pari' => $user->mainProm->pari - ($this->price * $kolicina)]);
			$user->mainProm->update([$this->type.'_zaliha' => json_encode($user_zaliha) ]);
			return true;
		}
		return false;
	}

}
