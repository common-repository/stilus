<?php
/*
  stilusSettings.class.php
  Implements the settings of the plugin.
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if(!class_exists('StilusSettings')){
  /**
   * Class Settings
   * Implements the settings section of the plugin
   */
  class StilusSettings {

    /**
     * Constructor
     */
    public function __construct() {
      // register actions
      add_action('admin_init', array(&$this, 'admin_init'));  //register settings
      add_action('admin_menu', array(&$this, 'add_menu'));    //add the menu
    } // __construct

      /**
       * hook into WP's admin_init action hook
       * Describe the settings of the plugin
       */
    public function admin_init() {
      /** Avaible Models and Languages **/

      // register the plugin's settings
      register_setting('st_settings-group', 'st_mystilusU');                                                     // User of www.mystilus.com
      register_setting('st_settings-group', 'st_encodedP', array(&$this, 'post_process_input_password'));   // Password for the user on www.mystilus.com

      // add the settings section
      add_settings_section('st_settings_general-section',
                           __('Stilus plugin general configuration','Stilus'),
                           array(&$this, 'settings_section_wp_plugin_general'),
                           'st_settings'
                           );

      // User
      add_settings_field('st_settings-st_mystilusU',
                         __('User','Stilus'),
                         array(&$this, 'settings_field_input_text'),
                         'st_settings',
                         'st_settings_general-section',
                         array(
                               'field' => 'st_mystilusU'
                               )
                         );

      // Password
      add_settings_field('st_settings-st_encodedP',
                         __('Password','Stilus'),
                         array(&$this, 'settings_field_input_password'),
                         'st_settings',
                         'st_settings_general-section',
                         array(
                              'field' => 'st_encodedP'
                              )
                         );

    } //activate


    /*
     * Print the help text for the section general
     */
    public function settings_section_wp_plugin_general() {
      $uppc = StilusEncoder::encodeUPPC(get_option('st_mystilusU'), get_option('st_encodedP'));
      $mystilusEditOptionsLink = STILUS_URLTOCONF;
      echo '<div>';
      _e('Insert the same username and password you used to register in','Stilus');
      echo ' <a href=https://www.mystilus.com >Stilus</a>.</div>';
      echo '<div>';
      _e('You can','Stilus');
      echo ' <a target="_blank" href="'.$mystilusEditOptionsLink.'" >';
      _e('configure','Stilus');
      echo '</a> ';
      _e('your proofreading options from your account in mystilus.com.', 'Stilus');
      echo '</div>';
    }

    /*
    * functions for echo each type of setting
    */
    public function settings_field_input_text($args) {
      $field = $args['field'];
      $value = get_option($field,'');
      // echo a proper input type="text"
      echo sprintf('<input type="text" name="%s" id="%s" value="%s" />', $field, $field, $value);
    } //settings_field_input_text($args)

    public function settings_field_input_password($args) {
      $field = $args['field'];
      $value = get_option($field,'');
      // echo a proper input type="password"
      echo sprintf('<input type="password" name="%s" id="%s" value="%s" />', $field, $field, $value);
    } //settings_field_input_password($args)

    public function post_process_input_password($password){
      return StilusEncoder::encodeP($password);
    } //post_process_input_password($password)


   /**
    * Add a menu
    */
    public function add_menu() {
      // Add a page to manage this plugin's settings
      $hook_suffix = add_options_page(__('Stilus Plugin Settings','Stilus'),
                                      'Stilus',
                                      'manage_options',
                                      'st_settings',
                                      array(&$this, 'plugin_settings_page')
                                      );

    } //add_menu()


   /**
    * Menu Callback
    */
    public function plugin_settings_page() {
      if(!current_user_can('manage_options')) {
        wp_die(__('Error Ocurred: You need admin permissions to access this page..','Stilus'));
      }

      //otions header
      echo '<div class="wrap">';
      $src = STILUS_IMG."LogoStilus.png";
      echo "<img src='$src' \>";

      //tabs
      if ( isset ( $_GET['tab'] ))
        $this->tabs($_GET['tab']);
      else
        $this->tabs('general');

      // Render the settings template
      include_once(STILUS_DIR."/inc/templates/settings.php");
    } // plugin_settings_page()


   /*
    * Print tabs
    */
    public function tabs($current = 'general') {
      $tab1= __('General Settings','Stilus');

      $tabs = array('general' => $tab1);

      echo '<div id="icon-themes" class="icon32"><br></div>';
      echo '<h2 class="nav-tab-wrapper">';
      foreach($tabs as $tab => $name){
        $class = ($tab == $current) ? ' nav-tab-active' : '';
        echo "<a class='nav-tab$class' href='?page=st_settings&amp;tab=$tab'>$name</a>";
      }
      echo '</h2>';
    }

  } //StilusSettings
}
