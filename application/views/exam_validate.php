<div data-role="collapsible" data-theme="b" data-content-theme="d" data-collapsed-icon="arrow-d" data-expanded-icon="arrow-u">
	
	<h4>Employees</h4>
	<ul data-role="listview" data-inset="false">
		
	<?php 
		if($rslt >0){
			foreach ($rslt as $row){
				$emp_name = $row->first_name;
				$qdesignerid = $row->qDesignerId;
				
				$getexamname['table'] = 'qdesigner';
				$getexamname['where']['qDesignerId'] = $qdesignerid;
				$getexamname = getsingle($getexamname);
				
				$examname = $getexamname['title'];
				
	?>
		 <table width="100%">
        <tr>
          <td > 
            <div style='padding-left:10px;'><h4><?php echo $emp_name ?></h4></div>
          </td>
		<td>	 <a href="#viewexams" data-rel="popup" data-role="button" data-inline="true" data-transition="slideup" data-icon="gear">Completed Exams</a>   
		
		<div data-role="popup" id="viewexams" data-theme="d">
        <ul data-role="listview" data-inset="true" style="min-width:210px;" data-theme="d">
            <li data-role="divider" data-theme="e">Select an exam</li>
            <li><a href="#"><?php print $examname; ?></a></li>
            <!--<li><a href="#">Exam 2</a></li>
            <li><a href="#">Exam 3</a></li>
            <li><a href="#">Exam 4</a></li>-->
        </ul>
	</div>
		
		
		 </td>	
		</tr>
		</table>
		<?php
			}
		}
		else{
		?>
		
		<li><b>No employees are available!!!</b></li>
			
		<?php }?>
   
	</ul>
</div>

<div data-role="collapsible" data-theme="b" data-content-theme="d" data-collapsed-icon="arrow-d" data-expanded-icon="arrow-u">
	<h4>Candidates</h4>
	<ul data-role="listview" data-inset="false">

	<?php 
		if($rslt_cand >0){
			foreach ($rslt_cand as $cand){
				empty($cand_name)? '' : $cand->first_name;
	?>
	
		<li><?php print $cand_name?></li>	
		
		<?php
			}
		}
		else{
		?>
		
		<li><b>No Candidates are available!!!</b></li>
     
    <?php }?>
     
  </ul>
</div>

