<?=$javascript->link('/ratings/js/rating_jquery',false);?>
<?=$html->css('/ratings/css/rating');?>
  
<div id="pages-wrap">
<?=$content['content']?>
</div>


<?php
if( Configure::read('Content.rating') ){
echo $this->element('rating', array('plugin' => 'ratings',
                                    'model' => 'Contents.Content',
                                    'id' =>$id,
                                    'config'=>'plugin_rating',//생략가능 plugins/ratings/plugin_rating.php load
                                    'name'=>'page'//생략 가능 element id
                                    ));
}
?> 

<?php
if( Configure::read('Content.comment') ){

echo $this->element('comment', array('plugin' => 'comment',
                                    'model' => 'Contents.Content',
                                    'key'=>'page',
                                    'id' =>$id,
                                   	'return_url'=>$this->here,
                                    'mailto'=>array(
                                    	'name'=>'',
                                    	'email'=>'',
                                    	'subject'=>'',
                                    	)
                                    ));
                                    
}
?> 



<?

if( (int)$session->Read('User.level') >= $allow_level || (int)$session->Read('Admin.level') >= $allow_level ){
	echo $editor->page($_editor,'page-content','99%','500');

	echo $javascript->codeBlock("
		var editMode = false;

		$(function(){

			$('#pages-wrap').dblclick(function(){
					
				var src = $(this).html();
				var width = $(this).css('width');

				$(this).empty();

				$(this).append($(\"<textarea style='width:\" + width + \";height:800px' id='page-content'>\" + src + \"</textarea>\").hide());
				
				setTimeout(function(){
					setEditor(); 
					editMode = true;
				},500);
			});

			$('body').dblclick(function(){
				if( editMode == true ){

					var src = '';
					
					try{
						src = _editor.getData();
					}catch(e){
						src = _editor.outputBodyHTML();
					}

					$.ajax({
						url:'/pages/edit/$id',
						type:'post',
						data:{content:src},
						success:function(data){
							if( data == 'success' ){
								editMode=false;
							}else{
								window.alert('수정 할 수 없습니다.');
							}
							$('#pages-wrap').empty();
							$('#pages-wrap').html(src);
						}
					});

				}
			});

		});
	",array("inline"=>false));

}//
?>