<?php

App::import('Vendor', 'Securimage',array('file'=>'captcha'.DS.'securimage'.DS.'securimage.php'));

class CaptchaController extends AppController {

	var $name = "Captcha";
	var $uses = array();
	var $components = array();



	/***
	*
	*
	*/	
	function beforeFilter(){
		parent::beforeFilter();
		
		$this->autoRender = false;
		
	}
	
	
	/***
	*
	*
	*/
	function image($w=200,$h=60){

		$img = new securimage();
		
		// Change some settings
		$plugin_securimage_dir = dirname(APP).DS.'plugins'.DS.'captcha'.DS.'webroot';		
		$vendor_securimage_dir = dirname(APP).DS.'vendors'.DS.'captcha'.DS.'securimage';
		
		$img->wordlist_file = $vendor_securimage_dir.DS.'words'.DS.'words.txt';
		$img->use_wordlist  = true;
		$img->gd_font_file  = $vendor_securimage_dir.DS.'gdfonts/automatic.gdf';
		$img->ttf_file      = $vendor_securimage_dir.DS.'AHGBold.ttf';
		
		$img->image_width = $w;
		$img->image_height = $h;
		
		$img->perturbation = 0.85;
		//$img->image_bg_color = new Securimage_Color(0×0, 0×0, 0×0);
		//$img->text_color = new Securimage_Color(0xff, 0xff, 0xff);
		$img->text_transparency_percentage = 1;
		$img->use_transparent_text = true;
		$img->use_wordlist = true;
		//$img->text_angle_minimum = -10;
		//$img->text_angle_maximum = 10;
		$img->num_lines = 0;
		$img->line_color = new Securimage_Color(0xff, 0xaff, 0xff);

		//$img->image_type = SI_IMAGE_PNG;	
		
		$img->show($plugin_securimage_dir.DS.'backgrounds/bg6.png');
		

	}
	
}
?>