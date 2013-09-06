<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * People Contact Manager Panel
 *
 * Table Of Contents
 *
 * admin_screen()
 */
class People_Contact_Manager_Panel
{	
	public static function admin_screen () {
		global $people_contact_grid_view_icon;
		$message = '';
		if( isset($_GET['action']) && $_GET['action'] == 'del' && isset($_GET['id']) && $_GET['id'] >= 0){
			People_Contact_Profile_Data::delete_row( $_GET['id'] );
			$message = '<div class="updated" id=""><p>'.__('Profile Successfully deleted.', 'cup_cp').'</p></div>';
		} elseif ( isset($_GET['edited_profile']) ) {
			$message = '<div class="updated" id=""><p>'.__('Profile Successfully updated.', 'cup_cp').'</p></div>';
		} elseif ( isset($_GET['created_profile']) ) {
			$message = '<div class="updated" id=""><p>'.__('Profile Successfully created.', 'cup_cp').'</p></div>';
		}
		
		$my_contacts = People_Contact_Profile_Data::get_results('', 'c_order ASC', '', 'ARRAY_A');
		?>
        <div id="htmlForm">
        <div style="clear:both"></div>
		<div class="wrap">
        
        <?php echo $message; ?>
        <div class="icon32 icon32-posts-post" id="icon-edit"><br></div><h2><?php _e('Profiles', 'cup_cp'); ?> <a class="add-new-h2" href="<?php echo admin_url('admin.php?page=people-contact', 'relative');?>"><?php _e('Add New', 'cup_cp'); ?></a> <a class="add-new-h2 a3-view-docs-button" target="_blank" href="<?php echo PEOPLE_CONTACT_DOCS_URI;?>#section-5" ><?php _e('View Docs', 'cup_cp'); ?></a></h2>
		<div style="clear:both;height:5px;"></div>
		<form name="contact_setting" method="post" action="">
		  <table class="widefat post fixed sorttable people_table">
			<thead>
			  <tr>
				<th width="30" class="manage-column column-title" style="text-align:left;white-space:nowrap"></th>
				<th width="2%" class="manage-column column-title" style="text-align:right;white-space:nowrap"><?php _e('No', 'cup_cp'); ?></th>
				<th width="5%" class="manage-column column-title">&nbsp;</th>
				<th width="10%" class="manage-column column-title" style="text-align:left;white-space:nowrap"><?php _e('Name', 'cup_cp'); ?></th>
				<th width="20%" class="manage-column column-title" style="text-align:left;white-space:nowrap"><?php _e('Email', 'cup_cp'); ?></th>
				<th width="10%" class="manage-column column-title" style="text-align:left;white-space:nowrap"><?php _e('Phone', 'cup_cp'); ?></th>
				<th style="text-align:left" class="manage-column column-title"><?php _e('Location', 'cup_cp'); ?></th>
				<th width="10%" style="text-align:center" class="manage-column column-title"></th>
			  </tr>
			</thead>
			<tbody>
			<?php 
			if ( is_array($my_contacts) && count($my_contacts) > 0 ) {
				$i = 0;
				foreach ( $my_contacts as $value ) {
					$i++;
					if ( $value['c_avatar'] != '') {
						$src = $value['c_avatar'];
					} else {
						$src = $people_contact_grid_view_icon['default_profile_image'];
					}
					?>
			  <tr id="recordsArray_<?php echo $value['id']; ?>">
				<td style="cursor:pointer;" valign="middle"><img src="<?php echo PEOPLE_CONTACT_IMAGE_URL; ?>/updown.png" style="cursor:pointer" /></td>
				<td valign="middle" class="no" style="text-align:right;"><span class="number_item"><?php echo $i;?></span></td>
				<td valign="middle" class="avatar" align="center"><img src="<?php echo $src; ?>" style="border:1px solid #CCC;padding:2px;background:#FFF;width:32px;" /></td>
				<td valign="middle" style="text-align:left;" class="name"><?php esc_attr_e( stripslashes( $value['c_name']) );?></td>
				<td valign="middle" class="phone"><?php esc_attr_e( stripslashes( $value['c_email']) );?></td>
				<td valign="middle" class="phone"><?php esc_attr_e( stripslashes( $value['c_phone']) );?></td>
				<td valign="middle" class="address"><?php esc_attr_e( stripslashes( $value['c_address']) );?></td>
				<td valign="middle" align="center"><a title="<?php _e('Edit', 'cup_cp'); ?>" href="<?php echo admin_url('admin.php?page=people-contact&action=edit&id='.$value['id'], 'relative');?>"><?php _e('Edit', 'cup_cp'); ?></a> | <a title="<?php _e('Delete', 'cup_cp'); ?>" href="<?php echo admin_url('admin.php?page=people-contact&action=del&id='.$value['id'], 'relative');?>" onclick="if(!confirm('<?php _e('Are you sure delete this profile?', 'cup_cp'); ?>')){return false;}else{return true;}"><?php _e('Delete', 'cup_cp'); ?></a></td>
			  </tr>
			  <?php
				}
			}else{
								?>
			  <tr>
				<td valign="middle" align="center" colspan="8"><?php _e('No Profile', 'cup_cp'); ?></td>
			  </tr>
			  <?php
			}
		?>
			</tbody>
		  </table>
		  <?php $people_update_orders = wp_create_nonce("people_update_orders"); ?>
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
							var order = $(this).sortable("serialize") + '&action=people_update_orders&security=<?php echo $people_update_orders; ?>';
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
        </div>
		<?php	
	}
}
?>