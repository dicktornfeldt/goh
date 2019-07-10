<?php

namespace App;

/*
|--------------------------------------------------------------------------
| Set users attendance on raid
|--------------------------------------------------------------------------
|
| This class is responsible for setting attendance on certain raid for certain user
|
*/

use WP_AJAX;

class SetRaidAttendance extends WP_AJAX
{
  protected $action = 'set_user_attendance';

  /**
   * Run AJAX function
   * @return mixed Return JSON or Mixed data based on required results
   */
  protected function run()
  {
    $user_id = filter_var($this->get('user_id'), FILTER_SANITIZE_STRING);
    $raid_id = filter_var($this->get('raid_id'), FILTER_SANITIZE_STRING);


    $this->returnJSON([
      'message' => 'success',
      'status' => 200,
    ]);
  }
}

try {
  SetRaidAttendance::listen();
} catch (ReflectionException $e) {
}
