<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage extends CI_Controller {
	
	  // public function __construct()
       // {
				 	// $this->menu="question";
// 
// $this->title="question";
// 
	// }

	
 
	public function index()
	{
	
	
		$this->exam();
	

	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	function validate(){
		

// ---------------------------------------------------------------------
$this->menu="result";
$this->title="question";
			
// ---------------------------------------------------------------------
$data['main']['validate']['title']=	"Validate Exam";
$data['main']['validate']['page']  =	$this->load->view("exam_validate",$data,TRUE); 

// ---------------------------------------------------------------------


$this->load->view("theme/header",$data);

$this->load->view("theme/index",$data);

$this->load->view("theme/footer",$data);

	}
	
function exam($examid=0,$mocktype="off") {
$data['examid']=intval($examid);
$data['mocktype']=$mocktype;
// ---------------------------------------------------------------------
$this->menu="result";
$this->title="question";
// ---------------------------------------------------------------------
$exist['table']='qexam';
$exist['where']['qDesignerId']=$examid;
$exist=getsingle($exist);
if(!empty($exist['equestions'])){
$qu=unserialize($exist['equestions']);
$questcount=count($qu);
$data['qucount']=$questcount;
$i=0;
foreach( $qu as $d){
$i++;


$data['question']=$d;
$data['qid']=$d;
$data['id']=$i;
$data['date']=date("H:i:s");










$data['main']['question-'.$i]['title']=	"Exam";
$data['main']['question-'.$i]['page']  =	$this->load->view("question_dashboard",$data,TRUE);
 
}
}
else{
$data['main']['error']['title']=	"Exam";
$data['main']['error']['page']  =	$this->load->view("error",$data,TRUE); 
}
// ---------------------------------------------------------------------
$this->load->view("theme/header",$data);
$this->load->view("theme/index",$data);
$this->load->view("theme/footer",$data);
}
function answerexam(){

	$userid = $this->session->userdata('userid');
	$usertype = $this->session->userdata('usertype');
	
	$qid=intval($this->input->post('qid'));
	//$data['qid'] = intval($this->input->post('qid',TRUE));
	$clickid=$this->input->post('clkid');
	$status=$this->input->post('status');
	$flag=intval($this->input->post('flag'));
	$examid=intval($this->input->post('examid'));
	
	$ansexam['table']='examanswer';
	$ansexam['where']['qBankid']=$qid;
	$ansexam['where']['qDesignerId']=$examid;
	$ansexam['where']['userid']=$userid;
	$count=total_rows($ansexam);

print $userid;
print "Count".$count;

	$update['table'] = 'examanswer';
	$update['data']['qBankid'] = $qid;
	$update['data']['qDesignerId'] = $examid;
	$update['data']['userid'] = $userid;
	$update['data']['usertype'] = $usertype;
	$update['data']['entrydate'] = entrydate();
	
 
	
	if($flag=='1'){
		/*if($clickid=='a')
			$ans['data']['answer']['answer1'] = $this->input->post('clkid');
		elseif($clickid=='b')
			$ans['data']['answer']['answer2'] = $this->input->post('clkid');
		elseif($clickid=='c')	
			$ans['data']['answer']['answer3'] = $this->input->post('clkid');
		elseif($clickid=='d')
			$ans['data']['answer']['answer4'] = $this->input->post('clkid');*/
		
		$update['data']['answer']=lock(serialize($this->input->post('clkid')));
}
	elseif($flag=='2'){
	$update['data']['answer'] = lock(serialize($this->input->post('clkid')));
	
}
	elseif($flag=='3'){
	$update['data']['answer'] = lock(serialize($this->input->post('clkid')));
	
}
	elseif($flag=='5'){
	$update['data']['answer'] = lock(serialize($this->input->post('clkid')));
	
}

	if ($count > 0) {
		$update['where']['qBankid'] = $qid;
		$update['where']['qDesignerId']= $examid;
		$update['where']['userid']= $userid;
		$test= update($update);
		//print "test".$test;
		print_r($update);
		if (update($update)) {
			print"Data Updated Sucessfully";
		}
		else
			print"Error Occured";
	}
	else {
		insert($update);
			print "Data Inserted Successfully";
	}
	
}

function answer_delete(){
	
	$qid=intval($this->input->post('qid'));
	$clickid=$this->input->post('clkid');
	$status=$this->input->post('status');
	
	$ansexam['table']='test';
	$ansexam['where']['qBankid']=$qid;
	$count=total_rows($ansexam);

	
	//echo"Hellooooooooooo".$count;

	$update['table'] = 'examanswer';
	$update['data']['qBankid'] = $qid;
	
	/*if($clickid=='a' && $status=='false')
		$update['data']['option1'] ='';
	elseif($clickid=='b' && $status=='false')
		$update['data']['option2'] ='';
	elseif($clickid=='c' && $status=='false')
		$update['data']['option3'] ='';
	elseif($clickid=='d' && $status=='false')
		$update['data']['option4'] ='';*/
		$update['data']['answer']=lock(serialize($this->input->post('clkid')));
		
	if ($count > 0) {
		$update['where']['qBankid'] = $qid;
		if (update($update)) {
			print"Data Updated Sucessfully";
		}
		else
			print"Error Occured";
	}
}

function timer(){
	$today=date("H:i:s");
	//print "Today date".$today;
}

function message_dialog($examid=0){
	
$data['examid']=intval($examid);

$data['title']='Confirm Page';

$getexam['table'] = 'qdesigner';
$getexam['where']['qDesignerId'] = $examid;
$getexam=getsingle($getexam);

$data['q_title'] = $getexam['title'];
	
$this->load->view("theme/header",$data);

$this->load->view("successpage",$data);

$this->load->view("theme/footer",$data);
	
}

function finish_exam(){
	$examid=$this->input->post('clickid');
	$userid=$this->input->post('userid');
	$status=1;
	
	$update['table'] = 'assigned_users';
	$update['where']['user_id'] = $userid;
	$update['where']['qid'] = $examid;
	$update['data']['c_status'] = $status;
	
	if (update($update)) {
			print"You have successfully finished your exam!!! Result will be published soon.";
		}
	else
			print"Error Occured";
	
}

}

/* End of file exam.php */
/* Location: ./application/controllers/exam.php */
