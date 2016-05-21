<?php

/***** Load Stylesheets *****/

function mh_squared_child_styles() {
    wp_enqueue_style('mh-squared-parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('mh-squared-child-style', get_stylesheet_directory_uri() . '/style.css', array('mh-squared-parent-style'));
}
add_action('wp_enqueue_scripts', 'mh_squared_child_styles');


/***** Add FB meta tag  to Header *****/
function hook_facebook_meta() {

	$output='<meta property="fb:pages" content="816914461664341" />';

	echo $output;

}
add_action('wp_head','hook_facebook_meta');




/***** Zerg Net Advertising Block *****/

if (!function_exists('ad_zergnet_bottom_blocks')) {
	function ad_zergnet_bottom_blocks() {?>

					<div class="related-content-wrap">
						<h4 class="related-content-title">
                        	FROM AROUND THE WEB
						</h4>

						<div class="related-content mh-row clearfix">
                        
<div id="zergnet-widget-37226"></div>

<script language="javascript" type="text/javascript">
        (function() {
                var zergnet = document.createElement('script');
                zergnet.type = 'text/javascript'; zergnet.async = true;
                zergnet.src = 'http://www.zergnet.com/zerg.js?id=37226';
                var znscr = document.getElementsByTagName('script')[0];
                znscr.parentNode.insertBefore(zergnet, znscr);
        })();
</script>

                        </div>
					</div><?php

	}
}







?>