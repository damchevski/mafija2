<?php

namespace App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\User\User;


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
	public function add($id)
	{
		$ids = explode('_', $this->friends_pending);
		if(!in_array((string)$id, $ids)){
			$this->update(['friends_pending' => $this->friends_pending.$id.'_']);
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
			$this->update(['friends_ids' => $this->friends_ids.$user->id.'_']);
			$this->update(['friends' =>  $this->friends + 1]);
			$user->contact->update(['friends_ids' => $user->contact->friends_ids.$this->id.'_']);
			$user->contact->update(['friends' => $user->contact->friends + 1]);
			return true;
		}
		return false;
	}
	public function remove($user)
	{
		$ids = explode('_', $this->friends_ids);
		if(in_array((string)$user->id, $ids)){
			foreach ($ids as $key => $value) {
				if($value == $user->id){
					 unset($ids[$key]);
				}
			}
			$this->update(['friends_ids' => implode("_", $ids)]);
			$this->update(['friends' =>  $this->friends - 1]);
			$ids = explode('_', $user->contact->friends_ids);
			if(in_array((string)$this->user_id, $ids)){
				foreach ($ids as $key => $value) {
					if($value == $this->user_id){
						 unset($ids[$key]);
					}
				}
				$user->contact->update(['friends_ids' => implode("_", $ids)]);
				$user->contact->update(['friends' => $user->contact->friends - 1]);
				return true;
			}
		}
		return false;
	}
	public function isFriend($id){
			$ids = explode('_', $this->friends_ids);
			if(in_array((string)$id, $ids)){
				return true;
			}
			return false;
	}
	public function getFriends(){
		$users = array();
		$ids = explode('_', $this->friends_ids);
		foreach ($ids as $i=>$id) {
			$users[$i]= User::find($id);
		}
		array_pop($users);
		return $users;
	}
	public function getFriendsPending(){
		$users = array();
		$ids = explode('_', $this->friends_pending);
		foreach ($ids as $i=>$id) {
			$users[$i]= User::find($id);
		}
		array_pop($users);
		return $users;
	}

}
