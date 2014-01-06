 
	<?php 

$exist['table']='qexam';
$exist['where']['qDesignerId']=$examid;
$exist=getsingle($exist);

empty($exist)?0:$exist;

//pa($exist);
if(!empty($exist['equestions'])){
$qu=unserialize($exist['equestions']);

//print "<div >Question Set: ".count($qu)."</div>";
//print_r($qu);
//$ques=ques;

$pro['table']='product';
$pro['where']['productid']=$ques['productid'];
$pro=getsingle($pro);

$mod['table']='module';
$mod['where']['moduleid']=$ques['moduleid'];
$mod=getsingle($mod);

$sub['table']='tbl_subject';
$sub['where']['n_subjectid']=$ques['subjectid'];
$sub=getsingle($sub);

?>
<div class='dashboard-box'>
	<div class='dashboard-title'><?php pa(ucfirst($ques['title']));?></div>
	<table>
		<tr><td>Minimum Mark :</td><td><?php pa($ques['minMark']);?></td></tr>
		<tr><td>Duration :</td><td><?php pa($ques['duration']);?></td></tr>
		<tr><td>Alert Time :</td><td><?php pa($ques['alertTime']);?></td></tr>
		<!--<tr><td>Product :</td><td><?php pa($pro['name']);?></td></tr>
		<tr><td>Module:</td><td><?php pa($mod['name']);?></td></tr>-->
		<tr><td>Subject :</td><td><?php pa(empty($sub['c_subject'])?'Not Defined':$sub['c_subject']);?></td></tr>
		</table>

</div>

<div class='dashboard-box'>
	<div class='dashboard-title'>Exam Instructions</div>
	<table>
		<tr><td>
		Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
		</br></br>
		Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.


		</td></tr>
		</table>

</div>

<?php

}
?>
	
		 

