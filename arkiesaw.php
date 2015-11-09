<?php
/*
   Plugin Name: ArkieSaw
   Plugin URI: http://wordpress.org/extend/plugins/arkiesaw/
   Version: 0.1
   Author: <a href="http://routerchowder.com">Luke Patrick</a>
   Description: Lets users add locations defined to specific regions within a clickable map of Arkansas
   Text Domain: arkiesaw
   License: GPLv3
  */

/*
    "WordPress Plugin Template" Copyright (C) 2015 Michael Simpson  (email : michael.d.simpson@gmail.com)

    This following part of this file is part of WordPress Plugin Template for WordPress.

    WordPress Plugin Template is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    WordPress Plugin Template is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Contact Form to Database Extension.
    If not, see http://www.gnu.org/licenses/gpl-3.0.html
*/

$Arkiesaw_minimalRequiredPhpVersion = '5.0';

/**
 * Check the PHP version and give a useful error message if the user's version is less than the required version
 * @return boolean true if version check passed. If false, triggers an error which WP will handle, by displaying
 * an error message on the Admin page
 */
function Arkiesaw_noticePhpVersionWrong() {
    global $Arkiesaw_minimalRequiredPhpVersion;
    echo '<div class="updated fade">' .
      __('Error: plugin "ArkieSaw" requires a newer version of PHP to be running.',  'arkiesaw').
            '<br/>' . __('Minimal version of PHP required: ', 'arkiesaw') . '<strong>' . $Arkiesaw_minimalRequiredPhpVersion . '</strong>' .
            '<br/>' . __('Your server\'s PHP version: ', 'arkiesaw') . '<strong>' . phpversion() . '</strong>' .
         '</div>';
}


function Arkiesaw_PhpVersionCheck() {
    global $Arkiesaw_minimalRequiredPhpVersion;
    if (version_compare(phpversion(), $Arkiesaw_minimalRequiredPhpVersion) < 0) {
        add_action('admin_notices', 'Arkiesaw_noticePhpVersionWrong');
        return false;
    }
    return true;
}



//////////////////////////////////
// Run initialization
/////////////////////////////////

// Initialize i18n
add_action('plugins_loadedi','Arkiesaw_i18n_init');

// Run the version check.
// If it is successful, continue with initialization for this plugin
if (Arkiesaw_PhpVersionCheck()) {
    // Only load and run the init function if we know PHP version can parse it
    include_once('arkiesaw_init.php');
    Arkiesaw_init(__FILE__);
}

  //////////////////////////////
 // Let's get the template  //
/////////////////////////////

/* Add custom landing page template
------------------------
class templaterCore {
        protected $plugin_slug;
        private static $instance;
        protected $templates;
        public static function get_instance() {
                if( null == self::$instance ) {
                        self::$instance = new templaterCore();
                } 
                return self::$instance;
        } 
        private function __construct() {
                $this->templates = array();
                add_filter(
                                        'page_attributes_dropdown_pages_args',
                                         array( $this, 'register_project_templates' ) 
                                );
                add_filter(
                                        'wp_insert_post_data', 
                                        array( $this, 'register_project_templates' ) 
                                );
                add_filter(
                                        'template_include', 
                                        array( $this, 'view_project_template') 
                                );
                $this->templates = array(
                        'members-page.php'     => 'Member Map Page',
                );                      
        } 
        public function register_project_templates( $atts ) {
                $cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );
                $templates = wp_get_theme()->get_page_templates();
                        if ( empty( $templates ) ) {
                                $templates = array();
                } 
                wp_cache_delete( $cache_key , 'themes');
                $templates = array_merge( $templates, $this->templates );
                wp_cache_add( $cache_key, $templates, 'themes', 1800 );
                return $atts;
        } 
        public function view_project_template( $template ) {
                global $post;
                if (!isset($this->templates[get_post_meta( 
                                        $post->ID, '_wp_page_template', true 
                                )] ) ) {        
                        return $template;       
                } 
                $file = plugin_dir_path(__FILE__). get_post_meta( 
                                        $post->ID, '_wp_page_template', true 
                                );
                if( file_exists( $file ) ) {
                        return $file;
                } 
                                else { echo $file; }
                return $template;
        } 
} 
add_action( 'plugins_loaded', array( 'templaterCore', 'get_instance' ) );

------------- */

/////////////////////////////
// Load our custom elements
////////////////////////////

include_once('arkiesaw_custom.php');

  ////////////////////////////////
 //// Load our custom sheets ///
//////////////////////////////

function arkie_scripts() 
{
    
    //Register all our shcripts
    wp_register_style( 'member', plugins_url( '/css/member.css', __FILE__ ) );
    wp_register_script( 'raphael', plugins_url('/js/raphael.min.js', __FILE__ ), array('jquery'), '', true );
    wp_register_script( 'map', plugins_url('/js/map.js', __FILE__ ), array('jquery'), '', true );
    wp_register_script( 'map', plugins_url('/js/members.js', __FILE__ ), array('jquery'), '', true );
    
    //Equeue said shcripts
    wp_enqueue_style('member');
    wp_enqueue_script('raphael');
    wp_enqueue_script('map');
    wp_enqueue_script('members');
}

add_action('wp_enqueue_scripts', 'arkie_scripts');
