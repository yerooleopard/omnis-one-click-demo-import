<?php
// function omnis_ocdi_plugin_page_setup( $default_settings ) {
// 	$default_settings['parent_slug'] = 'omnis-theme';
// 	$default_settings['page_title']  = esc_html__( 'Omnis One Click Demo Import' , 'pt-ocdi' );
// 	$default_settings['menu_title']  = esc_html__( 'Import Demo Data' , 'pt-ocdi' );
// 	$default_settings['capability']  = 'import';
// 	$default_settings['menu_slug']   = 'omnis-one-click-demo-import';

// 	return $default_settings;
// }
// add_filter( 'pt-ocdi/plugin_page_setup', 'omnis_ocdi_plugin_page_setup' );

add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

function omnis_ocdi_confirmation_dialog_options ( $options ) {
	return array_merge( $options, array(
		'width'       => 500,
		'dialogClass' => 'wp-dialog',
		'resizable'   => false,
		'height'      => 'auto',
		'modal'       => true,
	) );
}
add_filter( 'pt-ocdi/confirmation_dialog_options', 'omnis_ocdi_confirmation_dialog_options', 10, 1 );