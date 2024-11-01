<?php
/*
  stilusPostForm.php
  Template to perform the POST call to the stilus API using a form.
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<form id='st_PostForm' name='st_PostForm' action='<?php echo STILUS_URLTOPOST; ?>' enctype='multipart/form-data' method='post' target=''>
  <input type='hidden' id='st_up' name='up' value='<?php echo $st_up; ?>' />
  <input type='hidden' id='st_txt' name='txt' value='' />
  <input type='hidden' id='st_if' name='if' value='html' />
  <input type='hidden' id='st_of' name='of' value='html' />
</form>