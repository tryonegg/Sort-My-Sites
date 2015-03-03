<?php

class sort_my_sites_admin {
	protected static $instance = null;
	protected $plugin = null;
	protected $options = null;

	private function __construct() {

		$this->plugin = sort_my_sites::get_instance();
		$this->version = sort_my_sites::VERSION;
		$this->plugin_slug = $this->plugin->get_plugin_slug();
		$this->options = $this->plugin->get_options();

		add_action( 'admin_init', array( $this, 'setup' ) );

	}

	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}


	public function setup(){

		add_action( 'wpmu_options', array( $this, 'add_network_options' ) );
		add_action( 'update_wpmu_options', array( $this, 'save_network_settings' ) );

	}

	function save_network_settings(){
		$value = wp_unslash( $_POST[ $this->plugin_slug . "_order_by" ] );
		update_site_option( $this->plugin_slug . "_order_by", $value );

		$value = ( isset( $_POST[ $this->plugin_slug . "_case_sensitive" ] ) )? wp_unslash( $_POST[ $this->plugin_slug . "_case_sensitive" ] ): false;
		update_site_option( $this->plugin_slug . "_case_sensitive", $value );

		$value = ( isset( $_POST[ $this->plugin_slug . "_primary_at_top" ] ) )? wp_unslash( $_POST[ $this->plugin_slug . "_primary_at_top" ] ): false;
		update_site_option( $this->plugin_slug . "_primary_at_top", $value );
	}
	 
	function add_network_options(){
		include( 'views/settings-network.php' );
	}
}