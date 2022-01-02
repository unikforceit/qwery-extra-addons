<?php
/*
Plugin Name: Qwery Extra Addon
Plugin URI: https://unikforce.com/
Description: Team Layout Addons and many more.
Author: UnikForce IT
Author URI: https://unikforce.com/
Version: 1.0.0
*/

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'QWERY_VERSION', '1.0.0' );
define( 'QWERY_PLUG_DIR', dirname(__FILE__).'/' );
define('QWERY_PLUG_URL', plugin_dir_url(__FILE__));

function qwery_extra_addons() {
    if( ! class_exists( 'Qwery_Extra_Addons' ) ) {
        require_once QWERY_PLUG_DIR .'/includes/index.php';
    }
}
add_action( 'plugins_loaded', 'qwery_extra_addons' );