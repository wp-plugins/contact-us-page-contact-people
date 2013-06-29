<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * People Contact AddNew
 *
 * Table Of Contents
 *
 * admin_screen_add_edit()
 */
class People_Contact_AddNew
{
	public static function admin_screen_add_edit(){
		global $people_contact_location_map_settings;
		if(isset($_POST['update_contact'])){
			@session_start();
			
			$contacts = get_option('contact_arr');
			
			$contacts[$_POST['key']] = $_REQUEST['contact_arr'];
			
			$contacts[$_POST['key']]['c_avatar'] = $_REQUEST['c_avatar'];
			
			update_option('contact_arr',$contacts);
			$_SESSION['people_contact_message'] = '<div class="updated" id=""><p>'.__('Profile Successfully updated.', 'cup_cp').'</p></div>';
			wp_redirect( 'admin.php?page=people-contact-manager', 301 );
			exit;
		
		} elseif(isset($_POST['add_new_contact'])){
			@session_start();
			$contacts = get_option('contact_arr');
			if(!is_array($contacts) && count($contacts) <= 0 ){
				$contacts = array();
			}
			$_REQUEST['contact_arr']['c_avatar'] = $_REQUEST['c_avatar'];
			$contacts[] = $_REQUEST['contact_arr'];
			update_option('contact_arr',$contacts);
			$_SESSION['people_contact_message'] = '<div class="updated" id=""><p>'.__('Profile Successfully created.', 'cup_cp').'</p></div>';
			wp_redirect( 'admin.php?page=people-contact-manager', 301 );
			exit;
		}
		
		$contacts = get_option('contact_arr');
	
        $url = get_bloginfo('wpurl')."/wp-admin/admin.php";
		$bt_type = 'add_new_contact';
		$bt_value = __('Create', 'cup_cp');
		$title = __('Add New Profile', 'cup_cp');
		$center_address = 'Australia';
		if ( $people_contact_location_map_settings['center_address'] != '') {
			$center_address = $people_contact_location_map_settings['center_address'];
		}
		$googleapis_url = 'http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($center_address).'&sensor=false';
		$geodata = file_get_contents($googleapis_url);
		$geodata = json_decode($geodata);
		$center_lat = $geodata->results[0]->geometry->location->lat;
		$center_lng = $geodata->results[0]->geometry->location->lng;
		$latlng_center = $latlng = $center_lat.','.$center_lng;
		$bt_cancel = '<a class="button" href="admin.php?page=people-contact-manager">'.__('Cancel', 'cup_cp').'</a>';
		
		$data = array('c_title' => '', 'c_name' => '', 'c_email' => '', 'c_phone' => '', 'c_fax' => '', 'c_mobile' => '', 'c_address' => '', 'c_latitude' => '', 'c_longitude' => '', 'c_shortcode' => '', 'c_avatar' => '');
		if(isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id']) && $_GET['id'] >= 0){
			$bt_type = 'update_contact';
			$data = $contacts[$_GET['id']];
			$title = __('Edit Profile', 'cup_cp');
			if ( (trim($data['c_latitude']) == '' || trim($data['c_longitude']) == '' ) && trim($data['c_address']) != '') {
				$googleapis_url = 'http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($data['c_address']).'&sensor=false';
				$geodata = file_get_contents($googleapis_url);
				$geodata = json_decode($geodata);
				$data['c_latitude'] = $geodata->results[0]->geometry->location->lat;
				$data['c_longitude'] = $geodata->results[0]->geometry->location->lng;	
			}
			if ( trim($data['c_latitude']) != '' && trim($data['c_longitude']) != '' ) {
				$latlng = $data['c_latitude'].','.$data['c_longitude'];
			}
			$bt_value = __('Update', 'cup_cp');
		}
		?>
        <div id="htmlForm">
        <div style="clear:both"></div>
		<div class="wrap">
        
        <div class="icon32 icon32-posts-post" id="icon-edit"><br></div><h2><?php echo $title;?></h2>
          <div style="clear:both;"></div>
		  <div class="contact_manager">
			<form action="" name="add_conact" id="add_contact" method="post">
			<input type="hidden" value="<?php echo $_GET['id'];?>" id="key" name="key">
            <div class="col-left">
            <h3><?php _e('Profile Details', 'cup_cp'); ?></h3>
            <p><?php _e("&lt;empty&gt; fields don't show on front end.", ''); ?></p>
			<table class="form-table" style="margin-bottom:0;">
			  <tbody>
				<tr valign="top">
				  <th scope="row"><label for="c_title"><?php _e('Title / Position', 'cup_cp') ?></label></th>
				  <td><input type="text" class="regular-text" value="<?php if(isset($data['c_title'])){ esc_attr_e( stripslashes( $data['c_title'] ) ) ;}?>" id="c_title" name="contact_arr[c_title]"></td>
				</tr>
				<tr valign="top">
				  <th scope="row"><label for="c_name"><?php _e('Name', 'cup_cp') ?></label></th>
				  <td><input type="text" class="regular-text" value="<?php if(isset($data['c_name'])){ esc_attr_e( stripslashes( $data['c_name']));}?>" id="c_name" name="contact_arr[c_name]"></td>
				</tr>
				<tr valign="top">
				  <th scope="row"><label for="c_avatar"><?php _e('Profile Image', 'cup_cp') ?></label></th>
				  <td>
                  <?php echo People_Contact_Uploader::upload_input_fields('contact_arr', 'c_avatar', __('Profile Image', 'cup_cp'), $data['c_avatar'], '<div class="description">'.__("Image format .jpg, .png, 150px by 150px recommended size.", 'cup_cp').'</div>', '236px' ); ?>
                  </td>
				</tr>
        	  </tbody>
			</table>
			<h3><?php _e('Contact Details', 'cup_cp'); ?></h3>
            <p><?php _e("&lt;empty&gt; fields don't show on front end.", ''); ?></p>
			<table class="form-table" style="margin-bottom:0;">
			  <tbody>
				<tr valign="top">
				  <th scope="row"><label for="c_email"><?php _e('Email', 'cup_cp') ?></label></th>
				  <td><input type="text" class="regular-text" value="<?php if(isset($data['c_email'])){esc_attr_e( stripslashes( $data['c_email'] ));}?>" id="c_email" name="contact_arr[c_email]"></td>
				</tr>
				<tr valign="top">
				  <th scope="row"><label for="c_phone"><?php _e('Phone', 'cup_cp') ?></label></th>
				  <td><input type="text" class="regular-text" value="<?php if(isset($data['c_phone'])){esc_attr_e( stripslashes( $data['c_phone'] ) );}?>" id="c_phone" name="contact_arr[c_phone]"></td>
				</tr>
				<tr valign="top">
				  <th scope="row"><label for="c_fax"><?php _e('Fax', 'cup_cp') ?></label></th>
				  <td><input type="text" class="regular-text" value="<?php if(isset($data['c_fax'])){esc_attr_e( stripslashes( $data['c_fax'] ));}?>" id="c_fax" name="contact_arr[c_fax]"></td>
				</tr>
				<tr valign="top">
				  <th scope="row"><label for="c_mobile"><?php _e('Mobile', 'cup_cp') ?></label></th>
				  <td><input type="text" class="regular-text" value="<?php if(isset($data['c_mobile'])){esc_attr_e( stripslashes( $data['c_mobile'] ));}?>" id="c_mobile" name="contact_arr[c_mobile]"></td>
				</tr>
			  </tbody>
			</table>
            
            <h3><?php _e('Location Address', 'cup_cp'); ?></h3>
            <p><?php _e("&lt;empty&gt; Profile location does not show on the map.", ''); ?></p>
			<table class="form-table" style="margin-bottom:0;">
			  <tbody>
				<tr valign="top">
				  <th scope="row"><label for="c_address"><?php _e('Address', 'cup_cp') ?></label></th>
				  <td><input type="text" class="regular-text" value="<?php if(isset($data['c_address'])){esc_attr_e( stripslashes( $data['c_address']));}?>" id="c_address" name="contact_arr[c_address]"></td>
				</tr>
				<tr valign="top">
				  <th scope="row"><label for="c_latitude"><?php _e('Latitude', 'cup_cp') ?></label></th>
				  <td><input type="text" readonly="readonly" class="regular-text" value="<?php if(isset($data['c_latitude'])){echo $data['c_latitude'];}?>" id="c_latitude" name="contact_arr[c_latitude]"></td>
				</tr>
				<tr valign="top">
				  <th scope="row"><label for="c_longitude"><?php _e('Longitude', 'cup_cp') ?></label></th>
				  <td><input type="text" readonly="readonly" class="regular-text" value="<?php if(isset($data['c_longitude'])){echo $data['c_longitude'];}?>" id="c_longitude" name="contact_arr[c_longitude]"></td>
				</tr>
			  </tbody>
			</table>
            
		<style>
		#a3_plugin_meta_upgrade_area_box { border:2px solid #E6DB55;-webkit-border-radius:10px;-moz-border-radius:10px;-o-border-radius:10px; border-radius: 10px; padding:10px; position:relative}
		#a3_plugin_meta_upgrade_area_box legend {margin-left:4px; font-weight:bold;}
		</style>
        <fieldset id="a3_plugin_meta_upgrade_area_box"><legend><?php _e('Upgrade to','cup_cp'); ?> <a href="<?php echo PEOPLE_CONTACT_AUTHOR_URI; ?>" target="_blank"><?php _e('Pro Version', 'cup_cp'); ?></a> <?php _e('to activate', 'cup_cp'); ?></legend>
            <h3><?php _e('3RD Party Contact Form Shortcode for this profile', 'cup_cp'); ?></h3>
            <table class="form-table" style="margin-bottom:0;">
            <tr valign="top">
				  <th scope="row"><label for="c_shortcode"><?php _e('Enter Form Shortcode', 'cup_cp') ?></label></th>
				  <td>
                  
                  <input disabled="disabled" type="text" class="regular-text" value="" id="c_shortcode" name="contact_arr[c_shortcode]"></td>
				</tr>
			  </tbody>
			</table>
		</fieldset>                
            
            </div>
			<div class="col-right">
			  <div class="maps_content" style="padding:10px 0px;">
			    <div id="map_canvas" style="width:100%;float:left;height:500px"></div>
              </div>
			</div>   
            <div style="clear:both"></div>
			<script type="text/javascript" >
			<?php
			$map_type = $people_contact_location_map_settings['map_type'];
			if($map_type == ''){
				$map_type = 'ROADMAP';
			}
			$zoom_level = $people_contact_location_map_settings['zoom_level'];
			if($zoom_level <= 0){
				$zoom_level = 16;
			}
			?>
			
			var geocoder;
			var map;
			var marker;
		
			function initialize(){
			//MAP
			  var latlng = new google.maps.LatLng(<?php echo $latlng;?>);
			  var latlng_center = new google.maps.LatLng(<?php echo $latlng_center;?>);
			  var options = {
				zoom: <?php echo $zoom_level;?>,
				center: latlng_center,
			
				mapTypeId: google.maps.MapTypeId.<?php echo $map_type;?>
			  };
					
			  map = new google.maps.Map(document.getElementById("map_canvas"), options);
			
			  //GEOCODER
			  geocoder = new google.maps.Geocoder();
					
			  marker = new google.maps.Marker({
				map: map,
				draggable: true,
				position: latlng
			  });
							
			}
			
			jQuery(document).ready(function ($) { 
					 
			  initialize();
							  
			  $(function() {
				$("#c_address").autocomplete({
				  //This bit uses the geocoder to fetch address values
				  source: function(request, response) {
					geocoder.geocode( {'address': request.term }, function(results, status) {
					  response($.map(results, function(item) {
						return {
						  label:  item.formatted_address,
						  value: item.formatted_address,
						  latitude: item.geometry.location.lat(),
						  longitude: item.geometry.location.lng()
						}
					  }));
					})
				  },
				  //This bit is executed upon selection of an address
				  select: function(event, ui) {
					$("#c_latitude").val(ui.item.latitude);
					$("#c_longitude").val(ui.item.longitude);
					var location = new google.maps.LatLng(ui.item.latitude, ui.item.longitude);
					marker.setPosition(location);
					map.setCenter(location);
				  }
				});
			  });
				
			  //Add listener to marker for reverse geocoding
			  google.maps.event.addListener(marker, 'drag', function() {
				geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
				  if (status == google.maps.GeocoderStatus.OK) {
					if (results[0]) {
					  $('#c_address').val(results[0].formatted_address);
					  $('#c_latitude').val(marker.getPosition().lat());
					  $('#c_longitude').val(marker.getPosition().lng());
					}
				  }
				});
			  });
			  
			});
			</script>
			<div style="clear:both"></div>
			<p class="submit" style="margin-bottom:0;padding-bottom:0;">
            <input type="hidden" value="<?php echo $bt_type;?>" name="<?php echo $bt_type;?>" />
            <input type="submit" value="<?php echo $bt_value;?>" class="button-primary" id="add_edit_buttom" name="add_edit_buttom"> <?php echo $bt_cancel;?></p>
			</form>
		  </div>
		  <div style="clear:both"></div>
		</div>
        <div style="clear:both"></div>
		</div>
		<?php
	}
}
?>