<?php

  $lifetime=360000;
   session_set_cookie_params($lifetime);
   set_time_limit(1800);
   ini_set('max_execution_time', 1800);
   ini_set('memory_limit', '4095M');
   session_start();
   /*echo('session_get_cookie_params<pre>'); print_r(session_get_cookie_params()); echo('</pre>');*/
   /*echo('$_SESSION<pre>'); print_r($_SESSION); echo('</pre>');*/
   /*echo('$_POST<pre>'); print_r($_POST); echo('</pre>');*/


   include('includes/functions/database.php');
   include('includes/functions/cript.php');

   header('Content-Type: text/html; charset=utf-8');
   header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
   header('Cache-Control: no-store, no-cache, must-revalidate');
   header('Cache-Control: post-check=0, pre-check=0', FALSE);
   header('Pragma: no-cache');


   include('includes/auth.php');

   if(isset($_POST['action'])){  	 $action = $_POST['action'];
  	 if($action == 'logout'){  	 	$language = $_SESSION['language'];  	    session_unset();
  	    $_SESSION['language'] = $language;
  	 }
   }



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


   if(empty($backup)){   	 $date = date('Y_m_d', strtotime('now'));
   	 $backup = 'backup_'.$date;
   	 $_SESSION['backup'] = $backup;
   }

   if(empty($language)){   	 $_SESSION['language'] = 'english';
   	 $language             = 'english';
   }

   include('includes/language/'.$language.'.php');


   if(!isset($bd_data) || $bd_data=='invalid'){   	  if(isset($_POST['bds'])){   	    $_SESSION['bds'] = $_POST['bds'];
   	    $bds             = $_POST['bds'];
   	  }
   	  if(isset($_POST['bdu'])){
   	    $_SESSION['bdu'] =  $_POST['bdu'];
   	    $bdu             = $_POST['bdu'];
   	  }
   	  if(isset($_POST['bdp'])){
   	    $_SESSION['bdp'] = $_POST['bdp'];
   	    $bdp             = $_POST['bdp'];
   	  }
   	  if(isset($_POST['bd'])){
   	    $_SESSION['bd']  = $_POST['bd'];
   	    $bd              = $_POST['bd'];
   	  }
   }


   if(isset($_POST['rurl'])){
   	    $_SESSION['rurl'] = $_POST['rurl'];
   	    $rurl             = $_POST['rurl'];
   }
   if(isset($_POST['rbds'])){
   	    $_SESSION['rbds'] = $_POST['rbds'];
   	    $rbds             = $_POST['rbds'];
   }
   if(isset($_POST['rbdu'])){
   	    $_SESSION['rbdu'] = $_POST['rbdu'];
   	    $rbdu             = $_POST['rbdu'];
   }
   if(isset($_POST['rbdp'])){
   	    $_SESSION['rbdp'] = $_POST['rbdp'];
   	    $rbdp             = $_POST['rbdp'];
   }
   if(isset($_POST['rbd'])){
   	    $_SESSION['rbd']  = $_POST['rbd'];
   	    $rbd              = $_POST['rbd'];
   }
   if(isset($_POST['rl'])){
   	    $_SESSION['rl']  = $_POST['rl'];
   	    $rl              = $_POST['rl'];
   }
   if(isset($_POST['rp'])){
   	    $_SESSION['rp']   = $_POST['rp'];
   	    $rp               = $_POST['rp'];
   }
   if(isset($_POST['sff'])){
   	    $_SESSION['sff']   = $_POST['sff'];
   	    $sff               = $_POST['sff'];
   }
   if(isset($_POST['dff'])){
   	    $_SESSION['dff']   = $_POST['dff'];
   	    $dff               = $_POST['dff'];
   }

   /*
   echo('<br><br><br><br><br>');
   echo('POST<br><pre>');  print_r($_POST);  echo('</pre>');
   echo('SESSION<br><pre>');  print_r($_SESSION);  echo('</pre>');
   echo('<br><pre>');  print_r(array('rl'=>$rl, 'rp'=>$rp));  echo('</pre>');
   */

   /*
   echo('<br>');echo('<br>');echo('<br>');echo('<br>');echo('<br>');echo('<br>');
   $tst_str = 'Тестовая строка TeSt!';
   $tsr_enc =  encrypt($tst_str, '91Ni81F');
   $tsr_dec =  decrypt($tsr_enc, '91Ni81F');
   echo($tst_str .'=>'. $tsr_enc);
   echo('<br>');echo('<br>');
   echo($tsr_enc .'=>'. $tsr_dec);
   echo('<br>');
   */

  ini_set('display_errors', '0');

  $bd_data = 'invalid';
  if(tep_db_connect($bds, $bdu, $bdp, $bd)){
     $_SESSION['bd_data'] = 'valid';
     $bd_data = 'valid';
     tep_db_set_utf8();
  }else{
  	 $_SESSION['bd_data'] = 'invalid';
  	 $bd_data = 'invalid';
  }

  ini_set('display_errors', '1');

  /*
  echo('$_SESSION<pre>'); print_r($_SESSION); echo('</pre>');
  echo('$bds->'.$bds.'<br>');
  */


