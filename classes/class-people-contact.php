<?php
/**
 * People Contact Class
 *
 * Table Of Contents
 *
 * People_Contact()
 * init()
 * send_a_contact()
 * load_ajax_contact_form()
 * create_contact_maps();
 */
class People_Contact {
	var $admin_page,$contact_manager;
	public $template_url = PEOPLE_CONTACT_PATH;
	
	public function People_Contact () {
		$this->init();
	}
	
	public function init () {
		//Add Ajax Send Email
		add_action('wp_ajax_send_a_contact', array( &$this, 'send_a_contact'));
		add_action('wp_ajax_nopriv_send_a_contact', array( &$this, 'send_a_contact'));
		//Add Ajax Action Client
		add_action('wp_ajax_load_ajax_contact_form', array( &$this, 'load_ajax_contact_form') );
		add_action('wp_ajax_nopriv_load_ajax_contact_form', array( &$this, 'load_ajax_contact_form') );
	}
	
	public function send_a_contact(){
		check_ajax_referer( 'send-a-contact', 'security' );
		$profile_email = trim($_REQUEST['profile_email']);
		$profile_name = trim($_REQUEST['profile_name']);
		$c_name = trim($_REQUEST['c_name']);
		$c_email = trim($_REQUEST['c_email']);
		$c_phone = trim($_REQUEST['c_phone']);
		$c_message = trim($_REQUEST['c_message']);
		
		$send_copy = 0;
		if ( isset($_REQUEST['send_copy']) )
			$send_copy = 1;
				
		if(trim($_REQUEST['c_subject']) != ''){
			$subject = trim($_REQUEST['c_subject']). ' ' . __('from', 'cup_cp'). ' ' .get_bloginfo('name');
		}else{
			$subject = __('Contact from', 'cup_cp').' '.get_bloginfo('name');
		}
		
		$profile_data = array(
			'subject' 			=> $subject,
			'to_email' 			=> $profile_email,
			'profile_name'		=> $profile_name,
			'profile_email'		=> $profile_email,
			'contact_name'		=> $c_name,
			'contact_email'		=> $c_email,
			'contact_phone'		=> $c_phone,
			'message'			=> $c_message,
		);
		$email_result = People_Contact_Functions::contact_to_people( $profile_data, $send_copy );
		
		echo $email_result;
		
		die();
	}
	
