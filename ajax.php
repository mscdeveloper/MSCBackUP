<?php
  $lifetime=360000;
  session_set_cookie_params($lifetime);
  set_time_limit(1800);
  ini_set('max_execution_time', 1800);
  ini_set('memory_limit', '4095M');
  session_start();

  include('includes/functions/database.php');
  include('includes/functions/cript.php');

  /* header('Content-Type: text/html; charset=utf-8'); */
  header('Content-type: application/json; charset=utf-8');
  header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
  header('Cache-Control: no-store, no-cache, must-revalidate');
  header('Cache-Control: post-check=0, pre-check=0', FALSE);
  header('Pragma: no-cache');


  include('includes/auth.php');


  ini_set('display_errors', '0');
  $bds = $_SESSION['bds'];
  $bdu = $_SESSION['bdu'];
  $bdp = $_SESSION['bdp'];
  $bd  = $_SESSION['bd'];
  $backup = $_SESSION['backup'];

   $rurl = $_SESSION['rurl'];
   $rl   = $_SESSION['rl'];
   $rp   = $_SESSION['rp'];
   $rbds = $_SESSION['rbds'];
   $rbdu = $_SESSION['rbdu'];
   $rbdp = $_SESSION['rbdp'];
   $rbd  = $_SESSION['rbd'];

   $sff =  $_SESSION['sff'];
   $dff =  $_SESSION['dff'];

   $language = $_SESSION['language'];

  ini_set('display_errors', '1');


  if(empty($language)){
   	 $_SESSION['language'] = 'english';
   	 $language             = 'english';
  }
  include('includes/language/'.$language.'.php');



   if(isset($_POST['rbds'])){
   	    $bds             = $_POST['rbds'];
   }
   if(isset($_POST['rbdu'])){
   	    $bdu             = $_POST['rbdu'];
   }
   if(isset($_POST['rbdp'])){
   	    $bdp             = $_POST['rbdp'];
   }
   if(isset($_POST['rbd'])){
   	    $bd              = $_POST['rbd'];
   }
   if(isset($_POST['sff'])){
   	    $sff              = $_POST['sff'];
   }


  if(isset($_POST['dir'])  ){
  	$bd_data = 'valid';

  }else{
     ini_set('display_errors', '0');
     $bd_data = 'invalid';
     if(tep_db_connect($bds, $bdu, $bdp, $bd)){        $bd_data = 'valid';
        tep_db_set_utf8();
     }else{  	    $bd_data = 'invalid';
     }
     ini_set('display_errors', '1');

  }

  if(isset($_POST['action']) &&  $_POST['action'] == 'get_languages'){  	 $bd_data = 'valid';
  }

  if(isset($_POST['action']) &&  ($_POST['action'] == 'get_language' || $_POST['action'] == 'set_language') ){
  	 $bd_data = 'valid';
  }

  if($bd_data == 'valid' && !isset($_POST['signature'])){    $_SESSION['bds'] = $bds;
    $_SESSION['bdu'] = $bdu;
    $_SESSION['bdp'] = $bdp;
    $_SESSION['bd']  = $bd;
    $_SESSION['backup'] = $backup;

    if(!empty($rurl)){
      $rurl = $_SESSION['rurl'];
    }

    if(!empty($rurl) && !empty($rl) && !empty($rp)){
      $_SESSION['rl'] = $rl;
      $_SESSION['rp'] = $rp;
    }

    if(!empty($rbds)){      $_SESSION['rbds'] = $rbds;
    }

    if(!empty($rbdu)){      $_SESSION['rbdu'] = $rbdu;
    }

    if(!empty($rbdp)){      $_SESSION['rbdp'] = $rbdp;
    }

    if(!empty($rbd)){      $_SESSION['rbd'] = $rbd;
    }

  }


  if(  empty($bds) && !isset($_POST['dir'])  && !(isset($_POST['action']) &&  $_POST['action'] == 'get_languages') && !(isset($_POST['action']) &&  ($_POST['action'] == 'get_language' || $_POST['action'] == 'set_language') )  ){  	echo json_encode((object)array('error' => 1, 'error_description' => $lng->ajax->connect_data_error));   /* 'Данные для подключения к базе данных не найдены.' */
  	exit();
  }

  if($bd_data == 'invalid'){  	echo json_encode((object)array('error' => 1, 'error_description' => $lng->ajax->connect_error));  /* 'Ошибка подключения к базе данных...' */
  	exit();
  }

/*============================================================================*/
function formated_file_size($_path)
{
    $bytes = sprintf('%u', filesize($_path));

    if ($bytes > 0)
    {
        $unit = intval(log($bytes, 1024));
        $units = array('B', 'KB', 'MB', 'GB');

        if (array_key_exists($unit, $units) === true)
        {
            return sprintf('%d %s', $bytes / pow(1024, $unit), $units[$unit]);
        }
    }

    return $bytes;
}
/*============================================================================*/
  function rrmdir($dir) {
  if (is_dir($dir)) {
    $objects = scandir($dir);
    foreach ($objects as $object) {
      if ($object != "." && $object != "..") {
        if (filetype($dir."/".$object) == "dir")
           rrmdir($dir."/".$object);
        else unlink   ($dir."/".$object);
      }
    }
    reset($objects);
    rmdir($dir);
  }
 }
