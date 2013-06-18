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
