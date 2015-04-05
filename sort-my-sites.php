<?php 
/*
Plugin Name: Sort My Sites
Plugin URI: https://github.com/tryonegg/sort-my-sites
Description: Sort both the Admin Bar->My Sites dropdown and My Sites page in the dasboard. 
Author: Tryon Eggleston
Author URI: https://github.com/tryonegg/
Version: 1.1
Network: true
*/

if ( ! defined( 'WPINC' ) ) { // If this file is called directly, abort.
	die;
}

class sort_my_sites {
	const VERSION = 1.1;
	protected $plugin_slug = 'sort-my-sites';
	protected static $instance = null;

	protected $options = array(
		 "case_sensitive"	=> false,
		 "primary_at_top"	=> true,
		 "order_by" 		=> "blogname",
		 "order_options" 	=> array(
			null 				=> 'None',
			'userblog_id' 		=> "Site ID", 
			'blogname' 			=> "Site Name", 
			'domain' 			=> "Domain", 
			'path' 				=> "Site Path", 
			'siteurl' 			=> "Site URL" 
		)
	);

	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

	public function get_options() {
		return $this->options;
	}

	private function __construct() {

		add_filter( 'get_blogs_of_user', array( $this, 'sort_sites' ) );

		$this->options['case_sensitive'] = $this->get_option('case_sensitive');
		$this->options['primary_at_top'] = $this->get_option('primary_at_top');
		$this->options['order_by'] = $this->get_option('order_by');

	}

	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}


	/**
	 * Gets the most relevant option setting
	 * @param string
	*/
	public function get_option( $option ){

		$useroptions = get_user_meta( get_current_user_id(), 'sort_my_sites_options', true);

		if( $useroptions ){
			if( isset( $useroptions[$option] ) ){
				return $useroptions[$option];
			} else {
				return false;
			}
		} else {
			return get_site_option(  $this->plugin_slug . "_" . $option, $this->options[ $option ]  );
		}

	}


	/**
	 * Compares A & B
	 *
	 * @param  object
	 * @param  object
	 */
	
	public function sorter($a, $b){
		$o = $this->options['order_by'];
		if ( $a->$o == $b->$o){
			return 0;
		} else {
			if( $this->options['case_sensitive'] ){
				return ($a->$o < $b->$o ) ? -1 : 1;
			} else {
				return ( strtolower($a->$o) < strtolower($b->$o) ) ? -1 : 1; 
			}
		}
	}	


	/**
	 * Filter hook to sort the sites
	 *
	 * @param  object of the sites unsorted
	 * @return object of the sites sorted
	 */
	public function sort_sites($sites){

		if( $this->options['order_by'] == null ) return $sites;

		if( array_key_exists( $this->options['order_by'], $this->options['order_options'] ) ) { 

			if ( $this->options['primary_at_top'] ) {

				$primary = $sites[1];
				unset( $sites[1] );

			}

			uasort( $sites, array( $this, 'sorter' ) );

			if ( $this->options['primary_at_top'] ) {
				array_unshift( $sites, $primary );
			}

		}

		return $sites;
	}

}

if( is_multisite() ){

	add_action( 'plugins_loaded', array( 'sort_my_sites', 'get_instance' ) );

	if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

		require_once( plugin_dir_path( __FILE__ ) . 'admin/class-sort-my-sites-admin.php' );
		add_action( 'plugins_loaded', array( 'sort_my_sites_admin', 'get_instance' ) );

	}

}