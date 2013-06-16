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
