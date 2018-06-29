<?php

namespace App\Controllers;
use App\Models\User;

class AjaxController extends Controller
{

  public function getValidation($request, $response)
  {
    $type = $request->getParam('type');
    $val = $request->getParam('val');
    $password = $request->getParam('password');

    switch ($type) {
      case 'username':
      $v = $this->Validator->validate(['username' => [$val,'required|alnumDash|max(50)|min(5)|uniqueUsername'] ]);
      break;

      case 'email':
      $v = $this->Validator->validate(['email' => [$val,'required|max(100)|email|uniqueEmail'] ]);
      break;

      case 'password':
      $v = $this->Validator->validate(['password' => [$val,'required|min(8)|alnumDash'] ]);
      break;

      case 'password_confirm':
      $v = $this->Validator->validate([
        'password' => [$password,'required'],
        'password_confirm' => [$val,'required|matches(password)'] ]);
      break;
    }

      if ($v->passes()){
        return 'true';
      }else {
          return $v->errors()->first();
      }
  }

  public function getUser($request, $response)
  {
    $user = $this->auth->user();
    return $user->id.' '.$user->username;
  }
}
