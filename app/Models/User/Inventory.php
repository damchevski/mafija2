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
		'drinks' => "{'Пиво':0,'Ракија':0}",
		'drugs' => "{'Кокаин':0,'Марихуана':0}",
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
	public function zaliha($type,$id)
	{
		return json_decode($this->{$type},true)[$id];
	}
	public function chance($type,$id)
	{
		return explode('_', $this->crime_chance)[$id-1];
	}
}
