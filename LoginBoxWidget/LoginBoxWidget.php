<?php
/*
Plugin Name: LoginBox Widget
Description: This plugin adds a widget with a login button that once pressed, shows a login form in the widget area for the guests. The authenticated users do not see the form.
Version: 1.0
Author: GeoSn0w (@FCE365)
Author URI: https://twitter.com/FCE365
License: GPL2
Text Domain: geosn0w_LoginBoxWidget_lbw
*/
add_action('plugins_loaded', 'geosn0w_load_textdomain');

function geosn0w_load_textdomain()
{
	load_plugin_textdomain('geosn0w_LoginBoxWidget_lbw');
}

class geosn0w_LoginBoxWidget extends WP_Widget
{
	public function __construct()
	{
		parent::__construct('geosn0w_LoginBoxWidget', esc_html__('LoginBox Widget', 'geosn0w_LoginBoxWidget_lbw'));
	}

	public function widget($args, $instance)
	{
		extract($args);
		echo $args['before_widget'];
		if (!empty($title)) echo $args['before_title'] . $title . $args['after_title'];
		//Added in case some themes don't add it by default since the plugin uses FA icons.
		echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">';
		if (is_user_logged_in()) {
			global $current_user;
			get_currentuserinfo();
			// Probably not the best way to do this but this is literally my first ever Wordpress Widget / Plugin so feel free to point to my horrible mistakes :P
			echo '<center> Hello, ' . $current_user->user_login . '</center>';
			echo '<style> .extra button { margin: 0; padding: 0; border: inherit; background: #3093de; color: #fff; text-decoration: none; font-size: 17px; font-size: 1.0625rem; transition: all 0.2s ease; width: 100%; min-height: 49px; } </style> <div class ="extra" align="center"> <button onclick="getToChannel()"><i class="fa fa-user"></i> Your Profile</button> </div> <script> function getToChannel() { window.location.href = "/wp-admin/profile.php"; } </script>';
		}
		else {
			echo '<style> .extra button { margin: 0; padding: 0; border: inherit; background: #3093de; color: #fff; text-decoration: none; font-size: 17px; font-size: 1.0625rem; transition: all 0.2s ease; width: 100%; min-height: 49px; } </style><div class="extra" id="loginButton"> <center> Have an account? </center> <button onclick="showForm()"><i class="fa fa-key"></i> Authenticate</button></div><div id="loginForm"><center>';

			echo '<style> #loginform { text-align: left; } #remME { text-align: center; } .extra input[type="text"], input[type="email"], input[type="url"], input[type="password"], input[type="search"], textarea { width: 100%; } .extra input[type="submit"] { margin: 0; padding: 0; border: inherit; background: #3093de; color: #fff; text-decoration: none; font-size: 17px; font-size: 1.0625rem; transition: all 0.2s ease; width: 100%; min-height: 49px; } </style> <form name="loginform" id="loginform" action="/wp-login.php" method="post"> <div class="extra"> <p class="login-username"> <label for="user_login">Username</label> <input type="text" name="log" id="user_login" class="input" value="" size="20"> </p> <p class="login-password"> <label for="user_pass">Password</label> <input type="password" name="pwd" id="user_pass" class="input" value="" size="20"> </p> </div> <div id="remME"> <p class="login-remember"><label><input name="rememberme" type="checkbox" id="rememberme" value="forever"> Remember Me</label></p> </div> <p class="login-submit"> <div class="extra" style="border:none"><input type="submit" name="wp-submit" id="wp-submit" class="button button-primary" value= "Authenticate"</div> <input type="hidden" name="redirect_to" value="/"> </p> </form>';
			echo '</center></div><script> function showForm() {var y = document.getElementById("loginButton");var x = document.getElementById("loginForm");y.style.display = "none";x.style.display = "block";}</script>';
		}

		echo $args['after_widget'];
	}
}

function lbw_geosn0w_regWid()
{
	register_widget('geosn0w_LoginBoxWidget');
}

add_action('widgets_init', 'lbw_geosn0w_regWid');
