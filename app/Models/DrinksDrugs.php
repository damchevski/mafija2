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
		if($user_zaliha[$this->title] + $kolicina <= $this->zaliha && $user->mainProm->hasMoney($this->price * $kolicina)){
			$user_zaliha[$this->title] += $kolicina;
			$user->mainProm->update(['pari' => $user->mainProm->pari - ($this->price * $kolicina)]);
			$user->inventory->update([$this->type => json_encode($user_zaliha) ]);
			return true;
		}
		return false;
	}

}
