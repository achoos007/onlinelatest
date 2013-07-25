 <div id="assigneelist">
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
print title($title);

?>

<div class="data-box">
    <?php
    ?>
    <form method="post" action="<?php print site_url('exam/assigneelist');?>" id="examassign"> 
<div data-role="fieldcontain" >
   Choose Assignee
   <select name="assigneeid" id="assignee" data-mini="true">
      <option value="select">Select</option>
      <option value="1">Employees</option>
      <option value="2">Candidates</option>
   </select>
</div>
       
       
        <input type="hidden" value='<?php print $qid; ?>' name="qdesignerid"/> 
<?php
//print "<input type='button' value='Load More' data-theme='b' name='loadmoreopen' id='loadmoreopen' data-mini='true'/>";
print submit('Continue');
print close();
?>
    </form>
</div>
   </div>  
<?php
$script="
    
    $('#assignee').change(function(){

    value=this.value;
    //alert(value);
    $.post('".site_url('exam/assigneelist/')."',{clkid:value},function(data){
    //alert(data);
    //$('#assigneelist').html(data);
    });

    })
    

    ";
print ready($script);
?>