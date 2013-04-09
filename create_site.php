<?php 

require_once '../../../wp-config.php';
require_once 'domain-parking.php';
require_once 'site.class.php';

if(isset($_POST['submit'])){
	$site = new Site();
	
	$site_id = null; // from wp_site
	$blog_id = null; // from wp_blogs
	$domain_name = $_POST['domain_name'];
	$old_site = $_POST['old_site'];
	
	if(!Site::has_proper_a_record($domain_name)){
		wp_redirect('/wp-admin/options-general.php?page=domain-parking&error=no_a_record');
	}
	
	$site_id = Site::create_site($domain_name);
	
	Site::copy_site_meta($site_id);
	
	$blog_id = Site::update_blog($domain_name, $old_site, $site_id);
	
	Site::update_options($blog_id, $domain_name);
	
	wp_redirect('/wp-admin/options-general.php?page=domain-parking');
}

