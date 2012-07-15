<div id="banner">
    <div id="logo">
        <h1><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
        <p id="description"><?php bloginfo('description'); ?></p>
    </div>
    <div id="subscribe">
        <span class="postsrss"><a href="<?php bloginfo('rss2_url'); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/rss_icon.png" />&nbsp;<?php _e('Subscribe to Posts'); ?></a></span>
        <span class="commentsrss"><a href="<?php bloginfo('comments_rss2_url'); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/rss_icon.png" />&nbsp;<?php _e('Subscribe to Comments'); ?></a></span>
    </div>
    <div class="clear"></div>
    <div id="menu">
        <ul id="nav">
            <li<?php if(!is_page() ) {?> class="current_page_item"<?php }?> id="home_li"><a href="<?php bloginfo('home'); ?>"><?php _e('Home'); ?></a></li>
            <?php wp_list_pages('depth=1&title_li='); ?>
        </ul>
    </div>
</div>