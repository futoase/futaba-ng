<?php
/**
 * Seek MD5 checksum of file.
 *
 * @params string $inFile file path.
 * @return string MD5 checksum.
 *         false Is error.
 */
function md5_of_file($in_file) {
 if (file_exists($in_file)){
   if(function_exists('md5_file')){
     return md5_file($in_file);
   }else{
     $fd = fopen($in_file, 'r');
     $fileContents = fread($fd, filesize($in_file));
     fclose ($fd);
     return md5($fileContents);
   }
 }else{
   return false;
 }
}
?>
