<?php 
class ImageHelper extends Helper {

    var $helpers = array('Html');
    
    var $cacheDir = '/files/imagecache'; // relative to IMAGES_URL path
    
/**
 * Automatically resizes an image and returns formatted IMG tag
 *
 * @param string $path Path to the image file, relative to the webroot/img/ directory.
 * @param integer $width Image of returned image
 * @param integer $height Height of returned image
 * @param boolean $aspect Maintain aspect ratio (default: true)
 * @param array    $htmlAttributes Array of HTML attributes.
 * @param boolean $return Wheter this method should return a value or output it. This overrides AUTO_OUTPUT.
 * @return mixed    Either string or echos the value, depends on AUTO_OUTPUT and $return.
 * @access public
 */
    function resize($path, $width, $height, $aspect = true, $htmlAttributes = array(), $return = false) {
        
        $types = array(1 => "gif", "jpeg", "png", "swf", "psd", "wbmp"); // used to determine image type
        
        $fullpath = ROOT.DS.APP_DIR.DS.WEBROOT_DIR;
    
        $url = $fullpath.$path;
        
        if (!($size = getimagesize($url))) 
            return; // image doesn't exist
            
        if ($aspect) { // adjust to aspect.

						$src_x = 0;
						$src_y = 0;
        
            if (($size[1]/$height) > ($size[0]/$width))  // $size[0]:width, [1]:height, [2]:type
                $width = ceil(($size[0]/$size[1]) * $height);
            else 
                $height = ceil($width / ($size[0]/$size[1]));
        }else{//resize Crop
		      // Check to see that we are not over resizing, otherwise, set the new scale      
		      // -- resize to max, then crop to center
		      $src_x = 0 ;
		      $src_y = 0 ;

					$vertical = false;		      
					if( $size[0] < $size[1] ){//세로
						$vertical = true;
					}	      

			    		      	      
		      if($width > $size[0]) $width = $size[0]; 
		      $ratioX = $width / $size[0];
		      
		      if($height > $size[1]) $height = $size[1];
		      $ratioY = $height / $size[1];         
		 
		      if ($ratioX < $ratioY) {
		       $startX = round(($size[0] - ($width / $ratioY))/2);
		       $startY = 0;
		       $size[0] = round($width / $ratioY);
		       $size[1] = $size[1];

		      } else {
		       $startX = 0;
		       $startY = round(($size[1] - ($size[1] / $ratioX))/2);
		       $size[0] = $size[0];
		       $size[1] = round($height / $ratioX); 
	       
		      }

					if( $vertical ){//가로
				     $src_y = ceil($size[1]/2)-ceil($height/2);							
//				     $src_x = ceil($size[0]/2)-ceil($width/2);		
			    }
      
        }
        

        
//        $relfile = $this->webroot.$this->themeWeb.$this->cacheDir.'/'.$width.'x'.$height.'_'.basename($path); // relative file
        $relfile = $this->cacheDir.DS.$width.'x'.$height.'_'.basename($path);  // location on server
        $cachefile = $fullpath.$this->cacheDir.DS.$width.'x'.$height.'_'.basename($path);  // location on server
        
        if (file_exists($cachefile)) {
            $csize = getimagesize($cachefile);
            $cached = ($csize[0] == $width && $csize[1] == $height); // image is cached
            if (@filemtime($cachefile) < @filemtime($url)) // check if up to date
                $cached = false;
        } else {
            $cached = false;
        }

        if (!$cached) {
            $resize = ($size[0] >= $width || $size[1] >= $height) || ($size[0] < $width || $size[1] < $height);
        } else {
            $resize = false;
        }

        
        if ($resize) {
        
            $image = call_user_func('imagecreatefrom'.$types[$size[2]], $url);
            if (function_exists("imagecreatetruecolor") && ($temp = imagecreatetruecolor($width, $height))) {
                imagecopyresampled ($temp, $image, 0, 0, $src_x, $src_y, $width, $height, $size[0], $size[1]);
              } else {
                $temp = imagecreate ($width, $height);
                imagecopyresized ($temp, $image, 0, 0, $src_x, $src_y, $width, $height, $size[0], $size[1]);
            }
		        $folder = new Folder(dirname($cachefile),true);
		        
            call_user_func("image".$types[$size[2]], $temp, $cachefile);
            imagedestroy ($image);
            imagedestroy ($temp);
        }         
        
			return $this->output(sprintf($this->Html->image($relfile,$htmlAttributes)));
    }
}