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





					 



/*

$data['main']['openquestion']['right']['text']=	"Open Questions";  

$data['main']['openquestion']['right']['url']=	"question/upload/#open_question_list";  

$data['main']['openquestion']['title']=	"Upload Questions";  

$data['main']['openquestion']['page']=		$this->load->view("addQuestions",$data,TRUE); 

*/





$data['main']['open_question_list']['right']['text']=	"Options";  

$data['main']['open_question_list']['right']['url']=	"#popupMenu"; 

$data['main']['open_question_list']['right']['option']=	" data-rel='popup'  data-inline='true' data-position-to='orgin' "; 

$data['main']['open_question_list']['title']=	"Open Questions";  

$data['main']['open_question_list']['page']=		$this->load->view("openQuestions",$data,TRUE); 

/*



$data['main']['edit_question']['back'] =	"Edit Question";  

$data['main']['edit_question']['title']=	"Edit Question";  

$data['main']['edit_question']['page']=		$this->load->view("editQuestions",$data,TRUE); 

*/ 





$this->load->view("theme/header",$data);

$this->load->view("theme/index",$data);

$this->load->view("theme/footer",$data);

}



function qupload(){

	$data=$this->do_upload(); 

	if(!empty($data['success'])){

		

	$this->importquestions($data['success']['full_path']);

	

	

	}else{

		print $data['error'];

		

	}

}

function assignsub(){
   

$questions=explode(',',$this->input->post('selected_questions'));




$total=$this->input->post('subtotal');

		foreach(range(1,$total) as $q){
	  
			$sub=$this->input->post('subject_id_'.$q); 

					if($sub > 0){
					if(!empty($questions))
							foreach($questions as $qs){
								if($qs<1)
								continue;



							$qb['table']='q_subject';
							$qb['where']['qBankid']=$qs;
							$qb['where']['subjectid']=$sub;
							$exist=getsingle($qb);
									if(empty($exist)){

									$ins['table']=$qb['table'];
									$ins['data']['qBankid']=$qs;
									$ins['data']['subjectid']=$sub;
									$ins['data']['entrydate']=entrydate();
									insert($ins);
									
									
									
									
									$op['table']='qBank';
									$op['where']['qBankid']=$qs;
									$op['data']['status']='assigned';
									update($op);
									
									
									
									
									
									
									
									
									
									

									}


							}
					} 
		
		
		
		
		
		
		
		}
	
	
	
	
	
	
	print " Data Updated: ".dateformat();
	
	 









}


function deletequestions(){
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
			$('#deleteQuestions' ).popup( 'close' );
			});
		
		</script>
		"; 
}




function upload(){

	

$data['title']="Upload Questions";



$this->load->view("theme/header",$data);

$this->load->view("addQuestions",$data);

$this->load->view("theme/footer",$data);

	

}

	function admin(){ 

$this->form_validation->set_rules('questType', 'Question Type', 'required');

$this->form_validation->set_rules('questionEdit', 'Question', 'required');

if ($this->form_validation->run() == FALSE)

{
	
	echo validation_errors(); 
	


} 

else{

 //~ pa($POST);

/*

    (

    [qBankid] => 204

    [questType] => multiple choice single answer

    [questionEdit] => Under the State Children's Health Insurance Program

    [opt1] => states have expanded Medicaid to insure children.

    [opt2] => states have created separate child health programs.

    [opt3] => states can extend health insurance to children whose families do not qualify for Medicaid

    [opt4] => All of the above.

    [answer] => 1

    [answer_Yes] => 1

    [hint1] => 

    [hint2] => 1

    [hint3] => 1

    [sub_1] => 1

    [sub_2] => 2

    [level] => moderate

    [score] => 123

    [submit] => Save

)

*/





 

/*



qBankid	questiontype	question	option1	option2	option3	option4	answer	level	score	hint1	hint2	hint3	compulsory	entrydate	status

*/









$update['table']='qBank';

$update['data']['questiontype']=$this->input->post('questType');

$update['data']['question']=trim($this->input->post('questionEdit')); 

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

$update['data']['n_subjectid']=implode(',',($this->input->post('sub')));  

//print_r($update['data']['n_subjectid']);

//print_r(unserialize($update['data']['n_subjectid']));

$update['data']['status']='assigned'; 

$update['data']['entrydate']=entrydate();


 //~ pa($update);

 







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
//print_r($sub);

}

}























