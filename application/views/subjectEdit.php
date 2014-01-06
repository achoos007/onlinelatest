<?php 

	ajaxform("subjectformedit",'editresult'); 

	$status=2;
			
	if(!empty($subjectid) && ($subjectid>0)){
		$sub['table']='tbl_subject';
		$sub['where']['n_subjectid']=$subjectid;
		$sub=getsingle($sub);
		$name=$sub['c_subject'];
		$status=$sub['status'];
	}

	print title($title);
?>

<div class='data-box'>
	<div class="message" id="editresult"></div>
	<form method="post" action ="<?php print site_url("subjects/edit");?>" id="subjectformedit">
	<div align="center">  
	<?php 
		$name=empty($name)? '':$name;
		if(!empty($name)){
	?>
		<input type="text" name="name" id="name" value="<?php print $name; ?>"  placeholder="Subject Name" />
  <?php 
		}
		else{
	?> 
  <input type="text" name="name" id="name" value="<?php print $name;?>"  placeholder="Subject Name"  />
  <?php } ?>
	<br/>
	<br/>
  
	<select name="status" id="status" >
		<option value='1' <?php print ( $status == 1)?  " selected='selected' ":""; ?> >Active</option>
		<option value='0' <?php print ($status==0)? " selected='selected' ":""; ?> >Inactive</option>
	</select>
	<br/>
	<br/>
	<input value="<?php print $subjectid;?>" type="hidden" id="subjectid" name="subjectid" /> 
	<input value="<?php print $btnText;?>" type="submit"  data-inline='true' data-mini='true'  data-theme='b' class="refresh_page" />
	<?php
		if($btnText == 'Edit'){
	?>
	<div data-role="button"  data-inline='true' data-mini='true'  data-theme='b' id='deleteSub'>Delete</div>
	<?php
		}
	?>
	</div>
	</form> 
</div>
  
<?php 
	print script();
?>

$(document).ready(function (){
	$('#deleteSub').click(function(){
		if(confirm( 'Are you sure to delete ?')){
		$.post('<?php print site_url("subjects/del/".$subjectid);?>');
		window.setTimeout('location.reload()', 1000);
	
//$('.ui-dialog').dialog('close');
	//	refreshPage();
	}	else{
	$('.ui-dialog').dialog('close'); 
}
		});
		
//$('.refresh_page').click(function(){
	// window.setTimeout('location.reload()', 1000);
//	});		
		
	});


</script>



