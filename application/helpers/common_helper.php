<?php   
#--------------------------------------------------------------------------------------------------------------- 
function modelfn(){  
/*
0: model name
1: fn name
2+ fn arguments 
*/  
$arg_list = func_get_args();  
$ci = &get_instance();
$ci->load->model(func_get_arg(0));
$fn=$arg_list[1];
return $ci-> $arg_list[0]->$fn($arg_list[2]);
} 
#--------------------------------------------------------------------------------------------------------------- 
function libfn($library_name, $function_name){
// 1 library name
// 2 fn name
//3 parameters
$ci = &get_instance();
$arg_list = func_get_args();  
$ci->load->library($arg_list[0]); 
$function_name=$arg_list[1]; 
return $ci->$arg_list[0]->$function_name(func_get_arg(2));
}
#---------------------------------------------------------------------------------------------------------------
function getrecords($param){
return $keyid = modelfn('common_model','getrecords',$param);	 
}
function printqq(){
	$param['nil']=1;
return $keyid = modelfn('common_model','printqq',$param);	 
}
function total_rows($param){
$keyid = getrecords($param);	 
return count($keyid['result']);
}
function qry($param){  
return  modelfn('common_model','qry',$param);	 
}

#---------------------------------------------------------------------------------------------------------------
function getsingle($param){
return  modelfn('common_model','getsingle',$param);	 
} 
#---------------------------------------------------------------------------------------------------------------
function delete($param){
return  modelfn('common_model','delete',$param);	 
} 
#---------------------------------------------------------------------------------------------------------------

#---------------------------------------------------------------------------------------------------------------

function insert($param){
return $keyid = modelfn('common_model','insert',$param);	 
}

#---------------------------------------------------------------------------------------------------------------

function enum($table,$field){
	
	$param[]=$table;
	$param[]=$field; 
return   modelfn('common_model','enum',$param);	 
}
#---------------------------------------------------------------------------------------------------------------

function insertid(){
return $keyid = modelfn('common_model','insertid');	 
}
#---------------------------------------------------------------------------------------------------------------
#---------------------------------------------------------------------------------------------------------------

function update($param){
return  modelfn('common_model','update',$param);	 
}

?>
