<?php
//サムネイル作成
/**
 * Build of thumbnail file.
 *
 * @params string $path file path.
 * @params string $tim timestamp.
 * @params string $ext extention name.
 * @return void
 */
function thumb($path,$tim,$ext){
  if(!function_exists("ImageCreate") ||
     !function_exists("ImageCreateFromJPEG")){
    return;
  }

  $fname=$path.$tim.$ext;
  $thumb_dir = THUMB_DIR;     //サムネイル保存ディレクトリ
  $width     = MAX_W;            //出力画像幅
  $height    = MAX_H;            //出力画像高さ
  // 画像の幅と高さとタイプを取得
  $size = GetImageSize($fname);
  switch ($size[2]) {
    case 1 :
      if(function_exists("ImageCreateFromGIF")){
        $im_in = @ImageCreateFromGIF($fname);
        if($im_in){break;}
      }
      if(!is_executable(realpath("./gif2png")) || 
         !function_exists("ImageCreateFromPNG")){
        return;
      }

      @exec(realpath("./gif2png")." $fname",$a);

      if(!file_exists($path.$tim.'.png')){
        return;
      }
      $im_in = @ImageCreateFromPNG($path.$tim.'.png');
      unlink($path.$tim.'.png');
      if(!$im_in){
        return;
      }
      break;

    case 2 : 
      $im_in = @ImageCreateFromJPEG($fname);
      if(!$im_in){
        return;
      }
      break;
    case 3 :
      if(!function_exists("ImageCreateFromPNG")){
        return;
      }
      $im_in = @ImageCreateFromPNG($fname);
      if(!$im_in){
        return;
      }
      break;
    default : 
      return;
  }
  // リサイズ
  if ($size[0] > $width || $size[1] >$height) {
    $key_w = $width / $size[0];
    $key_h = $height / $size[1];
    ($key_w < $key_h) ? $keys = $key_w : $keys = $key_h;
    $out_w = ceil($size[0] * $keys) +1;
    $out_h = ceil($size[1] * $keys) +1;
  } else {
    $out_w = $size[0];
    $out_h = $size[1];
  }
  // 出力画像（サムネイル）のイメージを作成
  if(function_exists("ImageCreateTrueColor")&&get_gd_ver()=="2"){
    $im_out = ImageCreateTrueColor($out_w, $out_h);
  }
  else{
    $im_out = ImageCreate($out_w, $out_h);
  }
  // 元画像を縦横とも コピーします。
  ImageCopyResized($im_out, $im_in, 0, 0, 0, 0, $out_w, $out_h, $size[0], $size[1]);
  // サムネイル画像を保存
  ImageJPEG($im_out, $thumb_dir.$tim.'s.jpg',60);
  chmod($thumb_dir.$tim.'s.jpg',0666);
  // 作成したイメージを破棄
  ImageDestroy($im_in);
  ImageDestroy($im_out);
}
?>
