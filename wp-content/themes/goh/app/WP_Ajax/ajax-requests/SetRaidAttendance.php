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
    $user_attendance = filter_var($this->get('user_attendance'), FILTER_SANITIZE_STRING);

    $current_attendance = get_post_meta($raid_id, 'attendance');
    $current_attendance = reset($current_attendance);
    $current_attendance = (array)$current_attendance;

    if ($user_attendance == 'no') {
      $index = array_search($user_id, $current_attendance);
      if ($index !== false) {
        unset($current_attendance[$index]);
        update_field('attendance', $current_attendance, $raid_id);
        $this->returnJSON([
          'message' => 'removed',
          'status' => 200,
        ]);
      } else {
        $this->returnJSON([
          'message' => 'not_signed',
          'status' => 200,
        ]);
      }
    }


    if ($user_attendance == 'yes') {
      if (in_array($user_id, $current_attendance)) {
        $this->returnJSON([
          'message' => 'already_signed',
          'status' => 200,
        ]);
      }

      $current_attendance[] = $user_id;

      update_field('attendance', $current_attendance, $raid_id);

      $this->returnJSON([
        'message' => 'signed',
        'status' => 200,
      ]);
    }
  }
}

try {
  SetRaidAttendance::listen();
} catch (ReflectionException $e) {
}
