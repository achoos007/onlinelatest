<?php
// getting session value for role id


$notanswered =0;

$roleid = $this->session->userdata('roleid');
$userid = $this->session->userdata('userid');


// for getting alert time

$getqdesigner['table'] = 'qdesigner';
$getqdesigner['where']['qDesignerId'] = $examid;
$getqdesigner = getsingle($getqdesigner);

$alerttime = $getqdesigner['alertTime'];



//----------------------- For checking values from manage controller

//print "User Id".$userid;   // current loggined user id
//print "User Id ".$user_id; // exam attended user id

//print"QrY".$qry;
//print "Count".$count_one;
//print "qryy".$qryy;

//---------------------------------------------

// Global variable declaration

$a=$b=$c=$d=$uans="";
$chkbox1 = $chkbox2 = $chkbox3 = $chkbox4 = "";


// $roleid has the following values 0-for admin, 1-for employee and 2- for candidate

// Not for admin

if($roleid != 0){
	
	$query=  $this->db->query("select * from examanswer where 
	qBankid=".$qid." and qDesignerId=".$examid." and userid=".$userid);
	
	$data['count1'] = $query->num_rows();	
	
 	foreach ($query->result() as $row){
		$ans = $row->answer;
		//print "ANs".$ans;
		$openans = open($ans);	
		//print "Open Answer".$openans;
	
		$unans = unserialize($openans);

	

		$unans_count = count($unans);
		//print_r($unans);
		if($unans_count >= 1 && is_array($unans)) 
			foreach ($unans as $key => $value ){
				//print $value;
				if($value == 1)
					$chkbox1 = 'data-theme="e"';
				if($value == 2)
					$chkbox2 = 'data-theme="e"';
				if($value == 3)
					$chkbox3 = 'data-theme="e"';
				if($value == 4)
					$chkbox4 = 'data-theme="e"';
			}
	}
	
	
	// for calculating total marks
	

	if($data['count1'] > 0){
		switch($unans[0]){	
			case '1' :
				$a = 'data-theme="e"';
				$uans=1;
				$b=$c=$d="";
				$youranswer = "Given answer is ".$uans;
				break;
		
			case '2' :
				$b = 'data-theme="e"';
				$uans=2;
				$a=$c=$d="";
				$youranswer = "Given answer is ".$uans;
				break;
		
			case '3' :
				$c = 'data-theme="e"';
				$uans=3;
				$b=$a=$d="";
				$youranswer = "Given answer is ".$uans;
				break;
		
			case '4' :
				$d = 'data-theme="e"';
				$uans=4;
				$b=$c=$a="";
				$youranswer = "Given answer is ".$uans;
				break;				
		}
	}
	
 
	// print_r($data['count1']);
	//$openans = open($ans);	
	//print "Open Answer".$openans;
	//$unans = unserialize($openans);
}

// Get values from Mange controller for question navigation
$aa=$question;
$bb=$qid;
$qno=$id;
$p=$id-1;
$q=$id+1;


// -----------------------For testing the encrypted value directly from the database-----------

//print"Q Count".$qucount;
//$testans = open('Zf8LJxa/YXuuTjh9kth6/0W+zSkuUCs1QKxK1v2uVXMz9AfVvoOGJGJ3cJ0zAfT8VBBU5zhtB5s7vi8g+HLC+g==');

//print $testans;

	//$testunans = unserialize($testans);
//print_r($testunans);

//print"User id".$user_id;

//-----------------------------------------------------Printing End-------------------------------


	//print "AnS".$count_one;

if($count_one > 0){

	$openans = open($ans);	
	$unans = unserialize($openans);
	//print_r($unans);
	$unans_count = count($unans);
	if($unans_count >= 1 && is_array($unans)) 

		foreach ( $unans as $key => $value ){
			//print $value;
			if($value == 1)
				$chkbox1 = 'data-theme="e"';
			if($value == 2)
				$chkbox2 = 'data-theme="e"';
			if($value == 3)
				$chkbox3 = 'data-theme="e"';
			if($value == 4)
				$chkbox4 = 'data-theme="e"';
		}


// For setting the check boxes or radio button as selected with users answer

		switch($unans[0]){	
			
			case '1' :
				$a = 'data-theme="e"';
				$uans=1;
				$b=$c=$d="";
				$youranswer = "Given answer is ".$uans;
				break;
		
			case '2' :
				$b = 'data-theme="e"';
				$uans=2;
				$a=$c=$d="";
				$youranswer = "Given answer is ".$uans;
				break;
		
			case '3' :
				$c = 'data-theme="e"';
				$uans=3;
				$b=$a=$d="";
				$youranswer = "Given answer is ".$uans;
				break;
		
			case '4' :
				$d = 'data-theme="e"';
				$uans=4;
				$b=$c=$a="";
				$youranswer = "Given answer is ".$uans;
				break;
		}
}

// intializing the hint values
$qucount1=$qucount;
$hint1=0;
$hint2=0;
$hint3=0;

//for Current time
//$duration = gmdate('H:i:s',$duration);
//print"Total Duration".$duration;

// fo rgetting starting time when user enter the start button

$get_start_time['table'] = ' exam_time_log';
$get_start_time['where']['userid'] = $userid;
$get_start_time['where']['typeid'] = $roleid;
$get_start_time['where']['qdesignerid'] = $examid;

$get_start_time = getsingle($get_start_time);

$getstarttime = empty($get_start_time['start_time'])?0:$get_start_time['start_time'];
$getstarttime = explode(" ",$getstarttime);

$gettimeonly = empty($getstarttime[1])?0:$getstarttime[1]; 

$gettimeonly = explode(":",$gettimeonly);

$gethour = empty($gettimeonly[0])?0:$gettimeonly[0]; 
$getminutes = empty($gettimeonly[1])?0:$gettimeonly[1]; 
$getseconds = empty($gettimeonly[2])?0:$gettimeonly[2]; 


//echo "Hour".$getseconds;
//$duration = 36000;
$duration = ($duration_hour*60*60)+($duration_minutes*60);  // getting hours and minutes from db and converting to seconds
$hours = floor($duration / 3600);
$minutes = floor(($duration / 60) % 60);
$seconds = $duration % 60;

$hours = empty($hours)?0:$hours;
$minutes = empty($minutes)?0:$minutes;
$seconds = empty($seconds)?0:$seconds;

//print "Hour".$hours;
//print "Minutes".$minutes;
//print "Seconds".$seconds;


$countdownhours = $hours + $gethour;
$countdownminutes = $minutes + $getminutes;

//print "CountDown".$countdownminutes;

$date=date("H:i:s");


// For mock test checking 
if($mocktype=='on'){
	$que['table']='qBank';
	$que['where']['questionfor']='only for mock test';
	$que['where']['qBankid']=$qid;
}
else{
	$que['table']='qBank';
	$que['where']['qBankid']=$qid;
}

// Getting hint values from table
$que=getsingle($que);
$hint1=empty($que['hint1'])? '0' : $que['hint1'];
$hint2=empty($que['hint2'])? '0' : $que['hint2'];
$hint3=empty($que['hint3'])? '0' : $que['hint3'];
$correct_answer = empty($que['answer'])? '0' : $que['answer'];
$mark = empty($que['score'])? '0' : $que['score'];
$questiontype=empty($que['questiontype'])? '0' : $que['questiontype'];
$qDesignerId=$examid;

//print_r($qids);



if($roleid == 0)
	{
		 // for getting total marks from all questions
		foreach($qids as $key=>$val){
				
			$getallquest['table'] = 'qBank'; 
			$getallquest['where']['qBankid'] = $val;
			$getallquest = getsingle($getallquest);
			$grand_total = empty($getallquest['score'])?0:$getallquest['score'];
		  $grand [] = $grand_total; 
		}
		$mark_sum = array_sum($grand);
		
		//print "Sum".$mark_sum;
		$disabled = 'disabled';
		
		$type = empty($typeid)?0:$typeid; 
		
		print "Question Responded (".$qno."/".$qucount.") 	<label for='slider-2'></label>
    <input name='slider-name' id='".$qno."' data-highlight='true' data-mini='true'  min='0' max='".$qucount."' value='".$qno."' type='range' class='slider_move'>";
print "<p align='right'>Exam Attended By <b>".$name."</b></p>";
		
	}
	else{
		$disabled = '';
	}

?>    
    
    
<?php    
print"<div class='ui-grid-b'>
    <div class='ui-block-a' > <div class='ui-bar ui-bar-d' style='height:50px'><div style='float:left'><a href=''data-role='button' data-icon='gear' data-iconpos='notext' data-theme='e' data-inline='true'>alert</a></div><div style='float:left; padding-left:25px; padding-top:10px;'><div class='clock-1'></div></div></div></div>
     <div class='ui-block-b'><div class='ui-bar ui-bar-d' style='height:50px'><a href=''data-role='button' data-icon='grid' data-iconpos='notext' data-theme='e' data-inline='true'>alert</a>Question Responded (".$qno."/".$qucount.") 
     </div></div><div class='ui-block-c'><div class='ui-bar ui-bar-d' style='height:50px'>";
     if($roleid !=0){
    print "<div style='float:left'><a href=''data-role='button' data-icon='alert' data-iconpos='notext' data-theme='e' data-inline='true'>alert</a></div><div style='float:left; padding-left:25px; padding-top:10px;' class='countdown-2'><span id='date-str'></span></div>";
    }
    

print"</div></div></div>";
?>
<div class="ui-grid-a">
  <div class="ui-block-a" style="width:60%">
    <div class="ui-bar ui-bar-c" style="min-height:280px;">
			<?php
				print '<div style="width:100%;">';
				
				$flag=0;
				
					if($count_one == 0)
						$marks_obt = 0;
					else
						$marks_obt = $marks_obt;	
		
				if($questiontype=='multiple choice single answer')
				{
					?>
					
		
					
					<?php

					//print"<div class='countdown'> </div>";
					print '<div><h3>'.$qno.') '.ucfirst($que['question']).'</h3></div>';
					print '

						<div data-role="fieldcontain">
							<fieldset data-role="controlgroup">
								<input type="radio" name="checkbox" '.$a.' id="radio-choice-1" value="1"  class="'.$qid.'_single" '.$disabled.' />
								<label for="radio-choice-1">'.$que['option1'].'</label>
     	
								<input type="radio" name="checkbox" '.$b.' id="radio-choice-2" value="2"  class="'.$qid.'_single" '.$disabled.' />
								<label for="radio-choice-2">'.$que['option2'].'</label>
  
								<input type="radio" name="checkbox" '.$c.' id="radio-choice-3" value="3"  class="'.$qid.'_single" '.$disabled.' />
								<label for="radio-choice-3">'.$que['option3'].'</label>
  
								<input type="radio" name="checkbox" '.$d.' id="radio-choice-4" value="4"  class="'.$qid.'_single" '.$disabled.'/>
								<label for="radio-choice-4">'.$que['option4'].'</label>
							</fieldset>
						</div>
					';

					$flag='2';
				}

				if($questiontype=='multiple choice multiple answer')
				{
					print '<div><h3>'.$qno.') '.ucfirst($que['question']).'</h3></div>';
				?>
				
		
				
				<?php
					print '
						<div data-role="fieldcontain">
							<fieldset data-role="controlgroup">
								<label><input type="checkbox" name="checkbox[]" class="'.$qid.'" value="1"  '.$chkbox1.' '.$disabled.' /> '.$que['option1'].' </label> 

								<label><input type="checkbox" name="checkbox[]" class="'.$qid.'" value="2"  '.$chkbox2.' '.$disabled.' /> '.$que['option2'].' </label>

								<label><input type="checkbox" name="checkbox[]" class="'.$qid.'" value="3"  '.$chkbox3.' '.$disabled.'/> '.$que['option3'].' </label>

								<label><input type="checkbox" name="checkbox[]" class="'.$qid.'" value="4"  '.$chkbox4.' '.$disabled.'/> '.$que['option4'].' </label>
							</fieldset>
						</div>
					';
					$flag='1';
				}

				else if($questiontype=='yes / no')
				{
					print '<div><h3>'.$qno.') '.ucfirst($que['question']).'</h3></div>';

					print' 
						<div style="width:500px;padding:15px;">
							<input type="radio" name="checkbox[]" id="radio-yesno-1" value="1" '.$a.' '.$disabled.' class="'.$qid.'_yn" />
							<label for="radio-yesno-1">'.$que['option1'].'</label>
     	
							<input type="radio" name="checkbox[]" id="radio-yesno-2" value="2" '.$b.' '.$disabled.' class="'.$qid.'_yn" />
							<label for="radio-yesno-2">'.$que['option2'].'</label>
						</div>	
					';
	
				$flag='3';
				}
	
				else if($questiontype=='file upload')
				{
					
					print '<div><h3>'.$qno.') '.ucfirst($que['question']).'</h3></div>';
					if($roleid!=0){
					print'
		 
						<form action='.site_url('manage/do_upload/').' method="post" enctype="multipart/form-data" data-ajax="false">
							<input type="file" name="userfile" size="20" />

							<br /><br />

							<input type="submit" value="upload" />
							<input type="hidden" value="4" name="flag4"/>
							<input type="hidden" value="'.$qid.'" name="qid"/>
							<input type="hidden" value="'.$examid.'" name="examid"/>
							<input type="hidden" value="'.$roleid.'" name="roleid"/>

						</form>

						<!--<div class="progress" style="position:relative; width:400px; border: 1px solid #ddd; padding: 1px; border-radius: 3px;">
							<div class="bar" style="background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px;"></div >
							<div class="percent" style="position:absolute; display:inline-block; top:3px; left:48%;">0%</div >
						</div>-->
						
						<div id="status"></div>	
					';
					
					print'<p style="color:red">Note:- Make sure that you are uploading .doc or .pdf extension files. All other file format may not supported!!!</p>';
				}
				else{
						$ans = empty($ans)?"":$ans;
					//print $ans;
					if($count_one > 0){
					print'
						<a href="'.site_url("manage/download_answer/".$ans.'/').'" data-ajax="false" data-role="button" data-icon="arrow-d" data-iconpos="bottom" data-inline="true">Download the answer</a>
						
					
					';
					
				
					
					print '
							<fieldset data-role="controlgroup" data-type="horizontal" data-mini="true"> 
							<legend>Select Mark</legend>
								<label for="fu_'.$qid.'">Select A</label>
									<select name="fu" id="fu_'.$qid.'">
										<option value="0">Mark</option>';
									for($i=1;$i<=$mark;$i++){
											if($marks_obt == $i && $count_one > 0){
											$sel = "selected";
										}
										else{
											
										$sel = "";
										}
											
										print '<option value="'.$i.'" '.$sel.' >'.$i.'</option>';
									}
									print '</select>
							</fieldset>
							 
							
							  ';
				}
				
				else{
					print 'Not answered!!!';
					}

				}
					
				}

				else if($questiontype=='short text')
				{
					print '<div><h3>'.$qno.') '.ucfirst($que['question']).'</h3></div>';
					$unans = empty($unans)?"":$unans;
					if($roleid == 0){
						$dis = "disabled";
					}
					else{
						$dis = "";
					}
					print '

						<div style="width:500px;padding:15px;">
							<textarea cols="40" rows="8" name="checkbox" id="textarea-short_'.$qid.'" '.$dis.' class="'.$qid.'_short" >'.$unans.'</textarea>';
							if($roleid !=0){
							 print'<a href="#" data-role="button" data-inline="true" id="short_submit_'.$qid.'">Save</a>';
						 }
						 else{
						
								
							 print '
							<fieldset data-role="controlgroup" data-type="horizontal" data-mini="true"> 
							<legend>Select Mark</legend>
								<label for="st_mark_'.$qid.'">Select A</label>
									<select name="st_mark" id="st_mark_'.$qid.'">
										<option value="0">Mark</option>';
										for($i=1;$i<=$mark;$i++){
											if($marks_obt == $i && $count_one > 0){
											$sel = "selected";
										}
										else{
											
										$sel = "";
										}
											
										print '<option value="'.$i.'" '.$sel.' >'.$i.'</option>';
									}
										print '<!--<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>-->
									</select>
							</fieldset>
							 
							
							  ';
						 }
						print'</div>
					';
					$flag='5';
				}

			print '</div>';
			?>
		</div>
	</div>
	
	<div class="ui-block-b" style="width:40%;"> 
		<div class="ui-bar ui-bar-c" style="min-height:280px;">
		<?php
		
			print '<div align="right" > <a href="#popupPadded" data-rel="popup" data-role="button" data-inline="true" data-icon="info" data-iconpos="right"  data-theme="b" data-mini="true">Hint</a> 
			</div>';
			if(($roleid == 0) && ($questiontype!='short text') && ($questiontype!='file upload') ){
				print '<div  align="right"><a href="#" data-role="button" data-icon="check" data-iconpos="notext" data-theme="b" data-iconshadow="false" data-inline="true">Correct Answer</a>Correct Answer is '.$correct_answer.'</div>';
				if($uans > 0){
				print '<div  align="right"><a href="#" data-role="button" data-icon="gear" data-iconpos="notext" data-theme="b" data-iconshadow="false" data-inline="true">Given Answer</a>'.$youranswer.'</div>';
			}
				if($correct_answer == $uans){
					print '<div  align="right" style="color:green"><a href="#" data-role="button" data-icon="check" data-iconpos="notext" data-theme="b" data-iconshadow="false" data-inline="true">Correct Answer</a>Given Answer is Correct</div>';
					
					print '<div  align="right">  <a href="#" data-role="button" data-icon="plus" data-iconpos="notext" data-theme="b" data-iconshadow="false" data-inline="true">Marks</a>Marks Obtained '.$mark.'</div>';
				}
				else{

					if($uans > 0){
						print '<div  align="right" style="color:red"> <a href="#" data-role="button" data-icon="delete" data-iconpos="notext" data-theme="b" data-iconshadow="false" data-inline="true">Wrong Answer</a>Given Answer is Wrong</div>';
					}
					else{
						print '<div  align="right" style="color:red"> <a href="#" data-role="button" data-icon="delete" data-iconpos="notext" data-theme="b" data-iconshadow="false" data-inline="true">Wrong Answer</a>Question not attended!!!</div>';
					}
					print '<div  align="right">  <a href="#" data-role="button" data-icon="plus" data-iconpos="notext" data-theme="b" data-iconshadow="false" data-inline="true">Marks</a>Marks Obtained 0</div>';
					
				}
				

				
			}

		
		?>
					
		</div>
	</div>
		
</div>

<div data-role="footer" data-theme='b'>		
	<div data-role="navbar" >
		<ul>
		<?php
			if($qno > $qucount1){
				print '<li style="min-height:120px;margin-left:350px; font-size:16px;"><p>&nbsp;</p>You have successfully completed the exam</li>';
			}
			else{
		?>
			
		<li data-iconpos="left">
			<a data-icon="arrow-l" data-iconpos="left" href="<?php print site_url('manage/exam/'.$examid.'/'.$mocktype.'/'.$date.'/'.$user_id).'#'.('question-'.$p);?>" data-ajax="false" id="aboutPage">Previous</a>
		</li>
		
		<li>
			<?php if($q > $qucount1){
				if($roleid == 0){
				?>
				
			<a data-icon="check" href="#generateResult"  data-rel="popup" data-position-to="window" data-inline="true" data-transition="pop"> Generate Result</a>
			<div data-role='popup' id='generatepopupMenu' data-theme='a'>
			<div data-role="popup" id="generateResult" data-overlay-theme="a" data-theme="c" data-dismissible="false" style="max-width:400px;" class="ui-corner-all">
			<div data-role="header" data-theme="a" class="ui-corner-top">
        <h1>Score Card</h1>
			</div>
			<form id="sendscorecard" method="post" action="<?php print site_url("scorecard/save_scorecard")  ?>">
			<div data-role="content" data-theme="d" class="ui-corner-bottom ui-content">
				<?php 
					
					$notanswered = $id-($answered+$wronganswer);
					
					
					$total_score = empty($mark_sum)?0:$mark_sum;
					
					
					
					$negative_mark = $wronganswer * $negative;  // for calculating negative marks if exists
					
					$total_marks = $total_marks - $negative_mark;
					
					if($total_score == 0){
						$percentage = 0;
					}
					else{
					$percentage = ($total_marks/$total_score)*100;
					$percentage = round($percentage,2);
					}
					
					if($percentage >= 50 && $percentage < 60){
						$result = "Passed";
						$grade = "B";
						$color = 'data-theme="a"';
					}
					elseif($percentage >= 60 && $percentage < 80){
						$result = "Passed";
						$grade = "B+";
						$color = 'data-theme="a"';
					}
					elseif($percentage >= 80 && $percentage < 90){
						$result = "Passed";
						$grade = "A";
						$color = 'data-theme="a"';
					}
					elseif($percentage >= 90 && $percentage < 100){
						$result = "Passed";
						$grade = "A+";
						$color = 'data-theme="a"';
					}
					else{
						$result = "Failed";
						$grade = "D";
						$color = 'data-theme="c"';
						}
					

				?>
       <table>
        <tr>
        <td><h4>Total No. of Questions </td> <td><a href="#" data-role="button" data-theme="e" data-inline="true"><?php print $id; ?> </a></h4></td>
        </tr>
        <tr>
        <td><h4>Correct Answers</td><td> <a href="#" data-role="button" data-theme="e" data-inline="true"> <?php print $answered; ?></a></h4></td>
        </tr>
        <tr>
				<td>
        <h4>Wrong Answers </td><td> <a href="#" data-role="button" data-theme="e" data-inline="true"><?php print $wronganswer; ?></a></h4></td>
         </tr>
        <tr>
				<td>
        <h4>Un Answered  </td><td><a href="#" data-role="button" data-theme="e" data-inline="true"><?php print $notanswered; ?></a></h4></td>
         </tr>
        <tr>
				<td>
        <h4>Negative Marks</td><td><a href="#" data-role="button" data-theme="e" data-inline="true"><?php print $negative_mark; ?><b></b></a></h4></td>
         </tr>
        <tr>
				<td>
        <h4>Marks Scored  </td><td><a href="#" data-role="button" data-theme="e" data-inline="true"><?php print $total_marks."/".$total_score; ?></a></h4></td>
        </tr>
        <tr>
				<td>
        <h4>Percentage </td><td><a href="#" data-role="button" data-theme="e" data-inline="true"><?php print $percentage; ?><b>%</b></a></h4></td>
         </tr>
        <tr>
				<td>
        <h4>Result</td><td><a href="#" data-role="button" <?php print $color; ?> data-inline="true"><?php print $result; ?><b></b></a></h4></td>
         </tr>
         <tr>
				<td>
        <h4>Grade</td><td><a href="#" data-role="button" data-theme="e" data-inline="true"><?php print $grade; ?><b></b></a></h4></td>
         </tr>
       
        <tr>
				<td>
        </table>
       
        <input type="hidden" name="totalquest" value="<?php print $id; ?>">
        <input type="hidden" name="answered" value="<?php print $answered; ?>">
        <input type="hidden" name="wronganswer" value="<?php print $wronganswer; ?>">
        <input type="hidden" name="notanswered" value="<?php print $notanswered; ?>">
        <input type="hidden" name="totalmarks" value="<?php print $total_score; ?>">
        <input type="hidden" name="marks_obtained" value="<?php print $total_marks; ?>">
        <input type="hidden" name="percentage" value="<?php print $percentage; ?>">
        <input type="hidden" name="result" value="<?php print $result; ?>">
        <input type="hidden" name="grade" value="<?php print $grade; ?>">
        <input type="hidden" name="user_id" value="<?php print $user_id; ?>">
        <input type="hidden" name="examid" value="<?php print $examid; ?>">
        <input type="hidden" name="type" value="<?php print $type; ?>">
        <a  class="ui-corner-all" href="#" data-role="button" data-inline="true" data-rel="back" data-theme="c" data-mini="true">Exit</a>
       <!-- <a class="ui-corner-all scorecard" href="" data-role="button" data-inline="true"  data-theme="b" data-mini="true">Send an Email</a>-->
        <button type="submit" data-theme="b" data-inline="true" >Send Email</button>
			</div>
			</form>
		</div>
		</div>		
			<?php 
				}
				else{
					?>
					<a data-icon="check" href="<?php print site_url('manage/message_dialog/'.$examid) ?>"  data-rel='dialog'  data-transition='pop'> Finish</a>
				<?php	
				}
			}
			else{
			
			?>
			<a data-icon="arrow-r" data-iconpos="right" href="<?php print site_url('manage/exam/'.$examid.'/'.$mocktype.'/'.$date.'/'.$user_id).'#'.('question-'.$q);?>" data-ajax='false'  >Next</a>
			<?php }?>
		</li> 
		<?php
		
	
			}
		?>
		</ul>
		<?php
		

$config['total_rows'] = $qucount1;
$config['per_page'] = 1;
$paginid=1;
$config['first_link'] = 'First';

$config['uri_segment'] = $this->uri->segment(7);
$config['use_page_numbers'] = FALSE;
$config['num_links'] = 5;
$config['last_link'] = 'Last';
$config['next_link'] = '&gt;';
$config['prev_link'] = '&lt;';






$config['base_url'] = site_url('manage/exam/'.$examid.'/'.$mocktype.'/'.$date.'/'.$user_id.'/'.'#'.('question-'));


//print $uri_segment;


$this->exampagination->initialize($config);

$pagination = $this->exampagination->create_links();


print $pagination;
		?>
	</div><!-- /navbar -->
</div><!-- /footer -->

<div data-role="popup" id="popupPadded" data-theme="a" data-mini='true'>
	<ul data-role="listview" data-inset="true" style="min-width:210px;" data-theme="b" data-mini='true'>
	<?php if($hint1 != '') 
		{
	?>
		<li><a href='#'><?php echo $hint1 ?></a></li>
	<?php 
		}if($hint2 != '') {
	?>
		<li><a href='#'><?php echo $hint2 ?></a></li>
			<?php }if($hint3 != '') {?>
			
		<li><a href='#'><?php echo $hint3 ?></a></li> 
		<?php }?>
	</ul>
</div>

<!--<div data-role="popup" id="popupPadded" class="ui-content">
	<p><?php //echo $hint ?></p>
</div>-->
<?php 
print'
<div id="'.$qid.'"></div>
';
?>
<script type='text/javascript'>
	


</script>
<?php
$script="

$('.".$qid."').click(function(){
	var received = new Array();

	if ($(this).is(':checked')){

		$.each($('input[name=\"checkbox[]\"]:checked'), function() {
		received.push($(this).val());
		});
	 
		$.post('".site_url('manage/answerexam/')."',{clkid:received,qid:$qid,flag:$flag,roleid:$roleid,examid:$qDesignerId},function(data){
			//$('#".$qid."').html(data);
		});
	} 
	else{

		$.each($('input[name=\"checkbox[]\"]:checked'), function() {
			received.push($(this).val());
		});
		checkvalue='false';
   	$.post('".site_url('manage/answer_delete/')."',{clkid:received,qid:$qid,flag:$flag,status:checkvalue,examid:$qDesignerId},function(data){
			//alert(data);
			//$('#".$qid."').html(data);
		});
	} 
	
});



$('.".$qid."_single').click(function(){
	ansval = $('input:checked').val();
	//alert(ansval);
	$.post('".site_url('manage/answerexam/')."',{clkid:ansval,qid:$qid,flag:$flag,roleid:$roleid,examid:$qDesignerId},function(data){
		//alert(data);
		//$('#".$qid."').html(data);
	});
});


$('.".$qid."_yn').click(function(){
	ansval = $('input:checked').val();
	//alert(ansval);
	$.post('".site_url('manage/answerexam/')."',{clkid:ansval,qid:$qid,flag:$flag,roleid:$roleid,examid:$qDesignerId},function(data){
		//alert(data);
		//$('#".$qid."').html(data);
	});
});


$('#st_mark_".$qid."').change(function(){ 
	txt_val = $(this).val();
	//alert(txt_val);
	$.post('".site_url('manage/st_mark/')."',{stmark:txt_val,qid:$qid,user_id:$user_id,examid:$qDesignerId},function(data){
		//alert(data);
	});
});

$('#fu_".$qid."').change(function(){ 
	txt_val = $(this).val();
	//alert(txt_val);
	$.post('".site_url('manage/st_mark/')."',{stmark:txt_val,qid:$qid,user_id:$user_id,examid:$qDesignerId},function(data){
		//alert(data);
	});
});


$( '#aboutPage' ).on( 'pageinit',function(event){
  //alert( 'This page was just enhanced by jQuery Mobile!' );
});


// for submitting the file upload using ajax form
    
var bar = $('.bar');
var percent = $('.percent');
var status = $('#status');
   
$('form').ajaxForm({
    beforeSend: function() {
        status.empty();
        var percentVal = '0%';
        bar.width(percentVal)
        percent.html(percentVal);
    },
    uploadProgress: function(event, position, total, percentComplete) {
        var percentVal = percentComplete + '%';
        bar.width(percentVal)
        percent.html(percentVal);
    },
    success: function() {
        var percentVal = '100%';
        bar.width(percentVal)
        percent.html(percentVal);
    },
	complete: function(xhr) {
		status.html(xhr.responseText);
	}
}); 



	
	

$('#short_submit_".$qid."').click(function(){
	short_val = $('#textarea-short_".$qid."').val();
	//alert('hai'+short_val);
	$.post('".site_url('manage/answerexam/')."',{clkid:short_val,qid:$qid,flag:$flag,roleid:$roleid,examid:$qDesignerId},function(data){
			//alert('Your data saved!!!');
	});
});







";
print ready($script);
?>
 <script>
   $('.clock-1').timeTo(); // for displaying current time display
   

        
    var hours = <?php print $hours; ?>   
     
    var minutes = <?php print $countdownhours; ?>    
    
    var seconds = <?php print $countdownminutes; ?>    
    
    var examid  = <?php print $qDesignerId; ?>
    
    var type  = <?php print $roleid; ?>
    
    var userid  = <?php print $userid; ?>
    
    var date = getRelativeDate(hours,minutes,seconds);
    
    var  countdownAlertLimit = 50;
    
   
		<?php 
			if($roleid !=0){
			
		?>
				document.getElementById('date-str').innerHTML = date.toString();   
    
    <?php 
			}
    ?> 
           
    $('.countdown-2').timeTo(date,countdownAlertLimit, function(){
		
			$.post('http://198.1.110.184/~geniuste/gg/onlinelatest/index.php/manage/exam_timeout/',{examid:examid,type:type,userid:userid},function(data){
								
				if(data){
					alert(data);
					window.location.href = "http://198.1.110.184/~geniuste/gg/onlinelatest/index.php/manage/exam/designer";
				} 	
			});
							
		});
    
    
        
    function getRelativeDate(days, hours, minutes){
			var date = new Date((new Date()).getTime() + 60000 /* milisec */ * 60 /* minutes */ * 24 /* hours */ * days /* days */);

      date.setHours(hours || 0);
      date.setMinutes(minutes || 0);
      date.setSeconds(0);

      return date;
    }
</script>


<script type='text/javascript'>
$( document ).delegate("#question-<?php print $id;?>", "pageinit", function() {
function testtime(){ 
 //alert(' hai'); 
	
}
});
</script>



















