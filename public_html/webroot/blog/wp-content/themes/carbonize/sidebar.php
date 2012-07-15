<div id="sidebar">
    <div id="search">
        <form action="<?php bloginfo('home'); ?>/" method="post" id="srch-frm">
            <input type="text" value="" name="s" id="s" />
            <input name="searchsubmit" id="searchsubmit" type="submit" value="" />
        </form>
    </div>

    <!-- If you do not want the tabbed content then ... -->
    <!-- Place your start comment tag here -->
    <div class="sdtab_top"></div>
    <div class="sdtab">
    	<div>
    		<h2><a name="recentposts" id="recentposts"><?php _e('Recent Posts'); ?></a></h2>
    		<ul><?php wp_get_archives('type=postbypost&limit=5'); ?></ul>
    	</div>
    	<div>
    		<h2><a name="recentcomments" id="recentcomments"><?php _e('Recent Comments'); ?></a></h2>
    		<?php include (TEMPLATEPATH . "/recentcomments.php"); ?>
    	</div>
    	<div>
    		<h2><a name="tags" id="tags"><?php _e('Tags'); ?></a></h2>
    		<p><?php wp_tag_cloud('smallest=8&largest=15&orderby=name'); ?> </p>
    	</div>
        <ul class="sdtabs">
    		<li id="firsttab"><a href="#recentposts"><?php _e('Recent Posts'); ?></a></li>
    		<li><a href="#recentcomments"><?php _e('Recent Comments'); ?></a></li>
    		<li id="lasttab"><a href="#tags"><?php _e('Tags'); ?></a></li>
    	</ul>
    </div>
    <div class="sdtab_bottom"></div>
    <!-- Place your end comment tag here -->

    <div class="widget_top"></div>
    <div class="widget_center">
    <ul>
        <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(1) ) : else : ?>
        <li>
        	<h2><?php _e('Archives'); ?></h2>
        	<ul>
                <?php wp_get_archives('type=monthly'); ?>
        	</ul>
        </li>
        <li>
        	<h2><?php _e('Categories'); ?></h2>
        	<ul>
                <?php wp_list_categories('orderby=name&title_li='); ?>
        	</ul>
        </li>
        <?php endif; ?>
    </ul>
    </div>
    <div class="widget_bottom"></div>
</div>