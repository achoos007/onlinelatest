<?php

ajaxform("examformedit", 'addexam');
$b = enum('qBank', 'questiontype');
$this->load->helper('array');
$this->load->helper('text');
$hour=0;
$minutes=0;
$alerttime=0;
$qdid=0;
if (!empty($subjectid) && ($subjectid > 0)) {
    $questid['table'] = 'qdesigner';
    $questid['where']['qDesignerid'] = $subjectid;
    $questid = getsingle($questid);
    $qdid = $questid['qDesignerId'];
    $suid = $questid['subjectid'];
    $title = $questid['title'];
    $mark = $questid['minMark'];
    $negativemark = $questid['negative'];
    $duration_hour = $questid['duration_hour'];
    $duration_minutes = $questid['duration_minutes'];
    
    $hour = $duration_hour;
     if($hour < 10){
			$hour = "0".$hour;
		}
		//print "Hour".$hour;
    $minutes = $duration_minutes;
    if($minutes < 10){
			$minutes = "0".$minutes;
		}
		
		//print "Minutes".$minutes;
   /* $roundedhour = floor($duration/60/60);
    if($roundedhour > 0){
		}
    $min = explode(".",$hour);
    $splithour = empty($min)?0:$min[0];
    $splitmin = empty($min)?0:$min[1]*10;
    
    print "Split Min".$splitmin."\n";
    print "Split hour".$splithour."\n";
    if($splithour < 10)
		{
			$splithour = "0".$splithour;
		}
     if($splitmin < 10)
		{
			$splitmin = "0".$splitmin;
			print "Split Minnnnn".$splitmin;
		}*/
    //$hour = empty($hour)?"00":$hour;
    //$minutes = empty($minutes)?"00":$minutes;
   //print "Hour".$hour;
    $alerttime = ($questid['alertTime']/60);
    $negative = $questid['negative'];
    $grading = $questid['grading'];
    $shuffling = $questid['shuffling'];
    $timer = $questid['timer'];
    $marktype = $questid['markType'];
	
	$val['mm'][] = $questid['mmEasy'];
	$val['mm'][] = $questid['mmModerate'];
	$val['mm'][] = $questid['mmTough'];
	$val['mm'][] = $questid['mmMandatory'];

	$val['ms'][] = $questid['msEasy'];
	$val['ms'][] = $questid['msModerate'];
	$val['ms'][] = $questid['msTough'];
	$val['ms'][] = $questid['msMandatory'];

	$val['st'][] = $questid['desEasy'];
	$val['st'][] = $questid['desModerate'];
	$val['st'][] = $questid['desTough'];
	$val['st'][] = $questid['desMandatory'];

	$val['fu'][] = $questid['fileEasy'];
	$val['fu'][] = $questid['fileModerate'];
	$val['fu'][] = $questid['fileTough'];
	$val['fu'][] = $questid['fileMandatory'];
	
	$val['yn'][] = $questid['tfEasy'];
	$val['yn'][] = $questid['tfModerate'];
	$val['yn'][] = $questid['tfTough'];
	$val['yn'][] = $questid['tfMandatory'];
	
	
}
?>


