<?php

namespace App\Models\User;
use Illuminate\Database\Eloquent\Model;


class Contact Extends Model
{
	protected $table = "users_contacts";

	protected $fillable = [
		'friends',
		'friends_ids',
		'friends_pending',
		'clan',
		'crime_pending',
		'blacklist'
	];
  public static $defaults=[
    'friends' => 0,
    'friends_ids' => '',
    'friends_pending' => '',
    'clan' => '',
    'blacklist' => ''
  ];
	public function add($user)
	{
		$ids = explode('_', $this->friends_pending);
		if(!in_array((string)$user->id, $ids)){
				$this->update(['friends_pending' => $user->id.'_']);
				return true;
		}
		return false;
	}
	public function confirm($user)
	{
		$ids = explode('_', $this->friends_pending);
		if(in_array((string)$user->id, $ids)){
			foreach ($ids as $key => $value) {
				if($value == $user->id){
					 unset($ids[$key]);
				}
			}
			$this->update(['friends_pending' => implode("_", $ids)]);
			$this->update(['friends_ids' => $user->id.'_']);
			$this->update(['friends' => $this->friends + 1]);
			$user->contact->update(['friends_ids' => $this->id.'_']);
			$user->contact->update(['friends' => $user->friends + 1]);
			return true;
		}
		return false;
	}
	public function isFriend($user){
			$ids = explode('_', $this->friends_ids);
			if(!in_array((string)$user->id, $ids)){
				return true;
			}
			return false;
	}

}
