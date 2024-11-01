<?php
/*
  stilusEncoder.class.php
  The StilusEncoder class implements all the encoding/decoding functionallity.
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class StilusEncoder{

  public static function encodeUP($user, $encodedPassword) {
    return strrev(base64_encode($user.'|'.StilusEncoder::decodeP($encodedPassword).'|'.time()));
  } // encodeUP

  //product and credits params unused actually ... but not empty
  public static function encodeUPPC($user, $encodedPassword, $product = 'stg', $credits = '99') {
    return strrev(base64_encode($user.'|'.StilusEncoder::decodeP($encodedPassword).'|'.$product.'|'.$credits.'|'.time()));
  } // encodeUPPC

  public static function encodeP($password) {
    return strrev(base64_encode($password));
  } // encodeUP

  private static function decodeP($password) {
    return base64_decode(strrev($password));
  } // encodeUP
}

?>