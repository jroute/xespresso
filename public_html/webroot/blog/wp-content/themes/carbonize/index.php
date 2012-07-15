<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <?php get_header(); ?>
</head>

<body>
<div id="wrapper">
    <?php include (TEMPLATEPATH . "/banner.php"); ?>
    <div id="container">
        <div class="content_top"></div>
        <div class="content_center">
            <ul class="posts">
              <?php if (have_posts()) : ?>
              <?php while (have_posts()) : the_post(); ?>
              <li>
          		<?php include (TEMPLATEPATH . "/item.php"); ?>
          		<br />
                <?php if (!is_page()) { ?>
                <?php if (function_exists('wp_list_comments')): ?>
      			<!-- WP 2.7 and above -->
      			<?php comments_template('', true); ?>

      			<?php else : ?>
      			<!-- WP 2.6 and below -->
      			<?php comments_template(); ?>
          		<?php endif; ?>
                <?php } ?>
          	</li>
          	<?php endwhile; ?>
          	<?php else : ?>
          	<li>
          		<?php include (TEMPLATEPATH . "/missing.php"); ?>
          	</li>
          	<?php endif; ?>
          	<li>
                <?php if (!is_page()) { ?>
          		<div class="navigation">
            	    <div class="fl"><?php next_posts_link(trim(__('&laquo; Older Entries', 'default'))) ?></div>
                    <div class="fr"><?php previous_posts_link(trim(__('Newer Entries &raquo;', 'default'))) ?></div>
                 	<div class="clear"></div>
                </div>
                <?php } ?>
              </li>
            </ul>
        </div>
        <div class="content_bottom"></div>
    </div>
    <?php include(TEMPLATEPATH."/sidebar.php");?>
    <div class="clear"></div>
    <?php get_footer(); ?>
</div>
</body>

</html>
