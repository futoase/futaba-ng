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
