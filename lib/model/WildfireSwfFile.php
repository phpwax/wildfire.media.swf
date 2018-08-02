<?
class WildfireSwfFile extends WildfireDiskFile{

  //should return a url to display the image
  public function get($media_item, $size=false){
    return "/".trim($media_item->source, "/");
  }

  //this will actually render the contents of the image
  public function show($media_item, $size=false){
    return File::display_asset(PUBLIC_DIR.$media_item->source, $media_item->file_type);
  }

  //generates the tag to be displayed - return generic icon if not an image
  public function render($media_item, $size=false, $title="preview"){

    $path = PUBLIC_DIR.$media_item->source;
    $width = $this->width($path);
    $height = $this->height($path);
    $ratio = $height/$width;
    if($size){
      $width = $size;
      $height= round($size*$ratio);
    }

    $render = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" id="'.$title.'" width="'.$width.'" height="'.$height.'"/>
                <param name="movie" value="'.$this->get($media_item).'" />
                <!--[if !IE]>-->
                <object type="application/x-shockwave-flash" data="'.$this->get($media_item).'" width="'.$width.'" height="'.$height.'">
                <!--<![endif]-->
                  <a href="https://www.adobe.com/go/getflashplayer">
                    <img src="https://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
                  </a>
                <!--[if !IE]>-->
                </object>
                <!--<![endif]-->
              </object>';
              
    return $render;
  }

  public function width($src) {
    if(!is_readable($src)) return false;
    if($info = @getimagesize($src)) return $info[0];
    return $this->tryffmpeg("width",$src);
    return false;
  }
  public function height($src) {
    if(!is_readable($src)) return false;
    if($info = @getimagesize($src)) return $info[1];
    return $this->tryffmpeg("height",$src);
    return false;
  }
  
  public function tryffmpeg($dim,$src) {
    $command = "/usr/bin/ffmpeg -i \"".$src. "\" 2>&1";
    ob_start();
    passthru($command);
    $size = ob_get_contents();
    ob_end_clean();
    preg_match('/(\d{2,4})x(\d{2,4})/', $size, $matches);
    if($dim=="width") return $matches[1];
    if($dim=="height") return $height = $matches[2];
    return false;
  }

}
?>