/*============================================================================*/
function set_cookie($_key, $_value){	global  $lng;
	$_SESSION[$_key] = $_value;
	if($_SESSION[$_key] == $_value){      echo json_encode((object)array('error' => 0, 'result' => $lng->ajax->cookie_ok, 'key'=>$_key, 'value'=>$_SESSION[$_key]));  /*  'Cookie успешно создан...'  */
      exit();
	}else{      echo json_encode((object)array('error' => 1, 'error_description' => $lng->ajax->cookie_error, 'key'=>$_key, 'value'=>$_value));  /*  'Ошибка создания cookie...'  */
      exit();
	}
}
/*============================================================================*/
function create_folder($_folder_name){  global  $lng;

  if (!file_exists($_folder_name)) {
     $result = mkdir($_folder_name, 0777);
     if(!$result){      echo json_encode((object)array('error' => 1, 'error_description' => $lng->ajax->error_create_folde .'('. $_folder_name.')...'));   /*  'Ошибка создания папаки '  */
      exit();
     }
  }else{  	return true;
  }
  return false;
}
/*============================================================================*/
function url_no_dots($path) {
 $arr1 = explode('/',$path);
 $arr2 = array();
 foreach($arr1 as $seg) {
  switch($seg) {
   case '.':
    break;
   case '..':
    array_pop($arr2);
    break;
   case '...':
    array_pop($arr2); array_pop($arr2);
    break;
   case '....':
    array_pop($arr2); array_pop($arr2); array_pop($arr2);
    break;
   case '.....':
    array_pop($arr2); array_pop($arr2); array_pop($arr2); array_pop($arr2);
    break;
   default:
    $arr2[] = $seg;
  }
 }
 return implode('/',$arr2);
}
/*============================================================================*/
function remote_file_exists($url){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if( $httpCode == 200 ){return true;}
    return false;
}
/*============================================================================*/
function check_backup_empty($_backup=''){  global $backup;
  global  $lng;

  if($_backup==''){
    $_backup = $backup;
  }

  $dir_for_backup = ('backups/'.$_backup.'/');

  if (!file_exists($dir_for_backup)) {      echo json_encode((object)array('error' => 0, 'result' => $lng->ajax->folder . ' '.$dir_for_backup.' '.$lng->ajax->not_found.'...'));  /*Папка  не найдена */
      exit();
  }

  $files_arr = array();
  if ($handle = opendir($dir_for_backup)){  	 while (false !== ($file = readdir($handle))){
  	     $ext = substr($file, strrpos($file, '.') + 1);
  	     if(in_array($ext, array('zip', 'ZIP', 'gz'))){
  	       array_push($files_arr, $file);
  	     }
  	 }
  	 if(count($files_arr)==0){       echo json_encode((object)array('error' => 0, 'result' => $lng->ajax->folder . ' '.$dir_for_backup.' '.$lng->ajax->empty.'...'));    /* Папка пуста */
       exit();
  	 }else{       echo json_encode((object)array('error' => 1, 'result' => $lng->ajax->folder . ' '.$dir_for_backup.' '.$lng->ajax->files_exist.'...', 'files'=>$files_arr));    /*  Папка содержит файлы */
       exit();
  	 }
  }else{      echo json_encode((object)array('error' => 0, 'result' => $lng->ajax->folder . ' '.$dir_for_backup.' '.$lng->ajax->not_found.'...'));    /* Папка не найдена */
      exit();
  }
}
/*============================================================================*/
function clear_backup_folder(){  global $backup;

  $dir_for_backup = ('backups/'.$backup.'/');
  $files = glob($dir_for_backup.'*'); /*get all file names*/
  foreach($files as $file){ /*iterate files */
   if(is_file($file))
      unlink($file); /* delete file */
  }
  check_backup_empty();
}
/*============================================================================*/
function save_table_part($_table_name, $_start=0){   global $backup;
   global  $lng;

   create_folder('backups');
   create_folder('backups/'.$backup);
   create_folder('backups/'.$backup.'/temp');
   $curent_start = 1;

   if($_start > 0){
		$curent_start = ($_start/3000)+1;
   }


   if($_start == 0){

   }



   $table_data = tep_db_get_array("SELECT * FROM ".$_table_name." LIMIT ".$_start.", 3000");
   $table_data_enc = json_encode($table_data);
   $file_name = 'backups/'.$backup.'/temp/' . $_table_name . '['.$curent_start.']'.'.json';
   file_put_contents($file_name, $table_data_enc);
   $total_count = count($table_data);
   $total_count_formated = number_format($total_count, 0, '.', ' ');

   if(count($table_data)<3000){

     $create_arr = tep_db_get_array("SHOW CREATE TABLE ".$_table_name);
   	 if($create_arr[0]){$create_arr = $create_arr[0];}
   	 if($create_arr['Create Table']){
   	 	$create = $create_arr['Create Table'];


   	 	$create_arr = explode('(', $create);
   	 	$create_last_str = $create_arr[count($create_arr)-1];
   	 	$create_last_str = trim($create_last_str);
   	 	$create_last_str_arr = explode(' ', $create_last_str);
   	 	$new_create_last_str = '';
   	 	foreach($create_last_str_arr as $key => $value){
   	 		 $el_arr = explode('=', $value);
   	 		 if(isset($el_arr[1])){
   	 		 	if($el_arr[0]=='AUTO_INCREMENT'){
   	 		 		/* $value = 'AUTO_INCREMENT=1'; */
   	 		 	}
   	 		 	if($el_arr[0]=='CHARSET'){
   	 		 		$value = 'CHARSET=utf8';
   	 		 	}
   	 		 }
   	 		 $new_create_last_str .= $value . ' ';
   	 	}
   	 	$create = str_replace(array($create_last_str, '0000-00-00 00:00:00'), array($new_create_last_str, '0001-01-01 00:00:01'), $create);



   	 	$file_name = 'backups/'.$backup.'/temp/create.sql';
   	 	file_put_contents($file_name, $create);



        $zip = new ZipArchive();
        $res = $zip->open('backups/'.$backup.'/'.$_table_name.'.zip', ZipArchive::CREATE);
        $zip->addFile('backups/'.$backup.'/temp/create.sql', 'create.sql');
        $zip->close();
        unlink('backups/'.$backup.'/temp/create.sql');
   	 }



   }

     $zip = new ZipArchive();
     $res = $zip->open('backups/'.$backup.'/'.$_table_name.'.zip', ZipArchive::CREATE);
     $zip->addFile('backups/'.$backup.'/temp/' . $_table_name . '['.$curent_start.']'.'.json',     $_table_name . '['.$curent_start.']'.'.json');
     $zip->close();
     unlink('backups/'.$backup.'/temp/' . $_table_name . '['.$curent_start.']'.'.json');

   echo json_encode((object)array('error' => 0, 'table'=>$_table_name, 'saved_count'=>$total_count, 'start'=>$_start, 'file_nr'=>$curent_start, 'report' => $lng->ajax->from_table . ' ' . $_table_name . ' '.$lng->ajax->save_ok.' ' . $total_count_formated .  ' '.$lng->ajax->rows.'...'));  /*  'Из таблицы     упешно сохранено     записей...'  */
   exit();
}
/*============================================================================*/
    /* for remote */
 function get_table_part($_table_name, $_start=0){
   global  $lng;
   check_signature();

   $curent_start = 1;
   if($_start > 0){
		$curent_start = ($_start/3000)+1;
   }



   $table_data = tep_db_get_array("SELECT * FROM ".$_table_name." LIMIT ".$_start.", 3000");
   /*$table_data_enc = json_encode($table_data);*/

   $total_count = count($table_data);
   $total_count_formated = number_format($total_count, 0, '.', ' ');

   $create = '';
   if(count($table_data)<3000){


     $create_arr = tep_db_get_array("SHOW CREATE TABLE ".$_table_name);
   	 if($create_arr[0]){$create_arr = $create_arr[0];}
   	 if($create_arr['Create Table']){
   	 	$create = $create_arr['Create Table'];


   	 	$create_arr = explode('(', $create);
   	 	$create_last_str = $create_arr[count($create_arr)-1];
   	 	$create_last_str = trim($create_last_str);
   	 	$create_last_str_arr = explode(' ', $create_last_str);
   	 	$new_create_last_str = '';
   	 	foreach($create_last_str_arr as $key => $value){
   	 		 $el_arr = explode('=', $value);
   	 		 if(isset($el_arr[1])){
   	 		 	if($el_arr[0]=='AUTO_INCREMENT'){
   	 		 		/* $value = 'AUTO_INCREMENT=1'; */
   	 		 	}
   	 		 	if($el_arr[0]=='CHARSET'){
   	 		 		$value = 'CHARSET=utf8';
   	 		 	}
   	 		 }
   	 		 $new_create_last_str .= $value . ' ';
   	 	}
   	 	$create = str_replace(array($create_last_str, '0000-00-00 00:00:00'), array($new_create_last_str, '0001-01-01 00:00:01'), $create);
   	 }



   }
   echo json_encode((object)array('error' => 0, 'table'=>$_table_name, 'saved_count'=>$total_count, 'start'=>$_start, 'file_nr'=>$curent_start, 'report' => $lng->ajax->from_table . ' ' . $_table_name . ' ' .  $lng->ajax->save_ok  . ' ' . $total_count_formated .  ' ' . $lng->ajax->rows . '...', 'table_data'=>$table_data, 'create'=>$create));   /*  'Из таблицы     упешно сохранено     записей...'  */
   exit();
}
/*============================================================================*/
/*============================================================================*/
/*============================================================================*/
/*============================================================================*/
/*============================================================================*/
/*============================================================================*/
/*============================================================================*/
function get_all_backaps_names(){
  $backups_arr = array();
  $dir_for_backups = ('backups/');
  $files = glob($dir_for_backups.'*');
  foreach($files as $file){  	if(!is_file($file)){  		$backup_name = str_replace(array($dir_for_backups), array(''), $file);
  		array_push($backups_arr ,$backup_name);
  	}
  }
  echo json_encode((object)array('error' => 0, 'backups'=>$backups_arr));
  exit();
}
/*============================================================================*/
function get_backup_tables(){   global $backup;

  $files_arr = array();
  $files_bad_arr = array();
  $dir_for_backup = ('backups/'.$backup.'/');
  $files = glob($dir_for_backup.'*');

  foreach($files as $file){
  	  $ext = substr($file, strrpos($file, '.') + 1);
  	  $file_no_ext = str_replace(array('.'.$ext, $dir_for_backup), array('', ''), $file);
  	  if(in_array($ext, array('zip', 'ZIP', 'gz')) && is_file($file)){
  	     $table_name_arr = explode('/', $file);
  	     $table_name = $table_name_arr[count($table_name_arr)-1];
  	     $table_name =  str_replace(array('.zip', '.ZIP', '.gz'), array('', '', ''), $table_name);

         $za_count_files = 0;
         $za_count_rows = 0;
         $za_count_rows_formated = 0;
         $za_max_file_nr = 1;

         $za = new ZipArchive();
         $za->open($file);
          for( $i = 0; $i < $za->numFiles; $i++ ){
             $stat = $za->statIndex( $i );
             if($stat['name'] != 'create.sql'){             	$za_count_files++;

             	$file_nr = str_replace(array($table_name, '[', '].json'), array('', '', ''), $stat['name']);

             	$file_nr = (int)$file_nr;
             	$za_max_file_nr = max($za_max_file_nr, $file_nr);

             }
          }
          $za->close();


          $last_file_content = file_get_contents('zip://' . realpath($file) . '#' . $table_name . '[' .$za_max_file_nr . '].json' );
          $last_file_content = json_decode($last_file_content, true);

          if(is_array($last_file_content)){
             if($za_max_file_nr > 1){
             		$za_count_rows = (3000 * ($za_max_file_nr-1)) + count($last_file_content);
             }else{
             		$za_count_rows = count($last_file_content);
             }
          }else{
             $za_count_rows = 0;

                array_push($files_bad_arr, (object)array('table'=>$file_no_ext, 'size'=>formated_file_size($file), 'files'=>$za_count_files, 'feilds'=>$za_count_rows, 'feilds_formated'=>$za_count_rows_formated));

          }
          $za_count_rows_formated = number_format($za_count_rows, 0, '.', ' ');



             array_push($files_arr, (object)array('table'=>$file_no_ext, 'size'=>formated_file_size($file), 'files'=>$za_count_files, 'feilds'=>$za_count_rows, 'feilds_formated'=>$za_count_rows_formated, 'max_file_nr'=>$za_max_file_nr));

      }
  }
  echo json_encode((object)array('error' => 0, 'tables'=>$files_arr, 'tables_bad'=>$files_bad_arr));
  exit();
}
/*============================================================================*/
function get_db_tables(){	global $bd;

    check_signature();

    $tables_arr = array();
    $bd_tables = tep_db_get_array("SELECT table_name, table_rows FROM information_schema.tables WHERE table_schema='".$bd."'");
    foreach($bd_tables as $key => $value){
       $bd_tables[$key]['table_rows_int'] = (int)$bd_tables[$key]['table_rows'];
       $bd_tables[$key]['table_rows'] = number_format($bd_tables[$key]['table_rows'], 0, '.', ' ');
       $files =  ceil($bd_tables[$key]['table_rows_int'] / 3000);

       array_push($tables_arr, (object)array('table'=>$bd_tables[$key]['table_name'], 'files'=>$files, 'feilds'=>$bd_tables[$key]['table_rows_int'], 'feilds_formated'=>$bd_tables[$key]['table_rows']));
    }
    echo json_encode((object)array('error' => 0, 'db'=>$bd, 'tables'=>$tables_arr));
    exit();
}
/*============================================================================*/
function remove_backup($_backup_name){

  $dir_for_backup = ('backups/'.$_backup_name.'/');
  rrmdir($dir_for_backup);
  check_backup_empty($_backup_name);
}
/*============================================================================*/
function restore_table_part($_table_name, $_start=0){
   global $backup;
   global $bd;
   global  $lng;

   $temp_folder = 'backups/'.$backup.'/temp';
   $zip_file = 'backups/'.$backup.'/' . $_table_name . '.zip';
   /* create_folder($temp_folder); */


   if($_start == 0){
      $create_content = file_get_contents('zip://' . realpath($zip_file) . '#create.sql');
      $create_content = str_replace(array('CREATE TABLE `'.$_table_name.'`'), array('CREATE TABLE `'.$_table_name.'___`'), $create_content);

      $exist_new_table_arr = tep_db_get_array("SELECT count(*) AS cnt FROM information_schema.tables WHERE table_schema = '".$bd."' AND table_name = '".$_table_name.'___'."'");
      if(isset($exist_new_table_arr[0])){$exist_new_table_arr=$exist_new_table_arr[0];}
      if(isset($exist_new_table_arr['cnt']) && (int)$exist_new_table_arr['cnt'] > 0){      	  tep_db_query("DROP TABLE ".$_table_name."___");
      }

      tep_db_query($create_content);

   }

   $file_nr = 1;
   if($_start > 0){   	  $file_nr = ($_start/3000)+1;
   }

   $table_content = file_get_contents('zip://' . realpath($zip_file) . '#' . $_table_name .'['.$file_nr.'].json' );
   $table_content = json_decode($table_content, true);

   if(is_array($table_content)){
      foreach($table_content as $row){
   	      if(is_array($row)){
   	         $keys = '';
   	         $values = '';   	      	 /* print_r($row); */
   	         foreach ($row as $key => $value){   	   	       if($keys != ''){$keys .= ", ";}
   	   	       if($values != ''){$values .= "', '";}
   	   	       $keys .= $key;
   	   	       $values .= tep_db_input($value);
   	         }
   	         $values = "'" . $values . "'";
   	         if($keys != ''){   	           ini_set('display_errors', '0');
   	           tep_db_query("INSERT INTO ".$_table_name.'___'."  (".$keys.")VALUES(".$values.")");
   	           ini_set('display_errors', '1');
   	         }
   	      }
      }
      $saved_count = count($table_content);
   }else{   	  $saved_count = 0;
   }

   $saved_count_formated = number_format($saved_count, 0, '.', ' ');



   echo json_encode((object)array('error' => 0, 'table'=>$_table_name, 'saved_count'=>$saved_count, 'start'=>$_start, 'file_nr'=>$file_nr, 'report' => $lng->ajax->to_table . ' ' . $_table_name . ' '.$lng->ajax->success_imported.' '.$saved_count_formated.' '.$lng->ajax->rows.'...'));    /* В таблицу     упешно импортировано     записей */
   exit();


}
/*============================================================================*/
function rename_table($_table_name){    global $bd;
    global  $lng;

    $operation = (object)array();

    $operation->stage_1 = false;
    $exist_new_table_arr = tep_db_get_array("SELECT count(*) AS cnt FROM information_schema.tables WHERE table_schema = '".$bd."' AND table_name = '".$_table_name.'___old'."'");
    if(isset($exist_new_table_arr[0])){$exist_new_table_arr=$exist_new_table_arr[0];}
    if(isset($exist_new_table_arr['cnt']) && (int)$exist_new_table_arr['cnt'] > 0){
      	  tep_db_query("DROP TABLE ".$_table_name."___old");
      	  $operation->stage_1 = true;
    }

    $operation->stage_2 = false;
    $exist_new_table_arr = tep_db_get_array("SELECT count(*) AS cnt FROM information_schema.tables WHERE table_schema = '".$bd."' AND table_name = '".$_table_name."'");
    if(isset($exist_new_table_arr[0])){$exist_new_table_arr=$exist_new_table_arr[0];}
    if(isset($exist_new_table_arr['cnt']) && (int)$exist_new_table_arr['cnt'] > 0){
      	tep_db_query("RENAME TABLE `" . $_table_name . "` TO `" . $_table_name."___old`");
      	$operation->stage_2 = true;
    }

    tep_db_query("RENAME TABLE `" . $_table_name."___` TO `" . $_table_name."`");

    $operation->stage_4 = false;
    $exist_new_table_arr = tep_db_get_array("SELECT count(*) AS cnt FROM information_schema.tables WHERE table_schema = '".$bd."' AND table_name = '".$_table_name.'___old'."'");
    if(isset($exist_new_table_arr[0])){$exist_new_table_arr=$exist_new_table_arr[0];}
    if(isset($exist_new_table_arr['cnt']) && (int)$exist_new_table_arr['cnt'] > 0){
      	  tep_db_query("DROP TABLE ".$_table_name."___old");
      	  $operation->stage_4 = true;
    }

   echo json_encode((object)array('error' => 0, 'result'=>$lng->ajax->table_rename_ok, 'operations'=>$operation));              /* 'Таблица успешно переименована...' */
   exit();

}
/*============================================================================*/
function save_table_correction($_table_name){
   global $backup;
   global  $lng;

   create_folder('backups');
   create_folder('backups/'.$backup);
   create_folder('backups/'.$backup.'/temp');
   //__correction.zip'

   $file = 'backups/'.$backup.'/'.$_table_name.'.zip';

   $za_max_file_nr = 1;
   $za_count_rows = 0;
   $za_count_files = 0;

   $za = new ZipArchive();
   $za->open($file);
   for( $i = 0; $i < $za->numFiles; $i++ ){
       $stat = $za->statIndex( $i );
       if($stat['name'] != 'create.sql'){
          $za_count_files++;

          $file_nr = str_replace(array($_table_name, '[', '].json'), array('', '', ''), $stat['name']);

          $file_nr = (int)$file_nr;
          $za_max_file_nr = max($za_max_file_nr, $file_nr);

       }
   }
   $za->close();


   $last_file_content = file_get_contents('zip://' . realpath($file) . '#' . $_table_name . '[' .$za_max_file_nr . '].json' );
   $last_file_content = json_decode($last_file_content, true);

   if(is_array($last_file_content)){
      if($za_max_file_nr > 1){
             $za_count_rows = (3000 * ($za_max_file_nr-1)) + count($last_file_content);
      }else{
             $za_count_rows = count($last_file_content);
      }
   }else{   	  $last_file_content = array();
   }






   $table_data = tep_db_get_array("SELECT * FROM ".$_table_name." LIMIT ".$za_count_rows.", 3000");

   if(!is_array($table_data)){   	 $table_data = array();
   }
   $table_data = array_merge($last_file_content, $table_data);

   $table_data_enc = json_encode($table_data);
   $file_name = 'backups/'.$backup.'/temp/' . $_table_name . '['.$za_max_file_nr.']'.'.json';
   file_put_contents($file_name, $table_data_enc);
   $total_count = count($table_data);
   $total_count_formated = number_format($total_count, 0, '.', ' ');


   $zip = new ZipArchive();
   $res = $zip->open('backups/'.$backup.'/'.$_table_name.'.zip', ZipArchive::CREATE);
   $zip->addFile('backups/'.$backup.'/temp/' . $_table_name . '['.$za_max_file_nr.']'.'.json',     $_table_name . '['.$za_max_file_nr.']'.'.json');
   $zip->close();
   unlink('backups/'.$backup.'/temp/' . $_table_name . '['.$za_max_file_nr.']'.'.json');

   echo json_encode((object)array('error' => 0, 'table'=>$_table_name, 'saved_count'=>$total_count, 'start'=>$za_count_rows, 'file_nr'=>$za_max_file_nr, 'report' => $lng->ajax->from_table . ' ' . $_table_name . ' '.$lng->ajax->save_ok.' ' . $total_count_formated .  ' '.$lng->ajax->rows.'...'));    /* 'Из таблицы  упешно сохранено  записей...' */
   exit();
}
/*============================================================================*/

