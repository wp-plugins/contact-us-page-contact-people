<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * People Contact Manager Panel
 *
 * Table Of Contents
 *
 * admin_screen()
 */
class People_Category_Manager_Panel
{	
	public static function get_ultimate_version_name( $pro_version_name ) {
		return __( 'Ultimate Version', 'wc_email_inquiry' );
	}
	
	public static function get_ultimate_page_url( $pro_plugin_page_url ) {
		global $people_contact_admin_init;
		return $people_contact_admin_init->ultimate_plugin_page_url;
	}
	
	public static function admin_screen () {
		$message = '';
		
		global $people_contact_admin_init;
		add_filter( $people_contact_admin_init->plugin_name . '_pro_version_name', array( 'People_Category_Manager_Panel', 'get_ultimate_version_name' ) );
		add_filter( $people_contact_admin_init->plugin_name . '_pro_plugin_page_url', array( 'People_Category_Manager_Panel', 'get_ultimate_page_url' ) );
		
		?>
        <style>
		.pro_feature_fields { padding:0 10px 10px; }
		</style>
        <div id="htmlForm">
        <div style="clear:both"></div>
		<div class="wrap a3rev_panel_container a3rev_manager_panel_container">
        <div id="a3_plugin_panel_container"><div id="a3_plugin_panel_fields">
        <?php echo $message; ?>
		<?php
		if ( isset($_GET['action']) && $_GET['action'] == 'add_new' ) {
			People_Category_Manager_Panel::admin_category_update();
		} elseif ( isset($_GET['action']) && $_GET['action'] == 'edit' ) {
			People_Category_Manager_Panel::admin_category_update( $_GET['id'] );
		} elseif ( isset($_GET['action']) && $_GET['action'] == 'view-profile' ) {
			People_Category_Manager_Panel::admin_category_profiles( $_GET['id'] );
		} else {
			People_Category_Manager_Panel::admin_categories();
		}
		?>
        </div><div id="a3_plugin_panel_upgrade_area"><div id="a3_plugin_panel_extensions"><?php echo People_Contact_Functions::plugin_pro_notice(); ?></div></div></div>
        </div>
        </div>
		<?php
	}
	
	public static function admin_categories () {
		$all_categories = array ( array('id' => 1, 'category_name' => __('Profile Group', 'cup_cp') ) );
	?>
        <div class="icon32 icon32-a3rev-ui-settings icon32-a3revpeople-contact-settings" id="icon32-a3revpeople-category-manager"><br></div><h2><?php _e('Groups', 'cup_cp'); ?> <a class="add-new-h2" href="<?php echo admin_url('admin.php?page=people-category-manager&action=add_new', 'relative');?>"><?php _e('Add New', 'cup_cp'); ?></a></h2>
		<div style="clear:both;height:5px;"></div>
        <div class="pro_feature_fields">
        <?php global $people_contact_admin_init; $people_contact_admin_init->upgrade_top_message(true); ?>
        <div style="margin-bottom:5px;"><?php _e('Create Groups, assign Profiles to Groups and insert the Group into any Post or Page by Shortcode.', 'cup_cp'); ?></div>
		<form name="contact_setting" method="post" action="">
		  <table class="widefat post fixed sorttable people_table">
			<thead>
			  <tr>
				<th width="25" class="manage-column column-number" style="text-align:right;white-space:nowrap"><?php _e('No', 'cup_cp'); ?></th>
				<th width="15%" class="manage-column column-title" style="text-align:left;white-space:nowrap; width:15% !important;"><?php _e('Name', 'cup_cp'); ?></th>
				<th width="40%" class="manage-column column-shortcode" style="text-align:left;white-space:nowrap"><?php _e('Shortcode', 'cup_cp'); ?></th>
				<th width="55" class="manage-column column-profiles" style="text-align:center;white-space:nowrap"><?php _e('Profiles', 'cup_cp'); ?></th>
                <th width="65" class="manage-column column-activated" style="text-align:center;white-space:nowrap"><?php _e('Activated', 'cup_cp'); ?></th>
				<th width="100" style="text-align:center" class="manage-column column-actions">&nbsp;</th>
			  </tr>
			</thead>
			<tbody>
			<?php 
			if ( is_array($all_categories) && count($all_categories) > 0 ) {
				$i = 0;
				foreach ( $all_categories as $value ) {
					$i++;
					
					$total_profiles = 0;
			?>
			  <tr>
				<td valign="middle" class="no column-number" style="text-align:right;"><span class="number_item"><?php echo $i;?></span></td>
				<td valign="middle" style="text-align:left;" class="name column-title"><?php esc_attr_e( stripslashes( $value['category_name']) );?></td>
				<td valign="middle" class="column-shortcode">[people_group_contacts id="<?php echo $value['id'];?>" group_title="<?php esc_attr_e( stripslashes( $value['category_name']) );?>" column="3" show_map="1" show_group_title="1" ]</td>
				<td valign="middle" class="column-profiles" style="text-align:center"><?php echo $total_profiles;?></td>
                <td valign="middle" class="column-activated" style="text-align:center"><?php _e('Yes', 'cup_cp'); ?></td>
				<td valign="middle" class="column-actions" align="center"><a title="<?php _e('View Profiles', 'cup_cp'); ?>" href="<?php echo admin_url('admin.php?page=people-category-manager&action=view-profile&id='.$value['id'], 'relative');?>"><?php _e('View Profiles', 'cup_cp'); ?></a> | <a title="<?php _e('Edit', 'cup_cp'); ?>" href="<?php echo admin_url('admin.php?page=people-category-manager&action=edit&id='.$value['id'], 'relative');?>"><?php _e('Edit', 'cup_cp'); ?></a> | <a title="<?php _e('Delete', 'cup_cp'); ?>" href="<?php echo admin_url('admin.php?page=people-category-manager&action=del&id='.$value['id'], 'relative');?>" onclick="if(!confirm('<?php _e('Are you sure delete this category?', 'cup_cp'); ?>')){return false;}else{return true;}"><?php _e('Delete', 'cup_cp'); ?></a></td>
			  </tr>
			  <?php
				}
			}else{
								?>
			  <tr>
				<td valign="middle" align="center" colspan="6"><?php _e('No Groups', 'cup_cp'); ?></td>
			  </tr>
			  <?php
			}
		?>
			</tbody>
		  </table>
		</form>
		</div>
		<?php
	}
	
