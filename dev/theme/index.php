<?php

if ( ! class_exists( 'Timber' ) ) :
  echo 'Timber not activated. Make sure you activate the plugin in <a href="/wp-admin/plugins.php#timber">/wp-admin/plugins.php</a>';
	return;
endif;

$context = Timber::get_context();
$context['posts'] = Timber::get_posts();

$templates = array( 'index.twig' );
if ( is_home() ) :
  array_unshift( $templates, 'home.twig' );
endif;

Timber::render( $templates, $context );
