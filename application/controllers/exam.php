<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');

class Exam extends CI_Controller {

	function __construct() {
		parent::__construct();

		$this->menu = "exam";
	}
	
	public function index() {

		$this->load->view("theme/header", $data);
		$this->load->view("theme/index", $data);
		$this->load->view("theme/footer", $data);
	}

	function designer() {
		// Session variables - role id and user id 
		$roleid = $data['roleid'] = $this->session->userdata('roleid');
		$userid = $data['userid'] = $this->session->userdata('userid');
	
		$this->title = "Designer";
		$this->load->helper('text');

		$this->load->helper('date');
	
		$datestring = "%Y-%m-%d-%h-%i-%a";
		//$datestring = "%Y-%m-%d";
		$time = time();

		$data['today'] = $today = strtotime(date("Y-m-d H:i:s"));  
		
		$data['total_rows'] = $this->common_model->record_count('qdesigner');
	
		$this->load->library('pagination');
		$config['base_url'] = site_url('exam/designer');
	
		$config['per_page'] = 10;
	
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		if($roleid==0){
			$config['total_rows'] = $data['total_rows'];
			$data['results'] = $this->common_model->get_table_records('qdesigner',$config['per_page'],$page,'entrydate','DESC','');
			$data['main']['open_question_list']['right']['text'] = "Create Question Papers";
			$data['main']['open_question_list']['right']['url'] = site_url("exam/form");
			
			
				// for getting country name
		$join = array('tbl_1' => 'tbl_office','p1' => 'offc_id', 'p2' => 'office_id','tbl_2' => 'countries','p3' => 'country', 'p4' => 'cntry_id');
		$groupby = 'countries.country';
		$where = array('status' => 'Active');
		$select = array('countries.country','countries.cntry_id');
		$data['getcountries'] = $getcountries = $this->common_model->get_record_groupby('tbl_staffs',$join,$groupby,$where,'','',$select);
		
					// for getting country name for candidate
			$join = array('tbl_1' => 'countries','p1' => 'country_code', 'p2' => 'ccode');
			$groupby = 'countries.country';
			$where = array('status' => 'Active');
			$select = array('countries.country','countries.cntry_id');
			$data['getcandcountries'] = $this->common_model->get_record_groupby('candidate',$join,$groupby,$where,'','',$select);
			
		}else{
			
			//$getcandcountries = "Select c.country from candidate as a left join countries as c on (a.country_code = c.ccode) where a.status = 'Active' group by c.country asc";
			
			
		
			
	
			$where1 = array('user_id' => $userid, 'start_date <=' => $today, 'end_date >=' => $today,'assigned_users.c_status' => '0', 'assign_status' => 'Active');
			$join1 = array('tbl_1' => 'assigned_users','p1' => 'qDesignerId', 'p2' => 'qid');
			$data['results'] = $this->common_model->get_record_groupby('qdesigner',$join1,'',$where1,$config['per_page'],$page);
			$config['total_rows'] = $data['total_rows'] = count($data['results']);
		}
		$this->pagination->initialize($config);
	
	

		$data['main']['open_question_list']['title'] = "Previous Question Papers";	
		$data['main']['open_question_list']['page'] = $this->load->view("paper_designer_list", $data, TRUE);	

		$this->load->view("theme/header", $data);
		$this->load->view("theme/index", $data);
		$this->load->view("theme/footer", $data);
	}
	
	function req_exam(){
		
		
		$this->load->library('pagination'); // for loading pagination 
		$this->load->helper('date');
		$userid =  $this->session->userdata('userid');
		$datestring = "%Y-%m-%d-%H-%i-%s";
		$time = time();
		$data['today'] = mdate($datestring, $time);
		
		$data['total_rows'] = $this->common_model->record_count('qdesigner');
		
		$config['base_url'] = site_url('exam/req_exam');
		$config['per_page'] = 10;
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		

			$config['total_rows'] = $data['total_rows'];
			//$select = array('qdesigner.title','qdesigner.qDesignerId');
			//$data['results'] = $this->common_model->get_table_records('qdesigner',$config['per_page'],$page,'entrydate','DESC',$select);
			
			$query = $this->db->query("SELECT qdesigner.title,qdesigner.qDesignerId FROM qdesigner WHERE qdesigner.qDesignerId NOT IN (select qid from assigned_users,tbl_staffs where assigned_users.user_id = tbl_staffs.staff_id and tbl_staffs.staff_id=".$userid." and assigned_users.c_status!=3) LIMIT ".$page.",".$config['per_page']);
			
			if($query->num_rows() > 0){
				$data['results'] = $query->result();
				
			}
			
			
			$this->pagination->initialize($config);

		
		$data['main']['req_an_exam']['title'] = "Request An Exam";	
		$data['main']['req_an_exam']['page'] = $this->load->view("requestExam",$data,TRUE);
		
		$this->load->view("theme/header",$data);
		$this->load->view("theme/index",$data);
		$this->load->view("theme/footer",$data);
	}

	function listall() {

		$this->menu = "exam";
		$this->title = "Designer";
		$data['main']['open_question_list']['right']['text'] = "Create Question Papers";
		$data['main']['open_question_list']['right']['url'] = site_url("exam/form");
		$data['main']['open_question_list']['title'] = "Previous Question Papers";
		$data['main']['open_question_list']['page'] = $this->load->view("questionPaperList", $data, TRUE);

		$this->load->view("theme/header", $data);
		$this->load->view("theme/index", $data);
		$this->load->view("theme/footer", $data);
	}

	function form($qid = 0) {

		$data['subjectid'] = intval($qid);
		//print"Tetsdata".$data['subjectid'];
		if (intval($data['subjectid']) > 0)
			$data['bttnText'] = 'Edit';
		else
			$data['bttnText'] = 'Add';
		$this->menu = "exam";
		$this->title = "Designer";
		
		$data['main']['open_question_list']['right']['text'] = "Previous Question Papers";
		$data['main']['open_question_list']['right']['url'] = site_url("exam/designer");
		$data['main']['open_question_list']['title'] = "Question Designer";
		$data['main']['open_question_list']['page'] = $this->load->view("paper_designer", $data, TRUE);

		$this->load->view("theme/header", $data);
		$this->load->view("theme/index", $data);
		$this->load->view("theme/footer", $data);
	}

