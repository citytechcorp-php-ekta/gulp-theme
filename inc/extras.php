<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Gulpify
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function gulp_theme_body_classes($classes) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if (is_multi_author()) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if (!is_singular()) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter('body_class', 'gulp_theme_body_classes');

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function gulp_theme_pingback_header() {
	if (is_singular() && pings_open()) {
		echo '<link rel="pingback" href="', bloginfo('pingback_url'), '">';
	}
}
add_action('wp_head', 'gulp_theme_pingback_header');

/*==================Admin Login Screen started==================*/
function my_login_logo() {?>
    <style type="text/css">
    	body{
    		box-sizing: border-box !important;
    	}
        #login h1 a, .login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/assets-output/images/logo.png);
            padding-bottom: 20px;
            width:227px !important;
            height:117px !important;
            display: block;
            margin: 0 auto;
            background-size:auto !important;
        }
        body{
        	background: url(wp-content/themes/gulp-theme/assets-output/images/adminBG.jpg) repeat !important;
        }
        #login h1,.login form{
        	width: 100%;
        	float: left;
        }
        .login form {
        	opacity: .9;
        	border: 3px solid #EE2E3B;
        	box-sizing: border-box !important;

        }
        .wp-core-ui p .button {
        	background-color: #89042F;
        }
        .login label {
    		color: #89042F !important;
		}
		#login {
		    width: 350px !important;
		    padding: 3% 0 0 !important;
		}
		.login form .input, .login input[type=text] {
			border: 1px solid #89042F;
		}
		.login #nav{
			width: 50%;float: right;text-align: right;padding: 0 !important;margin-top: 17px !important;
		}
		#backtoblog{
			width: 50%;float: left;text-align: left;padding: 0 !important;
		}
    </style>
<?php }
add_action('login_enqueue_scripts', 'my_login_logo');
add_filter('login_headerurl', 'custom_loginlogo_url');
function custom_loginlogo_url($url) {
	return esc_url(home_url('/'));
}
add_filter('login_headertitle', 'custom_loginlogo_title');
function custom_loginlogo_title($title) {
	return 'Carmelmission.org';
}
/*========================Admin Login Screen Ended=======================*/
/*========================Meta Tags Started=============================*/
function add_meta_tags() {
	global $post;
	if (is_single()) {
		$meta = strip_tags($post->post_content);
		$meta = strip_shortcodes($post->post_content);
		$meta = str_replace(array("\n", "\r", "\t"), ' ', $meta);
		$meta = substr($meta, 0, 125);
		$keywords = get_the_category($post->ID);
		$metakeywords = '';
		foreach ($keywords as $keyword) {
			$metakeywords .= $keyword->cat_name . ", ";
		}
		echo '<meta name="description" content="' . get_post_meta($post->ID, 'montech_meta_description', true) . '" />' . "\n";
		echo '<meta name="keywords" content="' . get_post_meta($post->ID, 'montech_meta_key', true) . '" />' . "\n";
	}
	if (is_page()) {
		echo '<meta name="description" content="' . get_post_meta($post->ID, 'montech_meta_description', true) . '" />' . "\n";
		echo '<meta name="keywords" content="' . get_post_meta($post->ID, 'montech_meta_key', true) . '" />' . "\n";
	}
}
add_action('wp_head', 'add_meta_tags', 1);
/*==========================Meta Tags Ended===============================*/
/*===========================Walker Menu==============================*/
class CSS_Menu_Walker extends Walker {

	var $db_fields = array('parent' => 'menu_item_parent', 'id' => 'db_id');

	function start_lvl(&$output, $depth = 0, $args = array()) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul>\n";
	}

	function end_lvl(&$output, $depth = 0, $args = array()) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
	}

	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {

		global $wp_query;
		$indent = ($depth) ? str_repeat("\t", $depth) : '';
		$class_names = $value = '';
		$classes = empty($item->classes) ? array() : (array) $item->classes;

		/* Add active class */
		if (in_array('current-menu-item', $classes)) {
			$classes[] = 'active';
			unset($classes['current-menu-item']);
		}

		/* Check for children */
		$children = get_posts(array('post_type' => 'nav_menu_item', 'nopaging' => true, 'numberposts' => 1, 'meta_key' => '_menu_item_menu_item_parent', 'meta_value' => $item->ID));
		if (!empty($children)) {
			$classes[] = 'has-sub';
		}

		$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
		$class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

		$id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
		$id = $id ? ' id="' . esc_attr($id) . '"' : '';

		$output .= $indent . '<li' . $id . $value . $class_names . '>';

		$attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
		$attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
		$attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
		$attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';

		$item_output = $args->before;
		$item_output .= '<a' . $attributes . '><span>';
		$item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
		$item_output .= '</span></a>';
		$item_output .= $args->after;

		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
	}

	function end_el(&$output, $item, $depth = 0, $args = array()) {
		$output .= "</li>\n";
	}
}
/*===================Walker Menu Ended===================*/
