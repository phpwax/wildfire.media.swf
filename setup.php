<?
CMSApplication::register_module("media.swf", array("hidden"=>true, "plugin_name"=>"wildfire.media.swf", 'assets_for_cms'=>true));
WildfireMedia::$classes[] = 'WildfireSwfFile';
WildfireMedia::$allowed['swf'] = 'WildfireSwfFile';
?>