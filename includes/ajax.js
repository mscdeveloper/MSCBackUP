var first_start = true;
var ajax_error = 0;
function send_ajax_post(_data,  _callback){
   $.ajax({
            url: "ajax.php",
            type: 'POST',
            data: _data,
            cache: false,
            processData: false,
            async:true,
            success: function (_data){
                if(_data.error && _data.error_description && !first_start){                	/* alert(_data.error_description);  */
                	console.log(_data);
                }
                first_start = false;
                ajax_error = 0;
                if (typeof _callback === "function"){
                      _callback(_data);
                }
            },

    error: function (jqXHR, exception) {
        var msg = '';
        if (jqXHR.status === 0) {
            msg = lng.ajax.not_connect;  /* Not connect.\n Verify Network. */
        } else if (jqXHR.status == 404) {
            msg = lng.ajax.not_found_404;     /* 'Requested page not found. [404]' */
        } else if (jqXHR.status == 500) {
            msg = lng.ajax.not_found_500;             /* 'Internal Server Error [500].' */
        } else if (exception === 'parsererror') {
            msg = lng.ajax.json_parse_error;     /* 'Requested JSON parse failed.' */
        } else if (exception === 'timeout') {
            msg = lng.ajax.timeout_error;    /* 'Time out error.' */
        } else if (exception === 'abort') {
            msg = lng.ajax.abort_error;  /* 'Ajax request aborted.' */
        } else {
            msg = lng.ajax.uncaught_error  + jqXHR.responseText;  /* 'Uncaught Error.\n' */
        }
        console.log(lng.ajax.ajax_error + ' => ' + msg);
        if(ajax_error < 7){          ajax_error++;
          console.log(lng.ajax.recuest_error_count+ajax_error);  /* 'ajax error count - ' */
          console.log(lng.ajax.wait_3_seconds);    /* 'Wait 3 seconds...' */
          setTimeout(function(){
             send_ajax_post(_data,  _callback);
          }, 3000);

        }else{        	console.log(lng.ajax.ajax_stop_each);      /* 'ajax loop stop...' */        	ajax_error = 0;
        }
    }

});
}
/*----------------------------------------------------------------------------*/
function set_cookie(_key, _value, _callback){
   var data = 'action=set_cookie&key='+_key+'&value='+_value;
   send_ajax_post(data, function (_data){
                if (typeof _callback === "function"){
                      _callback(_data);
                }
   });
}
/*----------------------------------------------------------------------------*/
function check_backup_empty(_callback){
   var data = 'action=check_backup_empty';
   send_ajax_post(data, function (_data){
                if (typeof _callback === "function"){
                      _callback(_data);
                }
   });
}
/*----------------------------------------------------------------------------*/
function clear_backup_folder(_callback){
   var data = 'action=clear_backup_folder';
   send_ajax_post(data, function (_data){
                if (typeof _callback === "function"){
                      _callback(_data);
                }
   });
}
/*----------------------------------------------------------------------------*/
function save_table(_table_name, _callback){
   var data = 'action=save_table&table_name='+_table_name;
   send_ajax_post(data, function (_data){                if (typeof _callback === "function"){
                      _callback(_data);
                }
   });
}
/*----------------------------------------------------------------------------*/
function save_table_part(_table_name, _start, _callback){
   var data = 'action=save_table_part&table_name='+_table_name+'&start='+_start;
   send_ajax_post(data, function (_data){                if (typeof _callback === "function"){
                      _callback(_data);
                }
                if(_data.saved_count==3000){                	var start = (_data.start)+3000;
                	save_table_part(_table_name, start, _callback);
                }
                show_total_progress(_data.saved_count);
   });
}
/*----------------------------------------------------------------------------*/
function get_all_backaps_names(_callback){
   var data = 'action=get_all_backaps_names';
   send_ajax_post(data, function (_data){
                if (typeof _callback === "function"){
                      _callback(_data);
                }
   });
}
/*----------------------------------------------------------------------------*/
function get_backup_tables(_callback){
   var data = 'action=get_backup_tables';
   send_ajax_post(data, function (_data){
                if (typeof _callback === "function"){
                      _callback(_data);
                }
   });
}
/*----------------------------------------------------------------------------*/
function get_db_tables(_callback){
   var data = 'action=get_db_tables';
   send_ajax_post(data, function (_data){
                if (typeof _callback === "function"){
                      _callback(_data);
                }
   });
}
/*----------------------------------------------------------------------------*/
function remove_backup(_backup, _callback){
   var data = 'action=remove_backup&backup='+_backup;
   send_ajax_post(data, function (_data){
                if (typeof _callback === "function"){
                      _callback(_data);
                }
   });
}
/*----------------------------------------------------------------------------*/
function restore_table_part(_table_name, _start, _callback){
   var data = 'action=restore_table_part&table_name='+_table_name+'&start='+_start;
   send_ajax_post(data, function (_data){
                if (typeof _callback === "function"){
                      _callback(_data);
                }

                if(_data.saved_count==3000){
                	var start = (_data.start)+3000;
                	restore_table_part(_table_name, start, _callback);
                }
                show_total_progress(_data.saved_count);
   });
}
/*----------------------------------------------------------------------------*/
function rename_table(_table_name, _callback){
   var data = 'action=rename_table&table_name='+_table_name;
   send_ajax_post(data, function (_data){
                if (typeof _callback === "function"){
                      _callback(_data);
                }
   });
}
/*----------------------------------------------------------------------------*/
function get_remote_db_tables(_callback){
   var data = 'action=get_remote_db_tables';
   send_ajax_post(data, function (_data){
                if (typeof _callback === "function"){
                      _callback(_data);
                }
   });
}