	public function load_ajax_contact_form() {
		check_ajax_referer( 'ajax-popup-contact', 'security' );
		global $people_contact_contact_forms_settings;
		global $people_contact_grid_view_icon;
		$data = People_Contact_Profile_Data::get_row( $_REQUEST['contact_id'], '', 'ARRAY_A' );
		?>
		<script type="text/javascript">
		jQuery(document).ready(function ($) {
			$('input[type="text"]').focus(function (){
				$(this).removeClass('error');
			});
			$('textarea').focus(function (){
				$(this).removeClass('error');
			});
			$("#c_submit").click(function (){
				
				var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
				var c_name = $("#c_name").val();
				var c_subject = $("#c_subject").val();
				var c_email = $("#c_email").val();
				var c_phone = $("#c_phone").val();
				var c_message = $("#c_message").val();
				
				if( $.trim(c_name).length <= 0 ){
					$("#c_name").addClass('error');
					return false;
				}
				
				if(reg.test(c_email) == false) {
					$("#c_email").addClass('error');
					return false;
				}
				
				if( $.trim(c_message).length <= 0 ){
					$("#c_message").addClass('error');
					return false;
				}
				
				var wait = $('.ajax-wait');
				wait.css('display','block');
	
				var form_data = $('#c_form').serialize();
				var url = '<?php echo admin_url('admin-ajax.php', 'relative');?>?action=send_a_contact&security=<?php echo wp_create_nonce("send-a-contact");?>&'+form_data;
		
				$.post( url, '', function(response) {
					$('#c_form').html(response);
					wait.css('display','none');
				});
				return false;
			});
		});
		</script>
		<div class="custom_contact_popup" style="float:left;position:relative;z-index:1000000 !important">
		<div style="clear:both"></div>
		<p><?php _e('This email will be delivered to', 'cup_cp'); ?>:</p>
		<div style="clear:both;height:1em;"></div>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr class="top_title">
			<td width="80" class="avatar"><img src="<?php if($data['c_avatar'] != ''){echo $data['c_avatar'];}else{ echo $people_contact_grid_view_icon['default_profile_image'];}?>" width="60" /></td>
			<td class="profile"><h1 class="title"><?php echo bloginfo('name');?></h1><h3><?php esc_attr_e( stripslashes(  $data['c_title']) );?></h3><span><?php esc_attr_e( stripslashes( $data['c_name'] ) );?></span></td>
		  </tr>
		</table>
		<div style="clear:both;height:1em;"></div>
		<form id="c_form" name="c_form" action="" enctype="multipart/form-data" method="post">
		<input type="hidden" value="<?php esc_attr_e( stripslashes( $data['c_email'] ) );?>" id="profile_email" name="profile_email" />
        <input type="hidden" value="<?php esc_attr_e( stripslashes(  $data['c_title']) );?> <?php esc_attr_e( stripslashes( $data['c_name'] ) );?>" id="profile_name" name="profile_name" />
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:0 !important">
		  <tr>
			<td width="100%"><label for="c_name" class="gfield_label"><?php _e('Name', 'cup_cp'); ?> <span class="gfield_required">*</span> :</label>
			<input type="text" tabindex="1" value="" id="c_name" name="c_name"></td>
		  </tr>
		  <tr>
			<td><label for="c_email" class="gfield_label"><?php _e('E-mail', 'cup_cp'); ?> <span class="gfield_required">*</span> :</label>
			<input type="text" tabindex="1" value="" id="c_email" name="c_email"></td>
		  </tr>
		  <tr>
			<td><label for="c_phone" class="gfield_label"><?php _e('Phone', 'cup_cp'); ?> <span class="gfield_required">*</span> :</label>
			<input type="text" tabindex="1" value="" id="c_phone" name="c_phone"></td>
		  </tr>
		  
		  <tr>
			<td><label for="c_subject" class="gfield_label"><?php _e('Subject', 'cup_cp'); ?> :</label>
			<input type="text" tabindex="1" value="" id="c_subject" name="c_subject"></td>
		  </tr>
		  
		  <tr>
			<td><label for="c_message" class="gfield_label"><?php _e('Message', 'cup_cp'); ?> <span class="gfield_required">*</span> :</label>
			<textarea cols="50" rows="3" tabindex="6" class="textarea large" id="c_message" name="c_message"></textarea></td>
		  </tr>
		  <tr>
			<td><input type="submit" tabindex="7" value="<?php _e('Send', 'cup_cp'); ?>" class="button c_submit" id="c_submit" name="c_submit"></td>
		  </tr>
		</table>
		</form>
		<div style="clear:both"></div>
		<div class="ajax-wait">&nbsp;</div></div>
		<?php
			
		die();
	}
	
