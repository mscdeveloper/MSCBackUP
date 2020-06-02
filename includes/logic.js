/*----------------------------------------------------------------------------*/
function format_number(_number){
  var str = Math.floor(_number)+'';
  var sub = str.substring(str.length-3, str.length);
  newstr = ''+sub;
  var i = 1;
  while (sub.length >= 3){
    sub = str.substring(str.length-((i+1)*3),str.length-(i*3));
    newstr = sub + ' ' + newstr;
    i+=1;
  }
  return newstr;
}
/*----------------------------------------------------------------------------*/
function scroll_to_table_el(_table_name){
  var table_el;
  $('.cls-table-name:contains("'+_table_name+'")').each(function(){  	  if($(this).text() == _table_name){  	  	  table_el = $(this);
  	  }  });  $('html, body').stop();
  $('html, body').animate({
  	 scrollTop: ( table_el.offset().top - 100 )
  }, 600);
}
/*----------------------------------------------------------------------------*/
/*----------------------------------------------------------------------------*/
/*----------------------------------------------------------------------------*/
/*----------------------------------------------------------------------------*/
/*----------------------------------------------------------------------------*/
/*----------------------------------------------------------------------------*/
/*----------------------------------------------------------------------------*/
/*----------------------------------------------------------------------------*/
/*----------------------------------------------------------------------------*/
/*----------------------------------------------------------------------------*/
function save_table(_table, _callback){


  scroll_to_table_el(_table);
  save_table_part(_table, 0, function(_data){
	 console.log(_data);



	 var table_rows = $('#div_for_table_'+_data.table).attr('table_rows');
	 table_rows = parseInt(table_rows)||0;
	 var count_of_posts = 1;
	 if(table_rows>0){
	 	count_of_posts =  Math.ceil(table_rows/3000);
	 }
	 var percents = Math.ceil((100/count_of_posts)*_data.file_nr);

	 if(percents >99){percents = 100;}
	 if(_data.saved_count<3000){
	 	percents = 100;
	 	count_of_posts = _data.file_nr;
	 }
	 var progress_text =  percents + '%';
	 var progress_bg = 'bg-danger';
	 if(percents>20){
	 	 progress_text = _data.file_nr +' из '+count_of_posts+ ' ('+ percents +'%)';
	 }
	 if(percents>25){
	 	 progress_bg = 'bg-warning';
	 }
	 if(percents>50){
	 	progress_bg = 'bg-info';
	 }
	 if(percents>75){
	 	progress_bg = 'bg-success';
	 }
	 var progress = '';
     progress += '<div class="progress" style="height:25px;">';
       progress += '<div class="progress-bar '+progress_bg+'  progress-bar-striped" style="width:'+percents+'%; height:25px;">'+progress_text+'</div>';
     progress += '</div>';
	 $('#div_for_table_'+_data.table).html(progress);
	 if (_data.saved_count<3000 && typeof _callback === "function"){	 	_callback(_data);
	 }
  });

}
/*----------------------------------------------------------------------------*/
function save_all_tables(_old_table){
	_old_table = _old_table || '';
	if(_old_table == ''){	   var backup = $('#backup').val();
       set_cookie('backup', backup);
       total_load_rows=0;
       total_load_posts=0;
	}

	var table_name = '';
	var table_index = 0;
	var tables_arr = [];	$('.cls-table-name').each(function(){		var table_name = $(this).text();
		var cb = $(this).parent().find('.custom-control-input');
		if(cb[0].checked){
		   tables_arr.push(table_name);
        }	});
	if(_old_table == ''){		table_name = tables_arr[0];
	}else if(_old_table == tables_arr[tables_arr.length-1]){		/* last table */
		correction_all_tables();
	}else{		for(var key in tables_arr){			if(_old_table == tables_arr[key]){				table_name = tables_arr[(parseInt(key)+1)];
			}
		}
	}

	if(_old_table == ''){
	   check_backup_empty(function(_cbe_data){	   	   if(_cbe_data.error == 1){	   	   	   if(confirm(_cbe_data.result + lng.logic.q_remove_arhive)) {     /* '\nБудет произведено удаление архива...\n\nВы хотите продолжить?' */
		            clear_backup_folder(function(_cbe2_data){
		                if(_cbe2_data.error == 1){
		                    if(confirm(lng.logic.remove_arhive_err  +_cbe2_data.result + lng.logic.q_overwrite_arhive)) {        /* 'Ошибка удаления архива:\n'   \n\nПродолжение приведет к перезаписи архова...\n\nВы хотите продолжить?  */
		                        save_table(table_name, function(_data){
			                       save_all_tables(_data.table);
		                        });
		                     }else{		                     	return false;
		                     }
		                 }else{		                     save_table(table_name, function(_data){
			                    save_all_tables(_data.table);
		                     });
		                 }
		             });
	   	       }else{	   	       	 return false;
	   	       }
	   	   }else{
		        save_table(table_name, function(_data){
			       save_all_tables(_data.table);
		        });
	       }
	   });
	}else{
	  if(table_name != ''){		   save_table(table_name, function(_data){			    save_all_tables(_data.table);		   });
	  }
    }
}
/*----------------------------------------------------------------------------*/
function restore_table(_table, _callback){

   scroll_to_table_el(_table);

  restore_table_part(_table, 0, function(_data){
	 console.log(_data);

	 var table_rows = $('#div_for_table_'+_data.table).attr('table_rows');
	 table_rows = parseInt(table_rows)||0;
	 var count_of_posts = 1;
	 if(table_rows>0){
	 	count_of_posts =  Math.ceil(table_rows/3000);
	 }
	 var percents = Math.ceil((100/count_of_posts)*_data.file_nr);

	 if(percents >99){percents = 100;}
	 if(_data.saved_count != 3000){
	 	percents = 100;
	 	count_of_posts = _data.file_nr;
	 }
	 var progress_text =  percents + '%';
	 var progress_bg = 'bg-danger';
	 if(percents>20){
	 	 progress_text = _data.file_nr +' из '+count_of_posts+ ' ('+ percents +'%)';
	 }
	 if(percents>25){
	 	 progress_bg = 'bg-warning';
	 }
	 if(percents>50){
	 	progress_bg = 'bg-info';
	 }
	 if(percents>75){
	 	progress_bg = 'bg-success';
	 }
	 var progress = '';
     progress += '<div class="progress" style="height:25px;">';
       progress += '<div class="progress-bar '+progress_bg+'  progress-bar-striped" style="width:'+percents+'%; height:25px;">'+progress_text+'</div>';
     progress += '</div>';
	 $('#div_for_table_'+_data.table).html(progress);
	 if (_data.saved_count != 3000 && typeof _callback === "function"){	 	 rename_table(_data.table, function(_rename_data){	 	 	console.log(_rename_data);
	 	 	_callback(_data);	 	 });

	 }
  });

}
/*----------------------------------------------------------------------------*/
function restore_all_tables(_old_table){
	_old_table = _old_table || '';
	/*
	if(_old_table == ''){
	   var backup = $('#backup').val();
         set_cookie('backup', backup);
	}
    */
    if(_old_table == ''){
       total_load_rows=0;
       total_load_posts=0;
    }
	var table_name = '';
	var table_index = 0;
	var tables_arr = [];
	$('.cls-table-name').each(function(){
		var table_name = $(this).text();
		var cb = $(this).parent().find('.custom-control-input');
		if(cb[0].checked){
		   tables_arr.push(table_name);
        }
	});
	if(_old_table == ''){
		table_name = tables_arr[0];
	}else if(_old_table == tables_arr[tables_arr.length-1]){
		/* last table */
	}else{
		for(var key in tables_arr){
			if(_old_table == tables_arr[key]){
				table_name = tables_arr[(parseInt(key)+1)];
			}
		}
	}




	  if(table_name != ''){
		   restore_table(table_name, function(_data){
			    restore_all_tables(_data.table);
		   });
	  }

}
/*----------------------------------------------------------------------------*/
/*----------------------------------------------------------------------------*/
function save_remote_table(_table, _callback){

  scroll_to_table_el(_table);

  get_remote_table_part(_table, 0, function(_data){
	 console.log(_data);

	 var table_rows = $('#div_for_table_'+_data.table).attr('table_rows');
	 table_rows = parseInt(table_rows)||0;
	 var count_of_posts = 1;
	 if(table_rows>0){
	 	count_of_posts =  Math.ceil(table_rows/3000);
	 }
	 var percents = Math.ceil((100/count_of_posts)*_data.file_nr);

	 if(percents >99){percents = 100;}
	 if(_data.saved_count<3000){
	 	percents = 100;
	 	count_of_posts = _data.file_nr;
	 }
	 var progress_text =  percents + '%';
	 var progress_bg = 'bg-danger';
	 if(percents>20){
	 	 progress_text = _data.file_nr +' из '+count_of_posts+ ' ('+ percents +'%)';
	 }
	 if(percents>25){
	 	 progress_bg = 'bg-warning';
	 }
	 if(percents>50){
	 	progress_bg = 'bg-info';
	 }
	 if(percents>75){
	 	progress_bg = 'bg-success';
	 }
	 var progress = '';
     progress += '<div class="progress" style="height:25px;">';
       progress += '<div class="progress-bar '+progress_bg+'  progress-bar-striped" style="width:'+percents+'%; height:25px;">'+progress_text+'</div>';
     progress += '</div>';
	 $('#div_for_table_'+_data.table).html(progress);
	 if (_data.saved_count<3000 && typeof _callback === "function"){
	 	_callback(_data);
	 }
  });

}
/*----------------------------------------------------------------------------*/
function save_all_remote_tables(_old_table){
	_old_table = _old_table || '';
	if(_old_table == ''){
	   var backup = $('#remote_backup').val();
       set_cookie('backup', backup);
       total_load_rows=0;
       total_load_posts=0;
	}

	var table_name = '';
	var table_index = 0;
	var tables_arr = [];
	$('.cls-table-name').each(function(){
		var table_name = $(this).text();
		var cb = $(this).parent().find('.custom-control-input');
		if(cb[0].checked){
		   tables_arr.push(table_name);
        }
	});
	if(_old_table == ''){
		table_name = tables_arr[0];
	}else if(_old_table == tables_arr[tables_arr.length-1]){
		/* last table */
		correction_all_tables_remote();
	}else{
		for(var key in tables_arr){
			if(_old_table == tables_arr[key]){
				table_name = tables_arr[(parseInt(key)+1)];
			}
		}
	}


	if(_old_table == ''){
	   check_backup_empty(function(_cbe_data){
	   	   if(_cbe_data.error == 1){
	   	   	   if(confirm(_cbe_data.result + lng.logic.q_remove_arhive)) {               /* '\nБудет произведено удаление архива...\n\nВы хотите продолжить?' */
		            clear_backup_folder(function(_cbe2_data){
		                if(_cbe2_data.error == 1){
		                    if(confirm(lng.logic.remove_arhive_err +_cbe2_data.result + lng.logic.q_overwrite_arhive)) {     /* 'Ошибка удаления архива:\n'   '\n\nПродолжение приведет к перезаписи архова...\n\nВы хотите продолжить?'*/
		                        save_remote_table(table_name, function(_data){
			                       save_all_remote_tables(_data.table);
		                        });
		                     }else{
		                     	return false;
		                     }
		                 }else{
		                     save_remote_table(table_name, function(_data){
			                    save_all_remote_tables(_data.table);
		                     });
		                 }
		             });
	   	       }else{
	   	       	 return false;
	   	       }
	   	   }else{
		        save_remote_table(table_name, function(_data){
			       save_all_remote_tables(_data.table);
		        });
	       }
	   });
	}else{
	  if(table_name != ''){
		   save_remote_table(table_name, function(_data){
			    save_all_remote_tables(_data.table);
		   });
	  }
    }
}
/*----------------------------------------------------------------------------*/
/*----------------------------------------------------------------------------*/
/*----------------------------------------------------------------------------*/
/*----------------------------------------------------------------------------*/
/*----------------------------------------------------------------------------*/
function get_backups_drop_down(){	$('.cls-for-remove-backup').hide();	get_all_backaps_names(function (_data){
             if(_data.error == 0){             	var out = '';
                out += '<button class="btn btn-sm btn btn-light btn-block dropdown-toggle" href="#" id="dd_backups" data-toggle="dropdown">';
                out += 'Backup...';
                out += '</button>';
                out += '<div class="dropdown-menu">';
                 if(_data.backups.length == 0){                      out += '<div>~ не найдено ~</div>';
                 }else{
                     for(var key in _data.backups){
                       out += '<div id="btn_mode_save_to_server" class="dropdown-item btn btn-light" onclick="show_data_action_for_backup(\''+_data.backups[key]+'\');" style="cursor:pointer;">'+_data.backups[key]+'</div>';
                     }
                 }
                out += '</div>';
                $('#div_for_dd_backups').html(out);
             }else{             	if(_data.error_description){             	    alert(_data.error_description);
             	}else{             	    alert();     /* 'В процессе получения списка BackUp-ов произошла ошибка' */
             	}
             	return false;
             }


	});
}
/*----------------------------------------------------------------------------*/
function show_data_action_for_backup(_backup_name){	$('#dd_backups').html(_backup_name);
	set_cookie('backup', _backup_name);
	$('#action_data').empty();
	$('#action_data').html('<div class="spinner-grow text-dark mr-2" style="background-color:#5b5b5b;"></div><div class="spinner-grow text-muted mr-2" style="background-color:#7b7b7b;"></div><div class="spinner-grow text-light mr-2" style="background-color:#9b9b9b;"></div><div class="spinner-grow text-light mr-2" style="background-color:#b9b9b9;"></div><div class="spinner-grow text-light mr-2" style="background-color:#cbcbcb;"></div>');
	$('.cls-for-remove-backup').hide();
	var out = '';
	out += '';
    get_backup_tables(function (_data){    	$('#action_data').empty();
    	var tables_len = Object.keys(_data.tables).length;
    	var total_feilds = 0;
    	for(var key in _data.tables){    		total_feilds += parseInt(_data.tables[key].feilds) || 0;
    	}
    	var total_feilds_formated = format_number(total_feilds);    	out += '<div class="card">';
    	   out += '<div class="card-header">'+lng.logic.backup+' <span class="font-weight-bold text-info">'+_backup_name+'</span> '+lng.logic.found_s+' - <span class="font-weight-bold text-info">'+tables_len+'</span> '+lng.logic.tables+'. '+lng.logic.found+' <span class="font-weight-bold text-info">'+ total_feilds_formated+'</span> '+lng.logic.rows+'</div>';
    	   out += '<div class="card-body">';
    	     out += '<div class="row">';
                            out += '<div class="col-6">';
                                   out += '<div class="custom-control custom-checkbox">';
                                     out += '<input type="checkbox" class="custom-control-input" id="cb_for_all" checked>';
                                     out += '<label class="custom-control-label" for="cb_for_all">'+lng.logic.table+'</label>';    /* Таблица */
                                   out += '</div>';
                            out += '</div>';
                            out += '<div class="col-6 col-xl-2 text-right">'+lng.logic.size+'</div>';   /* Размер */
                            out += '<div class="col-12 col-xl-4"> </div>';
                              out += '<div class="col-12 border-top my-2"></div>';

    	                    for(var key in _data.tables){

                              out += '<div class="col-6 font-weight-bold">';
                                 out += '<span>';
                                  out += '<div class="custom-control custom-checkbox">';
                                    out += '<input type="checkbox" class="custom-control-input" id="cb_for_'+key+'" checked>';
                                    out += '<label class="custom-control-label cls-table-name" for="cb_for_'+key+'">'+_data.tables[key].table+'</label>';
                                  out += '</div>';
                                 out += '</span>';
                              out += '</div>';
                              out += '<div class="col-6 col-xl-2 text-right font-weight-bold">'+_data.tables[key].feilds_formated+'</div>';
                              out += '<div class="col-12 col-xl-4 font-weight-bold" table_rows="'+_data.tables[key].feilds+'" id="div_for_table_'+_data.tables[key].table+'"></div>';

                               out += '<div class="col-12 border-top my-2"></div>';
    	                    }

    	      out += '</div>';
    	    out += '</div>';
    	out += '</div>';



        $('#action_data').html(out);
        for(var key in _data.tables_bad){        	var bad_table = _data.tables_bad[key].table;
        	$('.cls-table-name').filter(function(){return this.innerHTML == bad_table;}).css('color','red');
        }
        $('.cls-for-remove-backup').show();
    });


}
/*----------------------------------------------------------------------------*/
function show_data_action_for_db(){
	$('#action_data').empty();
	$('.cls-for-remove-backup').hide();
	var out = '';
	out += '';
    get_db_tables(function (_data){
    	var tables_len = Object.keys(_data.tables).length;
    	var total_feilds = 0;
    	for(var key in _data.tables){
    		total_feilds += parseInt(_data.tables[key].feilds) || 0;
    	}
    	var total_feilds_formated = format_number(total_feilds);
    	out += '<div class="card">';
    	   out += '<div class="card-header">'+lng.logic.datebase+' <span class="font-weight-bold text-info">'+_data.db+'</span> '+lng.logic.found_s+' - <span class="font-weight-bold text-info">'+tables_len+'</span> '+lng.logic.tables+'. '+lng.logic.found+' <span class="font-weight-bold text-info">'+ total_feilds_formated+'</span> '+lng.logic.rows+'</div>';
    	   out += '<div class="card-body">';
    	     out += '<div class="row">';
                            out += '<div class="col-6">';
                                   out += '<div class="custom-control custom-checkbox">';
                                     out += '<input type="checkbox" class="custom-control-input" id="cb_for_all" checked>';
                                     out += '<label class="custom-control-label" for="cb_for_all">'+lng.logic.table+'</label>'; /* Таблица */
                                   out += '</div>';
                            out += '</div>';
                            out += '<div class="col-6 col-xl-2 text-right">'+lng.logic.size+'</div>';    /* Размер */
                            out += '<div class="col-12 col-xl-4"> </div>';
                              out += '<div class="col-12 border-top my-2"></div>';

    	                    for(var key in _data.tables){


                              out += '<div class="col-6 font-weight-bold">';
                                 out += '<span>';
                                  out += '<div class="custom-control custom-checkbox">';
                                    out += '<input type="checkbox" class="custom-control-input" id="cb_for_'+key+'" checked>';
                                    out += '<label class="custom-control-label cls-table-name" for="cb_for_'+key+'">'+_data.tables[key].table+'</label>';
                                  out += '</div>';
                                 out += '</span>';
                              out += '</div>';
                              out += '<div class="col-6 col-xl-2 text-right font-weight-bold">'+_data.tables[key].feilds_formated+'</div>';
                              out += '<div class="col-12 col-xl-4 font-weight-bold" table_rows="'+_data.tables[key].feilds+'" id="div_for_table_'+_data.tables[key].table+'"></div>';

                               out += '<div class="col-12 border-top my-2"></div>';
    	                    }

    	      out += '</div>';
    	    out += '</div>';
    	out += '</div>';



        $('#action_data').html(out);
    });


}
/*----------------------------------------------------------------------------*/
function show_data_action_for_remote_db(){
	$('#action_data').empty();
	$('.cls-for-remove-backup').hide();
	var out = '';
	out += '';
    get_remote_db_tables(function (_data){
        $('#action_load_from_remote_server_save').show();  /*new!!!*/
    	var tables_len = Object.keys(_data.tables).length;
    	var total_feilds = 0;
    	for(var key in _data.tables){
    		total_feilds += parseInt(_data.tables[key].feilds) || 0;
    	}
    	var total_feilds_formated = format_number(total_feilds);
    	out += '<div class="card">';
    	   out += '<div class="card-header"><span class="font-weight-bold text-warning">'+lng.logic.remote+'</span> '+lng.logic.datebase+' <span class="font-weight-bold text-info">'+_data.db+'</span> '+lng.logic.found_s+' - <span class="font-weight-bold text-info">'+tables_len+'</span> '+lng.logic.tables+'. '+lng.logic.found+' <span class="font-weight-bold text-info">'+ total_feilds_formated+'</span> '+lng.logic.rows+'</div>';
    	   out += '<div class="card-body">';
    	     out += '<div class="row">';
                            out += '<div class="col-6">';
                                   out += '<div class="custom-control custom-checkbox">';
                                     out += '<input type="checkbox" class="custom-control-input" id="cb_for_all" checked>';
                                     out += '<label class="custom-control-label" for="cb_for_all">'+lng.logic.table+'</label>';    /* Таблица */
                                   out += '</div>';
                            out += '</div>';
                            out += '<div class="col-6 col-xl-2 text-right">'+lng.logic.size+'</div>';   /* Размер */
                            out += '<div class="col-12 col-xl-4"> </div>';
                              out += '<div class="col-12 border-top my-2"></div>';

    	                    for(var key in _data.tables){


                              out += '<div class="col-6 font-weight-bold">';
                                 out += '<span>';
                                  out += '<div class="custom-control custom-checkbox">';
                                    out += '<input type="checkbox" class="custom-control-input" id="cb_for_'+key+'" checked>';
                                    out += '<label class="custom-control-label cls-table-name" for="cb_for_'+key+'">'+_data.tables[key].table+'</label>';
                                  out += '</div>';
                                 out += '</span>';
                              out += '</div>';
                              out += '<div class="col-6 col-xl-2 text-right font-weight-bold">'+_data.tables[key].feilds_formated+'</div>';
                              out += '<div class="col-12 col-xl-4 font-weight-bold" table_rows="'+_data.tables[key].feilds+'" id="div_for_table_'+_data.tables[key].table+'"></div>';

                               out += '<div class="col-12 border-top my-2"></div>';
    	                    }

    	      out += '</div>';
    	    out += '</div>';
    	out += '</div>';



        $('#action_data').html(out);
    });


}
/*----------------------------------------------------------------------------*/
var total_load_rows=0;
var total_load_posts=0;
var total_start_time;
var total_end_time;
function show_total_progress(_load_rows){	if(total_load_posts == 0){		$('#footer').parent().parent().show();
		total_start_time = new Date();
	}	total_load_rows += _load_rows;	var tables_arr = [];
	var toral_rows = 0;
	var total_posts = 0
	$('.cls-table-name').each(function(){
		var table_name = $(this).text();
		var cb = $(this).parent().find('.custom-control-input');
		var table_rows = $(this).parent().parent().parent().next().text();
		table_rows = table_rows.replace(new RegExp(" ","g"), "");
		table_rows = parseInt(table_rows)||0;
		var table_posts = 1;
		if(table_rows>0){
		  table_posts = Math.ceil(table_rows/3000);
		}
		if(cb[0].checked){
		   tables_arr.push({'table' : table_name, 'rows' : table_rows, 'posts':table_posts});
		   toral_rows += table_rows;
		   total_posts += table_posts;
        }
	});
	total_load_posts++;
	/* console.log(toral_rows);*/
	var total_percent = Math.ceil(100/toral_rows * total_load_rows);
	if(total_percent > 100){total_percent=100;}
	/*console.log(total_percent);*/


    total_end_time = new Date();
    var timeDiff = total_end_time - total_start_time;
    timeDiff /= 1000;
    var seconds = Math.round(timeDiff);

    var h = Math.floor(seconds / 3600);
    seconds %= 3600;
    var m = Math.floor(seconds / 60);
    var s = seconds % 60;

    var elapsed_time = '';
    if(h>0){    	if(h<10){h='0'+h;}
    	if(m<10){m='0'+m;}
    	if(s<10){s='0'+s;}    	elapsed_time = h + ':' + m + ':' + s;
    }else if(m>0){    	if(m<10){m='0'+m;}
    	if(s<10){s='0'+s;}    	elapsed_time =  m + ':' + s;
    }else if(s>0){    	if(s<10){s='0'+s;}    	elapsed_time =  s +' сек.';
    }



	 var progress_text =  total_percent + '%';
	 var progress_bg = 'bg-danger';
	 if(total_percent>5){	 	progress_text =  total_percent + '% (' + elapsed_time+ ')';
	 }
	 if(total_percent>20){
	 	 progress_text = total_load_posts +' '+lng.logic.out_of+' '+total_posts+ ' ('+ total_percent +'%) '+lng.logic.elapsed_time+' ' + elapsed_time;   /* из   затрачено времени */
	 }
	 if(total_percent>25){
	 	 progress_bg = 'bg-warning';
	 }
	 if(total_percent>50){
	 	progress_bg = 'bg-info';
	 }
	 if(total_percent>75){
	 	progress_bg = 'bg-success';
	 }
	 var progress = '';
     progress += '<div class="progress" style="height:25px;">';
       progress += '<div class="progress-bar '+progress_bg+'  progress-bar-striped" style="width:'+total_percent+'%; height:25px;">'+progress_text+'</div>';
     progress += '</div>';
	 $('#footer').html(progress);
}
/*----------------------------------------------------------------------------*/
function show_data_action_for_remote_files(){
	$('#action_data').empty();
	$('#action_data').html('<div class="spinner-grow text-dark mr-2" style="background-color:#5b5b5b;"></div><div class="spinner-grow text-muted mr-2" style="background-color:#7b7b7b;"></div><div class="spinner-grow text-light mr-2" style="background-color:#9b9b9b;"></div><div class="spinner-grow text-light mr-2" style="background-color:#b9b9b9;"></div><div class="spinner-grow text-light mr-2" style="background-color:#cbcbcb;"></div>');
	//$('#action_load_from_remote_server_files_save').hide();
	var out = '';
	out += '';
    get_remote_files_in_dir(function (_data){
        $('#action_load_from_remote_server_files_save').show();  /*new!!!*/
        var total_files = Object.keys(_data.files).length;
    	out += '<div class="card">';
    	   out += '<div class="card-header"><span class="font-weight-bold text-warning">'+lng.logic.remote+'</span> '+lng.logic.dir+' <span class="font-weight-bold text-info">'+_data.remote_dir+'</span> '+lng.logic.found_liles+' - <span class="font-weight-bold text-info">'+total_files+'</span>  </div>';
    	   out += '<div class="card-body">';
    	     out += '<div class="row">';
                            out += '<div class="col-6">';
                                   out += '<div class="custom-control custom-checkbox">';
                                     out += '<input type="checkbox" class="custom-control-input" id="cb_for_all" checked>';
                                     out += '<label class="custom-control-label" for="cb_for_all">'+lng.logic.file+'</label>';        /* Файл */
                                   out += '</div>';
                            out += '</div>';
                            out += '<div class="col-6 col-xl-2 text-right">'+lng.logic.date+'</div>';   /* Дата */
                            out += '<div class="col-12 col-xl-4"> </div>';
                              out += '<div class="col-12 border-top my-2"></div>';

    	                    for(var key in _data.files){
                              var file_name = '~пусто~';
                              if(_data.files[key].file){
    	                      var file_name_arr = (_data.files[key].file).split('/');
    	                      file_name = file_name_arr[(file_name_arr.length-1)];
                              }

                              if(file_name != '~пусто~'){
                              out += '<div class="col-6 font-weight-bold">';
                                 out += '<span>';
                                  out += '<div class="custom-control custom-checkbox">';
                                    out += '<input type="checkbox" class="custom-control-input" id="cb_for_'+key+'" checked>';
                                    out += '<label class="custom-control-label cls-table-name" for="cb_for_'+key+'">'+file_name+'</label>';
                                  out += '</div>';
                                 out += '</span>';
                              out += '</div>';
                              out += '<div class="col-6 col-xl-2 text-right font-weight-bold">'+_data.files[key].create_ru+'</div>';
                              out += '<div class="col-12 col-xl-4 font-weight-bold" file_name="'+_data.files[key].file+'" id="div_for_file_'+file_name+'"></div>';

                               out += '<div class="col-12 border-top my-2"></div>';
                              }

    	                    }

    	      out += '</div>';
    	    out += '</div>';
    	out += '</div>';



        $('#action_data').html(out);

    });


}
/*----------------------------------------------------------------------------*/
/*----------------------------------------------------------------------------*/
/*----------------------------------------------------------------------------*/
/*----------------------------------------------------------------------------*/
/*----------------------------------------------------------------------------*/
/*----------------------------------------------------------------------------*/
/*----------------------------------------------------------------------------*/
/*----------------------------------------------------------------------------*/
/*----------------------------------------------------------------------------*/
/*----------------------------------------------------------------------------*/$(document).on('click', '#cb_for_all', function() {	var all_cb = $('[id^="cb_for_"]');
	if(this.checked){
		all_cb.prop('checked', true);
	}else{
		all_cb.prop('checked', false);
	}});