	function edit() {
		$data['menu'] = 'exam';
		//print_r($_POST);
		///$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('title', 'Title', 'required|alpha_dash|callback_title');
		$this->form_validation->set_rules('mark', 'Minimum Mark', 'required|is_natural_no_zero|max_length[3]');
		//$this->form_validation->set_rules('duration', 'Duration', 'required|is_natural_no_zero');
		$this->form_validation->set_rules('subjectid', 'Subject name', 'required');
		$this->form_validation->set_rules('alerttime', 'Alert time', 'required|is_natural_no_zero');
		$this->form_validation->set_rules('mm_0_count','Multiple answer easy type','integer');
		$this->form_validation->set_rules('mm_1_count','Multiple answer moderate type','integer');
		$this->form_validation->set_rules('mm_2_count','Multiple answer tough type','integer');
		$this->form_validation->set_rules('mm_3_count','Multiple answer mandatory type','integer');
		$this->form_validation->set_rules('ms_0_count','Single answer easy type','integer');
		$this->form_validation->set_rules('ms_1_count','Single answer moderate type','integer');
		$this->form_validation->set_rules('ms_2_count','Single answer tough type','integer');
		$this->form_validation->set_rules('ms_3_count','Single answer mandatory type','integer');
		$this->form_validation->set_rules('yn_0_count','Yes/No easy type','integer');
		$this->form_validation->set_rules('yn_1_count','Yes/No moderate type','integer');
		$this->form_validation->set_rules('yn_2_count','Yes/No tough type','integer');
		$this->form_validation->set_rules('yn_3_count','Yes/No mandatory type','integer');
		$this->form_validation->set_rules('st_0_count','Short text easy type','integer');
		$this->form_validation->set_rules('st_1_count','Short text moderate type','integer');
		$this->form_validation->set_rules('st_2_count','Short text tough type','integer');
		$this->form_validation->set_rules('st_3_count','Short text mandatory type','integer');
		$this->form_validation->set_rules('fu_0_count','File upload easy type','integer');
		$this->form_validation->set_rules('fu_1_count','File upload moderate type','integer');
		$this->form_validation->set_rules('fu_2_count','File upload tough type','integer');
		$this->form_validation->set_rules('fu_3_count','File upload mandatory type','integer');

		if ($this->form_validation->run() == FALSE) {
			echo validation_errors();
		} else {
			//pa($_POST);
			$hour = $this->input->post('hour');	
			$minutes = $this->input->post('minutes');	
			//$duration = $hour + $minutes;

			$data['qid'] = intval($this->input->post('qdesignerid',TRUE));
			$update['table'] = 'qdesigner';
			$update['data']['title'] = $this->input->post('title');
			$update['data']['minMark'] = $this->input->post('mark');
			$update['data']['duration_hour'] = $hour;
			$update['data']['duration_minutes'] = $minutes;
			$update['data']['alertTime'] = ($this->input->post('alerttime'))*60;
			$update['data']['negative'] = $this->input->post('negativemark');
			$update['data']['grading'] = $this->input->post('grading');
			$update['data']['shuffling'] = $this->input->post('shuffling');
			$update['data']['timer'] = $this->input->post('timer');
			$update['data']['productid'] = $this->input->post('productid');
			$update['data']['moduleid'] = $this->input->post('moduleid');
			$update['data']['subjectid'] = $this->input->post('subjectid');
			$update['data']['mocktest']	=	$this->input->post('mocktest');
			$update['data']['markType'] = $this->input->post('radio-choice-2');
			$update['data']['mmEasy'] = $this->input->post('mm_0_count');
			$update['data']['mmModerate'] = $this->input->post('mm_1_count');
			$update['data']['mmTough'] = $this->input->post('mm_2_count');
			$update['data']['mmMandatory'] = $this->input->post('mm_3_count');
			$update['data']['msEasy'] = $this->input->post('ms_0_count');
			$update['data']['msModerate'] = $this->input->post('ms_1_count');
			$update['data']['msTough'] = $this->input->post('ms_2_count');
			$update['data']['msMandatory'] = $this->input->post('ms_3_count');
			$update['data']['tfEasy'] = $this->input->post('yn_0_count');
			$update['data']['tfModerate'] = $this->input->post('yn_1_count');
			$update['data']['tfTough'] = $this->input->post('yn_2_count');
			$update['data']['tfMandatory'] = $this->input->post('yn_3_count');
			$update['data']['desEasy'] = $this->input->post('st_0_count');
			$update['data']['desModerate'] = $this->input->post('st_1_count');
			$update['data']['desTough'] = $this->input->post('st_2_count');
			$update['data']['desMandatory'] = $this->input->post('st_3_count');
			$update['data']['fileEasy'] = $this->input->post('fu_0_count');
			$update['data']['fileModerate'] = $this->input->post('fu_1_count');
			$update['data']['fileTough'] = $this->input->post('fu_2_count');
			$update['data']['fileMandatory'] = $this->input->post('fu_3_count');
			$update['data']['status'] = $this->input->post('status');
			$update['data']['entrydate'] = entrydate();
			if ($data['qid'] > 0) {
				$update['where']['qDesignerId'] = $this->input->post('qdesignerid');
				if (update($update)) {
					print"Data Updated Sucessfully".ready('setTimeout(location.reload(), 1000)');
				}
				else
					print"Error Occured";
			}
			else {
				insert($update);
				print "Data Inserted Successfully".ready('setTimeout(location.reload(), 1000)');;
				//redirect('http://localhost/onlinelatest/trunk/index.php?/exam/designer', 'refresh');
			}
		}
	}

	public function title($str){
	
		$title['table']='qdesigner';
		$title['where']['title']=$str;
	 
		$data['qdesignerid']=intval($this->input->post('qdesignerid')); 
		$title['where']['qdesignerid !=']=$data['qdesignerid'];
	
		$title=getsingle($title);
		//printqq();
		if(!empty($title))
		{
			$title=$title['title'];
			if($str==$title){
				$this->form_validation->set_message('title', $title.' is already exist');
				return FALSE;
			}
			else
			{	
				$this->form_validation->set_message('title',$title.' is available ');
				return TRUE;
			}
		}
	}

	function delete() {
	
		$qdid = intval($this->input->post('clkid'));
		$del['table'] = 'qdesigner';
		$del['where']['qDesignerId'] = $qdid;
		delete($del);
	}

	function candDelete() {

		$cid = intval($this->input->post('clkid'));
		
		$del['table'] = 'candidate';
		$del['where']['candidate_id'] = $cid;
		$del['data']['status'] = 'Inactive';
		update($del);
	}

	function remove() {

		$qdid = intval($this->input->post('clkid'));
		$del['table'] = 'qdesigner';
		$del['where']['qDesignerId'] = $qdid;
		$res = getsingle($del);
		delete($del);

		print $res['title']."  has been Successfully Deleted!!!".ready('setTimeout("refreshPage()",1000);');
	}

	function module() {
		$pid = intval($this->input->post('clkid'));
		$query = $this->db->query("select moduleid,name from module where productid='$pid'");
		if ($query->num_rows() > 0) {
			print "<option value='select'>Select</option>";
			foreach ($query->result() as $row) {
				$moduleid = $row->moduleid;
				$modulename = $row->name;
				print "<option value='" . $moduleid . "'>" . $modulename . " </option>";
			}
		}
	}

	function subject(){
		$mid = intval($this->input->post('clkid'));
		$query=  $this->db->query("select n_subjectid,c_subject from tbl_subject where n_specid='$mid'");
		if($query->num_rows() > 0){
			print "<option value='select'>Select</option>";
			foreach ($query->result() as $row){
				$subjectid=$row->n_subjectid;
				$subjectname=$row->c_subject;
				print"<option value='".$subjectid."'>".$subjectname."</option>";
			}
		}
	}

	function assign($qid=0){
	
		$this->menu = "exam";
		$this->title = "Designer";

		$data['title']=" Assign ";  
		$data['qid'] = intval($qid);
		$this->load->view("theme/header",$data);
		$this->load->view("examAssign",$data);
		$this->load->view("theme/footer",$data);
	}

