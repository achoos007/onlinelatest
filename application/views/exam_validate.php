<?php 	
	$stat = empty($stat)?0:$stat;
	$emailid = empty($emailid)?0:$emailid;
	//echo "Num Rows".$total_candcount;	
	$pagination = $this->pagination->create_links();
?>




<h2>Exam Summary</h2>
<p>&nbsp;</p>
<ul data-role="listview" data-autodividers="true" data-filter="true" data-inset="true" data-count-theme="b">
	<div align='center' >
		<div data-role='navbar' >
			<?php print $pagination; ?>
		</div>
	</div>
	<?php 
		foreach($results as $row){
			$userid = $row->candidate_id;
			$qDesignerId = $row->qDesignerId;
			$firstname = ucfirst($row->first_name);
			$subject = ucfirst($row->title);
			$scheduled_date = $row->scheduled_date;
			$exam_status = $row->c_status;
		
			
			// for getting the score card details

			$getscoredetail['table'] = 'scorecard';
			$getscoredetail['where']['user_id'] = $userid;
			$getscoredetail['where']['typeid'] = 2;
			$getscoredetail['where']['examid'] = $qDesignerId;
			$getscoredetail = getsingle($getscoredetail);
			
			$totalquest = empty($getscoredetail['totalquest'])?0:$getscoredetail['totalquest'];
			$correctanswer = empty($getscoredetail['correctanswer'])?0:$getscoredetail['correctanswer'];
			$wronganswer = empty($getscoredetail['wronganswer'])?0:$getscoredetail['wronganswer'];
			$unanswered = empty($getscoredetail['unanswered'])?0:$getscoredetail['unanswered'];
			$marks_obtained = empty($getscoredetail['marks_obtained'])?0:$getscoredetail['marks_obtained'];
			$marks_obtained = $marks_obtained;
			$totalmark = empty($getscoredetail['totalmark'])?0:$getscoredetail['totalmark'];
			$totalmark = intval($totalmark);
			$percentage = empty($getscoredetail['percentage'])?0:$getscoredetail['percentage'];
			$result = empty($getscoredetail['result'])?'':$getscoredetail['result'];
			$grade = empty($getscoredetail['grade'])?0:$getscoredetail['grade'];
			
			if($exam_status == 0){
				$exam_status = "Not attended";
			}
			elseif($exam_status == 2){
				$exam_status = "Dropped";
			}
			elseif($exam_status == 1 && $result == 'Passed') {
				$exam_status = "Passed";
			}
			elseif($exam_status == 1 && $result == '') {
				$exam_status = "Awaiting Result";
			}
			elseif($exam_status == 1 && $result == 'Failed') {
				$exam_status = "Failed";
			}
			
						
			print"<div id='userDet".$userid.$qDesignerId."' data-role='popup' data-overlay-theme='a' data-theme='e' class='ui-content'>";
	?>
	<a href="#" data-rel="back" data-role="button" data-theme="a" data-icon="delete" data-iconpos="notext" class="ui-btn-right">Close</a>
	<div data-role="header" data-theme="a" class="ui-corner-top">
		<h1>Exam Summary</h1>
	</div>

	<div data-role="fieldcontain">
		<?php
			print"<h4>Name:$firstname</h4>";
			print"<h4>Exam Name:$subject</h4>";
			print"<h4>Scheduled Date:$scheduled_date</h4>";
			print"<h4>Total Questions:$totalquest</h4>";
			print"<h4>Correct Answers:$correctanswer</h4>";
			print"<h4>Wrong Answers:$wronganswer</h4>";
			print"<h4>Unanswered:$unanswered</h4>";
			print"<h4>Marks Obtained:$marks_obtained</h4>";
			print"<h4>Total Marks:$totalmark</h4>";
			print"<h4>Percentage:$percentage</h4>";
			print"<h4>Result Status:$result</h4>";
			print"<h4>Grade:$grade</h4>";
		?>
	</div>
</div>

<div data-role="collapsible" data-theme="c" data-content-theme="d">
	<?php 
    print "<h4>$firstname<p class='ui-li-aside'><span class='ui-li-count' style='padding:10px;'><strong>$exam_status</strong></span></p> <p class='ui-li-aside'><strong>".$subject."</strong></p></h4>";
  ?>
  <div class="ui-grid-b">
		<div class="ui-block-a">
			<div class="ui-bar ui-bar-b" style="height:60px">
				<?php 
					print"<p><b>Exam Name:</b><span style='padding-left:20px;'>$subject</span></p>";
					print"<p><b>Scheduled Date:</b><span style='padding-left:20px;'>$scheduled_date</span></p>";
				?>	
			</div>
		</div>
    <div class="ui-block-b">
			<div class="ui-bar ui-bar-b" style="height:60px">
			<?php
				print"<p><b>Total Questions:</b><span style='padding-left:20px;'>$totalquest</span></p>";
				print"<p><b>Correct Answers:</b><span style='padding-left:20px;'>$correctanswer</span></p>";
				print"<p><b>Wrong Answers:</b><span style='padding-left:20px;'>$wronganswer</span></p>";
				print"<p><b>Unanswered:</b><span style='padding-left:20px;'>$unanswered</span></p>";	
			?>
			</div>
		</div>
    <div class="ui-block-c">
			<div class="ui-bar ui-bar-b" style="height:60px">
			<?php
				print"<p><b>Marks Scored:</b><span style='padding-left:20px;'>$marks_obtained</span></p>";
				print"<p><b>Total Marks:</b><span style='padding-left:20px;'>$totalmark</span></p>";
				print"<p><b>Percentage:</b><span style='padding-left:20px;'>$percentage <b>%</b></span></p>";
				print"<p><b>Result Status:</b><span style='padding-left:20px;'>$result</span></p>";
				print"<p><b>Grade:</b><span style='padding-left:20px;'>$grade</span></p>";
			?>
			</div>
		</div>
	</div><!-- /grid-b -->
</div>
<?php 
	}
	print "<div align='center'>";
	print "<div data-role='navbar'>";
	print $pagination;
	print "</div>";
	print "</div>";
?>

</ul>

							

