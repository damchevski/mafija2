<?php

namespace App\Controllers\Auth;

use App\Models\User\User;
use App\Models\User\UserPermission;
use App\Models\User\Prom;
use App\Models\User\Inventory;
use App\Models\User\Energy;
use App\Models\User\Contact;
use App\Controllers\Controller;
use Carbon\Carbon;

class AuthController extends Controller
{
  public function getActivate($request, $response)
  {
    $email = $request->getParam('email');
    $activate = $request->getParam('activate');
    $active_hash = $this->hash->hash($activate);
    $user = User::where('email', $email)->where('active', false)->first();

    if(!$user || !$this->hash->hashCheck($user->active_hash, $active_hash)){
      $this->flash->addMessage('error','Не можевме да го активираме акаунтот');
      return $response->withRedirect($this->router->pathFor('home'));
    }else {
      $user->update([
        'active' => true,
        'active_hash' => null
      ]);
      $this->flash->addMessage('info','Вашиот акаунт е успешно активиран, можете да се најавите');
      return $response->withRedirect($this->router->pathFor('auth.signin'));
    }
  }
  public function getSignOut($request, $response)
  {
    $this->auth->logout();
    $this->flash->addMessage('info','Само што се одјавивте');
    return $response->withRedirect($this->router->pathFor('home'));
  }
  public function getSignUp($request, $response){
    return $this->view->render($response, 'auth/signup.twig');
  }
  public function postSignUp($request, $response)
  {
    $username = $request->getParam('username');
    $email = $request->getParam('email');
    $password = $request->getParam('password');
    $password_confirm = $request->getParam('password_confirm');
    $drzava = $request->getParam('drzava');
    $pol = $request->getParam('pol');

    $v = $this->Validator->validate([
      'username' => [$username,'required|alnumDash|max(50)|min(4)|uniqueUsername'],
      'email' => [$email,'required|max(100)|email|uniqueEmail'],
      'password' => [$password,'required|min(8)|alnumDash'],
      'password_confirm' => [$password_confirm,'required|matches(password)']
    ]);
    if ($v->passes()){
      $activate = $this->randomlib->generateString(128);
      $user = User::create([
      'username'    => $username,
      'email'       => $email,
      'drzava'      => $drzava,
      'pol'         => $pol,
      'password'    => password_hash($password, PASSWORD_DEFAULT),
      'active'      => false,
      'active_hash' => $this->hash->hash($activate)
      ]);

      $user->permissions()->create(UserPermission::$defaults);
      $user->energy()->create(Energy::$defaults);
      $user->prom()->create(Prom::$defaults);
      $user->inventory()->create(Inventory::$defaults);
      $user->contact()->create(Contact::$defaults);
      $user->task()->create(['task' => 0]);

      $this->Mail->send('email/auth/activate.twig',['user' => $user, 'activate' => $activate],function($message) use ($user){
        $message->to($user->email);
        $message->subject('Ви благодариме на регистрацијата');
      });

      $this->flash->addMessage('info','Успешно се регистриравте, проверете емаил за активација на акаунтот');
      return $response->withRedirect($this->router->pathFor('home'));
    }else {
      return $this->view->render($response, 'auth/signup.twig',[
        'errors'  => $v->errors(),
        'request' => $request->getParams()
      ]);
    }
  }
  public function getSignIn($request, $response){
    return $this->view->render($response, 'auth/signin.twig');
  }
  public function postSignIn($request, $response)
  {
    $username = $request->getParam('username');
    $password = $request->getParam('password');
    $remember = $request->getParam('remember');

    $auth = $this->auth->attempt($username, $password, $remember);
    if(!$auth){
      $this->flash->addMessage('error','Неуспешно најавување. Обиди се повторно');
      return $response->withRedirect($this->router->pathFor('auth.signin'));
    }
    $this->flash->addMessage('info','Успешно се најавивте');
    return $response->withRedirect($this->router->pathFor('home'));
  }
}
