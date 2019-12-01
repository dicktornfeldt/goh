<?php

namespace App;

/*
|--------------------------------------------------------------------------
| Send application
|--------------------------------------------------------------------------
|
| This class is responsible for handling user applications
|
*/

use WP_AJAX;

class SendApplication extends WP_AJAX
{
  protected $action = 'send_application';

  /**
   * Run AJAX function
   * @return mixed Return JSON or Mixed data based on required results
   */
  protected function run()
  {
    $user_nick  = filter_var($this->get('user_nick'), FILTER_SANITIZE_STRING);
    $user_email = filter_var($this->get('user_email'), FILTER_SANITIZE_STRING);
    $discord_battlenet = filter_var($this->get('discord_battlenet'), FILTER_SANITIZE_STRING);
    $user_desc  = filter_var($this->get('user_desc'), FILTER_SANITIZE_STRING);
    $user_class = filter_var($this->get('user_class'), FILTER_SANITIZE_STRING);
    $user_race  = filter_var($this->get('user_race'), FILTER_SANITIZE_STRING);

    // quit if application exists
    $post_exists = post_exists($user_email);
    if ($post_exists) {
      $this->returnJSON([
        'message' => 'app_exists',
        'status' => 400,
      ]);
    }

    $post_content = "Nick: $user_nick, Mail: $user_email, Klass: $user_class, Ras: $user_race, Disc/Battlenet: $discord_battlenet Beskrivning: $user_desc,";

    $args = [
      'post_type' => 'Application',
      'post_title' => $user_email,
      'post_content' => $post_content,
    ];


    $post_id = wp_insert_post($args);

    if (! is_wp_error($post_id)) {
      $this->mailApplication($post_content);

      $this->returnJSON([
        'message' => 'success',
        'status' => 200,
      ]);
    } else {
      $this->returnJSON([
        'message' => $post_id->get_error_message(),
        'status' => 400,
      ]);
    }
  }


  public function mailApplication(string $post_content)
  {
    $to      = 'dick.tornfeldt@gmail.com,gammalochhorde@gmail.com';
    $subject = 'GOH - Guildansökning';
    $headers = ['Content-Type: text/html; charset=UTF-8'];
    $body    = $post_content;

    wp_mail($to, $subject, $body, $headers);
  }
}

try {
  SendApplication::listen();
} catch (ReflectionException $e) {
}
