<?php
/**
 * Create http link.
 *
 * @params string $message message.
 * @return string Replaced to the link.
 */
function auto_link($message){
  return preg_replace(
    "/(https?|ftp|news)(:\/\/[[:alnum:]\+\$\;\?\.%,!#~*\/:@&=_-]+)/",
    "<a href=\"\\1\\2\" target=\"_blank\">\\1\\2</a>",
    $message
  );
}
?>
