<?php
 
/*
     $CI =& get_instance();
     $CI->load->library('session');  
     $CI->load->library('encrypt');  
     $CI->load->helper('date');  
*/
 function lock($id){
     $CI =& get_instance();
     $CI->load->library('encrypt');   
   $encrypt= $CI->encrypt->encode($id );   
   return $encrypt;
 }   
 function open($id){
     $CI =& get_instance();
     $CI->load->library('encrypt');   
   $decrypt= $CI->encrypt->decode($id );   
   return $decrypt;
 }   
 
 
 function valid(){
   
     $CI =& get_instance();
     $CI->load->library('session');   
   if((($CI->uri->segment(1) != 'login' ) &&($CI->uri->segment(1) != '' )  ) &&  ($CI->uri->segment(1) != 'logout' ))
   {
   
 if(  $CI->session->userdata('userid')===FALSE){  
    redirect('/login/', 'refresh');
}else{
  return $CI->session->userdata('userid');
}
     
     
   }else{
     
   }
   
   
   
 }
 
 function form($id='' , $url='', $ret=0,$arg=''){
   if($id!='')
   $att['id']=$id;
   else
   $att['id']='wizbizform';
   
   if(!empty($arg))
   foreach( $att as $key=>$value)
   $att[$key]=$value;
   if($ret==1)
   return  form_open_multipart($url,$att);
   else
   print  form_open_multipart($url,$att);
   
 }
 
 
 function defaultreport(){
   return entrydate('-'.config('default-report'));
 }
 
 
 function arrtoval($arr,$sep=',',$d=''){
	 if(empty($arr)) return $d;
	 foreach($arr as $k=>$v){
		 $d.=empty($d)? $v:$sep.$v;
	 }	 return $d; }
 
 
 function arrtokey($arr,$sep=',',$d=''){
	 if(empty($arr)) return NULL;
	 foreach($arr as $k=>$v){
		 $d.=empty($d)? $k:$sep.$k;
	 }	 return $d; }
 
 
 function arrtovk($arr,$d=''){
	 if(empty($arr)) return $d;
	 foreach($arr as $k=>$v){
		 $d[$v]=$v;
	 }	 return $d; }
	 
	 
	 
	 
 function arrayjoin($arr,$d=''){
	  if(empty($arr)) return $d;
	 
	  foreach($arr as $k=>$v){
		 $d[]=$v;
	 }	 return $d; 
	 
	 
	 
 }
function truncate($string, $length = 250 ){ 
return character_limiter($string,  $length );
		}
 
function format($string, $length = 100,$position=.5 ){ 
return ellipsize($string,  $length , $position);
		}
 
 function entrydate($str='now'){
   /*
    * ref: http://www.php.net/manual/en/function.date.php
    * if 11/26/2011 slash is used as separater then then the format is : m/d/Y
    * if 11-26-2011 hyphen is used as separater then then the format is : d-m-Y    * 
    *  
=> "now"
=>"10 September 2000"
=>"+1 day" 
=>"+1 week"
=>  "+1 week 2 days 4 hours 2 seconds"
=> "next Thursday"
=>"last Monday"
*/
 return $time=strtotime($str); 
 }
 
  function dateformat($timestamp='',$format=''){
    $timestamp=empty($timestamp)? entrydate(): $timestamp;
    $format=empty($format)? 'd/m/Y H:i:s': $format;
    return date($format,$timestamp);
    
  }
 
    function a(){
/*
      receives any number of arguments and converts it to an array of arguments 
      * with normal indexes
*/      
  return $arg_list = func_get_args();  
      
    }
 
 
 function alert($msg){  
   
   
    print "<script type='text/javascript'>	alert('".$msg."'); </script>"; 
 
  }
 
 function msgjs($msg){   print "	<script type='text/javascript'>	$('#actionmessage').append('".$msg."'); </script>"; }
 
 function exist($arg){ if(!empty($arg)){return TRUE;}else{ return FALSE; }}
 
 function Sec2Time($time){
  if(is_numeric($time)){
    $value = array(
      "y" => 0, "d" => 0, "h" => 0,
      "m" => 0, "s" => 0,
    );
    if($time >= 31556926){
      $value["y"] = floor($time/31556926);
      $time = ($time%31556926);
    }
    if($time >= 86400){
      $value["d"] = floor($time/86400);
      $time = ($time%86400);
    }
    if($time >= 3600){
      $value["h"] = floor($time/3600);
      $time = ($time%3600);
    }
    if($time >= 60){
      $value["m"] = floor($time/60);
      $time = ($time%60);
    }
    $value["s"] = floor($time);
    return (array) $value;
  }else{
    return (bool) FALSE;
  }
}


 function time_elapsed($timestamp){
   
  $status= $timestamp-entrydate();
    $tomesage='';
     $to=Sec2Time(abs($status));   
     if($to['y']>0)
       $tomesage.= $to['y'].' year ';
      if($to['d']>0)
      $tomesage.= $to['d'].' days ';
      if($to['h']>0)
      $tomesage.= $to['h'].' hours '; 
      $tomesage.= $to['m'].' mins '; 
      $tomesage.= $to['s'].' secs '; 
   if($status>0){
     // future time 
      $tomesage.= ' more'; 
   }
   else{ 
      $tomesage.= ' ago';  
   }
   
   return  $tomesage;
   
 }
 
 
 function url($url=''){
   print site_url($url);
   
 }
 
 
 
 
 function script($data=''){
   $script="     <script type='text/javascript'>    ";
   if(!empty($data))
   $script.=$data."</script>";
    
   return    $script;
 }
 
 
  
