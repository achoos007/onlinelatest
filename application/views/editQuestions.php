<?php 


$sb[]=0;
$subjects=array();
if(!empty($qid)){
$q['table']='qBank';
$q['where']['qBankid']=intval($qid);
$q=getsingle($q);  
$subjids=explode(',',$q['n_subjectid']);
/*
get subject ids
*/
$sub['table']='q_subject';
$sub['where']['qBankid']=intval($qid);
$sub=getrecords($sub);
if(!empty($sub['result']))
foreach($sub['result'] as $s)
{
	$sbj[]=$s['subjectid'];
	
}
}
$qid=empty($qid)? 0 : intval($qid);


$questiontype=empty($q['questiontype'])?'':$q['questiontype'];
$category=empty($q['category'])?'':$q['category'];

if($category == 'Image'){
	$ques=empty($q['question'])?'':$q['question'];
	$imgurl = 'http://198.1.110.184/~geniuste/gg/onlinelatest/uploads/questions/imageType/';
	
	$imgques = empty($q['image_questions'])?0:$q['image_questions'];
	$imgoption1 = empty($q['imgoption1'])?0:$q['imgoption1'];
	$imgoption2 = empty($q['imgoption2'])?0:$q['imgoption2'];
	$imgoption3 = empty($q['imgoption3'])?0:$q['imgoption3'];
	$imgoption4 = empty($q['imgoption4'])?0:$q['imgoption4'];
	$imgques=$imgurl.$imgques;
	$imgoption1=$imgurl.$imgoption1;
	$imgoption2=$imgurl.$imgoption2;
	$imgoption3=$imgurl.$imgoption3;
	$imgoption4=$imgurl.$imgoption4;
	
	
	$option1=empty($q['option1'])?0:$q['option1'];
	$option2=empty($q['option2'])?0:$q['option2'];
	$option3=empty($q['option3'])?0:$q['option3'];
	$option4=empty($q['option4'])?0:$q['option4'];

	
}
else{
	$ques=empty($q['question'])?'':$q['question'];
	$option1=empty($q['option1'])?0:$q['option1'];
	$option2=empty($q['option2'])?0:$q['option2'];
	$option3=empty($q['option3'])?0:$q['option3'];
	$option4=empty($q['option4'])?0:$q['option4'];
}
$answer=empty($q['answer'])?'':$q['answer'];
$compulsory=empty($q['compulsory'])?'':$q['compulsory'];
$subjects=empty($q['n_subjectid'])?$subjects:$subjids;


$hint1=empty($q['hint1'])?'':$q['hint1'];
$hint2=empty($q['hint2'])?'':$q['hint2'];
$hint3=empty($q['hint3'])?'':$q['hint3'];
$level=empty($q['level'])?'':$q['level'];
$score=empty($q['score'])?'':$q['score'];


