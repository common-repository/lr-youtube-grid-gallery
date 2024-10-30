<?php
/**
 * Plugin Name: LR YouTube Grid Gallery
 * Version: 1.0
 * Description: LR YouTube Grid Gallery is a plugin you can create an area for YouTube videos quickly with management by shortcode.
 * Author: Logicrays
 */
 
define("lr-youtube-grid-gallery","lr_youtube_grid_gallery" );
define('LRYG_PLUGIN_URL', plugins_url('', __FILE__));
ini_set('allow_url_fopen',1);

add_image_size( 'lryg-thumb-youtube', 320, 180, true  );

include_once('custom-post-lr-youtube-grid-gallery.php');
include_once('custom-taxonomy-lr-youtube-grid-gallery.php');
include_once('lr-generation-codes.php');
include_once('content-list-lr-youtube-grid-gallery.php');

function lryg_admin_style() {
	wp_enqueue_style( 'font-awesome-min', LRYG_PLUGIN_URL.'/admin/css/font-awesome.min.css', false );
    wp_enqueue_style( 'style.lryg.admin', LRYG_PLUGIN_URL.'/admin/css/style.lryg.admin.min.css', false );    
}
add_action( 'admin_enqueue_scripts', 'lryg_admin_style' );

function lryg_script_gallery() {
	wp_enqueue_script(array('jquery', 'thickbox'));
	wp_enqueue_style( 'style-lrygallery', LRYG_PLUGIN_URL.'/css/style-lrygallery-min.css' );
	wp_enqueue_style( 'bootstrap', LRYG_PLUGIN_URL.'/css/bootstrap.css' );
}  
add_action('wp_print_scripts', 'lryg_script_gallery');

$lryg_options = array(
	'lryg_size_wight' => '640',
	'lryg_size_height' => '390',
	'lryg_thumb_wight' => '320',
	'lryg_thumb_height' => '180',
	'lryg_thumb_s_wight' => '160',
	'lryg_thumb_s_height' => '90',
	'lryg_autoplay' => '0'
);

if ( is_admin() ) :

function lryg_register_settings() {
	register_setting( 'lryg_plugin_options', 'lryg_options', 'lryg_validate_options' );
}
add_action( 'admin_init', 'lryg_register_settings' );

$lryg_btn_autoplay = array(
	'1' => array(
		'value' => '1',
		'label' => 'True'
	),
	'0' => array(
		'value' => '0',
		'label' => 'False'
	),
);

function lryg_plugin_options() {
	//add_theme_page( 'LR YouTube Grid Gallery', __('LRYG settings', 'lr-youtube-grid-gallery'), 'manage_options', 'lryg_settings', 'lryg_plugin_options_page' );
	add_submenu_page(
        'edit.php?post_type=lr-youtube-gallery',
        __('LR YouTube Grid Gallery', 'lr-youtube-grid-gallery'),
        __('LRYG Settings', 'lr-youtube-grid-gallery'),
        'manage_options',
        'lryg_settings',
        'lryg_plugin_options_page');
}
add_action( 'admin_menu', 'lryg_plugin_options' );

