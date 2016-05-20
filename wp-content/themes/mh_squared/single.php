<?php get_header(); ?>
<div class="mh-row clearfix">
	<div id="main-content" class="mh-content"><?php
		mh_squared_before_post_content();
		if (have_posts()) :
			while (have_posts()) : the_post();
				get_template_part('content', 'single');
				mh_squared_postnav();
				mh_squared_authorbox();
				mh_squared_related_posts();
			endwhile;
			comments_template();
		else :
			get_template_part('content', 'none');
		endif; ?>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>