<form method="post" action="<?php print site_url("exam/edit")  ?>" id="examformedit">

	<div style="float:left;width:250px; padding:1px; height:350px;" align='center'>
		<div data-role="collapsible"  data-theme="b" data-content-theme="c" data-collapsed="false"  data-mini="true" >
			<h4>General Settings</h4>
				<ul data-role="listview" data-mini='true' style=" height:316px; background-color:#EEEEEE;" data-theme='c'>
					
					<li  data-mini='true' >
						<fieldset data-role="controlgroup"  data-mini='true' >
							<label  data-mini='true' >Title</label>
							<input type="text" name="title"  data-mini="true" id="title" value="<?php
							print empty($title) ? '' : $title; ?>"  placeholder="Title" >
						</fieldset>
					</li>
					
					<li>
					  <fieldset data-role="controlgroup">
							<label>Minimum Mark</label>
							<input type="text" value="<?php print empty($mark) ? '50' : $mark  ?>" name="mark" id="mark" data-mini="true" placeholder='50%'  >
						</fieldset>
					</li>
					
					<!--<li>
						<fieldset data-role="controlgroup">
							<label>Duration</label>
							<input type="text" value="<?php //print empty($duration) ? '' : $duration  ?>" name="duration" id="duration" data-mini="true" placeholder='Minutes' >
					  </fieldset>
					</li>-->
					<li>
					<fieldset data-role="controlgroup" data-type="horizontal" data-mini="true">
   <label>Duration</label>
    <label for="hour">Hour</label>
    <select name="hour" id="hour">
			
			<?php 
				for($i=0;$i<=9;$i++){
					if($i<10){
							$k = "0".$i;
						}
					else{
						$k=$i;
					}
				?>
				<option value='<?php print $i;?>'  <?php if($hour == $k) { ?> selected='selected' <?php } ?> ><?php print $k; ?></option>
				<?php
				}
      ?>
    </select>
    <label for="minutes">Minutes</label>
    <select name="minutes" id="minutes">
        <?php 
					for($j=0;$j<60;$j=$j+5){
						if($j<10){ $m = "0".$j; }	else{	$m =$j; }
						
				?>
						<option value='<?php print $j; ?>' <?php if($minutes == $m) { ?> selected='selected' <?php } ?> ><?php print $m; ?></option>
			<?php		
					}
				?>
    </select>
    <label>&nbsp; (hour:min)</label>