?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.1.0/css/flag-icon.min.css" rel="stylesheet">
    <title>msc backup</title>
  </head>
  <body>
    <h1></h1>

    <div>
      <?php
        if( $bd_data == 'invalid' ){        	?>
        	<div class="row m-0">
        	 <div id="div_for_small_laguage" class="col-12 pr-4 text-right">
        	 </div>
        	</div>

        	<form class="form" method="POST">
              <div class="text-center mb-4">
                <div class="row m-0">

                  <div class="col-xl-5 col-lg-4 col-md-3 col-sm-2 col-1">
                  </div>

                  <div class="col-xl-2 col-lg-4 col-md-6 col-sm-8 col-10">
                       <div class="m-4 font-weight-bold"><?php echo($lng->int->data_for_connection); ?></div>

        	           <input type="text"  name="bds" class="form-control mb-2" value="<?php echo($bds); ?>" placeholder="<?php echo($lng->int->db_server); ?>" required autofocus>
                       <input type="text"  name="bdu" class="form-control mb-2" value="<?php echo($bdu); ?>" placeholder="<?php echo($lng->int->db_user); ?>" autofocus>
                       <input type="text"  name="bdp" class="form-control mb-2" value="<?php echo($bdp); ?>" placeholder="<?php echo($lng->int->db_pass); ?>" autofocus>
                       <input type="text"  name="bd"  class="form-control mb-2" value="<?php echo($bd); ?>" placeholder="<?php echo($lng->int->db); ?>" required autofocus>


                      <button class="btn btn-lg btn-primary btn-block" type="submit"><?php echo($lng->int->connect); ?></button>

                      <p class="mt-5 mb-3 text-muted text-center">&copy; 2020 mscdeveloper</p>

                  </div>

                  <div class="col-xl-5 col-lg-4 col-md-3 col-sm-2 col-1">
                  </div>

                </div>
             </div>
        	</form>

        	<?php
        }else{

           ?>

             <nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top m-0 mb-4 ">

                 <div class="navbar-brand font-weight-bold">MSCBackUP</div>

                 <ul class="navbar-nav mr-auto">
                    <!--
                    <li class="nav-item">
                       <a class="nav-link" href="#">Link 1</a>
                    </li>
                    <li class="nav-item">
                       <a class="nav-link" href="#">Link 2</a>
                    </li>
                    <li class="nav-item">
                       <a class="nav-link" href="#">Link 3</a>
                    </li>
                    -->
                    <li class="nav-item dropdown">
                       <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                             <?php echo($lng->int->work_type); ?>
                       </a>
                       <div class="dropdown-menu">
                          <div id="btn_mode_save_to_server" class="dropdown-item btn btn-light" style="cursor:pointer;"><?php echo($lng->int->save_backup); ?></div>
                          <div id="btn_mode_load_from_server" class="dropdown-item btn btn-light" style="cursor:pointer;"><?php echo($lng->int->load_backup); ?></div>
                          <div class="dropdown-divider"></div>
                          <div id="btn_mode_load_from_remote_server" class="dropdown-item btn btn-light" style="cursor:pointer;"><?php echo($lng->int->save_backup_remote); ?></div>
                          <div id="btn_mode_load_from_remote_server_files" class="dropdown-item btn btn-light" style="cursor:pointer;"><?php echo($lng->int->save_files_remote); ?></div>
                       </div>
                     </li>
                     <li id="nav_bar_lang" class="nav-item dropdown">
                     </li>
                  </ul>

                  <div id="nav_mode" class="nav-item font-weight-bold text-light d-inline my-2 my-lg-0">
                    <!-- Режим -> Сохранение на сервер -->
                  </div>

             </nav>





            <div class="row m-0"><div class="col-12 mt-4 mb-4">&nbsp;</div><div class="col-12 mt-4 mb-4 d-xs-block d-sm-none">&nbsp;</div></div>

             <div>

             </div>

             <div class="row m-1">
                <div class="mt-1 col-12 col-md-4 col-lg-3">

                   <div class="card">
                      <div class="card-header"><?php echo($lng->int->connection_from); ?></div>
                      <div class="card-body">

                         <div class="row">
                           <div class="col-6"><?php echo($lng->int->server_from); ?></div>
                           <div class="col-6"><?php echo($bds); ?></div>
                            <div class="col-12 border-top my-2"></div>
                           <div class="col-6"><?php echo($lng->int->user_from); ?></div> <!-- Пользователь: -->
                           <div class="col-6"><?php echo($bdu); ?></div>
                            <div class="col-12 border-top my-2"></div>
                           <div class="col-6"><?php echo($lng->int->pass_from); ?></div>    <!-- Пароль: -->
                           <div class="col-6"><?php echo($bdp); ?></div>
                            <div class="col-12 border-top my-2"></div>
                           <div class="col-6"><?php echo($lng->int->db_from); ?></div>   <!-- База: -->
                           <div class="col-6"><?php echo($bd); ?></div>
                         </div>

                         <div class="row action-modes" id="action_save_to_server">
                            <div class="col-12 border-top my-2"></div>
                           <div class="col-4"><?php echo($lng->int->backup_from); ?></div>        <!-- Backup: -->
                           <div class="col-8">
                              <input type="text"  id="backup" class="form-control" value="<?php echo($backup);?>" placeholder="<?php echo($lng->int->backup_name); ?>" required autofocus>
                           </div>
                            <div class="col-12 border-top my-2"></div>
                           <div class="col-12"><button class="btn btn-lg btn-success btn-block" onclick="save_all_tables();"><?php echo($lng->int->save); ?></button></div>   <!--  Сохранить  -->
                         </div>

                         <div class="row action-modes" id="action_load_from_server" style="display:none;">
                            <div class="col-12 border-top my-2"></div>
                           <div class="col-4"><?php echo($lng->int->backup_from); ?></div>                           <!-- Backup: -->
                           <div class="col-8" id="div_for_dd_backups"></div>

                           <div class="col-12 border-top my-2 cls-for-remove-backup"></div>
                           <div class="col-12 cls-for-remove-backup"><button class="btn btn-lg btn-success btn-block" onclick="restore_all_tables();"><?php echo($lng->int->restore); ?></button></div>   <!-- Восстановить -->
                           <div class="col-12 cls-for-remove-backup mt-2" ><button id="btn_remove_backup" class="btn btn-lg btn-success btn-danger btn-block"><?php echo($lng->int->remove_backup); ?></button></div>   <!-- Удалить BackUP -->

                         </div>





                          <form class="form row action-modes" id="action_load_from_remote_server" style="display:none;" method="POST" >


                            <div class="col-12 border-top my-2"></div>
                           <div class="col-4"><?php echo($lng->int->backup_from); ?></div>         <!-- Архив: -->
                           <div class="col-8">
                              <input type="text"  id="remote_backup" class="form-control" value="<?php echo($backup);?>" placeholder="<?php echo($lng->int->backup_name); ?>" required autofocus>  <!-- Имя архива -->
                           </div>

                             <div class="col-12 border-top my-2"></div>

                           <?php if(empty($rurl)){ ?>
                           <div class="col-12 mb-2">
                              <input type="text"  name="rurl" class="form-control" value="" placeholder="<?php echo($lng->int->program_remote_url); ?>" required autofocus>    <!-- MSCBackUP remote URL  -->
                           </div>
                           <?php }else{ ?>
                           <div class="col-6"><?php echo( $lng->int->program_remote_url_s ); ?></div>                      <!-- Удал. MSCBackUP: -->
                           <div class="col-6"><?php echo($rurl); ?></div>
                           <?php } ?>

                           <?php if(empty($rurl) && empty($rl) && empty($rp)){ ?>
                           <div class="col-12 mb-2">
                              <input type="text"  name="rl" class="form-control" value="" placeholder="<?php echo( $lng->int->login_remote_url ); ?>" required autofocus>   <!-- Login for remote URL  -->
                           </div>
                            <?php }else{ ?>
                            <div class="col-12 border-top my-2"></div>
                           <div class="col-6"><?php echo( $lng->int->login_remote_url_s ); ?></div>     <!--  Логин урл: -->
                           <div class="col-6"><?php echo($rl); ?></div>
                           <?php } ?>


                           <?php if(empty($rurl) && empty($rl) && empty($rp)){ ?>
                           <div class="col-12 mb-2">
                              <input type="text"  name="rp" class="form-control" value="" placeholder="<?php echo($lng->int->pass_remote_url); ?>" required autofocus>  <!-- PassWord for remote URL -->
                           </div>
                            <?php }else{ ?>
                            <div class="col-12 border-top my-2"></div>
                           <div class="col-6"><?php echo($lng->int->pass_remote_url_s); ?></div>    <!-- Пароль урл: -->
                           <div class="col-6"><?php echo($rp); ?></div>
                           <?php } ?>


                           <?php if(empty($rbds)){ ?>
                           <div class="col-12 mb-2">
                              <input type="text"  name="rbds" class="form-control" value="" placeholder="<?php echo($lng->int->remote_db_server); ?>" required autofocus>      <!-- Удал. сервер Б.Д. -->
                           </div>
                            <?php }else{ ?>
                            <div class="col-12 border-top my-2"></div>
                           <div class="col-6"><?php echo($lng->int->remote_db_server_s); ?></div>     <!-- Удал. сервер Б.Д.: -->
                           <div class="col-6"><?php echo($rbds); ?></div>
                           <?php } ?>


                           <?php if(empty($rbdu)){ ?>
                           <div class="col-12 mb-2">
                              <input type="text"  name="rbdu" class="form-control" value="" placeholder="<?php echo($lng->int->remote_db_user); ?>" autofocus>   <!--  Удал. пользователь Б.Д.  -->
                           </div>
                           <?php }else{ ?>
                            <div class="col-12 border-top my-2"></div>
                           <div class="col-6"><?php echo($lng->int->remote_db_user_s); ?></div>       <!--  Удал. пользователь Б.Д.  -->
                           <div class="col-6"><?php echo($rbdu); ?></div>
                           <?php } ?>

                           <?php if(empty($rbdp)){ ?>
                           <div class="col-12 mb-2">
                               <input type="text"  name="rbdp" class="form-control" value="" placeholder="<?php echo($lng->int->remote_db_pass); ?>" autofocus>    <!-- Удал. Пароль Б.Д. -->
                           </div>
                           <?php }else{ ?>
                            <div class="col-12 border-top my-2"></div>
                           <div class="col-6"><?php echo($lng->int->remote_db_pass_s); ?></div>       <!-- Удал. Пароль Б.Д. -->
                           <div class="col-6"><?php echo($rbdp); ?></div>
                           <?php } ?>


                           <?php if(empty($rbd)){ ?>
                           <div class="col-12 mb-2">
                               <input type="text"  name="rbd" class="form-control" value="" placeholder="<?php echo( $lng->int->remote_db ); ?>" required autofocus>   <!-- Удал. Б.Д. -->
                           </div>
                           <?php }else{ ?>
                             <div class="col-12 border-top my-2"></div>
                           <div class="col-6"><?php echo( $lng->int->remote_db_s ); ?></div>             <!-- Удал. Б.Д. -->
                           <div class="col-6"><?php echo($rbd); ?></div>
                           <?php } ?>

                           <div class="col-12 mt-2">
                             <?php if(empty($rurl) || empty($rbds) || empty($rbdu) || empty($rbd) ){?>
                              <button class="btn btn-lg btn-primary btn-block" type="submit"><?php echo( $lng->int->connect ); ?></button>     <!--  Подключиться  -->
                             <?php }?>


                           </div>

                         </form>
                         <div class="row mt-2 action-modes" id="action_load_from_remote_server_save" style="display:none;">
                           <div class="col-12">
                               <button class="btn btn-lg btn-success btn-block" onclick="save_all_remote_tables();"><?php echo( $lng->int->save_backup ); ?></button>   <!-- Сохранить  -->
                           </div>
                         </div>


                         <form class="form row action-modes" id="action_load_from_remote_server_files" style="display:none;" method="POST" >

                             <div class="col-12 border-top my-2"></div>

                           <?php if(empty($rurl)){ ?>
                           <div class="col-12 mb-2">
                              <input type="text"  name="rurl" class="form-control" value="" placeholder="<?php echo($lng->int->pass_remote_url); ?>" required autofocus>        <!-- MSCBackUP remote URL -->
                           </div>
                           <?php }else{ ?>
                           <div class="col-6"><?php echo($lng->int->pass_remote_url_s); ?></div>          <!-- Удал. MSCBackUP: -->
                           <div class="col-6"><?php echo($rurl); ?></div>
                           <?php } ?>

                           <?php if(empty($rurl) && empty($rl)){ ?>
                           <div class="col-12 mb-2">
                              <input type="text"  name="rl" class="form-control" value="" placeholder="<?php echo( $lng->int->login_remote_url ); ?>" required autofocus>       <!-- Login for remote URL -->
                           </div>
                            <?php }else{ ?>
                            <div class="col-12 border-top my-2"></div>
                           <div class="col-6"><?php echo( $lng->int->login_remote_url_s ); ?></div>     <!-- Login for remote URL -->
                           <div class="col-6"><?php echo($rl); ?></div>
                           <?php } ?>


                           <?php if(empty($rurl) && empty($rp)){ ?>
                           <div class="col-12 mb-2">
                              <input type="text"  name="rp" class="form-control" value="" placeholder="<?php echo($lng->int->pass_remote_url); ?>" required autofocus>
                           </div>
                            <?php }else{ ?>
                            <div class="col-12 border-top my-2"></div>
                           <div class="col-6"><?php echo($lng->int->pass_remote_url_s); ?></div>                 <!-- PassWord for remote URL  -->
                           <div class="col-6"><?php echo($rp); ?></div>
                           <?php } ?>


                           <?php if(empty($sff)){ ?>
                           <div class="col-12 mb-2">
                              <input type="text"  name="sff" class="form-control" value="" placeholder="<?php echo($lng->int->source_dir); ?>" required autofocus>                <!-- Source files folder  -->
                           </div>
                            <?php }else{ ?>
                            <div class="col-12 border-top my-2"></div>
                           <div class="col-6"><?php echo($lng->int->source_dir_s); ?></div>        <!-- Исх. папка: -->
                           <div class="col-6"><?php echo($sff); ?></div>
                           <?php } ?>

                           <?php if(empty($dff)){ ?>
                           <div class="col-12 mb-2">
                              <input type="text"  name="dff" class="form-control" value="" placeholder="<?php echo($lng->int->destination_dir); ?>" required autofocus>   <!-- Destination files folder  -->
                           </div>
                            <?php }else{ ?>
                            <div class="col-12 border-top my-2"></div>
                           <div class="col-6"><?php echo($lng->int->destination_dir_s); ?></div>       <!-- Прин. папка: -->
                           <div class="col-6"><?php echo($dff); ?></div>
                           <?php } ?>

                           <div class="col-12 mt-2">
                             <?php if(empty($rurl)|| empty($sff) ||  empty($dff) ){?>
                              <button class="btn btn-lg btn-primary btn-block" type="submit"><?php echo($lng->int->connect); ?></button>   <!-- Подключиться -->
                             <?php }?>
                           </div>


                         </form>

                         <div class="row mt-2 action-modes" id="action_load_from_remote_server_files_save" style="display:none;">
                           <div class="col-12">
                               <button class="btn btn-lg btn-success btn-block" onclick="save_all_remote_server_files();"><?php echo($lng->int->seve_files); ?></button>      <!--  Сохранить  -->
                           </div>
                         </div>


                         <div class="row">
                           <div class="col-12 m-0 mt-2">
                             <form class="form" method="POST">
                              <input type="hidden" name="action" value="logout">
                              <button class="btn btn-lg btn-outline-danger btn-block" type="submit"><?php echo($lng->int->exit); ?></button>  <!--  Выход  -->
                             </form>
                           </div>
                         </div>
                      </div>
                    </div>

                </div>
                <div class="mt-1 col-12 col-md-8 col-lg-9" id="action_data">
                  <!-- main content -->
                </div>
             </div>


             <div class="row m-0"><div class="col-12 mt-4 mb-4">&nbsp;</div><div class="col-12 mt-4 mb-4 d-xs-block d-sm-none">&nbsp;</div></div>

             <div class="navbar1 navbar-expand-sm bg-light navbar-dark fixed-bottom m-0 p-2">
                  <div class="row m-0">
                    <div id="footer" class="col-12 font-weight-bold pl-0 pr-0">
                       2020 &copy; mscdeveloper
                    </div>
                  </div>
             </div>



           <?php
        }
      ?>

    </div>




    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha384-tsQFqpEReu7ZLhBV2VZlAu7zcOV+rXbYlF2cqB8txI/8aZajjp4Bqd+V6D5IgvKT" crossorigin="anonymous"></script><!-- https://code.jquery.com/jquery-3.3.1.slim.min.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="includes/ajax.js"></script>
    <script src="includes/logic.js"></script>
    <?php if(empty($rurl) || empty($rbds) || empty($rbdu) || empty($rbd) ){ ?>
       <script>var GLOBAL_REMOTE_DATA_EXIST = false;</script>
    <?php }else{ ?>
       <script>var GLOBAL_REMOTE_DATA_EXIST = true;</script>
    <?php } ?>

    <?php if(empty($rurl) || empty($sff) || empty($dff) ){ ?>
        <script>var GLOBAL_REMOTE_DATA_FILES_EXIST = false;</script>
    <?php }else{ ?>
        <script>var GLOBAL_REMOTE_DATA_FILES_EXIST = true;</script>
    <?php } ?>




        <script>
            var lng = {};
            $(document).ready(function(){            	get_language('<?php echo($language); ?>', function(_data){            		lng = _data.lng;
            		<?php if((is_array($_POST) && count($_POST) == 0 && $bd_data == 'valid')||(isset($_POST['bds']) && $bd_data == 'valid')){ ?>
            		   $('#btn_mode_save_to_server').click();
            		<?php } ?>
            		<?php if(isset($_POST['sff']) || isset($_POST['dff'])){?>
            		     $('#btn_mode_load_from_remote_server_files').click();
            		<?php } ?>
            		<?php if( isset($_POST['rbds']) || isset($_POST['rbd'])){?>
            		     $('#btn_mode_load_from_remote_server').click();
            		<?php } ?>            	});
            	show_small_language_drop_down();
            });
        </script>


  </body>
</html>