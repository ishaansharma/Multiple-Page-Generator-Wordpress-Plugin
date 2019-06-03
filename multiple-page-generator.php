<?php
/*
*Plugin Name: Multiple Page Generator
*Plugin URI: https://visualwebz.com
*Description: WordPress Multiple page generator 
*Version: 1.0
*Author: Ayat Rashidi, Sardor Botirov, Lewis Liu, Andre Eneliko
*Author URI: https://visualwebz.com
*License: GPLv2 2 or later
 */

//MPG stands for multiple page generator

defined('ABSPATH') or die('No script kiddies please!');

//path of the plugin
define('MY_PLUGIN_PATH', plugin_dir_path(__FILE__));

//adding menus to the admin menu
add_action('admin_menu', 'mpg_setup_menu');

//function that creates menus
function mpg_setup_menu()
{
    add_menu_page('Multiple Page Generator page', 'Multiple Page Generator', 'manage_options', 'mpg_plugin_menu', 'pageGenerator', '', 2);
    add_submenu_page('mpg_plugin_menu', 'Single Inserter Page', 'Pages Creator', 'manage_options', 'single-generator', 'single_create');
    add_submenu_page('mpg_plugin_menu', 'Upload xlsx Page', 'Excel Sheet Pages Creator', 'manage_options', 'xlsx-page-generator', 'xlsx_page_create');
    remove_submenu_page('mpg_plugin_menu', 'mpg_plugin_menu');
}

function check_Yoast() {

    if (('multiple-page-generator_page_single-generator' || 'multiple-page-generator_page_xlsx-page-generator') != $hook) {
        if (!is_plugin_active('wordpress-seo/wp-seo.php')) {
        }
    }
}
add_action( 'admin_init', 'check_Yoast' );

//main layout of the plugin
function pageGenerator()
{
    echo "<h1>Welcome to the home page of Plug-in</h1>";
}

//functions that displays error message to install Yoast plugin (if not installed or activated)
function mpg_show_message(){
    if (!is_plugin_active('wordpress-seo/wp-seo.php')) {
        if(!file_exists(ABSPATH . '/wp-content/plugins/wordpress-seo/wp-seo.php')){
            $url = wp_nonce_url(add_query_arg(array('action' => 'install-plugin','plugin' => 'wordpress-seo'),admin_url( 'update.php' )),'install-plugin_wordpress-seo');
        echo '<br>
            <div class="notice notice-info is-dismissible">
                <p>Please install and activate required plugin (Yoast) to get better SEO purposes. <a href="'.$url.'">Install Yoast</a></p>
            </div><br>';
            return false;
        }else {
            $url = wp_nonce_url(admin_url('plugins.php?action=activate&plugin=wordpress-seo/wp-seo.php'), 'activate-plugin_wordpress-seo/wp-seo.php');
            echo '<br>
                <div class="notice notice-info is-dismissible">
                    <p>Please activate required plugin (Yoast) to get better SEO purposes. <a href="'.$url.'">Activate Yoast</a></p>
                </div><br>';
                return false;
        }

    }
    return true;
}
//function that calls Page Creator Layout
function single_create()
{
    echo "<h1>Pages Creator</h1>";
    if(mpg_show_message()){
        include MY_PLUGIN_PATH . 'view/layout2.php';
    }
}

//function that calls Excel Sheet Page Creator Layout
function xlsx_page_create()
{
    echo "<h1>Excel Sheet Pages Creator</h1>";
    if(mpg_show_message()){
    include MY_PLUGIN_PATH . 'view/layout3.php';
    }
}

//adding all js scripts and styling to the header
function mpg_enqueue($hook)
{
    if (('multiple-page-generator_page_single-generator' || 'multiple-page-generator_page_xlsx-page-generator') != $hook) {
        return;
    }
    if ('multiple-page-generator_page_xlsx-page-generator' === $hook) {
        wp_enqueue_script('mpg_jquery_script', plugins_url('assets/js/library/jquery-3.4.1.min.js', __FILE__));
        wp_enqueue_script('mpg_xls_script', plugins_url('assets/js/library/xls.core.min.js', __FILE__));
        wp_enqueue_script('mpg_xlsx_script', plugins_url('assets/js/library/xlsx.core.min.js', __FILE__));
    }
    wp_enqueue_script('MPG_functions_script', plugins_url('assets/js/mpgFunctions.js', __FILE__));
    wp_enqueue_style('my-my_custom_script', plugins_url('assets/css/styles.css', __FILE__));
}
//adding mpg_enqueue to the admin page
add_action('admin_enqueue_scripts', 'mpg_enqueue');
