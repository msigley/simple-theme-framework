<?php
global $post, $open_graph;

$page_title = '';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" /><?php /* Force IE to not use compatibility mode. This must always be the first line in the head. */ ?>
	<?php
	$page_title = wp_title('', false); //Page title is structured in SEO plugin.
	?>
	<title><?php echo $page_title; ?></title>
	<meta name="googlebot" content="NOODP" />
	<?php if ( is_home() || is_front_page() ) : ?>
		<meta name="description" content="This is the home page meta description." />
	<?php endif; ?>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<!--Open Graph Meta for Social Media-->
	<?php
	if( isset( $open_graph['title'] ) ) {
		?>
		<meta property="og:title" content="<?php echo $open_graph['title'] ?>" />
		<?php
		unset( $open_graph['title'] );
	} else {
		?>
		<meta property="og:title" content="<?php echo '['.get_bloginfo('name').'] '.$page_title; ?>" />
		<?php
	}
	
	if( isset( $open_graph['type'] ) ) {
		?>
		<meta property="og:type" content="<?php echo $open_graph['type'] ?>" />
		<?php
		unset( $open_graph['type'] );
	} else {
		?>
		<meta property="og:type" content="website" />
		<?php
	}
	
	if( isset( $open_graph['url'] ) ) {
		?>
		<meta property="og:url" content="<?php echo $open_graph['url'] ?>" />
		<?php
		unset( $open_graph['url'] );
	} else {
		?>
		<meta property="og:url" content="<?php echo get_permalink($post->ID); ?>" />
		<?php
	}
	
	if( isset( $open_graph['image'] ) ) {
		?>
		<meta property="og:image" content="<?php echo $open_graph['image'] ?>" />
		<?php
		unset( $open_graph['image'] );
	} else {
		$post_thumb = get_post_thumbnail_id($post->ID);
		if( !empty($post_thumb) ) {
			$post_thumb = wp_get_attachment_url($post_thumb);
			?>
			<meta property="og:image" content="<?php echo $post_thumb; ?>" />
			<?php
		} else {
			?>
			<meta property="og:image" content="<?php bloginfo( 'template_url' ); ?>/images/ogmeta_thumb.jpg" />
			<?php
		}
	}
	
	if( isset( $open_graph['description'] ) ) {
		?>
		<meta property="og:description" content="<?php echo $open_graph['description'] ?>" />
		<?php
		unset( $open_graph['description'] );
	} elseif( is_single() ) {
		?>
		<meta property="og:description" content="<?php echo $post->post_excerpt; ?>" />
		<?php
	} else {
		?>
		<meta property="og:description" content="" />
		<?php
	}
	
	if ( !empty($open_graph) && is_array($open_graph) ) {
		foreach ( $open_graph as $property => $content ) {
			?>
			<meta property="og:<?php echo $property; ?>" content="<?php echo $content; ?>" />
			<?php
		}
	}
	?>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="icon" href="<?php bloginfo('template_url'); ?>/favicon.ico" type="image/x-icon" />
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?>" href="<?php bloginfo( 'rss2_url' ); ?>" />
	<link rel="alternate" type="application/atom+xml" title="<?php bloginfo( 'name' ); ?>" href="<?php bloginfo( 'atom_url' ); ?>" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <div id="wrapper" class="container_12"><!-- this encompasses the entire website except #footer -->
        <header class="grid_12 mbm">
            <h1><?php bloginfo( 'site_title' ); ?></h1>
        </header>
        
        <nav id="nav-primary" class="nav grid_12 mbm">
            <!--Primary Navigation-->
            <?php wp_nav_menu( array( 'container_id' => 'menu', 'container_class' => 'ddsmoothmenu', 'theme_location' => 'header-menu' ) ); ?>
        </nav><!--#nav-primary-->
        
        <div id="content-wrap" class="container_12 mbm">