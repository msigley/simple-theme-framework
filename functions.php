<?php
	// enables wigitized sidebars
	if ( function_exists('register_sidebar') ) {

		// Sidebar Widget
		// Location: the sidebar
		register_sidebar(array('name'=>'Sidebar',
			'before_widget' => '<div class="widget-area widget-sidebar"><ul>',
			'after_widget' => '</ul></div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>',
		));
		
		// Mobile Sidebar Widget
		// Location: the mobile sidebar
		register_sidebar(array('name'=>'Mobile Sidebar',
			'before_widget' => '<div class="widget-area widget-sidebar"><ul>',
			'after_widget' => '</ul></div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>',
		));

	}

	// post thumbnail support
	add_theme_support( 'post-thumbnails' );

	// custom menu support
	add_theme_support( 'menus' );
	if ( function_exists( 'register_nav_menus' ) ) {
	  	register_nav_menus(
	  		array(
	  		  'header-menu' => 'Header Menu',
			  'header-menu-mobile' => 'Header Menu Mobile'
	  		)
	  	);
	}
	
	// Add first/last classes to the nav menus
	function nav_menu_add_classes( $items, $args ) {
	    //Add first item class
	    $items[1]->classes[] = 'menu-item-first';
	
	    //Add last item class
	    $i = count($items);
	    while($items[$i]->menu_item_parent != 0 && $i > 0) {
	        $i--;
	    }
	    $items[$i]->classes[] = 'menu-item-last';
	
	    return $items;
	}
	add_filter( 'wp_nav_menu_objects', 'nav_menu_add_classes', 10, 2 );
	
	//Removes detailed login error information for security
	add_filter('login_errors',create_function('$a', "return null;"));
	
	//Removes the WordPress version from your header for security
	function remove_version() {
		return '';
	}
	add_filter('the_generator', 'remove_version');
	
	//Allows wordpress to handle the inclusion of the javascript libraries
	function include_js_files() {
		//Register Javascript Files
		wp_register_script('jquery-init', get_template_directory_uri().'/js/jquery-init.js', array('jquery'));
		wp_register_script('nivoslider', get_template_directory_uri().'/js/jquery.nivo.slider.pack.js', array('jquery-init'));
		wp_register_script('nivoslider-init', get_template_directory_uri().'/js/jquery.nivo.slider.pack-init.js', array('nivoslider'));
		wp_register_script('ddsmoothmenu', get_template_directory_uri().'/js/ddsmoothmenu.js', array('jquery-init'));
		wp_register_script('ddsmoothmenu-init', get_template_directory_uri().'/js/ddsmoothmenu-init.js', array('ddsmoothmenu'));
		wp_register_script('googlewebfonts-config', get_template_directory_uri().'/js/google.webfonts-config.js', false);
		wp_register_script('googlewebfonts', get_template_directory_uri().'/js/google.webfonts.js', array('googlewebfonts-config'));
		
		//Enqueue Javascript Files
		wp_enqueue_script('nivoslider-init');
		wp_enqueue_script('ddsmoothmenu-init');
		wp_enqueue_script('googlewebfonts');
	}
	add_action('wp_enqueue_scripts', 'include_js_files');
	
	//Allows wordpress to handle the inclusion of the CSS libraries
	function include_css_files() {
		//Register CSS Libraries
		wp_register_style('reset', get_template_directory_uri().'/css/reset.css');
		wp_register_style('960-grid', get_template_directory_uri().'/css/960_24_col.css');
		wp_register_style('oocss-spacing', get_template_directory_uri().'/css/spacing.css');
		wp_register_style('oocss-typography', get_template_directory_uri().'/css/typography.css');
		wp_register_style('ddsmoothmenu', get_template_directory_uri().'/css/ddsmoothmenu.css');
		
		//Enqueue Styles
		wp_enqueue_style('reset');
		wp_enqueue_style('960-grid');
		wp_enqueue_style('oocss-spacing');
		wp_enqueue_style('oocss-typography');
		wp_enqueue_style('ddsmoothmenu');
	}
	add_action('wp_print_styles', 'include_css_files');
	
	//Register ddsmoothmenu javascript for dropdown menus
	wp_register_script('ddsmoothmenu', 
		get_bloginfo('template_directory') . '/js/ddsmoothmenu.js');
	wp_register_script('ddsmoothmenu-init', 
		get_bloginfo('template_directory') . '/js/ddsmoothmenu-init.js',
		array('ddsmoothmenu'));
	
	//Register jQuery init javascript for turning jQuery's noConflict mode off
	wp_register_script('jquery-init', 
		get_bloginfo('template_directory') . '/js/jquery-init.js',
		array('jquery'));
	
	//Register Nivo Slider for JQuery Image Slideshows
	wp_register_script('nivo-slider', 
		get_bloginfo('template_directory') . '/js/jquery.nivo.slider.pack.js');
	wp_register_script('nivo-slider-init',
		get_bloginfo('template_directory') . '/js/jquery.nivo.slider.init.js',
		array('nivo-slider'));
	
	//Completely Disable Trackbacks
	function disable_all_trackbacks($open, $post_id) {
		return false;
	}
	add_filter('pings_open', 'disable_all_trackbacks', 10, 2);
	
	//Removes Trackbacks from the comment count
	function comment_count( $count ) {
		if ( ! is_admin() ) {
			global $id;
			$comments_by_type = &separate_comments(get_comments('status=approve&post_id=' . $id));
			return count($comments_by_type['comment']);
		} else {
			return $count;
		}
	}
	add_filter('get_comments_number', 'comment_count', 0);
	
	// custom excerpt ellipses for 2.9+
	function custom_excerpt_more($more) {
		return 'Read More &raquo;';
	}
	add_filter('excerpt_more', 'custom_excerpt_more');
	// no more jumping for read more link
	function no_more_jumping($post) {
		return '<a href="'.get_permalink($post->ID).'" class="read-more">'.'Continue Reading'.'</a>';
	}
	add_filter('excerpt_more', 'no_more_jumping');
	
	// category id in body and post class
	function category_id_class($classes) {
		global $post;
		foreach((get_the_category($post->ID)) as $category)
			$classes [] = 'cat-' . $category->cat_ID . '-id';
			return $classes;
	}
	add_filter('post_class', 'category_id_class');
	add_filter('body_class', 'category_id_class');
	
	//Browser body classes
	//Source: http://wpquicktips.wordpress.com/2010/09/01/add-the-browser-name-and-version-to-the-body-class/
	function mytheme_body_class( $class ) {
		$arr = array(
			'msie',
			'firefox',
			'webkit',
			'opera');
		$agent = strtolower( $_SERVER['HTTP_USER_AGENT'] );
		
		foreach( $arr as $name ) {
			if( strpos( $agent, $name ) > -1 ) {
				$class[] = $name;
				
				preg_match( '/' . $name . '[\/|\s]([0-9]+)/i', $agent, $matches );
				if ( $matches[1] )
				$class[] = $name . '-' . $matches[1];
				
				return $class;
			}
		}
		
		return $class;
	}
	add_filter( 'body_class', 'mytheme_body_class' );
?>