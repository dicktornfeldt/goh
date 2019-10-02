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
    $user_id         = filter_var($this->get('user_id'), FILTER_SANITIZE_STRING);
    $raid_id         = filter_var($this->get('raid_id'), FILTER_SANITIZE_STRING);
    $user_attendance = filter_var($this->get('user_attendance'), FILTER_SANITIZE_STRING);
    $attending       = false;

    if (have_rows('attendance_list', $raid_id)) {
      while (have_rows('attendance_list', $raid_id)) {
        the_row();

        $user = get_sub_field('anvandare');
        $index = get_row_index();

        if ($user_id == $user->ID) {
          $attending = true;

          if ($user_attendance == 'Nej') {
            delete_row('attendance_list', (int)$index, $raid_id);
            $this->returnJSON(['message' => 'removed']);
          }

          $value = [
            'anvandare' => $user,
            'narvaro'   => $user_attendance,
          ];

          update_row('attendance_list', (int)$index, $value, $raid_id);

          $this->returnJSON(['message' => 'updated', 'value' => $value]);
        }
      }
    }

    if (! $attending && $user_attendance != 'Nej') {
      $user = new \WP_User($user_id);
      $value = [
        'anvandare' => $user,
        'narvaro'   => $user_attendance,
      ];
      $total_rows = add_row('attendance_list', $value, $raid_id);

      $value = [
        'anvandare'     => $user,
        'narvaro'       => $user_attendance,
        'signup_number' => $total_rows,
      ];
      update_row('attendance_list', (int)$total_rows, $value, $raid_id);

      $this->returnJSON(['message' => 'signed']);
    }
  }
}

try {
  SetRaidAttendance::listen();
} catch (ReflectionException $e) {
}