</fieldset>
					</li>
					
					<li>
						<fieldset data-role="controlgroup">
							<label>Alert Time</label>
						  <select name="alerttime" id="alerttime" data-mini="true">
							<?php 
								for($n=0;$n<=30;$n=$n+5){
									if($n < 10){$p = "0".$n; } else{ $p = $n; }
								
							?>
							<option value='<?php print $n; ?>' <?php if($alerttime == $p) { ?> selected='selected' <?php } ?> ><?php print $p; ?></option>
							<?php		
								}
							?>
						</select>
					 </fieldset>
					</li>
				</ul>
		</div>
  </div>

	<div style="float:left;width:250px; padding:1px; height:350px;" align='center'>
		<div data-role="collapsible" data-collapsed="false" data-theme="b" data-content-theme="c"  data-mini="true" >
			<h4>Exam Parameters</h4>
				<ul data-role="listview" data-mini='true'  style=" height:315px; background-color:#EEEEEE;" data-theme='c'>
					
					<li>
						<fieldset data-role="controlgroup" data-mini="true" >
							<?php 
								$negative = empty($negativemark)?'':$negativemark;
							?>				
							<label  data-mini='true' >Negative Mark</label>
							<select name="negativemark" id="negativemark" data-inline="true">
								<option value='0' <?php if($negative == 0){ ?> selected <?php } ?> >0</option>
								<option value="0.25"  <?php if($negative == 0.25){ ?> selected <?php } ?> >0.25</option>
								<option value="0.5"  <?php if($negative == 0.5){ ?> selected <?php } ?>>0.50</option>
								<option value="0.75"  <?php if($negative == 0.75){ ?> selected <?php } ?>>0.75</option>
								<option value="1"  <?php if($negative == 1){ ?> selected <?php } ?>>1</option>
							</select>

							
							
              <!--<input type="checkbox" name="negativemark" id="checkbox-1a" class="custom" data-mini="true" <?php //if ($subjectid > 0 && $negative == 'on') { ?>checked="checked" <?php //} ?>/>
              <label for="checkbox-1a">Negative mark</label>-->
            </fieldset>
					</li>
					
					<li>
						<fieldset data-role="controlgroup">
							<input type="checkbox" name="grading" id="grading" class="custom" data-mini="true" <?php if ($subjectid > 0 && $grading == 'on') { ?> checked="checked" <?php } ?>/>
              <label for="grading">Grading</label>
             </fieldset>
					</li>
					
					<li>
						<fieldset data-role="controlgroup">
              <input type="checkbox" name="shuffling" id="shuffling" class="custom" data-mini="true" <?php if ($subjectid > 0 && $shuffling == 'on') { ?> checked="checked"<?php } ?>/>
              <label for="shuffling">Shuffling</label>
            </fieldset>
					</li>
        
					<li>
						<fieldset data-role="controlgroup">
              <input type="checkbox" name="timer" id="timer" class="custom" data-mini="true" <?php if ($subjectid > 0 && $timer == 'on') { ?> checked="checked" <?php } ?> />
              <label for="timer">Timer</label>
            </fieldset>
					</li>
				</ul>
			</div>
		</div>
		
		<div style="float:left;width:250px; padding:1px; height:350px;" align='center'>
			<div data-role="collapsible" data-collapsed="false" data-theme="b" data-content-theme="c"  data-mini="true" >
				<h4>Subject Parameters</h4>
					<ul data-role="listview"  style=" height:315px; background-color:#EEEEEE;" data-theme='c' data-mini='true'>
						
					
        
						<li>
							<fieldset data-role="controlgroup">
								<label>Subject</label>
								<select name="subjectid" id="subjectid" data-mini="true">
									<option value="">Select</option>
                                      <?php
									$query = $this->db->query("SELECT n_subjectid,c_subject FROM tbl_subject where c_subject!='' and status='1'");
									if ($query->num_rows() > 0) {
                    foreach ($query->result() as $row) {
                      $name = $row->c_subject;
                      $name = word_limiter($name, 3);
                      $subjectid = $row->n_subjectid;
                     if($subjectid == $suid)
                     { 
											 $chk = "selected";
										 }
										 else{ 
											 $chk = ""; 
										 }
                    
											
                      
                      print "<option value='" . $subjectid . set_select('subjectid', $subjectid) . "' ".$chk.">" . $name . "</option>";
                       
                    }
									}
									?>
								</select>
              </fieldset>
						</li>
					</ul>
      </div>
    </div>
        
    <div style="float:left;width:210px; padding:1px;  " align='center'>
			<div data-role="collapsible" data-collapsed="false" data-theme="b" data-content-theme="c"  data-mini="true" >
				<h4>Marks Parameters</h4>
					<ul data-role="listview" data-mini='true' style=" height:315px; background-color:#EEEEEE;" data-theme='c'>
						<li>
							<fieldset data-role="controlgroup">
								<input type="radio" name="radio-choice-2" id="radio-choice-1" value="0" <?php set_radio('radio-choice-2', '0'); ?> data-mini="true" <?php //if ($subjectid > 0 && $marktype == 0) { ?> checked="checked" <?php //} ?>/>
								<label for="radio-choice-1">Equal Marks</label>
              </fieldset>
						</li>
						
						<li>
							<fieldset data-role="controlgroup">
								<input type="radio" name="radio-choice-2" id="radio-choice-2" value="1"  data-mini="true" <?php //if ($subjectid > 0 && $marktype == 1) { ?> checked="checked" <?php //} ?> />
								<label for="radio-choice-2">Database Marks</label>
              </fieldset>
						</li>
          </ul>
       </div>
    </div>
 
 
 
		<div>&nbsp;</div>
		<div class='clear'></div>       

		
    <?php 
   
			$type[1]='mm';
			$type[]='ms';
			$type[]='st';
			$type[]='fu';
			$type[]='yn';
    
			$typename[]="Easy - Total";
			$typename[]="Moderate - Total";
			$typename[]="Tough - Total";
			$typename[]="Mandatory - Total";
              
			$c=0;
	
		foreach ($b as $e) { 
				$c++;
							
		?>

    <h3><?php print ucfirst(strtolower($e)); ?></h3>
	
		<div class="ui-grid-d ui-responsive">
    <?php
      $qrty['table'] = 'qBank';
      $qrty['where']['questiontype'] = $e;
      $qrty['limit'] = 10000000;
      $qrty = getrecords($qrty);

      $qe['table'] = 'qBank';
      $qe['where']['questiontype'] = $e;
      $qe['where']['level'] = 'easy';
      $qe['limit'] = 10000000;
      $qe = getrecords($qe);

      $qm['table'] = 'qBank';
      $qm['where']['questiontype'] = $e;
      $qm['where']['level'] = 'moderate';
      $qm['limit'] = 10000000;
      $qm = getrecords($qm);

      $qt['table'] = 'qBank';
      $qt['where']['questiontype'] = $e;
      $qt['where']['level'] = 'tough';
      $qt['limit'] = 10000000;
      $qt = getrecords($qt);

      $qma['table'] = 'qBank';
      $qma['where']['questiontype'] = $e;
      $qma['where']['level'] = 'mandatory';
      $qma['limit'] = 10000000;
      $qma = getrecords($qma);

      print ' <div class="ui-block-a" ><div class="ui-body ui-body-b" style="height:60px;"><h3>Available:<span id="'.$c.'_count">'.count($qrty['result']).'</span></h3></div></div>';
        $data['co_id'][] = $c.'_count'; 
        
				for ($i = 0; $i < 4; $i++) {
					
				
					if(!empty($data['readonly']))
						unset($data['readonly']);
						
						$data['id'] = $data['name'] = $type[$c]."_".$i."_count";
						$data['id_array'][] =	$data['name'];
						
							if(!empty($val[$type[($i+1)]]))
								
								$data['value'] = $val[$type[$c]][$i]; 
								
								
									if ($i == 0){
										$data['totalquest'] = count($qe['result']);
											if(count($qe['result'])<1)
												$data['readonly']=	"readonly";
                    
									}
						
									if ($i == 1){
										$data['totalquest'] = count($qm['result']);
											if(count($qm['result'])<1)
												$data['readonly']=	"readonly";
									}
						
									if ($i == 2){
										$data['totalquest'] = count($qt['result']);
											if(count($qt['result'])<1)
												$data['readonly']=	"readonly";
									}
            
									if ($i == 3){
										$data['totalquest'] = count($qma['result']);
											if(count($qma['result'])<1)
												$data['readonly']=	"readonly";
									}
						
            $data['data-mini'] = 'true';
            $data['style'] = 'width:50%;';
            print '  <div class="ui-block-d"><div class="ui-body ui-body-d" style="height:60px;"> 
                 '.$typename[$i].' ('.$data['totalquest'].')  
                ' . form_input($data) . ' </div></div>';
        }
        
        if($c == '5')
        {
         ?>
         
        <input type='hidden' value='<?php print json_encode($data['id_array']); ?>' name='test' id="test">
        <input type='hidden' value='<?php print json_encode($data['co_id']); ?>' name='co_count' id="co_count">
      <?php
     
		 }
		 
		 ?>
		 
		
		 <?php

        print "</div><!-- /grid-d -->";
        
        
        
    }
        
    ?>
    <p>&nbsp;</p>
		<div id="addexam"></div>
		<div align="center" >
			<table  style="margin-top:20px;float:left; " width="100%">
				<tr><td align="center" colspan="6">
          <input type="hidden" value="1" name="status">
          <input type="hidden" value='<?php print $qdid; ?>' name="qdesignerid"/>
          <input value='<?php print $bttnText; ?>' type="submit"   data-mini='true'  data-theme='b'/>
          
        </td>
        <td><?php print close('Cancel'); ?></td>
        </tr>
			</table>
		</div>
		
		<div id="module"></div>
		<div id="mockvalue"></div>
