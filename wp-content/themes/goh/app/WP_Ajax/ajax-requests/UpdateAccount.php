<?php

namespace App;

/*
|--------------------------------------------------------------------------
| Update user's account
|--------------------------------------------------------------------------
|
| This class is responsible for updating user's or subscriber's account
| information via AJAX request. This extends standard custom WP_AJAX class
|
*/

use WP_AJAX;

class UpdateAccount extends WP_AJAX
{
  protected $action = 'update_user';

  /**
   * Run AJAX function
   * @return mixed Return JSON or Mixed data based on required results
   */
  protected function run()
  {
    $user_id = filter_var($this->get('user_id'), FILTER_SANITIZE_STRING);
    $user_nick = filter_var($this->get('user_nick'), FILTER_SANITIZE_STRING);
    $user_email = filter_var($this->get('user_email'), FILTER_SANITIZE_STRING);
    $user_desc = filter_var($this->get('user_desc'), FILTER_SANITIZE_STRING);
    $user_class = filter_var($this->get('user_class'), FILTER_SANITIZE_STRING);
    $user_race = filter_var($this->get('user_race'), FILTER_SANITIZE_STRING);

    if ($user_nick) {
      update_user_meta($user_id, 'nick', $user_nick);
    }
    if ($user_email) {
      update_user_meta($user_id, 'user_email', $user_email);
    }
    if ($user_desc) {
      update_user_meta($user_id, 'description', $user_desc);
    }
    if ($user_class) {
      update_user_meta($user_id, 'class', $user_class);
    }
    if ($user_race) {
      update_user_meta($user_id, 'race', $user_race);
    }


    $this->returnJSON([
      'message' => 'success',
      'status' => 200,
    ]);
  }
}

try {
  UpdateAccount::listen();
} catch (ReflectionException $e) {
}
