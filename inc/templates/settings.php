<?php
/*
  settings.php
  Stilus' settings page template
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
//GENERAL tab

if(!(isset($_GET['tab']))||$_GET['tab']=='general'){
 ?>

  <form method="post" action="options.php">

    <?php /* print wordpress option form */ ?>
    <?php @settings_fields('st_settings-group'); ?>
    <?php do_settings_sections('st_settings'); ?>
    <?php @submit_button(); ?>
   </form>

<?php

} // END of tabs selector
