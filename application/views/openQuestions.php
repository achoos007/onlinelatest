  
<ul data-role="listview" data-inset='true' data-filter='true' id='questionlistopen'>
			<?php 
 
			$op['table']='qBank';
			$op['where']['status']='open';
			$op['start']=$start;
			$op['order']['qBankid']='desc';
			$op =getrecords($op); 
			if(!empty($op['result']))
			foreach($op['result'] as $o){  
				print "
<li  id='quest".$o['qBankid']."' >
<a href='#'  style='padding-top: 0px;padding-bottom: 0px;padding-right: 42px;padding-left: 0px;'  >
	<label style='border-top-width: 0px;margin-top: 0px;border-bottom-width: 0px;margin-bottom: 0px;border-left-width: 0px;border-right-width: 0px;' data-corners='false'>
		<fieldset data-role='controlgroup'>                                                        
				<input type='checkbox' class='openquestions' name='checkbox-2b' id='checkbox_".$o['qBankid']."' value='".$o['qBankid']."'/>                   
						<label for='checkbox-2b' style='border-top-width: 0px;margin-top: 0px;border-bottom-width: 0px;margin-bottom: 0px;border-left-width: 0px;border-right-width: 0px;'>
						<img src='".base_url('images/question.jpg')."' style='float:left;width:80px;height:80px'/>
						<label  style='float:left;padding:10px 0px 0px 10px;'> 
								<h3>".truncate($o['question'],80)."</h3> 
								<p>".$o['questiontype']."</p>
						</label> 
				</label>
		</fieldset> 
	</label>
</a>
<a href='".site_url('question/form/'.$o['qBankid'])."'  data-icon='info'  data-rel='dialog' >
	Edit
</a>
</li>";
						} 
			?>			
</ul>






<a href="#"  data-role="button" data-inline="true" id='setOption'>Options</a>
<?php 

print "<input type='button' value='Load More' data-theme='b' name='loadmoreopen' id='loadmoreopen'/>";
?>

<div id="deleteQuestion" data-role='popup' style='width:250px; padding:50px; border:5px solid #B9B9B9;' data-theme='d'>
Are you sure to delete Question ?
<div class='clear'><br/><br/></div>
<?php 
print button('Delete','','delete_question');
print close();
?>
</div>
<?php 


$script=" 
$('.open_confirm').click(function (){ 
	 clickId=this.id; 
	$( '#deleteQuestion' ).popup( 'open' ); 
	}); 
$('.delete_question').click(function(){ 
$.post('".site_url('question/delete/')."',{clkid:clickId});	 
$('#deleteQuestion').popup( 'close' );
$('#ques_'+clickId+'').hide(2000);
setTimeout('refreshPage()',2050); 
	}); 
";
  
print ready($script);

?>

		<!-- ****************************************************** -->
		<!-- ****************************************************** -->
		<!-- ****************************************************** -->
