<?php
	$this->benchmark->mark('code_start'); //  for checking the loading performance
	// For getting current date
	$entrydate=entrydate();
	//print_r($getcountries);
	$pagination = $this->pagination->create_links(); // for creating pagination links

	//print_r($country_name);
	
	$getallcountries = "Select c.country, c.ccode from countries as c group by c.country asc";

	$getallcountries = $this->db->query($getallcountries);
	
	if ($uid == '1') {  // 1 denotes employees
		// For getting title name
		$qdes['table'] = 'qdesigner';
		$qdes['where']['qDesignerId'] = $qid;
		$qdes = getsingle($qdes);
		$title = $qdes['title'];
?>
		
		<a href="#"  data-role="button" data-inline="true" id='empSchedule'>Schedule</a>
		<p>&nbsp;</p>
				<div align='center'>
					<div data-role='navbar' >
						<?php //print $pagination; ?>
					</div>
				</div>
				<ul data-role="listview" data-inset='true' data-filter='true' id='emplistopen'>
				<?php
					$date = explode("-",$today);
					
					$year = $date[0];
					$nextyear = $year+1;
					$month = $date[1];
					$day = $date[2];
					
					$hour = $date[3];
					$minute = $date[4];
					$second = $date[5];
							
					foreach ($getemplist as $row) {
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
						print "
							<li  id='emp".$staff_id."' >
								<a href='#'  style='padding-top: 0px;padding-bottom: 0px;padding-right: 42px;padding-left: 0px;'  >
									<label style='border-top-width: 0px;margin-top: 0px;border-bottom-width: 0px;margin-bottom: 0px;border-left-width: 0px;border-right-width: 0px;' data-corners='false'>
										<fieldset data-role='controlgroup'>                                                        
											<input type='checkbox' class='empnames' name='checkbox-2b' id='checkbox_".$staff_id."' value='".$staff_id."'/>                   
											<label for='checkbox-2b' style='border-top-width: 0px;margin-top: 0px;border-bottom-width: 0px;margin-bottom: 0px;border-left-width: 0px;border-right-width: 0px;'>
												<img src='".$img."' style='float:left;width:80px;height:80px'/>
												<label  style='float:left;padding:10px 0px 0px 10px;'> 
													<h3>".$str."</h3> 
												</label> 
											</label>
										</fieldset> 
									</label>
								</a>
							</li>";
					}	
				?>
				</ul>
				<input type='button' value='Load More' data-theme='b' name='loadmoreemp' id='loadmoreemp'/>
				<div data-role="popup" id="empPopup" data-theme="a">
					<div data-role="popup" id="empAssign" data-theme="a" class="ui-corner-all">
						<form action='<?php print site_url('exam/assignemp');?>' method='post' id='assign_emp_form'>
							<div style="padding:10px 20px;">
								<h3>Schedule Exam</h3>
                <p id='assign_emp_result'></p> 
								<fieldset data-role="controlgroup" data-type="horizontal" data-mini="true">
									<legend>From Date and Time</legend>
									<label for="from_day">Scheduled Day</label>
									<select name="from_day" id="from_day">
									<?php
										for($i=1;$i<=31;$i++){
									?>
										<option value='<?php print $i;?>'  <?php if($day == $i) { ?> selected <?php } ?> ><?php print $i; ?></option>
									<?php 	
										} 
									?>
									</select>	
									<label for="from_month">Scheduled Month</label>
									<select name='from_month' id='from_month'>
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
									<label for="from_year">Scheduled Year</label>
									<select name="from_year" id="from_year">
									<?php
										print"<option value='".$year."'>".$year."</option>
										<option value='".$nextyear."'>".$nextyear."</option>";
									?>
									</select>
									<label for="from_hour">Scheduled Hour</label>
									<select name="from_hour" id="from_hour">
									<?php
										for($j=1;$j<=23;$j++){
											if($j<10)
												$j = "0".$j;
									?>
										<option value='<?php print $j;?>'  <?php if($hour == $j) { ?> selected <?php } ?> ><?php print $j; ?></option>
									<?php 	
										} 
									?>
									</select>	
									<label for="from_minute">Scheduled Minute</label>
									<select name="from_minute" id="from_minute">
									<?php
										for($k=1;$k<=59;$k++){
											if($k<10)
												$k = "0".$k;
									?>
											<option value='<?php print $k;?>'  <?php if($minute == $k) { ?> selected <?php } ?> ><?php print $k; ?></option>
									<?php 	
										} 
									?>
									</select>	
								</fieldset>
					
								<fieldset data-role="controlgroup" data-type="horizontal" data-mini="true">
									<legend>To Date and Time</legend>
									<label for="to_day">Scheduled Day</label>
									<select name="to_day" id="to_day">
									<?php
										for($i=1;$i<=31;$i++){
									?>
											<option value='<?php print $i;?>'  <?php if($day == $i) { ?> selected <?php } ?> ><?php print $i; ?></option>
									<?php 	
										} 
									?>
									</select>	
									<label for="to_month">Scheduled Month</label>
									<select name='to_month' id='to_month'>
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
									<label for="to_year">Scheduled Year</label>
									<select name="to_year" id="to_year">
									<?php
										print"<option value='".$year."'>".$year."</option>
										<option value='".$nextyear."'>".$nextyear."</option>";
									?>
									</select>
									<label for="to_hour">Scheduled Hour</label>
										<select name="to_hour" id="to_hour">
										<?php
											for($j=1;$j<=23;$j++){
												if($j<10)
													$j = "0".$j;
										?>
												<option value='<?php print $j;?>'  <?php if($hour == $j) { ?> selected <?php } ?> ><?php print $j; ?></option>
										<?php 	
											} 
										?>
										</select>	
										<label for="to_minute">Scheduled Minute</label>
										<select name="to_minute" id="to_minute">
										<?php
											for($k=1;$k<=59;$k++){
												if($k<10)
													$k = "0".$k;
										?>
												<option value='<?php print $k;?>'  <?php if($minute == $k) { ?> selected <?php } ?> ><?php print $k; ?></option>
										<?php 	
											} 
										?>
									</select>	
								</fieldset>
                        
								<input type='hidden' value='' id='selected_emp' name='selected_emp' />
								<input type='hidden' value='<?php print $second; ?>' id='fromsec' name='fromsec' />
								<input type='hidden' value='<?php print $second; ?>' id='tosec' name='tosec' />
								<input type='hidden' value='<?php print $uid; ?>' name='uid'/>
								<input type='hidden' value='<?php print $qid; ?>' name='qid'/>
								<button type="submit" data-theme="b" data-icon="check">Assign</button>
								<?php print close(); ?>
							</div>
						</form>
						<?php
							ajaxform('assign_emp_form','assign_emp_result');
						?>
					</div>
				</div>
				<!--<div align='center'>
					<div data-role='navbar' >
						<?php //print $pagination; ?>
					</div>
				</div>-->
				
				<a href="#"  data-role="button" data-inline="true" id='empSchedule'>Options</a>
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
			<a href="#"  data-role="button" data-inline="true" id='candSchedule'>Schedule</a>
			<p>&nbsp;</p>
			<ul data-role="listview" data-inset='true' data-filter='true' id='candlistopen'>
				<div align='center'>
					<div data-role='navbar' >
						<?php //print $pagination; ?>
					</div>
				</div>
      <?php
        $temp='';
        $date = explode("-",$today);
					
				$year = $date[0];
				$nextyear = $year+1;
				$month = $date[1];
				$day = $date[2];
				
				$hour = $date[3];
				$minute = $date[4];
				$second = $date[5];

				foreach ($getcandlist as $row) {
					$st = 'bhr' . $row->candidate_id;
					$cand_id =  $row->candidate_id;
					$scheduled_date = $row->scheduled_date;
					
					$completed_status = $row->c_status;
											
					$scheduled_date = empty($scheduled_date)?"":"Scheduled Date is ".$scheduled_date;
					$assign_status=$row->assign_status;
					
					$cand_status=$row->status;
					$img = base_url('images/cands.jpg');
					//print "Candidate Status".$cand_status;
					
					if($assign_status == 'Active')
						$status_val='Reschedule';
					else
						$status_val='Schedule';
					$str = ucfirst(strtolower($row->first_name)) . "&nbsp;" . ucfirst(strtolower($row->last_name));
						//if($completed_status != 1){
					print "
						<li  id='cand".$cand_id."' >
							<a href='#'  style='padding-top: 0px;padding-bottom: 0px;padding-right: 42px;padding-left: 0px;'  >
								<label style='border-top-width: 0px;margin-top: 0px;border-bottom-width: 0px;margin-bottom: 0px;border-left-width: 0px;border-right-width: 0px;' data-corners='false'>
									<fieldset data-role='controlgroup'>                                                        
										<input type='checkbox' class='candnames' name='checkbox-2b' id='checkbox_".$cand_id."' value='".$cand_id."'/>                   
										<label for='checkbox-2b' style='border-top-width: 0px;margin-top: 0px;border-bottom-width: 0px;margin-bottom: 0px;border-left-width: 0px;border-right-width: 0px;'>
											<img src='".$img."' style='float:left;width:80px;height:80px'/>
											<label  style='float:left;padding:10px 0px 0px 10px;'> 
												<h3>".$str."</h3> 
											</label> 
										</label>
									</fieldset> 
								</label>
							</a>";
				print"<a href='".site_url('exam/editcandidate/'.$row->candidate_id). "'  data-icon='grid'  data-rel='dialog'>Edit Candidate</a>
					</li>";				
				}
      ?>
				<div align='center'>
					<div data-role='navbar' >
						<?php //print $pagination; ?>
					</div>
				</div>
			</ul>
			
			<input type='button' value='Load More' data-theme='b' name='loadmorecand' id='loadmorecand'/>
			<div data-role="popup" id="candPopup" data-theme="a">
				<div data-role="popup" id="candAssign" data-theme="a" class="ui-corner-all">
					<form action='<?php print site_url('exam/assigncand');?>' method='post' id='assign_cand_form'>
						<div style="padding:10px 20px;">
              <h3>Schedule Exam</h3>
              <p id='assign_cand_result'></p> 
              <fieldset data-role="controlgroup" data-type="horizontal" data-mini="true">
								<legend>From Date and Time</legend>
								<label for="from_day">Scheduled Day</label>
								<select name="from_day" id="from_day">
								<?php
									for($i=1;$i<=31;$i++){
								?>
										<option value='<?php print $i;?>'  <?php if($day == $i) { ?> selected <?php } ?> ><?php print $i; ?></option>
								<?php 	
									} 
								?>
								</select>	
								<label for="from_month">Scheduled Month</label>
								<select name='from_month' id='from_month'>
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
								<label for="from_year">Scheduled Year</label>
								<select name="from_year" id="from_year">
								<?php
									print"<option value='".$year."'>".$year."</option>
									<option value='".$nextyear."'>".$nextyear."</option>";
								?>
								</select>
								<label for="from_hour">Scheduled Hour</label>
								<select name="from_hour" id="from_hour">
								<?php
									for($j=1;$j<=23;$j++){
										if($j<10)
											$j = "0".$j;
								?>
											<option value='<?php print $j;?>'  <?php if($hour == $j) { ?> selected <?php } ?> ><?php print $j; ?></option>
								<?php 	
									} 
								?>
								</select>	
								<label for="from_minute">Scheduled Minute</label>
								<select name="from_minute" id="from_minute">
								<?php
									for($k=1;$k<=59;$k++){
										if($k<10)
											$k = "0".$k;
								?>
									<option value='<?php print $k;?>'  <?php if($minute == $k) { ?> selected <?php } ?> ><?php print $k; ?></option>
								<?php 	
									} 
								?>
								</select>	
							</fieldset>
					
							<fieldset data-role="controlgroup" data-type="horizontal" data-mini="true">
								<legend>To Date and Time</legend>
								<label for="to_day">Scheduled Day</label>
								<select name="to_day" id="to_day">
								<?php
									for($i=1;$i<=31;$i++){
								?>
										<option value='<?php print $i;?>'  <?php if($day == $i) { ?> selected <?php } ?> ><?php print $i; ?></option>
								<?php 	
									} 
								?>
								</select>	
								<label for="to_month">Scheduled Month</label>
								<select name='to_month' id='to_month'>
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
								<label for="to_year">Scheduled Year</label>
								<select name="to_year" id="to_year">
								<?php
									print"<option value='".$year."'>".$year."</option>
									<option value='".$nextyear."'>".$nextyear."</option>";
								?>
								</select>
								<label for="to_hour">Scheduled Hour</label>
								<select name="to_hour" id="to_hour">
								<?php
									for($j=1;$j<=23;$j++){
										if($j<10)
											$j = "0".$j;
								?>
										<option value='<?php print $j;?>'  <?php if($hour == $j) { ?> selected <?php } ?> ><?php print $j; ?></option>
								<?php 	
									} 
								?>
								</select>	
								<label for="to_minute">Scheduled Minute</label>
								<select name="to_minute" id="to_minute">
								<?php
									for($k=1;$k<=59;$k++){
										if($k<10)
											$k = "0".$k;
								?>
										<option value='<?php print $k;?>'  <?php if($minute == $k) { ?> selected <?php } ?> ><?php print $k; ?></option>
								<?php 	
									} 
								?>
								</select>	
							</fieldset>
              
              <input type='hidden' value='' id='selected_cand' name='selected_cand' />
							<input type='hidden' value='<?php print $second; ?>' id='fromsec' name='fromsec' />
							<input type='hidden' value='<?php print $second; ?>' id='tosec' name='tosec' />
							<input type='hidden' value='<?php print $uid; ?>' name='uid'/>
							<input type='hidden' value='<?php print $qid; ?>' name='qid'/>
              <button type="submit" data-theme="b" data-icon="check">Assign</button>
              <?php print close(); ?>
            </div>
					</form>
					<?php
						ajaxform('assign_cand_form','assign_cand_result');
					?>
					</div>
				</div>	
			<a href="#"  data-role="button" data-inline="true" id='candSchedule'>Options</a>
		</div>
	</div>
<?php
	}
