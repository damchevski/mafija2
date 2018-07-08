<?php

namespace App\Models\User;
use Illuminate\Database\Eloquent\Model;


class Inventory Extends Model
{
	protected $table = "users_inventories";

	protected $fillable = [
		'drinks',
		'drugs',
    'finished_missions',
		'weapons',
    'crime_chance',
		'cars',
		'car_chance'
	];
	public static $defaults=[
		'drinks' => "{'pivo':0,'rakija':0}",
		'drugs' => "{'kokain':0,'marihuana':0}",
		'finished_missions' => "",
		'weapons' => "",
		'crime_chance' => "0_0_0"
	];
	public function removeCar($car_id,$id)
	{
		$cars = json_decode($this->cars,true);
		$car = explode('_', $cars[$car_id]);
		$car[0]--;
		unset($car[$id]);
		$cars[$car_id]= (string)implode('_', $car);
		if($this->update(['cars' => json_encode($cars)])){
			return true;
		}
		return false;
 }
 public function addCar($car_id,$dmg)
 {
	 $cars = json_decode($this->cars,true);
	 $car = explode('_', $cars[$car_id]);
	 $car[0]++;
	 array_push($car,$dmg);
	 $cars[$car_id]= (string)implode('_', $car);
	 if($this->update(['cars' => json_encode($cars)])){
		 return true;
	 }
	 return false;
}

}
