<?php
/*
  Plugin Name: Stilus
  Description: The plugin Stilus for WordPress enables you to get a check report of your contents in Spanish before publishing them in your WordPress website.
  Version: 1.0.1
  Author: Stilus
  Author URI: http://www.mystilus.com/
  License: GPLv2
  Text Domain: Stilus
  Domain Path: /lang
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if(defined('STILUS_URL')) return;

//get actual locale ilang:
$ilang = substr(get_locale(), 0, 2);
if(!in_array($ilang, array('es','en'))){
  $ilang = 'es';
}

define( 'STILUS_URL', plugin_dir_url( __FILE__ ) );
define( 'STILUS_DIR', plugin_dir_path( __FILE__ ) );
define( 'STILUS_PLUGIN_FILE', plugin_basename( __FILE__ ) );
define( 'STILUS_IMG', STILUS_URL.'img/' );
define( 'STILUS_URLTOPOST', "https://www.mystilus.com/api/stilus" );
define( 'STILUS_URLTOCONF', "https://www.mystilus.com/Opciones_de_revision");

require_once STILUS_DIR . '/inc/stilusSettings.class.php';
require_once STILUS_DIR . '/inc/stilusEncoder.class.php';
require_once STILUS_DIR . '/inc/stilus.class.php';

$Stilus = new Stilus;
