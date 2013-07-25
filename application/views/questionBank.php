		

<ul data-role="listview" data-inset='true' data-filter='true' id='questionlist'>
			<?php 
 
			$op['table']='qBank';
			$op['where']['status !=']='open';
			$op['start']=$this->session->userdata('q_bank_start');
			$op['order']['qBankid']='desc';
			$op =getrecords($op);  
			if(!empty($op['result']))
			foreach($op['result'] as $o){  
				
 
				print "
				<li id='ques_".$o['qBankid']."'>
				<a href='".site_url('question/form/'.$o['qBankid'])."' data-rel='dialog'   >

				<h3>".format($o['question'])."</h3>
				<p>".$o['questiontype']."</p>
				</a> 
				</li>
				";
			}
			?>			
</ul>
<?php 

print "<input type='button' value='Load More' data-theme='b' name='loadmore' id='loadmore'/>";
?>

<?php 


$script=" $('#loadmore').click(function (){	$.post('".site_url('question/loadmore/assigned')."',function(data){ 
	
	 
	//~ alert(data);

$('#questionlist').append(data);
$('#questionlist').listview('refresh');
});});";



print ready($script);

?>
