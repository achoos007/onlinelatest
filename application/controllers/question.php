<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Question extends CI_Controller {
 

	public function index($start=0){

		$data['start'] =intval($start);

		$this->menu="question";

		$this->title="Question";

		$this->open($data['start']);

	}

function open($start=0){

	$data['start'] =intval($start);
	$this->session->set_userdata('q_bank_start',$data['start']);
	$data['menu']='question';

	$this->load->helper('text');
	$this->menu="question";
	$this->title="question";
	
	$data['result'] = $this->do_upload();
	$data['main']['open_question_list']['right']['text']=	"Options";  
	$data['main']['open_question_list']['right']['url']=	"#popupMenu"; 
	$data['main']['open_question_list']['right']['option']=	" data-rel='popup'  data-inline='true' data-position-to='orgin' "; 
	$data['main']['open_question_list']['title']=	"Open Questions";  
	$data['main']['open_question_list']['page']=		$this->load->view("openQuestions",$data,TRUE); 


	$this->load->view("theme/header",$data);
	$this->load->view("theme/index",$data);
	$this->load->view("theme/footer",$data);

}

function qupload(){

	$data=$this->do_upload(); 
	if(!empty($data['success'])){
		$this->importquestions($data['success']['full_path']);
	}
	else{
		print $data['error'];
	}

}

function assignsub(){

  $this->load->helper(array('form', 'url'));
	$this->load->library('form_validation');
	$this->form_validation->set_rules('subject_id_', 'Please select an Item', 'required');
	
	$questions=explode(',',$this->input->post('selected_questions'));
	//print_r($questions);

	$total=$this->input->post('subtotal');
	$sub=implode(",",$this->input->post('subject_id')); 
	//print $sub;

	foreach($questions as $qs){
		$ins['table']='qBank';
		$ins['where']['qBankid']=$qs;
		$ins['data']['n_subjectid']=$sub;
		$ins['data']['entrydate']=entrydate();
		$ins['data']['status']='assigned';
		//print_r($ins);
		update($ins);
	}

	print " Data Updated: ".dateformat().ready('setTimeout("refreshPage()",1000);');
	
}

function deletequestions(){
	$questions=explode(',',$this->input->post('selected_questions_delete'));
	$delete['table']='qBank';
	$delete['wherein']['qBankid']=$questions;
	$delete['data']['status']='inactive';
	update($delete);  
		
	$msg='';
	foreach($questions as $q){
		$msg.=($msg=='')?"#quest".$q : ",#quest".$q;
	}
	print "Questions deleted
	
	".script()."
	$(document).ready(function(){
		$('".$msg."').hide('slow');
		$('#deleteQuestions' ).popup( 'close' );
	});
	</script>"; 
}

function deldeletequestions(){
	$questions=explode(',',$this->input->post('selected_questions_delete'));
	$delete['table']='qBank';
	$delete['wherein']['qBankid']=$questions;
	delete($delete);  

	$msg='';
	foreach($questions as $q){
		$msg.=($msg=='')?"#quest".$q : ",#quest".$q;
	}
	print "Questions deleted
	".script()."
	$(document).ready(function(){
		$('".$msg."').hide('slow');
		$('#deldeleteQuestions' ).popup( 'close' );
	});
	</script>"; 
}

function upload(){
	$data['title']="Upload Questions";
	$this->load->view("theme/header",$data);
	$this->load->view("addQuestions",$data);
	$this->load->view("theme/footer",$data);
}

function admin(){ 
	$this->form_validation->set_rules('questType', 'Question Type', 'required');
	//$this->form_validation->set_rules('questionEdit', 'Question', 'required');
	$this->form_validation->set_rules('score', 'Score', 'required|integer|max_length[3]');

	if ($this->form_validation->run() == FALSE)
	{
		echo validation_errors(); 
	} 
	else{
		$qid = $this->input->post('qBankid');
		if($qid >0){	
			$option1=trim($this->input->post('opt1')); 
		}
		else{
			$option1=trim($this->input->post('opt12')); 
		}
		//print "Option 1".$option1;
		//  upload an image and document options
    
    $config = array();
    $config['upload_path'] = 'uploads/questions/imageType';
    $config['allowed_types'] = 'jpg|png|gif|jpeg|JPG|PNG|GIF|JPEG|pdf|doc|docx|xls|xlsx';
    $config['max_size'] = '0'; // 0 = no file size limit
    $config['max_width']  = '0';
    $config['max_height']  = '0';
    $config['overwrite'] = TRUE;

		$this->load->library('upload',$config);
    //$this->uploadfile($_FILES['userfile']);
    $files = $_FILES;
    $userfile = empty($_FILES['userfile']['name'])?0:$_FILES['userfile']['name'];
    $cpt = count($userfile);
    // print "Count $cpt";
    for($i=0; $i<$cpt; $i++)
		{   
      $_FILES['userfile']['name']= empty($files['userfile']['name'][$i])?'':$files['userfile']['name'][$i];
      $_FILES['userfile']['type']= empty($files['userfile']['type'][$i])?'':$files['userfile']['type'][$i];
			$_FILES['userfile']['tmp_name']= empty($files['userfile']['tmp_name'][$i])?'':$files['userfile']['tmp_name'][$i];
      $_FILES['userfile']['error']= empty($files['userfile']['error'][$i])?0:$files['userfile']['error'][$i];
      $_FILES['userfile']['size']= empty($files['userfile']['size'][$i])?0:$files['userfile']['size'][$i]; 
			$filename = empty($userfile)?0:$userfile;
      // $this->upload->initialize($this->set_upload_options());
      $this->upload->do_upload();
			$this->upload->data();
    }
    

		/*

		qBankid	questiontype	question	option1	option2	option3	option4	answer	level	score	hint1	hint2	hint3	compulsory	entrydate	status

		*/

		$sublist = $this->input->post('sub');
		$sublist = empty($sublist)?0:$sublist;

		$update['table']='qBank';
		$update['data']['questiontype']=$this->input->post('questType');
		$selectquest=$this->input->post('select-quest');
		if($selectquest == 1){
			$update['data']['question']=trim($this->input->post('questionEdit')); 
			$update['data']['category']='Text'; 
		}
		elseif($selectquest == 2) {
			$update['data']['question']=trim($this->input->post('questionEdit')); 
			$update['data']['image_questions']=empty($filename[0])?0:$filename[0]; 
			$update['data']['imgoption1']=empty($filename[1])?0:$filename[1];
			$update['data']['imgoption2']=empty($filename[2])?0:$filename[2];
			$update['data']['imgoption3']=empty($filename[3])?0:$filename[3];
			$update['data']['imgoption4']=empty($filename[4])?0:$filename[4]; 	
			$update['data']['category']='Image'; 	
		}

		$update['data']['option1']=trim($this->input->post('opt1')); 
		$update['data']['option2']=trim($this->input->post('opt2')); 
		$update['data']['option3']=trim($this->input->post('opt3')); 
		$update['data']['option4']=trim($this->input->post('opt4')); 
		$update['data']['answer']=trim($this->input->post('answer'));
		$update['data']['level']=trim($this->input->post('level')); 
		$update['data']['score']=trim($this->input->post('score')); 
		$update['data']['hint1']=trim($this->input->post('hint1')); 
		$update['data']['hint2']=trim($this->input->post('hint2')); 
		$update['data']['hint3']=trim($this->input->post('hint3')); 
		$update['data']['compulsory']=trim($this->input->post('comp'));  
		
		if($sublist >0){
			$update['data']['n_subjectid']=implode(',',$sublist);  
			$update['data']['status']='assigned'; 
		}
		else{
			$update['data']['n_subjectid']=0;
			$update['data']['status']='open'; 
		}

		//print_r($update['data']['n_subjectid']);
		//print_r(unserialize($update['data']['n_subjectid']));
		$update['data']['entrydate']=entrydate();

		$del['table']='q_subject';
		$del['where']['qBankid']=$this->input->post('qBankid');
		delete($del);

		$s['table']='tbl_subject';
		$s=getrecords($s); 

		foreach($s['result'] as $sub){  
			if($this->input->post('sub_'.$sub['n_subjectid'])!=''){
				$sub['table']='q_subject';
				$sub['data']['qBankid']=$this->input->post('qBankid');
				$sub['data']['subjectid']=$this->input->post('sub_'.$sub['n_subjectid']);
				$sub['data']['entrydate']=entrydate();
				insert($sub);
			}
		}

		if(intval($this->input->post('qBankid')) ==0){

			//print_r($update);

			if(insert($update))
				print " Successfully Updated ".ready('setTimeout(location.reload(), 1000)');
			else
				print " Please try Again ";
		}else{
			$update['where']['qBankid']=$this->input->post('qBankid');
			if(update($update))
				print " Successfully Updated ".ready('setTimeout(location.reload(), 1000)');
			else
				print " Please try Again ";
		}
	}
}

function form($qid){

	$data['title']="Upload Questions";
	$data['qid']=intval($qid);
	
	$this->load->view("theme/header",$data);
	$this->load->view("editQuestions",$data);
	$this->load->view("theme/footer",$data);
}

function imageQuestions($qid){

	$data['title']="Upload Questions";
	$data['qid']=intval($qid);

	$this->load->view("theme/header",$data);
	$this->load->view("imageQuestions",$data);
	$this->load->view("theme/footer",$data);
}

function do_upload(){
	$config['upload_path'] = 'uploads/questions/';
	$config['allowed_types'] = '*';
	$config['encrypt_name']	= TRUE; 

	$this->load->library('upload', $config);
	if ( ! $this->upload->do_upload('excelFile'))
	{ 
		$data = array('error' => $this->upload->display_errors());
	}
	else
	{
		$data = array('success' => $this->upload->data());
	}
	return $data;
}

function importquestions($filename){
	require_once 'Excel/reader.php';

	$data = new Spreadsheet_Excel_Reader();
	$data->setOutputEncoding('CP1251');
	$data->read($filename);	
	for ($x = 2; $x <= count($data->sheets[0]["cells"]); $x++)
	{
		$n_id="";$c_questiontype="";$c_question="";$c_option1="";$c_option2="";$c_option3="";
		$c_option4="";$n_answer="";$c_level="";$c_compulsory="";$n_score="";$hint1="";$hint2="";$hint3="";
		if(isset($data->sheets[0]["cells"][$x][1]))
			$n_id = $data->sheets[0]["cells"][$x][1];
		if(isset($data->sheets[0]["cells"][$x][2]))
			$c_questiontype = $data->sheets[0]["cells"][$x][2];
		if(isset($data->sheets[0]["cells"][$x][3]))
			$c_question = $data->sheets[0]["cells"][$x][3];
		if(isset($data->sheets[0]["cells"][$x][4]))
			$c_option1 = $data->sheets[0]["cells"][$x][4];
		if(isset($data->sheets[0]["cells"][$x][5]))
			$c_option2 = $data->sheets[0]["cells"][$x][5];
		if(isset($data->sheets[0]["cells"][$x][6]))
			$c_option3 = $data->sheets[0]["cells"][$x][6];
		if(isset($data->sheets[0]["cells"][$x][7]))
			$c_option4 = $data->sheets[0]["cells"][$x][7];
		if(isset($data->sheets[0]["cells"][$x][8]))
			$n_answer = $data->sheets[0]["cells"][$x][8];
		if(isset($data->sheets[0]["cells"][$x][9]))
			$c_level = $data->sheets[0]["cells"][$x][9];
		if(isset($data->sheets[0]["cells"][$x][10]))
			$n_score = $data->sheets[0]["cells"][$x][10];	
		if(isset($data->sheets[0]["cells"][$x][11]))
			$hint1 = $data->sheets[0]["cells"][$x][11];
		if(isset($data->sheets[0]["cells"][$x][12]))
			$hint2 = $data->sheets[0]["cells"][$x][12];	
		if(isset($data->sheets[0]["cells"][$x][13]))
			$hint3 = $data->sheets[0]["cells"][$x][13];	
		if(isset($data->sheets[0]["cells"][$x][14]))
			$c_compulsory = $data->sheets[0]["cells"][$x][14];						

		$ques['table']='qBank';
		$ques['data']['questiontype']=$c_questiontype;
		$ques['data']['question']=$c_question;
		$ques['data']['option1']=$c_option1;
		$ques['data']['option2']=$c_option2;
		$ques['data']['option3']=$c_option3;
		$ques['data']['option4']=$c_option4;
		$ques['data']['answer']=$n_answer;
		$ques['data']['level']=$c_level;
		$ques['data']['score']=$n_score;
		$ques['data']['hint1']=$hint1;
		$ques['data']['hint2']=$hint2;
		$ques['data']['hint3']=$hint3;
		$ques['data']['compulsory']=$c_compulsory;
		$ques['data']['n_subjectid']=0; 
		$ques['data']['status']='open'; 
		$ques['data']['entrydate']=entrydate(); 

		insert($ques);
	}
	print ready(' $(".ui-dialog").dialog("close"); refreshPage();');
} // end of importquestions

function delete(){

	$quid=intval($this->input->post('clkid'));
	$del['table']='qBank';
	$del['where']['qBankid']=$quid;
	delete($del);
}

function bank($start=0){

	$data['start'] =intval($start);
	$this->session->set_userdata('q_bank_start',$data['start']);
	$data['menu']='question';
	
	$this->load->helper('text');
	$this->menu="Question Bank";
	$this->title="Question Bank";

	$data['main']['open_question_list']['title']=	"Question Bank";  
	$data['main']['open_question_list']['page']=		$this->load->view("questionBank",$data,TRUE); 

	$this->load->view("theme/header",$data);
	$this->load->view("theme/index",$data);
	$this->load->view("theme/footer",$data);
}

function loadmore($type='open'){

	$this->load->helper('text');
	$list='';
	if ($type!='open'){
		$op['where']['status !=']='open';
	}
	else{
		$op['where']['status']='open';
	}
	$op['table']='qBank';
	$op['start']=$this->session->userdata('q_bank_start')+20;
	$this->session->set_userdata('q_bank_start',$op['start']);
	$op['order']['qBankid']='desc';
	$op =getrecords($op);   

	if(!empty($op['result']))
		foreach($op['result'] as $o){  
			if ($type =='open'){
				$list .= "
				<li  id='quest".$o['qBankid']."' >
					<a href='#'  style='padding-top: 0px;padding-bottom: 0px;padding-right: 42px;padding-left: 0px;'  >
					<label style='border-top-width: 0px;margin-top: 0px;border-bottom-width: 0px;margin-bottom: 0px;border-left-width: 0px;border-right-width: 0px;' data-corners='false'>
					<fieldset data-role='controlgroup'>                                                        
						<input type='checkbox' name='checkbox-2b' id='checkbox_".$o['qBankid']."'  class='openquestions' value='".$o['qBankid']."'  />                   
						<label for='checkbox_".$o['qBankid']."' style='border-top-width: 0px;margin-top: 0px;border-bottom-width: 0px;margin-bottom: 0px;border-left-width: 0px;border-right-width: 0px;'>
							<img src='".base_url('images/question.jpg')."' style='float:left;width:80px;height:80px' />
							<label  style='float:left;padding:2px;'> 
								<h3>".truncate($o['question'],80)."</h3> 
								<p>".$o['questiontype']."</p>
							</label> 
						</label>
					</fieldset> 
					</label>
					</a>
					<a href='".site_url('question/form/'.$o['qBankid'])."'  data-icon='info'  data-rel='dialog' >Edit</a>
				</li>
				";
			}
			else
			{
				$list .= "
				<li  id='quest".$o['qBankid']."' >
				<a href='#'  style='padding-top: 0px;padding-bottom: 0px;padding-right: 42px;padding-left: 0px;'  >
				<label style='border-top-width: 0px;margin-top: 0px;border-bottom-width: 0px;margin-bottom: 0px;border-left-width: 0px;border-right-width: 0px;' data-corners='false'>
				<fieldset data-role='controlgroup'>                                                        
					<input type='checkbox' name='checkbox-2b' id='checkbox_".$o['qBankid']."'  class='openquestions' value='".$o['qBankid']."'  />                   
					<label for='checkbox_".$o['qBankid']."' style='border-top-width: 0px;margin-top: 0px;border-bottom-width: 0px;margin-bottom: 0px;border-left-width: 0px;border-right-width: 0px;'>
						<img src='".base_url('images/question.jpg')."' style='float:left;width:80px;height:80px' />
						<label  style='float:left;padding:2px;'> 
							<h3>".truncate($o['question'],80)."</h3> 
							<p>".$o['questiontype']."</p>
						</label> 
					</label>
				</fieldset> 
				</label>
				</a>
				<a href='".site_url('question/form/'.$o['qBankid'])."'  data-icon='info'  data-rel='dialog' >Edit</a>
				</li>
				";
			}
		}
		print $list;
}

function singleanswer(){
	$singleval=$this->input->post('flag');

	if($singleval==1){
		print "
		<li data-role='fieldcontain' >
		<fieldset data-role='controlgroup' data-mini='true' data-inline='true'> 
		<legend>Answer</legend> 
		";
		$op=array(1=>'A','B','C','D');  
		foreach($op as $i=>$an){ 
			print "	<input type='radio' name='answer' id='answer_".$an."' value='".$i."' ";
			/*if($i == $answer)
			print " checked='checked' ";*/
			print "				/> 			<label for='answer_".$an."'>".$an."</label>"; 
		}
		print"</fieldset> 
		</li>";
	}
	
	else if($singleval==0){
		print "
		<li data-role='fieldcontain' class='singleresult'>
		<fieldset data-role='controlgroup' data-mini='true' data-inline='true'> 
		<legend>Answer</legend> 
		";
		$op=array(1=>'A','B','C','D');  
		foreach($op as $i=>$an){ 
			print "	<input type='checkbox' name='answer' id='answer_".$an."' value='".$i."' ";
			print "	/><label for='answer_".$an."'>".$an."</label>"; 
		} 
		print"</fieldset> 
		</li>";
	}
	
	else if($singleval==2){
	?>					
	<li data-role="fieldcontain" >
		<fieldset data-role="controlgroup" data-mini="true"> 
			<legend>Option A</legend>
			<input type='text' id='opt1' name='opt1'  value='' /> <br><br>
			<legend>Option B</legend>
			<input type='text' id='opt2' name='opt2'  value='' /> <br><br>
			
			<legend>Answer</legend> 
			<div class="singleresult">
			<?php
				$op=array(1=>'A','B');  
				foreach($op as $i=>$an){ 
					print "	<input type='radio' name='answer' id='answer_".$an."' value='".$i."' ";
					/*if($i == $answer)
					print " checked='checked' ";*/
					print "				/> 			<label for='answer_".$an."'>".$an."</label>"; 
				} 
			?>  
			</div>
		</fieldset> 
	</li>
	<?php
	}
}	

function questiontypechange(){
	//$flag = $this->input->post('flag');
	$value = $this->input->post('value');
	
	if(($value == 'multiple choice single answer') || ($value == 'multiple choice multiple answer') || ($value == 'yes / no')){
	?>
		<li data-role="fieldcontain" data-theme="c" class="select-quest">
			<legend>Select Question</legend>
			<select name="select-quest" id="select-quest" data-mini="true">
				<option value="1">Write a Question</option>
				<option value="2">Upload a Question</option>
			</select>
		</li>
		
		<li data-role="fieldcontain" > 
			<legend>Write a Question</legend>
			<textarea id="questionEdit" name="questionEdit"></textarea>
		</li>
	<?php 
	}
	else if($value == 'short text' || ($value == 'file upload')){
	?>
		<li data-role="fieldcontain" > 
			<legend>Write a Question</legend>
			<textarea id="questionEdit" name="questionEdit"></textarea>
		</li>
	<?php	}
	
	//print "Flag".$flag;
	//print "Value".$value;
}

function test_download($file_path = ""){
	
	$this->load->helper('download');
	$data['download_path'] = 	"http://198.1.110.184/~geniuste/gg/onlinelatest/uploads/sample_format.xls";
	$this->load->view("testing_download",$data);
	
}
	
public function _output($output)
{
	if(! $this->session->userdata('userid'))		
	{
		redirect('login', 'refresh');
	}		
	else
		echo $output;
}

function choosetype(){
	$value = $this->input->post('value');
	$type = $this->input->post('questtype');
	if($value==1){
		if($type == 'yes / no'){
			print "<li data-role='fieldcontain' class='shorttext'>
			<fieldset data-role='controlgroup' data-mini='true' > 
			<legend>Option A</legend>
			<input type='text' id='opt1' name='opt1'  value='' /> <br><br>
			<legend>Option B</legend>
			<input type='text' id='opt2' name='opt2'  value='' /><br><br>";
		}
		else{
		
		print "<li data-role='fieldcontain' class='shorttext'>
			<fieldset data-role='controlgroup' data-mini='true' > 
			<legend>Option A</legend>
			<input type='text' id='opt1' name='opt1'  value='' /> <br><br>
			<legend>Option B</legend>
			<input type='text' id='opt2' name='opt2'  value='' /><br><br>
			<legend class='file_type'>Option C</legend>
			<input type='text' id='opt3' name='opt3'  value='' /><br><br>
			<legend class='file_type'>Option D</legend>
			<input type='text' id='opt4' name='opt4'  value='' /><br><br>
			</fieldset>
			</li>
		";
		}
		
	}
	elseif($value == 2){
		if($type == 'yes / no'){
			print "<li data-role='fieldcontain' class='shorttext'>
			<fieldset data-role='controlgroup' data-mini='true' > 
			<legend>Upload a Question</legend>
			<input type='file' multiple='multiple' name='userfile[]' size='20' />
			<br><br>
			<legend>Option A</legend>
			<input type='text' id='opt1' name='opt1'  value='' /> <br><br>
			<input type='file' multiple='multiple' name='userfile[]' size='20' />
			<legend>Option B</legend>
			<input type='text' id='opt2' name='opt2'  value='' /><br><br>
			<input type='file' multiple='multiple' name='userfile[]' size='20'  />";
		}
		else{
			print "<li data-role='fieldcontain' class='shorttext'>
			<fieldset data-role='controlgroup' data-mini='true' > 
			<legend>Upload a Question</legend>
			<input type='file' multiple='multiple' name='userfile[]' size='20' />
			<br><br>
			<legend>Option A</legend>
			<input type='text' id='opt1' name='opt1'  value='' /> <br><br>
			<input type='file' multiple='multiple' name='userfile[]' size='20' />
			<legend>Option B</legend>
			<input type='text' id='opt2' name='opt2'  value='' /><br><br>
			<input type='file' multiple='multiple' name='userfile[]' size='20'  />
			<legend class='file_type'>Option C</legend>
			<input type='text' id='opt3' name='opt3'  value='' /><br><br>
			<input type='file' multiple='multiple' name='userfile[]' size='20' class='file_type'/>
			<legend class='file_type'>Option D</legend>
			<input type='text' id='opt4' name='opt4'  value='' /><br><br>
			<input type='file' multiple='multiple' name='userfile[]' size='20' class='file_type'/>
			</fieldset>
			</li>
			";
		}
	}
	
}

}



/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