<div data-role="popup" id="popupMenu" data-theme="a" data-mini='true'>
	<a href="#" data-rel="back" data-role="button" data-theme="a" data-icon="delete" data-iconpos="notext" class="ui-btn-right">Close</a>
				<ul data-role="listview" data-inset="true" style="min-width:210px;" data-theme="b" data-mini='true'>
					<li><a href="<?php print site_url('question/form/0');?>" data-rel='dialog' data-mini='true'>Add questions</a></li>
					<li><a href="<?php print site_url('question/upload');?>" data-rel='dialog' data-mini='true'>File Upload</a></li> 
					<li><a href="<?php print site_url('question/bank');?>"  data-mini='true'>Question Bank</a></li> 
				</ul>
		</div>
 

		<div data-role="popup" id="popupAssign" data-theme="a"  data-position-to="window" style='width:300px;'>
			<a href="#" data-rel="back" data-role="button" data-theme="a" data-icon="delete" data-iconpos="notext" class="ui-btn-right">Close</a>
				<ul data-role="listview" data-inset="true" style="min-width:210px;" data-theme="b">
					<li data-role="divider" data-theme="a">Options</li>
					<li><a href="#assignToSubjects" data-rel='popup'>Assign to subjects</a></li>
					<li><a href="#deleteQuestions"  data-rel='popup'>Delete Questions</a></li>
				</ul>
		</div>
		
		
		
		<!-- ****************************************************** -->
		<!-- ****************************************************** -->
		<!-- ****************************************************** -->
		
		
		
		
		
		
		
		
		
		
		<!-- ****************************************************** -->
		<!-- ****************************************************** -->
		<!-- ****************************************************** -->
		<div data-role="popup" id="deleteQuestions" data-theme="a" data-position-to="window"  style='width:300px;'>
			<a href="#" data-rel="back" data-role="button" data-theme="a" data-icon="delete" data-iconpos="notext" class="ui-btn-right">Close</a>
			<form action='<?php print site_url('question/deletequestions');?>' method='post' id='deletequestions_form'>
				<ul data-role="listview" data-inset="true" style="min-width:210px;" data-theme="c">
					<li data-role="divider" data-theme="b" id='delete_result'>Delete Questions</li> 
					
					
					
					
					
					
					
					
					<li>
						<div class="ui-grid-a">	
						
						<div>
						Delete <label id='quesCount'>0</label> Questions ?
						
						</div>
						
						
						
						</div>
						</li>
						
						
						
						
						
						
						
						
						
						
						
					 
						 
						 
					<li>
						<input type='hidden' value='' id='selected_questions_delete' name='selected_questions_delete' />
						 
						<input type='submit' value='Confirm' />  
						</li>
				</ul>
				</form>
		</div>
		
		<!-- ****************************************************** -->
		<!-- ****************************************************** -->
		<!-- ****************************************************** -->
		
		<div data-role="popup" id="assignToSubjects" data-theme="a" data-position-to="window"  style='width:300px;'>
			<a href="#" data-rel="back" data-role="button" data-theme="a" data-icon="delete" data-iconpos="notext" class="ui-btn-right">Close</a>
			<form action='<?php print site_url('question/assignsub');?>' method='post' id='assign_subjects_form'>
				<ul data-role="listview" data-inset="true" style="min-width:210px;" data-theme="c">
					<li data-role="divider" data-theme="b" id='assign_sub_result'>Assign To Subjects</li> 
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					<?php 
					
					$sub['table']='tbl_subject';
					$sub=getrecords($sub);
					$c=0;
					foreach($sub['result'] as $s){
						$c++;
				// Array
// (
	 // [subject_id_1] => 1
	// [subject_id_2] => 0
	// [subject_id_3] => 3
	// [selected_questions] => 0,72,73,74,75,76
	// [subtotal] => 3
// )
					?> 
					<li>
						<div class="ui-grid-a">	
						<div class="ui-block-a">
				<fieldset data-role="controlgroup" data-type="horizontal" data-mini="true">
				<legend>Select subjects:</legend>
				<input type="radio" name="subject_id_<?php print $c;?>" id="radio-choice-c" value="<?php print $s['n_subjectid'];?>"/>
				<label for="radio-choice-c">YES</label>
				<input type="radio" name="subject_id_<?php print $c;?>" id="radio-choice-d" value="0" />
				<label for="radio-choice-d">NO</label> 
				</fieldset>

							</div>	<div class="ui-block-b" style='padding:10px;'> <?php print $s['c_subject'];?></div></div>
						</li>
						 <?php } ?>
						 
						 
					<li>
						
						<input type='hidden' value='' id='selected_questions' name='selected_questions' />
						<input type='hidden' value='<?php print $c;?>' id='subtotal' name='subtotal' />
						<input type='submit' value='Assign' />
						
						
						
						</li>
				</ul>
				</form>
		</div>
		
		<!-- ****************************************************** -->
		<!-- ****************************************************** -->
		<!-- ****************************************************** -->
		
<?php 
ajaxform('assign_subjects_form','assign_sub_result');
ajaxform('deletequestions_form','delete_result');

$script=" 
				$('#loadmoreopen').click(function (){	$.post('".site_url('question/loadmore/open')."',function(data){ 
				$('#questionlistopen').append(data); 
				$('#questionlistopen').listview('refresh');
				$('input[type=\'checkbox\']').checkboxradio({ theme: 'c' });
				});});
				var quids=0;
				var quCount=0;
				var questionsArray=new Array();
				$('.openquestions').click(function(){
				quids=quids+','+this.value;
				quCount=$('#quesCount').html();
				if ($(this).is(':checked')) {
				quCount=(quCount*1)+1;
				questionsArray.push(this.value);
				} else {
				quCount=(quCount*1)-1; 
				var index = questionsArray.indexOf(this.value);
				questionsArray.splice(index, 1);	
				} 
				$('#quesCount').html(quCount);
				$('#selected_questions').val(questionsArray.toString());
				$('#selected_questions_delete').val(questionsArray.toString());
				// alert(questionsArray.toString());
				});
				$('#setOption').click(function(){
				$( '#popupAssign' ).popup( 'open' );
				}); 
";



print ready($script);

?>
