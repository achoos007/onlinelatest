<?php


// For getting current date
$entrydate=entrydate();




$this->load->helper('date');

$datestring = "%Y-%m-%d";
$time = time();

$today = mdate($datestring, $time);

$getcountries = "Select c.country from tbl_staffs as a left join tbl_office as b on (a.offc_id=b.office_id) left join countries as c on (b.country = c.cntry_id) where a.status = 'Active' group by c.country asc";

$getcountries = $this->db->query($getcountries);

$getcandcountries = "Select c.country from candidate as a left join countries as c on (a.country_code = c.ccode) where a.status = 'Active' group by c.country asc";

$getcandcountries = $this->db->query($getcandcountries);

$getallcountries = "Select c.country, c.ccode from countries as c group by c.country asc";

$getallcountries = $this->db->query($getallcountries);
	
if ($uid == '1') {  // 1 denotes employees

	// For getting title name
  $qdes['table'] = 'qdesigner';
  $qdes['where']['qDesignerId'] = $qid;
  $qdes = getsingle($qdes);
  $title = $qdes['title'];



  
?>

<div id="sucess-msg"></div>
	<div data-role="content" >
		<div class="content-primary">
			<ul data-role="listview" data-inset='true' data-filter='true' >
				<?php
					$date = explode("-",$today);
					
					$year = $date[0];
					$nextyear = $year+1;
					$month = $date[1];
					$day = $date[2];
				foreach($getcountries->result() as $getcountry){
				
				$country_name = $getcountry->country;
				
				?>
				
				<li data-role="list-divider" data-theme="a"><?php print $country_name?></li>
				<?php
				
					$getemplist = "select * from tbl_staffs as a  left join assigned_users as b on (a.staff_id = b.user_id and b.qid= ".$qid.") left join tbl_office as c on (a.offc_id = c.office_id) left join countries as d on (c.country = d.cntry_id) where a.status='Active' and d.country = '".$country_name."'  LIMIT 0, 10  ";
 
					$getemplist = $this->db->query($getemplist);
					
					
					foreach ($getemplist->result() as $row) {
						

						$st = 'bhr' . $row->staff_id;
						$staff_id =  $row->staff_id;
						$assign_status=$row->assign_status;
						
						$completed_status = $row->c_status;
						
						$scheduled_date = $row->scheduled_date;
						
						$scheduled_date = empty($scheduled_date)?"":"Scheduled Date is ".$scheduled_date;
						$img_url = 'http://198.1.110.184/~geniuste/gg/'.$row->photo;
						//$img_url = '';
						$img = empty($row->photo)? base_url('images/cands.jpg') : $img_url;
						$str = ucfirst(strtolower($row->first_name)) . "&nbsp;" . ucfirst(strtolower($row->last_name));
						if($assign_status == 'Active')
							$status_val='Reschedule';
						else
							$status_val='Schedule';
							//if($completed_status != 1){
				?>
						<li data-theme='b'><a  class='$st bhr'  href='javascript:void(0);'  >
										<img src='<?php print $img ?>' style='padding-top:10px;padding-left:10px;'>
										<h2><?php print $str ?></h2>
										<p align='center'>
											<?php
											if($completed_status == 1){
											?>
												<a href='#' data-rel='popup' data-position-to='window' data-role='button' data-inline='true' data-icon='check' data-theme='a' data-mini='true' data-transition='pop'>Completed</a> 	
											<?php
											}
											else{
											if($assign_status == 'Active'){
											?>
										<a href='#scheduled_popup<?php print $staff_id ?>' data-rel='popup' data-position-to='window' data-role='button' data-inline='true' data-icon='check' data-theme='a' data-mini='true' data-transition='pop'><?php print $status_val ?></a> 
										
										
										<!--<a href="#remove_schedule<?php //print $uid.$staff_id.$qid ?>" data-rel="popup" data-position-to="window" data-role="button" data-inline="true" data-transition="pop" data-icon="delete" data-theme="a" data-mini="true">Remove</a>-->
										<a href="" class="user_remove" id="<?php print $staff_id ?>"  data-role="button" data-inline="true"  data-icon="delete" data-theme="a" data-mini="true">Remove</a>
										
						<div data-role="popup" id="<?php print $uid.$staff_id.$qid ?>" data-overlay-theme="a" data-theme="c" data-dismissible="false" style="max-width:400px;" class="ui-corner-all">
							<div data-role="header" data-theme="a" class="ui-corner-top">
								<h1>Remove user from Exam?</h1>
							</div>
							<div data-role="content" data-theme="d" class="ui-corner-bottom ui-content">
								<h3 class="ui-title">Remove user from this exam?</h3>
								
								<a href="#" data-role="button" data-inline="true" data-rel="back" data-theme="c" data-mini="true">	Cancel</a>
								<a href="" data-role="button" data-inline="true"  data-transition="flow" data-theme="b" data-mini="true">Delete </a>
							</div>
						</div>		
										
										<?php } 
								
										
										else {
											?>
										<a href='#scheduled_popup<?php print $staff_id ?>' data-rel='popup' data-position-to='window' data-role='button' data-inline='true' data-icon='check' data-theme='a' data-mini='true' data-transition='pop'><?php print $status_val ?></a> 	
										
										
										<?php	
										}
									}
										?>
										
										
										</p>
										
										<!-- pop up for remove a scheduled exam-->
										

										
		<?php								
		print "<div data-role='popup' id='popupMenu".$staff_id."' data-theme='a'>
		<div data-role='popup' id='scheduled_popup".$staff_id."' data-theme='a' class='ui-corner-all'>
			<form id='schedule_exam".$staff_id."' method='post' action='".site_url('exam/user_selection')."'>
				<div id='schedule_success".$staff_id."'></div>
				<div style='padding:10px 20px;'>
				<fieldset data-role='controlgroup' data-type='horizontal' data-mini='true'>
					<legend>Scheduler</legend>
					<legend>".$scheduled_date."</legend>
					
					<label for='scheduled_day'>Scheduled Day</label>
						<select name='scheduled_day' id='scheduled_day'>
						";
    
				
					for($i=1;$i<=31;$i++){
					?>
						<option value='<?php print $i;?>'  <?php if($day == $i) { ?> selected <?php } ?> ><?php print $i; ?></option>
					<?php 	
					} 
    
					print"</select>";
					?>
						<label for='scheduled_month'>Scheduled Month</label>
						<select name='scheduled_month' id='scheduled_month'>
							<option value='01'<?php if($month == '01') { ?> selected <?php } ?> >January</option>
							<option value='02'<?php if($month == '02') { ?> selected <?php } ?> >February</option>
							<option value='03'<?php if($month == '03') { ?> selected <?php } ?> >March</option>
							<option value='04'<?php if($month == '04') { ?> selected <?php } ?> >April</option>
							<option value='05'<?php if($month == '05') { ?> selected <?php } ?> >May</option>
							<option value='06'<?php if($month == '06') { ?> selected <?php } ?> >June</option>
							<option value='07'<?php if($month == '07') { ?> selected <?php } ?> >July</option>
							<option value='08'<?php if($month == '08') { ?> selected <?php } ?> >August</option>
							<option value='09'<?php if($month == '09') { ?> selected <?php } ?> >September</option>
							<option value='10'<?php if($month == '10') { ?> selected <?php } ?> >October</option>
							<option value='11'<?php if($month == '11') { ?> selected <?php } ?> >November</option>
							<option value='12'<?php if($month == '12') { ?> selected <?php } ?> >December</option>
						</select>
					<?php
						
					print"<label for='scheduled_year'>Scheduled Year</label>
					<select name='scheduled_year' id='scheduled_year'>
						<option value='".$year."'>".$year."</option>
						<option value='".$nextyear."'>".$nextyear."</option>
					</select>
				</fieldset>
							  
				<input type='hidden' value='".$uid."' name='uid'/>
				<input type='hidden' value='".$qid."' name='qid'/>
				<input type='hidden' value='".$entrydate."' name='entrydate'/>
				<input type='hidden' value='".$staff_id."' name='staff_id'/>";

        print"<button type='submit' data-theme='b' data-icon='check' name='assign' >Assign</button>";

       
        
      print"</div>
    </form>
  </div>
</div>
										
<div class='statusmsg'></div></a>";
			//}
			print"</li>  ";
						
ajaxform("schedule_exam".$staff_id,'schedule_success'.$staff_id);  			
						

		
		}
}
	
		?>

      </ul>
    </div>
  </div>
  <!--<div><input value='Assign' type="submit"  data-inline='true' data-mini='true'  data-theme='b'/></div>-->
  <div id="deleteQuestion" data-role='popup' style='width:250px; padding:50px; border:5px solid #B9B9B9;' data-theme='d'>
       You have added this user(s) to <?php echo $title; ?> exam
  <div class='clear'><br/><br/></div>
	<?php
		print button('Assign', '', 'delete_question');
		print close();
} 

