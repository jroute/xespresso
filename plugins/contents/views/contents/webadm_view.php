<div id="navigation-bar">
	<?=$this->element('webadm_navigation_bar');?>
</div>

<div id='content'>
<div id="pages-wrap">

<?=$this->data['content']?>

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
                                    0,
                                    base64_encode($this->here)                                    
                                    ));
}
?>

</div>