/*============================================================================*/
/*============================================================================*/
/*============================================================================*/
/*============================================================================*/
function send_remote_post($_post_feilds=array()){
   global $global_auth;

   global $rurl;
   global $rl;
   global $rp;

   global $rbds;
   global $rbdu;
   global $rbdp;
   global $rbd;

   $_post_feilds['rbds'] = $rbds;
   $_post_feilds['rbdu'] = $rbdu;
   $_post_feilds['rbdp'] = $rbdp;
   $_post_feilds['rbd']  = $rbd;

   $curent_action = '';
   if(isset($_post_feilds['action'])){   	 $curent_action = $_post_feilds['action'];
   }
   $curent_signature = "$curent_action$rbds$rbdu$rbdp$rbd$global_auth";
   /*$curent_signature = md5($curent_signature);  for crypt*/
   $curent_signature = encrypt($curent_signature, $global_auth); /*for crypt*/

   $_post_feilds['signature'] = $curent_signature;


   $ajax_url = $rurl . 'ajax.php';

   $ch = curl_init($ajax_url);
   /*
   curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
   curl_setopt($ch, CURLOPT_HEADER, 1);
   */
   if(!empty($rl)){
      curl_setopt($ch, CURLOPT_USERPWD, $rl . ":" . $rp);
   }
   curl_setopt($ch, CURLOPT_TIMEOUT, 60000);
   curl_setopt($ch, CURLOPT_POST, 1);
   curl_setopt($ch, CURLOPT_POSTFIELDS, $_post_feilds);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
   $result = curl_exec($ch);
   curl_close($ch);

   return $result;

}
/*============================================================================*/
function check_signature(){
   global $global_auth;
   global  $lng;

   global $bds;
   global $bdu;
   global $bdp;
   global $bd;

   $signature = '';
   if(isset($_POST['signature'])){
   	 $signature = $_POST['signature'];
   }


   $curent_action = '';
   if(isset($_POST['action'])){
   	 $curent_action = $_POST['action'];
   }
   $curent_signature = "$curent_action$bds$bdu$bdp$bd$global_auth";
   /*$curent_signature = md5($curent_signature); for crypt */

   if(isset($_POST['signature']) && encrypton_valid($curent_signature, $signature, $password) /*$signature !== $curent_signature*/){  /* for crypt */     echo json_encode((object)array('error' => 1, 'result'=>$lng->ajax->signature_error /*, 'signature'=>$signature, 'signature_calk'=>$curent_signature*/));     /*  'Ошибка signature...'  */
     exit();
   }
}
/*============================================================================*/
function get_remote_db_tables(){
    $result = send_remote_post(array('action'=>'get_db_tables'));
    echo($result);
    exit();
}
/*============================================================================*/
function get_remote_table_part($_table_name, $_start){	global $backup;

   create_folder('backups');
   create_folder('backups/'.$backup);
   create_folder('backups/'.$backup.'/temp');

	$result = send_remote_post(array('action'=>'get_table_part', 'table_name'=>$_table_name, 'start'=>$_start));

	$result_dec = json_decode($result, true);
	$file_nr = $result_dec['file_nr'];



	if(isset($result_dec['table_data'])){		$table_data = $result_dec['table_data'];
		if(empty($table_data)){			$table_data = array();
		}

        $table_data_enc = json_encode($table_data);
        $file_name = 'backups/'.$backup.'/temp/' . $_table_name . '['.$file_nr.']'.'.json';
        file_put_contents($file_name, $table_data_enc);

        $zip = new ZipArchive();
        $res = $zip->open('backups/'.$backup.'/'.$_table_name.'.zip', ZipArchive::CREATE);
        $zip->addFile('backups/'.$backup.'/temp/' . $_table_name . '['.$file_nr.']'.'.json',     $_table_name . '['.$file_nr.']'.'.json');
        $zip->close();
        unlink('backups/'.$backup.'/temp/' . $_table_name . '['.$file_nr.']'.'.json');

		if(count($table_data)<3000 && isset($result_dec['create'])){
	   	  $file_name = 'backups/'.$backup.'/temp/create.sql';
   	 	  file_put_contents($file_name, $result_dec['create']);

          $zip = new ZipArchive();
          $res = $zip->open('backups/'.$backup.'/'.$_table_name.'.zip', ZipArchive::CREATE);
          $zip->addFile($file_name, 'create.sql');
          $zip->close();
          unlink($file_name);

		}
		unset($result_dec['table_data']);
		unset($result_dec['create']);
		$result = json_encode($result_dec);
	}


    echo($result);
    exit();
}
/*============================================================================*/
function save_table_correction_remote($_table_name){
   global $backup;
   global  $lng;

   create_folder('backups');
   create_folder('backups/'.$backup);
   create_folder('backups/'.$backup.'/temp');

   $file = 'backups/'.$backup.'/'.$_table_name.'.zip';

   $za_max_file_nr = 1;
   $za_count_rows = 0;
   $za_count_files = 0;

   $za = new ZipArchive();
   $za->open($file);
   for( $i = 0; $i < $za->numFiles; $i++ ){
       $stat = $za->statIndex( $i );
       if($stat['name'] != 'create.sql'){
          $za_count_files++;

          $file_nr = str_replace(array($_table_name, '[', '].json'), array('', '', ''), $stat['name']);

          $file_nr = (int)$file_nr;
          $za_max_file_nr = max($za_max_file_nr, $file_nr);

       }
   }
   $za->close();


   $last_file_content = file_get_contents('zip://' . realpath($file) . '#' . $_table_name . '[' .$za_max_file_nr . '].json' );
   $last_file_content = json_decode($last_file_content, true);

   if(is_array($last_file_content)){
      if($za_max_file_nr > 1){
             $za_count_rows = (3000 * ($za_max_file_nr-1)) + count($last_file_content);
      }else{
             $za_count_rows = count($last_file_content);
      }
   }else{
   	  $last_file_content = array();
   }






   /*$table_data = tep_db_get_array("SELECT * FROM ".$_table_name." LIMIT ".$za_count_rows.", 3000");*/
   $result = send_remote_post(array('action'=>'get_table_part', 'table_name'=>$_table_name, 'start'=>$za_count_rows));

   $table_data = json_decode($result, true);


   if(!is_array($table_data)){
   	 $table_data = array();
   }
   $table_data = array_merge($last_file_content, $table_data);

   $table_data_enc = json_encode($table_data);
   $file_name = 'backups/'.$backup.'/temp/' . $_table_name . '['.$za_max_file_nr.']'.'.json';
   file_put_contents($file_name, $table_data_enc);
   $total_count = count($table_data);
   $total_count_formated = number_format($total_count, 0, '.', ' ');


   $zip = new ZipArchive();
   $res = $zip->open('backups/'.$backup.'/'.$_table_name.'.zip', ZipArchive::CREATE);
   $zip->addFile('backups/'.$backup.'/temp/' . $_table_name . '['.$za_max_file_nr.']'.'.json',     $_table_name . '['.$za_max_file_nr.']'.'.json');
   $zip->close();
   unlink('backups/'.$backup.'/temp/' . $_table_name . '['.$za_max_file_nr.']'.'.json');

   echo json_encode((object)array('error' => 0, 'table'=>$_table_name, 'saved_count'=>$total_count, 'start'=>$za_count_rows, 'file_nr'=>$za_max_file_nr, 'report' => $lng->ajax->from_table . ' ' . $_table_name . ' '.$lng->ajax->save_ok.' ' . $total_count_formated .  ' '.$lng->ajax->rows.'...'));    /* 'Из таблицы  упешно сохранено  записей...' */
   exit();
}
/*============================================================================*/
function  get_files_in_dir($_dir){ global  $lng;

 $files = glob($_dir . '*.*');
 usort($files, function($a, $b) {
    return filemtime($a) < filemtime($b);
 });
 $files_arr = array();
 foreach($files as $key => $file){
	$file_url = url_no_dots(dirname( (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ).'/'.$file);
    /*
    $file_url_arr = explode('/', $file_url);
    $file_url_arr[count($file_url_arr)-1] = urlencode($file_url_arr[count($file_url_arr)-1]);
    $file_url = implode('/',$file_url_arr);
    */


    if(!empty($file_url) && strpos($file_url, ' ') === false && strpos($file_url, '+') === false && strpos($file_url, '&') === false && strpos($file_url, '%') === false ){
	  array_push($files_arr, (object)array('file'=>$file_url, 'create'=> date ('Y-m-d H:i:s', filemtime($file)), 'create_ru'=> date ('d.m.Y', filemtime($file)) ));
    }
 }
 $remote_dir = '';
 if(isset($files[0])){
   $remote_dir = url_no_dots(dirname(dirname( (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ).'/'.$files[0]).'/');
 }
  echo json_encode((object)array('error' => 0, 'result'=>$lng->ajax->files, 'remote_dir'=>$remote_dir, 'files'=>$files_arr));       /* 'Список файлов...' */
  exit();
}
/*============================================================================*/
function get_remote_files_in_dir(){	global $sff;
    $result = send_remote_post(array('action'=>'get_files_in_dir', 'dir'=>$sff));
    echo($result);
    exit();
}
/*============================================================================*/
function save_file_from_remote($_remote_file_url){	global $dff;
	global  $lng;

	$destination_dir  = dirname(realpath($dff)).'/';

    $remote_file_url_arr = explode('/', $_remote_file_url);
    $remote_file_name = $remote_file_url_arr[count($remote_file_url_arr)-1];
    /*$remote_file_name = urlencode($remote_file_name); */

    $newfile = $dff . $remote_file_name;
    $newfile_url = url_no_dots(  dirname(  (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ) . '/' .  $dff  . $remote_file_name );

    if(!remote_file_exists($_remote_file_url)){       echo json_encode((object)array('error' => 0, 'result'=>$lng->ajax->file_not_found . '...', 'done'=>false, 'file'=>$remote_file_name, 'url'=>$newfile_url, 'original_url'=>$_remote_file_url));  /* Файл не найден... */
       exit();
    }

    if ( copy($_remote_file_url, $newfile) ) {
       $result =  json_encode((object)array('error' => 0, 'result'=>$lng->ajax->file_copy_ok . '...', 'done'=>true, 'file'=>$remote_file_name, 'url'=>$newfile_url, 'original_url'=>$_remote_file_url));   /* 'Файл успешно скопирован...' */
    }else{
       $result =  json_encode((object)array('error' => 0, 'result'=>$lng->ajax->file_copy_error . '...', 'done'=>false, 'file'=>$remote_file_name, 'url'=>$newfile_url, 'original_url'=>$_remote_file_url));
    }
   echo $result;
   exit();
}
/*============================================================================*/
function get_languages(){  global $language;
  global  $lng;
  $gl_lng = $lng;
  $language_dir	= 'includes/language/';  $language_arr = array();
  if ($handle = opendir($language_dir)){
  	 while (false !== ($file = readdir($handle))){
  	     $file_arr = explode('/', $file);
  	     $file = $file_arr[count($file_arr)-1];
  	     $file_arr = explode('.', $file);
  	     $file = $file_arr[0];
  	     if($file != ''){  	      include($language_dir . $file . '.php');
  	      $def = false;
  	      if($file == $language){  	      	$def = true;
  	      }
  	      array_push($language_arr, array('file'=>$file, 'laguage'=>$lng->language, 'flag'=>$lng->flag, 'default'=>$def));
  	     }
  	 }
     $result =  json_encode((object)array('error' => 0, 'result'=>$gl_lng->ajax->files_found . ' '.count($language_arr).'...', 'language'=>$language_arr ));   /* Найдено файлов */
  }else{  	 $result =  json_encode((object)array('error' => 1, 'result'=>$gl_lng->ajax->folder . ' '.$language_dir.' '.$gl_lng->ajax->not_found.'...', 'language'=>$language_arr ));    /* Каталог  не найден... */
  }
   echo $result;
   exit();
}
/*============================================================================*/
function get_language($_language){   $language_dir	= 'includes/language/';
   include($language_dir.$_language.'.php');
   $result =  json_encode((object)array('error' => 0, 'result'=>'', 'lng'=>$lng  ));
   echo $result;
   exit();
}
/*============================================================================*/
function set_language($_language){	global  $lng;
	$_SESSION['language'] = $_language;
	if($_SESSION['language'] == $_language){
      echo json_encode((object)array('error' => 0, 'result' => $lng->ajax->cookie_ok . '...', 'language'=>$_language));  /* Cookie успешно создан */
      exit();
	}else{
      echo json_encode((object)array('error' => 1, 'error_description' => $lng->ajax->cookie_error . '...', 'language'=>$_SESSION['language']));  /*  Ошибка создания cookie  */
      exit();
	}
}
/*============================================================================*/
/*============================================================================*/
/*============================================================================*/
/*============================================================================*/
/*============================================================================*/
/*============================================================================*/


  if(isset($_POST['action'])){
	 $action = $_POST['action'];

     if($action == 'set_cookie'){
     	$key = '';
     	if(isset($_POST['key'])){
     	  $key = $_POST['key'];
     	}
     	$value = '';
     	if(isset($_POST['value'])){
     	  $value = $_POST['value'];
     	}
     	set_cookie($key, $value);
     }

     if($action == 'check_backup_empty'){
     	check_backup_empty();
     }

      if($action == 'clear_backup_folder'){
     	clear_backup_folder();
     }

     if($action == 'save_table'){     	$table_name = $_POST['table_name'];
     	$start = 0;
     	if(isset($_POST['start'])){
     	  $start = (int)$_POST['start'];
     	}     	save_table($table_name, $start);
     }

     if($action == 'save_table_part'){
     	$table_name = $_POST['table_name'];
     	$start = 0;
     	if(isset($_POST['start'])){
     	  $start = (int)$_POST['start'];
     	}
     	save_table_part($table_name, $start);
     }

     if($action == 'get_all_backaps_names'){
     	get_all_backaps_names();
     }

     if($action == 'get_backup_tables'){     	get_backup_tables();
     }

     if($action == 'get_db_tables'){
     	get_db_tables();
     }

     if($action == 'remove_backup'){
     	$backup = '';
     	if(isset($_POST['backup'])){
     	  $backup = $_POST['backup'];
     	}
     	remove_backup($backup);
     }

     if($action == 'restore_table_part'){
     	$table_name = '';
     	if(isset($_POST['start'])){
     	  $table_name = $_POST['table_name'];
     	}
     	$start = 0;
     	if(isset($_POST['start'])){
     	  $start = (int)$_POST['start'];
     	}
     	restore_table_part($table_name, $start);
     }

     if($action == 'rename_table'){     	$table_name = '';
     	if(isset($_POST['table_name'])){
     	  $table_name = $_POST['table_name'];
     	}
     	rename_table($table_name);
     }

     if($action == 'get_table_part'){
     	$table_name = '';
     	if(isset($_POST['table_name'])){
     	  $table_name = $_POST['table_name'];
     	}
     	$start = 0;
     	if(isset($_POST['start'])){
     	  $start = (int)$_POST['start'];
     	}
        get_table_part($table_name, $start);
     }

     /* for remote calls */

     if($action == 'get_remote_db_tables'){
     	get_remote_db_tables();
     }

     if($action == 'get_remote_table_part'){
     	$table_name = '';
     	if(isset($_POST['table_name'])){
     	  $table_name = $_POST['table_name'];
     	}
     	$start = 0;
     	if(isset($_POST['start'])){
     	  $start = (int)$_POST['start'];
     	}
        get_remote_table_part($table_name, $start);
     }

     if($action == 'get_files_in_dir'){
     	$dir= '';
     	if(isset($_POST['dir'])){
     	  $dir= $_POST['dir'];
     	}
     	get_files_in_dir($dir);
     }

     if($action == 'get_remote_files_in_dir'){
     	get_remote_files_in_dir();
     }

     if($action == 'save_file_from_remote'){     	$file = '';
     	if(isset($_POST['file'])){     		$file = $_POST['file'];
     	}
     	save_file_from_remote($file);
     }

     if($action == 'save_table_correction'){
     	$table_name = '';
     	if(isset($_POST['table_name'])){
     	  $table_name = $_POST['table_name'];
     	}
     	save_table_correction($table_name);
     }

     if($action == 'save_table_correction_remote'){
     	$table_name = '';
     	if(isset($_POST['table_name'])){
     	  $table_name = $_POST['table_name'];
     	}
     	save_table_correction_remote($table_name);
     }

     if($action == 'get_languages'){     	get_languages();
     }

     if($action == 'get_language'){
     	$language = '';
     	if(isset($_POST['language'])){
     	  $language = $_POST['language'];
     	}
     	get_language($language);
     }

     if($action == 'set_language'){
     	$language = '';
     	if(isset($_POST['language'])){
     	  $language = $_POST['language'];
     	}
     	set_language($language);
     }



    /*
     if($action == 'test'){       $str = '';
       if(isset($_POST['str'])){
     	  $str = $_POST['str'];
       }
       $enc = encrypt($str, $global_auth);
       $result = send_remote_post(array('action'=>'test_remote', 'str'=>$str, 'enc'=>$enc ));
       echo($result);
       exit();

     }

      if($action == 'test_remote'){       $str = '';
       if(isset($_POST['str'])){
     	  $str = $_POST['str'];
       }
       $enc = '';
       if(isset($_POST['enc'])){
     	  $enc = $_POST['enc'];
       }

       $dec = decrypt($enc, $global_auth);
       $valid = encrypton_valid($str, $enc, $global_auth);
       echo json_encode((object)array('error' => 0, 'str'=>$str, 'enc'=>$enc, 'dec'=>$dec, 'valid'=>$valid ));
       exit();
      }
      */


  }






  if(count($_POST) == 0){  	echo json_encode((object)array('error' => 1, 'error_description' => $lng->ajax->empty_post.'...'));         /* Отправлен пустой POST запрос */
  	exit();
  }else{  	echo json_encode((object)array('error' => 1, 'error_description' => 'POST запрос не обработан...', 'post'=>$_POST));  /* POST запрос не обработан */
  	exit();
  }
  echo(json_encode((object)array()));

?>
