<?php
class SpriteStyleGroup extends ArrayObject implements SpriteHashable{
  protected $spriteStyleNodes;
  protected $sprite;
  protected $backgroundStyleNode;
  
  public function __construct(SpriteSprite &$sprite){
    $this->spriteStyleNodes = array();
    $this->sprite = $sprite;
    parent::__construct($this->spriteStyleNodes, ArrayObject::ARRAY_AS_PROPS);
    
    //$this->backgroundStyleNode = new SpriteStyleNode(null, 'sprite'.md5($this->sprite->getRelativePath()), null, $this->sprite->getRelativePath());
    /* Here edit by Gautam */

	//grab the array
	global $sexy_plugopts;

	//check for the auto-expand feature
	if($_POST['expand'] == '1' || $sexy_plugopts['expand'] == '1') {
		$sexyExpandStyles = 'div.sexy-bookmarks-expand{height:29px;overflow:hidden}';
	} elseif($_POST['expand'] == '0' || $sexy_plugopts['expand'] == '0') {
		$sexyExpandStyles = null;
	} else {
		$sexyExpandStyles = null;
	}

	//check which background image (if any) they've chosen
	if($_POST['bgimg'] == 'sexy' || $sexy_plugopts['bgimg'] == 'sexy') {
		$sexyBackgroundImg = "div.sexy-bookmarks-bg-sexy{padding:28px 0 0 10px !important;background:transparent url('../images/sharing-sexy.png') no-repeat !important}";
	} elseif($_POST['bgimg'] == 'caring' || $sexy_plugopts['bgimg'] == 'caring') {
		$sexyBackgroundImg = "div.sexy-bookmarks-bg-caring{padding:26px 0 0 10px !important;background:transparent url('../images/sharing-caring-hearts.png') no-repeat !important}";
	} elseif($_POST['bgimg'] == 'care-old' || $sexy_plugopts['bgimg'] == 'care-old') {
		$sexyBackgroundImg = "div.sexy-bookmarks-bg-caring-old{padding:26px 0 0 10px !important;background:transparent url('../images/sharing-caring.png') no-repeat !important}";
	} elseif($_POST['bgimg'] == 'love' || $sexy_plugopts['bgimg'] == 'love') {
		$sexyBackgroundImg = "div.sexy-bookmarks-bg-love{padding:26px 0 0 10px !important;background:transparent url('../images/share-love-hearts.png') no-repeat !important}";
	} elseif($_POST['bgimg'] == 'wealth' || $sexy_plugopts['bgimg'] == 'wealth') {
		$sexyBackgroundImg = "div.sexy-bookmarks-bg-wealth{margin-left:15px !important;padding:35px 0 0 20px !important;background:transparent url('../images/share-wealth.png') no-repeat !important}";
	} elseif($_POST['bgimg'] == 'enjoy' || $sexy_plugopts['bgimg'] == 'enjoy') {
		$sexyBackgroundImg = "div.sexy-bookmarks-bg-enjoy{padding:26px 0 0 10px !important;background:transparent url('../images/share-enjoy.png') no-repeat !important}";
	} elseif($_POST['bgimg'] == 'german' || $sexy_plugopts['bgimg'] == 'german') {
		$sexyBackgroundImg = "div.sexy-bookmarks-bg-german{padding:35px 0 0 20px !important;background:transparent url('../images/share-german.png') no-repeat !important}";
	} else {
		$sexyBackgroundImg = null;
	}

	//define the global styles
	$sexyGlobalStyles = 'div.sexy-bookmarks{margin:20px 0;clear:both !important}'.$sexyExpandStyles.$sexyBackgroundImg.'div.sexy-bookmarks ul.socials{width:100% !important;margin:0 !important;padding:0 !important;float:left !important}div.sexy-bookmarks ul.socials{background:transparent none !important;border:0 none !important;outline:0 none !important}div.sexy-bookmarks ul.socials li{display:inline !important;float:left !important;list-style-type:none !important;margin:0;height:29px !important;width:60px !important;cursor:pointer !important;padding:0 !important;background-color:transparent !important;border:0 none !important;outline:0 none !important;clear:none !important}div.sexy-bookmarks ul.socials li:before,div.sexy-bookmarks ul.socials li:after,div.sexy-bookmarks ul.socials li a:before,div.sexy-bookmarks ul.socials li a:after{content:none !important}div.sexy-bookmarks ul.socials a,div.sexy-bookmarks ul.socials a:hover{display:block !important;width:60px !important;height:29px !important;text-indent:-9999px !important;background-color:transparent !important;text-decoration:none !important;border:0 none !important}div.sexy-bookmarks ul.socials a:hover,div.sexy-bookmarks ul.socials li:hover{background-color:transparent !important;border:0 none !important;outline:0 none !important}';

    $this->backgroundStyleNode = new SpriteStyleNode(null, $sexyGlobalStyles.'div.sexy-bookmarks ul.socials li', null, $this->sprite->getRelativePath());
    foreach($this->sprite as $spriteImage){
      $this->addStylesToGroup($spriteImage);
    }
  }
  
  public function getBackgroundStyleNode(){
    return $this->backgroundStyleNode;
  }
  
  public function getStyleNode($path){
    return parent::offsetGet($path);
  }
  
  public function getRelativePath(){
    return SpriteConfig::get('relTmplOutputDirectory').'/'.$this->getFilename();
  }
  
  public function getFilename(){
    return $this->getHash().'.css';
  }
  
  public function getHash(){
    return 'sexy-custom-sprite.min';
  }
  
  public function getCss(){
    $css = $this->getBackgroundStyleNode()->renderCss();
    foreach($this as $styleNode){
      $css .= $styleNode->renderCss();
    }
    return $css;
  }
  
  protected function addStylesToGroup(SpriteImage $spriteImage){
     parent::offsetSet($spriteImage->getKey(), new SpriteStyleNode($spriteImage, $spriteImage->getCssClass(), $this->getBackgroundStyleNode(), $this->sprite->getRelativePath()));
  }
  
}
