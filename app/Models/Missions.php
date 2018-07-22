<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Missions Extends Model
{
	protected $table = "missions";

	protected $fillable = [
		'type',
		'rank',
		'title',
		'description',
		'price',
		'requirements'
	];
	//terba da se napravi opp za poveke opcii
	public function checkMissions($user)
	{
			$missions_ids = explode('_', $user->inventory->finished_missions);

			for ($id=1; $id <= Missions::count() ; $id++) {
				if(!in_array((string)$id, $missions_ids)){
				$missions = Missions::where('id',$id)->first();
				$requirements = json_decode($missions->requirements,true);
				$prices = json_decode($missions->price,true);
				$i = 0;
				foreach ($requirements as $key=>$value) {
					//tuka
				if($value <= $user->prom->{$key}){
					$i++;
				}
				}
				if($i == sizeof($requirements)){
					foreach ($prices as $key => $value) {
						$user->prom->update([ $key => 	$user->prom->{$key} + $value ]);
					}
					$user->inventory->update(['finished_missions' => $user->inventory->finished_missions.$missions->id.'_']);
				}
			}
			}
	}

}
