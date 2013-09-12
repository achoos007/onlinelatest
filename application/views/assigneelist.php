<?php



// For getting current date
$entrydate=entrydate();

// for getting country code
$co['table'] = 'country';
$co = getrecords($co);
	
if ($uid == '1') {  // 1 denotes employees

	// For getting title name
  $qdes['table'] = 'qdesigner';
  $qdes['where']['qDesignerId'] = $qid;
  $qdes = getsingle($qdes);
  $title = $qdes['title'];
?>

<div id="sucess-msg"></div>
	<div data-role="content" >
		<div class="content-primary">
			<ul data-role="listview" data-inset='true' data-filter='true' >
      <?php
				$temp='';
				foreach ($co['result'] as $row) {
					$code = $row['code'];
          $cname = $row['name'];
          if($temp != $cname){
      ?>
						<li data-role="list-divider" data-theme="a"><?php print $cname; ?></li>
      <?php
					}
          
          // Fetching employee list
					$emplist['table'] = 'tbl_staffs';
					$emplist['order']['first_name'] = 'asc';
					$emplist['join']['assigned_users']='tbl_staffs.staff_id=assigned_users.user_id and qid="'.$qid.'"';
					$emplist['where']['country_code'] = $code;
					$emplist['where']['status'] = 'Active';
					$emplist['limit']=1000000;
					$emplist = getrecords($emplist);
											
					foreach ($emplist['result'] as $row) {
						$st = 'bhr' . $row['staff_id'];
						$assign_status=$row['assign_status'];
						$img_url = 'http://198.1.110.184/~geniuste/gg/'.$row['photo'];
						$img = empty($row['photo'])? base_url('images/cands.jpg') : $img_url;
						if($assign_status == 'Active')
							$status_val='Remove';
						else
							$status_val='Assign';
							
						$str = ucfirst(strtolower($row['first_name'])) . "&nbsp;" . ucfirst(strtolower($row['last_name']));
						print " <li data-theme='b'><a  class='$st bhr'  href='javascript:void(0);'  >
										<img src='".$img."' style='padding-top:10px;padding-left:10px;'>
										<h2>$str</h2>
										<div>
											<fieldset data-role='controlgroup' data-type='horizontal'> 
												<input type='radio' name='radio-choice-2' id='".$row['staff_id']."' value='' class='userassign' data-mini='true'  />
												<label for='".$row['staff_id']."'><div id='test".$row['staff_id']."' >$status_val</div></label>
											</fieldset>
										</div>
										<div class='statusmsg'></div></a>
										</li>  ";
					}
        }
      ?>
      </ul>
    </div>
  </div>
  <div><input value='Assign' type="submit"  data-inline='true' data-mini='true'  data-theme='b'/></div>
  <div id="deleteQuestion" data-role='popup' style='width:250px; padding:50px; border:5px solid #B9B9B9;' data-theme='d'>
       You have added this user(s) to <?php echo $title; ?> exam
  <div class='clear'><br/><br/></div>
	<?php
		print button('Assign', '', 'delete_question');
		print close();
} 

