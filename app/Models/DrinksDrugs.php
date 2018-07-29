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
		$user_zaliha = json_decode($user->inventory->{$this->type},true);
		if($user_zaliha[$this->id] + $kolicina <= $this->zaliha && $user->prom->hasMoney($this->price * $kolicina)){
			$user_zaliha[$this->id] += $kolicina;
			$user->prom->update(['pari' => $user->prom->pari - ($this->price * $kolicina)]);
			$user->inventory->update([$this->type => json_encode($user_zaliha) ]);
			return true;
		}
		return false;
	}

}
