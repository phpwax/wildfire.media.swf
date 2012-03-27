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

    $render = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" id="'.$title.'">
                <param name="movie" value="'.$this->get($media_item).'" />
                <!--[if !IE]>-->
                <object type="application/x-shockwave-flash" data="'.$this->get($media_item).'">
                <!--<![endif]-->
                  <a href="http://www.adobe.com/go/getflashplayer">
                    <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
                  </a>
                <!--[if !IE]>-->
                </object>
                <!--<![endif]-->
              </object>';
    return $render;
  }
}
?>