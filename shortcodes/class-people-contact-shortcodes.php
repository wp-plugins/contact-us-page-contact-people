<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * People Contact Shortcode
 *
 * Table Of Contents
 *
 * People_Contact_Shortcode()
 * init()
 * add_people_contact_button()
 * people_contact_generator_popup()
 * people_contacts_html()
 * people_contact_html()
 */
class People_Contact_Shortcode{
	
	var $admin_page,$contact_manager;
	public $template_url = PEOPLE_CONTACT_PATH;
	
	public function People_Contact_Shortcode () {
		$this->init();
	}
	
	public function init () {
		add_action( 'media_buttons', array( &$this, 'add_people_contact_button'), 100 );
		add_action( 'admin_footer', array( &$this, 'people_contact_generator_popup') );
		add_shortcode( 'people_contacts', array( &$this, 'people_contacts_html') );
	}
	
	public function add_people_contact_button() {
		$is_post_edit_page = in_array(basename($_SERVER['PHP_SELF']), array('post.php', 'page.php', 'page-new.php', 'post-new.php'));
        if(!$is_post_edit_page)
            return;
		echo '<a href="#TB_inline?width=640&inlineId=people-contact-wrap" class="thickbox button contact_add_shortcode" title="' . __( 'Insert shortcode', 'cup_cp' ) . '"><span class="contact_add_shortcode_icon"></span>'.__('Contact', 'cup_cp').'</a>';
		?>
        <style type="text/css">
		.contact_add_shortcode_icon {
            background: url("<?php echo PEOPLE_CONTACT_IMAGE_URL;?>/avatar16x16.png") no-repeat scroll left top transparent;
            display: inline-block;
			height: 16px;
			left: -5px;
			margin: 0 2px 0 0;
			position: relative;
			top: -2px;
			vertical-align: text-top;
			width: 16px;
        }
		#TB_ajaxContent{width:auto !important;}
		#TB_ajaxContent p {
			padding:2px 0;	
			margin:6px 0;
		}
		.field_content {
			padding:0 0 0 40px;
		}
		.field_content label{
			width:150px;
			float:left;
			text-align:left;
		}
		#a3_plugin_shortcode_upgrade_area { margin-top:10px; border:2px solid #E6DB55;-webkit-border-radius:10px;-moz-border-radius:10px;-o-border-radius:10px; border-radius: 10px; padding:0; position:relative}
	  	#a3_plugin_shortcode_upgrade_area h3{ margin-left:10px;}
	   	#a3_plugin_shortcode_extensions { background: url("<?php echo PEOPLE_CONTACT_IMAGE_URL; ?>/logo_a3blue.png") no-repeat scroll 4px 6px #FFFBCC; -webkit-border-radius:10px 10px 0 0;-moz-border-radius:10px 10px 0 0;-o-border-radius:10px 10px 0 0; border-radius: 10px 10px 0 0; color: #555555; margin: 0px; padding: 4px 8px 4px 100px; text-shadow: 0 1px 0 rgba(255, 255, 255, 0.8); min-height:35px;}
		</style>
		<?php
	}
	
	public function people_contact_generator_popup() {
		$contacts = People_Contact_Profile_Data::get_results('', 'c_order ASC', '', 'ARRAY_A');
		?>
		<div id="people-contact-wrap" style="display:none">
        <div id="a3_plugin_shortcode_upgrade_area"><?php echo People_Contact_Functions::extension_shortcode(); ?>
			<div class="field_content">
            <div id="people-contact-content" class="people-contact-content" style="text-align:left;padding:20px 0;">
            <h3>Insert People Contact</h3>
            <p><label for="people_contact_item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php _e('Select people', 'cup_cp'); ?>:</label> 
                <select style="min-width:300px" id="people_contact_item" name="people_contact_item">
                <?php
				    echo '<option value="">'.__('Please select...', 'cup_cp').'</option>';	
					if( is_array($contacts) && count($contacts) > 0 ){
						foreach ($contacts as $key=>$value) {
							$profile_name =  trim( esc_attr( stripslashes($value['c_name']) ) );
							if ($profile_name == '') $profile_name = trim( esc_attr( stripslashes($value['c_title']) ) ); 
							echo '<option value="'.$value['id'].'">'.$profile_name.'</option>';
						}
					} 
				?>
                </select> <img class="people_contact_item_loader" style="display:none;" src="<?php echo PEOPLE_CONTACT_IMAGE_URL; ?>/ajax-loader.gif" border=0 />
            </p>
            
            <p><label for="people_contact_align">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php _e('Alignment', 'cup_cp'); ?>:</label> <select style="width:100px" id="people_contact_align" name="people_contact_align"><option value="none" selected="selected"><?php _e('None', 'cup_cp'); ?></option><option value="left-wrap"><?php _e('Left - wrap', 'cup_cp'); ?></option><option value="left"><?php _e('Left - no wrap', 'cup_cp'); ?></option><option value="center"><?php _e('Center', 'cup_cp'); ?></option><option value="right-wrap"><?php _e('Right - wrap', 'cup_cp'); ?></option><option value="right"><?php _e('Right - no wrap', 'cup_cp'); ?></option></select> <span class="description"><?php _e('Horizontal aliginment of grid item', 'cup_cp'); ?></span></p>
				<p><label for="people_contact_item_width">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php _e('Box width', 'cup_cp'); ?>:</label> <input style="width:100px;" size="10" id="people_contact_item_width" name="people_contact_item_width" type="text" value="300" />px</p>
				<p><label for="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php _e('Padding', 'cup_cp'); ?></strong>:</label><br /> 
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label for="people_contact_padding_top" style="width:auto; float:none"><?php _e('Above', 'cup_cp'); ?>:</label><input style="width:50px;" size="10" id="people_contact_padding_top" name="people_contact_padding_top" type="text" value="10" />px &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                	<label for="people_contact_padding_bottom" style="width:auto; float:none"><?php _e('Below', 'cup_cp'); ?>:</label> <input style="width:50px;" size="10" id="people_contact_padding_bottom" name="people_contact_padding_bottom" type="text" value="10" />px &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                	<label for="people_contact_padding_left" style="width:auto; float:none"><?php _e('Left', 'cup_cp'); ?>:</label> <input style="width:50px;" size="10" id="people_contact_padding_left" name="people_contact_padding_left" type="text" value="0" />px &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                	<label for="people_contact_padding_right" style="width:auto; float:none"><?php _e('Right', 'cup_cp'); ?>:</label> <input style="width:50px;" size="10" id="people_contact_padding_right" name="people_contact_padding_right" type="text" value="0" />px
                </p>
           
            
			</div>
            <div style="clear:both;height:0px"></div>
            <p><input disabled="disabled" type="button" class="button-primary" value="<?php _e('Insert Shortcode', 'cup_cp'); ?>" />&nbsp;&nbsp;&nbsp;
            <a class="button" style="" href="#" onclick="tb_remove(); return false;"><?php _e('Cancel', 'cup_cp'); ?></a>
			</p>
		</div>
        </div>
        </div>
        <style type="text/css">
		.people_value{position:relative;top:-2px;}
        .people_item {margin-right:5%;}
        </style>
		<?php
	}
	
	public function people_contacts_html( $atts ) {
		global $people_contact;
		extract( shortcode_atts( array(), $atts ) );
		$contacts = People_Contact_Profile_Data::get_results('', 'c_order ASC', '', 'ARRAY_A');
		return '<div id="people_contacts_container">'.$people_contact->create_contact_maps($contacts).'</div>';
	}
	
}
?>