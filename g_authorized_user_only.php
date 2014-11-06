<?php
/**
 * Plugin Name: G-Authorzed User Only
 * Plugin URI: github.com/gafreax/wp-g-authorized-user-only
 * Description: Really simple plugin for allow only auth user to be logged in
 * Version: 1.0
 * Author: gabriele fontana <gafreax@gmail.com>
 * Author URI: gafreax.wordpress.org
 * License: GPLv2
 */
defined('ABSPATH') or die("No script kiddies please!");
include __DIR__ .'/options.php';
function g_wp_aup_check_logged_in() {
    $url=get_option('g_authorized_user_only_redirect_url');
    $valid = filter_var($url,FILTER_VALIDATE_URL);
    $base = basename($_SERVER['REQUEST_URI'].'.php');
    if($valid === FALSE)$url =get_site_url() . '/wp-login.php'; 
    
   if(!is_user_logged_in() && strpos($base,'wp-login') === false) header('Location: ' . $url);
}
add_action('init','g_wp_aup_check_logged_in');


