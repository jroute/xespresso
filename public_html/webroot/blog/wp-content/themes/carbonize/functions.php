<?php
if ( function_exists('register_sidebars') )
    register_sidebars(1);
?>
<?php
function mytheme_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
            <div class="com-wrapper <?php if (1 == $comment->user_id) echo "admin"; ?>">
	        	<div id="comment-<?php comment_ID(); ?>" class="com-header">
					<span class="avtar"><?php if(function_exists('get_avatar')) { echo get_avatar($comment, '48', get_bloginfo('stylesheet_directory').'/images/gravtar.png'); } ?></span>
                    <br />
                    <span class="commentauthor"><?php comment_author_link() ?></span>
	            </div>
                <div class="com-text">
    				<div class="comment_content">
                        <?php if ($comment->comment_approved == '0') : ?>
    	                    <?php _e('Your comment is awaiting moderation', 'default'); ?>
    	                <?php endif; ?>
                        <p class="commentmetadata">
                            <a href="#comment-<?php comment_ID() ?>" title=""><?php printf( __('%1$s at %2$s', 'default'), get_comment_time(__('F jS, Y', 'default')), get_comment_time(__('H:i', 'default')) ); ?></a>
                       	    <?php edit_comment_link(__('Edit', 'default'),'&nbsp;&nbsp;',''); ?>
                        </p>
                        <p>
                            <?php comment_text() ?>
                        </p>
                    </div>
                    <div class="reply">
    			    	<p><?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></p>
    			    </div>
                </div>

                <div class="clear"></div>
		    </div>
<?php
        }



function mytheme_ping($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>

		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
			<div class="com-wrapper">
                <div id="comment-<?php comment_ID(); ?>" class="com-header">
					<span class="avtar"><?php if(function_exists('get_avatar')) { echo get_avatar($comment, '48', get_bloginfo('stylesheet_directory').'/images/gravtar.png'); } ?></span>
                    <br />
                    <span class="commentauthor"><?php comment_author_link() ?></span>
	            </div>
                <div class="com-text">
    				<div class="comment_content">
                        <?php if ($comment->comment_approved == '0') : ?>
    	                    <?php _e('Your comment is awaiting moderation', 'default'); ?>
    	                <?php endif; ?>
                        <p class="commentmetadata">
                            <a href="#comment-<?php comment_ID() ?>" title=""><?php printf( __('%1$s at %2$s', 'default'), get_comment_time(__('F jS, Y', 'default')), get_comment_time(__('H:i', 'default')) ); ?></a>
                       	    <?php edit_comment_link(__('Edit', 'default'),'&nbsp;&nbsp;',''); ?>
                        </p>
                        <p>
                            <?php comment_text() ?>
                        </p>
                    </div>
    			    <div class="reply">
    			    	<p><?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></p>
    			    </div>
                </div>

                <div class="clear"></div>
			</div>
<?php
        }

?>