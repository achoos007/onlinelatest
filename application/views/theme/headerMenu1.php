
<table width="100%" height="768px" border="0" cellpadding="0" cellspacing="0"   >


<tr>

<td   align="center" height='100px'  ><a href="<?php print site_url();?>"><img src="<?php echo base_url("images/header.jpg"); ?>" border="0" /></a></td>

</tr>  


<tr>

<td   align="center"  valign='top' > 






<table width="1000px" border="0"   height="100%" cellpadding="0" cellspacing="0">
<tr>
<td  bgcolor="#0e4081" height="40px" valign='top'>



<div align="right" style='color:#FFFFFF;margin:3px;'>


			Welcome <?php print ucwords($this->session->userdata('name'));?> | <a href='<?php print site_url('logout');?>' data-ajax='false'><label>Logout</label></button></a> 

</div>


<div data-role="navbar"  >
<ul>
<li><a href="<?php echo site_url(); ?>"  data-ajax='false'  <?php 		print ($this->menu=="home")? ' class="ui-btn-active ui-state-persist" ':'';		?> >Home</a></li>
<li><a href="<?php echo site_url("subjects/");?>" data-ajax='false'  <?php 		print ($this->menu=="subjects")? ' class="ui-btn-active ui-state-persist" ':'';		?> >Subjects</a></li>
<li><a href="<?php echo site_url("question");?>" data-ajax='false'  <?php 		print ($this->menu=="question")? ' class="ui-btn-active ui-state-persist" ':'';		?> >Upload Questions</a></li>
<li><a href="<?php echo site_url("exam/designer");?>" data-ajax='false'   <?php 		print ($this->menu=="exam")? ' class="ui-btn-active ui-state-persist" ':'';		?> >Exam</a></li>
<li><a href="<?php echo site_url("manage/exam/");?>" data-ajax='false'  <?php 		print ($this->menu=="result")? ' class="ui-btn-active ui-state-persist" ':'';		?>  >Manage Exam</a></li>
</ul>
</div>

</td> 
</tr>


<tr>

<td valign='top'>
