<?php
add_shortcode( 'lryg-youtube-grid-gallery', 'lryg_youtube_gallery_shortcode' );
function lryg_youtube_gallery_shortcode( $atts ) {
    ob_start();
    extract( shortcode_atts( array (
        'orderby' => 'date',
        'order' => 'DESC',
        'posts' => 6,
        'category' => 'all',
    ), $atts ) );
    add_thickbox();
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    if($category != 'all'){
	    $options = array(
	        'post_type' => 'lr-youtube-gallery',
	        'order' => $order,
	        'orderby' => $orderby,
	        'posts_per_page' => $posts,
	        'paged' => $paged,
	        'tax_query' => array(
                array(
                    'taxonomy' => 'youtube-category',
                    'field' => 'slug',
                    'terms' => array($category)
                )
            )
	    );
    }else{
    	$options = array(
	        'post_type' => 'lr-youtube-gallery',
	        'order' => $order,
	        'orderby' => $orderby,
	        'posts_per_page' => $posts,
	        'paged' => $paged,
	    );
    };
    global $lryg_options; $lryg_settings = get_option( 'lryg_options', $lryg_options );

    $loop_youtube_gallery = new WP_Query( $options );

    if($loop_youtube_gallery->have_posts()) {
	echo '<div class="ul-lryoutubegallery">';
		while ( $loop_youtube_gallery->have_posts() ) : $loop_youtube_gallery->the_post();

		$desc_value = get_post_meta( get_the_ID(), 'video_desc', true );
		$idvideo = get_post_meta( get_the_ID(), 'video_url', true );
		
		$quality_video = get_post_meta( get_the_ID(), 'custom_element_grid_quality_meta_box', true );
		if ($quality_video == null){
			$quality_video = 'default';
		}else{
			$quality_video = $quality_video;
		}
		
		$similar_video = get_post_meta( get_the_ID(), 'radio_similiar', true );
		if ($similar_video == null){
			$similar_video = '1';
		}else{
			$similar_video = $similar_video;
		}

		$controles_video = get_post_meta( get_the_ID(), 'radio_controles', true );
		if ($controles_video == null){
			$controles_video = '1';
		}else{
			$controles_video = $controles_video;
		}

		$title_video = get_post_meta( get_the_ID(), 'radio_title', true );
		if ($title_video == null){
			$title_video = '1';
		}else{
			$title_video = $title_video;
		}

		$embed_code = lryg_youtubeembedfromUrl($idvideo);
		$size_thumb_w = $lryg_settings['lryg_thumb_wight'];
		$size_thumb_h = $lryg_settings['lryg_thumb_height']; 
	    ?>
		<div class="li-lryoutubegallery col-md-4" id="post-<?php the_ID(); ?>">
			<h3 class="title-lryoutubegallery"><?php the_title();?></h3>
			<div id="video-id-<?php the_ID(); ?>" style="display:none;">
				<iframe width="<?php echo $lryg_settings['lryg_size_wight']; ?>" height="<?php echo $lryg_settings['lryg_size_height']; ?>" src="http://www.youtube.com/embed/<?php echo $embed_code; ?>?rel=<?php echo $similar_video;?>&amp;vq=<?php echo $quality_video;?>&amp;controls=<?php echo $controles_video;?>&amp;showinfo=<?php echo $title_video;?>&amp;autoplay=<?php echo $lryg_settings['lryg_autoplay']; ?>" frameborder="0" allowfullscreen></iframe>
			</div>
			<a href="#TB_inline?width=<?php echo $lryg_settings['lryg_size_wight'] + '15'; ?>&height=<?php echo $lryg_settings['lryg_size_height'] + '20'; ?>&inlineId=video-id-<?php the_ID(); ?>" title="<?php the_title();?>" class="thickbox">
				<?php 
				 if ( has_post_thumbnail()) 
				 { 
				 	the_post_thumbnail('lryg-thumb-youtube', array('class' => 'img-lryoutubegallery lryg-size-thumb')); 
				 }
				 else
				 { 
				 	echo '<img src="http://img.youtube.com/vi/'.$embed_code.'/mqdefault.jpg" class="img-lryoutubegallery lryg-size-thumb" alt="'.get_the_title().'" title="'.get_the_title().'" />'; 
				 } 
				 ?>
			</a>
			<?php 
			if( ! empty( $desc_value ) ) 
			{ 
				echo '<blockquote class="blockquote-lryoutubegallery">' . $desc_value . '</blockquote>'; 
			} 
			?>
		</div>
	<?php endwhile;
	echo '</div>
	<style>
	.lryg-size-thumb{
		width:'.$size_thumb_w.'px!important;
		height:'.$size_thumb_h.'px!important; 
	}
	</style>
	';
		
	if(function_exists('wp_pagenavi')) {
		wp_pagenavi( array( 'query' => $loop_youtube_gallery ));
	} else {
		if($loop_youtube_gallery->max_num_pages>1){
	?>
	<div class="lryg-default-pagination">
	    <?php if ($paged > 1) { ?>
	    	<a href="<?php echo '?paged=' . ($paged -1); //prev link ?>">&laquo;</a>
	    <?php } for($i=1;$i<=$loop_youtube_gallery->max_num_pages;$i++){ ?>
	    	<a href="<?php echo '?paged=' . $i; ?>" <?php echo ($paged==$i)? 'class="selected"':'';?>><?php echo $i;?></a>
	    <?php } if($paged < $loop_youtube_gallery->max_num_pages){ ?>
	    	<a href="<?php echo '?paged=' . ($paged + 1); //next link ?>">&raquo;</a>
	    <?php } ?>
	</div>
	<?php }
	}
        $myvariable = ob_get_clean();
        return $myvariable;
    }else{
	    echo '<h6>' . __( 'There is no registered video ...', 'lr-youtube-grid-gallery' ) . '</h6>';
    }
}