?>
</div>
       
<?php
$this->benchmark->mark('code_end');
echo $this->benchmark->elapsed_time('code_start', 'code_end');
	$script = "
	
		$('#loadmoreemp').click(function (){	
			$.post('".site_url('exam/loadmore')."',function(data){ 
				$('#emplistopen').append(data); 
				$('#emplistopen').listview('refresh');
				$('input[type=\'checkbox\']').checkboxradio({ theme: 'c' });
			});
		});
				
		var empids=0;
		var empCount=0;
		var empArray=new Array();
		$('.empnames').click(function(){
			empids=empids+','+this.value;
			if ($(this).is(':checked')) {
				empCount=(empCount*1)+1;
				empArray.push(this.value);
			} 
			else {
				empCount=(empCount*1)-1; 
				var index = empArray.indexOf(this.value);
				empArray.splice(index, 1);	
			} 
			$('#selected_emp').val(empArray.toString());
			var qval = empArray.toString();
			//alert(empArray.toString());
		});
				
		$('#empSchedule').click(function(){
			if(empArray.toString() == ''){
				alert('Please select a user atleast !!!! ');}
			else{
				$( '#empAssign' ).popup( 'open' );
			}
		}); 
				
				
		// for candidate
				
		$('#loadmorecand').click(function (){	
			$.post('".site_url('exam/loadmorecand')."',function(data){ 
				$('#candlistopen').append(data); 
				$('#candlistopen').listview('refresh');
				$('input[type=\'checkbox\']').checkboxradio({ theme: 'c' });
			});
		});
				
		var candids=0;
		var candCount=0;
		var candArray=new Array();
		$('.candnames').click(function(){
			candids=candids+','+this.value;
		
			if ($(this).is(':checked')) {
				candCount=(candCount*1)+1;
				candArray.push(this.value);
			} 
			else {
				candCount=(candCount*1)-1; 
				var index = candArray.indexOf(this.value);
				candArray.splice(index, 1);	
			} 
			$('#selected_cand').val(candArray.toString());
			var qval = candArray.toString();
			//alert(candArray.toString());
		});
				
			
		$('#candSchedule').click(function(){
			if(candArray.toString() == ''){
				alert('Please select a user atleast !!!! ');}
			else{
				$( '#candAssign' ).popup( 'open' );
			}
		}); 
	
	";
	print ready($script);
	ajaxform("addcandidate_recent",'candidate_success_recent');  
?>
