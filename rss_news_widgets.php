<?php
/*
Plugin Name: RSS News Widgets
Plugin URI: https://github.com/mittmedia/rss_news_widgets
Description:
Version: 1.0.0
Author: Fredrik Sundström
Author URI: https://github.com/fredriksundstrom
License: MIT
*/

/*
Copyright (c) 2012 Fredrik Sundström

Permission is hereby granted, free of charge, to any person
obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without
restriction, including without limitation the rights to use,
copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following
conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.
*/

require_once( 'wp_mvc/init.php' );

$rss_news_widgets_app = new \WpMvc\Application();

$rss_news_widgets_app->init( 'RssNewsWidgets', WP_PLUGIN_DIR . '/rss_news_widgets' );

// WP: Add pages
add_action( 'network_admin_menu', 'rss_news_widgets_add_pages' );
function rss_news_widgets_add_pages()
{
  add_submenu_page( 'settings.php', 'Rss News Widget Settings', 'Rss News Widget', 'Super Admin', 'rss_news_widgets_settings', 'rss_news_widgets_settings_page');
}

function rss_news_widgets_settings_page()
{
  global $rss_news_widgets_app;

  $rss_news_widgets_app->settings_controller->index();
}

add_action( 'admin_enqueue_scripts', 'rss_news_widgets_add_styles' );
function rss_news_widgets_add_styles() {
  wp_enqueue_style( 'rss_news_widgets_style_settings', WP_PLUGIN_URL . '/rss_news_widgets/assets/build/stylesheets/settings.css' );
  wp_enqueue_script( 'rss_news_widgets_script_settings', WP_PLUGIN_URL . '/rss_news_widgets/assets/build/javascripts/settings.js' );
}

if ( isset( $_GET['rss_news_widgets_updated'] ) ) {
  add_action( 'network_admin_notices', 'rss_news_widgets_updated_notice' );
}

function rss_news_widgets_updated_notice()
{
  $html = \WpMvc\ViewHelper::admin_notice( __( 'Settings saved.' ) );

  echo $html;
}
