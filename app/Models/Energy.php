<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Energy Extends Model
{
	protected $table = "energy_status";

	protected $fillable = [
		'energija',
    'status'
	];
	public static $defaults=[
		'energija' => 20,
		'status' => 0
	];
	public function calculateEnergy(){
		if($this->energija <=100){
			 //razlika vo sekundi za vreminja
			 $difference_in_seconds = strtotime(Carbon::now()) - strtotime($this->updated_at);
			 $addEnergija = $difference_in_seconds / 10;//na kolku sekundi se polni eden poen
			 if($this->energija + $addEnergija < 100){
					$this->update(['energija' => $this->energija + $addEnergija ]);
			 }else {
					$this->update(['energija' => 100 ]);
			 }
		}
	}

}
