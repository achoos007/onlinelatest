<style type='text/css'>
.menu-box{
padding:5px; 
background-color:#EBEBEB;  
border:1px outset #A1A1A1;
-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px; 
width:127px;
height:125px;
margin:10px;
float:left;
overflow:hidden;
}
.menu-image{
padding:5px; 
background-color:#EBEBEB;  
border:1px outset #A1A1A1;
-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px; 
height:75px;
overflow:hidden;
}
</style>




<?php
$roleid = $this->session->userdata('roleid');
if($roleid == 0){ 
?>


<a href="<?php print site_url('subjects/form');?>" data-rel="dialog" >
<div class='menu-box' align='center'>
<div class='menu-image' align='center'>
	<img src="<?php print base_url('images/subject.jpg');?>" border='0' width='115px' />
</div>
<h3>
Add Subjects
</h3>
</div>
</a>

<a href='<?php print site_url('subjects');?>'> 
<div class='menu-box' align='center'>
<div class='menu-image' align='center'>
	<img src="<?php print base_url('images/subject1.jpg');?>" border='0' width='115px' />
</div>
<h3>
Manage Subjects
</h3>
</div>
</a>

<a href='<?php print site_url('question/bank');?>'>
<div class='menu-box' align='center'>
<div class='menu-image' align='center'>
	<img src="<?php print base_url('images/quest.jpg');?>" border='0'width='115px' />
</div>
<h3>
Question Bank
</h3>
</div>
</a>
<a href="<?php print site_url('question/form/0');?>" data-rel='dialog' data-mini='true'>
<div class='menu-box' align='center'>
<div class='menu-image' align='center'>
	<img src="<?php print base_url('images/quest1.jpg');?>" border='0'width='115px' />
</div>
<h3>
Add Questions
</h3>
</div>
</a>

<a href='<?php print site_url('question');?>'>
<div class='menu-box' align='center'>
<div class='menu-image' align='center'>
	<img src="<?php print base_url('images/quest2.jpg');?>" border='0'width='115px' />
</div>
<h3>
Open Questions
</h3>
</div>
</a>
<a href="<?php print site_url('question/upload');?>" data-rel='dialog' data-mini='true'>
<div class='menu-box' align='center'>
<div class='menu-image' align='center'>
	<img src="<?php print base_url('images/quest3.jpg');?>" border='0'width='115px' />
</div>
<h3>
Upload Questions
</h3>
</div>
</a>



<a href='<?php print site_url('exam/designer');?>'>
<div class='menu-box' align='center'>
<div class='menu-image' align='center'>
	<img src="<?php print base_url('images/write1.jpg');?>" border='0'width='115px' />
</div>
<h3>
Recent Exams
</h3>
</div>
</a>



<!--<a href='<?php print site_url('exam/form');?>'>
<a href='<?php print site_url('exam/execute');?>'>-->
<a href="#popupLogin111" data-transition="pop" data-rel="popup" data-position-to="window" data-transition="pop">
<div class='menu-box' align='center'>
<div class='menu-image' align='center'>
	<img src="<?php print base_url('images/cands.jpg');?>" border='0'width='115px' />
</div>
<h3>
Add Candidate
</h3>
</div>
</a>

<div data-role="popup" id="candpopupMenu" data-theme="b">
    <div data-role="popup" id="popupLogin111" data-theme="b" class="ui-corner-all">
			 <a href="#" data-rel="back" data-role="button" data-theme="b" data-icon="delete" data-iconpos="notext" class="ui-btn-right">Close</a>
        <form id="addcandidate" method="post" action="<?php print site_url("exam/newcandidate")  ?>">
            <div style="padding:10px 20px;">
              <div id="candidate_success" ><h3>Please sign in</h3></div>
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
<?php
ajaxform("addcandidate",'candidate_success');
?>


<a href='<?php print site_url('exam/form');?>'>
<div class='menu-box' align='center'>
<div class='menu-image' align='center'>
	<img src="<?php print base_url('images/write2.jpg');?>" border='0'width='115px' />
</div>
<h3>
Create Exams
</h3>
</div>
</a>



<a href='<?php print site_url('exam/designer');?>'>
<div class='menu-box' align='center'>
<div class='menu-image' align='center'>
	<img src="<?php print base_url('images/write5.jpg');?>" border='0'width='115px' />
</div>
<h3>
Assign Exams
</h3>
</div>
</a>



<a href='<?php print site_url('exam/designer');?>'>
<div class='menu-box' align='center'>
<div class='menu-image' align='center'>
	<img src="<?php print base_url('images/write3.jpg');?>" border='0'width='115px' />
</div>
<h3>
Manage Exams
</h3>
</div>
</a>
<?php }
?>


<a href='<?php print site_url('exam/designer');?>'>
<div class='menu-box' align='center'>
<div class='menu-image' align='center'>
	<img src="<?php print base_url('images/write4.jpg');?>" border='0'width='115px' />
</div>
<h3>
Assigned Exams
</h3>
</div>
</a>

<a href='#'>
<div class='menu-box' align='center'>
<div class='menu-image' align='center'>
	<img src="<?php print base_url('images/view-result.jpeg');?>" border='0'width='115px' />
</div>
<h3>
View Reports
</h3>
</div>
</a>
 
