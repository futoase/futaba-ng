<?php

class ExtensionRepository {
  private static $extensions = [
    1 => '.gif',
    2 => '.jpg',
    3 => '.png',
    4 => '.swf',
    5 => '.psd',
    6 => '.bmp',
    13 => '.swf'
  ];
 
  /**
   * Find of extensions.
   *
   * @params integer $extension_id extension id.
   * @return string extension result.
   *         false extension not found.
   */ 
  public static function find($extension_id) {
    if (array_key_exists((int)$extension_id, self::$extensions)) {
      return self::$extensions[(int)$extension_id];
    }
    else {
      return false;
    }
  } 
}
