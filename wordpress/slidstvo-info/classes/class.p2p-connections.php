<?php
/**
 * P2P Connections
 *
 * @file
 * @package		Slidstvo info
 * @author		Andrew Skochelias
 */

defined( 'ABSPATH' ) || die();

/**
 * Class WBL_P2P_Connections.
 */
class WBL_P2P_Connections {

	private $connections = [
		[
			'from'	=> 'wbl_author',
			'to'	=> 'post',
		],
		[
			'from'	=> 'wbl_author',
			'to'	=> 'wbl_article',
		],
		[
			'from'	=> 'wbl_author',
			'to'	=> 'wbl_investigation',
		],
		[
			'from'	=> 'wbl_author',
			'to'	=> 'wbl_movie',
		],
	];

	/**
	 * Constructor
	 */
	function __construct() {

		// Register post type
		add_action( 'p2p_init', [ &$this, 'registerConnections' ] );
	}

	/**
	 * Register Connections
	 *
	 * @return void.
	 */
	public function registerConnections() {

		foreach ( $this->connections as $connection ) {

			// Register connection
			p2p_register_connection_type(
				[
					'name'			=> $connection['from'] . '-' . $connection['to'],
					'from'			=> $connection['from'],
					'to'			=> $connection['to'],
					'admin_box'		=> true,
				]
			);
		}
	}
}

new WBL_P2P_Connections();
