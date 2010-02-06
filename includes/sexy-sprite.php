<?php

/*
 * Dynamic Image and CSS Generator for Sexy Bookmarks
 * Author: Kerem Erkan <kerem@keremerkan.net>  
 * Version: 1.0
 *
 * Enjoy! :)
*/

class SexySprite
{
  var $image;
  var $icon_folder;
  var $x_offset = 0;
  var $style = "div.sexy-bookmarks{margin:20px 0;clear:both !important}";
  var $style_foot = "div.sexy-bookmarks ul.socials{width:100% !important;margin:0 !important;padding:0 !important;float:left !important}div.sexy-bookmarks ul.socials{background:transparent none !important;border:0 none !important;outline:0 none !important}div.sexy-bookmarks ul.socials li{display:inline !important;float:left !important;list-style-type:none !important;margin:0;height:29px !important;width:60px !important;cursor:pointer !important;padding:0 !important;background-color:transparent !important;border:0 none !important;outline:0 none !important;clear:none !important}div.sexy-bookmarks ul.socials li:before,div.sexy-bookmarks ul.socials li:after,div.sexy-bookmarks ul.socials li a:before,div.sexy-bookmarks ul.socials li a:after{content:none !important}div.sexy-bookmarks ul.socials a,div.sexy-bookmarks ul.socials a:hover{display:block !important;width:60px !important;height:29px !important;text-indent:-9999px !important;background-color:transparent !important;text-decoration:none !important;border:0 none !important}div.sexy-bookmarks ul.socials a:hover,div.sexy-bookmarks ul.socials li:hover{background-color:transparent !important;border:0 none !important;outline:0 none !important}";
  var $expand = "div.sexy-bookmarks-expand{height:29px;overflow:hidden}";

  public function __construct($w, $bgimg, $exp)
  {
    $this->image = @imagecreatetruecolor(60*$w, 60);

    if ( $this->image !== FALSE )
    {
      $bg = imagecolorallocatealpha($this->image, 255, 255, 255, 127);
      imagefill($this->image, 0, 0, $bg);
    } 

    if ( !empty($exp) )
      $this->style .= $this->expand;

    $this->style .= "div.sexy-bookmarks ul.socials li{background:url('../images/sexy-custom-sprite.png') no-repeat}";
    $this->icon_folder = SEXY_PLUGDIR . "images/icons/";

    if ( !empty($bgimg) )
    {
      if ( $bgimg == 'sexy' )
        $this->style .= "div.sexy-bookmarks-bg-sexy{padding:28px 0 0 10px !important;background:transparent url('../images/sharing-sexy.png') no-repeat !important}";
      elseif ( $bgimg == 'caring' )
        $this->style .= "div.sexy-bookmarks-bg-caring{padding:26px 0 0 10px !important;background:transparent url('../images/sharing-caring-hearts.png') no-repeat !important}";
      elseif ( $bgimg == 'care-old' )
        $this->style .= "div.sexy-bookmarks-bg-caring-old{padding:26px 0 0 10px !important;background:transparent url('../images/sharing-caring.png') no-repeat !important}";
      elseif ( $bgimg == 'love' )
        $this->style .= "div.sexy-bookmarks-bg-love{padding:26px 0 0 10px !important;background:transparent url('../images/share-love-hearts.png') no-repeat !important}";
      elseif ( $bgimg == 'wealth' )
        $this->style .= "div.sexy-bookmarks-bg-wealth{margin-left:15px !important;padding:35px 0 0 20px !important;background:transparent url('../images/share-wealth.png') no-repeat !important}";
      elseif ( $bgimg == 'enjoy' )
        $this->style .= "div.sexy-bookmarks-bg-enjoy{padding:26px 0 0 10px !important;background:transparent url('../images/share-enjoy.png') no-repeat !important}";
      elseif ( $bgimg == 'german' )
        $this->style .= "div.sexy-bookmarks-bg-german{padding:35px 0 0 20px !important;background:transparent url('../images/share-german.png') no-repeat !important}";
      elseif ( $bgimg == 'knowledge' )
        $this->style .= "div.sexy-bookmarks-bg-knowledge{padding:35px 0 0 10px !important;background:transparent url('../images/share-knowledge.png') no-repeat !important}";
    }

    $this->style .= $this->style_foot;
  }

  function append_image($src_file)
  {
    $source = @imagecreatefrompng($this->icon_folder . $src_file . '.png');

    $pct = 1;

    $w = 60;
    $h = 60;

    // Turn alpha blending off
    imagealphablending($source, FALSE);

    // Find the most opaque pixel in the image (the one with the smallest alpha value)
    $minalpha = 127;
    for( $x = 0; $x < $w; $x++ )
    { 
      for( $y = 0; $y < $h; $y++ )
      {
        $alpha = ( imagecolorat($source, $x, $y) >> 24 ) & 0xFF;

        if( $alpha < $minalpha )
          $minalpha = $alpha;
      }
    }

    // Loop through image pixels and modify alpha for each
    for ( $x = 0; $x < $w; $x++ )
    {
      for ( $y = 0; $y < $h; $y++ )
      {
        // Get current alpha value (represents the TANSPARENCY!)
        $colorxy = imagecolorat($source, $x, $y);
        $alpha = ($colorxy >> 24) & 0xFF;

        // Calculate new alpha
        if ( $minalpha !== 127 )
          $alpha = 127 + 127 * $pct * ($alpha - 127) / (127 - $minalpha);
        else
          $alpha += 127 * $pct;

        // Get the color index with new alpha
        $alphacolorxy = imagecolorallocatealpha($source, ($colorxy >> 16) & 0xFF, ($colorxy >> 8) & 0xFF, $colorxy & 0xFF, $alpha);

        // Set pixel with the new color + opacity
        if ( !imagesetpixel($source, $x, $y, $alphacolorxy) )
          return false;
      }
    }

    // The image copy
    imagecopy($this->image, $source, $this->x_offset, 0, 0, 0, 60, 60);
    imagedestroy($source);
    $pos = 0 - $this->x_offset;
    $this->style .= 'li.' . $src_file . '{background-position:' . $pos . 'px bottom !important}';
    $this->style .= 'li.' . $src_file . ':hover{background-position:' . $pos . 'px top !important}';
    $this->x_offset = $this->x_offset + 60;
  }

  function save_image()
  {
    imagesavealpha($this->image, TRUE);
    imagepng($this->image, SEXY_PLUGDIR.'/images/sexy-custom-sprite.png');
    imagedestroy($this->image);

    $css = SEXY_PLUGDIR.'/css/sexy-custom-sprite.css';

    $f = fopen($css, 'w');

    if ( $f !== FALSE )
    {
      fwrite($f, $this->style, strlen($this->style));
      fclose($f);
    }
    else
      file_put_contents($css, $this->style);
  }
}