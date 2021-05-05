<?php
/**
 * The plugin page view - the "settings" page of the plugin.
 *
 * @package ocdi
 */

namespace OCDI;

$predefined_themes = $this->import_files;

if ( ! empty( $this->import_files ) && isset( $_GET['import-mode'] ) && 'manual' === $_GET['import-mode'] ) {
	$predefined_themes = array();
}

/**
 * Hook for adding the custom plugin page header
 */
Helpers::do_action( 'ocdi/plugin_page_header' );
?>

<div class="ocdi  wrap  about-wrap">

	<?php ob_start(); ?>
		<h1 class="ocdi__title  dashicons-before  dashicons-upload"><?php esc_html_e( 'Omnis Theme Demo Import', 'pt-ocdi' ); ?></h1>
	<?php
	$plugin_title = ob_get_clean();

	// Display the plugin title (can be replaced with custom title text through the filter below).
	echo wp_kses_post( apply_filters( 'pt-ocdi/plugin_page_title', $plugin_title ) );

	// Display warrning if PHP safe mode is enabled, since we wont be able to change the max_execution_time.
	if ( ini_get( 'safe_mode' ) ) {
		printf(
			esc_html__( '%sWarning: your server is using %sPHP safe mode%s. This means that you might experience server timeout errors.%s', 'pt-ocdi' ),
			'<div class="notice  notice-warning  is-dismissible"><p>',
			'<strong>',
			'</strong>',
			'</p></div>'
		);
	}

	// Start output buffer for displaying the plugin intro text.
	ob_start();
	?>

	<div class="ocdi__intro-notice  notice  notice-warning  is-dismissible">
		<p><?php esc_html_e( 'Before you begin, make sure all the required plugins are activated.', 'pt-ocdi' ); ?></p>
	</div>

	<div class="ocdi__intro-text">
		<p class="about-description">
			<?php esc_html_e( 'Importing demo data (post, pages, images, theme settings, ...) is the easiest way to setup your theme.', 'pt-ocdi' ); ?>
			<?php esc_html_e( 'It will allow you to quickly edit everything instead of creating content from scratch.', 'pt-ocdi' ); ?>
		</p>

		<hr>

		<p><?php esc_html_e( 'When you import the data, the following things might happen:', 'pt-ocdi' ); ?></p>

		<ul>
			<li><?php esc_html_e( 'No existing posts, pages, categories, images, custom post types or any other data will be deleted or modified.', 'pt-ocdi' ); ?></li>
			<li><?php esc_html_e( 'Posts, pages, images, widgets, menus and other theme settings will get imported.', 'pt-ocdi' ); ?></li>
			<li><?php esc_html_e( 'Please click on the Import button only once and wait, it can take a couple of minutes.', 'pt-ocdi' ); ?></li>
		</ul>

		<hr>
	</div>

	<?php
	$plugin_intro_text = ob_get_clean();

	// Display the plugin intro text (can be replaced with custom text through the filter below).
	echo wp_kses_post( apply_filters( 'pt-ocdi/plugin_intro_text', $plugin_intro_text ) );
	?>

	<?php if ( empty( $this->import_files ) ) : ?>
		<div class="notice  notice-info  is-dismissible">
			<p><?php esc_html_e( 'There are no predefined import files available in this theme. Please upload the import files manually!', 'pt-ocdi' ); ?></p>
		</div>
	<?php endif; ?>

	<?php if ( empty( $predefined_themes ) ) : ?>

		<div class="ocdi__file-upload-container">
			<h2><?php esc_html_e( 'Manual demo files upload', 'pt-ocdi' ); ?></h2>

			<div class="ocdi__file-upload">
				<h3><label for="content-file-upload"><?php esc_html_e( 'Choose a XML file for content import:', 'pt-ocdi' ); ?></label></h3>
				<input id="ocdi__content-file-upload" type="file" name="content-file-upload">
			</div>

			<div class="ocdi__file-upload">
				<h3><label for="widget-file-upload"><?php esc_html_e( 'Choose a WIE or JSON file for widget import:', 'pt-ocdi' ); ?></label></h3>
				<input id="ocdi__widget-file-upload" type="file" name="widget-file-upload">
			</div>

			<div class="ocdi__file-upload">
				<h3><label for="customizer-file-upload"><?php esc_html_e( 'Choose a DAT file for customizer import:', 'pt-ocdi' ); ?></label></h3>
				<input id="ocdi__customizer-file-upload" type="file" name="customizer-file-upload">
			</div>

			<?php if ( class_exists( 'ReduxFramework' ) ) : ?>
			<div class="ocdi__file-upload">
				<h3><label for="redux-file-upload"><?php esc_html_e( 'Choose a JSON file for Redux import:', 'pt-ocdi' ); ?></label></h3>
				<input id="ocdi__redux-file-upload" type="file" name="redux-file-upload">
				<div>
					<label for="redux-option-name" class="ocdi__redux-option-name-label"><?php esc_html_e( 'Enter the Redux option name:', 'pt-ocdi' ); ?></label>
					<input id="ocdi__redux-option-name" type="text" name="redux-option-name">
				</div>
			</div>
			<?php endif; ?>
		</div>

		<p class="ocdi__button-container">
			<button class="ocdi__button  button  button-hero  button-primary  js-ocdi-import-data"><?php esc_html_e( 'Import Demo Data', 'pt-ocdi' ); ?></button>
		</p>

	<?php elseif ( 1 === count( $predefined_themes ) ) : ?>

		<div class="ocdi__demo-import-notice  js-ocdi-demo-import-notice"><?php
			if ( is_array( $predefined_themes ) && ! empty( $predefined_themes[0]['import_notice'] ) ) {
				echo wp_kses_post( $predefined_themes[0]['import_notice'] );
			}
		?></div>

		<p class="ocdi__button-container">
			<button class="ocdi__button  button  button-hero  button-primary  js-ocdi-import-data"><?php esc_html_e( 'Import Demo Data', 'pt-ocdi' ); ?></button>
		</p>

	<?php else : ?>

		<!-- OCDI grid layout -->
		<div class="ocdi__gl  js-ocdi-gl">
		<?php
			// Prepare navigation data.
			$categories = Helpers::get_all_demo_import_categories( $predefined_themes );
		?>
			<?php if ( ! empty( $categories ) ) : ?>
				<div class="ocdi__gl-header  js-ocdi-gl-header">
					<nav class="ocdi__gl-navigation">
						<ul>
							<li class="active"><a href="#all" class="ocdi__gl-navigation-link  js-ocdi-nav-link"><?php esc_html_e( 'All', 'pt-ocdi' ); ?></a></li>
							<?php foreach ( $categories as $key => $name ) : ?>
								<li><a href="#<?php echo esc_attr( $key ); ?>" class="ocdi__gl-navigation-link  js-ocdi-nav-link"><?php echo esc_html( $name ); ?></a></li>
							<?php endforeach; ?>
						</ul>
					</nav>
					<div clas="ocdi__gl-search">
						<input type="search" class="ocdi__gl-search-input  js-ocdi-gl-search" name="ocdi-gl-search" value="" placeholder="<?php esc_html_e( 'Search demos...', 'pt-ocdi' ); ?>">
					</div>
				</div>
			<?php endif; ?>

			<div class="ocdi__gl-item-container  wp-clearfix  js-ocdi-gl-item-container items--demo">
				<?php foreach ( $predefined_themes as $index => $import_file ) : ?>
					<?php if (empty($import_file['type'])) : ?>
						<?php
							echo omnis_export_item_output($index, $import_file);
						?>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>

			<?php if (array_search('template', array_column($predefined_themes, 'type')) !== false) : ?>
			<div class="ocdi__gl-type-title"><?php esc_html_e('Home Pages', 'pt-ocdi'); ?></div>
			<?php endif; ?>
			<div class="ocdi__gl-item-container  wp-clearfix  js-ocdi-gl-item-container items--home">
				<?php foreach ( $predefined_themes as $index => $import_file ) : ?>
					<?php if (!empty($import_file['type']) && $import_file['type'] == 'home') : ?>
						<?php
							echo omnis_export_item_output($index, $import_file);
						?>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		
			<?php if (array_search('template', array_column($predefined_themes, 'type')) !== false) : ?>
			<div class="ocdi__gl-type-title"><?php esc_html_e('Pages', 'pt-ocdi'); ?></div>
			<?php endif; ?>
			<div class="ocdi__gl-item-container  wp-clearfix  js-ocdi-gl-item-container items--page">
				<?php foreach ( $predefined_themes as $index => $import_file ) : ?>
					<?php if (!empty($import_file['type']) && $import_file['type'] == 'page') : ?>
						<?php
							echo omnis_export_item_output($index, $import_file);
						?>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		
			<?php if (array_search('template', array_column($predefined_themes, 'type')) !== false) : ?>
			<div class="ocdi__gl-type-title"><?php esc_html_e('Templates', 'pt-ocdi'); ?></div>
			<?php endif; ?>
			<div class="ocdi__gl-item-container  wp-clearfix  js-ocdi-gl-item-container items--template">
				<?php foreach ( $predefined_themes as $index => $import_file ) : ?>
					<?php if (!empty($import_file['type']) && $import_file['type'] == 'template') : ?>
						<?php
							echo omnis_export_item_output($index, $import_file);
						?>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>

			<?php if (array_search('template', array_column($predefined_themes, 'type')) !== false) : ?>
			<div class="ocdi__gl-type-title"><?php esc_html_e('Dummy Data', 'pt-ocdi'); ?></div>
			<?php endif; ?>
			<div class="ocdi__gl-item-container  wp-clearfix  js-ocdi-gl-item-container items--dummy-data">
				<?php foreach ( $predefined_themes as $index => $import_file ) : ?>
					<?php if (!empty($import_file['type']) && $import_file['type'] == 'dummy-data') : ?>
						<?php
							echo omnis_export_item_output($index, $import_file);
						?>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>

		</div>

		<div id="js-ocdi-modal-content"></div>

	<?php endif; ?>
