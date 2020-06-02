<?php

 $lng = (object)array();

 $lng->file = 'english';
 $lng->language = 'English';
 $lng->flag = 'flag-icon-us';

 $lng->int =(object)array();
 $lng->int->data_for_connection = 'Connection data:';
 $lng->int->db_server           = 'DataBase Server';
 $lng->int->db_user             = 'DataBase User';
 $lng->int->db_pass             = 'DataBase Password';
 $lng->int->db                  = 'DataBase';
 $lng->int->connect             = 'Connect';
 $lng->int->work_type           = 'Type Of Work';
 $lng->int->save_backup         = 'Save Backup to server';
 $lng->int->load_backup         = 'Load Backup From Server';
 $lng->int->save_backup_remote  = 'Save From Another Server';
 $lng->int->save_files_remote   = 'Seve Files From Another Server';
 $lng->int->connection_from     = 'Connection Data:';
 $lng->int->server_from         = 'Server:';
 $lng->int->user_from           = 'User:';
 $lng->int->pass_from           = 'Pass:';
 $lng->int->db_from             = 'DB Name:';
 $lng->int->backup_from         = 'Backup:';
 $lng->int->backup_name         = 'Backup Name';
 $lng->int->save                = 'Save';
 $lng->int->restore             = 'Restore';
 $lng->int->remove_backup       = 'Remove BakUp';
 $lng->int->program_remote_url  = 'MSCBackUP remote URL';
 $lng->int->program_remote_url_s= 'Remote MSCBackUP:';
 $lng->int->login_remote_url    = 'Login for remote URL';
 $lng->int->login_remote_url_s  = 'URL Login:';
 $lng->int->pass_remote_url     = 'Pass For URL';
 $lng->int->pass_remote_url_s   = 'Url Pass:';
 $lng->int->remote_db_server    = 'Remote DB Server';
 $lng->int->remote_db_server_s  = 'Remote DB Server:';
 $lng->int->remote_db_user      = 'Remote DB User';
 $lng->int->remote_db_user_s    = 'Remote DB User:';
 $lng->int->remote_db_pass      = 'Remote DB Password';
 $lng->int->remote_db_pass_s    = 'Remote DB Pass:';
 $lng->int->remote_db           = 'Remote DataBase';
 $lng->int->remote_db_s         = 'Remote DB:';
 $lng->int->save_backup         = 'Save Backup';
 $lng->int->source_dir          = 'Sourse Dir. On Remote Server';
 $lng->int->source_dir_s        = 'Sourse Dir.:';
 $lng->int->source_dir          = 'Sourse Dir. On Remote Server';
 $lng->int->source_dir_s        = 'Sourse Dir.:';
 $lng->int->destination_dir     = 'Destination Dir. On This Server';
 $lng->int->destination_dir_s   = 'Destin. Dir.:';
 $lng->int->seve_files          = 'Save Files';
 $lng->int->exit                = 'Exit';


 $lng->ajax                     = (object)array();

 $lng->ajax->connect_data_error = 'Data for DB connect not found...';
 $lng->ajax->connect_error      = 'Error cnection to BD server...';
 $lng->ajax->cookie_ok          = 'Create Cookie done...';
 $lng->ajax->cookie_error       = 'Error of create Cookie...';
 $lng->ajax->error_create_folder= 'Create folder error ';
 $lng->ajax->folder             = 'Folder';
 $lng->ajax->not_found          = 'Not Found';
 $lng->ajax->empty              = 'is empty';
 $lng->ajax->files_exist        = 'files exist';
 $lng->ajax->not_found          = 'not found';
 $lng->ajax->from_table         = 'From table';
 $lng->ajax->save_ok            = 'saved successfully';
 $lng->ajax->rows               = 'rows';
 $lng->ajax->to_table           = 'To table';
 $lng->ajax->success_imported   = 'successfully imported';
 $lng->ajax->table_rename_ok    = 'The table was successfully renamed ...';
 $lng->ajax->signature_error    = 'Signature Error...';
 $lng->ajax->files              = 'List of files...';
 $lng->ajax->file_not_found     = 'File not found...';
 $lng->ajax->file_copy_ok       = 'File copied successfully...';
 $lng->ajax->file_copy_error    = 'An error occurred while copying ...';
 $lng->ajax->files_found        = 'Files found';
 $lng->ajax->empty_post         = 'Empty POST request';
 $lng->ajax->post_not_resolve   = 'POST request not processed';

 $lng->ajax->not_connect        = 'Not connect. Verify Network.';
 $lng->ajax->not_found_404      = 'Requested page not found. [404]';
 $lng->ajax->not_found_500      = 'Internal Server Error [500].';
 $lng->ajax->json_parse_error   = 'Requested JSON parse failed.';
 $lng->ajax->timeout_error      = 'Time out error.' ;
 $lng->ajax->abort_error        = 'Ajax request aborted.';
 $lng->ajax->uncaught_error     = 'Uncaught Error. ';
 $lng->ajax->ajax_error         = 'ajax error';
 $lng->ajax->recuest_error_count= 'ajax error count - ';
 $lng->ajax->wait_3_seconds     = 'Wait 3 seconds...';
 $lng->ajax->ajax_stop_each     = 'AJAX Request STOPPED...';

 $lng->logic                    =  (object)array();
 $lng->logic->q_remove_arhive   = '\nThe archive will be deleted ... \n\nDo you want to continue?';
 $lng->logic->remove_arhive_err = 'Error deleting archive:\n';
 $lng->logic->q_overwrite_arhive= '\n\nContinuation will overwrite archov ... \n\nDo you want to continue?';
 $lng->logic->backups_read_error= 'An error occurred while getting the list of backups';
 $lng->logic->backup            = 'Backup';
 $lng->logic->found_s           = 'found';
 $lng->logic->tables            = 'table(s)';
 $lng->logic->found             = 'Found';
 $lng->logic->rows              = 'rows';
 $lng->logic->table             = 'Table';
 $lng->logic->size              = 'Size';
 $lng->logic->datebase          = 'Database';
 $lng->logic->remote            = 'Remote';
 $lng->logic->out_of            = 'out of';
 $lng->logic->elapsed_time      = 'elapsed time';
 $lng->logic->dir               = 'directory';
 $lng->logic->found_liles       = 'files found';
 $lng->logic->file              = 'File';
 $lng->logic->date              = 'Date';
 $lng->logic->mode              = 'Mode';
 $lng->logic->backup_not_select = 'BackUP not select';
 $lng->logic->backup_choice     = 'Select BackUP to restore ...';
 $lng->logic->data_for_connect  = 'Connection Data';
 $lng->logic->input_data_connect= 'Enter the data to connect to the remote server';
 $lng->logic->error_delete      = 'Error deleting archive';
 $lng->logic->q_delete_archive  = 'Are you sure you want to delete the archive';
 $lng->logic->supplemented_by   = 'supplemented by';
 $lng->logic->pcs               = 'pcs';
 $lng->logic->correction        = 'Correction';

?>