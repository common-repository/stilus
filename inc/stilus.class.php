<?php
/*
  stilus.class.php
  Stilus main class of the plugin
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Stilus {

  var $isConfigured = false;
  var $user;
  var $encodedPassword;
  /*
   * Class constructor
   */
  function __construct() {
    //initial hookers and internationalization
    add_action('init', array($this,'init'));
    add_action('init', array($this, 'plugin_internationalization')); //i18n

    // Settings
    $settings = new StilusSettings();
    $plugin = STILUS_PLUGIN_FILE;
    $this->user = get_option('st_mystilusU');
    $this->encodedPassword = get_option('st_encodedP');
    $this->isConfigured = ($this->user != '' && $this->encodedPassword != '');
    add_filter("plugin_action_links_$plugin", array($this, 'plugin_settings_link'));
  } //__construct


  /*
   * Initial function
   */
  function init() {
     //Add Stilus's Button
    add_action('media_buttons_context',  array($this, 'add_stilus_button'));

     //Add Icons
    add_action('wp_enqueue_scripts', array($this, 'jk_load_dashicons'));

     //Add the info popup
     add_action('admin_footer',  array($this, 'add_inline_popup_content'));

     //Add java script functions to the stilus button
     add_action('admin_footer', array($this, 'set_on_click_post'));
  } // init


  /*
   * Add the button to process the text with my stilus
   */
  function add_stilus_button($context) {
    //our popup's title
    $title = __('Stilus Check report', 'Stilus');

    //append the icon
    if(!$this->isConfigured){
      $context .= "<a title='{$title}' disabled onClick='openErrorDialog();' href='#TB_inline?width=400&inlineId=stilus_info_not_configured' ".
                  "id='stilusButton' class='button thickbox' data-editor='content'>".
                  "<span class='wp-media-buttons-icon dashicons dashicons-editor-spellcheck'></span> ".__('Stilus Check report', 'Stilus')."
                   </a>";
    }else{ // use other window to popup the result
      $context .= "<button title='{$title}' id='stilusButton' onclick='event.preventDefault();' class='button thickbox' >
                     <span class='wp-media-buttons-icon dashicons dashicons-editor-spellcheck'></span> ".__('Stilus Check report', 'Stilus')."
                   </button>";
    }

    return $context;
  } //add_my_custom_button


  /*
   * Set an onclick function
   */
  function set_on_click_post(){
    if($this->isConfigured){
      wp_enqueue_script('stilusJS', plugins_url().'/stilus/inc/js/StilusChecker.js', array('jquery'), false, true);
      wp_localize_script('stilusJS', 'st_plainTextEditorAlert', __('Warning: The proofreading with Stilus can only be performed in the Visual editor. Please change the edition mode.', 'Stilus'));
      wp_localize_script('stilusJS', 'st_popupUrl', STILUS_URL.'/inc/templates/loading.php');
    }
  } // set_on_click_post


  /*
   * Include an hidden popup in order to display a the result
   */
  function add_inline_popup_content() {
    //load the templates
    if($this->isConfigured){
      $st_up = StilusEncoder::encodeUP($this->user, $this->encodedPassword); // st_up is used to render the template above
      require_once(STILUS_DIR.'/inc/templates/stilusPostForm.php');
    }else
      require_once(STILUS_DIR.'/inc/templates/stilusInfoPopup.php');
  } //add_inline_popup_content


  /*
   * Load dashicons for the page
   */
  function jk_load_dashicons() {
    wp_enqueue_style( 'st_dashicons' );
  } //jk_load_dashicons


  /*
   * Add the settings link to the plugins page
   */
  function plugin_settings_link($links) {
    $settings_link = '<a href="options-general.php?page=st_settings">'.__('Settings','Stilus').'</a>';
    array_unshift($links, $settings_link);
    return $links;
  } // plugin_settings_link


  /*
   * Load *.mo files for language
   * of the plugin interface.
   */
  public function plugin_internationalization() {
    load_plugin_textdomain('Stilus', false, basename(STILUS_DIR).'/lang');
  } //plugin_internationalization


} // class Stilus


?>