?>
<?php 
print title('Question Form');
?>
<div data-role='content'> 
<?php 
print ajaxform('imageQ','imageQResult');
//print form('editQ','question/admin');
?>
<form id='imageQ' action="<?php print site_url("question/admin");?>" method="post"   enctype="multipart/form-data" >
<?php
print hidden('qBankid',intval($qid));
?>
<ul data-role="listview">

	<li data-role="fieldcontain">  
		<legend>Question type</legend>
		<select id='questType' name='questType'>
		<?php
			$b=enum('qBank','questiontype');
			if(!empty($b))
				foreach($b as $e){
					print "<option value='".$e."' ";
					if($questiontype==$e)
						print " selected='selected' ";
						print ">".strtoupper($e)."</option>";
				}
		?>
		</select>
	</li>
							
	<li data-role="fieldcontain" class="select_question">
		<legend>Select Question</legend>
		<select name="select-quest" id="select-quest" data-mini="true">
			<option value="1">Write a Question</option>
			<option value="2">Upload a Question</option>
		</select>
	</li>

	<li data-role="fieldcontain" class="choosetype"> 
		<legend>Write a Question</legend>
		<fieldset data-role="controlgroup" data-mini="true" > 
		<?php 
			if($category == 'Image'){
				if($ques != ''){
					print "<textarea id='questionEdit' name='questionEdit'>".$ques."</textarea><br><br>";
				}
				print "<img src='".$imgques."' width='100' height='100'>";
			}
			else{
				print "<textarea id='questionEdit' name='questionEdit'>".$ques."</textarea>";
			}
		?>
		</fieldset>
	</li>
							
	<div id="option-list" data-role="fieldcontain" >
		<li data-role="fieldcontain" class="shorttext">
			<fieldset data-role="controlgroup" data-mini="true" > 
			<legend>Option A</legend> 
			<?php 
				if($category == 'Image'){
					if($option1 != ''){
						print "<input type='text' id='opt1' name='opt1'  value='$option1' /><br><br>";
					}
					print "<img src='".$imgoption1."' width='100' height='100'>";
				}
				else{
					print "<input type='text' id='opt1' name='opt1'  value='$option1' />";
				}
			?>
			</fieldset> 
		</li>

		<li data-role="fieldcontain" class="shorttext">
			<fieldset data-role="controlgroup" data-mini="true" > 
			<legend>Option B</legend> 
			<?php 
				if($category == 'Image'){
					if($option2 != ''){
						print"<input type='text' id='opt2' name='opt2'  value='$option2' /><br><br>";
					}
					print"<img src=$imgoption2 width='100' height='100'>";
				}
				else{
					print "<input type='text' id='opt2' name='opt2'  value='$option2' />";
				} 
			?>
			</fieldset> 
		</li>

		<li data-role="fieldcontain" class="yesorno shorttext" >
			<fieldset data-role="controlgroup" data-mini="true"> 
			<legend>Option C</legend> 
			<?php 
				if($category == 'Image'){
					if($option3 != ''){
						print"<input type='text' id='opt3' name='opt3'  value='$option3' /><br><br>";
					}
					print "<img src='$imgoption3' width='100' height='100'>";
				}
				else{
					print"<input type='text' id='opt3' name='opt3'  value='$option3' />";
				} 
			?>
			</fieldset> 
		</li>

		<li data-role="fieldcontain" class="yesorno shorttext">
			<fieldset data-role="controlgroup" data-mini="true"> 
			<legend>Option D</legend> 
			<?php 
				if($category == 'Image'){
					if($option4 != ''){
						print"<input type='text' id='opt4' name='opt4'  value='$option4' /><br><br>";
					}
					print"<img src='$imgoption4' width='100' height='100'>";
				}
				else{
					print"<input type='text' id='opt4' name='opt4'  value='$option4' />";
				} 
			?>
			</fieldset> 
		</li>
	</div>
							
	<li data-role="fieldcontain" class="singleresult">
		<fieldset data-role="controlgroup" data-mini="true"> 
		<legend>Answer</legend> 
		<?php
			$op=array(1=>'A','B','C','D');  
			foreach($op as $i=>$an){ 
				print "	<input type='checkbox' name='answer' id='answer_".$an."' value='".$i."' ";
				if($i == $answer)
					print " checked='checked' ";
				print "				/> 			<label for='answer_".$an."'>".$an."</label>"; 
			} 
		?>  
		</fieldset> 
	</li>
	
	<li data-role="fieldcontain">
		<fieldset data-role="controlgroup" data-mini="true"> 
		<legend>Compulsory</legend> 
		<?php
			$com=array('No','Yes'); 
			foreach($com as $c=>$cp){ 
				print "	<input type='radio' name='comp' id='comp_".$cp."' value='".$c."' "; 
				if($c == $compulsory)
					print " checked='checked' ";
				print "/><label for='comp_".$cp."'>".$cp."</label>"; 
			} 
		?>  
		</fieldset> 
	</li>

	<li data-role="fieldcontain">
		<fieldset data-role="controlgroup" data-mini="true"> 
		<legend>Hint 1</legend> 
			<input type='text' id='hint1' name='hint1' value='<?php print $hint1;?>'/>
		</fieldset> 
	</li>

	<li data-role="fieldcontain">
		<fieldset data-role="controlgroup" data-mini="true"> 
		<legend>Hint 2</legend> 
			<input type='text' id='hint2' name='hint2' value='<?php print $hint2;?>'/>
		</fieldset> 
	</li>

	<li data-role="fieldcontain">
		<fieldset data-role="controlgroup" data-mini="true"> 
		<legend>Hint 3 </legend> 
			<input type='text' id='hint3' name='hint3'  value='<?php print $hint3;?>'/>
		</fieldset> 
	</li>

	<li data-role="fieldcontain">
		<fieldset data-role="controlgroup" data-mini="true">
		<legend>Subject</legend>
		<?php  
			$s['table']='tbl_subject';
			$s=getrecords($s); 
			//print_r($subjects);
			//print"Hi".count($subjects);
			foreach($s['result'] as $sub){ 
				print " <input type='checkbox' name='sub[]' id='sub_".$sub['n_subjectid']."' value='".$sub['n_subjectid']."' ";
				if(count($subjects)>0){
					if(in_array($sub['n_subjectid'],$subjects))
						print ' checked="checked" ';
				}
				print " class='custom' /><label for='sub_".$sub['n_subjectid']."'>".strtoupper($sub['c_subject'])."</label> "; 
			}
		?> 
		</fieldset>
	</li>

	<li data-role="fieldcontain">
		<fieldset data-role="controlgroup" data-mini="true"> 
		<legend>Level</legend> 
		<?php
			$b=enum('qBank','level');
			if(!empty($b))
				foreach($b as $e){ 
					print "	<input type='radio' name='level' id='lev_".$e."' value='".$e."' ";
					if($level==$e)
						print " checked='checked' ";
					print " /><label for='lev_".$e."'>".$e."</label>"; 
				}
		?>  
		</fieldset> 
	</li>

	<li data-role="fieldcontain">
		<fieldset data-role="controlgroup" data-mini="true"> 
		<legend>Score</legend> 
			<input type='text' id='score' name='score' value="<?php print $score;?>" />
		</fieldset> 
	</li>

	<li><div id='imageQResult' class='error'></div></li>
