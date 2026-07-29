<?php
/**
 * Plugin Name:       QHTA Theme Extras
 * Description:       Presentation and theme-layer customisations for qhta.com.au. Replaces Astra Pro features and holds sitewide display tweaks. Contains no business logic.
 * Version:           1.0.1
 * Author:            QHTA
 * License:           GPL-2.0-or-later
 * Requires at least: 6.0
 * Requires PHP:      7.4
 *
 * Scope rule: if it would survive the conference ending, it belongs here.
 * If it is conference domain logic, it belongs in the conference program plugin.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'QHTA_TX_VERSION', '1.0.1' );
define( 'QHTA_TX_PATH', plugin_dir_path( __FILE__ ) );
define( 'QHTA_TX_URL', plugin_dir_url( __FILE__ ) );

/**
 * Front-end stylesheet.
 *
 * Depends on Astra's main stylesheet so our rules win on equal specificity
 * without needing !important.
 */
function qhta_tx_enqueue_styles() {
	wp_enqueue_style(
		'qhta-theme-extras',
		QHTA_TX_URL . 'css/theme-extras.css',
		array( 'astra-theme-css' ),
		QHTA_TX_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'qhta_tx_enqueue_styles', 20 );

/**
 * Block editor stylesheet, so the editor canvas matches the front end.
 *
 * add_editor_style() is not usable here: it resolves relative paths against the
 * theme directory, and an absolute URL makes WordPress fetch the file over HTTP
 * on every editor load. enqueue_block_assets is enqueued inside the iframed
 * editor canvas, which is where these rules have to land.
 *
 * Separate handle with no dependencies — astra-theme-css is not registered in
 * the editor context, and WordPress silently drops an enqueue whose dependency
 * is missing.
 */
function qhta_tx_enqueue_editor_styles() {
	if ( ! is_admin() ) {
		return;
	}

	wp_enqueue_style(
		'qhta-theme-extras-editor',
		QHTA_TX_URL . 'css/theme-extras.css',
		array(),
		QHTA_TX_VERSION
	);
}
add_action( 'enqueue_block_assets', 'qhta_tx_enqueue_editor_styles' );
