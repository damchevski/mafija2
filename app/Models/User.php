<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class User Extends Model
{
	protected $table = "users";

	protected $fillable = [
		'username',
		'name',
		'email',
		'password',
		'drzava',
		'pol',
		'active',
    'active_hash',
    'recover_hash',
    'remember_identifier',
    'remember_token'
	];
	public function updateEnergy()
	{
		return $this->hasMany('App\Models\Energy');
	}


	public function updateRememberCredentials($identifier, $token)
	{
		$this->update([
			'remember_identifier' => $identifier,
			'remember_token'      => $token
		]);
	}
	public function removeRememberCredentials(){
		$this->updateRememberCredentials(null, null);
	}
}
