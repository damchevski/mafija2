<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Shop Extends Model
{
	protected $table = "shop";

	protected $fillable = [
		'type',
		'rank',
		'title',
		'description',
		'price',
    'reward'
	];
	public function add_wepons($user,$kolicina)
	{
		$user_zaliha = json_decode($user->inventory->{$this->type},true);
		if($user->mainProm->hasMoney($this->price * $kolicina)){
			$user_zaliha[$this->id] += $kolicina;
			$user->mainProm->update(['pari' => $user->mainProm->pari - ($this->price * $kolicina)]);
			$rewards = json_decode($this->reward,true);
			foreach ($rewards as $key => $value) {
			 $user->mainProm->update([ $key => $user->mainProm->{$key} + $value ]);
			}
			$user->inventory->update([$this->type => json_encode($user_zaliha) ]);
			return true;
		}
		return false;
	}
}
