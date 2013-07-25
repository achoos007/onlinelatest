<?php 
	print title($title);
	$userid = $this->session->userdata('userid');
?>

<div data-role="content" data-theme="b">
	<center><h3>Do you want to sumit the <?php print $q_title; ?> for validation? </h3>     
	<p>&nbsp;</p> 
	<a href="<?php print site_url('exam/designer')?>" data-role="button"  data-theme="b" data-mini="true" id="<?php print $examid; ?>" class="exam_finish">Yes</a>  
	<?php print close('No'); ?>
</div>

<?php
$script="

$('.exam_finish').click(function(){
	clkid = this.id;
	
	$.post('".site_url('manage/finish_exam/')."',{clickid:clkid,userid:$userid},function(data){
			alert(data);
		});
	});

";
print ready($script);
?>