</div>

<?php
function omnis_export_item_output($index, $import_file) {

	$OCDI = OneClickDemoImport::get_instance();

	// Prepare import item display data.
	$img_src = isset( $import_file['import_preview_image_url'] ) ? $import_file['import_preview_image_url'] : '';
	// Default to the theme screenshot, if a custom preview image is not defined.
	if ( empty( $img_src ) ) {
		$theme = wp_get_theme();
		$img_src = $theme->get_screenshot();
	}

	$_attached_elements = (!empty($import_file['attached_elements_settings'])) ? $import_file['attached_elements_settings'] : false;

	$output = '';
	$output .= '<div class="ocdi__gl-item js-ocdi-gl-item" data-categories="'.esc_attr( Helpers::get_demo_import_item_categories( $import_file ) ).'" data-name="'.esc_attr( strtolower( $import_file['import_file_name'] ) ).'">';
	$output .= '<div class="ocdi__gl-item-image-container">';
	if ( ! empty( $img_src ) ) {
		$output .= '<img class="ocdi__gl-item-image" src="'. esc_url( $img_src ) .'">';
	} else {
		$output .= '<div class="ocdi__gl-item-image  ocdi__gl-item-image--no-image">'. esc_html__( 'No preview image.', 'pt-ocdi' ) .'</div>';
	}
	$output .= '</div>';
	if ($_attached_elements) {
		$output .= '<div class="ocdi__attached-elements">';
		$output .= '<h6 class="ocdi__attached-title">Attached Items:</h6>';
		foreach ($_attached_elements as $key => $_attached_element) {
			$output .= '<div class="ocdi__attached-element">'. $_attached_element .'</div>';
		}
		$output .= '<small class="ocdi__attached-info">'. esc_html__('Make sure these attachements are properly set.', 'pt-ocdi') .'</small>';
		$output .= '</div>';
	}
	$output .= '<div class="ocdi__gl-item-footer'. (! empty( $import_file['preview_url'] ) ? '  ocdi__gl-item-footer--with-preview' : '') .'" title="'. esc_html( $import_file['import_file_name'] ) .'">';
	$output .= '<h4 class="ocdi__gl-item-title" title="'. esc_attr( $import_file['import_file_name'] ) .'">'. esc_html( $import_file['import_file_name'] ) .'</h4>';
	$output .= '<span class="ocdi__gl-item-buttons">';
	 if ( ! empty( $import_file['preview_url'] ) )  {
		$output .= '<a class="ocdi__gl-item-button  button" href="'. esc_url( $import_file['preview_url'] ) .'" target="_blank">'. esc_html__( 'Preview Demo', 'one-click-demo-import' ). '</a>';
	 }
	$output .= '<a class="ocdi__gl-item-button  button  button-primary" href="'. $OCDI->get_plugin_settings_url( [ 'step' => 'import', 'import' => esc_attr( $index ) ] ) .'">'. esc_html__( 'Import Demo', 'one-click-demo-import' ) .'</a>';

	$output .= '</span>';
	$output .= ' </div>';
	$output .= '</div>';

	

	return $output;
}

?>

<?php
/**
 * Hook for adding the custom admin page footer
 */
do_action( 'pt-ocdi/plugin_page_footer' );
