<?php
/**
 * WP_AJAX
 *
 * A simple class for creating active
 * record, eloquent models of WordPress Posts.
 *
 * @author      AnthonyBudd <anthonybudd94@gmail.com>
 * @source      https://github.com/anthonybudd/WP_AJAX
 * @link        https://medium.com/@AnthonyBudd/wp-ajax-97d8f1d83e26
 */

// phpcs:ignoreFile -- class name is uppercase because of abbr.
abstract class WP_AJAX
{
  protected $action;
  public $request;
  public $wp;
  public $user;


  abstract protected function run();

  public function __construct()
  {
    global $wp;
    $this->wp = $wp;
    $this->request = $_REQUEST;

    if ($this->isLoggedIn()) {
      $this->user = wp_get_current_user();
    }
  }

  public static function boot()
  {
    $class = self::getClassName();
    $action = new $class;
    $action->run();
    die();
  }

  /**
   * @param bool $public
   * @throws ReflectionException
   */
  public static function listen($public = true)
  {
    $actionName = self::getActionName();
    $className = self::getClassName();
    add_action("wp_ajax_{$actionName}", [$className, 'boot']);

    if ($public) {
      add_action("wp_ajax_nopriv_{$actionName}", [$className, 'boot']);
    }
  }


  // -----------------------------------------------------
  // UTILITY METHODS
  // -----------------------------------------------------
  public static function getClassName()
  {
    return get_called_class();
  }

  public static function formURL()
  {
    return admin_url('/admin-ajax.php');
  }

  /**
   * @return mixed
   * @throws ReflectionException
   * @throws Exception
   */
  public static function getActionName()
  {
    $class = self::getClassName();
    $reflection = new ReflectionClass($class);
    $action = $reflection->newInstanceWithoutConstructor();
    if (!isset($action->action)) {
      throw new Exception("Public property \$action not provided");
    }

    return $action->action;
  }

  // -----------------------------------------------------
  // JSONResponse
  // -----------------------------------------------------
  public function returnBack()
  {
    if (isset($_SERVER['HTTP_REFERER'])) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      die();
    }

    return false;
  }

  public function returnRedirect($url, $params = [])
  {
    $url .= '?' . http_build_query($params);
    ob_clean();
    header('Location: ' . $url);
    die();
  }

  public function returnJSON($data)
  {
    header('Content-Type: application/json');
    echo json_encode($data);
    die;
  }

  // -----------------------------------------------------
  // Helpers
  // -----------------------------------------------------
  public static function ajaxURL()
  {
    ?>
    <script type="text/javascript">
      var ajaxurl = '<?php echo admin_url('/admin-ajax.php'); ?>';
    </script>
    <?php
  }

  public static function WP_HeadAjaxURL()
  {
    add_action('wp_head', ['WP_AJAX', 'ajaxURL']);
  }

  public static function url($params = [])
  {
    $params = http_build_query(array_merge([
      'action' => (new static())->action,
    ], $params));

    return admin_url('/admin-ajax.php') . '?' . $params;
  }

  public function isLoggedIn()
  {
    return is_user_logged_in();
  }

  public function has($key)
  {
    if (isset($this->request[$key])) {
      return true;
    }

    return false;
  }

  /**
   * [get description]
   * @param  string $key [description]
   * @param  string $default [description]
   * @param bool $stripslashes
   * @return string
   */
  public function get($key, $default = null, $stripslashes = true)
  {
    if ($this->has($key)) {
      if ($stripslashes) {
        return stripslashes($this->request[$key]);
      }
      return $this->request[$key];
    }
    return $default;
  }

  /**
   * @param null $requestType
   * @return bool
   */
  public function requestType($requestType = null)
  {
    if (!is_null($requestType)) {
      if (is_array($requestType)) {
        return in_array($_SERVER['REQUEST_METHOD'], array_map('strtoupper', $requestType));
      }

      return ($_SERVER['REQUEST_METHOD'] === strtoupper($requestType));
    }

    return $_SERVER['REQUEST_METHOD'];
  }
}
