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

  /**
   * Verification of have already uploaded
   * 
   * @params array $uploaded_files uploaded filenames.
   * @params string $file_path verification file path.
   * @return true is uploaded.
   *         false is not uploaded.
   */
  public static function isUploaded($uploaded_files, $file_path) {
    $chk = self::md5HashOfFile($file_path);
    foreach($uploaded_files as $value){
      if(preg_match("/^$value/",$chk) === 1){
        return true;
      }
    }
    return false;
  }

  /**
   * Seek MD5 checksum of file.
   *
   * @params string $inFile file path.
   * @return string MD5 checksum.
   *         false Is error.
   */
  private static function md5HashOfFile($file_path) {
    if (file_exists($file_path)){
      if(function_exists('md5_file')){
        return md5_file($file_path);
      }
      else{
        $fd = fopen($file_path, 'r');
        $fileContents = fread($fd, filesize($file_path));
        fclose ($fd);
        return md5($fileContents);
      }
    }
    else{
      return false;
    }
  }
}
?>