function lryg_plugin_options_page() {
	global $lryg_options, $lryg_btn_autoplay;
	if ( ! isset( $_REQUEST['settings-updated'] ) ) $_REQUEST['settings-updated'] = false; ?>
	<div class="wrap">
		<?php echo "<h2 class='title-lryg'>" . __( ' LR YouTube Grid Gallery - Settings','lr-youtube-grid-gallery' ) . "</h2>"; ?>
		<p>Short code: [lryg-youtube-grid-gallery order="DESC" orderby="date" posts="6" category="all"]</p>
		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		<div class="updated fade"><p><strong><?php echo __('Saved Options','lr-youtube-grid-gallery' );?></strong></p></div>
		<?php endif; ?>	
		<form method="post" action="options.php">
			<?php $settings = get_option( 'lryg_options', $lryg_options ); settings_fields( 'lryg_plugin_options' ); ?>
			<h3 class="title-lryg-red"><?php echo __('Default settings','lr-youtube-grid-gallery' );?></h3>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="lryg_size_wight"><?php echo __('Video Length','lr-youtube-grid-gallery' );?></label></th>
					<td>
						<input id="lryg_size_wight" name="lryg_options[lryg_size_wight]" type="text" value="<?php esc_attr_e($settings['lryg_size_wight']); ?>" style="width: 40px;" />x<input id="lryg_size_height" name="lryg_options[lryg_size_height]" type="text" value="<?php esc_attr_e($settings['lryg_size_height']); ?>" style="width: 40px;" />
					</td>
				</tr>
				<tr valign="top">
					<td colspan="2" class="figure-lryg">
						<figure>
							<img src="http://dummyimage.com/<?php esc_attr_e($settings['lryg_size_wight']); ?>x<?php esc_attr_e($settings['lryg_size_height']); ?>/b0b0b0/fff.png" alt="" title="" >
						</figure>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="lryg_thumb_wight"><?php echo __('Thumbnail Size Larger','lr-youtube-grid-gallery' );?></label></th>
					<td>
						<input id="lryg_thumb_wight" name="lryg_options[lryg_thumb_wight]" type="text" value="<?php esc_attr_e($settings['lryg_thumb_wight']); ?>" style="width: 40px;" />x<input id="lryg_thumb_height" name="lryg_options[lryg_thumb_height]" type="text" value="<?php esc_attr_e($settings['lryg_thumb_height']); ?>" style="width: 40px;" />
					</td>
				</tr>
				<tr valign="top">
					<td colspan="2" class="figure-lryg">
						<figure>
							<img src="http://dummyimage.com/<?php esc_attr_e($settings['lryg_thumb_wight']); ?>x<?php esc_attr_e($settings['lryg_thumb_height']); ?>/b0b0b0/fff.png" alt="" title="" >
						</figure>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="lryg_thumb_s_wight"><?php echo __('Thumbnail Size Smaller','lr-youtube-grid-gallery' );?></label></th>
					<td>
						<input id="lryg_thumb_s_wight" name="lryg_options[lryg_thumb_s_wight]" type="text" value="<?php esc_attr_e($settings['lryg_thumb_s_wight']); ?>" style="width: 40px;" />x<input id="lryg_thumb_s_height" name="lryg_options[lryg_thumb_s_height]" type="text" value="<?php esc_attr_e($settings['lryg_thumb_s_height']); ?>" style="width: 40px;" />
					</td>
				</tr>
				<tr valign="top">
					<td colspan="2" class="figure-lryg">
						<figure>
							<img src="http://dummyimage.com/<?php esc_attr_e($settings['lryg_thumb_s_wight']); ?>x<?php esc_attr_e($settings['lryg_thumb_s_height']); ?>/b0b0b0/fff.png" alt="" title="" >
						</figure>
					</td>
				</tr>
				<tr valign="top"><th scope="row"><?php echo __('AutoPlay','lr-youtube-grid-gallery' );?></th>
					<td>
					<?php foreach( $lryg_btn_autoplay as $autoplay ) : ?>
						<input type="radio" id="<?php echo 'autoplay-' . $autoplay['value']; ?>" name="lryg_options[lryg_autoplay]" value="<?php esc_attr_e( $autoplay['value'] ); ?>" <?php checked( $settings['lryg_autoplay'], $autoplay['value'] ); ?> />
						<label for="<?php echo 'autoplay-' . $autoplay['value']; ?>"><?php echo $autoplay['label']; ?></label><br />
					<?php endforeach; ?>
					</td>
				</tr>
			</table>
			<p class="submit"><input type="submit" class="button-primary" value="<?php echo __('Save Option','lr-youtube-grid-gallery' );?>" /></p>			
		</form>
	</div>
	<?php
}
function lryg_validate_options( $input ) {
	global $lryg_options, $lryg_btn_autoplay;
	$settings = get_option( 'lryg_options', $lryg_options );
	$input['lryg_size_wight'] = wp_filter_nohtml_kses( $input['lryg_size_wight'] );
	$input['lryg_size_height'] = wp_filter_nohtml_kses( $input['lryg_size_height'] );
	$input['lryg_thumb_wight'] = wp_filter_nohtml_kses( $input['lryg_thumb_wight'] );
	$input['lryg_thumb_height'] = wp_filter_nohtml_kses( $input['lryg_thumb_height'] );
	$input['lryg_thumb_s_wight'] = wp_filter_nohtml_kses( $input['lryg_thumb_s_wight'] );
	$input['lryg_thumb_s_height'] = wp_filter_nohtml_kses( $input['lryg_thumb_s_height'] );
	$prev = $settings['lryg_autoplay'];
	if ( !array_key_exists( $input['lryg_autoplay'], $lryg_btn_autoplay ) )
		$input['lryg_autoplay'] = $prev;
	return $input;
}

