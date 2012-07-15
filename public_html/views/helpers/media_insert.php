<?php 
class MediaInsertHelper extends Helper
{

		function get_embed_type($file){
		
			$ext = @strtolower(array_pop(explode('.',$file)));
			
			switch($ext){	
				case 'wmv':
					return 'video/x-ms-wmv';
					break;
				case 'asf':
					return 'video/x-ms-asf';
					break;
				case 'avi':
					return 'video/avi';
					break;
				case 'swf':
					return 'application/x-shockwave-flash';
					break;
				default:
					return 'application/x-mplayer2';
			}

		}//end of function get_embed_type

 
		function src($file, $url , $w=480 , $h=272){
		
		$emtype = $this->get_embed_type($file);
		
		$html = <<<__HTML__
<div style="text-align:center;margin:10px;">
 <object classid="clsid:22D6F312-B0F6-11D0-94AB-0080C74C7E95" width="$w" height="$h">
  <PARAM NAME="Filename" VALUE="$url">
  <param name="ClickToPlay" value="true">
  <param name="AutoSize" value="true">
  <param name="AutoStart" value="true">
  <param name="ShowControls" value="true">
  <param name="ShowAudioControls" value="true">
  <param name="ShowDisplay" value="false">
  <param name="ShowTracker" value="true">
  <param name="ShowStatusBar" value="false">
  <param name="EnableContextMenu" value="false">
  <param name="ShowPositionControls" value="false">
  <param name="ShowCaptioning" value="false">
  <param name="AutoRewind" value="true">
  <param name="Enabled" value="true">
  <param name="EnablePositionControls" value="true">
  <param name="EnableTracker" value="true">
  <param name="PlayCount" value="1">
  <param name="SendWarningEvents" value="true">
  <param name="SendErrorEvents" value="true">
  <param name="SendKeyboardEvents" value="false">
  <param name="SendMouseClickEvents" value="false">
  <param name="SendMouseMoveEvents" value="false">
  <param name="ShowGotoBar" value="false">
  <param name="TransparentAtStart" value="false">
  <param name="Volume" value="0">
	<embed src="$url" type="$emtype" width="$w" height="$h" showtracker="1" showcontrols="1" showpositioncontrols="1" showdisplay="1" showstatusbar="1"></embed>
 </object>
</div>
__HTML__;
			return $html;
		}//end of src
		
}//end of class