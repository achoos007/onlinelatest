<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Scorecard extends CI_Controller {
	
	function __construct() {
		parent::__construct();
	}
	
	public function index(){
		$this->test();
	}
	
	function save_scorecard(){
		$this->menu="result";
		$this->title="question";
	
		$this->load->library('email');  // Inbuilt library for email functionality

		// Getting posted values
		$data['totalquest'] = $this->input->post('totalquest');
		$data['answered'] = $this->input->post('answered');
		$data['wronganswer'] = $this->input->post('wronganswer');
		$data['notanswered'] = $this->input->post('notanswered');
		$data['marks_obtained'] = $this->input->post('marks_obtained');
		$data['totalmarks'] = $this->input->post('totalmarks');
		$data['percentage'] = $this->input->post('percentage');
		$data['result'] = $this->input->post('result');
		$data['grade'] = $this->input->post('grade');
		$data['user_id'] = $this->input->post('user_id');
		$data['typeid'] = $this->input->post('type');
		$data['examid'] = $this->input->post('examid');
	
		// for getting exam name 
	
		$getexamname['table'] = 'qdesigner';
		$getexamname['where']['qDesignerId'] = $data['examid'];
		$getexamname = getsingle($getexamname);
		$title = ucfirst($getexamname['title']);
	
		// for checking whether the data is exists or not
	
		$getcount['table']	= 'scorecard';
		$getcount['where']['user_id']	= $data['user_id'];
		$getcount['where']['examid']	= $data['examid'];
		$getcount['where']['typeid']	= $data['typeid'];
		$data['count'] = total_rows($getcount);
	
	
		// for getting users email id
	
		if($data['typeid'] == 1){
			$getemail['table'] = 'tbl_staffs';
			$getemail['where']['staff_id'] = $data['user_id'];
		}
		elseif($data['typeid'] == 2){
			$getemail['table'] = 'candidate';	
			$getemail['where']['candidate_id'] = $data['user_id'];
		}
		$getemail = getsingle($getemail);
	
	if($data['typeid'] == 1){
	$data['emailid'] = $getemail['office_email'];
	}
	else{
		$data['emailid'] = $getemail['email'];
	}
	
	$msg = $title." result published and it is available in your dash board. Please visit the following link to see your result.";
	
	// Getting Email from, to 
	$this->email->from('exam@geniusgroup.ae', 'Genius University');
	$this->email->to($data['emailid']);
	
	$this->email->subject('Score Card');
	$this->email->message($msg);
	
	// to insert or update score card
	
	$toscorecard['table'] = 'scorecard';
	
	$toscorecard['data']['totalquest'] = $data['totalquest'];
	$toscorecard['data']['correctanswer'] = $data['answered'];
	$toscorecard['data']['wronganswer'] = $data['wronganswer'];
	$toscorecard['data']['unanswered'] = $data['notanswered'];
	$toscorecard['data']['marks_obtained'] = $data['marks_obtained'];
	$toscorecard['data']['totalmark'] = $data['totalmarks'];
	$toscorecard['data']['percentage'] = $data['percentage'];
	$toscorecard['data']['result'] = $data['result'];
	$toscorecard['data']['grade'] = $data['grade'];
	
	
	
	if($data['count'] > 0){
		
		$toscorecard['where']['user_id'] = $data['user_id'];
		$toscorecard['where']['examid'] = $data['examid'];
		$toscorecard['where']['typeid'] = $data['typeid'];
		if(update($toscorecard)){
			$data['stat'] = 1;
			print "Successfully Updated";
			
		}
		else{
			print "Try Again!!!";
		}
	}
	else{
		
		$toscorecard['data']['user_id'] = $data['user_id'];
		$toscorecard['data']['typeid'] = $data['typeid'];
		$toscorecard['data']['examid'] = $data['examid'];
		
		insert($toscorecard);
		$data['stat'] = 2;
		print "data inserted successfully";
		
	}
	if(($data['stat'] == 1) || ($data['stat'] == 2)){
	//$this->email->send();
	//$this->email->print_debugger();
	$data['sc'] = $toscorecard;
	}


	$data['main']['validate']['title']=	"Validate Exam";
	$data['main']['validate']['page']  =	$this->load->view("saveScore",$data,TRUE); 

	$this->load->view("theme/header",$data);
	$this->load->view("theme/index",$data);
	$this->load->view("theme/footer",$data);

	}
}