/*----------------------------------------------------------------------------*/
$('#btn_mode_load_from_server').click(function(){	$('#footer').empty();
	$('#footer').parent().parent().hide();
	var this_text = $(this).text();
	$('#nav_mode').html(lng.logic.mode + ' -> ' + this_text);   /* Режим */
	$('.action-modes').hide();
	get_backups_drop_down();
    $('#action_load_from_server').show();
    $('#action_load_from_remote_server_save').hide();

    var out = '';
    out += '<div class="card">';
    	   out += '<div class="card-header">'+lng.logic.backup_not_select+'</div>';    /* BackUP не выбран */
    	   out += '<div class="card-body">';
    	     out += '<div class="row">';
                            out += '<div class="col-12">';
                              out += '<- '+lng.logic.backup_choice+'...';   /* Выбирите архив для восстановления... */
                            out += '</div>';
             out += '</div>';
           out += '</div>';
   out += '</div>';
   $('#action_data').html(out);});
/*----------------------------------------------------------------------------*/
$('#btn_mode_save_to_server').click(function(){	$('#footer').empty();
	$('#footer').parent().parent().hide();

	var this_text = $(this).text();
	$('#nav_mode').html(lng.logic.mode + ' -> ' + this_text);
	$('.action-modes').hide();
	$('#action_save_to_server').show();
	$('#action_load_from_remote_server_save').hide();


	show_data_action_for_db();
});
/*----------------------------------------------------------------------------*/
$('#btn_mode_load_from_remote_server').click(function(){
	$('#footer').empty();
	$('#footer').parent().parent().hide();

	var this_text = $(this).text();
	$('#nav_mode').html(lng.logic.mode+' -> ' + this_text);     /* Режим */
	$('.action-modes').hide();
	$('#action_load_from_remote_server').show();
	$('#action_load_from_remote_server_save').hide();
	$('#action_load_from_remote_server_files_save').hide();

    if(!GLOBAL_REMOTE_DATA_EXIST){       var out = '';
       out += '<div class="card">';
    	   out += '<div class="card-header">'+lng.logic.data_for_connect+'</div>';   /* Данные для подключения */
    	   out += '<div class="card-body">';
    	     out += '<div class="row">';
                            out += '<div class="col-12">';
                              out += '<- '+lng.logic.input_data_connect+'...';     /* Введите данные для подключения у удаленному серверу */
                            out += '</div>';
             out += '</div>';
           out += '</div>';
      out += '</div>';
      $('#action_data').html(out);
    }else{    	$('#action_data').empty();
    	show_data_action_for_remote_db();

    }
});
/*----------------------------------------------------------------------------*/
$('#btn_remove_backup').click(function(){   var dd_dd_backups = $('#dd_backups');
   if(dd_dd_backups.length){   	   var backup_name = dd_dd_backups.text();
   	   if(confirm(lng.logic.q_delete_archive + ' "'+backup_name+'"?')){        /* Вы уверены в том, что хотите удалить backup */
   	      remove_backup(backup_name, function(_data){   	   	     if(_data.error == 0){   	   	     	 /* alert(backup_name + ' успешно удален.'); */
   	   	     	 $('#btn_mode_load_from_server').click();
   	   	     }else{   	   	     	alert(lng.logic.error_delete+' ' + backup_name + ' ...');  /* Ошибка удаления */
   	   	     }   	      });
   	   }
   }

});
/*----------------------------------------------------------------------------*/
$('#btn_mode_load_from_remote_server_files').click(function(){
	$('#footer').empty();
	$('#footer').parent().parent().hide();

	var this_text = $(this).text();
	$('#nav_mode').html(lng.logic.mode+' -> ' + this_text);      /* Режим */
	$('.action-modes').hide();
	$('#action_load_from_remote_server_files').show();
	$('#action_load_from_remote_server_files_save').hide();

    if(!GLOBAL_REMOTE_DATA_FILES_EXIST){
       var out = '';
       out += '<div class="card">';
    	   out += '<div class="card-header">'+lng.logic.data_for_connect+'</div>';       /* Данные для подключения */
    	   out += '<div class="card-body">';
    	     out += '<div class="row">';
                            out += '<div class="col-12">';
                              out += '<- '+lng.logic.input_data_connect+'...';        /* Введите данные для подключения у удаленному серверу */
                            out += '</div>';
             out += '</div>';
           out += '</div>';
      out += '</div>';
      $('#action_data').html(out);
    }else{
    	$('#action_data').empty();
        show_data_action_for_remote_files();

    }


});


