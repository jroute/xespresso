<h2 class="post_title">
	<?php if (is_page() || is_single()) { ?>
		<?php the_title(); ?>
	<?php } else { ?>
		<a href="<?php the_permalink() ?>" title="<?php _e('Permanent Link to', 'default'); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
	<?php } ?>
</h2>
<p class="post_meta">
    <span class="date"><?php _e('Posted on'); ?> <?php the_time(__('F jS, Y', 'default')) ?>, <?php the_time('g:i a'); ?></span>
    <span class="author"><?php _e('by'); ?> <?php the_author() ?></span>
</p>
<div class="post_content">
<?php the_content(__('Read the rest of this entry &raquo;', 'default')); ?>
</div>
<?php $parts = wp_link_pages(array('before'=>'Part: ','after'=>'','link_before'=>'<span>','link_after'=>'</span>', 'echo'=>0));
if(trim($parts) != "") { ?>
    <div class="post-pages">
        <?php echo $parts; ?>
        <div class="clear"></div>
    </div>
<?php } ?>
<?php if (!is_page()) { ?>
<div class="info">
    <span class="comment">
        <a href="<?php comments_link(); ?>"><?php comments_number( __( 'No comments', 'default' ), __( '1 comment', 'default' ), __( '% comments', 'default' ),  __( 'comments', 'default' )); ?></a>
    </span>
    <span class="cats">
        <?php the_category(', ') ?>
    </span>
</div>
<?php } ?>
<?php if (!is_page()) { ?>
<!--div class="moreinfo">
    <span class="cats"><img src="<?php bloginfo('template_url'); ?>/images/categoryicon.png" />&nbsp;<?php the_category(', ') ?></span>
    <?php the_tags('<span class="tags">', ', ', '</span>'); ?>
</div-->
<?php } ?>