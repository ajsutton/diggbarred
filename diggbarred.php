<?php
/*
Plugin Name: Diggbarred
Author: Phil Nelson
Author URI: http://extrafuture.com/
Version: 1.5
Description: Blocks all traffic from Digg from viewing your content, replacing it with a message to users. Idea and DiggBar code taken entirely from http://daringfireball.net/2009/04/how_to_block_the_diggbar
Plugin URI: http://extrafuture.com/projects/diggbarred

*/

add_option("diggbarred_version", "1.5");
add_option("diggbarred_message", 'Usage of the diggbar <a href="http://daringfireball.net/2009/04/how_to_block_the_diggbar">harms the internet</a> and this site blocks all requests via the digg in protest.  To view this page please visit it directly.');
add_option("diggbarred_style","width: 30%; line-height: 17px; text-align: justify; margin: 20% auto 0 auto; font-family: verdana, sans-serif; font-size: 13px;");

add_action('init', 'diggbarred_do_the_shit');

function diggbarred_do_the_shit() 
{
	
	if(preg_match('#http://digg.com/\w{1,8}/*(\?.*)?$#', $_SERVER['HTTP_REFERER'])) 
	{
		header("HTTP/1.0 403 Digg bar is blocked in protest", true, 403);
		header("Vary: Referer");
	    echo '<div style="'.get_option('diggbarred_style').'"><p>' . get_option('diggbarred_message') . '</p></div>';
	    exit;
	} else {
		$script_url = trailingslashit( get_bloginfo('wpurl') ) . PLUGINDIR . '/' . dirname( plugin_basename(__FILE__) ) . "/diggbarred.js";
		wp_enqueue_script('diggbarred_script', $script_url);
	}
	
}

function diggbarred_settings()
{
	require_once('diggbarred-options.php');
}

function diggbarred_admin_panel()
{
	add_options_page('Diggbarred Options', 'Diggbarred', 8, 'diggbarred/diggbarred-options.php', 'diggbarred_settings');
}

add_action('admin_menu', 'diggbarred_admin_panel');

?>
