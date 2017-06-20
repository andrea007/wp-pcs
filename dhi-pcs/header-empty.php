<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<?php if(get_option('eventerra_responsive') == 'true') : ?><meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1" /><?php endif; ?>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?><link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>"><?php endif; ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class() ?>>
	<div class="body-inner">
		<div class="container">

			<div class="content-footer">