	public static function admin_category_update( $category_id = 0) {
		$category_name = '';
		$publish = 1;
		$bt_type = 'add_new_category';
		$bt_value = __('Create', 'cup_cp');
		$title = __('Add New Group', 'cup_cp');
		if ( $category_id > 0 ) {
			$data = array('id' => 1, 'category_name' => __('Profile Group', 'cup_cp') );
			$category_name = $data['category_name'];
			$publish = 1;
			$bt_type = 'update_category';
			$title = __('Edit Group', 'cup_cp');
			$bt_value = __('Update', 'cup_cp');
		}
	?>
		<div class="icon32 icon32-a3rev-ui-settings icon32-a3revpeople-contact-settings" id="icon32-a3revpeople-category-add"><br></div><h2><?php echo $title;?></h2>
		<div style="clear:both;"></div>
        <div class="a3rev_panel_container">
        <div class="pro_feature_fields">
        <?php global $people_contact_admin_init; $people_contact_admin_init->upgrade_top_message(true); ?>
		<form action="<?php echo admin_url('admin.php?page=people-category-manager', 'relative');?>" method="post">
        	<?php if ( $category_id > 0 ) { ?><input type="hidden" value="<?php echo $category_id;?>" id="category_id" name="category_id"><?php } ?>
            <h3><?php echo $title; ?></h3>
			<table class="form-table" style="margin-bottom:0;">
			  <tbody>
				<tr valign="top">
				  <th scope="row"><label for="category_name"><?php _e('Group Name', 'cup_cp') ?></label></th>
				  <td><input disabled="disabled" type="text" style="width:300px;" value="<?php esc_attr_e( stripslashes( $category_name ) );?>" id="category_name" name="category_name" /></td>
				</tr>
				<tr valign="top">
				  <th scope="row"><label><?php _e('Activate Shortcode', 'cup_cp') ?></label></th>
				  <td>
                  		<input
								name="publish"
                                id="publish"
								class="a3rev-ui-onoff_checkbox"
                                checked_label="<?php _e( 'YES', 'cup_cp' ); ?>"
                                unchecked_label="<?php _e( 'NO', 'cup_cp' ); ?>"
                                type="checkbox"
								value="1"
								<?php checked( $publish, 1 ); ?>
								/>
                  		<div class="description"><?php _e('Select Yes to add this Group to the list of Group shortcodes that can be inserted in Post or Pages by shortcode. Set No and the Group will not show in the Insert Shortcode drop down list of available Groups.', 'cup_cp'); ?></div></td>
				</tr>
        	  </tbody>
			</table>
            <div style="clear:both"></div>
			<p class="submit" style="margin-bottom:0;padding-bottom:0;">
            <input type="hidden" value="<?php echo $bt_type;?>" name="<?php echo $bt_type;?>" />
            <input disabled="disabled" type="submit" value="<?php echo $bt_value;?>" class="button button-primary" id="add_edit_buttom" name="add_edit_buttom"> <input type="button" class="button" onclick="window.location='admin.php?page=people-category-manager'" value="<?php _e('Cancel', 'cup_cp'); ?>" /></p>
		</form>
        </div>
	</div>           
    <?php
	}
	
