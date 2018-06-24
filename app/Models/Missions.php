<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\MainProm;
use App\Models\User;


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
	public function checkMissions($user , $prom)
	{
			//user => glavniot
			//prom => negovi promenlivi
			$missions_ids = explode('_', $prom->finished_missions);

			for ($id=0; $id < Missions::count() ; $id++) {
				if(!in_array((string)$id, $missions_ids)){

				$missions = Missions::where('id',$id)->first();
				$requirements = json_decode($missions->requirements,true);
				$prices = json_decode($missions->price,true);
				$i = 0;
				foreach ($requirements as $key=>$value) {
					//tuka
				if($value <= $prom->{$key}){
					$i++;
				}
				}
				if($i == sizeof($requirements)){
					foreach ($prices as $key => $value) {
						$prom->update([ $key => $prom->{$key} + $value ]);
					}
					$prom->update(['finished_missions' => $prom->finished_missions.$missions->id.'_']);
				}
			}
			}
	}

}
