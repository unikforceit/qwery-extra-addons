<?php

if (!defined('ABSPATH')) {
    exit;
}
if (class_exists('ELEMENTOR')){
    return;
}
if (!class_exists('Qwey_Extra_Addon')) :

    /**
     * Main Qwey_Extra_AddonElement_Elementor_Addons Class
     *
     */
    final class Qwey_Extra_Addon {

        private static $instance;

        /**
         * Main Qwey_Extra_AddonElement_Elementor_Addons Instance
         *
         * Insures that only one instance of Qwey_Extra_AddonElement_Elementor_Addons exists in memory at any one
         * time. Also prevents needing to define globals all over the place.
         */
        public static function instance() {

            if (!isset(self::$instance) && !(self::$instance instanceof Qwey_Extra_Addon)) {

                self::$instance = new Qwey_Extra_Addon;

                self::$instance->includes();

                self::$instance->register_frontend_styles();

                self::$instance->hooks();

            }
            return self::$instance;
        }

        /**
         * Include required files
         *
         */
        private function includes() {

            require_once QWERY_PLUG_DIR . '/includes/helper-functions.php';

        }

        /**
         * Setup the default hooks and actions
         */
        private function hooks() {
            add_action('elementor/widgets/widgets_registered', array($this, 'include_widgets'));
        }
        
        public function include_widgets() {
            include_once QWERY_PLUG_DIR . '/includes/widgets/team/index.php';

        }

        public function register_frontend_styles() {
            function qwery_extra_addon_styles(){
                wp_enqueue_style( 'qwery-extra-addon', QWERY_PLUG_URL . 'assets/css/qwery.css');
            }
            add_action('wp_enqueue_scripts', 'qwery_extra_addon_styles', 9999);
        }


    }

endif; 
    
function Qwey_Extra_Addon() {
    return Qwey_Extra_Addon::instance();
}
Qwey_Extra_Addon();