function lryg_edit_columns( $columns ) {
    $columns = array(
        'cb' => '<input type="checkbox" />',
        'lryg_image' => __( 'Video Image', 'lr-youtube-grid-gallery' ),
        'lryg_title' => __( 'Title', 'lr-youtube-grid-gallery' ),
        'lryg_categories' => __("Category", 'lr-youtube-grid-gallery' ),
        'lryg_url' => __( 'Video Link', 'lr-youtube-grid-gallery' )
    );

    return $columns;
}
add_filter( 'manage_edit-lr-youtube-gallery_columns', 'lryg_edit_columns' );

add_action( 'init', 'lryg_chrUtube_buttons' );

function lryg_chrUtube_buttons() {
	add_filter("mce_external_plugins", "lryg_chrUtube_add_buttons");
    add_filter('mce_buttons', 'lryg_chrUtube_register_buttons');
}	
function lryg_chrUtube_add_buttons($plugin_array) {
	$plugin_array['chrUtube'] = plugins_url( '/admin/tinymce/lryg-tinymce.js' , __FILE__ );
	return $plugin_array;
}
function lryg_chrUtube_register_buttons($buttons) {
	array_push( $buttons, 'showUtube' );
	return $buttons;
}

function lryg_posts_columns( $column, $post_id ) {
    switch ( $column ) {
    	case 'lryg_image':
			$lrygGetId = get_post_meta($post_id, 'video_url', true );
			$lrygPrintId = lryg_youtubeEmbedFromUrl($lrygGetId);
			echo sprintf( '<a href="%1$s" title="%2$s">', admin_url( 'post.php?post=' . $post_id . '&action=edit' ), get_the_title() );
			if ( has_post_thumbnail()) { 
				the_post_thumbnail(array(150,90)); 
			}else{
				echo '<img title="'. get_the_title().'" alt="'. get_the_title().'" src="http://img.youtube.com/vi/' . $lrygPrintId .'/mqdefault.jpg" width="150" height="90" />';	
			}
			echo '</a>';
            break;
        case 'lryg_title':
            echo sprintf( '<a href="%1$s" title="%2$s">%2$s</a>', admin_url( 'post.php?post=' . $post_id . '&action=edit' ), get_the_title() );
            break;        
        case "lryg_categories":
		$lrygTerms = get_the_terms($post_id, 'youtube-category');
		if ( !empty( $lrygTerms ) )
		{
			$lrygOut = array();
			foreach ( $lrygTerms as $lrygTerm )
				$lrygOut[] = '<a href="edit.php?post_type=youtube-gallery&youtube-videos=' . $lrygTerm->slug . '">' . esc_html(sanitize_term_field('name', $lrygTerm->name, $lrygTerm->term_id, 'youtube-category', 'display')) . '</a>';
			echo join( ', ', $lrygOut );
		}
		else
		{
			echo __( 'Without category', 'lr-youtube-grid-gallery' );
		}
		break;			
        case 'lryg_url':
            $idvideo = get_post_meta($post_id, 'video_url', true );            
            echo ! empty( $idvideo ) ? sprintf( '<a href="%1$s" target="_blank">%1$s</a>', esc_url( $idvideo ) ) : '';
            break;
    	}
}
add_action( 'manage_posts_custom_column', 'lryg_posts_columns', 1, 2 );
endif;