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

<?php

trait Trip {
  /**
   * build processing result of trip signature.
   *
   * @params string $trip_signature trip signature.
   * @return string trip signature.
   */
  public static function buildTrip($trip_signature) {
    $cap = $trip_signature;
    $cap = strtr($cap, "&amp;", "&");
    $cap = strtr($cap, "&#44;", ",");
    $salt = substr($cap . "H.", 1, 2);
    $salt = preg_replace("/[^\.-z]/", "." ,$salt);
    $salt = strtr($salt, ":;<=>?@[\\]^_`", "ABCDEFGabcdef"); 
    return substr(crypt($cap,$salt),-10);
  }

  /**
   * get Trip signature in username.
   *
   * @params string $user_name user name.
   * @return string Yes, is in. (trip signature)
   *         false No, isn't in. 
   */
  public static function getTripSignatureInUsername($user_name) {
    if (preg_match("/(#|＃)(.*)/", $user_name, $regs) === 1) {
      return $regs[2];
    }
    else {
      return false;
    }
  }

  /**
   * Remove trip signature of username.
   *
   * @params string $user_name user name.
   * @return string Deleted username in trip signature.
   */
  public static function removeTripSignature($user_name) {
    return preg_replace("/(#|＃)(.*)/", "", $user_name);
  }
}

?>

<?php
/**
 * Prettify text
 */
class PrettifyText {
  use Trip;

  /**
   * replace string of mail address.
   * 
   * @params string $mail_address user mail address.
   * @return string replaced mail address.
   */
  public static function replaceStringOfMail($mail_address) {
    if (self::isAdmin()) {
      $mail_address = self::replaceSpecialStringOfAdmin($mail_address);
    }
    else {
      $mail_address = self::replaceSpecialString($mail_address);
    }
    return preg_replace("/[\r\n]/", "", $mail_address);
  }

  /**
   * replace string of subject.
   * 
   * @params string $subject subject.
   * @return string replaced subject.
   */
  public static function replaceStringOfSubject($subject) {
    if (self::isAdmin()) {
      $subject = self::replaceSpecialStringOfAdmin($subject);
    }
    else {
      $subject = self::replaceSpecialString($subject);
    }
    return preg_replace("/[\r\n]/", "", $subject);
  }

  /**
   * replace string of url.
   * 
   * @params string $url url.
   * @return string replaced url.
   */
  public static function replaceStringOfUrl($url) {
    if (self::isAdmin()) {
      $url = self::replaceSpecialStringOfAdmin($url);
    }
    else {
      $url = self::replaceSpecialString($url);
    }
    return preg_replace("/[\r\n]/", "", $url);
  }

  /**
   * replace string of res number.
   * 
   * @params string $res_number res number.
   * @return string replaced res number.
   */
  public static function replaceStringOfResNumber($res_number) {
    if (self::isAdmin()) {
      $res_number = self::replaceSpecialStringOfAdmin($res_number);
    }
    else {
      $res_number = self::replaceSpecialString($res_number);
    }
    return preg_replace("/[\r\n]/", "", $res_number);
  }

  /**
   * replace string of comment.
   * 
   * @params string $comment comment.
   * @return string replaced comment.
   */
  public static function replaceStringOfComment($comment) {
    if (self::isAdmin()) {
      $comment = self::replaceSpecialStringOfAdmin($comment);
    }
    else {
      $comment = self::replaceSpecialString($comment);
    }
    $comment = str_replace( "\r\n",  "\n", $comment); 
    $comment = str_replace( "\r",  "\n", $comment);
    // 連続する空行を一行
    $comment = preg_replace("/\n((　| )*\n){3,}/","\n",$comment);
    if(!BR_CHECK || substr_count($comment,"\n")<BR_CHECK){
      $comment = nl2br($comment);		//改行文字の前に<br>を代入する
    }
    $comment = str_replace("\n",  "", $comment);	//\nを文字列から消す。
    return $comment;
  }

  /**
   * replace string of name.
   * 
   * @params string $name name.
   * @return string replaced name.
   */
  public static function replaceStringOfName($name) {
    $name = preg_replace("/◆/","◇",$name);
    $name = preg_replace("/[\r\n]/","",$name);

    if (self::isAdmin()) {
      $name = self::replaceSpecialStringOfAdmin($name);
    }
    else {
      $name = self::replaceSpecialString($name);
    }

    $trip_signature = self::getTripSignatureInUsername($name);
    if ($trip_signature !== false) {
      $trip = self::buildTrip($trip_signature);
      $name = self::removeTripSignature($name);
      $name .= '</b>◆' . $trip . "<b>";
    } 

    return $name;
  }

  /**
   * is admin?
   *
   * @return true Yes, I'm admin.
   *         false No, I'm not admin.
   */
  private static function isAdmin() {
    global $admin;
    return $admin == ADMIN_PASS;
  }

  /**
   * replace string.
   *
   * @params string $target_string target string.
   * @return string replaced string.
   */
  private static function replaceSpecialString($target_string) {
    // strip html tag
    $trimed_tag_message = htmlspecialchars($target_string);
    // strip special chars
    $replace_ampersand_message = (
      str_replace("&amp;", "&", $trimed_tag_message)
    );
    // replace comma
    $replace_comma_message = (
      str_replace(",", "&#44;", $replace_ampersand_message)
    );
    return $replace_ampersand_message;
  } 

  /**
   * replace string of admin.
   *
   * @params string $target_string target string.
   * @return string replaced string.
   */
  private static function replaceSpecialStringOfAdmin($target_string) {
    // replace comma.
    return str_replace(",", "&#44;", $target_string);
  }
}

?>
