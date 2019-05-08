<?php
	if(!defined(WP_UNINSTALL_PLUGIN))
	die("This plugin can not be uninstalled from outside");
	
	if(get_option("cpl_options")!=false)
	{
		delete_option("cpl_options");
	}
?>
