














<?php 
print title($title);
?>


 



<div data-role='content'>
 




















 

<form id='AddQuestionsForm' action="<?php print site_url("question/qupload");?>" method="post" data-ajax='false'  enctype="multipart/form-data" >

<div>
<h4>Please Upload an Excel File in specified format</h4>
</div>

<input type="file" name="excelFile" id="excelFile"  />

<div align='center'>

<?php 
print submit('Upload');
?>



</div>
 
</form>





<div id='AddQ_res'></div>



</div>


















<?php 

ajaxform('AddQuestionsForm','AddQ_res');


/*

?>
<div style='width:650px;'>

<label for="select_product" class="select">Select Product:</label>
<select name="select_product" id="select_product">



<?php

$product['table']="tbl_product";
$product=getrecords($product);
if(!empty($product['result']))
foreach($product['result'] as $prod){


print "  <option value='".$prod['prod_id']."'>".ucwords($prod['prod_name'])."</option>";
}

?>
 
   
   
   
</select>


<label for="select_module" class="select">Select Module:</label>
<select name="select_module" id="select_module">



<?php

$modules['table']="tbl_modules";
$modules=getrecords($modules);
if(!empty($modules['result']))
foreach($modules['result'] as $mods){ 

print "  <option value='".$mods['module_id']."'>".ucwords($mods['module_name'])."</option>";
}

?> 
</select> 

<label for="select_subject" class="select">Select Subject:</label>
<select name="select_subject" id="select_subject"> 

<?php 
$subject['table']="tbl_subject";
$subject=getrecords($subject);
if(!empty($subject['result']))
foreach($subject['result'] as $subj){ 
print "  <option value='".$subj['n_subjectid']."'>".ucwords($subj['c_subject'])."</option>";
}

?> 
   
</select>  
</div>
<?php 

*/

?>
