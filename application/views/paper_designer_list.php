<?php
// Session variables - role id and user id 
$roleid = $this->session->userdata('roleid');
$userid = $this->session->userdata('userid');

$this->load->helper('text');

$this->load->helper('date');

$datestring = "%Y-%m-%d";
$time = time();

$today = mdate($datestring, $time);

$qdesignerid = 0;

if($roleid==0){
	$list['table'] = 'qdesigner';
	$list['order']['entrydate'] = 'desc';
	$list['limit'] = 10000000;
}

else{
	$list['table'] = 'qdesigner';
	//$list['order']['title'] = 'desc';
	// This join query for showing exam which is not attended by user

	$list['join']['assigned_users']='assigned_users.qid=qdesigner.qDesignerId and assigned_users.user_id="'.$userid.'" and assigned_users.c_status=0';
	$list['where']['assign_status']='Active';
	$list['where']['scheduled_date']=$today;
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
		<h3><?php echo ucfirst($o['title']); ?></h3> 
      <table width="100%">
        <tr>
          <td > 
            <div ><h4>Status :<?php echo $st ?></h4></div>
						<div ><h4><?php echo $mocktest ?></h4></div>
          </td>

          <td width="100px">  
						<?php
							if ($o['status'] == 1) {
								if($roleid == 0){
						?>
          
          
									<a href="#popupMenu1<?php print $o['qDesignerId']?>" data-rel="popup" data-role="button"   data-theme="b" data-mini="true" data-inline="true" data-icon="check" class="assign" id="<?php print $o['qDesignerId'];?>" >Assign</a>            

          </td>
          
          <td width="100px">
            <a href="<?php echo site_url('exam/execute/' . $o['qDesignerId']); ?>" data-role="button" data-theme="b" data-mini="true" data-inline="true" data-icon="gear">Execute</a>                   
          </td>
          
          <!--<td width="100px">
            <a href="<?php //echo site_url('manage/exam/' . $o['qDesignerId'].'/'.$a); ?>" data-role="button" data-theme="b" data-mini="true" data-inline="true" data-icon="gear">Manage</a>                  
          </td>--> 
          
          <td width="100px">
            <!--<a href="<?php //echo site_url('manage/validate/'); ?>" data-role="button" data-theme="b" data-mini="true" data-inline="true">Validate Exam</a>  -->   
            
            <a href="#validateExam<?php print $o['qDesignerId']?>" data-rel="popup" data-role="button" data-inline="true" data-icon="grid" data-theme="b" data-mini="true" data-transition="pop" data-inline="true">Validate Exam</a>              
          </td>
          
          <td width="100px">
            <a href="<?php echo site_url('exam/form/' . $o['qDesignerId']); ?>" data-role="button" data-theme="b" data-mini="true" data-inline="true" data-icon="grid">Edit</a>                   
          </td>
          
          <td width="100px">
 
            
            <a href="#qpdelete<?php print $o['qDesignerId']?>" data-rel="popup" data-position-to="window" data-role="button" data-mini="true" data-inline="true" data-transition="pop" data-icon="delete" data-theme="b">Delete</a>
<div data-role="popup" id="qpdelete<?php print $o['qDesignerId']?>" data-overlay-theme="a" data-theme="c" data-dismissible="false" style="max-width:400px;" class="ui-corner-all">
    <div data-role="header" data-theme="a" class="ui-corner-top">
        <h1>Delete Exam</h1>
    </div>
    <div data-role="content" data-theme="d" class="ui-corner-bottom ui-content">
        <h3 class="ui-title">Are you sure you want to delete this Exam </h3>
        <a href="#" data-role="button" data-inline="true" data-rel="back" data-theme="c">Cancel</a>
        <a href="#" id="<?php print $o['qDesignerId']; ?>" class="exam-delete" data-role="button" data-inline="true" data-transition="flow" data-theme="b">Delete</a>
    </div>
</div>
                             
          </td>
          
          <?php 
								}
                
                else{
					?>
					
					
					<td width="100px">         
            <a href="#startExam<?php print $o['qDesignerId']?>" data-role="button" data-rel="popup" data-position-to="window" data-mini="true" data-inline="true" data-theme="b" data-transition="pop">Attend</a>
          </td>
         
					<div data-role="popup" id="startExam<?php print $o['qDesignerId']?>" data-overlay-theme="a" data-theme="c" data-dismissible="false" style="max-width:400px;" class="ui-corner-all">
						<div data-role="header" data-theme="a" class="ui-corner-top">
							<h1>Start Exam</h1>
						</div>
					 
					 <?php 
					 $qdesignerid = $o['qDesignerId'];
					 ?>
						<div data-role="content" data-theme="d" class="ui-corner-bottom ui-content">
							<h3 class="ui-title">Are you ready to start this Exam now?</h3>
							<a href="#" data-role="button" data-inline="true" data-rel="back" data-theme="c">Exit</a>
							<a href="<?php echo site_url('manage/exam/' . $o['qDesignerId'].'/'.$a); ?>" data-role="button" data-inline="true" data-theme="b" id="<?php print $qdesignerid;?>" class="start_exam_count">Start Exam </a>
						</div>
					</div>
					
					
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
	
	
	
	<!-- pop up menu for validate exam -->
	
	<div data-role="popup" id="validateExam<?php print $o['qDesignerId']?>" data-theme="none">
    <div data-role="collapsible-set" data-theme="b" data-content-theme="c" data-collapsed-icon="arrow-r" data-expanded-icon="arrow-d" style="margin:0; width:250px;">
        <div data-role="collapsible" data-inset="false">
            <h2>Employees</h2>
           
							<?php
							$date=0;
							
							$get_emp_type="SELECT emp.first_name,emp.last_name,assign.user_id from tbl_staffs as emp,assigned_users as assign where emp.staff_id = assign.user_id and emp.status='Active' and assign.c_status=1 and assign.type='1' and assign.qid=".$o['qDesignerId'];
		
							$rslt = $this->login_db->get_results($get_emp_type);		
								if($rslt >0){
									?>
									<ol data-role="listview"  data-filter="true" data-inset="true">
									<?php
			foreach ($rslt as $row){
				$user_id = $row->user_id;
				$emp_name = $row->first_name;
				$flag = 1;
				
				$getexamname['table'] = 'qdesigner';
				
		
							?>
							 
                <li><a href="#reviewExam<?php print $o['qDesignerId']?>" data-rel="popup" data-position-to="window" data-inline="true" data-transition="pop"><?php echo $emp_name; ?></a></li>
                          
                
    <div data-role="popup" id="reviewExam<?php print $o['qDesignerId']?>" data-overlay-theme="a" data-theme="c" data-dismissible="false" style="max-width:400px;" class="ui-corner-all">
			<div data-role="header" data-theme="a" class="ui-corner-top">
        <h1>Review Exam</h1>
			</div>
			
			<div data-role="content" data-theme="d" class="ui-corner-bottom ui-content">
        <h3 class="ui-title">Are you ready to review this Exam now?</h3>
        <a href="#" data-role="button" data-inline="true" data-rel="back" data-theme="c">Exit</a>
        <a href="<?php echo site_url('manage/exam/' . $o['qDesignerId'].'/'.$a.'/'.$date.'/'.$user_id.'/'.$flag); ?>" data-role="button" data-inline="true" data-theme="b">Review Exam</a>
			</div>
		</div>
                
           <?php
				 }
				 ?>
				  </ol>  
				 <?php
			 }
			 else{
				 ?>
				 <ul data-role="listview" data-autodividers="false" data-filter="true" data-inset="true">
				 <li><b>No employees are available!!!</b></li>
				 </ul>
			 <?php }
           ?>     
                
            
        </div><!-- /collapsible -->
        <div data-role="collapsible" data-inset="false">
            <h2>Candidates</h2>
           
							
							<?php 
		
		
		//$get_type = "SELECT ea.userid,ea.typeid,ea.qDesignerId,cand.first_name FROM examanswer as ea, candidate as cand, assigned_users as assign WHERE typeid = 2 and ea.qDesignerId =".$o['qDesignerId']." and assign.c_status=1 and ea.userid = cand.candidate_id group by cand.first_name ";
		
		$get_type="SELECT cand.first_name,cand.last_name,assign.user_id from candidate as cand,assigned_users as assign where cand.candidate_id = assign.user_id and assign.c_status=1 and assign.type='2' and assign.qid=".$o['qDesignerId'];
		
		$rslt_cand = $this->login_db->get_results($get_type);					
		if($rslt_cand >0){
			?>
			 <ol data-role="listview"  data-filter="true" data-inset="true">
			<?php
			foreach ($rslt_cand as $cand){
				$user_id = $cand->user_id;
				$cand_name = $cand->first_name;
				$flag = 2;

		
				
	?>
							<li><a href="#reviewExamCand<?php print $user_id.$o['qDesignerId'] ; ?>" data-rel="popup" data-position-to="window" data-inline="true" data-transition="pop"><?php echo $cand_name; ?></a></li>
							
			<div data-role="popup" id="reviewExamCand<?php print $user_id.$o['qDesignerId']; ?>" data-overlay-theme="a" data-theme="c" data-dismissible="false" style="max-width:400px;" class="ui-corner-all">
			<div data-role="header" data-theme="a" class="ui-corner-top">
        <h1>Review Exam</h1>
			</div>
			
			<div data-role="content" data-theme="d" class="ui-corner-bottom ui-content">
        <h3 class="ui-title">Are you ready to review this Exam now?</h3>
        <a href="#" data-role="button" data-inline="true" data-rel="back" data-theme="c">Exit</a>
        <a href="<?php echo site_url('manage/exam/' . $o['qDesignerId'].'/'.$a.'/'.$date.'/'.$user_id.'/'.$flag); ?>" data-role="button" data-inline="true" data-theme="b">Review Exam</a>
			</div>
		</div>
           
		
		<?php
			}
			?>
			</ol>
			<?php
		}
		else{
		?>
		 <ul data-role="listview" data-autodividers="false" data-filter="true" data-inset="true">
		<li><b>No Candidates are available!!!</b></li>
     </ul>
    <?php }?>
                
           
        </div><!-- /collapsible -->
    </div><!-- /collapsible set -->
</div><!-- /popup -->
	
	

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

var d = new Date();
var year = d.getFullYear();
var month = d.getMonth()+1;
var day = d.getDate();
var hour = d.getHours();
var minute = d.getMinutes();
var second = d.getSeconds();

var currentdatetime = year + '-' + month + '-' + day + ' ' + hour + ':' + minute + ':' + second;




$('.start_exam_count').click(function(){
	//var qid = $qdesignerid;
	//var userid = $userid;
	//var roleid = $roleid;
	var qiid = this.id;
	$.post('".site_url('exam/start_exam_time')."',{qid:qiid,userid:$userid,roleid:$roleid,currdate:currentdatetime},function(data){
	
	//alert(data);
	
	});
	
	});

";

print ready($script);

?>
	