</ul>

<br/>
<br/>

<div align='center' class='clear'>

	<?php 

		print  submit('Save');
		print  close();

$script="

$('#questType').change(function(){
	var val = this.value;
	flag=0;
	if(val == 'multiple choice single answer'){
		$.post('".site_url('question/singleanswer')."',{flag:1},function(data){
			//alert(data);
			$('.singleresult').html(data); 
			$('input[type=\'radio\']').checkboxradio({ theme: 'c' });
			$('.shorttext').show();
			$('.select_question').show();
			$('.yesorno').show();
		}); 
	}
	
	else if(val == 'multiple choice multiple answer'){
		$.post('".site_url('question/singleanswer')."',{flag:0},function(data){
			//alert(data);
			$('.singleresult').html(data); 
			$('input[type=\'checkbox\']').checkboxradio({ theme: 'c' });
			$('.shorttext').show();
			$('.select_question').show();
			$('.yesorno').show();
		}); 
	}
	
	else if(val == 'yes / no'){
		$.post('".site_url('question/singleanswer')."',{flag:2},function(data){
			//alert(data);
			$('#option-list').html(data); 
			$('input[type=\'radio\']').checkboxradio({ theme: 'c',mini: true, inline: true });
			$('input[type=\'text\']').textinput({ theme: 'c' ,mini: true, inline: true});
			//$('.shorttext').show();
			$('.select_question').show();
			//$('.yesorno').hide();
			//$('.file_type').hide();
		}); 
	}
	
	else if(val == 'short text'){
		$.post('".site_url('question/singleanswer')."',{flag:3},function(data){
			$('.singleresult').html(data); 
			$('textarea').textinput({ theme: 'c' });
			$('.shorttext').hide();
			$('.select_question').hide();
		});
	}
	
	else if(val == 'file upload'){
		$.post('".site_url('question/singleanswer')."',{flag:4},function(data){
			$('.singleresult').html(data); 
			$('textarea').textinput({ theme: 'c' });
			$('.shorttext').hide();
			$('.select_question').hide();
		});
	}
	
});
	
	
$('#select-quest').change(function(){
		
	var val = this.value;
	var fs = $('#questType').val();	
	
	$.post('".site_url('question/choosetype')."',{value:val,questtype:fs},function(data){
		$('#option-list').html(data); 
		$('textarea').textinput({ theme: 'c',mini: true, inline: true });
		$('input[type=\'file\']').textinput({ theme: 'c',mini: true, inline: true });
		$('input[type=\'text\']').textinput({ theme: 'c' ,mini: true, inline: true});
	});
	
});
	
";
	
print ready($script);
?>
</div>
</div>
