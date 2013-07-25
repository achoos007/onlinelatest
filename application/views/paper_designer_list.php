<?php
// Session variables - role id and user id 
$roleid = $this->session->userdata('roleid');
$userid = $this->session->userdata('userid');

if($roleid==1){
	$list['table'] = 'qdesigner';
	$list['order']['title'] = 'desc';
}

else{
	$list['table'] = 'qdesigner';
	//$list['order']['title'] = 'desc';
	// This join query for showing exam which is not attended by user

	$list['join']['assigned_users']='assigned_users.qid=qdesigner.qDesignerId and assigned_users.user_id="'.$userid.'" and assigned_users.c_status=0';
	$list['where']['assign_status']='Active';
}

$list = getrecords($list);
$count = count($list['result']);
?>

<div align='center'>
	<div data-role='collapsible-set'>

  <?php
    if($count == 0){
			print "<font color='red' size='+1'>No exams assigned to you. Try again Later!!!</font>";
		}
    
    if (!empty($list['result'])) {
      foreach ($list['result'] as $o) {
				$a=$o['mocktest'];
				if($a == 'on')
					$mocktest="This is a mock test";
				else
					$mocktest="";
        if ($o['status'] == 1)
          $st = "Active";
        else
          $st = "Inactive";
                  
								
					
  ?>  
  
  <div id="remove-response"></div>      
  <div data-role="collapsible" <?php print (strtolower($o['status']) == 1) ? " data-collapsed-icon='check' " : " data-collapsed-icon='delete' "; ?>  data-content-theme="c"  >
		<h3><?php echo $o['title']?></h3> 
      <table width="100%">
        <tr>
          <td > 
            <div ><h4>Status :<?php echo $st ?></h4></div>
						<div ><h4><?php echo $mocktest ?></h4></div>
          </td>

          <td width="100px">  
						<?php
							if ($o['status'] == 1) {
								if($roleid == 1){
						?>
          
									<a href="#popupMenu1<?php print $o['qDesignerId']?>" data-rel="popup" data-role="button" data-theme="b" data-mini="true" data-inline="true" class="assign" id="<?php print $o['qDesignerId'];?>" >Assign</a>            

          </td>
          
          <td width="100px">
            <a href="<?php echo site_url('exam/execute/' . $o['qDesignerId']); ?>" data-role="button" data-theme="b" data-mini="true" data-inline="true">Execute</a>                   
          </td>
          
          <td width="100px">
            <a href="<?php echo site_url('manage/exam/' . $o['qDesignerId'].'/'.$a); ?>" data-role="button" data-theme="b" data-mini="true" data-inline="true">Manage</a>                   
          </td>
          
          <td width="100px">
            <a href="<?php echo site_url('exam/form/' . $o['qDesignerId']); ?>" data-role="button" data-theme="b" data-mini="true" data-inline="true">Edit</a>                   
          </td>
          
          <td width="100px">
            <a id ="<?php print $o['qDesignerId']; ?>" class="exam-delete" href="#" data-role="button" data-theme="b" data-mini="true" data-inline="true">Delete</a>                   
          </td>
          
          <?php 
								}
                
                else{
					?>
					
					<td width="100px">
            <a href="<?php echo site_url('manage/exam/' . $o['qDesignerId'].'/'.$a); ?>" data-role="button" data-theme="b" data-mini="true" data-inline="true">Attend</a>                   
          </td>
					
					<?php	
								}
							}
					?>
        </tr>
      </table>
	</div>   

  <div data-role="popup" id="popupMenu1<?php print $o['qDesignerId']?>" data-theme="a" data-mini='true'>
		<ul data-role="listview" data-inset="true" style="min-width:210px;" data-theme="b" data-mini='true'>
			<li class='qvalue'><a href="<?php print site_url('exam/assigneelist/1/'. $o['qDesignerId']);?>" data-mini='true'>Employees</a></li>
			<li><a href="<?php print site_url('exam/assigneelist/2/' . $o['qDesignerId']);?>" data-mini='true'>Candidates</a></li> 
		</ul>
	</div>

  <?php
			}
		}
  ?>
  
  </div>
</div> 

<?php

$script="

$('.exam-delete').click(function(){
	value = this.id;
		$.post('".site_url('exam/remove')."',{clkid:value},function(data){

				$('#remove-response').html(data);
			
				
			});
	});

";

print ready($script);

?>
	
