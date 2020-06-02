<?php

  /* mysqli installed */

  if(function_exists('mysqli_connect')){
       require('database_mysqli.php');
  }else{
       require('database_mysql.php');
  }


?>
