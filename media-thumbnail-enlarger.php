<?php
/*
Plugin Name: Media Library Thumbnail Enhancer
Plugin URI: http://ThoughtRefinery.com/
Description: Enhances media library thumbnails by making them larger and replacing the bundled icons with scalable SVG versions
Author: Nick Ciske (ThoughtRefinery)
Version: 1.3
Author URI: http://thoughtrefinery.com/
*/

// Customize media list table
add_action( 'admin_init', 'mte_media_columns' );

function mte_media_columns() {

    add_action('manage_media_custom_column', 'mte_custom_media_column_content',10,2);
    add_filter('manage_media_columns', 'mte_custom_media_column_headings');

}

add_action( 'admin_head','mte_admin_css' );

// Remove default column and replace it with ours
function mte_custom_media_column_headings( $columns ) {

	$offset = 2;
	$new_columns = array_slice($columns, 0, $offset, true) + array('mte_thumbnail' => '') + array_slice($columns, $offset, NULL, true);
	unset( $new_columns['icon'] );

	return $new_columns;
	
}

// Output our custom thumbnail
function mte_custom_media_column_content( $column_name, $id ) {
	
	echo '<a href="'.get_edit_post_link( $id ).'">';
	
		if( wp_attachment_is_image( $id ) ){
			// Custom image
			echo wp_get_attachment_image( $id, mte_get_image_size(), false );
		}else{
			// Not an image, use the icon
			echo '<img src="'.wp_mime_type_icon( $id ).'">';
		}	
	
	echo '</a>';
	
}

// Fancy new icons
function mte_change_mime_icon($icon, $mime = null, $post_id = null){
    $icon = str_replace( home_url().'/wp-includes/images/crystal/',  plugins_url('/icons/default/', __FILE__), $icon);
    $icon = str_replace( '.png',  '.svg', $icon);

    return $icon;
}
add_filter('wp_mime_type_icon', 'mte_change_mime_icon');

// Which image size are we using?
function mte_get_image_size(){

	if( in_array( 'mte_thumbnail', get_intermediate_image_sizes() ) )
		return 'mte_thumbnail';  // size is hard coded

	if( in_array( 'mte_thumbnail_ud', get_intermediate_image_sizes() ) )
		return 'mte_thumbnail_ud'; // size is set in settings: media

	return 'thumbnail'; // use WordPress default size

}

// Size column to image
function mte_admin_css(){
	
	echo '<style>';
	echo '.attachment-preview.type-application img, .attachment-preview.type-audio img, .attachment-preview.type-video img, .attachment-preview.type-text img { width: auto; max-height: 105px; padding-top: 0; }';
	echo '</style>';

	// enqueue modal styles if option is set
	if( get_option( 'mte_enlarge_modal_thumbs' ) ){
		wp_enqueue_style('mte_enlarge_modal_thumbs', plugins_url('css/enlarge-modal-thumbs.css', __FILE__ ));
	
		$w = get_option( mte_get_image_size() . '_size_w' );

		echo '<style>';
		echo '.media-frame-content .attachment-preview { width: '.($w-1).'px  !important; height: '.($w-1).'px !important; }';
		echo '</style>';
	}

	$screen = get_current_screen();

	if( $screen->base != 'upload' )
		return;

	$w = get_option( mte_get_image_size() . '_size_w' );
	$h = get_option( mte_get_image_size() . '_size_h' );

	echo '<style>';
	echo '.fixed .column-mte_thumbnail{ width: '.$w.'px; text-align: center; }';
	echo '.column-mte_thumbnail img{ width: auto; max-height: '.$h.'px; }';
	echo '</style>';


}

// Add settings
function mte_register_setting() {
	
	if( in_array( 'mte_thumbnail', get_intermediate_image_sizes() ) )
		return; // size is hard coded
	
	register_setting( 'media', 'mte_thumbnail_ud_size_w', 'absint' ); 
	register_setting( 'media', 'mte_thumbnail_ud_size_h', 'absint' ); 

	register_setting( 'media', 'mte_enlarge_modal_thumbs', 'absint' ); 
	
	add_settings_field( 'mte_thumbnail_size', 'Media Library Thumbnails', 'mte_setting_display', 'media', 'default' );
	
} 
add_action( 'admin_init', 'mte_register_setting' );

function mte_setting_display(){
	?>
	
	<fieldset><legend class="screen-reader-text"><span>Media Library Thumbnails</span></legend>
	<label for="mte_thumbnail_ud_size_w">Max Width</label>
	<input name="mte_thumbnail_ud_size_w" type="number" step="1" min="0" id="mte_thumbnail_ud_size_w" value="<?php echo absint( get_option( 'mte_thumbnail_ud_size_w', 150 ) ); ?>" class="small-text">
	<label for="mte_thumbnail_ud_size_h">Max Height</label>
	<input name="mte_thumbnail_ud_size_h" type="number" step="1" min="0" id="mte_thumbnail_ud_size_h" value="<?php echo absint( get_option( 'mte_thumbnail_ud_size_h', 150 ) ); ?>" class="small-text">
	<br>
	<input name="mte_enlarge_modal_thumbs" type="checkbox" id="mte_enlarge_modal_thumbs" value="1" <?php checked(1, get_option('mte_enlarge_modal_thumbs'))?>>
	<label for="mte_enlarge_modal_thumbs">Enlarge thumbnails in modal (pop-up) media library</label>

	</fieldset>
	
	<?php
}

// Add image size if not set
function mte_maybe_add_image_size(){

	if( in_array( 'mte_thumbnail', get_intermediate_image_sizes() ) )
		return; // size is hard coded

	$w = get_option( 'mte_thumbnail_ud_size_w' );
	$h = get_option( 'mte_thumbnail_ud_size_h' );
	
	if( $w && $h )
		add_image_size( 'mte_thumbnail_ud', $w, $h, true );

}
add_action( 'after_setup_theme', 'mte_maybe_add_image_size' );