<?php
	$this->benchmark->mark('code_start'); //  for checking the loading performance
	$pagination = $this->pagination->create_links(); // for creating pagination links
?>

<div align='center'>
	<div data-role='navbar' >
		<?php print $pagination; ?>
	</div>
	<div data-role='collapsible-set'>
  <?php
		
		$timestamp = gmdate("Y-m-d-H-i-s", $today);
		$date = explode("-",$timestamp);
				
		$year = $date[0];
		$nextyear = $year+1;
		$month = $date[1];
		$day = $date[2];
		//$hour = $date[3];
		//$minute = $date[4];
		//$ampm = $date[5];

  
    if (!empty($results)) {
      foreach ($results as $o) {
				$a=$o->mocktest;
				if($a == 'on'){	$mocktest="This is a mock test"; }
				else{	$mocktest="";}
        if ($o->status == 1){	$st = "Active";}
        else{ $st = "Inactive"; }
        
       	

  ?>  
		<div id="remove-response"></div>      
		<div data-role="collapsible" <?php print (strtolower($o->status) == 1) ? " data-collapsed-icon='check' " : " data-collapsed-icon='delete' "; ?>  data-content-theme="c"  >
			<h3><?php echo ucfirst($o->title); ?></h3> 
			<table width="100%">
				<tr>
					<td > 
						<div ><h4>Status :<?php echo $st ?></h4></div>
						<div ><h4><?php echo $mocktest ?></h4></div>
					</td>
					<td width="100px">  
					<?php
					$examid = $o->qDesignerId;
					if ($o->status == 1) {
						if($roleid == 0){
					?>
						<a href="#popupMenu1<?php print $examid; ?>" data-rel="popup" data-role="button"   data-theme="b" data-mini="true" data-inline="true" data-icon="check" class="assign" id="<?php print $examid;?>" >Assign</a>            
					</td>
          
          <!--<td width="100px">
						<a href="#popupSchedule<?php //print $examid; ?>" data-rel="popup"  data-position-to="window" data-role="button" data-theme="b"  data-transition="pop"  data-mini="true" data-inline="true" data-icon="gear">Schedule</a>  -->
						
					</td>
					
					<td width="100px">
						<a href="<?php echo site_url('exam/execute/' . $examid); ?>" data-role="button" data-theme="b" data-mini="true" data-inline="true" data-icon="gear">Execute</a>                   
					</td>
					<td width="100px">            
						<a href="#validateExam<?php print $examid; ?>" data-rel="popup" data-role="button" data-inline="true" data-icon="grid" data-theme="b" data-mini="true" data-transition="pop" data-inline="true">Validate Exam</a>              
					</td>
					<td width="100px">
						<a href="<?php echo site_url('exam/form/' . $examid ); ?>" data-role="button" data-theme="b" data-mini="true" data-inline="true" data-icon="grid">Edit</a>                   
					</td>
					<td width="100px">
						<a href="#qpdelete<?php print $examid; ?>" data-rel="popup" data-position-to="window" data-role="button" data-mini="true" data-inline="true" data-transition="pop" data-icon="delete" data-theme="b">Delete</a>
						<div data-role="popup" id="qpdelete<?php print $examid; ?>" data-overlay-theme="a" data-theme="c" data-dismissible="false" style="max-width:400px;" class="ui-corner-all">
							<div data-role="header" data-theme="a" class="ui-corner-top">
								<h1>Delete Exam</h1>
							</div>
							<div data-role="content" data-theme="d" class="ui-corner-bottom ui-content">
								<h3 class="ui-title">Are you sure you want to delete this Exam </h3>
								<a href="#" data-role="button" data-inline="true" data-rel="back" data-theme="c">Cancel</a>
								<a href="#" id="<?php print $examid; ?>" class="exam-delete" data-role="button" data-inline="true" data-transition="flow" data-theme="b">Delete</a>
							</div>
						</div>
					</td>
					<?php 
						}
						else{
					?>
					<td width="100px">         
						<a href="#startExam<?php print $examid; ?>" data-role="button" data-rel="popup" data-position-to="window" data-mini="true" data-inline="true" data-theme="b" data-transition="pop">Attend</a>
					</td>
       		<div data-role="popup" id="startExam<?php print $examid; ?>" data-overlay-theme="a" data-theme="c" data-dismissible="false" style="max-width:400px;" class="ui-corner-all">
						<div data-role="header" data-theme="a" class="ui-corner-top">
							<h1>Start Exam</h1>
						</div>
						<div data-role="content" data-theme="d" class="ui-corner-bottom ui-content">
							<h3 class="ui-title">Are you ready to start this Exam now?</h3>
							<a href="#" data-role="button" data-inline="true" data-rel="back" data-theme="c">Exit</a>
							<a href="<?php echo site_url('manage/exam/' . $examid.'/'.$a); ?>" data-role="button" data-inline="true" data-theme="b" id="<?php print $examid;?>" class="start_exam_count">Start Exam </a>
						</div>
					</div>
						
					<?php	
						}
					}
					?>
				</tr>
			</table>
		</div>
		
		
		
<div data-role="popup" id="popupMenu1<?php print $examid?>" data-theme="none">
    <div data-role="collapsible-set" data-theme="b" data-content-theme="c" data-collapsed-icon="arrow-r" data-expanded-icon="arrow-d" style="margin:0; width:250px;">
        <div data-role="collapsible" data-inset="false">
            <h2>Employees</h2>
            <ul data-role="listview">
							<?php
								foreach($getcountries as $row){
									$cntry_code = $row->cntry_id;
									$cntry_name = $row->country;
									print "<li><a href='".site_url('exam/assigneelist/1/'. $examid.'/'.$cntry_code.'/'.$cntry_name)."' >".$cntry_name."</a></li>";
								}
							?>
            </ul>
        </div><!-- /collapsible -->
        <div data-role="collapsible" data-inset="false">
            <h2>Candidatess</h2>
            <ul data-role="listview">
							<?php
              	foreach($getcandcountries as $row){
									$cntry_code = $row->cntry_id;
									$cntry_name = $row->country;
									print "<li><a href='".site_url('exam/assigneelist/2/'. $examid.'/'.$cntry_code.'/'.$cntry_name)."' >".$cntry_name."</a></li>";
								}
							?>
            </ul>
        </div><!-- /collapsible -->
      </div><!-- /collapsible set -->
</div><!-- /popup -->
		
		
		<!-- pop up menu for assign exam -->   
		<!--<div data-role="popup" id="popupMenu1<?php //print $examid?>" data-theme="a" data-mini='true'>
			<ul data-role="listview" data-inset="true" style="min-width:210px;" data-theme="b" data-mini='true'>
				<li class='qvalue'><a href="<?php //print site_url('exam/assigneelist/1/'. $examid);?>" data-mini='true'>Employees</a></li>
				<li><a href="<?php //print site_url('exam/assigneelist/2/' . $examid);?>" data-mini='true'>Candidates</a></li> 
			</ul>
		</div>-->
		<!-- pop up menu for assign exam Ends here-->  
		
		<!-- pop up menu for validate exam -->
		<div data-role="popup" id="validateExam<?php print $examid; ?>" data-theme="none">
			<div data-role="collapsible-set" data-theme="b" data-content-theme="c" data-collapsed-icon="arrow-r" data-expanded-icon="arrow-d" style="margin:0; width:250px;">
				<div data-role="collapsible" data-inset="false">
					<h2>Employees</h2>
					<?php
						$date=0;
										
						$join = array('tbl_1' => 'assigned_users','p1' => 'staff_id', 'p2' => 'user_id');
						$where = array('tbl_staffs.status' => 'Active','assigned_users.c_status'=>'1','assigned_users.type'=>'1','assigned_users.qid'=>$examid);
						$select = array('tbl_staffs.first_name','tbl_staffs.last_name','assigned_users.user_id');
						$getemp_type = $this->common_model->get_record_groupby('tbl_staffs',$join,'',$where,'','',$select);
		
						//print_r($getemp_type);
						if($getemp_type >0){
					?>
							<ol data-role="listview"  data-filter="true" data-inset="true">
							<?php
								foreach ($getemp_type as $row){
									$user_id = $row->user_id;
									$emp_name = $row->first_name;
									$flag = 1;
									
							?>
								<li><a href="#reviewExam<?php print $examid; ?>" data-rel="popup" data-position-to="window" data-inline="true" data-transition="pop"><?php echo $emp_name; ?></a></li>
								<div data-role="popup" id="reviewExam<?php print $examid; ?>" data-overlay-theme="a" data-theme="c" data-dismissible="false" style="max-width:400px;" class="ui-corner-all">
									<div data-role="header" data-theme="a" class="ui-corner-top">
										<h1>Review Exam</h1>
									</div>
									<div data-role="content" data-theme="d" class="ui-corner-bottom ui-content">
										<h3 class="ui-title">Are you ready to review this Exam now?</h3>
										<a href="#" data-role="button" data-inline="true" data-rel="back" data-theme="c">Exit</a>
										<a href="<?php echo site_url('manage/exam/' . $examid.'/'.$a.'/'.$date.'/'.$user_id.'/'.$flag); ?>" data-role="button" data-inline="true" data-theme="b">Review Exam</a>
									</div>
								</div>
							<?php
								}
							?>
							</ol>  
					<?php
						}
						else{
					?>
					<ul data-role="listview" data-autodividers="false" data-filter="true" data-inset="true">
						<li><b>No employees are available!!!</b></li>
					</ul>
					<?php 
						}
					?>     
				</div>
				<div data-role="collapsible" data-inset="false">
					<h2>Candidates</h2>
					<?php 
		
						$get_type="SELECT cand.first_name,cand.last_name,assign.user_id from candidate as cand,assigned_users as assign where cand.candidate_id = assign.user_id and assign.c_status=1 and assign.type='2' and assign.qid=".$examid;
		
						$rslt_cand = $this->login_db->get_results($get_type);					
						if($rslt_cand >0){
					?>
					<ol data-role="listview"  data-filter="true" data-inset="true">
					<?php
						foreach ($rslt_cand as $cand){
							$user_id = $cand->user_id;
							$cand_name = $cand->first_name;
							$flag = 2;
					?>
					<li><a href="#reviewExamCand<?php print $user_id.$examid ; ?>" data-rel="popup" data-position-to="window" data-inline="true" data-transition="pop"><?php echo $cand_name; ?></a></li>
							
					<div data-role="popup" id="reviewExamCand<?php print $user_id.$examid; ?>" data-overlay-theme="a" data-theme="c" data-dismissible="false" style="max-width:400px;" class="ui-corner-all">
						<div data-role="header" data-theme="a" class="ui-corner-top">
							<h1>Review Exam</h1>
						</div>
			
						<div data-role="content" data-theme="d" class="ui-corner-bottom ui-content">
							<h3 class="ui-title">Are you ready to review this Exam now?</h3>
							<a href="#" data-role="button" data-inline="true" data-rel="back" data-theme="c">Exit</a>
							<a href="<?php echo site_url('manage/exam/' . $examid.'/'.$a.'/'.$date.'/'.$user_id.'/'.$flag); ?>" data-role="button" data-inline="true" data-theme="b">Review Exam</a>
						</div>
					</div>
          <?php
						}
					?>
					</ol>
					<?php
						}
						else{
					?>
					<ul data-role="listview" data-autodividers="false" data-filter="true" data-inset="true">
						<li><b>No Candidates are available!!!</b></li>
					</ul>
					<?php }?>
				</div><!-- /collapsible -->
			</div><!-- /collapsible set -->
		</div>
		<!-- pop up menu for validate exam Ends here-->
		
		
		
		<?php
			}
		}
		else{
			print "<font color='red' size='+1'>No exams assigned to you. Try again Later!!!</font>";
		}
  ?>
	</div>
	<div data-role='navbar' >
		<?php print $pagination; ?>
	</div>
</div> 




<?php
$this->benchmark->mark('code_end');
echo $this->benchmark->elapsed_time('code_start', 'code_end');
$script="

	$('.exam-delete').click(function(){
		value = this.id;
		$.post('".site_url('exam/remove')."',{clkid:value},function(data){
			$('#remove-response').html(data);
		});
	});

	var d = new Date();
	var year = d.getFullYear();
	var month = d.getMonth()+1;
	var day = d.getDate();
	var hour = d.getHours();
	var minute = d.getMinutes();
	var second = d.getSeconds();

	var currentdatetime = year + '-' + month + '-' + day + ' ' + hour + ':' + minute + ':' + second;

	$('.start_exam_count').click(function(){

		var qiid = this.id;
		$.post('".site_url('exam/start_exam_time')."',{qid:qiid,userid:$userid,roleid:$roleid,currdate:currentdatetime},function(data){
	
			//alert(data);
		});
	});

";

print ready($script);

?>
	