	function assigneelist($uid=0,$qid=0,$cntry_code,$cntry_name){    
		$this->load->helper('date');
		$this->load->library('pagination');
		//$datestring = "%Y-%m-%d";
		$datestring = "%Y-%m-%d-%H-%i-%s";
		$time = time();
		$data['today'] = mdate($datestring, $time);
    //print_r($_POST);
    $this->menu = "exam";
    $this->title = "Designer";
    $data['title']=" List View ";  
    $data['uid']=intval($uid);
    if($data['uid'] == 1)
			$title = "Employee List";
		else if($data['uid'] == 2)
			$title = "Candidate List";
		
		$data['total_rows'] = $this->common_model->record_count('qdesigner');
		$data['qid'] = intval($qid);
		if($data['uid'] == 1){
		// for getting country name
		$join = array('tbl_1' => 'tbl_office','p1' => 'offc_id', 'p2' => 'office_id','tbl_2' => 'countries','p3' => 'country', 'p4' => 'cntry_id');
		$groupby = 'countries.country';
		$where = array('status' => 'Active');
		$select = array('countries.country','countries.cntry_id');
		$data['getcountries'] = $getcountries = $this->common_model->get_record_groupby('tbl_staffs',$join,$groupby,$where,'','',$select);

		$data['cntry_code'] = $cntry_code;
		$data['cntry_name'] = $cntry_name;
	
		
		// for getting employees count
		$getempcount = "SELECT a.first_name,a.last_name FROM `tbl_staffs` as a join tbl_office as b on a.offc_id = b.office_id join countries as c on b.country = c.cntry_id WHERE b.country=".$cntry_code." and a.status='Active'";
		
		//select a.first_name,a.last_name,a.staff_id,b.assign_status,b.scheduled_date,b.c_status,a.photo from tbl_staffs as a  left join assigned_users as b on (a.staff_id = b.user_id and b.qid= ".$data['qid'].") left join tbl_office as c on (a.offc_id = c.office_id) left join countries as d on (c.country = d.cntry_id) where a.status='Active' and d.country = '".$data['cntry_name']."'";
		$getempcount = $this->db->query($getempcount);
		$data['emp_count'] = $emp_count = $getempcount->num_rows();
		$config['base_url'] = site_url('exam/assigneelist/'.$uid."/".$qid."/".$cntry_code."/".$cntry_name."/");
		$config['total_rows'] = $emp_count;
		$config['per_page'] = 20;
		$config['uri_segment'] = 7;
		$page = ($this->uri->segment(7)) ? $this->uri->segment(7) : 0;
		
		 
		// Getting employees list
		$data['getemp'] = $getemplist = "SELECT a.first_name,a.last_name,a.staff_id,d.assign_status,d.start_date,d.end_date,d.c_status,a.photo FROM tbl_office as b, countries as c, `tbl_staffs` as a left join assigned_users as d on a.staff_id = d.user_id and d.qid=".$data['qid']." WHERE a.offc_id = b.office_id and b.country=".$cntry_code." and b.country = c.cntry_id  and a.status='Active' ORDER BY a.first_name ASC LIMIT ".$page.",".$config['per_page'];
		
		$getemplist = $this->db->query($getemplist);
		$data['getemplist'] = $getemplist->result();
		
		
	
}
		
	else{
		
			// for getting country name
		$join = array('tbl_1' => 'countries','p1' => 'country_code', 'p2' => 'ccode');
		$groupby = 'countries.country';
		$where = array('status' => 'Active');
		$select = array('countries.country','countries.cntry_id');
		$data['getcountries'] = $getcountries = $this->common_model->get_record_groupby('candidate',$join,$groupby,$where,'','',$select);

		$data['cntry_code'] = $cntry_code;
		$data['cntry_name'] = urldecode($cntry_name);
			// for getting employees count
			$getcandcount = "select * from candidate as a  left join assigned_users as b on (a.candidate_id = b.user_id and b.qid= ".$data['qid'].") left join countries as d on (a.country_code = d.ccode) where a.status='Active' and d.country = '".$data['cntry_name']."'";
			$getcandcount = $this->db->query($getcandcount);
			$data['cand_count'] = $cand_count = $getcandcount->num_rows();
		$config['base_url'] = site_url('exam/assigneelist/'.$uid."/".$qid."/".$cntry_code."/".$cntry_name."/");
		$config['total_rows'] = $cand_count;
		$config['per_page'] = 5;
		$config['uri_segment'] = 7;	
		$page = ($this->uri->segment(7)) ? $this->uri->segment(7) : 0;
		
		
		$getcandlist = "SELECT a.first_name,a.last_name,a.candidate_id,d.assign_status,d.start_date,d.end_date,d.c_status FROM countries as c, `candidate` as a left join assigned_users as d on a.candidate_id = d.user_id and d.qid=".$data['qid']." WHERE c.country='".$data['cntry_name']."' and a.status='Active' ORDER BY a.first_name ASC LIMIT ".$page.",".$config['per_page'];
		
		//select * from candidate as a  left join assigned_users as b on (a.candidate_id = b.user_id and b.qid= ".$data['qid'].") left join countries as d on (a.country_code = d.ccode) where a.status='Active' and d.country = '".$data['cntry_name']."' ORDER BY a.first_name ASC LIMIT ".$page.",".$config['per_page'];
		
		$getcandlist = $this->db->query($getcandlist);
		$data['getcandlist'] = $getcandlist->result();
				
		
	}
		
	
		
		
		
		
		
		
		$this->pagination->initialize($config);
		
    //$data['assignid'] = intval($assignid);
    $data['assigneeid']=intval($this->input->post('assigneeid'));
    $data['main']['open_question_list']['back'] = 1;
    $data['main']['open_question_list']['right']['text'] = "Previous Question Papers";
    $data['main']['open_question_list']['right']['url'] = site_url("exam/designer");
    $data['main']['open_question_list']['title'] = $title;
    if($uid == 1)
			$data['main']['open_question_list']['page'] = $this->load->view("assigneelist", $data, TRUE);
    else
			$data['main']['open_question_list']['page'] = $this->load->view("assigneelist_cand", $data, TRUE);

    $this->load->view("theme/header", $data);
    $this->load->view("theme/index", $data);
    $this->load->view("theme/footer", $data);
  }
  
  function mockuptest(){
	
		$this->load->helper('array');
		$mockval = $this->input->post('clkid');
		$b = enum('qBank', 'questiontype');
		$bb = array(
						'mm'=>'multiple choice multiple answer',
						'ms'=>'multiple choice single answer',
						'yon'=>'yes / no'
					);
		?>
		<table width="100%" style="margin-top:20px;float:left; border: 1px solid #4e89c5;">
			<th width="20%"></th>
			<th>Available</th>
			<th>Easy</th>
			<th>Moderate</th>
			<th>Tough</th>
			<th>Mandatory</th>
		<?php
			$type[1]='mm';
			$type[]='ms';
			$type[]='st';
			$type[]='fu';
			$type[]='yn';
              
			$c=0;
			
			if($mockval=='on')
				$b=$bb;
			else
				$b=$b;
		
			foreach ($b as $e) { 
				$c++;
		    print"<tr data-role='listview'>
        <td nowrap='nowrap'>
					<div data-role='fieldcontain' style='width:80px;'>
            <fieldset data-role='controlgroup'>
              <label>";
                print ucfirst(strtolower($e));
              print"</label>
            </fieldset>
          </div>
        </td>";
        if($mockval=='on'){
					$qrty['table'] = 'qBank';
					$qrty['where']['questiontype'] = $e;
					$qrty['where']['questionfor'] ='only for mock test';
					$qrty['limit'] = 10000000;
					$qrty = getrecords($qrty);
					
					$qe['table'] = 'qBank';
					$qe['where']['questiontype'] = $e;
					$qe['where']['questionfor'] ='only for mock test';
					$qe['where']['level'] = 'easy';
					$qe['limit'] = 10000000;
					$qe = getrecords($qe);

					$qm['table'] = 'qBank';
					$qm['where']['questiontype'] = $e;
					$qm['where']['questionfor'] ='only for mock test';
					$qm['where']['level'] = 'moderate';
					$qm['limit'] = 10000000;
					$qm = getrecords($qm);

					$qt['table'] = 'qBank';
					$qt['where']['questiontype'] = $e;
					$qt['where']['questionfor'] ='only for mock test';
					$qt['where']['level'] = 'tough';
					$qt['limit'] = 10000000;
					$qt = getrecords($qt);

					$qma['table'] = 'qBank';
					$qma['where']['questiontype'] = $e;
					$qma['where']['questionfor'] ='only for mock test';
					$qma['where']['level'] = 'mandatory';
					$qma['limit'] = 10000000;
					$qma = getrecords($qma);
				}
				else{
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
				}
        print"<td align='center'>" . count($qrty['result']) . "</td>";
          for ($i = 0; $i < 4; $i++) {
						if(!empty($data['readonly']))
							unset($data['readonly']);
				    $data['id'] = $data['name'] = $type[$c]."_".$i."_count";
            $data['value'] = '';
            if ($i == 0){
              $data['placeholder'] = count($qe['result']);
              if(count($qe['result'])<1)
								$data['readonly']=	"readonly";
            }
            if ($i == 1){
              $data['placeholder'] = count($qm['result']);
              if(count($qm['result'])<1)
								$data['readonly']=	"readonly";
						}
            if ($i == 2){
						  $data['placeholder'] = count($qt['result']);
              if(count($qt['result'])<1)
								$data['readonly']=	"readonly";
            }
            if ($i == 3){
						$data['placeholder'] = count($qma['result']);
            if(count($qma['result'])<1)
							$data['readonly']=	"readonly";
            }
            $data['data-mini'] = 'true';
            $data['style'] = 'width:50%;';
            print '<td align="center">
										' . form_input($data) . ' 
									</td>  
						';
          }
      }
		?>
		</table>
		<?php
	}

