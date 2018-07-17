<?php

namespace App\Models\User;
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
	public function energy()
	{
		return $this->hasOne('App\Models\User\Energy');
	}
	public function inventory()
	{
		return $this->hasOne('App\Models\User\Inventory');
	}
	public function contact()
	{
		return $this->hasOne('App\Models\User\Contact');
	}
	public function crime()
	{
		return $this->hasOne('App\Models\User\Crime');
	}
	public function bank()
	{
		return $this->hasOne('App\Models\User\Bank');
	}
	public function prom()
	{
		return $this->hasOne('App\Models\User\MainProm');
	}

	public function permissions()
	{
		return $this->hasOne('App\Models\User\UserPermission');
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
