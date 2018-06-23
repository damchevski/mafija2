<?php

namespace App\Controllers;
use App\Models\User;

class AdminController extends Controller
{
  public function getAdmin($request, $response)
  {
    $user = $this->auth->user();
    return $this->view->render($response, 'admin.twig');
  }
  public function postAdmin($request, $response)
  {
    //not in use
  }

}