  function user_selection($uid=0,$userid=0,$qid=0,$entrydate=0){
	
		$scheduled_day =  $this->input->post('scheduled_day');
		if($scheduled_day < 10)
			$scheduled_day = "0".$scheduled_day;
		$scheduled_month =  $this->input->post('scheduled_month');
		$scheduled_year =  $this->input->post('scheduled_year');
		$scheduled_date = array($scheduled_year,$scheduled_month ,$scheduled_day);
		$scheduled = implode("-", $scheduled_date);
    //print $scheduled;
    $uid=intval($this->input->post('uid'));
    $userid=intval($this->input->post('staff_id'));
    // $userid=intval($this->input->post('clkid'));
    $qid=intval($this->input->post('qid'));
    $entrydate=intval($this->input->post('entrydate'));
        
    // print "UID,QID,Entrydate". $uid. ", ". $qid. ", ".$entrydate.", ".$userid;
    // for getting Question Designer name and User Name
        
    $details['table']='qdesigner';
    $details['where']['qDesignerId']=$qid;
    $details=  getsingle($details);
    //$title=$details['title'];
            
    if($uid==1){
			$user_det['table']='tbl_staffs';
			$user_det['where']['staff_id']=$userid;
			$type = 1;
		}
		else{
			$user_det['table']='candidate';
			$user_det['where']['candidate_id']=$userid;
			$type = 2;
		}
				
		$user_det=  getsingle($user_det);
		$firstname=ucfirst(strtolower($user_det['first_name']));
		$lastname=  ucfirst(strtolower($user_det['last_name']));
		$username=$firstname."&nbsp".$lastname;
					
		$count='0';
		$assign['table']='assigned_users';
		$assign['where']['user_id']=$userid;
		$assign['where']['qid']=$qid;
		$count=  total_rows($assign);
        
    $update['table']='assigned_users';
    if($count>0)
    {
      $assign=  getsingle($assign);
      $status=$assign['assign_status'];
       
      if($status=='Active'){
        $update['where']['user_id']=$userid;
        $update['where']['qid']=$qid;
        $update['data']['assign_status']='Active';
        $update['data']['c_status']=0;
        $update['data']['type']=$type;
        $update['data']['entrydate']=$entrydate;
        $update['data']['scheduled_date']=$scheduled;
        $result = update($update);
        //print "<b>".$username ."</b>&nbsp; has been removed from <b>".$title."</b> exam";
        print "Date Updated".ready('setTimeout("refreshPage()",1000);');
        if($result){
          $flg=0;
          // print $flg;
				}
				else{
					$flg=3;
          //print $flg;
				}
      }
      else{
        $update['where']['user_id']=$userid;
        $update['where']['qid']=$qid;
        $update['data']['assign_status']='Active';
        $update['data']['c_status']=0;
        $update['data']['type']=$type;
        $update['data']['entrydate']=$entrydate;
        $update['data']['scheduled_date']=$scheduled;
        $result = update($update);
        //print "<b>".$username."</b>&nbsp; has been sucessfully added to <b>".$title."</b> exam";
        print "Date Scheduled".ready('setTimeout("refreshPage()",1000);');
        if($result){
          $flg=1;
          //print $flg;
				}
				else{
					$flg=3;
          //print $flg;
				}
      }
    }
    else {
      $update['data']['user_id']=$userid;
      $update['data']['qid']=$qid;
      $update['data']['assign_status']='Active';
      $update['data']['c_status']=0;
      $update['data']['type']=$type;
      $update['data']['entrydate']=$entrydate;
      $update['data']['scheduled_date']=$scheduled;
      $result = insert($update);
      //print "<b>".$username."</b>&nbsp; has been sucessfully added to <b>".$title."</b> exam";
      print "Date Scheduled".ready('setTimeout("refreshPage()",1000);');
      if($result){
        $flg=1;
        //print $flg;
			}
			else{
				$flg=3;
        //print $flg;
			}
    }
        
    /* $this->load->library('email');

		$this->email->from('biju.iitm@gmail.com', 'Biju');
		$this->email->to('biju@geniusadvt.com');

		$this->email->subject('Email Test');
		$this->email->message('sample.');

		$this->email->send();
	
		echo $this->email->print_debugger();*/
  }
    
  function user_remove() {
		//$entrydate=entrydate();
		
		$uid=intval($this->input->post('uid'));
    $staff_id=intval($this->input->post('staff_id'));
    // $userid=intval($this->input->post('clkid'));
    $qid=intval($this->input->post('qid'));
    $entrydate=intval($this->input->post('entrydate'));
		//print $uid.$staff_id.$qid;
		
		if($uid==1){
			$user_det['table']='tbl_staffs';
			$user_det['where']['staff_id']=$staff_id;
			$type = 1;
		}
		else{
			$user_det['table']='candidate';
			$user_det['where']['candidate_id']=$staff_id;
			$type = 2;
		}
				
		$count='0';
		$assign['table']='assigned_users';
		$assign['where']['user_id']=$staff_id;
		$assign['where']['qid']=$qid;
		$count=  total_rows($assign);
       
    $update['table']='assigned_users';
    if($count>0)
    {
      $assign=  getsingle($assign);
      $status=$assign['assign_status'];
      if($status=='Active'){
        $update['where']['user_id']=$staff_id;
        $update['where']['qid']=$qid;
        $update['data']['assign_status']='Inactive';
        $update['data']['type']=$type;
				$update['data']['entrydate']=$entrydate;
                
        // print_r($update);
        //$update['data']['scheduled_date']=$scheduled;
        $result = update($update);
        //print "<b>".$username ."</b>&nbsp; has been removed from <b>".$title."</b> exam";
        //print "Removed".ready('setTimeout("refreshPage()",1000);');	
        //redirect('http://localhost/onlinelatest/trunk/index.php?/exam/assigneelist/'.$uid.'/'.$qid, 'refresh');
               
        if($result){
					//print "Removed".ready('setTimeout("refreshPage()",1000);');	
          $flg=0;
          print $flg;
				}
				else{
					$flg=3;
          print $flg;
				}
      }	
		}
	}  
    
  function test($userid=0,$qid=0){
		
		$testid=$this->input->post('chkvalue');
		$qid=intval($this->input->post('qid'));
			
		//print "Values".$testid.", ".$userid.", ".$qid;
		$returndata=array();
			
		$strArray=explode("&",$testid);
		$i=0;
		foreach($strArray as $item){
			$array = explode("=", $item);
      //$returndata[$i] = $array[0];
      //$i = $i + 1;
      $returndata[$i] = $array[1];
			$i = $i + 1;
		}
		$count=count($returndata);
		//print $count;
		for($i=0;$i<$count;$i++){
			//print $returndata[$i];
			//$update['where']['user_id']=$returndata;
			//printqq($update);
		}
		$userids=serialize($returndata);
		print "Test".$userids;
			
		$update['table']='assigned_users';
		$update['data']['user_id']=$userids;
    $update['data']['qid']=$qid;
    $update['data']['assign_status']='Active';
    //printqq($update);
    //insert($update);
		//$str1=unserialize($str);
		//print_r($str1);
		//print_r($returndata);
		//parse_str($_POST['chkvalue'], $searcharray);
		//print_r($searcharray); 
	}

