<?php

/**
 * ImageFile Model.
 *
 * Image file is upload file of futaba.
 */
class ImageFile {
  private static $my;

  use uploadFile;

  public static function getNew() {
    if (self::$my == null) {
      self::$my = new self();
    } 
    return self::$my;
  }

  public function __construct() {
  }
}
?>

<?php

trait uploadFile {
  /**
   * create temporary filename.
   * 
   * @params string $file_path original file path.
   * @params string $time time stamp.
   * @return string temporary filename.
   */
  public static function createTempFileName($file_path, $time) {
    return $file_path . $time . '.tmp';
  }
}
?>
