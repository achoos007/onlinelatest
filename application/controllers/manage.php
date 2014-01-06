<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
	}
 
	public function index()
	{
		$this->exam();
	}
	
	function validate(){

	// ---------------------------------------------------------------------
		$this->menu="result";
		$this->title="question";
		
	// for using pagination

		$this->load->library('pagination');

		$data['total_candcount'] = $this->common_model->cand_record_count();
					
		$config["base_url"] = site_url('manage/validate');
		$config["total_rows"] = $data['total_candcount'];
		$config["per_page"] = 20;
		$config["uri_segment"] = 3;
		$config['cur_tag_open'] = '<b>';
		$config['cur_tag_close'] = '</b>';
		//$config['use_page_numbers'] = TRUE;

		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
	
		$data['results'] = $this->common_model->get_assigned_cand($config["per_page"],$page);
	
	// ---------------------------------------------------------------------
		$data['main']['validate']['title']=	"Exam Summary";
		$data['main']['validate']['right']['text']=	"Reports";  
		$data['main']['validate']['right']['url']=	site_url("manage/report"); 
	
		$data['main']['validate']['page']  =	$this->load->view("exam_validate",$data,TRUE); 

	// ---------------------------------------------------------------------

		$this->load->view("theme/header",$data);

		$this->load->view("theme/index",$data);
		
		$this->load->view("theme/footer",$data);

	}
	
	function report(){
		$this->menu = "result";
		$this->title = "Report";

		$getreports['table'] = 'scorecard';
		$getreports['join']['candidate'] = 'scorecard.user_id = candidate.candidate_id';
		$getreports['join']['qdesigner'] = 'scorecard.examid = qdesigner.qDesignerId';
		$getreports['order']['grade']='ASC';
		$data['getreports'] = getrecords($getreports);
	
		$data['result_name'] = $this->common_model->get_record_groupby('candidate','scorecard','candidate_id','user_id','user_id');
		$data['result_exam'] = $this->common_model->get_record_groupby('qdesigner','scorecard','qDesignerId','examid','examid');
		$data['result'] = $this->common_model->get_record_groupby('scorecard','','','','result');
		$data['grade'] = $this->common_model->get_record_groupby('scorecard','','','','grade');
		$data['percentage'] = $this->common_model->get_record_groupby('scorecard','','','','percentage');

		$data['main']['report']['right']['text'] = "Exam Summary";
		$data['main']['report']['right']['url'] = site_url("manage/validate");
		$data['main']['report']['title']=	"Detailed Report";		
		$data['main']['report']['page'] = $this->load->view("report", $data, TRUE);
	
		$this->load->view("theme/header", $data);
		$this->load->view("theme/index", $data);
		$this->load->view("theme/footer", $data);
	}
	
	public function get_report_search(){
		$value = $this->input->post('value');
		$id = $this->input->post('id');
		$get_result = $this->common_model->get_record_where('scorecard',$id,$value);
	
		foreach($get_result as $row){
			$user_id = $row->user_id;
			$examid = $row->examid;
				
			$get_result_cand['table']='candidate';
			$get_result_cand['where']['candidate_id']=$user_id;
			$get_result_cand = getsingle($get_result_cand);
				
			$get_result_sub['table'] = 'qdesigner';
			$get_result_sub['where']['qDesignerId'] = $examid;
			$get_result_sub = getsingle($get_result_sub);

			print "<tr>";
			print "<th>".$row->grade."</th>";
      print "<td><a href='#' data-rel='external'>".$get_result_cand['first_name']."</a></td>";
      print "<td>".$get_result_sub['title']."</td>";
      print "<td>".$row->percentage."</td>";
      print "<td>".$row->result."</td>";
      print "<td>".$row->correctanswer."</td>";
      print "<td>".$row->wronganswer."</td>";
      print "<td>".$row->marks_obtained."/".$row->totalmark."</td>";
			print "</tr>";

		}
	}
	
	public function export_report(){
		$result = $this->input->post('result');
		$examid = $this->input->post('examid');
		$user_id = $this->input->post('user_id');
		$grade = $this->input->post('grade');
		$percentage = $this->input->post('percentage');
		//print "Success".$result.",".$examid.",".$user_id.",".$grade.",".$percentage;
		
		if($result != ''){
			$where = "and a.result = '".$result."'";
		}
		else if($examid != ''){
			$where = "and examid = ".$examid;
		}
		else if($user_id != ''){
			$where = "and user_id = ".$user_id;
		}else if($grade != ''){
			$where = "and grade = ".$grade;
		}else if($percentage != ''){
			$where = "and percentage = ".$percentage;
		}
		else{
			$where = " and 1";
		}
		
		
		$query = "SELECT a.id, a.grade,b.first_name,c.title,a.percentage,a.result,a.correctanswer,a.wronganswer,a.marks_obtained FROM scorecard as a, candidate as b, qdesigner as c where a.user_id = b.candidate_id and a.examid = c.qDesignerId ".$where;
		
		//load our new PHPExcel library
		$this->load->library('excel');
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);


		/** Query 1.0 */
		//
	
    if ($result = mysql_query($query) or die(mysql_error())) {
		/** Create a new PHPExcel object 1.0 */
		//name the worksheet
			$this->excel->getActiveSheet()->setTitle('Report Summary');
		}  
		$this->excel->getActiveSheet()->setCellValue('A1','Id');
		$this->excel->getActiveSheet()->setCellValue('B1','Rank');
		$this->excel->getActiveSheet()->setCellValue('C1','Name');
		$this->excel->getActiveSheet()->setCellValue('D1','Exam');
		$this->excel->getActiveSheet()->setCellValue('E1','Percentage');
		$this->excel->getActiveSheet()->setCellValue('F1','Result');
		$this->excel->getActiveSheet()->setCellValue('G1','Correct Answer');
		$this->excel->getActiveSheet()->setCellValue('H1','Wrong Answer');
		$this->excel->getActiveSheet()->setCellValue('I1','Marks Scored');
		
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('I1')->getFont()->setBold(true);
		/** Loop through the result set 1.0 */
    $rowNumber = 2; //start in cell 1
    while ($row = mysql_fetch_row($result)) {
      $col = 'A'; // start at column A
      foreach($row as $cell) {
				$this->excel->getActiveSheet()->setCellValue($col.$rowNumber,$cell);
        $col++;
      }
    $rowNumber++;
		}
		//set cell A1 content with some text
		//$this->excel->getActiveSheet()->setCellValue('A1', 'This is just some text value');
		//change the font size
		//$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		//make the font become bold
		///$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		//merge cell A1 until D1
		//$this->excel->getActiveSheet()->mergeCells('A1:D1');
		//set aligment to center for that merged cell (A1 to D1)
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 
		$filename='Detailed Report.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
             
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
	}
	
	function exam($examid=0,$mocktype="off",$date=0,$user_id=0,$type=0) {
	
		$this->load->helper('text');
		$data['examid']=intval($examid);
		$data['mocktype']=$mocktype;
		$data['user_id']=intval($user_id);
		$data['type']=intval($type);
	
	// ---------------------------------------------------------------------
		
		$this->menu="result";
		$this->title="question";
	
	// for getting time duration 

		$get_duration['table'] = 'qdesigner';
		$get_duration['where']['qDesignerId'] = $examid;
		$get_duration = getsingle($get_duration);
		$data['duration_hour']=$get_duration['duration_hour'];
		$data['duration_minutes']=$get_duration['duration_minutes'];
		$data['negative']=$get_duration['negative'];
		$data['title']=ucfirst($get_duration['title']);

		$data['attended_user'] = $this->session->userdata('attended_user');

	// ---------------------------------------------------------------------
		$exist['table']='qexam';
		$exist['where']['qDesignerId']=$examid;
		$exist=getsingle($exist);
		if(!empty($exist['equestions'])){
			$qu=unserialize($exist['equestions']);
			$questcount=count($qu);
			$data['qucount']=$questcount;
			$i=0;

			$data['qids'] = $qu;

			$this->load->library('exampagination');

			foreach( $qu as $d){
				$i++;
				$userid = $this->session->userdata('userid');
				$roleid = $this->session->userdata('roleid');
				$data['question']=$d;
				$data['qid']=$d;
				$data['id']=$i;
				$data['date']=$date;
				$data['examid'] = $examid;

	// for getting the answerd question which needs to display at admin side
				$ansexam['table']='examanswer';
				$ansexam['where']['qBankid']=$data['qid'];
				$ansexam['where']['qDesignerId']=$data['examid'];
				$ansexam['where']['userid']=$user_id; //$user_id is the exam attended user id not admin ID
	
				$ansexam = getsingle($ansexam);
	
				$data['qryy']=array();
				$data['qry'] ="select * from examanswer where qBankid=".$data['qid']." and qDesignerId=".$data['examid']." and userid=".$userid;
				$query11=  $this->db->query("select count(*) as cnt from examanswer where qBankid=".$data['qid']." and qDesignerId=".$data['examid']." and userid=".$user_id);
				foreach ($query11->result() as $row) {
					$data['count_one'] = $row->cnt;
				}
	
				if($query11){$data['qryy']='haii';}
				//$count = count($ansexam['result']);
				//$count=total_rows($ansexam);
	
				if($data['count_one'] > 0){
					$data['ans'] = $ansexam['answer'];
					$data['marks_obt'] = $ansexam['marks_obtained'];
				}

				if($roleid == 0)
				{
	// for getting mark of all questions

					$correctanswer = "count(if(marks_obtained != 0, marks_obtained, NULL)) as answered";
					$wronganswer = "count(if(marks_obtained = 0, marks_obtained, NULL)) as wronganswer";
			
					$query=  $this->db->query("select sum(marks_obtained) as total_marks, sum(original_score) as total_score,".$correctanswer.",".$wronganswer.", typeid from examanswer where qDesignerId=".$data['examid']." and userid=".$user_id);
					foreach ($query->result() as $row) {
						$data['total_marks'] = $row->total_marks;
						$data['total_score'] = $row->total_score;
						$data['answered'] = $row->answered;
						$data['wronganswer'] = $row->wronganswer;
						$data['typeid'] = $row->typeid;
					}
	
	// for getting exam attended user name
	
					if($data['typeid'] == 1){
						$getusername['table'] = 'tbl_staffs';
						$getusername['where']['staff_id'] = $data['user_id'];
						$getusername = getsingle($getusername);
					}
					elseif($data['typeid'] == 2){
						$getusername['table'] = 'candidate';	
						$getusername['where']['candidate_id'] = $data['user_id'];
						$getusername = getsingle($getusername);
					}
					$data['name'] = ucfirst($getusername['first_name'])." ".ucfirst($getusername['last_name']);
					$data['name'] = empty($data['name'])?0:$data['name'];
					$data['main']['question-'.$i]['title']=	"Review Exam - ".$data['title'];
				}			
				else{
					$data['main']['question-'.$i]['title']=	"Exam - ".$data['title'];
				}
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
		function __construct()
		{
			parent::__construct();
			$this->load->helper(array('form', 'url'));
		}
		$userid = $this->session->userdata('userid');
		$usertype = $this->session->userdata('usertype');
	
		$qid=intval($this->input->post('qid'));
		//$data['qid'] = intval($this->input->post('qid',TRUE));
		$clickid=$this->input->post('clkid');
		$stmark=$this->input->post('stmark');
	
		$status=$this->input->post('status');
		$flag=intval($this->input->post('flag'));
		$examid=intval($this->input->post('examid'));
		$roleid=intval($this->input->post('roleid'));
	
		$ansexam['table']='examanswer';
		$ansexam['where']['qBankid']=$qid;
		$ansexam['where']['qDesignerId']=$examid;
		$ansexam['where']['userid']=$userid;
		$count=total_rows($ansexam);

		//print $userid;
		//print "Count".$count;
		//print"RoleId".$roleid;

		$update['table'] = 'examanswer';
		$update['data']['qBankid'] = $qid;
		$update['data']['qDesignerId'] = $examid;
		$update['data']['userid'] = $userid;
		$update['data']['typeid'] = $roleid;
		$update['data']['entrydate'] = entrydate();

	// for getting the correct answer

		$getanswer['table'] = 'qBank';
		$getanswer['where']['qBankid'] = $qid;
		$getanswer = getsingle($getanswer);
	
		$correct_answer = $getanswer['answer'];
		$score = $getanswer['score'];
	
		$update['data']['original_score'] = $score;
		//print "Correct Answer".$correct_answer;
	
		if($clickid == $correct_answer){
			$update['data']['marks_obtained'] = $score;
		}
		else{
			$update['data']['marks_obtained'] = 0;
		}
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
		elseif($flag=='4'){
			function __construct()
			{
				parent::__construct();
				$this->load->helper(array('form', 'url'));
			}
			//$update['data']['answer'] = lock(serialize($this->input->post('clkid')));
			/*$config['upload_path'] = '/var/www/uploads/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']	= '100';
			$config['max_width']  = '1024';
			$config['max_height']  = '768';

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload())
			{
				$error = array('error' => $this->upload->display_errors());
	
				//$this->load->view('upload_form', $error);
				print"Error";
			}
			else
			{
				$data = array('upload_data' => $this->upload->data());

				$this->load->view('upload_success', $data);
				print"Success page";
			}*/
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

	function st_mark(){
		$user_id = $this->input->post('user_id');
		$qid=intval($this->input->post('qid'));
		$stmark=$this->input->post('stmark');
		$examid=intval($this->input->post('examid'));

		$ansexam['table']='examanswer';
		$ansexam['where']['qBankid']=$qid;
		$ansexam['where']['qDesignerId']=$examid;
		$ansexam['where']['userid']=$user_id;
		$count=total_rows($ansexam);
	
		$update['table'] = 'examanswer';
		$update['data']['marks_obtained'] = $stmark;
	
		if ($count > 0) {
			$update['where']['qBankid'] = $qid;
			$update['where']['qDesignerId'] = $examid;
			$update['where']['userid'] = $user_id;
			$test= update($update);
			//print "test".$test;
			if (update($update)) {
				print"Data Updated Sucessfully";
			}
			else
				print"Error Occured";
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

	function do_upload()
	{
		$userid = $this->session->userdata('userid');
		$qid=intval($this->input->post('qid'));
		$examid=intval($this->input->post('examid'));
		$roleid=intval($this->input->post('roleid'));
		$flag=intval($this->input->post('flag4'));
		//$this->image_lib->initialize($config); 

		$ansexam['table']='examanswer';
		$ansexam['where']['qBankid']=$qid;
		$ansexam['where']['qDesignerId']=$examid;
		$ansexam['where']['userid']=$userid;
		$count=total_rows($ansexam);

		$config['image_library'] = 'gd2';
		$config['upload_path'] = 'uploads/answers';
		$config['allowed_types'] = 'csv|doc|pdf|txt|jpg';
		//$config['max_size']	= '1000';
		//$config['max_width']  = '1024';
		//$config['max_height']  = '768';

		//$data['file_name'] = $_FILES['userfile']['name'];
		$filename = empty($_FILES['userfile']['name'])?"":$_FILES['userfile']['name'];
		
		$this->load->library('upload', $config);
		
		//	$this->form_validation->set_rules('userfile', 'Userfile', 'callback_'.$filename);
		
		/*if ($this->form_validation->run() == FALSE) {
				echo validation_errors();
			} else {*/
		
		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());

		$this->load->view('fileupload_test', $error); 
		//print "Error while uploading. Please upload only .doc or .pdf extention files!!!";
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$config['source_image'] = 'uploads/answers/'.$filename;
			
			//print_r($config['source_image']);
			$config['new_image'] = 'uploads/answers/'.$filename;
			//print_r($config['new_image']);

			$config['wm_text'] = 'Genius Group';
			$config['wm_type'] = 'text';
			//$config['wm_font_path'] = './system/fonts/texb.ttf';
			$config['wm_font_size'] = '26';
			$config['wm_font_color'] = '000000';
			$config['wm_opacity'] = '25%';
			$config['wm_vrt_alignment'] = 'middle';
			$config['wm_hor_alignment'] = 'left';
			$config['wm_padding'] = '70';


			$this->load->library('image_lib', $config);
			$this->image_lib->watermark();

			$update['table'] = 'examanswer';
			$update['data']['qBankid'] = $qid;
			$update['data']['qDesignerId'] = $examid;
			$update['data']['userid'] = $userid;
			$update['data']['typeid'] = $roleid;
			$update['data']['entrydate'] = entrydate();
			
			if($flag=='4'){
				$update['data']['answer'] = $filename;
			}
			
			if ($count > 0) {
				$update['where']['qBankid'] = $qid;
				$update['where']['qDesignerId']= $examid;
				$update['where']['userid']= $userid;
				update($update);
				if (update($update)) {
					//print"Data Updated Sucessfully";
				}
				else
					print"Error Occured";
			}
			else {
				insert($update);
				//print "Data Inserted Successfully";
			}
			$this->load->view('upload_success', $data);
		}

//}
	}
	
	function download_answer($filename){
		$this->load->helper('download');
		$data['filename'] = $filename;
		$data['download_path'] = 	"http://198.1.110.184/~geniuste/gg/onlinelatest/uploads/answers/".$filename;
	
		$this->load->view("download_answer",$data);
	
		//redirect("question", "refresh");

		//$data = file_get_contents("/var/www/001.jpg"); // Read the file's contents
		//$name = 'myphoto.jpg';

		//force_download($name, $data);
	}
	
	public function userfile($str){
		$userfile['table']='examanswer';
		$userfile['where']['answer']=$str;
		$userfile=getsingle($userfile);
		//printqq();
		if(!empty($userfile))
		{
			$userfile=$userfile['userfile'];
			if($str==$userfile){
				$this->form_validation->set_message('userfile', $userfile.' is already exist');
				return FALSE;
			}
			else
			{	
				$this->form_validation->set_message('userfile',$userfile.' is available ');
				return TRUE;
			}
		}
	}
	
	function test_page(){
		
		//load our new PHPExcel library
$this->load->library('excel');
//activate worksheet number 1
$this->excel->setActiveSheetIndex(0);


/** Query 1.0 */
    $query = "SELECT * FROM scorecard";

    if ($result = mysql_query($query) or die(mysql_error())) {
/** Create a new PHPExcel object 1.0 */
//name the worksheet
$this->excel->getActiveSheet()->setTitle('test worksheet');
   }  
  $this->excel->getActiveSheet()->setCellValue('A1','Id');
  $this->excel->getActiveSheet()->setCellValue('B1','Rank');
  $this->excel->getActiveSheet()->setCellValue('C1','Name');
  $this->excel->getActiveSheet()->setCellValue('D1','Exam');
  $this->excel->getActiveSheet()->setCellValue('E1','Percentage');
  $this->excel->getActiveSheet()->setCellValue('F1','Result');
  $this->excel->getActiveSheet()->setCellValue('G1','Correct Answer');
  $this->excel->getActiveSheet()->setCellValue('H1','Wrong Answer');
  $this->excel->getActiveSheet()->setCellValue('I1','Marks Scored');
/** Loop through the result set 1.0 */
    $rowNumber = 2; //start in cell 1
    while ($row = mysql_fetch_row($result)) {
       $col = 'A'; // start at column A
       foreach($row as $cell) {
          $this->excel->getActiveSheet()->setCellValue($col.$rowNumber,$cell);
          $col++;
       }
       $rowNumber++;
}




//set cell A1 content with some text
//$this->excel->getActiveSheet()->setCellValue('A1', 'This is just some text value');
//change the font size
//$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
//make the font become bold
///$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
//merge cell A1 until D1
//$this->excel->getActiveSheet()->mergeCells('A1:D1');
//set aligment to center for that merged cell (A1 to D1)
$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 
$filename='just_some_random_name.xls'; //save our workbook as this file name
header('Content-Type: application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no cache
             
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format
$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
//force user to download the Excel file without writing it to server's HD
$objWriter->save('php://output');
		
		
		$data ="";
		$this->load->view("theme/header",$data);
		$this->load->view("testExcel",$data);
		$this->load->view("theme/footer",$data);
	}
	function csv_upload()
	{
		$file_handle = fopen("uploads/answers/".$filename, "r");
		while (!feof($file_handle) ) {
			$line_of_text = fgetcsv($file_handle, 1024);
			print $line_of_text[0] . $line_of_text[1]. $line_of_text[2] . "<BR>";
		}
		fclose($file_handle);	
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

	function exam_timeout(){
		$examid=intval($this->input->post('examid'));
		$type=intval($this->input->post('type'));
		$userid=intval($this->input->post('userid'));
	
		$changestatus['table'] = 'assigned_users';
		$changestatus['where']['user_id'] = $userid;
		$changestatus['where']['qid'] = $examid;
		$changestatus['where']['type'] = $type;
		$count = total_rows($changestatus);
	
		if($count > 0){
			$update['table'] = 'assigned_users';
			$update['data']['c_status'] = 2;
			$update['where']['user_id'] = $userid;
			$update['where']['qid'] = $examid;
			$update['where']['type'] = $type;
			if(update($update)){
				print "Your time expired!!! Please contact adminstrator";
			}
		}
	}
}

/* End of file exam.php */
/* Location: ./application/controllers/exam.php */
