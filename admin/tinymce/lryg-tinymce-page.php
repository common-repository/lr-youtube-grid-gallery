<?php
	$absolute_path = __FILE__;
	$path_to_file = explode( 'wp-content', $absolute_path );
	$path_to_wp = $path_to_file[0];
	require_once( $path_to_wp . '/wp-load.php' );
	header('HTTP/1.1 200 OK');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<link href="<?php echo plugins_url( '/css/lryg-tinymce.css' , __FILE__ );?>" type="text/css" rel="stylesheet">
	<script>
		$=jQuery.noConflict();
		$(document).ready(function() {
			$(".insert_information").click (function () {
				var order = $('select.order option:selected').val();
				var orderby = $('select.orderby option:selected').val();
				var page = $('select.page option:selected').val();
				var category = $('select.category option:selected').val();
				tinymce.execCommand('mceInsertContent', false, '[lryg-youtube-grid-gallery order="'+order+'" orderby="'+orderby+'" posts="'+page+'" category="'+category+'"]');
				$("#TB_overlay, #TB_window").remove();
				return false;
			});
			var	ajaxCont = $('#TB_ajaxContent'),
			tbWindow = $('#TB_window');
			ajaxCont.css({
				padding: 0,
				width: 630,
				overflowY: 'scroll',
				height: 230,
				padding: 20
			});
			tbWindow.css({
				width: ajaxCont.outerWidth(),
				marginLeft: -(ajaxCont.outerWidth()/2),
				height: 600
			});
		})		
	</script>
	</head>
	<body>
    <fieldset>
      <legend> 
      <img src="<?php echo plugins_url( '../../images/icon-youtube.png' , __FILE__ );?>" alt="LR YouTube Grid Gallery" title="LR YouTube Grid Gallery" /> LR YouTube Grid Gallery</legend>
      <ul class="ul-list-order">
        <li>
          <label style="width: 30%; display: inline-block;"><?php echo __('Select the order:','lr-youtube-grid-gallery' );?></label>
          <select class="order" style="width: 30%; display: inline-block;">
            <option value="DESC" selected><?php echo __('DESC','lr-youtube-grid-gallery' );?></option>
            <option value="ASC"><?php echo __('ASC','lr-youtube-grid-gallery' );?></option>
          </select>
        </li>
        <li>
          <label style="width: 30%; display: inline-block;"> <?php echo __('Select sort by:','lr-youtube-grid-gallery' );?> </label>
          <select class="orderby" style="width: 30%; display: inline-block;">
            <option value="date" selected><?php echo __('Data','lr-youtube-grid-gallery' );?></option>
            <option value="name"><?php echo __('Name','lr-youtube-grid-gallery' );?></option>
            <option value="rand"><?php echo __('RANDOM','lr-youtube-grid-gallery' );?></option>
          </select>
        </li>
        <li>
          <label style="width: 30%; display: inline-block;"> <?php echo __('Listing of Views per page:','lr-youtube-grid-gallery' );?> </label>
          <select class="page" style="width: 30%; display: inline-block;">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6" selected>6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="-1"><?php echo __('All','lr-youtube-grid-gallery' );?></option>
          </select>
        </li>
        <li>
          <label style="width: 30%; display: inline-block;"> <?php echo __('Listing of Views by Category:','lr-youtube-grid-gallery' );?> </label>
          <?php $taxonomyName = "youtube-category";   
			$parent_terms = get_terms($taxonomyName, array('orderby' => 'slug', 'hide_empty' => false));   
			echo '<select class="category" style="width: 30%; display: inline-block;">';
					echo '<option value="all" selected>'.__('All','lr-youtube-grid-gallery' ) .'</option>';
		        foreach ($parent_terms as $pterm) {
		        	echo '<option value="'.$pterm->slug.'">'.$pterm->name.'</option>';
		        }
		    echo '</select>';?>
        </li>
      </ul>
      <button class="insert_information" id="btn-send"><?php echo __('Submit','lr-youtube-grid-gallery' );?></button>
    </fieldset>
</body>
</html>