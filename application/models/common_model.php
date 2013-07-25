<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Common_model extends CI_Model {



function __construct()

{

parent::__construct();

}




function getrecords($param){  



/**
 * $passingarray['table']='global_settings';
 * getrecords($passingarray);

* function accepts an  array of parameters.

*   1 . ['table']  

*   2. ['where'] condition as an array .. eg: $parama['where']['tableid']=1,$parama['where']['name']='wizbiz',

*   3. ['limit'] is optional and is set from condig table as default

*   4.['start'] is optional and is set as 0 as default

*/
/*
*/



 
if(!empty($param['join'])){  $param['jointype']=empty($param['jointype'])? 'left outer':$param['jointype'];
  foreach($param['join'] as $k=>$v) 
  $this->db->join($k,$v,$param['jointype']);
   }





$param['limit']=empty($param['limit'])? 20 : intval($param['limit']);

if(intval($param['limit'])<1)
$param['limit']=1000000000;

$param['start']=empty($param['start'])? 0 : intval($param['start']);

if(! empty($param['select']))
$this->db->select($param['select']);


$param['table']=$param['table']; 

 

if(!empty($param['where']))   

$this->db->where($param['where']); 

 

  

if(!empty($param['wherein'])){
foreach($param['wherein'] as $k=>$v)
$this->db->where_in($k,$v);

}


if(!empty($param['orwherein'])){
foreach($param['orwherein'] as $k=>$v)
$this->db->or_where_in($k,$v);

}



$ap='';


if(!empty($param['orwhere']))
$this->db->or_where($param['orwhere'] );





$ap='';
if(!empty($param['wherenotin'])){  
foreach($param['wherenotin'] as $k=>$v)
$ap .= empty($ap)? $v:','.$v;
$this->db->where_not_in($k,$ap); 

} 


$ap='';
if(!empty($param['orwherenotin'])){  
foreach($param['orwherenotin'] as $k=>$v)
$ap .= empty($ap)? $v:','.$v;
$this->db->or_where_not_in($k,$ap);  
}  






if(!empty($param['like']))
$this->db->like($param['like']); 

if(!empty($param['orlike']))
$this->db->or_like($param['orlike']); 

if(!empty($param['notlike']))
$this->db->not_like($param['notlike']); 

if(!empty($param['ornotlike']))
$this->db->or_not_like($param['ornotlike']); 







if(!empty($param['order']))   {



foreach($param['order'] as $k => $v )

$this->db->order_by($k,$v); 

}else 
  if ($this->db->field_exists('name',$param['table'])) 
$this->db->order_by('name','asc');  
   if ($this->db->field_exists('title',$param['table'])) 
$this->db->order_by('title','asc');  
   


if(!empty($param['group']))
$this->db->group_by($param['group']); 








$this->db->limit(intval($param['limit']),intval($param['start']));



$query = $this->db->get($param['table']); 



$data['result']=$query->result_array();   


/*
echo $this->db->last_query();  
*/

return $data;

}
function getsingle($param){  



/**
 * $passingarray['table']='global_settings';
 * getrecords($passingarray);

* function accepts an  array of parameters.

*   1 . ['table']  

*   2. ['where'] condition as an array .. eg: $parama['where']['tableid']=1,$parama['where']['name']='wizbiz',

*   3. ['limit'] is optional and is set from condig table as default

*   4.['start'] is optional and is set as 0 as default

*/








if(!empty($param['join'])){  $param['jointype']=empty($param['jointype'])? 'left outer':$param['jointype'];
  foreach($param['join'] as $k=>$v) $this->db->join($k,$v,$param['jointype']); }



$param['limit']=1;



$param['start']=empty($param['start'])? 0 : intval($param['start']);



$param['table']=$param['table']; 

 

if(!empty($param['where']))   

$this->db->where($param['where']); 

 
if(! empty($param['select']))
$this->db->select($param['select']);


   /*
$ap='';
if(!empty($param['wherein'])){  
foreach($param['wherein'] as $k=>$v)
$ap .= empty($ap)? $v:','.$v;
$this->db->where_in($k,$ap); 

}

 */

$ap='';
if(!empty($param['wherein'])){
foreach($param['wherein'] as $k=>$v)
$this->db->where_in($k,$v);

}




if(!empty($param['orwhere'])){
foreach($param['orwhere'] as $k=>$v)
$this->db->or_where($k,$v);

}



if(!empty($param['orwherein'])){
foreach($param['orwherein'] as $k=>$v)
$this->db->or_where_in($k,$v);

}


$ap='';
if(!empty($param['wherenotin'])){  
  
  
  
/*
foreach($param['wherenotin'] as $k=>$v)
$ap .= empty($ap)? $v:','.$v;
*/
$this->db->where_not_in($param['wherenotin'] ); 

} 


$ap='';
if(!empty($param['orwherenotin'])){  
foreach($param['orwherenotin'] as $k=>$v)
$ap .= empty($ap)? $v:','.$v;
$this->db->or_where_not_in($k,$ap);  
}  






if(!empty($param['like']))
$this->db->like($param['like']); 

if(!empty($param['orlike']))
$this->db->or_like($param['orlike']); 

if(!empty($param['notlike']))
$this->db->not_like($param['notlike']); 

if(!empty($param['ornotlike']))
$this->db->or_not_like($param['ornotlike']); 







if(!empty($param['order']))   {



foreach($param['order'] as $k => $v )



$this->db->order_by($k,$v); 





}






if(!empty($param['group']))
$this->db->group_by($param['group']); 








$this->db->limit(intval($param['limit']),intval($param['start']));



$query = $this->db->get($param['table']); 


return $query->row_array();   


/*
echo $this->db->last_query();  
*/
 

}


    
 function printqq(){
   
echo $this->db->last_query();  

 }


//Insert data

function insert($param)
{ 
    $this->db->insert($param['table'],$param['data']);  
    return $this->db->insert_id();	 
    
 
}	

function insertid(){ return $this->db->insert_id();}

//Update data

function update($param)

{



$this->db->where($param['where']); 

return $this->db->update($param['table'],$param['data']); 

}

//Delete data

function delete($param)

{


if(!empty($param['where']))   

$this->db->where($param['where']);  

if(!empty($param['wherein'])){
foreach($param['wherein'] as $k=>$v)
$this->db->where_in($k,$v);

}


if(!empty($param['orwherein'])){
foreach($param['orwherein'] as $k=>$v)
$this->db->or_where_in($k,$v);

}
return $this->db->delete($param['table']); 

}


function qry($query){
$result= $this->db->query($query); 
$data['total_rows']=$result->num_rows(); 
$data['result']=$result->result_array();  
return $data;
}

function execute($query){
  $this->db->query($query); 
}




function enum($param){
# 1: table name
#2 : field name
      $query_enum = "SHOW COLUMNS FROM ".$param[0]." LIKE '".$param[1]."' "; 
   
/*
    $res=qry(  $query_enum ); 
*/
    
  $res=  $this->db->query($query_enum)->row()->Type;
	$regex = "/'(.*?)'/";
    preg_match_all( $regex , $res, $enum_array );
    $enum_fields = $enum_array[1];
    return( $enum_fields ); 
 /*   
   $res=explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2",$res['result'][0]['Type'])); 
      
	return $res;
*/

  
  
}


function primarykey($tablename){
$fields = $this->db->field_data($tablename); 
foreach ($fields as $field)
{
/*
   echo $field->name;br(2);
   echo $field->type;br(2);
   echo $field->max_length;br(2);
*/
   if( $field->primary_key==TRUE)
   return $field->name;
} 
}



}

