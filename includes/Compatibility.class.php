<?php
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'rtbCompatibility' ) ) {
/**
 * Class to handle backwards compatibilty issues for Restaurant Reservations
 *
 * @since 1.3
 */
class rtbCompatibility {

	/**
	 * Set up hooks
	 */
	public function __construct() {

		// Preserve this defined constant in case anyone relied on it
		// to check if the plugin was active
		define( 'RTB_TEXTDOMAIN', 'rtbdomain' );

		// Load a .mo file for an old textdomain if one exists
		add_filter( 'load_textdomain_mofile', array( $this, 'load_old_textdomain' ), 10, 2 );

		// Run a filter deprecrated in 1.4.3
		add_filter( 'rtb_bookings_table_views_date_range', array( $this, 'rtn_bookings_table_views_schedule' ) );

	}

	/**
	 * Load a .mo file for an old textdomain if one exists
	 *
	 * In versions prior to 1.3, the textdomain did not match the plugin
	 * slug. This had to be changed to comply with upcoming changes to
	 * how translations are managed in the .org repo. This function
	 * checks to see if an old translation file exists and loads it if
	 * it does, so that people don't lose their translations.
	 *
	 * Old textdomain: rtbdomain
	 */
	public function load_old_textdomain( $mofile, $textdomain ) {

		if ( $textdomain === 'restaurant-reservations' && 0 === strpos( $mofile, WP_LANG_DIR . '/plugins/'  ) && !file_exists( $mofile ) ) {
			$mofile = dirname( $mofile ) . DIRECTORY_SEPARATOR . str_replace( $textdomain, 'rtbdomain', basename( $mofile ) );
		}

		return $mofile;
	}

	/**
	 * Run a filter on the admin bookings page display views that was
	 * deprecrated in v1.4.3
	 *
	 * @since 1.4.3
	 */
	public function rtn_bookings_table_views_schedule( $views ) {
		return apply_filters( 'rtn_bookings_table_views_schedule', $views );
	}

}
} // endif
