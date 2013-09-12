<?php
// getting session value for role id

$roleid = $this->session->userdata('roleid');
$userid = $this->session->userdata('userid');

$aa=$question;
$bb=$qid;
$qno=$id;
$p=$id-1;
$q=$id+1;

//print"Q Count".$qucount;
//$testans = open('YI1FvT7vDGkoBGYn7kYi35DV9xOpceBK1nSck3csHtoMKGqFBjvtIzKBzWkM5937f4TsOpXAjo8RgtekXjTn3A==');

//print"Test Encryption".$testans;

//	$testunans = unserialize($testans);
//print"Test Unserialize".$testunans;
$a=$b=$c=$d=$uans="";
//print"User id".$user_id;
//print "Count".$count1;
if($count1 > 0){

//print"userid".$userid;
//print"qid".$qid;
//print"examid".$examid;

//print "Encrypted Answer".$ans;




$openans = open($ans);	
//print "Open Answer".$openans;
	
$unans = unserialize($openans);





//print_r($unans);
//print"array val".$unans[0];

// For setting the check boxes or radio button as selected with users answer

	switch($unans[0])
		{	
			case 'a' :
				$a = 'data-theme="e"';
				$uans=1;
				$b=$c=$d="";
				$youranswer = "Given answer is ".$uans;
				
				//print $a;
				break;
		
			case 'b' :
				$b = 'data-theme="e"';
				$uans=2;
				$a=$c=$d="";
				$youranswer = "Given answer is ".$uans;
				//print $b;
				break;
		
			case 'c' :
				$c = 'data-theme="e"';
				$uans=3;
				$b=$a=$d="";
				$youranswer = "Given answer is ".$uans;
				//print $c;
				break;
		
			case 'd' :
				$d = 'data-theme="e"';
				$uans=4;
				$b=$c=$a="";
				$youranswer = "Given answer is ".$uans;
				//print $d;
				break;
				
				
		}
}




$qucount1=$qucount;
$hint1=0;
$hint2=0;
$hint3=0;


//$duration = gmdate('H:i:s',$duration);
//print"Total Duration".$duration;
$date=date("H:i:s");