	function execute($examid=0) {

		$this->title = "Exam Preview";
		$data['examid']=intval($examid);

		//-----------------Exam Executer starts --------------------

		$ques['table']='qdesigner';
		$ques['where']['qdesignerid']=$data['examid'];

		$ques=getsingle($ques); 
		$subject_id = $ques['subjectid'];
	
		$data['ques']=$ques;
		if(!empty($ques)){
			// pa($ques);
			// [qDesignerId] => 4
			// [title] => QuestDesigner
			// [minMark] => 0
			// [duration] => 0
			// [alertTime] => 0
			// [negative] => 0
			// [grading] => 0
			// [shuffling] => 0
			// [timer] => 0
			// [productid] => 4
			// [moduleid] => 1
			// [subjectid] => 1
			// [markType] => 0
			// [msEasy] => 0
			// [msModerate] => 0
			// [msTough] => 0
			// [msMandatory] => 0
			// [mmEasy] => 0
			// [mmModerate] => 0
			// [mmTough] => 0
			// [mmMandatory] => 0
			// [tfEasy] => 0
			// [tfModerate] => 0
			// [tfTough] => 0
			// [tfMandatory] => 0
			// [desEasy] => 0
			// [desModerate] => 0
			// [desTough] => 0
			// [desMandatory] => 0
			// [fileEasy] => 0
			// [fileModerate] => 0
			// [fileTough] => 0
			// [fileMandatory] => 0
			// [status] => 1
			// 'multiple choice multiple answer',
			// 'multiple choice single answer',
			// 'short text',
			// 'file upload',
			// 'yes / no'
		
			$qarray['multiple choice multiple answer']['moderate']=$ques['mmModerate'];
			$qarray['multiple choice multiple answer']['easy']=$ques['mmEasy'];
			$qarray['multiple choice multiple answer']['tough']=$ques['mmTough'];
			$qarray['multiple choice multiple answer']['Mandatory']=$ques['mmMandatory'];
	
			$qarray['multiple choice single answer']['moderate']=$ques['msModerate'];
			$qarray['multiple choice single answer']['easy']=$ques['msEasy'];
			$qarray['multiple choice single answer']['tough']=$ques['msTough'];
			$qarray['multiple choice single answer']['mandatory']=$ques['msMandatory'];

			$qarray['short text']['moderate']=$ques['desModerate'];
			$qarray['short text']['easy']=$ques['desEasy'];
			$qarray['short text']['tough']=$ques['desTough'];
			$qarray['short text']['mandatory']=$ques['desMandatory'];

			$qarray['file upload']['moderate']=$ques['fileModerate'];
			$qarray['file upload']['easy']=$ques['fileEasy'];
			$qarray['file upload']['tough']=$ques['fileTough'];
			$qarray['file upload']['mandatory']=$ques['fileMandatory'];

			$qarray['yes / no']['moderate']=$ques['tfModerate'];
			$qarray['yes / no']['easy']=$ques['tfEasy'];
			$qarray['yes / no']['tough']=$ques['tfTough'];
			$qarray['yes / no']['mandatory']=$ques['tfMandatory'];

			$exist['table']='qexam';
			$exist['where']['qDesignerId']=$data['examid'];
			$exist=getsingle($exist);
			$data['exits']=empty($exits['qDesignerId'])?0:$exits['qDesignerId'];
			if(empty($exist)){
				foreach($qarray as $type=>$mode){
					foreach($mode as $m=>$count){
						$query=" select 	* from qBank	where 
						questiontype='".$type."' and
						level='".$m."' and status='assigned' and 
						find_in_set('".$subject_id."',`n_subjectid`) 
						ORDER BY RAND()
						limit ".$count." "; 
						$query=qry($query);
						$data['type']=$type;
						if(!empty($query['result']))
							foreach($query['result'] as $res){
								$data['questions'][$res['qBankid']]=$res['question']; 
								$questions[]=$res['qBankid'];
							}
					}
				}
				if(! empty($questions)){
					$insert['table']='qexam';
					$insert['data']['equestions']=serialize($questions);
					$insert['data']['entrydate']=entrydate();  
					$insert['data']['qDesignerId']=$data['examid'];
					insert($insert);
					
					// for updating status in exam designer (qDesigner) table
					$update_stat['table']='qdesigner';
					$update_stat['where']['qDesignerId']=$data['examid'];
					$update_stat['data']['status']=2; // 2 denotes this exam is excecuted and ready for assigning
					update($update_stat);
				}
				$data['quest']=serialize($questions);	  
			}

			//-----------------Exam Executer ends --------------------

			$data['main']['open_question_list']['back'] = 1;
			$data['main']['open_question_list']['right']['text'] ='Manage Exam';
			$data['main']['open_question_list']['right']['url'] =site_url('manage/exam/'.$data['examid']);
			$data['main']['open_question_list']['title'] = "Examination Preview";
			$data['main']['open_question_list']['page'] = $this->load->view("exam_execute", $data, TRUE);
		}else{ 
			$data['main']['error']['back'] = 1;
			$data['main']['error']['title'] = "error";
			$data['main']['error']['page'] = $this->load->view("error", $data, TRUE);
		}
		$this->load->view("theme/header", $data);
		$this->load->view("theme/index", $data);
		$this->load->view("theme/footer", $data);
	}

	function attend(){

		$this->menu = "exam";
		$this->title = "Designer";
		$data['title']=" List View ";   

		$query=" select * from qBank order by RAND() limit 50 ";
		$data['questions']=qry($query);

		$q=0;
		if(!empty($data['questions']['result'])){
			foreach($data['questions']['result'] as $ques){
				$q++;

				// $data['main']['open_question_list']['right']['text'] = "Previous Question Papers";
				// $data['main']['open_question_list']['right']['url'] = site_url("exam/designer");
	
				$data['question'] = $ques; 
				$data['main'][$q]['title'] = "Question ".$q;
				$data['main'][$q]['footermenu'] = '

				<div data-role="navbar">
					<ul>
						<li><a href="'.site_url("exam/attend/#2").'">Previous</a></li>
						<li><a href="#2">Next</a></li>
					</ul>
				</div>
				';
				$data['main'][$q]['page'] = $this->load->view("questions", $data, TRUE);
			}
			$data['title']="Upload Questions";
			$data['qid']=intval($qid);
			$this->load->view("theme/header",$data);
			$this->load->view("editQuestions",$data);
			$this->load->view("theme/footer",$data);
		}

		$this->load->view("theme/header", $data);
		$this->load->view("theme/index", $data);
		$this->load->view("theme/footer", $data);
	}

	function qvalue(){
		$qvalueid=intval($this->input->post('clkid'));
		echo $qvalueid;
	}

	// For getting values from new candidate registration page

	function newcandidate($cid=0){
	
		$this->load->library('email');
	
		$config['mailtype'] = 'html';
		$config['newline'] = '\r\n';
		$config['wordwrap'] = TRUE;
	
		$this->email->initialize($config);
	
		$cid=intval($this->input->post('cid'));
	
		$this->form_validation->set_rules('user', 'Username', 'required|min_length[6]|callback_username_check');
		//$this->form_validation->set_rules('user', 'User name', 'required');
		$this->form_validation->set_rules('pass','Password','required|min_length[6]');
		$this->form_validation->set_rules('firstname','First name','required');
		$this->form_validation->set_rules('lastname','Last name','required');
		$this->form_validation->set_rules('email','Email id','required|valid_email|callback_email_check');
		if ($this->form_validation->run() == FALSE)
		{
			echo validation_errors(); 
		} 
		else{
			$entrydate=entrydate();
			//print"EntryDate".dateformat($entrydate);
			
			$update['table']='candidate';
			$update['data']['first_name']=$this->input->post('firstname');
			$update['data']['last_name']=$this->input->post('lastname');
			$update['data']['username']=$this->input->post('user');
			$update['data']['password']=$this->input->post('pass');
			$update['data']['email']=$this->input->post('email');
			$update['data']['entrydate']=$entrydate;
			$update['data']['country_code']=$this->input->post('country_code');
			$update['data']['status']='Active';
	
			$name = ucfirst($this->input->post('firstname'))." ".ucfirst($this->input->post('lastname'));
			$toemail = $this->input->post('email');
			//
			$msg = "<b>Dear ".$name."</b> , \r\n
			Thank you for enrolling with genius group. <a href='http://198.1.110.184/~geniuste/gg/onlinelatest/index.php/login'>Click here</a> to login to your examination section with the following username and password. \r\n 
			<b> Username : </b>".$this->input->post('user')." \r\n
			<b>Password : </b>".$this->input->post('pass');
	
			if($cid > 0){
				$update['where']['candidate_id']=$cid;
				if(update($update)){
					print "Data updated successfully".ready('setTimeout("refreshPage()",1000);');
				}
				else
					print "Error Occured!!!";
			}
			else{
				insert($update);
				print "Data inserted successfully".ready('setTimeout("refreshPage()",1000);');

				$this->email->from('info@geniusadvt.com', 'Genius Group');
				$this->email->to($toemail);
				//$this->email->cc('biju@geniusadvt.com');
				//$this->email->bcc('them@their-example.com');
	
				$this->email->subject('Login Details');
				$this->email->message($msg);
				$this->email->send();
				//echo $this->email->print_debugger();
			}
		}
	}

	function username_check($str){
	
		$candidate['table']='candidate';
		$candidate['where']['username']=$str;
		
		$data['cid']=intval($this->input->post('cid')); 
		$candidate['where']['candidate_id !=']=$data['cid'];
	
		$candidate=getsingle($candidate);
		if(!empty($candidate))
		{
			$username=$candidate['username'];
			if($str==$username){
				$this->form_validation->set_message('username_check', $username.' is already exist');
				return FALSE;
			}
			else
			{	
				$this->form_validation->set_message('username_check',$str.' is available ');
				return TRUE;
			}
		}
	}

