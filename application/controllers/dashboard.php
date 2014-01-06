<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function index()
	{
		$this->menu="home";
		$this->title="home";
	
		if(! $this->session->userdata('userid'))		
		{
			redirect('login', 'refresh');
	  }			
		$data['menu']='home';

		$this->menu="home";
		$this->title="home";


		// Get exams
		
		$getexams = $this->db->query("select count(*) as total, sum(case when c_status='0' then 1 else 0 end) scheduled_exam,sum(case when c_status='1' then 1 else 0 end) completed_exam from assigned_users where scheduled_date != ''");
		foreach($getexams->result() as $row){
			$data['total_exams'] = $row->total;
			$data['scheduled_exams'] = $row->scheduled_exam;
			$data['completed_exams'] = $row->completed_exam;
		}

		// Get Candidate count
		$getcandidate  = $this->db->query("select count(*) as total, sum(case when status='Active' then 1 else 0 end) active_cand, sum(case when status = 'Inactive' then 1 else 0 end) inactive_cand from candidate");
		foreach($getcandidate->result() as $row){
			$data['total_cand'] = $row->total;
			$data['active_cand'] = $row->active_cand;
			$data['inactive_cand'] = $row->inactive_cand;
		}

		// Get employees count

		$getemployees  = $this->db->query("select count(*) as total, sum(case when status='Active' then 1 else 0 end) active_staffs, sum(case when status = 'Resigned' then 1 else 0 end) resigned_staffs, sum(case when status = 'Vacation' then 1 else 0 end) vacation_staffs, sum(case when status = 'Closed' then 1 else 0 end) closed_staffs, sum(case when status is null then 1 else 0 end) null_staffs from tbl_staffs");
		foreach($getemployees->result() as $row){
			$data['total_staffs'] = $row->total;
			$data['active_staffs'] = $row->active_staffs;
			$data['inactive_staffs'] = ($row->resigned_staffs)+($row->vacation_staffs)+($row->closed_staffs)+($row->null_staffs);
		}
		
		// Get question details
		
		$getquestions = $this->db->query("select count(*) as total, sum(case when status='open' then 1 else 0 end) open_quest, sum(case when status='assigned' then 1 else 0 end) assigned_quest, sum(case when status='inactive' then 1 else 0 end) inactive_quest from qBank");
		foreach($getquestions->result() as $row){
			$data['total_quest'] = $row->total;
			$data['open_quest'] = $row->open_quest;
			$data['assigned_quest'] = $row->assigned_quest;
			$data['inactive_quest'] = $row->inactive_quest;
		}
		
		// Get Top Result from Candidate
		
		$gettopresultcand = $this->db->query("select * from scorecard as a, candidate as b, qdesigner as c where a.typeid=2 and a.user_id=b.candidate_id and a.examid=c.qDesignerId order by a.percentage DESC LIMIT 0,3");
		$data['gettopresultcand'] = $gettopresultcand;
	
		
		$gettopresultemp = $this->db->query("select * from scorecard as a, tbl_staffs as b, qdesigner as c where a.typeid=1 and a.user_id=b.staff_id and a.examid=c.qDesignerId order by a.percentage DESC LIMIT 0,3");
		$data['gettopresultemp'] = $gettopresultemp;
		
		
		$data['main']['dashboard']['title']=	"Dashboard"; 
		$data['main']['dashboard']['page']=		$this->load->view("dashboard",$data,TRUE); 

		$this->load->view("theme/header",$data);
		$this->load->view("theme/index",$data);
		$this->load->view("theme/footer",$data);

	}
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
