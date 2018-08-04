<?php

use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use App\Middleware\AdminMiddleware;
use App\Middleware\TaskMiddleware;

$app->get('/', 'HomeController:getPeople')->setName('home');

$app->group('',function() use ($app){

  $app->get('/auth/signup', 'AuthController:getSignUp')->setName('auth.signup');
  $app->post('/auth/signup', 'AuthController:postSignUp');

  $app->get('/auth/signin', 'AuthController:getSignIn')->setName('auth.signin');
  $app->post('/auth/signin', 'AuthController:postSignIn');

  $app->get('/activate', 'AuthController:getActivate')->setName('activate');

  $app->get('/recover-password', 'UserController:getRecoverPassword')->setName('password.recover');
  $app->post('/recover-password', 'UserController:postRecoverPassword');

  $app->get('/reset-password', 'UserController:getResetPassword')->setName('password.reset');
  $app->post('/reset-password', 'UserController:postResetPassword');

  $app->get('/ajax/validate', 'AjaxController:getValidation')->setName('validate');

})->add(new GuestMiddleware($container));

$app->group('',function() use ($app){

  $app->get('/auth/signout', 'AuthController:getSignOut')->setName('auth.signout');

  $app->get('/update/profile', 'UserController:getUpdate')->setName('update');
  $app->post('/update/profile', 'UserController:postUpdate');
  //get kriminal
  $app->get('/ajax/rabota', 'AjaxController:getRabota')->setName('rabotas');
  $app->get('/ajax/drinks', 'AjaxController:getDrinks')->setName('drinks');
  $app->get('/ajax/cars', 'AjaxController:getCars')->setName('cars');
  $app->get('/ajax/trki', 'AjaxController:getTrki')->setName('trki');
  $app->get('/ajax/planed_crime', 'AjaxController:getCrime')->setName('cri');
  //get lokacii
  $app->get('/ajax/travel', 'AjaxController:getTravel')->setName('traveling');
  $app->get('/ajax/garaza', 'AjaxController:getGaraza')->setName('garaza');
  $app->get('/ajax/shop', 'AjaxController:getShop')->setName('shops');
  $app->get('/ajax/bank', 'AjaxController:getBank')->setName('banks');

  $app->get('/ajax/search', 'AjaxController:getSearch')->setName('search');

  $app->get('/profile', 'AjaxController:getProfile')->setName('profile');
  $app->get('/status', 'AjaxController:getStatus')->setName('status');
  $app->get('/stats', 'AjaxController:getStats')->setName('stats');
  $app->get('/add/friend', 'HomeController:getAddFriend')->setName('add-friend');
  $app->get('/confirm/friend', 'HomeController:getConfirmFriend')->setName('confirm-friend');
  $app->get('/delete/friend', 'HomeController:getDeleteFriend')->setName('delete-friend');

})->add(new AuthMiddleware($container));

$app->group('',function() use ($app){

  $app->get('/admin', 'AdminController:getAdmin')->setName('admin');
  $app->post('/admin', 'AdminController:postAdmin');

})->add(new AdminMiddleware($container));

$app->group('',function() use ($app){

  //post kriminal
  $app->get('/calculate/rabota', 'HomeController:getRabota')->setName('rabota');
  $app->get('/calculate/crime', 'HomeController:getCrime')->setName('crime');
  $app->get('/add/drinks-drugs', 'HomeController:getDrinksDrugs')->setName('drinks-drugs');
  $app->get('/capture/car', 'HomeController:getCar')->setName('car');
  $app->get('/race/car', 'HomeController:getRace')->setName('race');
  //post lokacii
  $app->get('/travel', 'HomeController:getTravel')->setName('travel');
  $app->get('/bank', 'HomeController:getBank')->setName('bank');
  $app->get('/shop', 'HomeController:getShop')->setName('shop');

})->add(new TaskMiddleware($container));
