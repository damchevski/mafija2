<?php

namespace App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Clan;

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
	public function task()
	{
		return $this->hasOne('App\Models\User\Task');
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
		return $this->hasOne('App\Models\User\Prom');
	}

	public function permissions()
	{
		return $this->hasOne('App\Models\User\UserPermission');
	}
	function get_gravatar( $email, $s = 92, $d = 'mp', $r = 'g', $img = false, $atts = array() ) {
    $url = 'https://www.gravatar.com/avatar/';
    $url .= md5( strtolower( trim( $email ) ) );
    $url .= "?s=$s&d=$d&r=$r";
    if ( $img ) {
        $url = '<img src="' . $url . '"';
        foreach ( $atts as $key => $val )
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
  }
	public function displayStatus($val)
	{
		switch ($val) {
			case 0:
				return "background:var(--red)";
			case 1:
		  	return "background:var(--green)";
			case 2:
				return "background:var(--yellow)";
			default:
				return "background:var(--gray-dark)";
		}
	}
	public function getClans()
	{
	  return Clan::limit(5)->get();
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
