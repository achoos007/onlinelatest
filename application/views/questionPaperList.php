<ul data-role="listview" data-inset='true' data-filter='true'>
<?php

$op['table']='qdesigner';
$op['where']['status']=1;
$op['order']['qDesignerId']='desc';
$op=  getrecords($op);
if(!empty($op['result']))
    foreach ($op['result'] as $o){
        print"<li id='ques_".$o['qDesignerId']."'>
        <a href='".site_url('exam/form/'.$o['qDesignerId'])."' data-ajax='false'>
        <h3>".$o['title']."</h3>
        </a>
        <a href='#deleteQuestion'  data-icon='delete'  data-theme='d' id='".$o['qDesignerId']."' class='open_confirm'>Delete</a>
        ";
    }

?>
</ul>

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
	
 
$.post('".site_url('exam/delete/')."',{clkid:clickId});	

	
	
$('#deleteQuestion').popup( 'close' );


$('#ques_'+clickId+'').hide(2000);

setTimeout('refreshPage()',2050);

	});
	

";



print ready($script);

?>