function pa($arr){
printarray($arr);
}


function printarray($arr){
	$res = "<div style='padding:10px;'><pre>";
	$res.=print_r($arr,TRUE);
	$res.="</pre></div>"; 
  print $res; 
} 

function br($t=2){
	for($d=1;$d<=$t;$d++)
	print "<br/>";
}
function nodata($ret=0,$text=''){
$CI =& get_instance();
$res=  ' 	<div align="center">         		<div class="wiz_logo" align="center"> <img src="'.$CI->config->item('base_url').'images/wiz_logo.png" width="25%" /> </div>
    <div class="wiz_txt fnt_80" align="center"> ';
    
    if($text=='')
    $res.=config('no-data-to-display');
    
else
    $res.=$text;
    
    
    
    
    $res.='</div>    ';
if($ret==1)
return $res;
else
print $res;
}

 function error($text,$delay=200){
   
   $error='<div class="clear"></div><div id="errordisplay" 
   style="display:none;   
   padding:5px;
   margin:3px;
   -webkit-border-radius: 5px;
   -moz-border-radius: 5px;
   border-radius: 5px;
   border: 1px solid #89aad3;
   background-color:#fff;
   -moz-box-shadow: 0 0 5px #888;
	-webkit-box-shadow: 0 0 5px#888;
	box-shadow: 0 0 5px #888;
  color:#FF0000;
  font-size:10px;
  ">
	'.$text.'</div>
   '.script().' 
    $("#errordisplay").delay('.$delay.').show("slow").delay('.($delay*10).').hide("slow"); 
   </script>
   
   ';
   return $error;
 }

 function msg($text){
   $id=entrydate();
   $error='<div id="'.$id.'" 
   style="display:none; 
   margin:1px;
   -webkit-border-radius: 5px;
   -moz-border-radius: 5px;
   border-radius: 5px;
   border: 1px solid #89aad3; 
   -moz-box-shadow: 0 0 5px #888;
	-webkit-box-shadow: 0 0 5px#888;
	box-shadow: 0 0 5px #888;">
	'.$text.'<br/></div>
   '.script().' 
    $("#'.$id.'").delay(500).show("slow").delay(3000).hide("slow"); 
   </script>
   
   ';
   return $error;
 }
 
 
 function valid_date($stamp)
{ 
  if (! is_numeric($stamp) )
     return FALSE;
 
  if (   strlen($stamp)!=10)
     return FALSE;
 
  if ( checkdate(date('m', $stamp), date('d', $stamp), date('Y', $stamp)) )
  {
     return TRUE;
  }
  return FALSE;
} 


function GetLastDayofMonth($year, $month) {
    for ($day=31; $day>=28; $day--) {
        if (checkdate($month, $day, $year)) {
            return $day;
        }
    }   
}

