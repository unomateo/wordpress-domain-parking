<?php 

/**
 * A site consists of:
 * Domain Name,
 * IP address,
 * site_id,
 * blog_id,
 * Options
 * 
 * @author matt
 *
 */
class Site {
	
	private $options = array();
	
	public function __construct(){
		global $wpdb, $table_prefix;
	}
	
	/**
	 * checks if the domain name is pointed to this server
	 * 
	 * returns false if the domain_name A record does not point to the server. Otherwise, returns true
	 * 
	 * @param string $domain_name
	 * @return boolean
	 */
	public static function has_proper_a_record($domain_name){
		
		if($_SERVER[SERVER_ADDR]!= gethostbyname($domain_name)){
			return false;
		} else {
			return true;
		}
		
	}
	
	/**
	 * inserts values into the wp_site table
	 * 
	 * @param string $domain_name
	 * @return integer
	 */
	public static function create_site($domain_name){
		global $wpdb, $table_prefix;
		$wpdb->insert($table_prefix.'site', array('domain'=>$domain_name, 'path'=>'/'));
		return $wpdb->insert_id;
	}
	
	/**
	 * Updates the wp_blogs table. 
	 * 
	 * replaces the old subdomain with the top level domain and updates the site_id with the top level domain's site_id
	 * 
	 * @param string $domain_name
	 * @param string $old_blog_name
	 * @param integer $site_id
	 * @return integer - blog_id from the affected row
	 */
	public static function update_blog($domain_name, $old_blog_id, $site_id){
		global $wpdb, $table_prefix;
		$wpdb->update($table_prefix.'blogs', array('site_id'=>$site_id, 'domain'=>$domain_name), array('blog_id'=>$old_blog_id));
		return $old_blog_id;
	}
	
	/**
	 * copies the site_meta from the default site to the newly added site
	 * @param integer $site_id
	 */
	public static function copy_site_meta($site_id){
		global $wpdb, $table_prefix;
		$wpdb->query('INSERT INTO '.$table_prefix.'sitemeta (site_id, meta_key, meta_value) 
					  SELECT '.$site_id.', meta_key, meta_value FROM wp_sitemeta WHERE site_id = 1');
	}
	
	/**
	 * updates the options for the new blog.
	 * 
	 * Option_names that are updated:
	 * --------------
	 * siteurl
	 * home
	 * 
	 * @param integer $blog_id
	 * @param string $domain_name
	 */
	public static function update_options($blog_id, $domain_name){
		global $wpdb, $table_prefix;
		$wpdb->update($table_prefix.$blog_id.'_options', array('option_value'=>'http://'.$domain_name), array('option_name'=>'siteurl'));
		$wpdb->update($table_prefix.$blog_id.'_options', array('option_value'=>'http://'.$domain_name), array('option_name'=>'home'));
	}
}