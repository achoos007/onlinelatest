<?php

// for displaying the title of Dialog
print title('Edit Candidate');

// for getting candidate details from candidate table
$editcand['table']='candidate';
$editcand['where']['candidate_id']=$cid;
$editcand=getsingle($editcand);

// Assigning each field to variables
$username = empty($editcand['username'])?'':$editcand['username'];
$password = empty($editcand['password'])?'':$editcand['password'];
$firstname = empty($editcand['first_name'])?'':$editcand['first_name'];
$lastname = empty($editcand['last_name'])?'':$editcand['last_name'];
$email = empty($editcand['email'])?'':$editcand['email'];
$country_code = empty($editcand['country_code'])?'':$editcand['country_code']; 
?>
<div data-role='content'> 
<?php
print ajaxform('editCand','editCandResult');
print form('editCand','exam/newcandidate');
print hidden('cid',intval($cid));
?>
	<label for="un">Username</label>
  <input name="user" id="un"  data-theme="b" type="text" value="<?php print $username ?>">
  <label for="pw">Password</label>
  <input name="pass" id="pw" value="<?php print $password ?>" placeholder="password" data-theme="b" type="text">
  <label for="fn">Firstname</label>
  <input name="firstname" id="fn" value="<?php print $firstname ?>" placeholder="firstname" data-theme="b" type="text">
  <label for="ln">Lastname</label>
  <input name="lastname" id="ln" value="<?php print $lastname ?>" placeholder="lastname" data-theme="b" type="text">
  <label for="email">Email</label>
  <input name="email" id="email" value="<?php print $email ?>" placeholder="email" data-theme="b" type="text">
  <label for="country_code" >Select </label>
	<select name="country_code" id="country_code" data-mini="true">
		
		<?php
			$country_list['table']='countries';
			$country_list['limit'] = 1000000;
			$country_list=getrecords($country_list);
		
			foreach($country_list['result'] as $cname ){
				if($cname['ccode'] == $country_code){
					$sel = "selected=selected";
					}
				else{
					$sel = "";
				}
				print "<option value='".$country_code."' ".$sel.">".$cname['country']."</option>";
				
			}
?>
		<!--<option value="IND" >India</option>
		<option value="BHR">Bhaharin</option>
		<option value="KWT">Kuwait</option>
		<option value="OMN">oman</option>
		<option value="ARE">United Arab Emirates</option>-->
	</select>
	<br><br>
	<div id='editCandResult' class='error'></div>
	<input value="<?php print $cid;?>" type="hidden" id="cid" name="cid" /> 
  <button type="submit" data-theme="b" data-inline="true" >Save</button>
  <div data-role="button"  data-inline='true'  data-theme='b' class='deleteCand' id="<?php print $cid; ?>">Inactive</div>
</div>	

<?php 
print script();
?>

$(document).ready(function (){
	$('.deleteCand').click(function(){
		var cid = this.id;
		if(confirm( 'Do you wish to inactive this user ?')){
		$.post('<?php print site_url("exam/candDelete/")?>',{clkid:cid},function(data){
			
			$('.ui-dialog').dialog('close');
		refreshPage();
			});
	

	}	else{
	$('.ui-dialog').dialog('close'); 
}
		});
	});


</script>
