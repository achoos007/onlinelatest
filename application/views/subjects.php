

<?php 

// print " hai ";
			$count = 0;
			$query = $this->db->query("SELECT n_subjectid,c_subject,addedby,status,d_date FROM tbl_subject order by d_date desc");
			 
			
?>
<div align='center'>
	 
	
	  
	  
<div data-role='collapsible-set'>


<?php 
if ($query->num_rows() > 0)
			{
			   foreach ($query->result() as $row)
			   {
				   $n_subjectid=$row->n_subjectid;
				   $c_subject=$row->c_subject;
				   $date=$row->d_date;	
				   $addedby=$row->addedby;
				   $status=$row->status;
				   $count = $count+1;
				   if($status == 1)
				   	$st ="Active";
					else
					$st ="Inactive";
				$addedby=$this->login_db->get_empusername($addedby);


/*
ajaxform("subjectform".$row->n_subjectid,"editform");
*/
?>


<div data-role="collapsible" <?php print (strtolower($status)==1)? " data-collapsed-icon='check' ":" data-collapsed-icon='delete' "; ?>  data-content-theme="c"  >
	<h3><?php echo $c_subject ?></h3> 
	 
	 <table width="100%">
		<tr>
			<td > 
    <div ><h4>Date Created: <?php echo dateformat($date,'d/m/Y'); ?></h4></div>
    <div ><h4>Added By :<?php echo $addedby ?></h4></div>
    <div ><h4>Status :<?php echo $st ?></h4></div>
    
    </td>
			<td width="100px">
			
    	<?php 
    	
    	print dialog("subjects/form/".$row->n_subjectid, 'Edit');
    	?>  
    
     </td>
		</tr>
	 </table>
	  
	</div>
	
	  <?php 
				   }
				}
				?>
	
	
	
	
	 
	
</div>
	
</div> 
	
	
	
 
	
	
	
	
	
	
	
	
	
	
	