// This is for candidate Details
else if($uid == '2'){

	?>

	<div id="sucess-msg"></div>
		<a href="#popupLogin" data-rel="popup" data-position-to="window" data-role="button" data-inline="true" data-icon="plus" data-theme="b" data-transition="pop">Add New Candidate</a>
		<div data-role="popup" id="popupMenu" data-theme="b">
			<div data-role="popup" id="popupLogin" data-theme="b" class="ui-corner-all">
				<a href="#" data-rel="back" data-role="button" data-theme="b" data-icon="delete" data-iconpos="notext" class="ui-btn-right">Close</a>
        <form id="addcandidate_recent" method="post" action="<?php print site_url("exam/newcandidate")  ?>">
        <div style="padding:10px 20px;">
          <div id="candidate_success_recent" ><h3>Please sign in</h3></div>
						<label for="un">Username:</label>
            <input name="user" id="un" value="" placeholder="username" data-theme="b" type="text">
            <label for="pw" >Password:</label>
            <input name="pass" id="pw" value="" placeholder="password" data-theme="b" type="password">
            <label for="fn" >Firstname</label>
            <input name="firstname" id="fn" value="" placeholder="firstname" data-theme="b" type="text">
            <label for="ln" >Lastname</label>
            <input name="lastname" id="ln" value="" placeholder="lastname" data-theme="b" type="text">
            <label for="email" >Email</label>
            <input name="email" id="email" value="" placeholder="email" data-theme="b" type="text">
            <label for="country_code" >Select Country	</label>
						<select name="country_code" id="country_code" data-mini="true">
								<?php
								
			
				foreach($getallcountries->result() as $getallcountries){
				
				$country_name = $getallcountries->country;
				$country_code = $getallcountries->ccode;
				
				print "<option value='".$country_code."'>".$country_name."</option>";
				
			}
			
?>
						</select>
						<br><br>
            <button type="submit" data-theme="b" data-inline="true" >Save</button>
          </div>
					</form>
			</div>
		</div>
		
		<div data-role="content" >
			<div class="content-primary">
				<ul data-role="listview" data-inset='true' data-filter='true'>
        <?php
        $temp='';
        
        $date = explode("-",$today);
					
					$year = $date[0];
					$nextyear = $year+1;
					$month = $date[1];
					$day = $date[2];
        /*foreach ($co['result'] as $row) {
					$code = $row['code'];
					$cname = $row['name'];
					if($temp != $cname){*/
					
					foreach($getcandcountries->result() as $getcountry){
				
					$country_name = $getcountry->country;
					
					if($temp != $country_name){
				?>
					<li data-role="list-divider" data-theme='a'> <?php print $country_name; ?></li>
				<?php
					}
				
					/*$candlist['table'] = 'candidate';
					$candlist['order']['first_name'] = 'asc';
					$candlist['join']['assigned_users']='candidate.candidate_id=assigned_users.user_id and qid="'.$qid.'"';
					$candlist['where']['country_code'] = $code;
					$candlist['where']['status'] = 'Active';
					$candlist['limit']=1000000;
					$candlist = getrecords($candlist);*/
					
					$getcandlist = "select * from candidate as a  left join assigned_users as b on (a.candidate_id = b.user_id and b.qid= ".$qid.") left join countries as d on (a.country_code = d.ccode) where a.status='Active' and d.country = '".$country_name."'";
					
					$getcandlist = $this->db->query($getcandlist);
					
					foreach ($getcandlist->result() as $row) {

					
						$st = 'bhr' . $row->candidate_id;
						$cand_id =  $row->candidate_id;
						$scheduled_date = $row->scheduled_date;
						
						$completed_status = $row->c_status;
						
						
						$scheduled_date = empty($scheduled_date)?"":"Scheduled Date is ".$scheduled_date;
						$assign_status=$row->assign_status;
						
						$cand_status=$row->status;
						
						//print "Candidate Status".$cand_status;
						
						if($assign_status == 'Active')
							$status_val='Reschedule';
						else
							$status_val='Schedule';
						$str = ucfirst(strtolower($row->first_name)) . "&nbsp;" . ucfirst(strtolower($row->last_name));
							//if($completed_status != 1){
							?>	
					<li data-theme='b'><a  class='$st bhr'  href='javascript:void(0);'  >
										<img src='<?php print base_url('images/cands.jpg'); ?>'  style='padding-top:10px;padding-left:10px;'>
										<h2><?print $str; ?></h2>
										
										
										<p align='center'>
											<?php
												if($completed_status == 1){
											?>
												<a href='#' data-rel='popup' data-position-to='window' data-role='button' data-inline='true' data-icon='check' data-theme='a' data-mini='true' data-transition='pop'>Completed</a> 	
											<?php
											}
											else{
											
											if($assign_status == 'Active'){
											?>
										<a href='#scheduled_popup<?php print $cand_id ?>' data-rel='popup' data-position-to='window' data-role='button' data-inline='true' data-icon='check' data-theme='a' data-mini='true' data-transition='pop'><?php print $status_val ?></a> 
										
										
										<!--<a href="#remove_schedule<?php //print $uid.$staff_id.$qid ?>" data-rel="popup" data-position-to="window" data-role="button" data-inline="true" data-transition="pop" data-icon="delete" data-theme="a" data-mini="true">Remove</a>-->
										<a href="" class="user_remove" id="<?php print $cand_id ?>"  data-role="button" data-inline="true"  data-icon="delete" data-theme="a" data-mini="true">Remove</a>
										
						<div data-role="popup" id="<?php print $uid.$cand_id.$qid ?>" data-overlay-theme="a" data-theme="c" data-dismissible="false" style="max-width:400px;" class="ui-corner-all">
							<div data-role="header" data-theme="a" class="ui-corner-top">
								<h1>Remove user from Exam?</h1>
							</div>
							<div data-role="content" data-theme="d" class="ui-corner-bottom ui-content">
								<h3 class="ui-title">Remove user from this exam?</h3>
								
								<a href="#" data-role="button" data-inline="true" data-rel="back" data-theme="c" data-mini="true">	Cancel</a>
								<a href="" data-role="button" data-inline="true"  data-transition="flow" data-theme="b" data-mini="true">Delete </a>
							</div>
						</div>		
										
										<?php } 
										else {
											?>
										<a href='#scheduled_popup<?php print $cand_id ?>' data-rel='popup' data-position-to='window' data-role='button' data-inline='true' data-icon='check' data-theme='a' data-mini='true' data-transition='pop'><?php print $status_val ?></a> 	
										
										
										<?php	
										}
									}
										?>
										
										
										
										
										</p>
										
												<?php								
		print "<div data-role='popup' id='popupMenu".$cand_id."' data-theme='a'>
		<div data-role='popup' id='scheduled_popup".$cand_id."' data-theme='a' class='ui-corner-all'>
			<form id='schedule_exam".$cand_id."' method='post' action='".site_url('exam/user_selection')."'>
				<div id='schedule_success".$cand_id."'></div>
				<div style='padding:10px 20px;'>
				<fieldset data-role='controlgroup' data-type='horizontal' data-mini='true'>
					<legend>Scheduler</legend>
					<legend>".$scheduled_date."</legend>
					
					<label for='scheduled_day'></label>
						<select name='scheduled_day' id='cand_scheduled_day'>
						";
    
				
					for($i=1;$i<=31;$i++){
					?>
						<option value='<?php print $i;?>'  <?php if($day == $i) { ?> selected <?php } ?> ><?php print $i; ?></option>
					<?php 	
					} 
    
					print"</select>";
					?>
						<label for='scheduled_month'></label>
						<select name='scheduled_month' id='cand_scheduled_month'>
							<option value='01'<?php if($month == '01') { ?> selected <?php } ?> >January</option>
							<option value='02'<?php if($month == '02') { ?> selected <?php } ?> >February</option>
							<option value='03'<?php if($month == '03') { ?> selected <?php } ?> >March</option>
							<option value='04'<?php if($month == '04') { ?> selected <?php } ?> >April</option>
							<option value='05'<?php if($month == '05') { ?> selected <?php } ?> >May</option>
							<option value='06'<?php if($month == '06') { ?> selected <?php } ?> >June</option>
							<option value='07'<?php if($month == '07') { ?> selected <?php } ?> >July</option>
							<option value='08'<?php if($month == '08') { ?> selected <?php } ?> >August</option>
							<option value='09'<?php if($month == '09') { ?> selected <?php } ?> >September</option>
							<option value='10'<?php if($month == '10') { ?> selected <?php } ?> >October</option>
							<option value='11'<?php if($month == '11') { ?> selected <?php } ?> >November</option>
							<option value='12'<?php if($month == '12') { ?> selected <?php } ?> >December</option>
						</select>
					<?php
						
					print"<label for='scheduled_year'></label>
					<select name='scheduled_year' id='cand_scheduled_year'>
						<option value='".$year."'>".$year."</option>
						<option value='".$nextyear."'>".$nextyear."</option>
					</select>
				</fieldset>
							  
				<input type='hidden' value='".$uid."' name='uid'/>
				<input type='hidden' value='".$qid."' name='qid'/>
				<input type='hidden' value='".$entrydate."' name='entrydate'/>
				<input type='hidden' value='".$cand_id."' name='staff_id'/>";

        print"<button type='submit' data-theme='b' data-icon='check' name='assign' >Assign</button>";

       
        
      print"</div>
    </form>
  </div>
</div>
										
";
						
ajaxform("schedule_exam".$cand_id,'schedule_success'.$cand_id); 
?>										
										

										<?php
										print"<a href='".site_url('exam/editcandidate/'.$row->candidate_id). "'  data-icon='grid'  data-rel='dialog'>Edit Candidate</a>";
										
										
										?>
										<div class='statusmsg'></div></a>
										<?php //} ?>
										</li>  
				<?php						
					}
	        $temp=$country_name;
        }
        ?>
				</ul>
			</div>
		</div>
		
		
		
		
  
		<!--<div data-role='popup' id='editcandidate' data-theme='b'>
      <ul data-role='listview' data-inset='true' style='min-width:210px;' data-theme='d' data-filter='false'>
        <li data-role='divider' data-theme='b'>Choose an action</li>
        <li><a href='#popupLogin' data-rel="popup" data-position-to="window" id='"<?php //print $row->candidate_id ?>"' class='editlogin' >Add</a></li>
        <li><a href='#'>Delete</a></li>
      </ul>
		</div>	-->		-

		<!--<div id="deleteQuestion" data-role='popup' style='width:250px; padding:50px; border:5px solid #B9B9B9;' data-theme='d'>
    You have added this user(s) to <?php //echo $title; ?> exam
			<div class='clear'><br/><br/></div>-->
			<?php
				//print button('Assign', '', 'delete_question');
				//print close();
}
?>
</div>
       