/*----------------------------------------------------------------------------*/
function get_remote_table_part(_table_name, _start, _callback){
   var data = 'action=get_remote_table_part&table_name='+_table_name+'&start='+_start;
   send_ajax_post(data, function (_data){
                if (typeof _callback === "function"){
                      _callback(_data);
                }
                if(_data.saved_count==3000){
                	var start = (_data.start)+3000;
                	get_remote_table_part(_table_name, start, _callback);
                }
                show_total_progress(_data.saved_count);
   });
}
/*----------------------------------------------------------------------------*/
function get_remote_files_in_dir(_callback){
   var data = 'action=get_remote_files_in_dir';
   send_ajax_post(data, function (_data){
                if (typeof _callback === "function"){
                      _callback(_data);
                }
   });
}
/*----------------------------------------------------------------------------*/
function save_file_from_remote(_file, _callback){
   var data = 'action=save_file_from_remote&file='+_file;
   send_ajax_post(data, function (_data){
                if (typeof _callback === "function"){
                      _callback(_data);
                }
   });
}
/*----------------------------------------------------------------------------*/
function save_table_correction(_table_name, _callback){
   var data = 'action=save_table_correction&table_name='+_table_name;
   send_ajax_post(data, function (_data){
                if (typeof _callback === "function"){
                      _callback(_data);
                }
   });
}
/*----------------------------------------------------------------------------*/
function save_table_correction_remote(_table_name, _callback){
   var data = 'action=save_table_correction_remote&table_name='+_table_name;
   send_ajax_post(data, function (_data){
                if (typeof _callback === "function"){
                      _callback(_data);
                }
   });
}
/*----------------------------------------------------------------------------*/
function get_languages(_callback){
   var data = 'action=get_languages';
   send_ajax_post(data, function (_data){
                if (typeof _callback === "function"){
                      _callback(_data);
                }
   });
}
/*----------------------------------------------------------------------------*/
function get_language(_language, _callback){
   var data = 'action=get_language&language='+_language;
   send_ajax_post(data, function (_data){
                if (typeof _callback === "function"){
                      _callback(_data);
                }
   });
}
/*----------------------------------------------------------------------------*/
function set_language(_language, _callback){
   var data = 'action=set_language&language='+_language;
   send_ajax_post(data, function (_data){
                if (typeof _callback === "function"){
                      _callback(_data);
                }
   });
}
/*----------------------------------------------------------------------------*/
