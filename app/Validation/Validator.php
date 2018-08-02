<?php

namespace App\Validation;

use Violin\Violin;
use App\Models\User\User;

class Validator extends Violin
{
  protected $container;

  public function __construct($container)
  {
      $this->container = $container;
      $this->addFieldMessages([
        'email' =>[
          'uniqueEmail' => 'Веќе е преземено!'
        ],
        'username' =>[
          'uniqueUsername' => 'Ова корисничко име е преземено!'
        ]
      ]);
      //mejavanje na rulse na mk i angliski
      $this->addRuleMessages([
        'checkPassword' => 'Не внесовте исти лозинки',
        'required'=> 'Не смеете да ги оставите празните полиња кои се задожителни!'
      ]);
  }
  public function validate_uniqueEmail($value, $input , $args)
  {
    $user = User::where('email',$value);
    return ! (bool) $user->count();
  }
  public function validate_uniqueUsername($value, $input , $args)
  {
    $user = User::where('username',$value);
    return ! (bool) $user->count();
  }
  public function validate_checkPassword($value, $input , $args)
  {
    $user = $this->container->auth->user();
    return password_verify($value, $user->password);
  }
}
