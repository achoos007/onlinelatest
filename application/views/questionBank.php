		

<ul data-role="listview" data-inset='true' data-filter='true' id='questionlist'>
			<?php 
 
			$op['table']='qBank';
			$op['where']['status !=']='open';
			$op['start']=$this->session->userdata('q_bank_start');
			$op['order']['entrydate']='desc';
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
								<h3>".truncate(ucfirst($o['question']),80)."</h3> 
								<p>".ucfirst($o['questiontype'])."</p>
						</label> 
				</label>
		</fieldset> 
	</label>
</a>
<a href='".site_url('question/form/'.$o['qBankid'])."'  data-icon='info'  data-rel='dialog' >
	Edit
</a>
</li>
				";
				
	
	
				
				
			}
			?>			
</ul>
<a href="#"  data-role="button" data-inline="true" id='delOption'>Options</a>


	<div data-role="popup" id="delpopupAssign" data-theme="a"  data-position-to="window" style='width:300px;'>
			<a href="#" data-rel="back" data-role="button" data-theme="a" data-icon="delete" data-iconpos="notext" class="ui-btn-right">Close</a>
				<ul data-role="listview" data-inset="true" style="min-width:210px;" data-theme="b">
					<li data-role="divider" data-theme="a">Options</li>
					<li><a href="#deldeleteQuestions"  data-rel='popup'>Delete Questions</a></li>
				</ul>
		</div>
		
		
		
				<div data-role="popup" id="deldeleteQuestions" data-theme="a" data-position-to="window"  style='width:300px;'>
			<a href="#" data-rel="back" data-role="button" data-theme="a" data-icon="delete" data-iconpos="notext" class="ui-btn-right">Close</a>
			<form action='<?php print site_url('question/deldeletequestions');?>' method='post' id='deldeletequestions_form'>
				<ul data-role="listview" data-inset="true" style="min-width:210px;" data-theme="c">
					<li data-role="divider" data-theme="b" id='deldelete_result'>Delete Questions</li> 
					
					
					
					
					
					
					
					
					<li>
						<div class="ui-grid-a">	
						
						<div>
						Delete <label id='delquesCount'>0</label> Questions ?
						
						</div>
						
						
						
						</div>
						</li>
						
						
						
						
						
						
						
						
						
						
						
					 
						 
						 
					<li>
						<input type='hidden' value='' id='delselected_questions_delete' name='selected_questions_delete' />
						 
						<input type='submit' value='Confirm' />  
						</li>
				</ul>
				</form>
		</div>
		

<?php 
ajaxform('deldeletequestions_form','deldelete_result');
print "<input type='button' value='Load More' data-theme='b' name='loadmore' id='loadmore'/>";
?>

<?php 


$script=" $('#loadmore').click(function (){	$.post('".site_url('question/loadmore/assigned')."',function(data){ 
	
	 
	//~ alert(data);

$('#questionlist').append(data);
$('#questionlist').listview('refresh');
$('input[type=\'checkbox\']').checkboxradio({ theme: 'c' });
});});

	var quids=0;
				var quCount=0;
				var questionsArray=new Array();
				$('.openquestions').click(function(){
				quids=quids+','+this.value;
				quCount=$('#delquesCount').html();
				if ($(this).is(':checked')) {
				quCount=(quCount*1)+1;
				questionsArray.push(this.value);
				} else {
				quCount=(quCount*1)-1; 
				var index = questionsArray.indexOf(this.value);
				questionsArray.splice(index, 1);	
				} 
				$('#delquesCount').html(quCount);
				$('#selected_questions').val(questionsArray.toString());
				var qval = questionsArray.toString();
				$('#delselected_questions_delete').val(questionsArray.toString());
				// alert(questionsArray.toString());
				});

$('#delOption').click(function(){
					if(questionsArray.toString() == ''){
						alert('Please select a question atleast !!!! ');}
						else{
				$( '#delpopupAssign' ).popup( 'open' );
			}
				}); 


";





print ready($script);

?>
