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

  /**
   * Auto adjustment image canvas size.
   *
   * @params integer $width image canvas width.
   * @params integer $height image canvas height.
   * @return array adjustment image canvas size.
   */
  public static function adjustmentImageCanvasSize($width, $height) {
    if($width > MAX_W || $height > MAX_H){
      $width_scaling_factor = MAX_W / $width;
      $height_scaling_factor = MAX_H / $height;
      if ($width_scaling_factor < $height_scaling_factor) {
        $base_of_scaling = $width_scaling_factor;
      }
      else {
        $base_of_scaling = $height_scaling_factor;
      }
      $desired_width = ceil($width * $base_of_scaling);
      $desired_height = ceil($height * $base_of_scaling);

      return [
        'width' => $desired_width,
        'height' => $desired_height
      ];
    }
    else {
      return [
        'width' => $width,
        'height' => $height
      ];
    }
  }
}
?>
