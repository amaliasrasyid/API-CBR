<?php
function format_number($num){
  $number = number_format($num,0,',','.');
  return $number ;
}
?>