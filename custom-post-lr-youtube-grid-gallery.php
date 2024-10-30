<?php
add_action('init', 'lryg_type_post_video');
	function lryg_type_post_video() { 
		$labels = array(
			'name' => __('Videos', 'lr-youtube-grid-gallery'),
			'singular_name' => __('Videos', 'lr-youtube-grid-gallery'),
			'add_new' => __('Add New', 'lr-youtube-grid-gallery'),
			'add_new_item' => __('Add New Videos', 'lr-youtube-grid-gallery'),
			'edit_item' => __('Editar Item', 'lr-youtube-grid-gallery'),
			'new_item' => __('New Videos', 'lr-youtube-grid-gallery'),
			'view_item' => __('View Videos', 'lr-youtube-grid-gallery'),
			'search_items' => __('Search Videos', 'lr-youtube-grid-gallery'),
			'not_found' =>  __('No registro Found', 'lr-youtube-grid-gallery'),
			'not_found_in_trash' => __('No Video in the trash', 'lr-youtube-grid-gallery'),
			'parent_item_colon' => '',
			'menu_name' => __('Videos', 'lr-youtube-grid-gallery')
		);
		$args = array(
			'labels' => $labels,
			'public' => true,
			'public_queryable' => true,
			'show_ui' => true,          
			'query_var' => true,
			'rewrite' => true,
			'capability_type' => 'post',
			'menu_icon' => '',
			'has_archive' => true,
			'hierarchical' => false,
			'menu_position' => 5,
			'register_meta_box_cb' => 'lryg_video_meta_box',      
			'supports' => array('title')
		);
	register_post_type( 'lr-youtube-gallery' , $args );
	}
	
	add_action( 'admin_head', 'lryg_chr_icon_UtubeGallery' );
	function lryg_chr_icon_UtubeGallery() {
	echo'
	    <style type="text/css" media="screen">
	        #icon-edit.icon32-posts-youtube-gallery {background: url("'.LRYG_PLUGIN_URL.'/images/icon-youtube-32.png") no-repeat;}
	    </style>';
	}
	function lryg_video_meta_box(){        
		add_meta_box('meta_box_video', __('Details of Video', 'lr-youtube-grid-gallery'), 'lryg_meta_box_meta_video', 'lr-youtube-gallery', 'normal', 'high');
	}

	function lryg_meta_box_meta_video(){
		global $post;
		// Values Saved
		$metaBoxUrl = get_post_meta($post->ID, 'video_url', true); 
		$metaBoxDesc = get_post_meta($post->ID, 'video_desc', true);
		$meta_element_quality = get_post_meta($post->ID, 'custom_element_grid_quality_meta_box', true);
		$meta_element_similar = get_post_meta($post->ID, 'radio_similiar', true);
		$meta_element_controles = get_post_meta($post->ID, 'radio_controles', true);
		$meta_element_title = get_post_meta($post->ID, 'radio_title', true);
		$metaIdVideo = lryg_youtubeEmbedFromUrl($metaBoxUrl);
		
		// Verication Radio Button Nulled
		$nulled_vefication = "";
		if(	$meta_element_similar == null || $meta_element_controles == null || $meta_element_title == null ){
			$nulled_vefication = 'checked="checked"';
		};
	?>
		<h4 class="title-ysg"><?php _e('Details of Video', 'lr-youtube-grid-gallery');?></h4>
		<ul>
			<li>
				<h4><label for="inputValorUrl" style="width:100%; display:block; font-weight: bold;"><?php _e('URL do Video:', 'lr-youtube-grid-gallery');?></label></h4>
				<input style="width:100%; display:block;" type="text" name="video_url" id="inputValorUrl" value="<?php echo $metaBoxUrl;?>" />
			</li>
			<li>
				<em style="padding: 5px 0; display: block; color: #666;">
					<b><?php _e('Examples of possible models:', 'lr-youtube-grid-gallery');?></b>
					<ul>
						<li>&bull; http://www.youtube.com/watch?v=UzifCbU_gJU</li>
						<li>&bull; http://www.youtube.com/watch?v=UzifCbU_gJU&feature=related</li>
						<li>&bull; http://youtu.be/UzifCbU_gJU</li>
					</ul>
				</em>
			</li>
			<?php if($metaIdVideo != null){ ?>
			<li>
				<h4><?php _e('Original Video Image', 'lr-youtube-grid-gallery') ;?>:</h4>
				<?php echo '<img title="'. get_the_title().'" alt="'. get_the_title().'" src="http://img.youtube.com/vi/' . $metaIdVideo .'/mqdefault.jpg" />';	?>				
				<br />
				<em style="padding: 5px 0; display: block; color: #666;"><?php echo __('Caution: When you have a highlighted image, it will be changed by it.', 'lr-youtube-grid-gallery') ;?></em>
			</li>
			<?php }; ?>
			<li>
				<h4><?php _e('Video Quality:', 'lr-youtube-grid-gallery') ;?>:</h4>
				<div class="lryg-select-style">
					<select name="custom_element_grid_quality" id="custom_element_grid_quality">
						<option value="default" <?php selected( $meta_element_quality, 'default' ); ?>><?php _e('Default', 'lr-youtube-grid-gallery');?></option>
						<option value="small" <?php selected( $meta_element_quality, 'small' ); ?>><?php _e('Small', 'lr-youtube-grid-gallery');?></option>
						<option value="medium" <?php selected( $meta_element_quality, 'medium' ); ?>><?php _e('Medium', 'lr-youtube-grid-gallery');?></option>
						<option value="large" <?php selected( $meta_element_quality, 'large' ); ?>><?php _e('Large', 'lr-youtube-grid-gallery');?></option>
						<option value="hd720" <?php selected( $meta_element_quality, 'hd720' ); ?>><?php _e('HD 720', 'lr-youtube-grid-gallery');?></option>
						<option value="hd1080" <?php selected( $meta_element_quality, 'hd1080' ); ?>><?php _e('HD 1080', 'lr-youtube-grid-gallery');?></option>
						<option value="highres" <?php selected( $meta_element_quality, 'highres' ); ?>><?php _e('High resolution', 'lr-youtube-grid-gallery');?></option>
					</select>
				</div>
				<br />
			</li>
			<li>
				<h4><?php _e('Suggested Videos When Video Ends', 'lr-youtube-grid-gallery') ;?>:</h4>
				<ul>
					<li><input class="lryg-radio-button" type="radio" name="radio_similiar" id="show_similar" value="1" <?php echo $nulled_vefication . ($meta_element_similar == '1')? 'checked="checked"':''; ?>><label for="show_similar"><?php _e('Yes','lr-youtube-grid-gallery');?></label></li>
					<li><input class="lryg-radio-button" type="radio" name="radio_similiar" id="hide_similar" value="0" <?php echo ($meta_element_similar == '0')? 'checked="checked"':''; ?>><label for="hide_similar"><?php _e('No','lr-youtube-grid-gallery');?></label></li>
				</ul>
			</li>
			<li>
				<h4><?php _e('Show Video controls', 'lr-youtube-grid-gallery') ;?>:</h4>
				<ul>
					<li><input class="lryg-radio-button" type="radio" name="radio_controles" id="show_controles" value="1" <?php echo $nulled_vefication . ($meta_element_controles == '1')? 'checked="checked"':''; ?>><label for="show_controles"><?php _e('Yes','lr-youtube-grid-gallery');?></label></li>
					<li><input class="lryg-radio-button" type="radio" name="radio_controles" id="hide_controles" value="0" <?php echo ($meta_element_controles == '0')? 'checked="checked"':''; ?>><label for="hide_controles"><?php _e('No','lr-youtube-grid-gallery');?></label></li>
				</ul>
			</li>
			<li>
				<h4><?php _e('Show Video Title and Video Assignments', 'lr-youtube-grid-gallery') ;?>:</h4>
				<ul>
					<li><input class="lryg-radio-button" type="radio" name="radio_title" id="show_title" value="1" <?php echo $nulled_vefication . ($meta_element_title == '1')? 'checked="checked"':''; ?>><label for="show_title"><?php _e('Yes','lr-youtube-grid-gallery');?></label></li>
					<li><input class="lryg-radio-button" type="radio" name="radio_title" id="hide_title" value="0" <?php echo ($meta_element_title == '0')? 'checked="checked"':''; ?>><label for="hide_title"><?php _e('No','lr-youtube-grid-gallery');?></label></li>
				</ul>
			</li>
			<li>
				<h4><label for="inputValorDesc" style="width:100%; display:block; font-weight: bold;"><?php _e('Description:', 'lr-youtube-grid-gallery');?></label></h4>
				<input style="width:100%; display:block;" type="text" name="video_desc" id="inputValorDesc" value="<?php echo $metaBoxDesc;?>" />
			</li>
			<li>
				<em style="padding: 5px 0; display: block; color: #666;">
					<?php _e('Enter a text if you want:', 'lr-youtube-grid-gallery');?>
				</em>
			</li>
		</ul>
		<?php
	}
	add_action('save_post', 'lryg_save_video_post');

	function lryg_save_video_post(){
	    global $post;        
		if(isset($_POST['video_url'])){
			update_post_meta($post->ID, 'video_url', $_POST['video_url']);
		}
		if(isset($_POST["custom_element_grid_quality"])){

			$meta_element_quality = $_POST['custom_element_grid_quality'];
			update_post_meta($post->ID, 'custom_element_grid_quality_meta_box', $meta_element_quality);

		}
		if(isset($_POST['radio_similiar'])){
			update_post_meta($post->ID, 'radio_similiar', $_POST['radio_similiar']);
		}if(isset($_POST['radio_controles'])){
			update_post_meta($post->ID, 'radio_controles', $_POST['radio_controles']);
		}if(isset($_POST['radio_title'])){
			update_post_meta($post->ID, 'radio_title', $_POST['radio_title']);
		}if(isset($_POST['video_desc'])){
			update_post_meta($post->ID, 'video_desc', $_POST['video_desc']);
		}
	}