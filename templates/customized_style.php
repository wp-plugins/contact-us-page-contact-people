<style>
<?php
global $people_contact_grid_view_style;
?>
#people_contacts_container .people_item .people-entry-item, .people_item .people-entry-item{
	background-color:<?php echo $people_contact_grid_view_style['grid_view_item_background'];?>;
	border:<?php echo $people_contact_grid_view_style['grid_view_item_border_width'];?>px <?php echo $people_contact_grid_view_style['grid_view_item_border_style'];?> <?php echo $people_contact_grid_view_style['grid_view_item_border_color'];?>;
	padding:<?php echo $people_contact_grid_view_style['grid_view_item_padding_tb'];?>px <?php echo $people_contact_grid_view_style['grid_view_item_padding_lr'];?>px;
			
	border-radius: <?php echo $people_contact_grid_view_style['grid_view_item_border_radius'];?>px !important;
	-moz-border-radius: <?php echo $people_contact_grid_view_style['grid_view_item_border_radius'];?>px !important;
	-webkit-border-radius: <?php echo $people_contact_grid_view_style['grid_view_item_border_radius'];?>px !important;
<?php
if($people_contact_grid_view_style['grid_view_item_shadow'] == 1){
?>
	-moz-box-shadow: 0 0 5px <?php echo $people_contact_grid_view_style['grid_view_item_shadow_color'];?> !important;
	-webkit-box-shadow: 0 0 5px <?php echo $people_contact_grid_view_style['grid_view_item_shadow_color'];?> !important;
	box-shadow: 0 0 5px <?php echo $people_contact_grid_view_style['grid_view_item_shadow_color'];?> !important;
<?php
}else{
?>
	-moz-box-shadow: 0 0 0px #ffffff !important;
	-webkit-box-shadow: 0 0 0px #ffffff !important;
	box-shadow: 0 0 0px #ffffff !important;
<?php
}
?>
}

/* Email Inquiry Form Style */
.custom_contact_popup * {
	box-sizing:content-box !important;
	-moz-box-sizing:content-box !important;
	-webkit-box-sizing:content-box !important;	
}
.custom_contact_popup h1 {
	clear:none !important;
	margin-top:0px !important;
	margin-bottom:5px !important;
}
.custom_contact_popup input[type="text"] {
	border-width:1px;
}
.custom_contact_popup textarea {
	border-width:1px;
}
</style>