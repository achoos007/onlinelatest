<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage extends CI_Controller {
	

	
	  // public function __construct()
       // {
				 	// $this->menu="question";
// 
// $this->title="question";
// 
	// }

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

	
// ---------------------------------------------------------------------
$data['main']['validate']['title']=	"Validate Exam";
$data['main']['validate']['page']  =	$this->load->view("exam_validate",$data,TRUE); 

// ---------------------------------------------------------------------








$this->load->view("theme/header",$data);

$this->load->view("theme/index",$data);

$this->load->view("theme/footer",$data);

	}
	
function exam($examid=0,$mocktype="off",$date=0,$user_id=0) {
$data['examid']=intval($examid);
$data['mocktype']=$mocktype;
$data['user_id']=intval($user_id);
// ---------------------------------------------------------------------
$this->menu="result";
$this->title="question";

// for getting time duration 

$get_duration['table'] = 'qdesigner';
$get_duration['where']['qDesignerId'] = $examid;
$get_duration = getsingle($get_duration);
$data['duration']=$get_duration['duration'];

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

	$userid = $this->session->userdata('userid');
$data['question']=$d;
$data['qid']=$d;
$data['id']=$i;
$data['date']=$date;

$data['examid'] = $examid;

// for getting the answerd question which needs to display at admin side
	$ansexam['table']='examanswer';
	$ansexam['where']['qBankid']=$data['qid'];
	$ansexam['where']['qDesignerId']=$data['examid'];
	$ansexam['where']['userid']=$user_id;
	
	$ansexam = getsingle($ansexam);
	
	
	
	
	$query=  $this->db->query("select * from examanswer where qBankid=".$data['qid']." and qDesignerId=".$data['examid']." and userid=".$user_id);
 $data['count1'] = $query->num_rows();
	//$count = count($ansexam['result']);
	//$count=total_rows($ansexam);
	
	if($data['count1'] > 0){
	$data['ans'] = $ansexam['answer'];
	}







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
	$status=$this->input->post('status');
	$flag=intval($this->input->post('flag'));
	$examid=intval($this->input->post('examid'));
	$roleid=intval($this->input->post('roleid'));
	
	$ansexam['table']='examanswer';
	$ansexam['where']['qBankid']=$qid;
	$ansexam['where']['qDesignerId']=$examid;
	$ansexam['where']['userid']=$userid;
	$count=total_rows($ansexam);

print $userid;
print "Count".$count;
print"RoleId".$roleid;

	$update['table'] = 'examanswer';
	$update['data']['qBankid'] = $qid;
	$update['data']['qDesignerId'] = $examid;
	$update['data']['userid'] = $userid;
	$update['data']['typeid'] = $roleid;
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

	elseif($flag=='4'){function __construct()
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
	$update['data']['answer'] = $this->input->post('clkid');
	
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

	function do_upload()
	{
		$config['upload_path'] = 'uploads/answers';
		$config['allowed_types'] = 'csv|doc|pdf|txt';
		//$config['max_size']	= '1000';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';

		$filename = $_FILES['userfile']['name'];
		
		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());

		//$this->load->view('fileupload_test', $error); 
		print "Error while uploading. Please upload only .doc or .pdf extention files!!!";
			
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());

		print"Successfully uploaded!!!!".$filename;
		
		
		$file_handle = fopen("uploads/answers/".$filename, "r");

	while (!feof($file_handle) ) {

$line_of_text = fgetcsv($file_handle, 1024);



$add['table'] = 'ex_hotel';

$add['data']['HotelID'] = $line_of_text[0];
$add['data']['Name'] = $line_of_text[1];
$add['data']['AirportCode'] = $line_of_text[2];
$add['data']['Address1'] = $line_of_text[3];
$add['data']['Address2'] = $line_of_text[4];
$add['data']['Address3'] = $line_of_text[5];
$add['data']['City'] = $line_of_text[6];
$add['data']['StateProvince'] = $line_of_text[7];
$add['data']['Country'] = $line_of_text[8];
$add['data']['PostalCode'] = $line_of_text[9];
$add['data']['Longitude']	=	$line_of_text[10];
$add['data']['Latitude'] = $line_of_text[11];
$add['data']['LowRate'] = $line_of_text[12];
$add['data']['HighRate'] = $line_of_text[13];
$add['data']['MarketingLevel'] = $line_of_text[14];
$add['data']['Confidence'] = $line_of_text[15];
$add['data']['HotelModified'] = $line_of_text[16];
$add['data']['PropertyType'] = $line_of_text[17];
$add['data']['TimeZone'] = $line_of_text[18];
$add['data']['GMTOffset'] = $line_of_text[19];
$add['data']['YearPropertyOpened'] = $line_of_text[20];
$add['data']['YearPropertyRenovated'] = $line_of_text[21];
$add['data']['NativeCurrency'] = $line_of_text[22];
$add['data']['NumberOfRooms'] = $line_of_text[23];
$add['data']['NumberOfSuites'] = $line_of_text[24];
$add['data']['NumberOfFloors'] = $line_of_text[25];
$add['data']['CheckInTime'] = $line_of_text[26];
$add['data']['CheckOutTime'] = $line_of_text[27];
$add['data']['HasValetParking'] = $line_of_text[28];
$add['data']['HasContinentalBreakfast'] = $line_of_text[29];
$add['data']['HasInRoomMovies'] = $line_of_text[30];
$add['data']['HasSauna'] = $line_of_text[31];
$add['data']['HasWhirlpool'] = $line_of_text[32];
$add['data']['HasVoiceMail'] = $line_of_text[33];
$add['data']['Has24HourSecurity'] = $line_of_text[34];
$add['data']['HasParkingGarage'] = $line_of_text[35];
$add['data']['HasElectronicRoomKeys'] = $line_of_text[36];
$add['data']['HasCoffeeTeaMaker'] = $line_of_text[37];
$add['data']['HasSafe'] = $line_of_text[38];
$add['data']['HasVideoCheckOut'] = $line_of_text[39];


$add['data']['HotelID'] = $line_of_text[40];
$add['data']['Name'] = $line_of_text[41];
$add['data']['AirportCode'] = $line_of_text[42];
$add['data']['Address1'] = $line_of_text[43];
$add['data']['Address2'] = $line_of_text[44];
$add['data']['Address3'] = $line_of_text[45];
$add['data']['City'] = $line_of_text[46];
$add['data']['StateProvince'] = $line_of_text[47];
$add['data']['Country'] = $line_of_text[48];
$add['data']['PostalCode'] = $line_of_text[49];
$add['data']['Longitude']	=	$line_of_text[50];
$add['data']['Latitude'] = $line_of_text[51];
$add['data']['LowRate'] = $line_of_text[52];
$add['data']['HighRate'] = $line_of_text[53];
$add['data']['MarketingLevel'] = $line_of_text[54];
$add['data']['Confidence'] = $line_of_text[55];
$add['data']['HotelModified'] = $line_of_text[56];
$add['data']['PropertyType'] = $line_of_text[57];
$add['data']['TimeZone'] = $line_of_text[58];
$add['data']['GMTOffset'] = $line_of_text[59];
$add['data']['YearPropertyOpened'] = $line_of_text[60];
$add['data']['YearPropertyRenovated'] = $line_of_text[61];
$add['data']['NativeCurrency'] = $line_of_text[62];
$add['data']['NumberOfRooms'] = $line_of_text[63];
$add['data']['NumberOfSuites'] = $line_of_text[64];
$add['data']['NumberOfFloors'] = $line_of_text[65];
$add['data']['CheckInTime'] = $line_of_text[66];
$add['data']['CheckOutTime'] = $line_of_text[67];
$add['data']['HasValetParking'] = $line_of_text[68];
$add['data']['HasContinentalBreakfast'] = $line_of_text[69];
$add['data']['HasInRoomMovies'] = $line_of_text[70];
$add['data']['HasSauna'] = $line_of_text[71];
$add['data']['HasWhirlpool'] = $line_of_text[72];
$add['data']['HasVoiceMail'] = $line_of_text[73];
$add['data']['Has24HourSecurity'] = $line_of_text[74];
$add['data']['HasParkingGarage'] = $line_of_text[75];
$add['data']['HasElectronicRoomKeys'] = $line_of_text[76];
$add['data']['HasCoffeeTeaMaker'] = $line_of_text[77];
$add['data']['HasSafe'] = $line_of_text[78];
$add['data']['HasVideoCheckOut'] = $line_of_text[79];


if(!empty($line_of_text)){
	insert($add);
print "Data Inserted Successfully";
}
else{
	
	print "Error Occured!!!";
	
	}
//print $line_of_text[0] . $line_of_text[1]. $line_of_text[2] . "<BR>";

}
fclose($file_handle);	
		
		
		
			$this->load->view('upload_success', $data);
}
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
	

}

/* End of file exam.php */
/* Location: ./application/controllers/exam.php */