	public static function admin_category_profiles ( $category_id ) {
		if ( $category_id < 1 ) return '';
		
		global $people_contact_grid_view_icon;
		
		$current_category = array('id' => 1, 'category_name' => __('Profile Group', 'cup_cp') );
		
		?>
        
        <div class="icon32 icon32-a3rev-ui-settings icon32-a3revpeople-contact-settings" id="icon32-a3revpeople-category-profiles-manager"><br></div><h2>"<?php echo esc_attr( stripslashes( $current_category['category_name'] ) ) ; ?>" <?php _e('Profiles', 'cup_cp'); ?></h2>
		<div style="clear:both;height:5px;"></div>
        <div class="pro_feature_fields">
        <?php global $people_contact_admin_init; $people_contact_admin_init->upgrade_top_message(true); ?>
        <div style="margin-bottom:5px;"><?php _e('Below are all of the Profiles currently assigned to this Group. Sort Profile order for this Group by drag and drop using the blue up - down arrow at the left of each Profile row.', 'cup_cp'); ?></div>
		<form name="contact_setting" method="post" action="">
		  <table class="widefat post fixed sorttable people_table">
			<thead>
			  <tr>
				<th width="25" class="manage-column column-number" style="text-align:left;white-space:nowrap"><?php _e('No', 'cup_cp'); ?></th>
				<th width="10%" class="manage-column column-title" style="text-align:left;white-space:nowrap"><?php _e('Name', 'cup_cp'); ?></th>
				<th width="18%" class="manage-column column-email" style="text-align:leftwhite-space:nowrap"><?php _e('Email', 'cup_cp'); ?></th>
				<th width="8%" class="manage-column column-phone" style="text-align:left;white-space:nowrap"><?php _e('Phone', 'cup_cp'); ?></th>
				<th width="15%" style="text-align:left" class="manage-column column-location"><?php _e('Location', 'cup_cp'); ?></th>
                <th width="8%" class="manage-column column-categories" style="text-align:left;white-space:nowrap"><?php _e('Groups', 'cup_cp'); ?></th>
				<th width="10" style="text-align:center" class="manage-column column-actions">&nbsp;</th>
			  </tr>
			</thead>
			<tbody>
			  <tr>
				<td valign="middle" align="center" colspan="7"><?php _e('No Profile for This Group', 'cup_cp'); ?></td>
			  </tr>
			</tbody>
		  </table>
		  <?php $people_category_update_orders = wp_create_nonce("people_category_update_orders"); ?>
			<script type="text/javascript">
				(function($){
					$(function(){
						var fixHelper = function(e, ui) {
							ui.children().each(function() {
								$(this).width($(this).width());
							});
							return ui;
						};
						$(".sorttable tbody").sortable({ helper: fixHelper, placeholder: "ui-state-highlight", opacity: 0.8, cursor: 'move', update: function() {
							var order = $(this).sortable("serialize") + '&category_id=<?php echo $category_id; ?>&action=people_category_update_orders&security=<?php echo $people_category_update_orders; ?>';
							$.post("<?php echo admin_url('admin-ajax.php', 'relative'); ?>", order, function(theResponse){
								$(".people_table").find(".number_item").each(function(index){
									$(this).html(index+1);
								});
							});
						}
						});
					});
				})(jQuery);
			</script>
		</form>
        </div>
		<?php	
	}
}
?>