function checktime($hour, $minute) {
    if ($hour > -1 && $hour < 24 && $minute > -1 && $minute < 60) {
        return true;
    }
} 


function splitdate($dateformat){
return date_parse($dateformat); 
/*
Array
(
    [year] => 2006
    [month] => 12
    [day] => 12
    [hour] => 10
    [minute] => 0
    [second] => 0
    [fraction] => 0.5
    [warning_count] => 0
    [warnings] => Array()
    [error_count] => 0
    [errors] => Array()
    [is_localtime] => 
)
*/
}
function splittime($entrydate)
{
        
        $data['year']=dateformat('Y',$entrydate);
        $data['month']=dateformat('m',$entrydate);
        $data['day']=dateformat('d',$entrydate);
        $data['textday']=dateformat('D',$entrydate);
        $data['mode']=dateformat('a',$entrydate);
        
        
/*
d 	Day of the month, 2 digits with leading zeros 	01 to 31
D 	A textual representation of a day, three letters 	Mon through Sun
j 	Day of the month without leading zeros 	1 to 31
l (lowercase 'L') 	A full textual representation of the day of the week 	Sunday through Saturday
N 	ISO-8601 numeric representation of the day of the week (added in PHP 5.1.0) 	1 (for Monday) through 7 (for Sunday)
S 	English ordinal suffix for the day of the month, 2 characters 	st, nd, rd or th. Works well with j
w 	Numeric representation of the day of the week 	0 (for Sunday) through 6 (for Saturday)
z 	The day of the year (starting from 0) 	0 through 365
Week 	--- 	---
W 	ISO-8601 week number of year, weeks starting on Monday (added in PHP 4.1.0) 	Example: 42 (the 42nd week in the year)
Month 	--- 	---
F 	A full textual representation of a month, such as January or March 	January through December
m 	Numeric representation of a month, with leading zeros 	01 through 12
M 	A short textual representation of a month, three letters 	Jan through Dec
n 	Numeric representation of a month, without leading zeros 	1 through 12
t 	Number of days in the given month 	28 through 31
Year 	--- 	---
L 	Whether it's a leap year 	1 if it is a leap year, 0 otherwise.
o 	ISO-8601 year number. This has the same value as Y, except that if the ISO week number (W) belongs to the previous or next year, that year is used instead. (added in PHP 5.1.0) 	Examples: 1999 or 2003
Y 	A full numeric representation of a year, 4 digits 	Examples: 1999 or 2003
y 	A two digit representation of a year 	Examples: 99 or 03
Time 	--- 	---
a 	Lowercase Ante meridiem and Post meridiem 	am or pm
A 	Uppercase Ante meridiem and Post meridiem 	AM or PM
B 	Swatch Internet time 	000 through 999
g 	12-hour format of an hour without leading zeros 	1 through 12
G 	24-hour format of an hour without leading zeros 	0 through 23
h 	12-hour format of an hour with leading zeros 	01 through 12
H 	24-hour format of an hour with leading zeros 	00 through 23
i 	Minutes with leading zeros 	00 to 59
s 	Seconds, with leading zeros 	00 through 59
u 	Microseconds (added in PHP 5.2.2) 	Example: 654321
Timezone 	--- 	---
e 	Timezone identifier (added in PHP 5.1.0) 	Examples: UTC, GMT, Atlantic/Azores
I (capital i) 	Whether or not the date is in daylight saving time 	1 if Daylight Saving Time, 0 otherwise.
O 	Difference to Greenwich time (GMT) in hours 	Example: +0200
P 	Difference to Greenwich time (GMT) with colon between hours and minutes (added in PHP 5.1.3) 	Example: +02:00
T 	Timezone abbreviation 	Examples: EST, MDT ...
Z 	Timezone offset in seconds. The offset for timezones west of UTC is always negative, and for those east of UTC is always positive. 	-43200 through 50400
Full Date/Time 	--- 	---
c 	ISO 8601 date (added in PHP 5) 	2004-02-12T15:19:21+00:00
r 	» RFC 2822 formatted date 	Example: Thu, 21 Dec 2000 16:01:07 +0200
U 	Seconds since the Unix Epoch (January 1 1970 00:00:00 GMT)
*/
        
        
        return $data;
        
}
?>