	public function create_contact_maps($contacts = array()){
		global $people_contact_grid_view_layout, $people_contact_grid_view_style, $people_contact_location_map_settings, $people_contact_grid_view_icon, $people_contact_contact_forms_settings;
		$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
		
		$contact_us_page_id = get_option('contact_us_page_id');
		if( !is_page() || ($contact_us_page_id != get_the_ID()) ) return;
		if( !is_array($contacts) || count ($contacts) <= 0 ) return;
		
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script('maps-googleapis','https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false' );
		wp_enqueue_script( 'fancybox', PEOPLE_CONTACT_JS_URL . '/fancybox/fancybox' . $suffix . '.js', array( 'jquery' ), '1.6', true );
		wp_enqueue_style( 'woocommerce_fancybox_styles', PEOPLE_CONTACT_JS_URL . '/fancybox/fancybox.css' );
			
		$ajax_popup_contact = wp_create_nonce("ajax-popup-contact");
		
		$profile_email_page_link = '';
		
		$grid_view_col = $people_contact_grid_view_layout['grid_view_col'];
		
		$phone_icon = $people_contact_grid_view_icon['grid_view_icon_phone'];
		if( trim($phone_icon ) == '' ) $phone_icon = PEOPLE_CONTACT_IMAGE_URL.'/p_icon_phone.png';
		$fax_icon = $people_contact_grid_view_icon['grid_view_icon_fax'];
		if( trim($fax_icon ) == '' ) $fax_icon = PEOPLE_CONTACT_IMAGE_URL.'/p_icon_fax.png';
		$mobile_icon = $people_contact_grid_view_icon['grid_view_icon_mobile'];
		if( trim($mobile_icon ) == '' ) $mobile_icon = PEOPLE_CONTACT_IMAGE_URL.'/p_icon_mobile.png';
		$email_icon = $people_contact_grid_view_icon['grid_view_icon_email'];
		if( trim($email_icon ) == '' ) $email_icon = PEOPLE_CONTACT_IMAGE_URL.'/p_icon_email.png';
		
		$center_address = 'Australia';
		if ( $people_contact_location_map_settings['center_address'] != '') {
			$center_address = $people_contact_location_map_settings['center_address'];
		}
		
		$url = 'http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($center_address).'&sensor=false';
		$geodata = file_get_contents($url);
		$geodata = json_decode($geodata);
		$center_lat = $geodata->results[0]->geometry->location->lat;
		$center_lng = $geodata->results[0]->geometry->location->lng;
			
		$latlng_center = $center_lat.','.$center_lng;
		
		$map_type = $people_contact_location_map_settings['map_type'];
			if($map_type == ''){
				$map_type = 'ROADMAP';
			}
			$zoom_level = $people_contact_location_map_settings['zoom_level'];
			if($zoom_level <= 0){
				$zoom_level = 16;
			}
		
		?>
		<script type="text/javascript">
		<?php
		if ( $people_contact_location_map_settings['hide_maps_frontend'] != 1 ) {
			?>
			var infowindow = null;
			jQuery(document).ready(function() {
				initialize();
			});
			function initialize() {
				var centerMap = new google.maps.LatLng(<?php echo $latlng_center;?>);
				var myOptions = {
					zoom: <?php echo $zoom_level;?>,
					center: centerMap,
					mapTypeId: google.maps.MapTypeId.<?php echo $map_type;?>
				}
				var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
				setMarkers(map, sites);
				infowindow = new google.maps.InfoWindow({
					content: "loading..."
				});
				var bikeLayer = new google.maps.BicyclingLayer();
				bikeLayer.setMap(map);
			}
			var sites = [
				<?php
				$i = 0;
				if(is_array($contacts) && count($contacts) > 0 ){
					$i++;
					$notes = '';
					foreach($contacts as $key=>$value){
						if($value['c_avatar'] != ''){
								$src = $value['c_avatar'];
						}else{
							$src = $people_contact_grid_view_icon['default_profile_image'];
						}
						if ( (trim($value['c_latitude']) == '' || trim($value['c_longitude']) == '' ) && trim($value['c_address']) != '') {
							$url = 'http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($value['c_address']).'&sensor=false';
							$geodata = file_get_contents($url);
							$geodata = json_decode($geodata);
							$value['c_latitude'] = $geodata->results[0]->geometry->location->lat;
							$value['c_longitude'] = $geodata->results[0]->geometry->location->lng;	
						}
		echo $notes."['".esc_attr( stripslashes( $value['c_name']))."',".$value['c_latitude'].",".$value['c_longitude'].",".$i.",'".esc_attr( stripslashes( $value['c_address']))."',".$value['id'].",'".$src."','".trim(esc_attr( stripslashes( $value['c_phone'])))."','".esc_attr( stripslashes( $value['c_title']))."','".trim(esc_attr( stripslashes( $value['c_fax'])))."','".trim(esc_attr( stripslashes( $value['c_mobile'])))."']";
						$notes = ',';
					}
				}
				?>
			];
		
			function setMarkers(map, markers) {
				var infotext = '';
				jQuery("div.people_item").each(function(i) {
					var current_object = jQuery(this);
					var sites = markers[i];
					var siteLatLng = new google.maps.LatLng(sites[1], sites[2]);
					infotext = '<div class="infowindow"><p class="info_title">'+sites[8]+'</p><div class="info_avatar"><img src="'+sites[6]+'" /></div><div><p class="info_title2">'+sites[0]+'</p>';
					if (sites[7] != '') infotext += '<p><span class="p_icon_phone"><img src="<?php echo $phone_icon;?>" style="width:auto;height:auto" /></span> '+sites[7]+'</p>';
					if (sites[9] != '') infotext += '<p><span class="p_icon_fax"><img src="<?php echo $fax_icon;?>" style="width:auto;height:auto" /></span> '+sites[9]+'</p>';
					if (sites[10] != '') infotext += '<p><span class="p_icon_mobile"><img src="<?php echo $mobile_icon;?>" style="width:auto;height:auto" /></span> '+sites[10]+'</p>';
					
					infotext += '<p><span class="p_icon_email"><img src="<?php echo $email_icon;?>" style="width:auto;height:auto" /></span> <a style="cursor:pointer" class="direct_email direct_email_map" target="_blank" href="<?php echo $profile_email_page_link; ?>'+sites[5]+'"><?php _e('Click Here', 'cup_cp'); ?></a></p></div></div>';
					var marker = new google.maps.Marker({
						position: siteLatLng,
						map: map,
						title: sites[0],
						zIndex: sites[3],
						html: infotext,
						c_id: sites[5]/*,
						icon :  "/images/market.png"*/
					});
					current_object.find(".people-entry-item").mouseover(function(i){
						infowindow.setContent(marker.html);
						infowindow.open(map, marker);
					});
					
					current_object.find(".people-entry-item").mouseout(function(i){
						infowindow.close();
					});
			
					google.maps.event.addListener(marker, "click", function () {
					var c_id = this.c_id;
					var url='<?php echo admin_url('admin-ajax.php', 'relative');?>'+'?action=load_ajax_contact_form&contact_id='+c_id+'&security=<?php echo $ajax_popup_contact;?>';
						jQuery.fancybox({
							'maxWidth' : 450,
							'maxHeight' : 546,
							'width':'60%',
							'height':'80%',
							'fitToView'	: true,
							'autoSize' : true,
							'autoDimensions': true,
							'type': 'ajax',
							'content': url
						});
						
						return false;
					})
					
					google.maps.event.addListener(marker, 'mouseout', function() {
					   //infowindow.close();
					});
					google.maps.event.addListener(marker, "mouseover", function () {
						infowindow.setContent(this.html);
						infowindow.open(map, this);
					});
				});
			}
			<?php } ?>
			
				jQuery(document).on("click", ".direct_email", function(){
					var c_id2 = jQuery(this).attr("href");
					jQuery.fancybox.resize();
					var url2='<?php echo admin_url('admin-ajax.php', 'relative');?>'+'?action=load_ajax_contact_form&contact_id='+c_id2+'&security=<?php echo $ajax_popup_contact;?>';
						jQuery.fancybox({
							'maxWidth' : 450,
							'maxHeight' : 546,
							'width':'60%',
							'height':'80%',
							'fitToView'	: true,
							'autoSize' : true,
							'autoDimensions': true,
							'type': 'ajax',
							'content': url2
						});
						return false;
				});
			
			var popupWindow=null;

			function profile_popup(url){
				window.open(url,"_blank");
			}
			
			function profile_parent_disable() {
				if(popupWindow && !popupWindow.closed)
				popupWindow.focus();
			}
			
		</script>
    	<?php
		wp_enqueue_script( 'jquery-masonry', PEOPLE_CONTACT_JS_URL.'/masonry/jquery.masonry.min.js');
		global $is_IE;
		if($is_IE){ wp_enqueue_script( 'respondjs', PEOPLE_CONTACT_JS_URL . '/respond-ie.js' ); }
		
		wp_register_script( 'jquery_modernizr', PEOPLE_CONTACT_JS_URL.'/masonry/modernizr-transitions.js');
    	wp_enqueue_script( 'jquery_modernizr' );
		?>
        <script type="text/javascript">
        jQuery(window).load(function(){
			var grid_view_col = <?php echo $grid_view_col;?>;
			var screen_width = jQuery('body').width(); 
			jQuery('.people_box_content').imagesLoaded(function(){
				jQuery(this).masonry({
					itemSelector: '.people_item',
					columnWidth: jQuery('.people_box_content').width()/grid_view_col,
					isAnimated: !Modernizr.csstransitions
				});
			});
		});
		jQuery(window).resize(function() {
			var grid_view_col = <?php echo $grid_view_col;?>;
			var screen_width = jQuery('body').width(); 
			jQuery('.people_box_content').imagesLoaded(function(){
				jQuery(this).masonry({
					itemSelector: '.people_item',
					columnWidth: jQuery('.people_box_content').width()/grid_view_col,
					isAnimated: !Modernizr.csstransitions
				});
			});
		});
		</script>
		<?php
		$html = '';
		if( $people_contact_location_map_settings['hide_maps_frontend'] != 1 ){
			$html .= '<div style="clear:both"></div>';
			$html .= '<div class="people-entry">';
			$html .= '<div style="clear:both"></div>';
			
			if($people_contact_location_map_settings['map_height'] <= 0){
				$map_height = '400';
			}else{
				$map_height = $people_contact_location_map_settings['map_height'];
			}
			if($people_contact_location_map_settings['map_width'] <= 0){
				$map_width = '100';
			}else{
				$map_width = $people_contact_location_map_settings['map_width'];
			}
			$map_width_type = $people_contact_location_map_settings['map_width_type'];
			
			if($map_width_type == 'px'){
				$map_width_type = 'px';
			}else{
				$map_width_type = '%';
			}
		
			$html .= '<div id="map_canvas" style="width: '.$map_width.$map_width_type.'; height: '.$map_height.'px;float:left;"></div>';
			$html .= '<div style="clear:both;margin-bottom:0em;" class="custom_title"></div>';
			$html .= '<div style="clear:both;height:15px;"></div>';
			$html .= '</div>';
		}
		if( trim($people_contact_grid_view_layout['grid_view_team_title']) != '' ){
			$html .= '<div class="custom_box_title"><h1 class="p_title">'.trim($people_contact_grid_view_layout['grid_view_team_title']).'</h1></div>';
		}
		$html .= '<div style="clear:both;margin-bottom:1em;"></div>';
		$html .= '<div class="people_box_content pcol'.$grid_view_col.'">';
		$i = 0;
		if(is_array($contacts) && count($contacts) > 0 ){
			$i++;
			$notes = '';
			foreach($contacts as $key=>$value){
				if($value['c_avatar'] != ''){
					$src = $value['c_avatar'];
				}else{
					$src = $people_contact_grid_view_icon['default_profile_image'];
				}
						
				$html .= '<div class="people_item">';
				$html .= '<div class="people-entry-item">';
				$html .= '<div style="clear:both;"></div>';
				$html .= '<div class="people-content-item">';
				$html .= '<h3 class="p_item_title">'.esc_attr( stripslashes( $value['c_title'])).'</h3>';
				$html .= '<span class="p_content_left"><img src="'.$src.'" /></span>';
				$html .= '<span class="p_content_right">';
				$html .= '<h3 class="p_item_name">'.esc_attr( stripslashes( $value['c_name'])).'</h3>';
				if ( trim($value['c_phone']) != '') {
				$html .= '<p style="margin-bottom:5px;"><span class="p_icon_phone"><img src="'.$phone_icon.'" style="width:auto;height:auto" /></span> '. esc_attr( stripslashes( $value['c_phone'] ) ).'</p>';
				}
				if ( trim($value['c_fax']) != '') {
				$html .= '<p style="margin-bottom:5px;"><span class="p_icon_fax"><img src="'.$fax_icon.'" style="width:auto;height:auto" /></span> '. esc_attr( stripslashes( $value['c_fax'] ) ).'</p>';
				} 
				if ( trim($value['c_mobile']) != '') {
				$html .= '<p style="margin-bottom:5px;"><span class="p_icon_mobile"><img src="'.$mobile_icon.'" style="width:auto;height:auto" /></span> '. esc_attr( stripslashes($value['c_mobile'] ) ).'</p>';
				}
				
				
	
					$html .= '<p style="margin-bottom:0px;"><span class="p_icon_email"><img src="'.$email_icon.'" style="width:auto;height:auto" /></span> <a style="cursor:pointer" class="direct_email" href="'.$value['id'].'">'.__('Click Here', 'cup_cp').'</a></p>';
					$html .= '</span>';
				
				$html .= '</div>';
				$html .= '<div style="clear:both;"></div>';
				$html .= '</div>';
				$html .= '</div>';
			}
		}
		$html .= '</div>';
		$html .= '<div style="clear:both"></div>';
		return $html;
	}
}
?>