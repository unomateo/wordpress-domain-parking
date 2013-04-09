<?php
/** 
* Plugin Name:	Domain Parking for Multisite Blogs
* Plugin URI:	N/A
* Description:	Allows easy configuration for parking top level domains on a wordpress multisite
* Version:		1.0
* Author:		Matt Dunlap
* Author URI:	N/A
* Text Domain:  Domain Parking
*/

/**
 * Add Settings link to plugins
 */
require_once('views/View.php');
require_once('site.class.php');

define( 'DOMAINPARKING_PATH', plugin_dir_path(__FILE__) );
define( 'DOMAINPARKING_URL', plugin_dir_url(__FILE__) );

class DomainParking extends Site{
	private $view;
	public function __construct(){
		$this->view = new View(); 
		if(is_admin()){
			add_action('admin_menu', array($this, 'add_plugin_page'));
			//add_action('admin_init', array($this, 'page_init'));
		}
	}
	
	public function add_plugin_page(){
		add_options_page('Settings Admin', 'Domain Parking', 'manage_options', 'domain-parking', array($this, 'create_admin_page'));
	}
	
	public function create_admin_page(){
		
		$options = array();
		global $wpdb;
		
		if(isset($_POST['submit'])){
			$result = $this->park_domain();
			wp_redirect($_SERVER[REQUEST_URI]);
		}

		// is this a multisite
		$multisite = ( is_multisite() ) ? TRUE : FALSE;
		$options['is_multisite'] = $multisite;
		
		// get all the sites that are not already a top level domain
		$blogs = array();
		if($multisite){
			$blogs = $wpdb->get_results("SELECT b.blog_id, b.domain 
										 FROM wp_blogs b 
										 WHERE b.domain 
										 NOT IN (SELECT s.domain FROM wp_site s)");
		}
		$options['blogs'] = $blogs;
		
		$this->view->display('index', $options);
	}

}

$dp = new DomainParking();