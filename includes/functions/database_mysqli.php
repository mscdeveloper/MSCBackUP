<?php



  function tep_db_connect($server = DB_SERVER_MYSQLI, $username = DB_SERVER_USERNAME, $password = DB_SERVER_PASSWORD, $database = DB_DATABASE, $link = 'db_link') {
    global $link;

    if($link === null){


       if(!$link = mysqli_connect($server, $username, $password, $database)){
         return null;
       }


       if (mysqli_connect_errno()){
         echo "Failed to connect to MySQL: " . mysqli_connect_error();
       }

       mysqli_query($link, "SET NAMES 'cp1251'");

    }


    return $link;

  }



  function tep_db_set_utf8(){  	global $link;

    mysqli_query($link, "SET NAMES 'utf8'");
    mysqli_query($link, "SET CHARACTER SET 'utf8'");
    mysqli_query($link, "SET SESSION collation_connection = 'utf8_general_ci'");
  }



  function tep_db_close($link = 'db_link') {
    global $link;
    return mysqli_close($link);
  }

  function tep_db_error($query, $errno, $error) {
    if (ini_get('display_errors')){
       die('<font color="#000000"><b>' . $errno . ' - ' . $error . '<br><br>' . $query . '<br><br><small><font color="#ff0000">[TEP STOP]</font></small><br><br></b></font>');
    }
  }

  if(isset($_GET['debug'])){  	?>
  	 <script>
  	 var total_db_query = 0;
  	 var total_db_microtime = 0;
     document.onreadystatechange = function(){
        if(document.readyState === 'complete'){
           console.log('total mysql querys -> '+ total_db_query);
           console.log('total mysql times -> '+total_db_microtime);
        }
     }
  	 </script>
  	<?php
  }

  function tep_db_query($query, $link = 'db_link') {
    global $link;

    if (defined('STORE_DB_TRANSACTIONS') && (STORE_DB_TRANSACTIONS == 'true')) {
      error_log('QUERY ' . $query . "\n", 3, STORE_PAGE_PARSE_TIME_LOG);
    }

    if(isset($_GET['debug'])){
       $starttime = microtime(true);
    }

    $result = mysqli_query($link, $query) or tep_db_error($query, mysqli_errno($link), mysqli_error($link));

    if(isset($_GET['debug'])){
      $endtime = microtime(true);
      $duration = $endtime - $starttime;
      ?><script>total_db_microtime+=<?php echo($duration);?>;</script><?php
    }


    if (defined('STORE_DB_TRANSACTIONS') && (STORE_DB_TRANSACTIONS == 'true')) {
       $result_error = mysqli_error();
       error_log('RESULT ' . $result . ' ' . $result_error . "\n", 3, STORE_PAGE_PARSE_TIME_LOG);
    }

    /*$result = mysql_query($query, $$link) or tep_db_error($query, mysql_errno(), mysql_error());



    if (defined('STORE_DB_TRANSACTIONS') && (STORE_DB_TRANSACTIONS == 'true')) {
       $result_error = mysql_error();
       error_log('RESULT ' . $result . ' ' . $result_error . "\n", 3, STORE_PAGE_PARSE_TIME_LOG);
    }
   */
   $mysql_q_string = '';
   if(isset($_GET['debug']))
    {      if($duration > 0){$duration='<span style="color:red;font-weight:bold;">'.$duration.'</span>';}
      $debug_array = (object)array();
      $debug_array->sql = $query;
      $debug_array->file = basename($_SERVER['PHP_SELF']);
      $debug_array->time = $duration;
      $bt = debug_backtrace();
      foreach($bt as $bt_el) {
      	if(isset($bt_el['function']) && $bt_el['function'] == 'tep_db_query'){      		$debug_array->line = $bt_el['line'];
      		$debug_array->file = $bt_el['file'];
      	}
      }
      echo('<div style="background-color:white; border-color:blue; border-style:solid; border-width:1px;  font-family: Courier New, Courier, Lucida Sans Typewriter, Lucida Typewriter, monospace; font-size: 14px; font-style: normal;"><pre>');  print_r($debug_array);  echo('</pre></div>');
      ?><script>total_db_query++;</script>  <?php      //echo('<b>MySql -> </b>'.$query.'<br><br>');
     /*$mysql_q_string=$mysql_q_string."<br><br>".$query; */
      /*
      echo("<script>
             mysql_q_qty=mysql_q_qty+1;
             //mysql_q_string=mysql_q_string+'<br><br>'+'".$query."';//
            </script>");
            echo($query.'<br><br>');
      */
    }

    return $result;
  }

  function tep_db_perform($table, $data, $action = 'insert', $parameters = '', $link = 'db_link') {
    reset($data);
    if ($action == 'insert') {
      $query = 'insert into ' . $table . ' (';
      /*while (list($columns, ) = each($data)) {   msc for php 7.3.6  */      foreach(array_keys($data) as $columns) {
        $query .= $columns . ', ';
      }
      $query = substr($query, 0, -2) . ') values (';
      /*
      reset($data);
      while (list(, $value) = each($data)) {       msc for php 7.3.6  */
      foreach($data as $value) {
        switch ((string)$value) {
          case 'now()':
            $query .= 'now(), ';
            break;
          case 'null':
            $query .= 'null, ';
            break;
          default:
            $query .= '\'' . tep_db_input($value) . '\', ';
            break;
        }
      }
      $query = substr($query, 0, -2) . ')';
    } elseif ($action == 'update') {
      $query = 'update ' . $table . ' set ';
      /*while (list($columns, $value) = each($data)) {  msc for php 7.3.6  */
      foreach($data as $columns => $value) {
        switch ((string)$value) {
          case 'now()':
            $query .= $columns . ' = now(), ';
            break;
          case 'null':
            $query .= $columns .= ' = null, ';
            break;
          default:
            $query .= $columns . ' = \'' . tep_db_input($value) . '\', ';
            break;
        }
      }
      $query = substr($query, 0, -2) . ' where ' . $parameters;
    }

    return tep_db_query($query, $link);
  }

  function tep_db_fetch_array($db_query) {
    return mysqli_fetch_array($db_query, MYSQLI_ASSOC);
  }

  function tep_db_num_rows($db_query) {
    return mysqli_num_rows($db_query);
  }

  function tep_db_data_seek($db_query, $row_number) {
    return mysqli_data_seek($db_query, $row_number);
  }

  function tep_db_insert_id() {
    global $link;
    return mysqli_insert_id($link);
  }

  function tep_db_free_result($db_query) {
    return mysqli_free_result($db_query);
  }

  function tep_db_fetch_fields($db_query) {
    return mysqli_fetch_field($db_query);
  }

  function tep_db_output($string) {
    return htmlspecialchars($string);
  }

  function tep_db_input($string, $link_x = 'db_link') {
    global $link;

    if($link === null){
      $link = tep_db_connect();
    }

    if (function_exists('mysqli_real_escape_string')) {
      return mysqli_real_escape_string($link, $string);
    }elseif(function_exists('mysql_escape_string')) {
      return mysql_escape_string($string);
    }

    return addslashes($string);
  }

  function tep_db_prepare_input($string) {
    if (is_string($string)) {
      return trim(stripslashes($string));    /* return trim(tep_sanitize_string(stripslashes($string)));   msc for php 7.3.6  */
    } elseif (is_array($string)) {
      /*reset($string);*/
      /* while (list($key, $value) = each($string)) {  msc for php 7.3.6  */      foreach($string as $key => $value) {
        $string[$key] = tep_db_prepare_input($value);
      }
      return $string;
    } else {
      return $string;
    }
  }

/*============================================================================*/
  function tep_db_get_array($string){
  $out=array();

  $query = tep_db_query($string);
  if(tep_db_num_rows($query) ){
   while ($r = tep_db_fetch_array($query)){
     $out[] = $r;
   }
  }

  return $out;
}
/*============================================================================*/


?>