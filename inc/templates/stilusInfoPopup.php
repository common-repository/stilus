<?php
/*
  stilusInfoPopup.php
  Stilus error and other info popup template
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<?php  /* if plugin not configured*/  ?>
<div id="stilus_info_not_configured" style="display:none;">
  <img style="display: block;margin: 0 auto;" src='<?php echo STILUS_IMG.'LogoStilus.png'; ?>' \>
  <p><span class="dashicons dashicons-warning"></span>1
  	<?php
    echo __("Before using Stilus, you must ", 'Stilus')." <a href='options-general.php?page=st_settings'> ".__('insert', 'Stilus')."</a> ";
    echo __( " your username and password.", 'Stilus');
  	?>
  </p>

</div>

<?php  /* Edit inline popup size*/  ?>
<script>

  function editWindow(){
    var height = 210;
    var width = 400;
    var marginLeft = (jQuery(window).width()-width)/2;
    var marginTop = (jQuery(window).height()-height)/2;

    jQuery("#TB_window")
      .css("height", height+"px")
      .css("width", width+"px")
      .css("top","0")
      .css("left","0")
      .css("margin-top",marginTop+"px")
      .css("margin-left",marginLeft+"px");

    jQuery("#TB_ajaxContent")
      .css("height", (height-47)+"px")
      .css("width", (width-30)+"px");
  } //editWindow

  function openErrorDialog(element){
    setTimeout(editWindow, 20);
    window.onresize = editWindow;
  } //openErrorDialog

</script>