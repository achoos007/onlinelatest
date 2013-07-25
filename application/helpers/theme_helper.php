<?php
#---------------------------------------------------------------------------------------------------------------
function heading($title){
	return "<div class='data-title' > ".$title." </div>";
}
function title($t=''){
	$t="
	<div data-role='header' data-theme='b'> 
	<h1>".ucwords($t)."</h1> 
</div>
	
	";
	return $t;
}
function ready($sccr){
	$s="
	<script type='text/javascript'>
	$(document).ready(function (){
	".$sccr."
		});
	</script>
	";
	return $s;
}
function closedialog(){
	$s="
	<script type='text/javascript'>
	$(document).ready(function (){
	$('.ui-dialog').dialog('close');
		});
	</script>
	";
	return $s;
}

function dialog($url,$text='popup'){
	
	$b='<a href="'.site_url($url).'" data-role="button" data-rel="dialog"   data-mini="true" data-theme="b">'.ucwords($text).'</a>';
	return $b;
}
function submit($t='Save',$id='submit',$class='submit'){
	 return '
	 <input type="submit" id="'.$id.'" name="'.$id.'" class="'.$class.'" data-role="button"   data-mini="true" data-theme="b" value="'.ucwords($t).'" />
	 ';
	
}
function hidden($id='id',$val='default'){
	 return '
	 <input type="hidden" id="'.$id.'" name="'.$id.'"  value="'.trim($val).'" />
	 ';
	
}
function button($t='Save',$id='submit',$class='submit'){
	 return '
	 <input type="button" id="'.$id.'" name="'.$id.'"  class="'.$class.'" data-role="button"  data-mini="true" data-theme="b" value="'.ucwords($t).'" />
	 ';
	
}
function close($t='close'){
	$b='<a href="#" data-role="button" data-rel="back" data-mini="true" data-theme="b">'.ucwords($t).'</a>';
	return $b;
	
}

function ajaxform($form_id,$div_id_to_update,$ret=0){
  
  $scriptdet=script()."
		$(document).ready(function() {
		var options = {
		target:'#".$div_id_to_update."' ,
		clearForm: false ,
		resetForm: false ,
		type:      'post',
		beforeSubmit: ".$div_id_to_update."
			};  
		//  $('#".$form_id."').ajaxForm(options);


		$('#".$form_id."').submit(function() {  


		$('#".$form_id."').ajaxSubmit(options); 

		return false;
		}); 
		}); 
		
function ".$div_id_to_update."(){ $('#".$div_id_to_update."').html('<img src=\"".base_url('images/ajax-loader1.gif')."\" />'); }

</script>
  ";
  if($ret<1)
  print $scriptdet;
  else
  return $scriptdet;
  
}
#---------------------------------------------------------------------------------------------------------------

function stopform($formid='',$ret=0){
  $html=script()." $(document).ready(function() {     ";   
  
   if($formid!='') 
   
    $html.=" $('#".$formid."').submit(function(){   return false; });   "; 
    
     else  
     
     $html.=" $('form').submit(function(){    return false; }); "; $html.=" });  ";  
     $html.=" </script> ";  
      
     if( $ret==0) 
     
        print $html ; 
      
      
      else
      
       return $html ;
}

#---------------------------------------------------------------------------------------------------------------

function build_ajax_form($url,$div_id_to_update,$form_id='ajaxform'){
    /*
      this func is simple to use to convert any element
      to ajax communicate with server
      all we need to do is if its not a fom that is to be submitted then call this func
      and send arguments like which url to send data as post
      which div or html tag to be updated
      and the form id which is optional argument thats to be used we there
      is more than one element to be communicated
      
      and on the html page  put this script
      

$(document).ready(function()
{     $("#valueajax").keyup(function (){ // change to what event the communication need to be happened. here 'keyup'  is used
      $('#formid_data').val($('#valueajax').val()); // bind the data to an html hidden field which has the id like 'formid_"data"'
    $('#1').submit(); // submit the form using normal submission which will be captured by ajaxForm js
});


});
here a form is builded with the data to be communicated
we use this method in order to avoid direct access of the func through url
and also to limit any mysql hacking thats to be parsed using basic codeigniter data validation/ filtering itself
strictly the data should be fetched using $this->input->post('formid_data') method
a sample working of this func is kept commented on dashboard/calendar
    */
print "
  <form id='".$form_id."' name='".$form_id."'     method='post' action='".site_url($url)."'>
   <input type='hidden' name='".$form_id."_data' id='".$form_id."_data' value='novalueassigned'/>
  </form>
".script()."
$(document).ready(function() {
              var ajaxoptions".$form_id." = {
        target:        '#".$div_id_to_update."' ,
        clearForm: false ,
        resetForm: false ,
        type:      'post'
    };
  $('#".$form_id."').ajaxForm(ajaxoptions".$form_id.");
$('#".$form_id."').submit(function(){
    $('#".$form_id."').ajaxSubmit(ajaxoptions".$form_id.");
    return false;
});

});
</script>
  ";
} 
?>
