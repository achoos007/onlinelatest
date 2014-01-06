<?php 
ajaxform("export_report", 'exportstatus');
?>
<!--<div id ="exportstatus"></div>-->
<form method="post" action="<?php print site_url("manage/export_report")  ?>" data-ajax="false">
<div class="ui-grid-a ui-responsive">
    <div class="ui-block-a" style="width:60%"><div class="ui-bar ui-bar-c">
   

<fieldset data-role="controlgroup" data-type="horizontal" data-mini="true">
	<legend>Search By</legend>
  <label for="result">Result</label>
  <select name="result" id="result" class="search_result">
		<option value=''>Result</option>
		<?php
			foreach($result as $row){
				$result = ucfirst($row->result);
				print "<option value='".$result."'>".$result."</option>";
			}
		?>
	</select>
  <label for="examid">Exam</label>
  <select name="examid" id="examid" class="search_result">
		<option value=''>Exam</option>
		<?php
			foreach($result_exam as $row){
				$title = ucfirst($row->title);
				$examid = $row->examid;
				print "<option value='".$examid."'>".$title."</option>";
			}
		?>
	</select>
	<label for="user_id">Name</label>
  <select name="user_id" id="user_id" class="search_result">
		<option value=''>Name</option>
		<?php
			foreach($result_name as $row){
				$name = ucfirst($row->first_name);
				$user_id = $row->user_id;
				print "<option value='".$user_id."'>".$name."</option>";
			}
		?>
	</select>
	<label for="grade">Grade</label>
	<select name="grade" id="grade" class="search_result">
		<option value=''>Grade</option>
		<?php
			foreach($grade as $row){
				$grade = ucfirst($row->grade);
				print "<option value='".$grade."'>".$grade."</option>";
			}
		?>
	</select>
	<label for="percentage">Percentage</label>
  <select name="percentage" id="percentage" class="search_result">
		<option value=''>Percentage</option>
		<?php
			foreach($percentage as $row){
				$percentage = ucfirst($row->percentage);
				print "<option value='".$percentage."'>".$percentage."</option>";
			}
		?>
	</select>
</fieldset>
</div></div>
 <div class="ui-block-b" style="width:40%"><div class="ui-bar ui-bar-c" >
	 <fieldset data-role="controlgroup" data-type="horizontal" data-mini="true" style="float:right;">
 <legend>Export To</legend>
 <label for="export_type">Select</label>
  <select name="export" id="export_type">
		<option value='1'>Excel</option>
	</select>
	<!--<a href="#" data-role="button" data-mini="true" data-inline="true" data-icon="check" data-theme="b" id="export">Export</a>-->
	<?php print submit('Export');?>
 </fieldset>
 
 </div></div>
</div><!-- /grid-a -->		
</form>
<table data-role="table" id="table-column-toggle" data-mode="columntoggle" class="ui-responsive table-stroke">
	<thead>
		<tr>
      <th data-priority="2">Rank</th>
      <th>Name</th>
      <th data-priority="3">Exam</th>
      <th data-priority="1"><abbr title="Rotten Tomato Rating">Percentage</abbr></th>
      <th data-priority="4">Result</th>
      <th data-priority="5">Correct Answers</th>
      <th data-priority="6">Wrong Answers</th>
      <th data-priority="7">Marks Scored</th>
    </tr>
  </thead>
  <tbody id="res_result">
		<?php
			foreach($getreports['result'] as $row){
		?>
		<tr>
			<th><?php print $row['grade'];?></th>
      <td><a href="#" data-rel="external"><?php print $row['first_name'] ?></a></td>
      <td><?php print $row['title'] ?></td>
      <td><?php print $row['percentage'] ?></td>
      <td><?php print $row['result'] ?></td>
      <td><?php print $row['correctanswer'] ?></td>
      <td><?php print $row['wronganswer'] ?></td>
      <td><?php print $row['marks_obtained'] ?>/<?php print $row['totalmark'] ?></td>
    </tr>
    <?php
			}
    ?>
  </tbody>
</table>

<?php
	$script = "
	
	$('.search_result').change(function(){
		var val = this.value;
		var id = this.id;
		$.post('".site_url('manage/get_report_search')."',{value:val,id:id},function(data){
			$('#res_result').html(data);

			var getval = new Array();
			var getval = [];

			getval[ 0 ] = 'result';
			getval[ 1 ] = 'examid';
			getval[ 2 ] = 'user_id';
			getval[ 3 ] = 'grade';
			getval[ 4 ] = 'percentage';
			
			for(var i=0; i<=getval.length;i++){
				var getids = getval[i];
				if(getids != id){
					$('#'+getids).val(''); 
					$('#'+getids).selectmenu('refresh', true );
				}
			}
		});
	});

	";
	print ready($script);
?>