</form>

<?php
	$script = "
 
		$('#productid').change(function(){
			
			value=this.value;

			$.post('" . site_url('exam/module/') . "',{clkid:value},function(data){

				$('#moduleid').html(data);

			});	
    
		});
		
		
    
		$('#moduleid').change(function(){

			value=this.value;

			$.post('" . site_url('exam/subject/') . "',{clkid:value},function(data){

				$('#subjectid').html(data);
				
			});

		});
		
		

		$('.mocktest').change(function(){
			
			value=this.value;

			$.post('".site_url('exam/mockuptest')."',{clkid:value},function(data){

				$('#mocktest1').html(data);
				
			});
			
	
		});
		
$('#subjectid').change(function(){
		 
		 value = this.value;
		 
		 var objj = $.parseJSON($('#test').val()); 
		 var objj1 = $.parseJSON($('#co_count').val()); 
		 //alert(objj1[0]);
		 $.post('".site_url('exam/sub_selection')."',{clkid:value},function(data){

			var obj = $.parseJSON(data); 
			//alert(data);
			var incr=0;

			$.each(obj.placeholder, function(key, val) {
	
				$('#'+objj[incr]).attr('placeholder',val);
				incr++;
	
			});
			var incr_count=0;
			$.each(obj.count, function(key, val) {
	//alert(objj1[incr]);
				$('#'+objj1[incr_count]).html(val);
				incr_count++;
	
			});
			

		});
});

	";
	print ready($script);
?>