<?php
	$script = "
	
	
		
		
	// This is for multiple selection of candidate and assign them to an exam		
	$('#testid').submit(function(){
		//val=$('.chkbox').val();
		//alert(val);
		var str = $('form').serialize();
		$.post('".site_url('exam/test/')."',{chkvalue:str,date:$entrydate},function(data){
			alert(data);
		});
		
		});
		
		$('.editcandidate').click(function(){
			clickid=this.id;
			//alert(clickid);
			$('.editlogin').append('<a>Edit</a>');
			});

			
		$('.userassign').click(function(){
			clickId=this.id;
			
			$.post('".site_url('exam/user_selection/')."',{clkid:clickId,qid:$qid,uid:$uid,entrydate:$entrydate},function(data){
			
			if(data==0)
			{	
				//alert('Removed');
				$('#test'+clickId).html('Assign');
			}
			else if(data==1)
			{
				//alert('Assigned');
				$('#test'+clickId).html('Remove');
			}
			else{
			alert('Error Occured!!!');
		}
		});
			
			});	
			
			$('.user_remove').click(function(){
				
				val = this.id;
				//alert(val);
					$.post('".site_url('exam/user_remove/')."',{staff_id:val,qid:$qid,uid:$uid,entrydate:$entrydate},function(data){
							if(data==0)
							{	
									window.setTimeout('location.reload()', 1000);
							}
						
					});
			});	
			
			
		";
	print ready($script);
	
 ajaxform("addcandidate_recent",'candidate_success_recent');  

?>
