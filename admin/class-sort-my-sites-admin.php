<?php

class Sort_My_Sites_Admin {
	protected static $instance = null;
	protected $plugin = null;
	protected $options = null;

	private function __construct() {

		$this->plugin = sort_my_sites::get_instance();
		$this->version = sort_my_sites::VERSION;
		$this->plugin_slug = $this->plugin->get_plugin_slug();
		$this->options = $this->plugin->get_options();


		add_action( 'wpmu_options', array( $this, 'add_network_options' ) );
		add_action( 'update_wpmu_options', array( $this, 'save_network_settings' ) );

		add_filter( 'screen_settings', array( $this, 'show_screen_options' ), 10, 2 );
		add_filter( 'set_screen_option_sort_my_sites_options',  array( $this, 'set_screen_options' ), 11, 3 );

	}

	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}
	

	function set_screen_options($status, $option, $value) {
		if ( 'sort_my_sites_options' == $option ) { 
			$blank = array(
				'order_by' => ''
			);
			if( $blank !== $_POST['sort-my-sites_options']  ){
				$value = $_POST['sort-my-sites_options'];
			}
		}
		return $value;
	}	

	function show_screen_options( $status, $args ) {

		$return = $status;

			if ( $args->base == 'my-sites' ) {

				$button = get_submit_button( __( 'Apply' ), 'button', 'screen-options-apply', false );

				$return .= '
					<fieldset>
						<legend>Sort Options</legend>
						<div class="metabox-prefs">
							<div><input type="hidden" name="wp_screen_options[option]" value="' .  $this->plugin_slug . '_options" /></div>
							<div><input type="hidden" name="wp_screen_options[value]" value="yes" /></div>
							<div class="custom_fields">
								<label for="order_by">Order by</label>
								<select name="' .  $this->plugin_slug . '_options[order_by]" id="order_by">';

									foreach( $this->options['order_options'] as $option => $title){ 
										$return .= '<option value="' . $option .'" '. selected( $this->options['order_by'], $option, false ) .' >'. $title .'</option>';
									}

								$return .='</select>
								<label for="direction">Direction</label>
								<select name="'. $this->plugin_slug . '_options[direction]" id="direction">
									<option value="asc"  '. selected( $this->options['direction'], 'asc', false )  .' >Ascending</option>
									<option value="desc"  '. selected( $this->options['direction'], 'desc', false )  .' >Descending</option>
								</select>								
								<label for="case_sensitive"><input type="checkbox" value="1" name="' . $this->plugin_slug . '_options[case_sensitive]" id="case_sensitive" ' . checked( true, $this->options['case_sensitive' ], false ) . ' /> Case sensitive</label>
								<label for="primary_at_top"><input type="checkbox" value="1" name="' . $this->plugin_slug . '_options[primary_at_top]" id="primary_at_top" ' . checked( true, $this->options['primary_at_top' ], false ) . ' /> Always show the primary site first</label>
							</div>
						</div>
					</fieldset>
					<br class="clear">'. 
					$button;
			}

		return $return;
	}

	function save_network_settings(){
		$options = array(
			"order_by" => wp_unslash( $_POST[ $this->plugin_slug . "_order_by" ] ),
			"case_sensitive" => ( isset( $_POST[ $this->plugin_slug . "_case_sensitive" ] ) )? wp_unslash( $_POST[ $this->plugin_slug . "_case_sensitive" ] ): false,
			"primary_at_top" => ( isset( $_POST[ $this->plugin_slug . "_primary_at_top" ] ) )? wp_unslash( $_POST[ $this->plugin_slug . "_primary_at_top" ] ): false,
			"direction" => ( isset( $_POST[ $this->plugin_slug . "_direction" ] ) )? wp_unslash( $_POST[ $this->plugin_slug . "_direction" ] ): false,
		);
		update_site_option( $this->plugin_slug, $options );
	}
	 
	function add_network_options(){
		include( 'views/settings-network.php' );
	}
}
