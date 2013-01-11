<?php

/*
	Plugin Name: Add URL Slugs as Body Classes
	Plugin URI: http://aarontgrogg.com/2012/02/24/wordpress-plugin-add-url-slugs-as-body-classes/
	Description: Add page name and/or category slugs as additional `&lt;body&gt;` classes.
	Version: 1.1
	Author: Aaron T. Grogg
	Author URI: http://aarontgrogg.com/
	License: GPLv2 or later
*/


//	Add deconstructed URI as <body> classes
	function bc_add_body_class( $classes)  { // $classes = array of additional classes to add
		global $post;
		if ($post && $post->ID) {
			foreach((get_the_category($post->ID)) as $category) {
				$classes[] = trim($category->category_nicename);
			}
			$url = get_bloginfo('url');
			$protocol = (strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === FALSE) ? 'http' : 'https';
			$base = $protocol .'://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			$bodyclass = trim(str_replace($url,'',$base));
			$bodyclass = explode('/',$bodyclass);
			foreach($bodyclass as $category) {
				$classes[] = trim($category);
			}
		}
		return array_unique($classes);
	}
	add_filter('post_class', 'bc_add_body_class');
	add_filter('body_class', 'bc_add_body_class');

?>
