<?php

require_once(__DIR__ . '/functions/wp_childpages.php');
require_once(__DIR__ . '/functions/wp_information.php');

function load_stylesheets()
{
	wp_register_style('custom', get_template_directory_uri() . '/assets/css/style.min.css', array(), false, 'all');
	wp_enqueue_style('custom');
}


function prefix_add_footer_styles()
{
	wp_enqueue_style('custom-fa', 'https://use.fontawesome.com/releases/v5.0.6/css/all.css');

	wp_register_style('style', get_template_directory_uri() . '/style.css', array(), false, 'all');
	wp_enqueue_style('style');
};
add_action('get_footer', 'prefix_add_footer_styles');


/*function add_rel_preload($html, $handle, $href, $media) {

    if (is_admin())
        return $html;

     $html = <<<EOT
<link rel='preload' as='style' onload="this.onload=null;this.rel='stylesheet'" id='$handle' href='$href' type='text/css' media='all' />
EOT;
    return $html;
}
add_filter( 'style_loader_tag', 'add_rel_preload', 10, 4 );
*/


add_action('wp_enqueue_scripts', 'load_stylesheets');


function smartwp_remove_wp_block_library_css()
{
	//wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style('wp-block-library-theme');
	wp_dequeue_style('wc-block-style');
	//wp_dequeue_style( 'custom' );
}
add_action('wp_enqueue_scripts', 'smartwp_remove_wp_block_library_css', 100);

//pre load fonts
add_action('wp_head', 'load_fonts');
function load_fonts()
{
?>
	<!-- <link rel="preconnect" href="https://fonts.gstatic.com"> -->
	<link rel="preload" as="font" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" crossorigin="anonymous">
<?php
}


function load_js()
{
	// wp_enqueue_style('costum-google-fonts', '//fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&family=Open+Sans:wght@300;400;600;800&display=swap');
	wp_register_script('scriptjs', get_template_directory_uri() . '/assets/js/script.min.js', '', 1, true);
	wp_enqueue_script('scrollscript', get_template_directory_uri() . '/assets/js/scrollScript.min.js', array(), false, true);
	wp_enqueue_script('scriptjs');
}

add_action('wp_enqueue_scripts', 'load_js');


function add_menuclass($ulclass)
{
	return preg_replace('/<a /', '<a class="nav-link"', $ulclass);
}
add_filter('wp_nav_menu', 'add_menuclass');


add_theme_support('menus');

add_theme_support('post-thumbnails');

register_nav_menus(
	array(

		'top-menu' => __('Top Menu', 'theme'),
		'footer-menu' => __('Footer Menu', 'theme'),

	)
);


function mytheme_setup()
{
	add_theme_support('custom-logo', array(
		'height'      => 100,
		'width'       => 400,
		'flex-height' => true,
		'flex-width'  => true,
	));
}

add_action('after_setup_theme', 'mytheme_setup');


add_filter('get_custom_logo', 'change_logo_class');

function change_logo_class($html)
{

	$html = str_replace('custom-logo', 'img-fluid', $html);
	$html = str_replace('custom-logo-link', 'img-fluid', $html);

	return $html;
}



add_image_size('smallest', 300, 300, true);
add_image_size('Medium', 500, 500, true);
add_image_size('large', 1000, 800, true);
add_image_size('largest');



function custom_widgets_init()
{
	register_sidebar(
		array(
			'name'          => __('Blog Sidebar', 'blazemedia'),
			'id'            => 'sidebar-1',
			'description'   => __('Add widgets here to appear in your sidebar on blog posts and archive pages.', 'twentyseventeen'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => __('Footer 1', 'blazemedia'),
			'id'            => 'sidebar-2',
			'description'   => __('Add widgets here to appear in your footer.', 'blazemedia'),
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '',
			'after_title'   => '',
			'class' => 'list-group',
		)
	);

	register_sidebar(
		array(
			'name'          => __('Footer 2', 'blazemedia'),
			'id'            => 'sidebar-3',
			'description'   => __('Add widgets here to appear in your footer.', 'blazemedia'),
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '',
			'after_title'   => '',
			'class' => 'list-group',
		)
	);

	register_sidebar(
		array(
			'name'          => __('Footer 3', 'blazemedia'),
			'id'            => 'sidebar-4',
			'description'   => __('Add widgets here to appear in your footer.', 'blazemedia'),
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '',
			'after_title'   => '',
			'class' => 'list-group',
		)
	);

	register_sidebar(
		array(
			'name'          => __('Single Archive Sidebar', 'blazemedia'),
			'id'            => 'sidebar-5',
			'description'   => __('Add widgets here to appear in your footer.', 'blazemedia'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h5 class="widget-title">',
			'after_title'   => '</h5>',
			'class' => 'list-group',
		)
	);

	register_sidebar(
		array(
			'name'          => __('Single Page Sidebar', 'blazemedia'),
			'id'            => 'sidebar-6',
			'description'   => __('Add widgets here to appear in your footer.', 'blazemedia'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
			'class' => 'list-group',
		)
	);

	register_sidebar(
		array(
			'name'          => __('Nav Sidebar', 'blazemedia'),
			'id'            => 'sidebar-7',
			'description'   => __('Add widgets here to appear in your navigation.', 'blazemedia'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
			'class' => 'list-group',
		)
	);
}

add_action('widgets_init', 'custom_widgets_init');


function custom_excerpt_length($length)
{
	return 30;
}
add_filter('excerpt_length', 'custom_excerpt_length', 999);

function my_theme_archive_title($title)
{
	$h1open = "<h1  class='text-left display-3 text-light' style='z-index: 100' data-trigger='titleTrigger' data-scroll-speed='+100'>";
	$h1close = "</h1>";
	$postby = "<p class='mb-0' style='z-index: 100' data-trigger='titleTrigger' data-scroll-speed='+100'>Showing Posts By</p>";
	$postfrom = "<p class='mb-0' style='z-index: 100' data-trigger='titleTrigger' data-scroll-speed='+100'>Showing Posts From</p>";
	$postin = "<p class='mb-0' style='z-index: 100' data-trigger='titleTrigger' data-scroll-speed='+100'>Showing Posts In</p>";

	if (is_category()) {
		$archive = single_cat_title('', false);
		$title = $postin;
		$title .= $h1open . $archive . $h1close;
	} elseif (is_tag()) {
		$archive = single_tag_title('', false);
		$title = $postfrom;
		$title .= $h1open . $archive . $h1close;
	} elseif (is_author()) {
		$archive = '<span class="vcard">' . get_the_author_meta('first_name') . " " . get_the_author_meta('last_name') . '</span>';
		$title = single_term_title('', false);
		$title = $postby;
		$title .= $h1open . $archive . $h1close;
	} elseif (is_post_type_archive()) {
		$archive = post_type_archive_title('', false);
		$title = single_term_title('', false);
		$title = $postfrom;
		$title .= $h1open . $archive . $h1close;
	} elseif (is_tax()) {
		$title = single_term_title('', false);
		$title = $postfrom;
		$title .= $h1open . $title . $h1close;
	} elseif (is_date()) {
		/* translators: Yearly archive title. %s: Year. */
		$date = get_the_date(_x('', 'Y'));
		$title = $postfrom;
		$title .= $h1open . $date . $h1close;
	}

	return $title;
}

add_filter('get_the_archive_title', 'my_theme_archive_title');
require_once(__DIR__ . '/functions/wp_category.php');
