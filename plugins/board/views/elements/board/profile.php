<?=$html->css(array('/js/jquery/plugins/bubblepopup/jquery.bubblepopup'),null,array('inline'=>false));?>
<?=$javascript->link(array('/js/jquery/plugins/bubblepopup/jquery.bubblepopup.min'),false);?>
<script type="text/javascript">
//<![CDATA[
$(function(){
	$('span.profile').CreateBubblePopup();

	
		$('span.profile').SetBubblePopupOptions({
					selectable: true,
					position: '<?=$position?>',
					align: '<?=$align?>',
					tail	 : {align:'<?=$tail?>',hidden: false},
					innerHtml: '<div style="width:250px;height:100px"><img src="/js/jquery/plugins/bubblepopup/loading.gif" style="border:0px; vertical-align:middle; margin-right:10px; display:inline;" />loading!</div>',
					innerHtmlStyle: { color:'#000', 'text-align':'center' },
					themeName: 'azure',
					themePath: '/js/jquery/plugins/bubblepopup/jquerybubblepopup-theme',
					alwaysVisible: false,		
					closingDelay: 200					
				});	
		// add a mouseover event for the "button" element...
		$('span.profile').mouseover(function(){

				//get a reference object for "this" target element
				var $profile = $(this);
				
				//load data asynchronously when mouse is over...
				$.post('/board/profile/'+$profile.attr('bid'),{'data[data]':$profile.attr('data')}, function(data) {
	
					//////////////////////////////////////////////////////////
					// IN THIS EXAMPLE,
					// the .get() method loads the data immediately, 
					// then we force the script to pause for 2 seconds, 
					// to see the loading effect; this is only an example,
					// feel free to delete this code in a real application...
					//
					var seconds_to_wait = 2;
					function pause(){
						var timer = setTimeout(function(){
							seconds_to_wait--;
							if(seconds_to_wait > 0){
								pause();
							}else{
	
								//set new innerHtml for the Bubble Popup
								$profile.SetBubblePopupInnerHtml(data, false); //false -> it shows new innerHtml but doesn't save it, then the script is forced to load everytime the innerHtml... 
								
								// take a look in documentation for SetBubblePopupInnerHtml() method
	
							};
						},100);
					};pause();
					//////////////////////////////////////////////////////////
	
				}) 

		}).css({cursor:'pointer'}); //end mouseover event	
})

//]]>
</script>