	function email_check($str){
		$candidate['table']='candidate';
		$candidate['where']['email']=$str;
	
		$data['cid']=intval($this->input->post('cid')); 
		$candidate['where']['candidate_id !=']=$data['cid'];
		$candidate=getsingle($candidate);
		if(!empty($candidate))
		{
			$email=$candidate['email'];
			if($str==$email){
				$this->form_validation->set_message('email_check', $email.' is already exist');
				return FALSE;
			}
			else
			{	
				$this->form_validation->set_message('email_check',$str.' is available ');
				return TRUE;
			}
		}
	}

	function editcandidate($cid){
	
		$data['cid']=intval($cid);
		$this->load->view("theme/header",$data);
		$this->load->view("editCandidate",$data);
		$this->load->view("theme/footer",$data);

	}

	function testfunction(){
		$data['uid'] = "Hi, This is a test value";
		$this->load->view("theme/header",$data);
		$this->load->view("testpage",$data);
		$this->load->view("theme/footer",$data);
	
		$country['table'] = 'country';
		$country = getrecords($country);
		printqq($country);
	
		//$cand['table'] = 'candidate';
		//$cand['join'][''];
	
	}

	function rowcount($arg1,$arg2,$arg3){
		$qs =22;
	
		/*$qs = $this->db->query("SELECT COUNT(*) as abc FROM `qBank` WHERE `questiontype`='".$arg1."' and `level`='".$arg2."' and find_in_set('".$arg1."',`n_subjectid`);");
			
			 foreach ($qs->result() as $row)
			   {
					 $test  = $row->abc;
				 }*/
				 
		return $qs;
	}
	