// This is for candidate Details
else if($uid == '2'){

	?>

	<div id="sucess-msg"></div>
		<a href="#popupLogin" data-rel="popup" data-position-to="window" data-role="button" data-inline="true" data-icon="plus" data-theme="b" data-transition="pop">Add New Candidate</a>
		<div data-role="popup" id="popupMenu" data-theme="b">
			<div data-role="popup" id="popupLogin" data-theme="b" class="ui-corner-all">
				<a href="#" data-rel="back" data-role="button" data-theme="b" data-icon="delete" data-iconpos="notext" class="ui-btn-right">Close</a>
        <form id="addcandidate_recent" method="post" action="<?php print site_url("exam/newcandidate")  ?>">
        <div style="padding:10px 20px;">
          <div id="candidate_success_recent" ><h3>Please sign in</h3></div>
						<label for="un" class="ui-hidden-accessible">Username:</label>
            <input name="user" id="un" value="" placeholder="username" data-theme="b" type="text">
            <label for="pw" class="ui-hidden-accessible">Password:</label>
            <input name="pass" id="pw" value="" placeholder="password" data-theme="b" type="password">
            <label for="fn" class="ui-hidden-accessible">Firstname</label>
            <input name="firstname" id="fn" value="" placeholder="firstname" data-theme="b" type="text">
            <label for="ln" class="ui-hidden-accessible">Lastname</label>
            <input name="lastname" id="ln" value="" placeholder="lastname" data-theme="b" type="text">
            <label for="email" class="ui-hidden-accessible">Email</label>
            <input name="email" id="email" value="" placeholder="email" data-theme="b" type="text">
            <label for="country_code" class="ui-hidden-accessible">Select </label>
						<select name="country_code" id="country_code" data-mini="true">
								<?php
			$country_list['table']='country';
			$country_list=getrecords($country_list);
			foreach($country_list['result'] as $cname ){
				print "<option value='".$cname['code']."'>".$cname['name']."</option>";
			}
?>
						</select>
						<br><br>
            <button type="submit" data-theme="b" data-inline="true" >Save</button>
          </div>
					</form>
			</div>
		</div>
		
		<div data-role="content" >
			<div class="content-primary">
				<ul data-role="listview" data-inset='true' data-filter='true'>
        <?php
        $temp='';
        foreach ($co['result'] as $row) {
					$code = $row['code'];
					$cname = $row['name'];
					if($temp != $cname){
				?>
					<li data-role="list-divider" data-theme='a'> <?php print $cname; ?></li>
				<?php
					}
				
					$candlist['table'] = 'candidate';
					$candlist['order']['first_name'] = 'asc';
					$candlist['join']['assigned_users']='candidate.candidate_id=assigned_users.user_id and qid="'.$qid.'"';
					$candlist['where']['country_code'] = $code;
					$candlist['where']['status'] = 'Active';
					$candlist['limit']=1000000;
					$candlist = getrecords($candlist);

					foreach ($candlist['result'] as $row) {
						$st = 'bhr' . $row['candidate_id'];
						$assign_status=$row['assign_status'];
						if($assign_status == 'Active')
							$status_val='Remove';
						else
							$status_val='Assign';
						$str = ucfirst(strtolower($row['first_name'])) . "&nbsp;" . ucfirst(strtolower($row['last_name']));
								
						print " <li data-theme='b'><a  class='$st bhr'  href='javascript:void(0);'  >
										<img src='".base_url('images/cands.jpg')."'  style='padding-top:10px;padding-left:10px;'>
										<h2>$str</h2>
										<p>
    
										<fieldset data-role='controlgroup' data-type='horizontal'> 
										<input type='radio' name='radio-choice-2' id='".$row['candidate_id']."' value='' class='userassign' data-mini='true'  />
										<label for='".$row['candidate_id']."'><div id='test".$row['candidate_id']."' >$status_val</div></label>
										</fieldset>
										</p>
										<div class='statusmsg'></div></a>
										<a href='".site_url('exam/editcandidate/'.$row['candidate_id'])."'  data-icon='grid'  data-rel='dialog'>Edit Candidate</a>
										</li>  ";
					}
	        $temp=$cname;
        }
        ?>
				</ul>
			</div>
		</div>
  
		<div data-role='popup' id='editcandidate' data-theme='b'>
      <ul data-role='listview' data-inset='true' style='min-width:210px;' data-theme='d' data-filter='false'>
        <li data-role='divider' data-theme='b'>Choose an action</li>
        <li><a href='#popupLogin' data-rel="popup" data-position-to="window" id='"<?php print $row['candidate_id'] ?>"' class='editlogin' >Add</a></li>
        <li><a href='#'>Delete</a></li>
      </ul>
		</div>				

		<div id="deleteQuestion" data-role='popup' style='width:250px; padding:50px; border:5px solid #B9B9B9;' data-theme='d'>
    You have added this user(s) to <?php echo $title; ?> exam
			<div class='clear'><br/><br/></div>
			<?php
				print button('Assign', '', 'delete_question');
				print close();
}
?>
</div>
       
<?php
	$script = "
	
	
		
		
	// This is for multiple selection of candidate and assign them to an exam		
	$('#testid').submit(function(){
		//val=$('.chkbox').val();
		//alert(val);
		var str = $('form').serialize();
		$.post('".site_url('exam/test/')."',{chkvalue:str,date:$entrydate},function(data){
			alert(data);
		});
		
		});
		
		$('.editcandidate').click(function(){
			clickid=this.id;
			//alert(clickid);
			$('.editlogin').append('<a>Edit</a>');
			});

			
		$('.userassign').click(function(){
			clickId=this.id;
			
			$.post('".site_url('exam/user_selection/')."',{clkid:clickId,qid:$qid,uid:$uid,entrydate:$entrydate},function(data){
			
			if(data==0)
			{	
				//alert('Removed');
				$('#test'+clickId).html('Assign');
			}
			else if(data==1)
			{
				//alert('Assigned');
				$('#test'+clickId).html('Remove');
			}
			else{
			alert('Error Occured!!!');
		}
		});
			
			});	
			
			
		";
	print ready($script);
	
 ajaxform("addcandidate_recent",'candidate_success_recent');  
?>
