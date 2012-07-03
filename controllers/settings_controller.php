<?php

namespace RssNewsWidgets
{
  class SettingsController extends \WpMvc\BaseController
  {
    public function index()
    {
      global $current_site;
      global $site;
      global $areas;
      global $content;

      $site = \WpMvc\Site::find( $current_site->id );

      if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
        if ( isset( $_POST['site']['sitemeta']['rss_news_widgets'] ) && trim( $_POST['site']['sitemeta']['rss_news_widgets']['meta_value'] ) != '' ) {
          $websafe_name = 'rss_news_widgets_';
          $websafe_name .= \WpMvc\ApplicationHelper::unique_identifier( $_POST['site']['sitemeta']['rss_news_widgets']['meta_value'] );

          $site->sitemeta->{$websafe_name} = \WpMvc\SiteMeta::virgin();
          $site->sitemeta->{$websafe_name}->site_id = $site->id;
          $site->sitemeta->{$websafe_name}->meta_key = $websafe_name;
          $site->sitemeta->{$websafe_name}->meta_value = $_POST['site']['sitemeta']['rss_news_widgets']['meta_value'];

          $site->sitemeta->{$websafe_name . '_rss_link'} = \WpMvc\SiteMeta::virgin();
          $site->sitemeta->{$websafe_name . '_rss_link'}->site_id = $site->id;
          $site->sitemeta->{$websafe_name . '_rss_link'}->meta_key = $websafe_name . '_rss_link';
          $site->sitemeta->{$websafe_name . '_rss_link'}->meta_value = $_POST['site']['sitemeta']['rss_news_widgets_rss_link']['meta_value'];
        }
        unset( $_POST['site']['sitemeta']['rss_news_widgets'] );
        unset( $_POST['site']['sitemeta']['rss_news_widgets_rss_link'] );

        $site->takes_post( $_POST['site'] );

        $site->save();
        static::redirect_to( "{$_SERVER['REQUEST_URI']}&rss_news_widgets_updated=1" );
      }

      $areas = array();

      $this->get_areas_from_sitemeta( $areas, $site );

      $content = array();

      $this->make_form_content_from_areas( $content, $areas, $site );

      $this->make_form_content_from_new_area( $content, $site );

      $this->render( $this, "index" );
    }

    private function get_areas_from_sitemeta( &$areas, $site )
    {
      $sitemeta_vars = get_object_vars( $site->sitemeta );

      foreach ( $sitemeta_vars as $key => $value ) {
        if ( preg_match( '/^((?!.*_rss_link)rss_news_widgets.*)$/', $key ) )
          array_push( $areas, $site->sitemeta->{$key} );
      }
    }
    private function make_form_content_from_areas( &$content, $areas, $site )
    {
      foreach ( $areas as $area ) {
        $content[] = array(
          'title' => __( 'Name' ),
          'name' => $site->sitemeta->{$area->meta_key}->meta_key,
          'type' => 'text',
          'object' => $site->sitemeta->{$area->meta_key},
          'default_value' => $site->sitemeta->{$area->meta_key}->meta_value,
          'key' => 'meta_value'
        );

        $content[] = array(
          'title' => __( 'Rss Link' ),
          'name' => $site->sitemeta->{$area->meta_key . '_rss_link'}->meta_key,
          'type' => 'text',
          'object' => $site->sitemeta->{$area->meta_key . '_rss_link'},
          'default_value' => $site->sitemeta->{$area->meta_key . '_rss_link'}->meta_value,
          'key' => 'meta_value'
        );

        $content[] = array(
          'title' => __( 'Delete' ),
          'type' => 'delete_action',
          'delete_objects' => array(
            $site->sitemeta->{$area->meta_key}->meta_key,
            $site->sitemeta->{$area->meta_key . '_rss_link'}->meta_key
            ),
          'object' => $site->sitemeta->{$area->meta_key}
        );

        $content[] = array( 'type' => 'spacer' );
      }
    }

    private function make_form_content_from_new_area( &$content, &$site )
    {
      $site->sitemeta->rss_news_widgets = \WpMvc\SiteMeta::virgin();
      $site->sitemeta->rss_news_widgets->site_id = $site->id;
      $site->sitemeta->rss_news_widgets->meta_key = 'rss_news_widgets';
      $site->sitemeta->rss_news_widgets->meta_value = '';

      $site->sitemeta->rss_news_widgets_rss_link = \WpMvc\SiteMeta::virgin();
      $site->sitemeta->rss_news_widgets_rss_link->site_id = $site->id;
      $site->sitemeta->rss_news_widgets_rss_link->meta_key = 'rss_news_widgets_rss_link';
      $site->sitemeta->rss_news_widgets_rss_link->meta_value = '';

      $content[] = array(
        'title' => __( 'Name' ),
        'name' => $site->sitemeta->rss_news_widgets->meta_key,
        'type' => 'text',
        'object' => $site->sitemeta->rss_news_widgets,
        'default_value' => $site->sitemeta->rss_news_widgets->meta_value,
        'key' => 'meta_value'
      );

      $content[] = array(
        'title' => __( 'Link' ),
        'name' => $site->sitemeta->rss_news_widgets_rss_link->meta_key,
        'type' => 'text',
        'object' => $site->sitemeta->rss_news_widgets_rss_link,
        'default_value' => $site->sitemeta->rss_news_widgets_rss_link->meta_value,
        'key' => 'meta_value'
      );
    }
  }
}
