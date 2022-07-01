<?php 
	/**
	* Plugin Main Class
	*/
	class LA_Caption_Hover {
		
		function __construct()  
		{
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_options_page_scripts' ) );
			add_action( "admin_menu", array($this,'caption_hover_admin_options'));
			add_action('wp_ajax_la_save_caption_options', array($this, 'save_caption_options'));
			add_shortcode( 'image-caption-hover', array($this,'render_caption_hovers') );
			add_action( 'admin_init', array($this, 'wdo_process_export_settings') );
			add_action( 'admin_init', array($this, 'wdo_process_import_settings') );
			add_filter( 'widget_text', 'do_shortcode' );
		}

		// Admin Options Page 
		function admin_options_page_scripts($slug){
			if( $slug=='toplevel_page_caption_hover' || $slug=='image-hover-effects_page_caption_hover_pro_settings' ){
				wp_enqueue_media();
				wp_enqueue_style( 'wp-color-picker' );
				wp_enqueue_script( 'wdo-admin-js', plugins_url( 'admin/admin.js', __FILE__ ), array('jquery', 'jquery-ui-accordion','wp-color-picker'));
				wp_enqueue_style( 'wdo-style-css', plugins_url( 'admin/style.css', __FILE__ ));
				wp_enqueue_style( 'wdo-ui-css', plugins_url( 'admin/jquery-ui.min.css', __FILE__ ));
				wp_localize_script( 'wdo-admin-js', 'laAjax', array( 'url' => admin_url( 'admin-ajax.php')));
			}
		}

		function caption_hover_admin_options(){
			add_menu_page( 'Image Hover Effects', 'Image Hover Effects', 'manage_options', 'caption_hover', array($this,'render_menu_page'), 'dashicons-format-image' );
			// add_submenu_page( 'caption_hover', 'Pro Version Settings', 'Pro Version Settings','manage_options', 'caption_hover_pro_settings', array($this,'pro_version_settings'));
			add_submenu_page( 'caption_hover', 'Export/Import', 'Export/Import','manage_options', 'caption_hover_submenu', array($this,'render_submenu_page'));
		}

		function pro_version_settings(){
			include 'includes/pro-version-settings.php';
		}

		function render_submenu_page(){
			?>
			<div class="metabox-holder">
				<div class="postbox">
					<h3><span><?php _e( 'Export Settings' ); ?></span></h3>
					<div class="inside">
						<p><?php _e( 'Export the Image Hover Effects settings if you want to use it in to another site.You will get a json file which you can upload using import section`. This allows you to easily import the configuration into another site.' ); ?></p>
						<form method="post">
							<p><input type="hidden" name="wdo_action" value="export_settings" /></p>
							<p>
								<?php wp_nonce_field( 'wdo_export_nonce', 'wdo_export_nonce' ); ?>
								<?php submit_button( __( 'Export' ), 'secondary', 'submit', false ); ?>
							</p>
						</form>
					</div><!-- .inside -->
				</div><!-- .postbox -->

				<div class="postbox">
					<h3><span><?php _e( 'Import Settings' ); ?></span></h3>
					<div class="inside">
						<p><?php _e( 'Import the Image Hover Effects settings by uploading a .json file. This file can be obtained by exporting the settings on another site using the form above.' ); ?></p>
						<form method="post" enctype="multipart/form-data">
							<p>
								<input type="file" name="import_file"/>
							</p>
							<p>
								<input type="hidden" name="wdo_action" value="import_settings" />
								<?php wp_nonce_field( 'wdo_import_nonce', 'wdo_import_nonce' ); ?>
								<?php submit_button( __( 'Import' ), 'secondary', 'submit', false ); ?>
							</p>
						</form>
					</div><!-- .inside -->
				</div><!-- .postbox -->
			</div><!-- .metabox-holder -->
		<?php }

		function save_caption_options(){
			if (isset($_REQUEST)) {
				update_option( 'la_caption_hover', $_REQUEST);
			}
		}

		function render_menu_page(){
			$saved_captions = get_option( 'la_caption_hover' );
			$pro_link = 'https://1.envato.market/BW2Yx';
			?>
			<div class="wrapper" id="caption">
				<div class="se-saved-con"></div>
				<div class="overlay-message">
				    <p>Changes Saved..!</p>
				</div>
				<h2 style="text-align: center;font-size: 30px;">Image Hover Effects</h2>
				<p style="text-align: center;">Best way to display images with text and animations.</p>
				<a class="button button-primary" style="text-decoration: none;color: #fff;text-align: center;margin: 22px auto;display: block;width: 30%;font-size: larger;" href="<?php echo plugin_dir_url( __FILE__ ); ?>documentation/" target="_blank">Documentation</a>
				
				<div id="faqs-container" class="accordian">
				<?php if (isset($saved_captions['posts'])) { ?>
				<?php foreach ($saved_captions['posts'] as $key => $data) { 
					?>
					
				    <h3><a href="#"><?php if ($data['cat_name'] !== '') {
				    	echo stripcslashes($data['cat_name']); 
				    } else {
				    	echo "Image Caption Hover";
				    }
				    ?></a><button class="button removecat"><span class="dashicons dashicons-dismiss" title="Remove Category"></span></button></h3>
				     
				     
				   <div class="accordian content">
					
				<?php foreach ($data['allcapImages'] as $key => $data2) { ?>   
				
				        <h3><a class=href="#"><?php if ($data2['img_name']!=='') {
				        	echo stripcslashes($data2['img_name']);
				        } else {
				        	echo "image";
				        }
				         ?></a><button class="button removeitem"><span class="dashicons dashicons-dismiss" title="Remove Image"></span></button></h3>
				        <div>
				        	<table class="form-table">
				        		<tr>
				        			<td style="width:30%">
				        				<strong><?php _e( 'Category Name', 'la-captionhover' ); ?></strong>
				        			</td>

				        			<td style="width:30%">
				        				<input type="text" class="catname widefat form-control" value="<?php echo stripcslashes($data['cat_name']); ?>">
				        			</td>

				        			<td style="width:40%">
				        				<p class="description"><?php _e( 'Name the category which would be shown on tab.It is only for reference.Category name should be same for everyimage', 'la-captionhover' ); ?></p>
				        			</td>
				        		</tr>
				        		<tr>
				        			<td >
				        				<strong><?php _e( 'Image Name', 'la-captionhover' ); ?></strong>
				        			</td>

				        			<td >
				        				<input type="text" class="imgname widefat form-control" value="<?php echo ( isset($data2['img_name']) && $data2['img_name'] != '' ) ? stripcslashes($data2['img_name']) : ''; ?>">
				        			</td>

				        			<td>
				        				<p class="description"><?php _e( 'Name to be shown on current inner tab.It will be for your reference only.', 'la-captionhover' ); ?></p>
				        			</td>
				        		</tr>
				        	</table>
				        	<button class="addimage button"><?php _e( 'Upload Image', 'la-captionhover' ); ?></button>
				        	<span class="image">
				        		<?php if (isset($data2['cap_img']) &&  $data2['cap_img']!='') {
				        		
				        			echo '<span>
				        						<img src="'.$data2['cap_img'].'">
					        					<span class="dashicons dashicons-dismiss">
					        					</span>
				        					</span>'; } ?>
				        		
				        	</span><br>
				        	<hr>
				        	<h4 style="font-size: 20px;text-align: center;"><?php _e( 'Caption Settings', 'la-captionhover' ); ?></h4>
				        	<hr>
							<table class="form-table">
								<tr>
									<td style="width:30%">
										<strong><?php _e( 'Caption Heading', 'la-captionhover' ); ?></strong>
									</td>
									<td style="width:30%">
										<input type="text" class="widefat capheading form-control" value="<?php echo stripcslashes($data2['cap_head']); ?>">
									</td>	
									<td style="width:40%">
										<p class="description"><?php _e( 'Give heading to be shown on image.', 'la-captionhover' ); ?></p>
									</td>
								</tr>
								<tr>
									<td>
										<strong><?php _e( 'Caption Description', 'la-captionhover' ); ?></strong>
									</td>
									<td>
										<textarea class="widefat capdesc form-control" rows="10"><?php echo stripslashes(trim($data2['cap_desc'])); ?></textarea>
									</td>
									<td>
										<p class="description"><?php _e( 'Give description to be shown on image under title.', 'la-captionhover' ); ?></p>
									</td>
								</tr>
								<tr>
									<td>
										<strong><?php _e( 'Caption Link', 'la-captionhover' ); ?></strong>
									</td>
									<td>
										<input type="text" class="widefat caplink form-control" value="<?php echo $data2['cap_link'] ?>">
									</td>
									<td>
										<p class="description"><?php _e( 'Give complete url of link which open when user click over image.', 'la-captionhover' ); ?></p>
									</td>
								</tr>
								<tr>
									<td>
										<strong><?php _e( 'Open Link in New Tab', 'la-captionhover' ); ?></strong>
									</td>
									<td>
										<select class="capnewtab form-control">
											<option value="yes"><?php _e( 'Yes', 'la-captionhover' ); ?></option>
											<option value="no"><?php _e( 'No', 'la-captionhover' ); ?></option>
										</select>
									</td>
									<td>
										<p class="description"><?php _e( 'Choose want to open link in new tab or not.', 'la-captionhover' ); ?></p>
									</td>
								</tr>

								<tr>
								    <td>
								        <strong><?php _e( 'Touch behaviour on mobile', 'la-captionhover' ); ?>  <b> <a class="pro-feature" href="<?php echo $pro_link; ?>" target="_blank">(PRO Feature)</a></b></strong>
								    </td>
								    <td>
								        <select class="captouchmobile form-control">
								            <option value="default"><?php _e( 'Default', 'la-captionhover' ); ?></option>
								            <option value="hoverontap"><?php _e( 'First Tap Hover, Second Tap Open Link', 'la-captionhover' ); ?></option> 
								        </select>
								    </td>
								    <td>
								        <p class="description"><?php _e( 'Select how you want links to behave on touch devices such as mobiles and tablets.', 'la-captionhover' ); ?></p>
								    </td>
								</tr>

								<tr>
				  					<td>
				  						<strong><?php _e( 'Caption Title Color', 'la-captionhover' ); ?></strong>
				  					</td>
				  					<td class="insert-picker">
				  						<input type="text" class="head-color" value="<?php echo $data2['cap_headcolor']; ?>">
				  					</td>
				  					<td> 
				  						<p class="description"><?php _e( 'Choose font color for caption heading', 'la-captionhover' ); ?>.</p>
				  					</td>
			  					</tr>

			  					<tr>
				  					<td>
				  						<strong><?php _e( 'Caption Description Color', 'la-captionhover' ); ?></strong>
				  					</td>
				  					<td class="insert-picker">
				  						<input type="text" class="desc-color" value="<?php echo $data2['cap_desccolor']; ?>">
				  					</td>
				  					<td>
				  						<p class="description"><?php _e( 'Choose font color for caption description', 'la-captionhover' ); ?>.</p>
				  					</td>
			  					</tr>
			  					<tr>
			  					    <td>
			  					        <strong><?php _e( 'Title | Description Font Size', 'la-captionhover' ); ?> <b> <a class="pro-feature" href="<?php echo $pro_link; ?>" target="_blank">(PRO Feature)</a></b></strong>
			  					    </td>
			  					    <td>
			  					        <input type="number" class="headfontsize form-control">
			  					    </td>
			  					    <td>
			  					        <p class="description"><?php _e( 'Give the font size(it will be in px) of Caption Heading and Description.(Default 22)', 'la_caption_hover' ); ?></p>
			  					    </td>
			  					</tr>
							</table>
							<hr>
							<h4 style="font-size: 20px;text-align: center;"><?php _e( 'Hover Settings', 'la-captionhover' ); ?></h4>
							<hr>
							<table class="form-table">
								<tr>
								    <td style="width:30%">
								        <strong><?php _e( 'Thumbnail Width', 'la-captionhover' ); ?> <b><a class="pro-feature" href="<?php echo $pro_link; ?>" target="_blank">(PRO Feature)</a></b></strong>
								        
								    </td>
								    <td style="width:30%">
								        <input type="number" class="form-control thumbwidth">
								    </td>
								    <td style="width:40%">
								        <p class="description"><?php _e( 'Give thumbnail width (keep width and height same for circle style) for the thumbnail.<b>Default(220px)</b>', 'la-captionhover' ); ?></p>
								    </td>
								</tr>
								<tr>
								    <td>
								        <strong><?php _e( 'Thumbnail Height', 'la-captionhover' ); ?> <b><a class="pro-feature" href="<?php echo $pro_link; ?>" target="_blank">(PRO Feature)</a></strong>        
								    </td>
								    <td>
								        <input type="number" class="form-control thumbheight">
								    </td>
								    <td>
								        <p class="description"><?php _e( 'Give thumbnail height (keep width and height same for circle style) for the thumbnail.<b>Default(220px)</b>', 'la-captionhover' ); ?></p>
								    </td>
								</tr>
								<tr>
									<td>
										<strong><?php _e( 'Image Shape', 'la-captionhover' ); ?></strong>
									</td>
									<td>
										<select class="styleopt form-control widefat">
										  <option value="circle" <?php if ( $data2['cap_style'] == 'circle' ) echo 'selected="selected"'; ?>><?php _e( 'Circle', 'la-captionhover' ); ?></option>
										  <option value="square" <?php if ( $data2['cap_style'] == 'square' ) echo 'selected="selected"'; ?>><?php _e( 'Square', 'la-captionhover' ); ?></option> 
										</select>
									</td>
									<td>
										<p class="description"><?php _e( 'Select shape of image. It could be square or circle.', 'la-captionhover' ); ?></p>
									</td>
								</tr>
								<tr>
									<td>
										<strong><?php _e( 'Select Hover Effect', 'la-captionhover' ); ?></strong>
									</td>
									<td>
										<select class="effectopt form-control widefat">
										  <option <?php if ( $data2['cap_effect'] == 'effect1' ) echo 'selected="selected"'; ?> value="effect1">Effect1</option>
										  <option <?php if ( $data2['cap_effect'] == 'effect2' ) echo 'selected="selected"'; ?> value="effect2">Effect2</option>
										  <option <?php if ( $data2['cap_effect'] == 'effect3' ) echo 'selected="selected"'; ?> value="effect3">Effect3</option>
										  <option <?php if ( $data2['cap_effect'] == 'effect4' ) echo 'selected="selected"'; ?> value="effect4">Effect4</option>
										  <option <?php if ( $data2['cap_effect'] == 'effect5' ) echo 'selected="selected"'; ?> value="effect5">Effect5</option>
										  <option <?php if ( $data2['cap_effect'] == 'effect6' ) echo 'selected="selected"'; ?> value="effect6">Effect6</option>
										  <option <?php if ( $data2['cap_effect'] == 'effect7' ) echo 'selected="selected"'; ?> value="effect7">Effect7</option>
										  <option <?php if ( $data2['cap_effect'] == 'effect8' ) echo 'selected="selected"'; ?> value="effect8">Effect8</option>
										  <option <?php if ( $data2['cap_effect'] == 'effect9' ) echo 'selected="selected"'; ?> value="effect9">Effect9</option>
										  <option <?php if ( $data2['cap_effect'] == 'effect10' ) echo 'selected="selected"'; ?> value="effect10">Effect10</option>
										  <option <?php if ( $data2['cap_effect'] == 'effect11' ) echo 'selected="selected"'; ?> value="effect11">Effect11</option>
										  <option <?php if ( $data2['cap_effect'] == 'effect12' ) echo 'selected="selected"'; ?> value="effect12">Effect12</option>
										  <option <?php if ( $data2['cap_effect'] == 'effect13' ) echo 'selected="selected"'; ?> value="effect13">Effect13</option>
										  <option <?php if ( $data2['cap_effect'] == 'effect14' ) echo 'selected="selected"'; ?> value="effect14">Effect14</option>
										  <option <?php if ( $data2['cap_effect'] == 'effect15' ) echo 'selected="selected"'; ?> value="effect15">Effect15</option>
										  <option <?php if ( $data2['cap_effect'] == 'effect16' ) echo 'selected="selected"'; ?> value="effect16">Effect16</option>
										  <option <?php if ( $data2['cap_effect'] == 'effect17' ) echo 'selected="selected"'; ?> value="effect17">Effect17</option>
										  <option <?php if ( $data2['cap_effect'] == 'effect18' ) echo 'selected="selected"'; ?> value="effect18">Effect18</option>
										  <option <?php if ( $data2['cap_effect'] == 'effect19' ) echo 'selected="selected"'; ?> value="effect19">Effect19</option>
										  <option <?php if ( $data2['cap_effect'] == 'effect20' ) echo 'selected="selected"'; ?> value="effect20">Effect20</option>
										   
										</select>
									</td>
									<td>
										<p class="description"><?php _e( 'Select hover animation. <b> <a class="pro-feature" href="'. plugin_dir_url( __FILE__ ).'documentation/" target="_blank">Check All Effects</a></b>.', 'la-captionhover' ); ?></p>
									</td>
								</tr>
								<tr>
									<td>
										<strong><?php _e( 'Animation Direction', 'la-captionhover' ); ?></strong>
									</td>
									<td>
										<select class="directionopt form-control widefat">
										  <option <?php if ( $data2['cap_direction'] == 'left_to_right' ) echo 'selected="selected"'; ?> value="left_to_right"><?php _e( 'Left To Right', 'la-captionhover' ); ?></option>
										  <option <?php if ( $data2['cap_direction'] == 'right_to_left' ) echo 'selected="selected"'; ?> value="right_to_left"><?php _e( 'Right To Left', 'la-captionhover' ); ?></option>
										  <option <?php if ( $data2['cap_direction'] == 'top_to_bottom' ) echo 'selected="selected"'; ?> value="top_to_bottom"><?php _e( 'Top To Bottom', 'la-captionhover' ); ?></option>
										  <option <?php if ( $data2['cap_direction'] == 'bottom_to_top' ) echo 'selected="selected"'; ?> value="bottom_to_top"><?php _e( 'Bottom To Top', 'la-captionhover' ); ?></option>
										</select>
									</td>
									<td>
										<p class="description"><?php _e( 'Select direction in which animation occur.', 'la-captionhover' ); ?></p>
									</td>
								</tr>

								<tr> 
									<td>
										<strong><?php _e( 'Images Per Row', 'la-captionhover' ); ?></strong> <br>
									</td>
									<td>
										<select class="capgrid form-control widefat">
										  <option value="12" <?php if ( $data2['cap_grid'] == '12' ) echo 'selected="selected"'; ?>>1</option>
										  <option value="6" <?php if ( $data2['cap_grid'] == '6' ) echo 'selected="selected"'; ?>>2</option>
										  <option value="4" <?php if ( $data2['cap_grid'] == '4' ) echo 'selected="selected"'; ?>>3</option>
										  <option value="3" <?php if ( $data2['cap_grid'] == '3' ) echo 'selected="selected"'; ?>>4</option>
										</select>
									</td>
									<td>
										<p class="description"><?php _e( 'Select how many images show in one row.Keep it same for every Image', 'la-captionhover' ); ?></p>
									</td>
								</tr>
								<tr>
								    <td>
								        <strong><?php _e( 'Caption Background Type', 'la-captionhover' ); ?><b> <a class="pro-feature" href="<?php echo $pro_link; ?>" target="_blank">(PRO Feature)</a></b></strong>
								    </td>
								    <td>
								        <select class="capbgtype form-control widefat">
								          <option value="color" >color</option>
								          <option value="image" >image</option>
								        </select>
								    </td>
								    <td>
								        <p class="description"><?php _e( 'Choose background type.It can be image or color. <b>Image over image</b> effect can be acheived with this option.', 'la-captionhover' ); ?></p>
								        <a style="color:#428bca;font-weight: bold;" href="https://demo.webdevocean.com/#image-over-image-section" target="_blank">Image over image effect example</a>
								    </td>
								</tr> 

								<tr class="bgcolorrow"> 
								    <td>
								        <strong><?php _e( 'Caption Background Color', 'la-captionhover' ); ?><b> <a class="pro-feature" href="<?php echo $pro_link; ?>" target="_blank">(PRO Feature)</a></b></strong>
								    </td>
								    <td>
								        <input type="text" class="form-control custom capbgcolor" value="#fff" />
								    </td>
								    <td><p class="description"><?php _e( 'Choose background color for the caption.(Default #1a4a72)', 'la-captionhover' ); ?></p></td>
								</tr>
								<tr class="bgimagerow"> 
								    <td>
								        <strong><?php _e( 'Choose Background Image', 'la-captionhover' ); ?><b> <a class="pro-feature" href="<?php echo $pro_link; ?>" target="_blank">(PRO Feature)</a></b></strong>
								    </td>
								    <td>
								        <button class="bgimage button"><?php _e( 'Upload Image', 'la-captionhover' ); ?></button>
								        <span class="backgroundimage">
								
								        </span>
								    </td>
								    <td><p class="description"><?php _e( 'Choose background color for the caption.(Default #1a4a72)', 'la-captionhover' ); ?></p></td>
								</tr>
								<tr class="bgimagerow"> 
								    <td>
								        <strong><?php _e( 'Background Size', 'la-captionhover' ); ?><b> <a class="pro-feature" href="<?php echo $pro_link; ?>" target="_blank">(PRO Feature)</a></b></strong>
								    </td>
								    <td>
								        <select class="capbgsize form-control widefat">
								          <option value="cover">Cover</option>
								          <option value="contain">Contain</option>
								          <option value="100% 100%">Full</option>
								        </select>

								    </td>
								    <td><p class="description"><?php _e( 'Choose background size.', 'la-captionhover' ); ?></p></td>
								</tr>

							</table>
							
					       	<span class="moreimages">
					    		<button class="button moreimg"><b title="Add New" class="dashicons dashicons-plus-alt"></b> <?php _e( 'Add New Image', 'la-captionhover' ); ?></button>
								<button class="button-primary addcat"><?php _e( 'Add New Category', 'la-captionhover' ); ?></button>
								<button class="button-primary fullshortcode pull-right" id="<?php echo $data2['shortcode']; ?>"><?php _e( 'Get Shortcode', 'la-captionhover' ); ?></button>
								
					    	</span>

					    	<div class="preview-container" style="display: none;">
                                <?php echo do_shortcode("[image-caption-hover id='".$data2['shortcode']."']"); ?>
                            </div>
 
				        </div> 
				        <?php } ?>

				   </div>
				   <?php }  ?>
				   <?php } else { ?>

				    <h3><a href="#">Image Caption Hover</a><button class="button removecat"><span class="dashicons dashicons-dismiss" title="Delete Category"></span></button></h3>
				     
				   <div class="accordian content">
					
				        <h3><a class=href="#">Image</a><button class="button removeitem"><span class="dashicons dashicons-dismiss" title="Delete Image"></span></button></h3>
				        <div>
				        	<table class="form-table">
				        		<tr>
				        			<td style="width:30%">
				        				<strong><?php _e( 'Category Name', 'la-captionhover' ); ?></strong>
				        			</td>

				        			<td style="width:30%">
				        				<input type="text" class="catname widefat form-control"> 
				        			</td>

				        			<td style="width:40%">
				        				<p class="description"><?php _e( 'Name the category which would be shown on tab.It is only for reference.Category name should be same for everyimage', 'la-captionhover' ); ?></p>
				        			</td>
				        		</tr>
				        		<tr>
				        			<td >
				        				<strong><?php _e( 'Image Name', 'la-captionhover' ); ?></strong>
				        			</td>

				        			<td >
				        				<input type="text" class="imgname widefat form-control" value="">
				        			</td>

				        			<td>
				        				<p class="description"><?php _e( 'Name to be shown on current inner tab.It will be for your reference only.', 'la-captionhover' ); ?></p>
				        			</td>
				        		</tr>
				        	</table>
				        	<button class="addimage button"><?php _e( 'Upload Image', 'la-captionhover' ); ?></button>
				        	<span class="image">
				        		
				        	</span><br>
				        	<hr>
				        	<h4 style="font-size: 20px;text-align: center;"><?php _e( 'Caption Settings', 'la-captionhover' ); ?></h4>
				        	<hr>
							<table class="form-table">

								<tr>
									<td style="width:30%">
										<strong><?php _e( 'Caption Heading', 'la-captionhover' ); ?></strong>
									</td>
									<td style="width:30%">
										<input type="text" class="widefat capheading form-control">
									</td>
									<td style="width:40%">
										<p class="description"><?php _e( 'Give heading to be shown on image.', 'la-captionhover' ); ?></p>
									</td>
								</tr>
								<tr>
									<td>
										<strong><?php _e( 'Caption Description', 'la-captionhover' ); ?></strong>
									</td>
									<td>
										<textarea class="widefat capdesc form-control" id="" cols="30" rows="10"></textarea>
									</td>
									<td>
										<p class="description"><?php _e( 'Give description to be shown on image under title.', 'la-captionhover' ); ?></p>
									</td>
								</tr>
								<tr>
									<td>
										<strong><?php _e( 'Caption Link', 'la-captionhover' ); ?></strong>
									</td>
									<td>
										<input type="text" class="widefat caplink form-control">
									</td>
									<td>
										<p class="description"><?php _e( 'Give complete url of link which open when user click over image.', 'la-captionhover' ); ?></p>
									</td>
								</tr>
								<tr>
									<td>
										<strong><?php _e( 'Open Link in New Tab', 'la-captionhover' ); ?></strong>
									</td>
									<td>
										<select class="capnewtab form-control">
											<option value="yes"><?php _e( 'Yes', 'la-captionhover' ); ?></option>
											<option value="no"><?php _e( 'No', 'la-captionhover' ); ?></option>
										</select>
									</td>
									<td>
										<p class="description"><?php _e( 'Choose want to open link in new tab or not.', 'la-captionhover' ); ?></p>
									</td>
								</tr>

								<tr>
								    <td>
								        <strong><?php _e( 'Touch behaviour on mobile', 'la-captionhover' ); ?>  <b> <a class="pro-feature" href="<?php echo $pro_link; ?>" target="_blank">(PRO Feature)</a></b></strong>
								    </td>
								    <td>
								        <select class="captouchmobile form-control">
								            <option value="default"><?php _e( 'Default', 'la-captionhover' ); ?></option>
								            <option value="hoverontap"><?php _e( 'First Tap Hover, Second Tap Open Link', 'la-captionhover' ); ?></option> 
								        </select>
								    </td>
								    <td>
								        <p class="description"><?php _e( 'Select how you want links to behave on touch devices such as mobiles and tablets.', 'la-captionhover' ); ?></p>
								    </td>
								</tr>

								<tr>
				  					<td>
				  						<strong><?php _e( 'Caption Title Color', 'la-captionhover' ); ?></strong>
				  					</td>
				  					<td class="insert-picker">
				  						<input type="text" class="head-color" value="#fff">
				  					</td>
				  					<td>
				  						<p class="description"><?php _e( 'Choose font color for caption heading', 'la-captionhover' ); ?>.</p>
				  					</td>
			  					</tr>

			  					<tr>
				  					<td>
				  						<strong><?php _e( 'Caption Description Color', 'la-captionhover' ); ?></strong>
				  					</td>
				  					<td class="insert-picker">
				  						<input type="text" class="desc-color" value="#fff">
				  					</td>
				  					<td>
				  						<p class="description"><?php _e( 'Choose font color for caption description', 'la-captionhover' ); ?>.</p>
				  					</td>
			  					</tr>
			  					<tr>
			  					    <td>
			  					        <strong><?php _e( 'Title | Description Font Size', 'la-captionhover' ); ?> <b> <a class="pro-feature" href="<?php echo $pro_link; ?>" target="_blank">(PRO Feature)</a></b></strong>
			  					    </td>
			  					    <td>
			  					        <input type="number" class="headfontsize form-control">
			  					    </td>
			  					    <td>
			  					        <p class="description"><?php _e( 'Give the font size(it will be in px) of Caption Heading.(Default 22)', 'la_caption_hover' ); ?></p>
			  					    </td>
			  					</tr>
							</table>
							<hr>
							<h4 style="font-size: 20px;text-align: center;"><?php _e( 'Hover Settings', 'la-captionhover' ); ?></h4>
							<hr>
							<table class="form-table">
								<tr>
								    <td style="width:30%">
								        <strong><?php _e( 'Thumbnail Width', 'la-captionhover' ); ?> <b><a class="pro-feature" href="<?php echo $pro_link; ?>" target="_blank">(PRO Feature)</a></b></strong>
								        
								    </td>
								    <td style="width:30%">
								        <input type="number" class="form-control thumbwidth">
								    </td>
								    <td style="width:40%">
								        <p class="description"><?php _e( 'Give thumbnail width (keep width and height same for circle style) for the thumbnail.<b>Default(220px)</b>', 'la-captionhover' ); ?></p>
								    </td>
								</tr>
								<tr>
								    <td>
								        <strong><?php _e( 'Thumbnail Height', 'la-captionhover' ); ?> <b><a class="pro-feature" href="<?php echo $pro_link; ?>" target="_blank">(PRO Feature)</a></strong>        
								    </td>
								    <td>
								        <input type="number" class="form-control thumbheight">
								    </td>
								    <td>
								        <p class="description"><?php _e( 'Give thumbnail height (keep width and height same for circle style) for the thumbnail.<b>Default(220px)</b>', 'la-captionhover' ); ?></p>
								    </td>
								</tr>
								<tr>
									<td>
										<strong><?php _e( 'Image Shape', 'la-captionhover' ); ?></strong>
									</td>
									<td>
										<select class="styleopt form-control widefat">
										  <option value="circle"><?php _e( 'Circle', 'la-captionhover' ); ?></option>
										  <option value="square"><?php _e( 'Square', 'la-captionhover' ); ?></option> 
										</select>
									</td>
									<td>
										<p class="description"><?php _e( 'Select shape of image. It could be square or circle.', 'la-captionhover' ); ?></p>
									</td>
								</tr>
								<tr>
									<td>
										<strong><?php _e( 'Select Hover Effect', 'la-captionhover' ); ?></strong>
									</td>
									<td>
										<select class="effectopt form-control widefat">
										  <option value="effect1">Effect1</option>
										  <option value="effect2">Effect2</option>
										  <option value="effect3">Effect3</option>
										  <option value="effect4">Effect4</option>
										  <option value="effect5">Effect5</option>
										  <option value="effect6">Effect6</option>
										  <option value="effect7">Effect7</option>
										  <option value="effect8">Effect8</option>
										  <option value="effect9">Effect9</option>
										  <option value="effect10">Effect10</option>
										  <option value="effect11">Effect11</option>
										  <option value="effect12">Effect12</option>
										  <option value="effect13">Effect13</option>
										  <option value="effect14">Effect14</option>
										  <option value="effect15">Effect15</option>
										  <option value="effect16">Effect16</option>
										  <option value="effect17">Effect17</option>
										  <option value="effect18">Effect18</option>
										  <option value="effect19">Effect19</option>
										  <option value="effect20">Effect20</option>
										   
										</select>
									</td>
									<td>
										<p class="description"><?php _e( 'Select hover animation. <b> <a class="pro-feature" href="'. plugin_dir_url( __FILE__ ).'documentation/" target="_blank">Check All Effects</a></b>', 'la-captionhover' ); ?></p>
									</td>
								</tr>
								<tr>
									<td>
										<strong><?php _e( 'Animation Direction', 'la-captionhover' ); ?></strong>
									</td>
									<td>
										<select class="directionopt form-control widefat">
										  <option value="left_to_right"><?php _e( 'Left To Right', 'la-captionhover' ); ?></option>
										  <option value="right_to_left"><?php _e( 'Right To Left', 'la-captionhover' ); ?></option>
										  <option value="top_to_bottom"><?php _e( 'Top To Bottom', 'la-captionhover' ); ?></option>
										  <option value="bottom_to_top"><?php _e( 'Bottom To Top', 'la-captionhover' ); ?></option>
										</select>
									</td>
									<td>
										<p class="description"><?php _e( 'Select direction in which animation occur.', 'la-captionhover' ); ?></p>
									</td>
								</tr>

								<tr>
									<td>
										<strong><?php _e( 'Images Per Row', 'la-captionhover' ); ?></strong> <br>
									</td>
									<td>
										<select class="capgrid form-control widefat">
										  <option value="12">1</option>
										  <option value="6">2</option>
										  <option value="4">3</option>
										  <option value="3">4</option>
										</select>
									</td>
									<td>
										<p class="description"><?php _e( 'Select how many images show in one row.Keep it same for every Image', 'la-captionhover' ); ?></p>
									</td>
								</tr>

								<tr>
								    <td>
								        <strong><?php _e( 'Caption Background Type', 'la-captionhover' ); ?><b> <a class="pro-feature" href="<?php echo $pro_link; ?>" target="_blank">(PRO Feature)</a></b></strong>
								    </td>
								    <td>
								        <select class="capbgtype form-control widefat">
								          <option value="color" >color</option>
								          <option value="image" >image</option>
								        </select>
								    </td>
								    <td>
								        <p class="description"><?php _e( 'Choose background type.It can be image or color. <b>Image over image</b> effect can be acheived with this option.', 'la-captionhover' ); ?></p>
								        <a style="color:#428bca;font-weight: bold;" href="https://www.youtube.com/watch?v=vJByUSE_P1k&feature=youtu.be" target="_blank">How to add image over image effect</a>
								    </td>
								</tr> 

								<tr class="bgcolorrow"> 
								    <td>
								        <strong><?php _e( 'Caption Background Color', 'la-captionhover' ); ?><b> <a class="pro-feature" href="<?php echo $pro_link; ?>" target="_blank">(PRO Feature)</a></b></strong>
								    </td>
								    <td>
								        <input type="text" class="form-control custom capbgcolor" value="#fff" />
								    </td>
								    <td><p class="description"><?php _e( 'Choose background color for the caption.(Default #1a4a72)', 'la-captionhover' ); ?></p></td>
								</tr>
								<tr class="bgimagerow"> 
								    <td>
								        <strong><?php _e( 'Choose Background Image', 'la-captionhover' ); ?><b> <a class="pro-feature" href="<?php echo $pro_link; ?>" target="_blank">(PRO Feature)</a></b></strong>
								    </td>
								    <td>
								        <button class="bgimage button"><?php _e( 'Upload Image', 'la-captionhover' ); ?></button>
								        <span class="backgroundimage">
								
								        </span>
								    </td>
								    <td><p class="description"><?php _e( 'Choose background color for the caption.(Default #1a4a72)', 'la-captionhover' ); ?></p></td>
								</tr>
								<tr class="bgimagerow"> 
								    <td>
								        <strong><?php _e( 'Background Size', 'la-captionhover' ); ?><b> <a class="pro-feature" href="<?php echo $pro_link; ?>" target="_blank">(PRO Feature)</a></b></strong>
								    </td>
								    <td>
								        <select class="capbgsize form-control widefat">
								          <option value="cover">Cover</option>
								          <option value="contain">Contain</option>
								          <option value="100% 100%">Full</option>
								        </select>

								    </td>
								    <td><p class="description"><?php _e( 'Choose background size.', 'la-captionhover' ); ?></p></td>
								</tr>

							</table><br>
							<span class="moreimages">
					    		<button class="button moreimg"><b title="Add New" class="dashicons dashicons-plus-alt"></b><?php _e( 'Add New Image', 'la-captionhover' ); ?></button>
								<button class="button-primary addcat"><?php _e( 'Add New Category', 'la-captionhover' ); ?></button>
								<button class="button-primary fullshortcode pull-right" id="1"><?php _e( 'Get Shortcode', 'la-captionhover' ); ?></button>
								
					    	</span>
				        </div>

				       	
				   </div>
				<?php } ?>
				</div>
					<button class="btn btn-success save-meta"><?php _e( 'Save Changes', 'la-captionhover' ); ?></button></br>
					<span id="la-loader" class="pull-right"><img src="<?php echo plugin_dir_url( __FILE__ ); ?>images/ajax-loader.gif"></span>
					<span id="la-saved"><strong><?php _e( 'Changes Saved!', 'la-captionhover' ); ?></strong></span>
			</div>
			<a style="text-decoration:none;"  href="https://1.envato.market/BW2Yx" target="_blank"><h4 style="border-radius: 20px;padding: 20px;background: #b72121;color: #fff;width: 40%;margin: 30px auto 0 auto;text-align:center;font-size:24px;">Get PRO Version</h4></a>
			<p class="clearfix"></p>
			
		<?php
		}

function render_caption_hovers($atts){
	$saved_captions = get_option( 'la_caption_hover' );

	if (isset($saved_captions['posts'])) { 
		$total_cols = 0;
		ob_start(); ?>
		<div class="image-hover-page-container animatedParent">
			<div class="row">
				<?php foreach($saved_captions['posts'] as $key => $data): ?>
					<?php foreach($data['allcapImages'] as $key => $data2): ?>
						<?php if ($atts['id']== $data2['shortcode']): ?>
							<?php 
								wp_enqueue_style( 'wdo-ihe-hover-css', plugins_url( 'css/image-hover.min.css',__FILE__ )); 
								wp_enqueue_script( 'wdo-hover-front-js', plugins_url( 'js/front.js', __FILE__ ), array('jquery'));
								$total_cols+= $data2['cap_grid'];
							 ?>
			                 <div class="col-lg-<?php echo $data2['cap_grid']; ?> col-sm-6">
			                   <!-- normal -->
			                   <div class="ih-item <?php echo $data2['cap_style']; ?> <?php echo $data2['cap_effect']; ?> <?php if ($data2['cap_effect']=='effect6' && $data2['cap_style']=='circle') {
			                    	echo "scale_up";
			                    } elseif($data2['cap_effect']=='effect8' && $data2['cap_style']=='square') {
			                    	echo "scale_up";
			                    }elseif($data2['cap_effect']=='effect1' && $data2['cap_style']=='square' && $data2['cap_direction']=='left_to_right'){
			                    		echo "left_and_right";
			                    }else{
			                    	
			                    	echo $data2['cap_direction'];
			                    } 
			                     ?>">
			 	                   <a class="taphover" href="<?php echo ( $data2['cap_link'] != '' ) ? $data2['cap_link'] : 'javascript:void(0)'; ?>">
			 		                   		<?php if($data2['cap_effect']=='effect1'&& $data2['cap_style']=='circle') {
			 		                   			echo "<div class='spinner'></div>";
			 		                   			} ?>
			 		                      <div class="img"><img style="height:100%;" src="<?php if ($data2['cap_img']!='') {
			 		                      	echo $data2['cap_img'];
			 		                      } else {
			 		                      	echo "http://www.gemologyproject.com/wiki/images/5/5f/Placeholder.jpg";
			 		                      }
			 		                       ?>" alt="img">

			 		                       <?php if($data2['cap_effect']=='effect4' && $data2['cap_style']=='square') 
			 		                       	echo "<div class='mask1'></div><div class='mask2'></div>";
			 		                       ?>

			 		                       </div>
			 		                       <?php if ($data2['cap_effect']=='effect8') { ?>
			 		                       	<div class="info-container">
			 		                       		
			 			                      <div class="info">
			 			                        <h3 style="color:<?php echo $data2['cap_headcolor']; ?>;<?php echo ( $data2['cap_head'] == '' ) ? 'opacity:0;' : '' ;  ?>"><?php if ($data2['cap_head'] !='') {
			 			                        	echo stripcslashes(trim($data2['cap_head']));
			 			                        } else {
			 			                        	echo "";
			 			                        }
			 			                         ?></h3>
			 			                        <p style="color:<?php echo $data2['cap_desccolor']; ?>"><?php if ($data2['cap_desc'] != '') {
			 			                        	echo stripcslashes($data2['cap_desc']); 
			 			                        } else {
			 			                        	echo "";
			 			                        }
			 			                         ?></p>
			 			                      </div>
			 		                       	</div>
			 		                       <?php } elseif($data2['cap_effect']=='effect1' || $data2['cap_effect']=='effect5' || $data2['cap_effect']=='effect13' || $data2['cap_effect']=='effect18' || $data2['cap_effect']=='effect20' || $data2['cap_effect']=='effect9') { ?>
			 		                       <div class="info" style="height:inherit;">
			 		                       		<div class="info-back">
			 				                        <h3 style="color:<?php echo $data2['cap_headcolor']; ?>;<?php echo ( $data2['cap_head'] == '' ) ? 'opacity: 0;' : '' ;  ?>"><?php if ($data2['cap_head'] !='') {
			 				                        	echo stripcslashes(trim($data2['cap_head']));
			 				                        } else {
			 				                        	echo "";
			 				                        }
			 				                         ?></h3>
			 				                        <p style="color:<?php echo $data2['cap_desccolor']; ?>"><?php if ($data2['cap_desc'] != '') {
			 				                        	echo stripcslashes($data2['cap_desc']); 
			 				                        } else {
			 				                        	echo "";
			 				                        }
			 				                         ?></p>
			 			                        </div>
			 		                      </div>
			 		                       	
			 		                       <?php } else{ ?>
			 								<div class="info">
			 			                        <h3 style="color:<?php echo $data2['cap_headcolor']; ?>;<?php echo ( $data2['cap_head'] == '' ) ? 'opacity: 0;' : '' ;  ?>"  >
			 			                        	<?php if ($data2['cap_head'] !='') {
			 			                        	echo stripcslashes(trim($data2['cap_head']));
			 			                        } else {
			 			                        	echo "";
			 			                        }
			 			                         ?></h3>
			 			                        <p style="color:<?php echo $data2['cap_desccolor']; ?>"><?php if ($data2['cap_desc'] != '') {
			 			                        	echo stripcslashes($data2['cap_desc']); 
			 			                        } else {
			 			                        	echo "";
			 			                        }
			 			                         ?></p>
			 		                      </div>
			 								

			 		                      <?php  }

			 		                        ?>
			 		                      
			 	                      </a>
			                       </div>
			                   <!-- end normal -->

			                 </div>	
						<?php endif ?>
						<?php if ($total_cols == 12): ?>
							</div><div class="row">
						<?php endif ?>
					<?php endforeach; ?>

				<?php endforeach; ?>
			</div>
				<!-- Row End -->
		</div>
		<!-- Container Rnd -->
			
		<?php				
	}
	return ob_get_clean();
}

		/**
		 * Process a settings export that generates a .json file of the shop settings
		 */
		function wdo_process_export_settings() {
			if( empty( $_POST['wdo_action'] ) || 'export_settings' != $_POST['wdo_action'] )
				return;
			if( ! wp_verify_nonce( $_POST['wdo_export_nonce'], 'wdo_export_nonce' ) )
				return;
			if( ! current_user_can( 'manage_options' ) )
				return;
			$settings = get_option( 'la_caption_hover' );
			ignore_user_abort( true );
			nocache_headers();
			header( 'Content-Type: application/json; charset=utf-8' );
			header( 'Content-Disposition: attachment; filename=image-hover-effect-export-' . date( 'm-d-Y' ) . '.json' );
			header( "Expires: 0" );
			echo json_encode( $settings );
			exit;
		}

		/**
		 * Process a settings import from a json file
		 */
		function wdo_process_import_settings() {
			if( empty( $_POST['wdo_action'] ) || 'import_settings' != $_POST['wdo_action'] )
				return;
			if( ! wp_verify_nonce( $_POST['wdo_import_nonce'], 'wdo_import_nonce' ) )
				return;
			if( ! current_user_can( 'manage_options' ) )
				return;
			$extension = end( explode( '.', $_FILES['import_file']['name'] ) );
			if( $extension != 'json' ) {
				wp_die( __( 'Please upload a valid .json file' ) );
			}
			$import_file = $_FILES['import_file']['tmp_name'];
			if( empty( $import_file ) ) {
				wp_die( __( 'Please upload a file to import' ) );
			}
			// Retrieve the settings from the file and convert the json object to an array.
			$settings = (array) json_decode( file_get_contents( $import_file ),true );
			update_option( 'la_caption_hover', $settings );
			wp_safe_redirect( admin_url( 'options-general.php?page=caption_hover' ) ); exit;
		}
	} 

 ?>