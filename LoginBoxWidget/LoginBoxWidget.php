<?php
/*
Plugin Name: LoginBox Widget
Description: This plugin adds a widget with a login button that once pressed, shows a login form in the widget area for the guests. The authenticated users do not see the form.
Version: 1.2
Author: GeoSn0w (@FCE365)
Author URI: https://twitter.com/FCE365
License: GPL2
Text Domain: geosn0w_LoginBoxWidget_lbw
*/

add_action('plugins_loaded', 'geosn0w_load_textdomain');

function geosn0w_load_textdomain() {
    load_plugin_textdomain('geosn0w_LoginBoxWidget_lbw');
}

class GeoSn0w_LoginBoxWidget extends WP_Widget {
    public function __construct() {
        parent::__construct('geosn0w_LoginBoxWidget', esc_html__('LoginBox Widget', 'geosn0w_LoginBoxWidget_lbw'));
    }

    public function widget($args, $instance) {
        extract($args);
        echo $before_widget;
        $title = apply_filters('widget_title', $instance['title']);
        
        if (!empty($title)) {
            echo $before_title . $title . $after_title;
        }
        
        if (is_user_logged_in()) {
            $current_user = wp_get_current_user();
            echo '<center>' . esc_html__('Hello, ', 'geosn0w_LoginBoxWidget_lbw') . esc_html($current_user->user_login) . '</center>';
            echo '<div class="extra" align="center">
                  <button id="profileButton"><i class="fa fa-user"></i> ' . esc_html__('Your Profile', 'geosn0w_LoginBoxWidget_lbw') . '</button>
                  </div>
                  <script>
                  document.getElementById("profileButton").addEventListener("click", function() {
                    window.location.href = "' . esc_url(admin_url('profile.php')) . '";
                  });
                  </script>';
        } else {
            $this->showLoginForm();
        }

        echo $after_widget;
    }

    private function showLoginForm() {
        echo '<div class="extra" id="loginButton">
                <center>' . esc_html__('Have an account?', 'geosn0w_LoginBoxWidget_lbw') . '</center>
                <button id="authenticateButton"><i class="fa fa-key"></i> ' . esc_html__('Authenticate', 'geosn0w_LoginBoxWidget_lbw') . '</button>
              </div>
              <div id="loginForm">
                <center>
                  <form id="loginform" action="' . esc_url(wp_login_url()) . '" method="post">
                    <div class="extra">
                      <p class="login-username">
                        <label for="user_login">' . esc_html__('Username', 'geosn0w_LoginBoxWidget_lbw') . '</label>
                        <input type="text" name="log" id="user_login" class="input" value="" size="20">
                      </p>
                      <p class="login-password">
                        <label for="user_pass">' . esc_html__('Password', 'geosn0w_LoginBoxWidget_lbw') . '</label>
                        <input type="password" name="pwd" id="user_pass" class="input" value="" size="20">
                      </p>
                    </div>
                    <div id="remME">
                      <p class="login-remember">
                        <label>
                          <input name="rememberme" type="checkbox" id="rememberme" value="forever"> ' . esc_html__('Remember Me', 'geosn0w_LoginBoxWidget_lbw') . '
                        </label>
                      </p>
                    </div>
                    <p class="login-submit">
                      <div class="extra" style="border:none">
                        <input type="submit" name="wp-submit" id="wp-submit" class="button button-primary" value="' . esc_attr__('Authenticate', 'geosn0w_LoginBoxWidget_lbw') . '">
                      </div>
                      <input type="hidden" name="redirect_to" value="' . esc_url(home_url('/')) . '">
                    </p>
                  </form>
                </center>
              </div>
              <script>
                document.getElementById("authenticateButton").addEventListener("click", function() {
                  document.getElementById("loginButton").style.display = "none";
                  document.getElementById("loginForm").style.display = "block";
                });
              </script>';
    }
}

function lbw_geosn0w_regWid() {
    register_widget('GeoSn0w_LoginBoxWidget');
}

add_action('widgets_init', 'lbw_geosn0w_regWid');
