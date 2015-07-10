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
		add_action('wp_ajax_send_a_contact', array( $this, 'send_a_contact'));
		add_action('wp_ajax_nopriv_send_a_contact', array( $this, 'send_a_contact'));
		//Add Ajax Action Client
		add_action('wp_ajax_load_ajax_contact_form', array( $this, 'load_ajax_contact_form') );
		add_action('wp_ajax_nopriv_load_ajax_contact_form', array( $this, 'load_ajax_contact_form') );
	}

	public function send_a_contact(){
		$profile_email = trim($_REQUEST['profile_email']);
		$profile_name = trim($_REQUEST['profile_name']);
		$c_name = trim($_REQUEST['c_name']);
		$c_email = trim($_REQUEST['c_email']);
		$c_phone = trim($_REQUEST['c_phone']);
		$c_message = trim($_REQUEST['c_message']);

		$send_copy = $_REQUEST['send_copy'];

		if(trim($_REQUEST['c_subject']) != ''){
			$subject = trim($_REQUEST['c_subject']). ' ' . people_ict_t__( 'Email Inquiry - from', __('from', 'cup_cp') ) . ' ' . ( function_exists('icl_t') ? icl_t( 'WP',__('Blog Title','wpml-string-translation'), get_option('blogname') ) : get_option('blogname') );
		}else{
			$subject = people_ict_t__( 'Email Inquiry - Contact from', __('Contact from', 'cup_cp') ).' '. ( function_exists('icl_t') ? icl_t( 'WP',__('Blog Title','wpml-string-translation'), get_option('blogname') ) : get_option('blogname') );
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
		global $people_contact_grid_view_icon;
		global $people_email_inquiry_global_settings;

		if ( trim( $people_email_inquiry_global_settings['inquiry_contact_text_button'] ) != '') $inquiry_contact_text_button = $people_email_inquiry_global_settings['inquiry_contact_text_button'];
		else $inquiry_contact_text_button = __('SEND', 'cup_cp');

		$inquiry_contact_button_class = apply_filters( 'people_inquiry_contact_button_class', '' );
		$inquiry_contact_form_class = apply_filters( 'people_inquiry_contact_form_class', '' );

		$contact_id = $_REQUEST['contact_id'];

		$data = People_Contact_Profile_Data::get_row( $contact_id, '', 'ARRAY_A' );
		?>
		<div class="custom_contact_popup <?php echo $inquiry_contact_form_class; ?>">
        <div style="padding:10px;">
		<div style="clear:both"></div>
		<div class="people_email_inquiry_contact_heading" ><?php echo $people_email_inquiry_global_settings['inquiry_contact_heading']; ?></div>
		<div style="clear:both; margin-top:10px"></div>
        <div class="people_email_inquiry_site_name"><?php echo $people_email_inquiry_global_settings['inquiry_form_site_name']; ?></div>
        <div style="clear:both; margin-top:5px"></div>
		<div style="float:left; margin-right:20px;" class="people_email_inquiry_default_image_container"><img src="<?php if($data['c_avatar'] != ''){echo $data['c_avatar'];}else{ echo PEOPLE_CONTACT_IMAGE_URL.'/no-avatar.png';}?>" width="80" /></div>
        <div style="display:block; margin-bottom:10px; padding-left:22%;" class="people_email_inquiry_product_heading_container">
			<div class="people_email_inquiry_profile_position"><?php esc_attr_e( stripslashes(  $data['c_title']) );?></div>
            <div class="people_email_inquiry_profile_name"><?php esc_attr_e( stripslashes(  $data['c_name']) );?></div>
        </div>
		<div style="clear:both;height:1em;"></div>
        <div class="people_email_inquiry_content" id="people_email_inquiry_content_<?php echo $contact_id; ?>">
        	<input type="hidden" value="<?php esc_attr_e( stripslashes( $data['c_email'] ) );?>" id="profile_email_<?php echo $contact_id; ?>" name="profile_email" />
        	<input type="hidden" value="<?php esc_attr_e( stripslashes(  $data['c_title']) );?> <?php esc_attr_e( stripslashes( $data['c_name'] ) );?>" id="profile_name_<?php echo $contact_id; ?>" name="profile_name" />
            <div class="people_email_inquiry_field">
                <label class="people_email_inquiry_label" for="c_name_<?php echo $contact_id; ?>"><?php people_ict_t_e( 'Default Form - Contact Name', __('Name', 'cup_cp') ); ?> <span class="gfield_required">*</span></label>
                <input type="text" name="c_name" id="c_name_<?php echo $contact_id; ?>" value="" /></div>
            <div class="people_email_inquiry_field">
                <label class="people_email_inquiry_label" for="c_email_<?php echo $contact_id; ?>"><?php people_ict_t_e( 'Default Form - Contact Email', __('Email', 'cup_cp') ); ?> <span class="gfield_required">*</span></label>
                <input type="text" name="c_email" id="c_email_<?php echo $contact_id; ?>" value="" /></div>
            <div class="people_email_inquiry_field">
                <label class="people_email_inquiry_label" for="c_phone_<?php echo $contact_id; ?>"><?php people_ict_t_e( 'Default Form - Contact Phone', __('Phone', 'cup_cp') ); ?> <span class="gfield_required">*</span></label>
                <input type="text" name="c_phone" id="c_phone_<?php echo $contact_id; ?>" value="" /></div>
            <div class="people_email_inquiry_field">
                <label class="people_email_inquiry_label" for="c_subject_<?php echo $contact_id; ?>"><?php people_ict_t_e( 'Default Form - Contact Subject', __('Subject', 'cup_cp') ); ?> </label>
                <input type="text" name="c_subject" id="c_subject_<?php echo $contact_id; ?>" value="" /></div>
            <div class="people_email_inquiry_field">
                <label class="people_email_inquiry_label" for="c_message_<?php echo $contact_id; ?>"><?php people_ict_t_e( 'Default Form - Contact Message', __('Message', 'cup_cp') ); ?> <span class="gfield_required">*</span></label>
                <textarea rows="3" name="c_message" id="c_message_<?php echo $contact_id; ?>"></textarea></div>
            <div class="people_email_inquiry_field">
                <?php if ( $people_email_inquiry_global_settings['send_copy'] != 'no' ) { ?>
                <label class="people_email_inquiry_label">&nbsp;</label>
                <label class="people_email_inquiry_send_copy"><input type="checkbox" name="send_copy" id="send_copy_<?php echo $contact_id; ?>" value="1" checked="checked" /> <?php people_ict_t_e( 'Default Form - Send Copy', __('Send a copy of this email to myself.', 'cup_cp') ); ?></label>
                <?php } ?>
                <a class="people_email_inquiry_form_button <?php echo $inquiry_contact_button_class; ?>" id="people_email_inquiry_bt_<?php echo $contact_id; ?>" contact_id="<?php echo $contact_id; ?>"><?php echo $inquiry_contact_text_button; ?></a>
            </div>
            <div style="clear:both"></div>
        </div>
		<div style="clear:both"></div>
		<div class="ajax-wait">&nbsp;</div>
        </div>
        </div>
		<?php

		die();
	}

	public function create_contact_maps($contacts = array() ) {
		global $people_email_inquiry_global_settings;
		global $people_contact_global_settings, $people_contact_grid_view_layout, $people_contact_location_map_settings, $people_contact_grid_view_icon;
		$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

		global $contact_people_page_id;
		if( !is_page() || ($contact_people_page_id != get_the_ID()) ) return;
		if( !is_array($contacts) || count ($contacts) <= 0 ) return;

		wp_enqueue_script( 'jquery' );
		People_Contact_Hook_Filter::frontend_scripts_enqueue();

		wp_enqueue_script('maps-googleapis','https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false' );
		wp_enqueue_script( 'fancybox', PEOPLE_CONTACT_JS_URL . '/fancybox/fancybox'.$suffix.'.js', array(), false, true );
		wp_enqueue_style( 'woocommerce_fancybox_styles', PEOPLE_CONTACT_JS_URL . '/fancybox/fancybox.css' );

		$ajax_popup_contact = wp_create_nonce("ajax-popup-contact");

		$unique_id = rand(100,10000);

		$profile_email_page_link = '#';

		$grid_view_col = $people_contact_global_settings['grid_view_col'];

		$show_map = ( $people_contact_location_map_settings['hide_maps_frontend'] != 1 ) ? 1 : 0 ;

		$phone_icon = PEOPLE_CONTACT_IMAGE_URL.'/p_icon_phone.png';
		$fax_icon = PEOPLE_CONTACT_IMAGE_URL.'/p_icon_fax.png';
		$mobile_icon = PEOPLE_CONTACT_IMAGE_URL.'/p_icon_mobile.png';
		$email_icon = PEOPLE_CONTACT_IMAGE_URL.'/p_icon_email.png';
		$website_icon = PEOPLE_CONTACT_IMAGE_URL.'/p_icon_website.png';

			$zoom_level           = $people_contact_location_map_settings['zoom_level'];
			$map_type             = $people_contact_location_map_settings['map_type'];
			$map_width_type       = $people_contact_location_map_settings['map_width_type'];
			$map_width_responsive = $people_contact_location_map_settings['map_width_responsive'];
			$map_width_fixed      = $people_contact_location_map_settings['map_width_fixed'];
			$map_height           = $people_contact_location_map_settings['map_height'];

		if ( '' == $map_type ) {
			$map_type = 'ROADMAP';
		}
		if ( $zoom_level <= 0 ) {
			$zoom_level = 16;
		}
		if ( $map_height <= 0 ) {
			$map_height = '400';
		}

		if ( $map_width_type == 'px' ) {
			$map_width_type = 'px';
			if ( $map_width_fixed <= 0 ) {
				$map_width = 100;
			} else {
				$map_width = $map_width_fixed;
			}
		} else {
			$map_width_type = '%';
			$map_width = $map_width_responsive;
		}
		?>
		<script type="text/javascript">
		<?php
		if ( $show_map != 0 ) {
			?>
			var infowindow = null;

			jQuery(document).ready(function() {
				initialize<?php echo $unique_id; ?>();
			});

			function initialize<?php echo $unique_id; ?>() {

				if ( sites<?php echo $unique_id; ?>.length < 1 ) return false;

				var myOptions = {
					zoom: <?php echo $zoom_level;?>,
					mapTypeId: google.maps.MapTypeId.<?php echo $map_type;?>
				}
				var map = new google.maps.Map(document.getElementById("map_canvas<?php echo $unique_id; ?>"), myOptions);

				setMarkers<?php echo $unique_id; ?>(map, sites<?php echo $unique_id; ?>);
				infowindow = new google.maps.InfoWindow({
					content: "loading..."
				});
				var bikeLayer = new google.maps.BicyclingLayer();
				bikeLayer.setMap(map);
			}

			var sites<?php echo $unique_id; ?> = [];
			<?php
			$i = 0;
			if(is_array($contacts) && count($contacts) > 0 ){
				foreach($contacts as $key=>$value){
					if ( 0 == $value['enable_map_marker'] ) continue;

					if ( (trim($value['c_latitude']) == '' || trim($value['c_longitude']) == '' ) && trim($value['c_address']) != '') {
						$url = 'http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($value['c_address']).'&sensor=false';
						$geodata = file_get_contents($url);
						$geodata = json_decode($geodata);
						$value['c_latitude'] = $geodata->results[0]->geometry->location->lat;
						$value['c_longitude'] = $geodata->results[0]->geometry->location->lng;
					}

					if ( trim( $value['c_latitude'] ) == '' || trim( $value['c_longitude'] ) == '' ) continue;

					$i++;

					if ( $value['c_avatar'] != '' ) {
						$src = $value['c_avatar'];
					} else {
						$src = PEOPLE_CONTACT_IMAGE_URL.'/no-avatar.png';
					}

					if ( class_exists('People_Contact_3RD_ContactForm_Functions') && People_Contact_3RD_ContactForm_Functions::check_enable_3rd_contact_form() ) {
						if ( '' == trim( $value['c_shortcode'] ) && '' == trim($people_email_inquiry_global_settings['contact_form_type_shortcode']) ) {
							$value['c_email'] = '';
						}
					}
					$profile_item = "['".esc_attr( stripslashes( $value['c_name']))."',".$value['c_latitude'].",".$value['c_longitude'].",".$i.",'".esc_attr( stripslashes( $value['c_address']))."',".$value['id'].",'".$src."','".trim(esc_attr( stripslashes( $value['c_phone'])))."','".esc_attr( stripslashes( $value['c_title']))."','".trim(esc_attr( stripslashes( $value['c_fax'])))."','".trim(esc_attr( stripslashes( $value['c_mobile'])))."','".trim(esc_url( stripslashes( $value['c_website'])))."','".trim(esc_attr( stripslashes( $value['c_email'])))."']";
			?>
			sites<?php echo $unique_id; ?>.push(<?php echo $profile_item; ?>);
			<?php
				}
				if ( $i < 1 ) {
					$show_map = 0;
				}
			} else {
				$show_map = 0;
			}
			?>

			function setMarkers<?php echo $unique_id; ?>(map, markers) {
				var infotext = '';
				var bounds = new google.maps.LatLngBounds ();
				jQuery.each( markers, function ( i, sites ) {
					var current_object = jQuery("div.people_item<?php echo $unique_id; ?>.people_item_id" + sites[5]);
					var siteLatLng = new google.maps.LatLng(sites[1], sites[2]);
					bounds.extend (siteLatLng);
					infotext = '<div class="infowindow"><p class="info_title">'+sites[8]+'</p><div class="info_avatar"><img src="'+sites[6]+'" /></div><div><p class="info_title2">'+sites[0]+'</p>';
					if (sites[4] != '') infotext += '<p class="info_address">'+sites[4]+'</p>';

					if (sites[12] != '') infotext += '<p><span class="p_icon_email"><img src="<?php echo $email_icon;?>" style="width:auto;height:auto" /></span> <a style="cursor:pointer" class="direct_email direct_email<?php echo $unique_id; ?> direct_email_map" target="_blank" profile-id="'+sites[5]+'" href="<?php echo $profile_email_page_link; ?>'+sites[5]+'"><?php echo ( function_exists('icl_t') ? icl_t( 'a3 Contact People', 'Profile Cards - Email Link Text', __('Click Here', 'cup_cp') ) : __('Click Here', 'cup_cp') ); ?></a></p>';
					infotext += '</div></div>';
					var marker = new google.maps.Marker({
						position: siteLatLng,
						map: map,
						title: sites[0],
						zIndex: sites[3],
						html: infotext,
						c_id: sites[5]/*,
						icon :  "/images/market.png"*/
					});
					if ( typeof(sites[1]) != 'undefined' && sites[1] != '' && typeof(sites[2]) != 'undefined' && sites[2] != '' ) {
						current_object.find(".people-entry-item").mouseover(function(i){
							infowindow.setContent(marker.html);
							infowindow.open(map, marker);
						});

						current_object.find(".people-entry-item").mouseout(function(i){
							infowindow.close();
						});
					}

					if (sites[12] != '') {
						google.maps.event.addListener(marker, "click", function () {
						var c_id = this.c_id;
							var ajax_url='<?php echo admin_url('admin-ajax.php', 'relative');?>'+'?action=load_ajax_contact_form&contact_id='+c_id+'&security=<?php echo $ajax_popup_contact;?>';
							var popup_wide = 520;

							if ( people_group_ei_getWidth<?php echo $unique_id; ?>()  <= 568 ) {
								popup_wide = '95%';
							}
							jQuery.fancybox({
								href: ajax_url,
								//content: ajax_url,
								centerOnScroll : <?php echo $people_email_inquiry_global_settings['fancybox_center_on_scroll'];?>,
								transitionIn : '<?php echo $people_email_inquiry_global_settings['fancybox_transition_in'];?>',
								transitionOut: '<?php echo $people_email_inquiry_global_settings['fancybox_transition_out'];?>',
								easingIn: 'swing',
								easingOut: 'swing',
								speedIn : <?php echo $people_email_inquiry_global_settings['fancybox_speed_in'];?>,
								speedOut : <?php echo $people_email_inquiry_global_settings['fancybox_speed_out'];?>,
								width: popup_wide,
								autoScale: true,
								autoDimensions: true,
								height: 500,
								margin: 0,
								maxWidth: "95%",
								maxHeight: "80%",
								padding: 10,
								overlayColor: '<?php echo $people_email_inquiry_global_settings['fancybox_overlay_color'];?>',
								showCloseButton : true,
								openEffect	: "none",
								closeEffect	: "none"
							});
							return false;
						})
					}

					if ( typeof(sites[1]) != 'undefined' && sites[1] != '' && typeof(sites[2]) != 'undefined' && sites[2] != '' ) {
						google.maps.event.addListener(marker, 'mouseout', function() {
						   //infowindow.close();
						});
						google.maps.event.addListener(marker, "mouseover", function () {
							infowindow.setContent(this.html);
							infowindow.open(map, this);
						});
					}
				});
				map.setCenter(bounds.getCenter());
				map.fitBounds(bounds);

				google.maps.event.addListenerOnce(map, 'idle', function(){
					if( map.getZoom() > <?php echo (int) $zoom_level; ?> ){
						map.setZoom(<?php echo $zoom_level;?>);
					}
				});
			}
			<?php } ?>

				var ajax_url2<?php echo $unique_id; ?>='<?php echo admin_url('admin-ajax.php', 'relative');?>'+'?action=load_ajax_contact_form&security=<?php echo $ajax_popup_contact;?>&contact_id=';
				jQuery(document).on("click", ".direct_email<?php echo $unique_id; ?>", function(){
					var c_id2 = jQuery(this).attr("profile-id");


						var popup_wide2 = 520;
						if ( people_group_ei_getWidth<?php echo $unique_id; ?>()  <= 568 ) {
							popup_wide2 = '95%';
						}
						jQuery.fancybox({
								href: ajax_url2<?php echo $unique_id; ?>+c_id2,
								//content: ajax_url,
								centerOnScroll : <?php echo $people_email_inquiry_global_settings['fancybox_center_on_scroll'];?>,
								transitionIn : '<?php echo $people_email_inquiry_global_settings['fancybox_transition_in'];?>',
								transitionOut: '<?php echo $people_email_inquiry_global_settings['fancybox_transition_out'];?>',
								easingIn: 'swing',
								easingOut: 'swing',
								speedIn : <?php echo $people_email_inquiry_global_settings['fancybox_speed_in'];?>,
								speedOut : <?php echo $people_email_inquiry_global_settings['fancybox_speed_out'];?>,
								width: popup_wide2,
								autoScale: true,
								autoDimensions: true,
								height: 500,
								margin: 0,
								maxWidth: "95%",
								maxHeight: "80%",
								padding: 10,
								overlayColor: '<?php echo $people_email_inquiry_global_settings['fancybox_overlay_color'];?>',
								showCloseButton : true,
								openEffect	: "none",
								closeEffect	: "none"
						});
						return false;
				});

			var popupWindow<?php echo $unique_id; ?>=null;

			function profile_popup<?php echo $unique_id; ?>(url){
				window.open(url,"_blank");
			}

			function profile_parent_disable<?php echo $unique_id; ?>() {
				if(popupWindow<?php echo $unique_id; ?> && !popupWindow<?php echo $unique_id; ?>.closed)
				popupWindow<?php echo $unique_id; ?>.focus();
			}

			function people_group_ei_getWidth<?php echo $unique_id; ?>() {
				xWidth = null;
				if(window.screen != null)
				  xWidth = window.screen.availWidth;

				if(window.innerWidth != null)
				  xWidth = window.innerWidth;

				if(document.body != null)
				  xWidth = document.body.clientWidth;

				return xWidth;
			}
		</script>
    	<?php
		wp_enqueue_script( 'jquery-masonry' );

		global $wp_version;
		$cur_wp_version = preg_replace('/-.*$/', '', $wp_version);
		?>
        <script type="text/javascript">
        jQuery(window).load(function(){
			var grid_view_col = <?php echo $grid_view_col;?>;
			var screen_width = jQuery('body').width();
			if(screen_width <= 750 && screen_width >= 481 ){
				grid_view_col = 2;
			}
			jQuery('.people_box_content<?php echo $unique_id; ?>').imagesLoaded(function(){
				jQuery('.people_box_content<?php echo $unique_id; ?>').masonry({
					itemSelector: '.people_item<?php echo $unique_id; ?>',
					<?php if ( version_compare( $cur_wp_version, '3.9', '<' ) ) { ?>
					columnWidth: jQuery('.people_box_content<?php echo $unique_id; ?>').width()/grid_view_col
					<?php } else { ?>
					columnWidth: '.people-grid-sizer'
					<?php } ?>
				});
			});
		});
		jQuery(window).resize(function() {
			var grid_view_col = <?php echo $grid_view_col;?>;
			var screen_width = jQuery('body').width();
			if(screen_width <= 750 && screen_width >= 481 ){
				grid_view_col = 2;
			}
			jQuery('.people_box_content<?php echo $unique_id; ?>').imagesLoaded(function(){
				jQuery('.people_box_content<?php echo $unique_id; ?>').masonry({
					itemSelector: '.people_item<?php echo $unique_id; ?>',
					<?php if ( version_compare( $cur_wp_version, '3.9', '<' ) ) { ?>
					columnWidth: jQuery('.people_box_content<?php echo $unique_id; ?>').width()/grid_view_col
					<?php } else { ?>
					columnWidth: '.people-grid-sizer'
					<?php } ?>
				});
			});
		});
		</script>
		<?php
		$html = '';
		if( $show_map != 0 ){
			$html .= '<div style="clear:both"></div>';
			$html .= '<div class="people-entry">';
			$html .= '<div style="clear:both"></div>';

			$html .= '<div id="map_canvas'.$unique_id.'" class="map_canvas_container" style="width: '.$map_width.$map_width_type.'; height: '.$map_height.'px;float:left;"></div>';
			$html .= '<div style="clear:both;margin-bottom:0em;" class="custom_title"></div>';
			$html .= '<div style="clear:both;height:15px;"></div>';
			$html .= '</div>';
		}

		$grid_view_team_title = trim($people_contact_global_settings['grid_view_team_title']);

		if ( $grid_view_team_title != '' ) {
			$html .= '<div class="custom_box_title"><h1 class="p_title">'.$grid_view_team_title.'</h1></div>';
		}
		$html .= '<div style="clear:both;margin-bottom:1em;"></div>';
		$html .= '<div class="people_box_content people_box_content'.$unique_id.' pcol'.$grid_view_col.'"><div class="people-grid-sizer"></div>';
		if(is_array($contacts) && count($contacts) > 0 ){
			foreach($contacts as $key=>$value){
				if($value['c_avatar'] != ''){
					$src = $value['c_avatar'];
				}else{
					$src = PEOPLE_CONTACT_IMAGE_URL.'/no-avatar.png';
				}

				$html .= '<div class="people_item people_item'.$unique_id.' people_item_id'.$value['id'].'">';
				$html .= '<div class="people-entry-item">';
				$html .= '<div style="clear:both;"></div>';
				$html .= '<div class="people-content-item">';
				$html .= '<h3 class="p_item_title">'.esc_attr( stripslashes( $value['c_title'])).'</h3>';
				$html .= '<div class="p_content_left"><img src="'.$src.'" /></div>';
				$html .= '<div class="p_content_right">';
				$html .= '<h3 class="p_item_name">'.esc_attr( stripslashes( $value['c_name'])).'</h3>';
				if ( trim($value['c_about']) != '') {
				$html .= wpautop(wptexturize( stripslashes( $value['c_about'] ) ) );
				}
				if ( trim($value['c_phone']) != '') {
				$html .= '<p style="margin-bottom:5px;"><span class="p_icon_phone"><img src="'.$phone_icon.'" style="width:auto;height:auto" /></span> '. esc_attr( stripslashes( $value['c_phone'] ) ).'</p>';
				}
				if ( trim($value['c_fax']) != '') {
				$html .= '<p style="margin-bottom:5px;"><span class="p_icon_fax"><img src="'.$fax_icon.'" style="width:auto;height:auto" /></span> '. esc_attr( stripslashes( $value['c_fax'] ) ).'</p>';
				}
				if ( trim($value['c_mobile']) != '') {
				$html .= '<p style="margin-bottom:5px;"><span class="p_icon_mobile"><img src="'.$mobile_icon.'" style="width:auto;height:auto" /></span> '. esc_attr( stripslashes($value['c_mobile'] ) ).'</p>';
				}
				if ( trim($value['c_website']) != '') {
				$html .= '<p style="margin-bottom:5px;"><span class="p_icon_website"><img src="'.$website_icon.'" style="width:auto;height:auto" /></span> <a href="'. esc_url( stripslashes($value['c_website'] ) ).'" target="_blank">'.( function_exists('icl_t') ? icl_t( 'a3 Contact People', 'Profile Cards - Website Link Text', __('Visit Website', 'cup_cp') ) : __('Visit Website', 'cup_cp') ).'</a></p>';
				}

				if ( trim($value['c_email']) != '') {

					$html .= '<p style="margin-bottom:0px;"><span class="p_icon_email"><img src="'.$email_icon.'" style="width:auto;height:auto" /></span> <a style="cursor:pointer" class="direct_email direct_email'.$unique_id.'" profile-id="'.$value['id'].'" href="#'.$value['id'].'">'.( function_exists('icl_t') ? icl_t( 'a3 Contact People', 'Profile Cards - Email Link Text', __('Click Here', 'cup_cp') ) : __('Click Here', 'cup_cp') ).'</a></p>';
				}
				$html .= '</div>';

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
