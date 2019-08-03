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

    $post_content = $user_nick .', '. $user_email .', '. $user_desc .', '. $user_class .', '. $user_race;

    $args = [
      'post_type' => 'Application',
      'post_title' => $user_email,
      'post_content' => $post_content,
    ];


    $post_id = wp_insert_post($args);

    if (! is_wp_error($post_id)) {
      try {
        /**
        * Initiate curl request
        *
        * @param string $url_entity Part of API we want to communicate to
        */
        $curl = curl_init('https://discordapp.com/api/webhooks/607157238657712128/TTyIKojs4yqjAmrJU3ngFte5_6o-IZ0hkunccXBEMvGhXigzRixhYOWeIx3WK8LkL_h7');


        /**
         * @var array $options Header options for request
         */
        $options = [
          'Content-Type: application/x-www-form-urlencoded',
        ];


        /**
         * @var array $body
         */
        $body = [
          'content' => $post_content,
        ];


        /**
         * curl settings
         */
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_SSLVERSION, 6);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $options);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));



        /**
         * @var string $response Encoded object
         */
        $response = curl_exec($curl);


        /**
         * @var string $error Returns the error message or '' (the empty string) if no error occurred.
         */
        $error = curl_error($curl);


        /**
         * closes the curl init
         */
        curl_close($curl);


        /**
         * if there was a curl error
         */
        if ($error) {
          $this->returnJSON([
            'message' => $error,
            'status' => 400,
          ]);
        }


        /**
         * if no curl error, return response from request
         */
        $this->returnJSON([
          'message' => 'success',
          'status' => 200,
        ]);
      } catch (Exception $e) {
        $this->returnJSON([
          'message' => $e,
          'status' => 400,
        ]);
      }
    } else {
      $this->returnJSON([
        'message' => $post_id->get_error_message(),
        'status' => 400,
      ]);
    }
  }
}

try {
  SendApplication::listen();
} catch (ReflectionException $e) {
}