	function sub_selection(){
		$b = enum('qBank', 'questiontype');
		$subjid = $this->input->post('clkid');
		$type[1]='mm';
		$type[]='ms';
		$type[]='st';
		$type[]='fu';
		$type[]='yn';
		
		$typename[]="Easy";
		$typename[]="Moderate";
		$typename[]="Tough";
		$typename[]="Mandatory";
	
		$c=0;
		foreach($b as $e){
			$c++;
			$qrty = $this->db->query("SELECT COUNT(*) as abc FROM `qBank` WHERE `questiontype`='".$e."'  and find_in_set('".$subjid."',`n_subjectid`);");
			foreach ($qrty->result() as $row)
			{
				$test0  = $row->abc;
			}
			$qs = $this->db->query("SELECT COUNT(*) as abc FROM `qBank` WHERE `questiontype`='".$e."' and `level`='easy' and find_in_set('".$subjid."',`n_subjectid`);");
			
			foreach ($qs->result() as $row)
			{
				$test  = $row->abc;
			}
			$qm = $this->db->query("SELECT COUNT(*) as abc FROM `qBank` WHERE `questiontype`='".$e."' and `level`='moderate' and find_in_set('".$subjid."',`n_subjectid`);");
			
			foreach ($qm->result() as $row)
			{
				$test1  = $row->abc;
			}
			$qt = $this->db->query("SELECT COUNT(*) as abc FROM `qBank` WHERE `questiontype`='".$e."' and `level`='tough' and find_in_set('".$subjid."',`n_subjectid`);");
			
			foreach ($qt->result() as $row)
			{
				$test2  = $row->abc;
			}
			$qma = $this->db->query("SELECT COUNT(*) as abc FROM `qBank` WHERE `questiontype`='".$e."' and `level`='mandatory' and find_in_set('".$subjid."',`n_subjectid`);");
			
			foreach ($qma->result() as $row)
			{
				$test3  = $row->abc;
			}
				 
			//rowcount($e,$subjid,$typename);
			
			for ($i = 0; $i < 4; $i++) {
				$data['id'][] = $data['name'] = $type[$c]."_".$i."_count";
				//$data['value'][] = $val[$type[$c]][$i]; 
				if ($i == 0){
					$data['placeholder'][] = $test;
				}
				if ($i == 1){
					$data['placeholder'][] = $test1;
				}
				if ($i == 1){
					$data['placeholder'][] = $test2;
				}
				if ($i == 1){
					$data['placeholder'][] = $test3;
				}
			}
      $data['placeval']['count'][] = $test0;
      $data['placeval']['placeholder']=$data['placeholder'];
      //print_r($data['count']);
      if($c == '5')
      {
			  print json_encode($data['placeval']);  
      }
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

	function start_exam_time($qid=0,$userid=0,$roleid=0,$currdate=""){
		$qid=intval($this->input->post('qid'));
		$userid=intval($this->input->post('userid'));
		$roleid=intval($this->input->post('roleid'));
		$currdate=$this->input->post('currdate');
		//print "Hi".$qid.",Userid:".$userid.",Roleid".$roleid."Current Date".$currdate;
		$count = 0;
		$exam_time['table'] = 'exam_time_log';
		$exam_time['where']['userid'] = $userid;
		$exam_time['where']['typeid'] = $roleid;
		$exam_time['where']['qdesignerid'] = $qid;
		$count=  total_rows($exam_time);
           
		$exam_time['table']='exam_time_log';
  
		if($count>0)
		{
			$exam_time['data']['start_time'] = $currdate;
			update($exam_time);
			//print_r($exam_time);
			print "Data updated successfully";
		}
		else{
			$exam_time['data']['userid'] = $userid;
			$exam_time['data']['typeid'] = $roleid;
			$exam_time['data']['qdesignerid'] = $qid;
			$exam_time['data']['start_time'] = $currdate;
			//print_r($exam_time);
			insert($exam_time);
			print "Data inserted successfully";
		}
	}
	
	function loadmore(){
	
	$countryname = $this->input->post('countryname');
	$qid = $this->input->post('qid');
	
	$start=$this->session->userdata('q_emp_start')+20;
	$this->session->set_userdata('q_emp_start',$start);
	$limit = 20;
	$getemplist = "select a.staff_id, a.first_name,a.last_name,a.staff_id,a.photo from tbl_staffs as a  left join tbl_office as c on (a.offc_id = c.office_id) left join countries as d on (c.country = d.cntry_id) where d.country = '".$countryname."' ORDER BY a.staff_id DESC LIMIT ".$start.",".$limit;
		$getemplist = $this->db->query($getemplist);
		$getemplist = $getemplist->result();
		
	$op['table']='tbl_staffs';

	$op['order']['first_name']='ASC';
	$op =getrecords($op);  
	
	 
	$list='';
	if(!empty($getemplist))
		foreach($getemplist as $o){  
				$str = ucfirst(strtolower($o->first_name)) . "&nbsp;" . ucfirst(strtolower($o->last_name));
				/*$list .= "<fieldset data-role='controlgroup'>
					  <label><input name='checkbox".$o['staff_id']."' id='checkbox".$o['staff_id']."' value=".$o['staff_id']."  class='empnames' type='checkbox'>".$str."</label>
						</fieldset>";*/
					$img_url = 'http://198.1.110.184/~geniuste/gg/'.$o->photo;
						//$img_url = '';
						$img = empty($o->photo)? base_url('images/cands.jpg') : $img_url;		
				$list .= "
				<li  id='emp".$o->staff_id."' >
					<a href='#'  style='padding-top: 0px;padding-bottom: 0px;padding-right: 42px;padding-left: 0px;'  >
					<label style='border-top-width: 0px;margin-top: 0px;border-bottom-width: 0px;margin-bottom: 0px;border-left-width: 0px;border-right-width: 0px;' data-corners='false'>
					<fieldset data-role='controlgroup'>                                                        
						<input type='checkbox' name='checkbox-2b' id='checkbox_".$o->staff_id."'  class='empnames' value='".$o->staff_id."'  />                   
						<label for='checkbox_".$o->staff_id."' style='border-top-width: 0px;margin-top: 0px;border-bottom-width: 0px;margin-bottom: 0px;border-left-width: 0px;border-right-width: 0px;'>
							<img src='".$img."' style='float:left;width:80px;height:80px' />
							<label  style='float:left;padding:2px;'> 
								<h3>".$str."</h3>
							</label> 
						</label>
					</fieldset> 
					</label>
					</a>
				</li>
				";

		
		}
		print $list;
	}
	
	
		function loadmorecand(){
		
	$op['table']='candidate';
	$op['start']=$this->session->userdata('q_cand_start')+20;
	$this->session->set_userdata('q_cand_start',$op['start']);
	$op['order']['first_name']='ASC';
	$op =getrecords($op);   
	$list='';
	if(!empty($op['result']))
		foreach($op['result'] as $o){  
				$str = ucfirst(strtolower($o['first_name'])) . "&nbsp;" . ucfirst(strtolower($o['last_name']));
				/*$list .= "<fieldset data-role='controlgroup'>
					  <label><input name='checkbox".$o['staff_id']."' id='checkbox".$o['staff_id']."' value=".$o['staff_id']."  class='empnames' type='checkbox'>".$str."</label>
						</fieldset>";*/
					
						//$img_url = '';
						$img = base_url('images/cands.jpg');		
				$list .= "
				<li  id='emp".$o['candidate_id']."' >
					<a href='#'  style='padding-top: 0px;padding-bottom: 0px;padding-right: 42px;padding-left: 0px;'  >
					<label style='border-top-width: 0px;margin-top: 0px;border-bottom-width: 0px;margin-bottom: 0px;border-left-width: 0px;border-right-width: 0px;' data-corners='false'>
					<fieldset data-role='controlgroup'>                                                        
						<input type='checkbox' name='checkbox-2b' id='checkbox_".$o['candidate_id']."'  class='empnames' value='".$o['candidate_id']."'  />                   
						<label for='checkbox_".$o['candidate_id']."' style='border-top-width: 0px;margin-top: 0px;border-bottom-width: 0px;margin-bottom: 0px;border-left-width: 0px;border-right-width: 0px;'>
							<img src='".$img."' style='float:left;width:80px;height:80px' />
							<label  style='float:left;padding:2px;'> 
								<h3>".$str."</h3>
							</label> 
						</label>
					</fieldset> 
					</label>
					</a>
				</li>
				";

		
		}
		print $list;
	}
	
	function assignemp(){

  $this->load->helper(array('form', 'url'));
	$this->load->library('form_validation');
	//$this->form_validation->set_rules('subject_id_', 'Please select an Item', 'required');
	
	
	$empids=explode(',',$this->input->post('selected_emp'));
	$fromdatetime= $this->input->post('from_year')."-".$this->input->post('from_month')."-".$this->input->post('from_day')." ".$this->input->post('from_hour').":".$this->input->post('from_minute').":".$this->input->post('fromsec');
	$todatetime= $this->input->post('to_year')."-".$this->input->post('to_month')."-".$this->input->post('to_day')." ".$this->input->post('to_hour').":".$this->input->post('to_minute').":".$this->input->post('tosec');
	$examid = $this->input->post('qid');
	$type = $this->input->post('uid');
	$request = $this->input->post('request');
	$request = empty($request)?'':$request;
	$entrydate=entrydate();
	$start_date = entrydate($fromdatetime);
	$end_date = entrydate($todatetime);
	//print_r($questions);
	
	if($fromdatetime == $todatetime){
		print "<p style='color:red'><b>Both date and time are same. Please change it !!!</b></p>";
	}
	else{
	foreach($empids as $emp){
		$ins['table']='assigned_users';
		$ins['where']['user_id']=$emp;
		$ins['where']['qid']=$examid;
		$count = total_rows($ins);
		
		$getqid['table'] = 'qdesigner';
		$getqid['where']['qDesignerId'] = $examid;
		$getqid = getsingle($getqid);
		$title = $getqid['title'];
		
		/* $ins['data']['n_subjectid']=$sub;
		$ins['data']['entrydate']=entrydate();
		$ins['data']['status']='assigned';
		//print_r($ins);
		update($ins);*/
		$update['table'] = 'assigned_users';
		if($count >0){
			$update['where']['user_id']=$emp;
      $update['where']['qid']=$examid;
      $update['data']['assign_status']='Active';
      if($request == 3){
      $update['data']['c_status']=3;
			}
			else{
      $update['data']['c_status']=0;
			}
      $update['data']['type']=$type;
      $update['data']['entrydate']=$entrydate;
      $update['data']['start_date']=$start_date;
      $update['data']['end_date']=$end_date;
      $result = update($update);
    
      //print "Date Updated".ready('setTimeout("refreshPage()",1000);');
			
		}
		else{
			$update['data']['user_id']=$emp;
      $update['data']['qid']=$examid;
      $update['data']['assign_status']='Active';
      if($request == 3){
      $update['data']['c_status']=3;
			}
			else{
      $update['data']['c_status']=0;
			}
      $update['data']['type']=$type;
      $update['data']['entrydate']=$entrydate;
      $update['data']['start_date']=$start_date;
      $update['data']['end_date']=$end_date;
      $result = insert($update);
      //print "Sucessfully added to <b>".$title."</b> exam";
      //print "Date Scheduled".ready('setTimeout("refreshPage()",1000);');
		}
	}
	
	if($count >0){
		 print "Users have been successfully reschedule for the <b>".$title."</b> exam";
	}
	else{
		  print "Users have been successfully scheduled for the <b>".$title."</b> exam";
	}
}
	//print "From Date".entrydate($fromdatetime);
	//print "To Date".entrydate($todatetime);
	//print "Exam Id".$examid;
	

	
	//print_r($empids);
	//print " Data Updated: ".dateformat().ready('setTimeout(location.reload(),1000);');
	
	}
	
	
	
	
	
	
	
	
	
		function assigncand(){

  $this->load->helper(array('form', 'url'));
	$this->load->library('form_validation');
	//$this->form_validation->set_rules('subject_id_', 'Please select an Item', 'required');
	
	$candids=explode(',',$this->input->post('selected_cand'));
	$fromdatetime= $this->input->post('from_year')."-".$this->input->post('from_month')."-".$this->input->post('from_day')." ".$this->input->post('from_hour').":".$this->input->post('from_minute').":".$this->input->post('fromsec');
	$todatetime= $this->input->post('to_year')."-".$this->input->post('to_month')."-".$this->input->post('to_day')." ".$this->input->post('to_hour').":".$this->input->post('to_minute').":".$this->input->post('tosec');
	$examid = $this->input->post('qid');
	$type = $this->input->post('uid');
	$entrydate=entrydate();
	$start_date = entrydate($fromdatetime);
	$end_date = entrydate($todatetime);
	//print_r($questions);

	//$total=$this->input->post('subtotal');
	//$sub=implode(",",$this->input->post('subject_id')); 
	//print $sub;
	if($fromdatetime == $todatetime){
		print "<p style='color:red'><b>Both date and time are same. Please change it !!!</b></p>";
	}
	else{
	foreach($candids as $cand){
		$ins['table']='assigned_users';
		$ins['where']['user_id']=$cand;
		$ins['where']['qid']=$examid;
		$count=  total_rows($ins);
		
		$getqid['table'] = 'qdesigner';
		$getqid['where']['qDesignerId'] = $examid;
		$getqid = getsingle($getqid);
		$title = $getqid['title'];
		
		/* $ins['data']['n_subjectid']=$sub;
		$ins['data']['entrydate']=entrydate();
		$ins['data']['status']='assigned';
		//print_r($ins);
		update($ins);*/
		$update['table'] = 'assigned_users';
		if($count >0){
			$update['where']['user_id']=$cand;
      $update['where']['qid']=$examid;
      $update['data']['assign_status']='Active';
      $update['data']['c_status']=0;
      $update['data']['type']=$type;
      $update['data']['entrydate']=$entrydate;
      $update['data']['start_date']=$start_date;
      $update['data']['end_date']=$end_date;
      $result = update($update);
      //print "<b>".$username ."</b>&nbsp; has been removed from <b>".$title."</b> exam";
      //print "Date Updated".ready('setTimeout("refreshPage()",1000);');
			
		}
		else{
			$update['data']['user_id']=$cand;
      $update['data']['qid']=$examid;
      $update['data']['assign_status']='Active';
      $update['data']['c_status']=0;
      $update['data']['type']=$type;
      $update['data']['entrydate']=$entrydate;
      $update['data']['start_date']=$start_date;
      $update['data']['end_date']=$end_date;
      print_r($update);
      $result = insert($update);
      //print "<b>".$username."</b>&nbsp; has been sucessfully added to <b>".$title."</b> exam";
      //print "Date Scheduled".ready('setTimeout("refreshPage()",1000);');
		}
	}
	
	if($count >0){
		 print "Users have been successfully reschedule for the <b>".$title."</b> exam";
	}
	else{
		  print "Users have been successfully scheduled for the <b>".$title."</b> exam";
	}
}
	
	//print "From Date".entrydate($fromdatetime);
	//print "To Date".entrydate($todatetime);
	//print "Exam Id".$examid;
	

	
	//print_r($empids);
	//print " Data Updated: ".dateformat().ready('setTimeout(location.reload(),1000);');
	
	}
	
	
	function scroll_emp(){
	
	$list ="";
		if($_POST)
	{
		//sanitize post value
		$group_number = filter_var($_POST["group_no"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
		$cntry_code = $this->input->post('countrycode');
		$qid = $this->input->post('qid');

	//throw HTTP error if group number is not valid
	if(!is_numeric($group_number)){
		header('HTTP/1.1 500 Invalid number!');
		exit();
	}
	$items_per_group = 5;
	//get current starting point of records
	$position = ($group_number * $items_per_group);
	
	//Limit our results within a specified range. 
	$getemplist = "SELECT a.first_name,a.last_name,a.staff_id,d.assign_status,d.start_date,d.end_date,d.c_status,a.photo FROM tbl_office as b, countries as c, `tbl_staffs` as a left join assigned_users as d on a.staff_id = d.user_id and d.qid=".$qid." WHERE a.offc_id = b.office_id and b.country=".$cntry_code." and b.country = c.cntry_id  and a.status='Active' ORDER BY a.first_name ASC LIMIT ".$position.",".$items_per_group;

	$getemplist = $this->db->query($getemplist);
	$result = $getemplist->result();
	$check = "check"; 
	if(!empty($result))  
		//output results from database
		
		foreach($result as $obj)
		{
			$start_date = empty($row->start_date)?'':dateformat($row->start_date,'d/m/Y H:i a');
			$end_date = empty($row->end_date)?'':dateformat($row->end_date,'d/m/Y H:i a');
						
			$scheduled_date = empty($start_date)?"":"Exam scheduled from <strong>".$start_date. "</strong> to <strong>".$end_date."</strong>";
					
			$assign_status=$row->assign_status;
				
			if($assign_status == 'Active')
				$status_val='Exam Scheduled';
			else
				$status_val='';
				
			$str = ucfirst(strtolower($obj->first_name)) . "&nbsp;" . ucfirst(strtolower($obj->last_name));
			
				$img_url = 'http://198.1.110.184/~geniuste/gg/'.$obj->photo;

						$img = empty($obj->photo)? base_url('images/cands.jpg') : $img_url;		
				$list .= "
				<li  id='emp".$obj->staff_id."' >
					<a href='javascript:void(0);'  style='padding-top: 0px;padding-bottom: 0px;padding-right: 42px;padding-left: 0px;'  >
					<label style='border-top-width: 0px;margin-top: 0px;border-bottom-width: 0px;margin-bottom: 0px;border-left-width: 0px;border-right-width: 0px;' data-corners='false'>
					<fieldset data-role='controlgroup'>                                                        
						<input type='checkbox' name='checkbox-2b[]' id='checkbox_".$obj->staff_id."' onclick=\"select_staff('".$obj->staff_id."','".$check."')\" value='".$obj->staff_id."'  />                   
						<label for='checkbox_".$obj->staff_id."' style='border-top-width: 0px;margin-top: 0px;border-bottom-width: 0px;margin-bottom: 0px;border-left-width: 0px;border-right-width: 0px;'>
							<img src='".$img."' style='float:left;width:80px;height:80px' />
							<label  style='float:left;padding:2px;'> 
								<h3>".$str."</h3>
								<p>".$scheduled_date."</p>
							</label> 
							<p class='ui-li-aside'><strong>".$status_val."</strong></p>
						</label>
					</fieldset> 
					</label>
					</a>
				</li>
				";
		}
		
		print $list;
	
	
	unset($obj);
	}
	
}


function scroll_cand(){
	
	$list ="";
		if($_POST)
	{
		//sanitize post value
		$group_number = filter_var($_POST["group_no"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
		$countryname = $this->input->post('countryname');
		$qid = $this->input->post('qid');

	//throw HTTP error if group number is not valid
	if(!is_numeric($group_number)){
		header('HTTP/1.1 500 Invalid number!');
		exit();
	}
	$items_per_group_cand = 5;
	//get current starting point of records
	$position = ($group_number * $items_per_group_cand);
	
	//Limit our results within a specified range. 
	$getcandlist = "SELECT a.first_name,a.last_name,a.candidate_id,d.assign_status,d.start_date,d.end_date,d.c_status FROM countries as c, `candidate` as a left join assigned_users as d on a.candidate_id = d.user_id and d.qid=".$qid." WHERE c.country='".$countryname."' and a.status='Active' ORDER BY a.first_name ASC LIMIT ".$position.",".$items_per_group_cand;
	
	
	//select * from candidate as a  left join assigned_users as b on a.candidate_id = b.user_id and b.qid= ".$qid." left join countries as d on a.country_code = d.ccode where a.status='Active' and d.country = '".$countryname."' ORDER BY a.first_name ASC LIMIT ".$position.",".$items_per_group_cand;
	
	//select a.candidate_id, a.first_name,a.last_name from candidate as a left join countries as d on (a.country_code = d.ccode) where a.status='Active' and d.country = '".$countryname."' ORDER BY a.first_name ASC LIMIT ".$position.",".$items_per_group_cand;
	
	$getcandlist = $this->db->query($getcandlist);
	$result = $getcandlist->result();

	if(!empty($result))  
		//output results from database
		
		foreach($result as $obj)
		{
			
			$start_date = empty($obj->start_date)?'':dateformat($obj->start_date,'d/m/Y H:i a');
			$end_date = empty($obj->end_date)?'':dateformat($obj->end_date,'d/m/Y H:i a');
						
			$scheduled_date = empty($start_date)?"":"Exam scheduled from <strong>".$start_date. "</strong> to <strong>".$end_date."</strong>";
					
			$assign_status=$obj->assign_status;
				
			if($assign_status == 'Active')
				$status_val='Exam Scheduled';
			else
				$status_val='';
			
			$str = ucfirst(strtolower($obj->first_name)) . "&nbsp;" . ucfirst(strtolower($obj->last_name));
			$img =  base_url('images/cands.jpg');		
				$list .= "
						<li  id='cand".$obj->candidate_id."' >
							<a href='#'  style='padding-top: 0px;padding-bottom: 0px;padding-right: 42px;padding-left: 0px;'  >
								<label style='border-top-width: 0px;margin-top: 0px;border-bottom-width: 0px;margin-bottom: 0px;border-left-width: 0px;border-right-width: 0px;' data-corners='false'>
									<fieldset data-role='controlgroup'>                                                        
										<input type='checkbox' onclick='select_cand(".$obj->candidate_id.")' class='candnames' name='checkbox-2b[]' id='checkbox_".$obj->candidate_id."' value='".$obj->candidate_id."'/>                   
										<label for='checkbox-2b' style='border-top-width: 0px;margin-top: 0px;border-bottom-width: 0px;margin-bottom: 0px;border-left-width: 0px;border-right-width: 0px;'>
											<img src='".$img."' style='float:left;width:80px;height:80px'/>
											<label  style='float:left;padding:10px 0px 0px 10px;'> 
												<h3>".$str."</h3> 
												<p>".$scheduled_date."</p>
											</label> 
											<p class='ui-li-aside'><strong>".$status_val."</strong></p>
										</label>
									</fieldset> 
								</label>
							</a><a href='".site_url('exam/editcandidate/'.$obj->candidate_id). "'  data-icon='grid'  data-rel='dialog'>Edit Candidate</a>
						</li>";								
		}
		print $list;
	unset($obj);
	}
	
}


	

	
}  // End of exam class

/* End of file exam.php */
/* Location: ./application/controllers/exam.php */