// For mock test checking 
if($mocktype=='on')
{
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

if($roleid == 0)
	{
		$disabled = 'disabled';
	}
	else{
		$disabled = '';
	}
print "Question Responded (".$qno."/".$qucount.") 	<label for='slider-2'></label>
    <input name='slider-2' id='slider-2' data-highlight='true' data-mini='true'  min='0' max='".$qucount."' value='".$qno."' type='range'>";
print"<div class='ui-grid-b'>
    <div class='ui-block-a' > <div class='ui-bar ui-bar-d' style='height:50px'><div style='float:left'><a href=''data-role='button' data-icon='gear' data-iconpos='notext' data-theme='e' data-inline='true'>alert</a></div><div style='float:left; padding-left:25px; padding-top:10px;'> Current Time : ".$date."</div></div></div>
     <div class='ui-block-b'><div class='ui-bar ui-bar-d' style='height:50px'><a href=''data-role='button' data-icon='grid' data-iconpos='notext' data-theme='e' data-inline='true'>alert</a>Question Responded (".$qno."/".$qucount.") 
     </div></div>
    <div class='ui-block-c'><div class='ui-bar ui-bar-d' style='height:50px'><div style='float:left'><a href=''data-role='button' data-icon='alert' data-iconpos='notext' data-theme='e' data-inline='true'>alert</a></div><div style='float:left; padding-left:25px; padding-top:10px;' class='countdown'></div></div></div>

</div>";
?>
<div class="ui-grid-a">
  <div class="ui-block-a" style="width:60%">
    <div class="ui-bar ui-bar-c" style="min-height:280px;">
			<?php
				print '<div style="width:600px;">';
				
				$flag=0;
		
				if($questiontype=='multiple choice single answer')
				{
					?>
					
		
					
					<?php

					//print"<div class='countdown'> </div>";
					print '<div><h3>'.$qno.') '.ucfirst($que['question']).'</h3></div>';
					print '

						<div data-role="fieldcontain">
							<fieldset data-role="controlgroup">
								<input type="radio" name="checkbox" '.$a.' id="radio-choice-1" value="a"  class="'.$qid.'_single" '.$disabled.' />
								<label for="radio-choice-1">'.$que['option1'].'</label>
     	
								<input type="radio" name="checkbox" '.$b.' id="radio-choice-2" value="b"  class="'.$qid.'_single" '.$disabled.' />
								<label for="radio-choice-2">'.$que['option2'].'</label>
  
								<input type="radio" name="checkbox" '.$c.' id="radio-choice-3" value="c"  class="'.$qid.'_single" '.$disabled.' />
								<label for="radio-choice-3">'.$que['option3'].'</label>
  
								<input type="radio" name="checkbox" '.$d.' id="radio-choice-4" value="d"  class="'.$qid.'_single" '.$disabled.'/>
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
								<label><input type="checkbox" name="checkbox[]" class="'.$qid.'" value="a" '.$a.' '.$disabled.' /> '.$que['option1'].' </label> 

								<label><input type="checkbox" name="checkbox[]" class="'.$qid.'" value="b" '.$b.' '.$disabled.' /> '.$que['option2'].' </label>

								<label><input type="checkbox" name="checkbox[]" class="'.$qid.'" value="c" '.$c.' '.$disabled.'/> '.$que['option3'].' </label>

								<label><input type="checkbox" name="checkbox[]" class="'.$qid.'" value="d" '.$d.' '.$disabled.'/> '.$que['option4'].' </label>
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
							<input type="radio" name="checkbox[]" id="radio-yesno-1" value="a" class="'.$qid.'_yn" />
							<label for="radio-yesno-1">'.$que['option1'].'</label>
     	
							<input type="radio" name="checkbox[]" id="radio-yesno-2" value="b" class="'.$qid.'_yn" />
							<label for="radio-yesno-2">'.$que['option2'].'</label>
						</div>	
					';
	
				$flag='3';
				}
	
				else if($questiontype=='file upload')
				{
					
					print '<div><h3>'.$qno.') '.ucfirst($que['question']).'</h3></div>';
					print'
		 
						<form action='.site_url('manage/do_upload/').' method="post" enctype="multipart/form-data" data-ajax="false">
							<input type="file" name="userfile" size="20" />

							<br /><br />

							<input type="submit" value="upload" />

						</form>

						<div class="progress" style="position:relative; width:400px; border: 1px solid #ddd; padding: 1px; border-radius: 3px;">
							<div class="bar" style="background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px;"></div >
							<div class="percent" style="position:absolute; display:inline-block; top:3px; left:48%;">0%</div >
						</div>
						
						<div id="status"></div>	
					';
	
					print'<p style="color:red">Note:- Make sure that you are uploading .doc or .pdf extension files. All other file format may not supported!!!</p>';
					$flag='4';
				}

				else if($questiontype=='short text')
				{
					print '<div><h3>'.$qno.') '.ucfirst($que['question']).'</h3></div>';
		
					print '

						<div style="width:500px;padding:15px;">
							<textarea cols="40" rows="8" name="checkbox[]" id="textarea-short" class="'.$qid.'_short"></textarea>
						</div>
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
			if($roleid == 0){
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
			<a data-icon="arrow-l" data-iconpos="left" href="<?php print site_url('manage/exam/'.$examid.'/'.$mocktype.'/'.$date).'#'.('question-'.$p);?>" data-ajax="false" id="aboutPage">Previous</a>
		</li>
		
		<li>
			<?php if($q > $qucount1){
				if($roleid == 0){
				?>
				
			<a data-icon="check" href=""  data-rel='dialog'  data-transition='pop'> Generate Result</a>
				
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
	
	if ($(this).is(':checked')) {

$.each($('input[name=\"checkbox[]\"]:checked'), function() {
	 received.push($(this).val());
	 
	});
	 

		$.post('".site_url('manage/answerexam/')."',{clkid:received,qid:$qid,flag:$flag,roleid:$roleid,examid:$qDesignerId},function(data){
			//alert(data);
			//$('#".$qid."').html(data);
									 });
} else {

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


$('.".$qid."_short').change(function(){
	//alert('Hai');
	txt_val = $(this).val();
	//alert(test);
	$.post('".site_url('manage/answerexam/')."',{clkid:txt_val,qid:$qid,flag:$flag,examid:$qDesignerId},function(data){
		alert(data);
	});
});



$( '#aboutPage' ).on( 'pageinit',function(event){
  alert( 'This page was just enhanced by jQuery Mobile!' );
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



	
	
	///  for new count dowmn timer
	
	
	
		
TotalSeconds = ".$duration.";

UpdateTimer();

setTimeout(function() { 

	Tick();
	
}, 1000);
		

function Tick(){
	if (TotalSeconds <= 0) {
		//alert('You have only 0 more seconds!!!')
		return;
	}

	TotalSeconds -= 1;

	UpdateTimer();
	
	setTimeout(function() { 
		
		Tick();
		
	}, 1000);
}




function UpdateTimer() {
var Seconds = TotalSeconds;
//alert(Seconds);

var Days = Math.floor(Seconds / 86400);
Seconds -= Days * 86400;

var Hours = Math.floor(Seconds / 3600);
Seconds -= Hours * (3600);

var Minutes = Math.floor(Seconds / 60);
Seconds -= Minutes * (60);


var TimeStr = 'Remaining Time : '+((Days > 0) ? Days + ' days ' : '') + LeadingZero(Hours) + ':' + LeadingZero(Minutes) + ':' + LeadingZero(Seconds)


 $('.countdown').html(TimeStr);
}


function LeadingZero(Time) {

return (Time < 10) ? '0' + Time : + Time;

}







";
print ready($script);
?>





<script type='text/javascript'>
$( document ).delegate("#question-<?php print $id;?>", "pageinit", function() {
function testtime(){ 
 alert(' hai'); 
	
}
});
</script>



















