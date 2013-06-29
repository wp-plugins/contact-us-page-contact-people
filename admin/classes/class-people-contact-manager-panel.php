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
		@session_start();
		global $people_contact_grid_view_icon;
		$message = '';
		if( isset($_GET['action']) && $_GET['action'] == 'del' && isset($_GET['id']) && $_GET['id'] >= 0){
			$contacts = get_option('contact_arr');
			unset($contacts[$_GET['id']]);
			update_option('contact_arr',$contacts);
			$message = '<div class="updated" id=""><p>'.__('Profile Successfully deleted.', 'cup_cp').'</p></div>';
		} elseif (isset($_SESSION['people_contact_message'])) {
			$message = $_SESSION['people_contact_message'];
			unset($_SESSION['people_contact_message']);
		}
		
		$url = get_bloginfo('wpurl')."/wp-admin/admin.php";
		$contacts = get_option('contact_arr');
		?>
        <div id="htmlForm">
        <div style="clear:both"></div>
		<div class="wrap">
        
        <?php echo $message; ?>
        <div class="icon32 icon32-posts-post" id="icon-edit"><br></div><h2><?php _e('Profiles', 'cup_cp'); ?> <a class="add-new-h2" href="<?php echo $url;?>?page=people-contact"><?php _e('Add New', 'cup_cp'); ?></a></h2>
		<div style="clear:both;height:5px;"></div>
		<form name="contact_setting" method="post" action="">
		  <table class="widefat post fixed sorttable people_table">
			<thead>
			  <tr>
				<th width="30" class="manage-column column-title" style="text-align:left;white-space:nowrap"></th>
				<th width="2%" class="manage-column column-title" style="text-align:left;white-space:nowrap"><?php _e('No', 'cup_cp'); ?></th>
				<th width="5%" class="manage-column column-title">&nbsp;</th>
				<th width="10%" class="manage-column column-title" style="text-align:left;white-space:nowrap"><?php _e('Name', 'cup_cp'); ?></th>
				<th width="20%" class="manage-column column-title" style="text-align:leftwhite-space:nowrap"><?php _e('Email', 'cup_cp'); ?></th>
				<th width="10%" class="manage-column column-title" style="text-align:left;white-space:nowrap"><?php _e('Phone', 'cup_cp'); ?></th>
				<th style="text-align:left" class="manage-column column-title"><?php _e('Location', 'cup_cp'); ?></th>
				<th width="10%" style="text-align:center" class="manage-column column-title"></th>
			  </tr>
			</thead>
			<tbody>
			<?php 
			if(is_array($contacts) && count($contacts) > 0 ){
				$i = 0;
				foreach($contacts as $key=>$value){
					$i++;
					if($value['c_avatar'] != ''){
						$src = $value['c_avatar'];
					} else {
						$src = $people_contact_grid_view_icon['default_profile_image'];
					}
					?>
			  <tr id="recordsArray_<?php echo $key; ?>">
				<td style="cursor:pointer;" valign="middle"><img src="<?php echo PEOPLE_CONTACT_IMAGE_URL; ?>/updown.png" style="cursor:pointer" /></td>
				<td valign="middle" class="no"><span class="number_item"><?php echo $i;?></span></td>
				<td valign="middle" class="avatar" align="center"><img src="<?php echo $src?>" style="border:1px solid #CCC;padding:2px;background:#FFF;width:32px;" /></td>
				<td valign="middle" style="text-align:left;" class="name"><?php esc_attr_e( stripslashes( $value['c_name']));?></td>
				<td valign="middle" class="phone"><?php esc_attr_e( stripslashes( $value['c_email']));?></td>
				<td valign="middle" class="phone"><?php esc_attr_e( stripslashes( $value['c_phone']));?></td>
				<td valign="middle" class="address"><?php esc_attr_e( stripslashes( $value['c_address']));?></td>
				<td valign="middle" class="control" align="center"><a title="<?php _e('Edit', 'cup_cp'); ?>" href="<?php echo $url;?>?page=people-contact&action=edit&id=<?php echo $key;?>"><?php _e('Edit', 'cup_cp'); ?></a> | <a title="<?php _e('Delete', 'cup_cp'); ?>" href="<?php echo $url;?>?page=people-contact-manager&action=del&id=<?php echo $key;?>" onclick="if(!confirm('<?php _e('Are you sure delete this profile?', 'cup_cp'); ?>')){return false;}else{return true;}"><?php _e('Delete', 'cup_cp'); ?></a></td>
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