if(intval($this->input->post('qBankid')) ==0){



if(insert($update))




print " Successfully Updated ".ready('setTimeout("refreshPage()",1000);');



else



print " Please try Again ";



}else{



$update['where']['qBankid']=$this->input->post('qBankid');



if(update($update))



print " Successfully Updated ".ready('setTimeout("refreshPage()",1000);');



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



function do_upload()

	{

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


/*

			chmod($data['success']['full_path'], 777);  

*/

 

		}

		

			return $data;

	}

	

	function importquestions($filename)

	{

				require_once 'Excel/reader.php';

				$data = new Spreadsheet_Excel_Reader();

				$data->setOutputEncoding('CP1251');

				$data->read($filename);	

				for ($x = 2; $x <= count($data->sheets[0]["cells"]); $x++)

				{

					$n_id="";$c_questiontype="";$c_question="";$c_option1="";$c_option2="";$c_option3="";

					$c_option4="";$n_answer="";$c_level="";$c_compulsory;$n_score="";

					if($data->sheets[0]["cells"][$x][1])

						$n_id = $data->sheets[0]["cells"][$x][1];

					if($data->sheets[0]["cells"][$x][2])

						$c_questiontype = $data->sheets[0]["cells"][$x][2];

					if($data->sheets[0]["cells"][$x][3])

						$c_question = $data->sheets[0]["cells"][$x][3];

					if($data->sheets[0]["cells"][$x][4])

						$c_option1 = $data->sheets[0]["cells"][$x][4];

					if($data->sheets[0]["cells"][$x][5])

						$c_option2 = $data->sheets[0]["cells"][$x][5];

					if($data->sheets[0]["cells"][$x][6])

						$c_option3 = $data->sheets[0]["cells"][$x][6];

					if($data->sheets[0]["cells"][$x][7])

						$c_option4 = $data->sheets[0]["cells"][$x][7];

					if($data->sheets[0]["cells"][$x][8])

						$n_answer = $data->sheets[0]["cells"][$x][8];

					if($data->sheets[0]["cells"][$x][9])

						$c_level = $data->sheets[0]["cells"][$x][9];

					if($data->sheets[0]["cells"][$x][10])

						$c_compulsory = $data->sheets[0]["cells"][$x][10];						

					if($data->sheets[0]["cells"][$x][11])

						$n_score = $data->sheets[0]["cells"][$x][11];

					$ques['table']='qBank';

					$ques['data']['questiontype']=$c_questiontype;

					$ques['data']['question']=$c_question;

					$ques['data']['option1']=$c_option1;

					$ques['data']['option2']=$c_option2;

					$ques['data']['option3']=$c_option3;

					$ques['data']['option4']=$c_option4;

					$ques['data']['answer']=$n_answer;

					$ques['data']['score']=$n_answer;

					$ques['data']['hint1']=$n_answer;

					$ques['data']['level']=$c_level;

					$ques['data']['compulsory']=$c_compulsory;

					$ques['data']['score']=$n_score; 

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

		

	}else{

		

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
<a href='".site_url('question/form/'.$o['qBankid'])."'  data-icon='info'  data-rel='dialog' >
	Edit
</a>
</li>

";
}
else
{
	$list .= "
	<li id='ques_".$o['qBankid']."'>
				<a href='".site_url('question/form/'.$o['qBankid'])."' data-rel='dialog'   >

				<h3>".format($o['question'])."</h3>
				<p>".$o['questiontype']."</p>
				</a> 
				</li>
				";
}
 





				// <li id='ques_".$o['qBankid']."'>
// 
// 
// 
				// <a href='".site_url('question/form/'.$o['qBankid'])."' data-rel='dialog'   >
// 
// 
// 
				// <h3>".format($o['question'])."</h3>
// 
// 
// 
				// <p>".$o['questiontype']."</p>
// 
// 
// 
				// </a> 
// 
// 
// 
				// </li>
// 
// 
// 
				// ";



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
					</li>
					";
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
					</li>
					";
	}
	
	else if($singleval==2){
?>					
		<li data-role="fieldcontain" >
			<fieldset data-role="controlgroup" data-mini="true"> 
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

	
public function _output($output)
{




if(! $this->session->userdata('userid'))		
{
redirect('login', 'refresh');

}		

else
echo $output;
}
	

	

	

	

	

	

	

	

}



/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
