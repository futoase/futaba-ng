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