/*----------------------------------------------------------------------------*/
function save_all_remote_server_files(_curent_file){	_curent_file = _curent_file || '';
	var files_arr = [];
	$('.cls-table-name').each(function(){
		var file = $(this).text();
		var url = $(this).parent().parent().parent().next().next().attr('file_name');
		var status_text = $(this).parent().parent().parent().next().next().text();
		var cb = $(this).parent().find('.custom-control-input');
		if(cb[0].checked){
		   files_arr.push({'file':file, 'url':url});
        }
	});
	var files_len = Object.keys(files_arr).length;

	/*console.log(files_arr);*/

	var new_key = 0;
	if(_curent_file == ''){	 _curent_file = files_arr[new_key].file;
	}else if(_curent_file == files_arr[(files_len-1)].file){		return true;
		/* last loop */
	}else{
	   for(var key in files_arr){		   if(files_arr[key].file == _curent_file){                new_key = parseInt(key)+1;
		   }
	   }

	}

	if(_curent_file == ''){		while(!files_arr[new_key].file == ''){			new_key++;
		}
	}

	/*console.log(_curent_file);*/
	_curent_file = files_arr[new_key].file;
	var curent_url = files_arr[new_key].url;




    save_file_from_remote(curent_url, function(_data){    	/*console.log(_data);*/

    	new_key = new_key+1;


        var progress_class = 'bg-danger';
        var progress_text  = 'Ошибка';
        if(_data.done){        	 progress_class = 'bg-success';
        	 progress_text  = 'Успешно';
        }
        var progress = '';
        progress += '<div class="progress" style="height:25px;">';
           progress += '<div class="progress-bar '+progress_class+'  progress-bar-striped" style="width:100%; height:25px;">'+progress_text+'</div>';
        progress += '</div>';
        $('[file_name="'+_data.original_url+'"]').html(progress);


        if($('[file_name="'+_data.original_url+'"]').length){
          $('html, body').stop();
          $('html, body').animate({
  	            scrollTop: ( $('[file_name="'+_data.original_url+'"]').offset().top - 100 )
          }, 100);
         }




        var total_percent = Math.ceil((100/files_len)*new_key);

        if(new_key == 1){
		  $('#footer').parent().parent().show();
		  total_start_time = new Date();
	    }
        total_end_time = new Date();
        var timeDiff = total_end_time - total_start_time;
        timeDiff /= 1000;
        var seconds = Math.round(timeDiff);

        var h = Math.floor(seconds / 3600);
        seconds %= 3600;
        var m = Math.floor(seconds / 60);
        var s = seconds % 60;

        var elapsed_time = '';
        if(h>0){
    	    if(h<10){h='0'+h;}
    	    if(m<10){m='0'+m;}
    	    if(s<10){s='0'+s;}
    	    elapsed_time = h + ':' + m + ':' + s;
        }else if(m>0){
    	    if(m<10){m='0'+m;}
    	    if(s<10){s='0'+s;}
    	    elapsed_time =  m + ':' + s;
        }else if(s>0){
    	    if(s<10){s='0'+s;}
    	    elapsed_time =  s +' сек.';
        }



	     var progress_text =  total_percent + '%';
	     var progress_bg = 'bg-danger';
	     if(total_percent>5){
	 	    progress_text =  total_percent + '% (' + elapsed_time+ ')';
	     }
	     if(total_percent>20){
	 	     progress_text = new_key +' '+lng.logic.out_of+' '+files_len+ ' ('+ total_percent +'%) '+lng.logic.elapsed_time+' ' + elapsed_time;        /* из      затрачено времени */
	     }
	     if(total_percent>25){
	 	     progress_bg = 'bg-warning';
	     }
	     if(total_percent>50){
	 	    progress_bg = 'bg-info';
	     }
	     if(total_percent>75){
	 	    progress_bg = 'bg-success';
	     }
	     var progress = '';
         progress += '<div class="progress" style="height:25px;">';
           progress += '<div class="progress-bar '+progress_bg+'  progress-bar-striped" style="width:'+total_percent+'%; height:25px;">'+progress_text+'</div>';
         progress += '</div>';
	     $('#footer').html(progress);



    	save_all_remote_server_files(_data.file);

    });
}
/*----------------------------------------------------------------------------*/
function correction_all_tables(_old_table){	_old_table = _old_table || '';
	if(_old_table == ''){
	   var backup = $('#backup').val();
       set_cookie('backup', backup);
       total_load_rows=0;
       total_load_posts=0;
       total_start_time = new Date();
	}

	var table_name = '';
	var table_index = 0;
	var tables_arr = [];
	$('.cls-table-name').each(function(){
		var table_name = $(this).text();
		var cb = $(this).parent().find('.custom-control-input');
		if(cb[0].checked){
		   tables_arr.push(table_name);
        }
	});
	var curent_key=0;
	if(_old_table == ''){
		table_name = tables_arr[0];
		/*$('[id^="div_for_table_"]').empty();*/
	}else if(_old_table == tables_arr[tables_arr.length-1]){
		/* last table */
		return false;
	}else{
		for(var key in tables_arr){
			if(_old_table == tables_arr[key]){
				curent_key = (parseInt(key)+1);
				table_name = tables_arr[curent_key];

			}
		}
	}

	var total_percent = Math.ceil((100/tables_arr.length)*(curent_key+1));

	save_table_correction(table_name, function(_data){		console.log(_data);

        var old_table_rows = $('#div_for_table_'+_data.table).attr('table_rows');
        old_table_rows = parseInt(old_table_rows)||0;
        var last_saved_rows = old_table_rows - _data.start;
        while(old_table_rows>3000){
        	old_table_rows -= 3000;
        }

        var total_added = _data.saved_count - old_table_rows;
		var curent_progress_text = $('#div_for_table_'+_data.table).find('.progress-bar').html();
		$('#div_for_table_'+_data.table).find('.progress-bar').html(curent_progress_text + ' '+lng.logic.supplemented_by+' '+ total_added +' '+lng.logic.pcs);


        total_end_time = new Date();
        var timeDiff = total_end_time - total_start_time;
        timeDiff /= 1000;
        var seconds = Math.round(timeDiff);

        var h = Math.floor(seconds / 3600);
        seconds %= 3600;
        var m = Math.floor(seconds / 60);
        var s = seconds % 60;

        var elapsed_time = '';
        if(h>0){
    	    if(h<10){h='0'+h;}
    	    if(m<10){m='0'+m;}
    	    if(s<10){s='0'+s;}
    	    elapsed_time = h + ':' + m + ':' + s;
        }else if(m>0){
    	    if(m<10){m='0'+m;}
    	    if(s<10){s='0'+s;}
    	    elapsed_time =  m + ':' + s;
        }else if(s>0){
    	    if(s<10){s='0'+s;}
    	    elapsed_time =  s +' сек.';
        }


	    var progress_text =  total_percent + '%';
	    var progress_bg = 'bg-danger';
	    if(total_percent>5){
	 	   progress_text =  total_percent + '% (' + elapsed_time+ ')';
	    }
	    if(total_percent>20){
	 	    progress_text = lng.logic.correction + ' '+(curent_key+1) +' '+lng.logic.out_of+' '+tables_arr.length+ ' ('+ total_percent +'%) '+lng.logic.elapsed_time+' ' + elapsed_time;
	    }
        if(total_percent==100){
	 	    progress_text = lng.logic.correction + ' '+(curent_key+1) +' '+lng.logic.out_of+' '+tables_arr.length+ ' ('+ total_percent +'%)';
	    }
	    if(total_percent>25){
	 	    progress_bg = 'bg-warning';
	    }
	    if(total_percent>50){
	 	   progress_bg = 'bg-info';
	    }
	    if(total_percent>75){
	 	   progress_bg = 'bg-success';
	    }
	    var progress = '';
        progress += '<div class="progress" style="height:25px;">';
          progress += '<div class="progress-bar '+progress_bg+'  progress-bar-striped" style="width:'+total_percent+'%; height:25px;">'+progress_text+'</div>';
        progress += '</div>';
	    $('#footer').html(progress);


		correction_all_tables(_data.table);	});

}
/*----------------------------------------------------------------------------*/
function correction_all_tables_remote(_old_table){
	_old_table = _old_table || '';
	if(_old_table == ''){
	   var backup = $('#backup').val();
       set_cookie('backup', backup);
       total_load_rows=0;
       total_load_posts=0;
       total_start_time = new Date();
	}

	var table_name = '';
	var table_index = 0;
	var tables_arr = [];
	$('.cls-table-name').each(function(){
		var table_name = $(this).text();
		var cb = $(this).parent().find('.custom-control-input');
		if(cb[0].checked){
		   tables_arr.push(table_name);
        }
	});
	var curent_key=0;
	if(_old_table == ''){
		table_name = tables_arr[0];
		/*$('[id^="div_for_table_"]').empty();*/
	}else if(_old_table == tables_arr[tables_arr.length-1]){
		/* last table */
		return false;
	}else{
		for(var key in tables_arr){
			if(_old_table == tables_arr[key]){
				curent_key = (parseInt(key)+1);
				table_name = tables_arr[curent_key];

			}
		}
	}

	var total_percent = Math.ceil((100/tables_arr.length)*(curent_key+1));

	save_table_correction_remote(table_name, function(_data){
		console.log(_data);

        var old_table_rows = $('#div_for_table_'+_data.table).attr('table_rows');
        old_table_rows = parseInt(old_table_rows)||0;
        var last_saved_rows = old_table_rows - _data.start;
        while(old_table_rows>3000){
        	old_table_rows -= 3000;
        }

        var total_added = _data.saved_count - old_table_rows;
		var curent_progress_text = $('#div_for_table_'+_data.table).find('.progress-bar').html();
		$('#div_for_table_'+_data.table).find('.progress-bar').html(curent_progress_text + ' '+lng.logic.supplemented_by+' '+ total_added +' '+lng.logic.pcs);

        total_end_time = new Date();
        var timeDiff = total_end_time - total_start_time;
        timeDiff /= 1000;
        var seconds = Math.round(timeDiff);

        var h = Math.floor(seconds / 3600);
        seconds %= 3600;
        var m = Math.floor(seconds / 60);
        var s = seconds % 60;

        var elapsed_time = '';
        if(h>0){
    	    if(h<10){h='0'+h;}
    	    if(m<10){m='0'+m;}
    	    if(s<10){s='0'+s;}
    	    elapsed_time = h + ':' + m + ':' + s;
        }else if(m>0){
    	    if(m<10){m='0'+m;}
    	    if(s<10){s='0'+s;}
    	    elapsed_time =  m + ':' + s;
        }else if(s>0){
    	    if(s<10){s='0'+s;}
    	    elapsed_time =  s +' сек.';
        }


	    var progress_text =  total_percent + '%';
	    var progress_bg = 'bg-danger';
	    if(total_percent>5){
	 	   progress_text =  total_percent + '% (' + elapsed_time+ ')';
	    }
	    if(total_percent>20){
	 	    progress_text = lng.logic.correction + ' '+(curent_key+1) +' '+lng.logic.out_of+' '+tables_arr.length+ ' ('+ total_percent +'%) '+lng.logic.elapsed_time+' ' + elapsed_time;
	    }
        if(total_percent==100){
	 	    progress_text = lng.logic.correction + ' '+(curent_key+1) +' '+lng.logic.out_of+' '+tables_arr.length+ ' ('+ total_percent +'%)';
	    }
	    if(total_percent>25){
	 	    progress_bg = 'bg-warning';
	    }
	    if(total_percent>50){
	 	   progress_bg = 'bg-info';
	    }
	    if(total_percent>75){
	 	   progress_bg = 'bg-success';
	    }
	    var progress = '';
        progress += '<div class="progress" style="height:25px;">';
          progress += '<div class="progress-bar '+progress_bg+'  progress-bar-striped" style="width:'+total_percent+'%; height:25px;">'+progress_text+'</div>';
        progress += '</div>';
	    $('#footer').html(progress);



		correction_all_tables(_data.table);
	});

}
/*----------------------------------------------------------------------------*/
function show_small_language_drop_down(){	get_languages(function (_data){		if(_data.error == 0){		   var language = _data.language;           var def_lang_name = '';
           var def_lang_flag = '';
           for(var key in language){           	   if(language[key]['default']){           	   	  def_lang_name = language[key].laguage;
           	   	  def_lang_flag = language[key].flag;
           	   }
           }			var out_nb = '';
			out_nb += '<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">';
			   out_nb += '<span class="flag-icon '+def_lang_flag+'"> </span> '+def_lang_name;
			out_nb += '</a>';
			out_nb += '<div class="dropdown-menu">';



			var out = '';
            out += '<div class="dropdown">';
              out += '<button class="btn dropdown-toggle" data-toggle="dropdown"><span class="flag-icon '+def_lang_flag+'"> </span> '+def_lang_name+'</button>';
              out += '<div class="dropdown-menu">';
                 for(var key in language){
                    out += '<div style="cursor:pointer;" onclick="set_new_language(\''+language[key].file+'\');" class="dropdown-item"><span class="flag-icon '+language[key].flag+'"> </span> '+language[key].laguage+'</div>';

                    out_nb += '<div onclick="set_new_language(\''+language[key].file+'\');" class="dropdown-item btn btn-light" style="cursor:pointer;"><span class="flag-icon '+language[key].flag+'"> </span> '+language[key].laguage+'</div>';
                 }
              out += '</div>';
            out += '</div>';
            $('#div_for_small_laguage').html(out);


            out_nb += '</div>';
            $('#nav_bar_lang').html(out_nb);
		}	});
}
/*----------------------------------------------------------------------------*/
function set_new_language(_language){
	set_language(_language, function(_data){
        location.href = location.href;
		/*window.location.reload(false);*/	});
}
/*----------------------------------------------------------------------------*/

