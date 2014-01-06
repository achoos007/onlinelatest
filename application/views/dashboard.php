<style type='text/css'>
.menu-box{
padding:5px; 
background-color:#EBEBEB;  
border:1px outset #A1A1A1;
-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px; 
width:127px;
height:125px;
margin:10px;
float:left;
overflow:hidden;
}
.menu-image{
padding:5px; 
background-color:#EBEBEB;  
border:1px outset #A1A1A1;
-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px; 
height:75px;
overflow:hidden;
}
</style>


<?php
	$roleid = $this->session->userdata('roleid');
	if($roleid == 0){ 
		
		// getting candidate and employees result count
		
		$cand_count = $gettopresultcand->num_rows();
		$emp_count = $gettopresultemp->num_rows();
?>
<div data-role="collapsible-set" data-content-theme="c" >
	<div data-role="collapsible" data-theme="b" data-content-theme="b">
		<h3>Users </h3>
    <div class="ui-grid-a">
			<div class="ui-block-a"><div class="ui-bar ui-bar-a" style="height:auto">
				<p>Total Candidates &nbsp; (<?php print $total_cand; ?>)</p>
				<p>Active &nbsp; (<?php print $active_cand; ?>)</p>
				<p>Inactive &nbsp; (<?php print $inactive_cand; ?>)</p>
		  </div></div>
		  
			<div class="ui-block-b"><div class="ui-bar ui-bar-a" style="height:auto">
				<p>Total Employees &nbsp; (<?php print $total_staffs; ?>)</p>
				<p>Active &nbsp; (<?php print $active_staffs; ?>)</p>
				<p>Inactive &nbsp; (<?php print $inactive_staffs; ?>)</p>
			</div></div>
		</div><!-- /grid-a -->
       
  </div>
    
  <div data-role="collapsible" data-theme="b" data-content-theme="b">
		<h3>Questions / Exams </h3>
		<div class="ui-grid-a">
			<div class="ui-block-a"><div class="ui-bar ui-bar-a" style="height:auto">
				<p>Total Questions&nbsp; (<?php print $total_quest; ?>)</p>
				<p>Open Questions &nbsp; (<?php print $open_quest; ?>)</p>
				<p>Assigned Questions &nbsp; (<?php print $assigned_quest; ?>)</p>
				<p>Inactive Questions &nbsp; (<?php print $inactive_quest; ?>)</p>
			</div></div>
			
			<div class="ui-block-b"><div class="ui-bar ui-bar-a" style="height:auto">
				
				<p>Scheduled Exams &nbsp; (<?php print $scheduled_exams; ?>)</p>
				<p>Completed Exams &nbsp; (<?php print $completed_exams; ?>)</p>
				<p>Total Exams &nbsp; (<?php print $total_exams; ?>)</p>
				<p>&nbsp;</p>
			</div></div>	
		</div>
  </div>
  
  <div data-role="collapsible" data-theme="b" data-content-theme="b">
		<h3>Results </h3>
		<table data-role="table" id="table-column-toggle" <?php if($cand_count >0) { ?> data-mode="columntoggle"<?php }?> class="ui-responsive table-stroke">
			<thead>
				<h3>Top Results&nbsp;(Candidate)</h3>
			</thead>
			<?php
				if($cand_count >0){
			?>
			<thead>
				<tr>
					<th data-priority="2">Rank</th>
					<th>Name</th>
					<th data-priority="3">Exam</th>
					<th data-priority="1"><abbr title="Rotten Tomato Rating">Percentage</abbr></th>
				</tr>
			</thead>
			<tbody>
			<?php
				foreach($gettopresultcand->result() as $row){
					$first_name = ucfirst($row->first_name);
					$grade = $row->grade;
					$rank = $row->percentage;
					$exam_name = ucfirst($row->title);
					
					print "<tr>";
						print "<th>$grade</th>";
						print "<td><a href='#' data-rel='external'>$first_name</a></td>";
						print "<td>$exam_name</td>";
						print "<td>$rank%</td>";
					print "</tr>";
				}
			?>
			</tbody>
			<?php 
				}
				else{
					print "<p align='center'><b>No results found</b></p>";
				}
			?>
		</table>
		<p>&nbsp;</p>
		<table data-role="table" id="table-column-toggle1" <?php if($emp_count >0) { ?> data-mode="columntoggle"<?php }?> class="ui-responsive table-stroke">
			<thead>
				<h3>Top Results&nbsp;(Employees)</h3>
			</thead>
			<?php
				if($emp_count >0){
			?>
			<thead>
				<tr>
					<th data-priority="2">Rank</th>
					<th>Name</th>
					<th data-priority="3">Exam</th>
					<th data-priority="1"><abbr title="Rotten Tomato Rating">Percentage</abbr></th>
				</tr>
			</thead>
			<tbody>
			<?php
				foreach($gettopresultemp->result() as $row){
					$first_name = ucfirst($row->first_name);
					$grade = $row->grade;
					$rank = $row->percentage;
					$exam_name = ucfirst($row->title);
					print "<tr>";
						print "<th>$grade</th>";
						print "<td><a href='#' data-rel='external'>$first_name</a></td>";
						print "<td>$exam_name</td>";
						print "<td>$rank%</td>";
					print "</tr>";
				}
			?>
			</tbody>
			<?php 
				}
				else{
					print "<p align='center'><b>No results found</b></p>";
				}
			?>
		</table>
		
	</div>
</div> <!-- end of collapsible  window-->

<a href="<?php print site_url('subjects/form');?>" data-rel="dialog" >
	<div class='menu-box' align='center'>
		<div class='menu-image' align='center'>
			<img src="<?php print base_url('images/subject.jpg');?>" border='0' width='115px' />
		</div>
		<h3>Add Subjects</h3>
	</div>
</a>

<a href='<?php print site_url('subjects');?>'> 
	<div class='menu-box' align='center'>
		<div class='menu-image' align='center'>
			<img src="<?php print base_url('images/subject1.jpg');?>" border='0' width='115px' />
		</div>
		<h3>Manage Subjects</h3>
	</div>
</a>

<a href='<?php print site_url('question/bank');?>'>
	<div class='menu-box' align='center'>
		<div class='menu-image' align='center'>
			<img src="<?php print base_url('images/quest.jpg');?>" border='0'width='115px' />
		</div>
		<h3>Question Bank</h3>
	</div>
</a>

<a href="<?php print site_url('question/form/0');?>" data-rel='dialog' data-mini='true'>
	<div class='menu-box' align='center'>
		<div class='menu-image' align='center'>
			<img src="<?php print base_url('images/quest1.jpg');?>" border='0'width='115px' />
		</div>
		<h3>Add Questions</h3>
	</div>
</a>

<a href='<?php print site_url('question');?>'>
	<div class='menu-box' align='center'>
		<div class='menu-image' align='center'>
			<img src="<?php print base_url('images/quest2.jpg');?>" border='0'width='115px' />
		</div>
		<h3>Open Questions</h3>
	</div>
</a>

<a href="<?php print site_url('question/upload');?>" data-rel='dialog' data-mini='true'>
	<div class='menu-box' align='center'>
		<div class='menu-image' align='center'>
			<img src="<?php print base_url('images/quest3.jpg');?>" border='0'width='115px' />
		</div>
		<h3>Upload Questions</h3>
	</div>
</a>

<a href='<?php print site_url('exam/designer');?>'>
	<div class='menu-box' align='center'>
		<div class='menu-image' align='center'>
			<img src="<?php print base_url('images/write1.jpg');?>" border='0'width='115px' />
		</div>
		<h3>Recent Exams</h3>
	</div>
</a>

<a href="#popupLogin111" data-transition="pop" data-rel="popup" data-position-to="window" data-transition="pop">
	<div class='menu-box' align='center'>
		<div class='menu-image' align='center'>
			<img src="<?php print base_url('images/cands.jpg');?>" border='0'width='115px' />
		</div>
		<h3>Add Candidate</h3>
	</div>
</a>

<div data-role="popup" id="candpopupMenu" data-theme="b">
  <div data-role="popup" id="popupLogin111" data-theme="b" class="ui-corner-all">
		<a href="#" data-rel="back" data-role="button" data-theme="b" data-icon="delete" data-iconpos="notext" class="ui-btn-right">Close</a>
			<form id="addcandidate" method="post" action="<?php print site_url("exam/newcandidate")  ?>">
				<div style="padding:10px 20px;">
					<div id="candidate_success" ><h3>Please sign in</h3></div>
					<label for="un" class="ui-hidden-accessible">Username:</label>
					<input name="user" id="un" value="" placeholder="username" data-theme="b" type="text">
          <label for="pw" class="ui-hidden-accessible">Password:</label>
          <input name="pass" id="pw" value="" placeholder="password" data-theme="b" type="password">
          <label for="fn" class="ui-hidden-accessible">Firstname</label>
          <input name="firstname" id="fn" value="" placeholder="firstname" data-theme="b" type="text">
          <label for="ln" class="ui-hidden-accessible">Lastname</label>
          <input name="lastname" id="ln" value="" placeholder="lastname" data-theme="b" type="text">
          <label for="email" class="ui-hidden-accessible">Email</label>
          <input name="email" id="email" value="" placeholder="email" data-theme="b" type="text">
          <label for="country_code" class="ui-hidden-accessible">Select </label>
					<select name="country_code" id="country_code" data-mini="true">
						<?php
							$getallcountries = "Select c.country, c.ccode from countries as c group by c.country asc";
							$getallcountries = $this->db->query($getallcountries);
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
<?php
ajaxform("addcandidate",'candidate_success');
?>

<a href='<?php print site_url('exam/form');?>'>
	<div class='menu-box' align='center'>
		<div class='menu-image' align='center'>
			<img src="<?php print base_url('images/write2.jpg');?>" border='0'width='115px' />
		</div>
		<h3>Create Exams</h3>
	</div>
</a>
<a href='<?php print site_url('manage/validate');?>'>
	<div class='menu-box' align='center'>
		<div class='menu-image' align='center'>
			<img src="<?php print base_url('images/view-result.jpeg');?>" border='0'width='115px' />
		</div>
		<h3>Exam Summary</h3>
	</div>
</a>

<div class='menu-box' align='center'>
	<h3>Exams</h3>
	<p style="color:red"><b>Scheduled : </b><?php print $scheduled_exams; ?></p>
	<p style="color:green"><b>Completed : </b><?php print $completed_exams; ?></p>
</div>

<?php } ?>

<a href='<?php print site_url('exam/designer');?>'>
	<div class='menu-box' align='center'>
		<div class='menu-image' align='center'>
			<img src="<?php print base_url('images/write4.jpg');?>" border='0'width='115px' />
		</div>
		<h3>Assigned Exams</h3>
	</div>
</a>


