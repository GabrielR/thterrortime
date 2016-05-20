<?php /* Template Name: Full-Width */ ?>
<?php get_header(); ?>
<div class="mh-row clearfix">
	<div id="main-content" class="page-full-width"><?php
		mh_squared_before_page_content();
		if (have_posts()) :
			while (have_posts()) : the_post();
				get_template_part('content', 'page');
			endwhile;
			get_template_part('comments', 'pages');
		endif; ?>
	</div>
</div>
<?php get_footer(); ?>