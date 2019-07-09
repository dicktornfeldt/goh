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
    if (! check_ajax_referer('update_user_token', '_wpnonce', false)) {
      $this->returnJSON([
        'message' => 'Token invalid',
        'status' => 403,
      ]);
    }


    $user_id = $this->get('user_id');
    $user_nick = $this->get('user_nick');
    $user_email = $this->get('user_email');
    $user_desc = $this->get('user_desc');
    $user_class = $this->get('user_class');
    $user_race = $this->get('user_race');


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
