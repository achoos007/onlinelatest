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
$roleid=$this->session->userdata('roleid');
$this->title = "Designer";
if($roleid==0){
$data['main']['open_question_list']['right']['text'] = "Create Question Papers";
$data['main']['open_question_list']['right']['url'] = site_url("exam/form");
}


//$get_type = "SELECT ea.userid,ea.typeid,ea.qDesignerId,emp.first_name FROM examanswer as ea, tbl_staffs as emp WHERE typeid = 1 and ea.userid = emp.staff_id group by emp.first_name ";
	
	//$data['rslt'] = $this->login_db->get_results($get_type);
		
	

$data['main']['open_question_list']['title'] = "Previous Question Papers";	
$data['main']['open_question_list']['page'] = $this->load->view("paper_designer_list", $data, TRUE);	




$this->load->view("theme/header", $data);
$this->load->view("theme/index", $data);
$this->load->view("theme/footer", $data);
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

function assigneelist($uid=0,$qid=0,$assignid=0){       
        //print_r($_POST);
         $this->menu = "exam";
        $this->title = "Designer";
        $data['title']=" List View ";  
        $data['uid']=intval($uid);
        if($data['uid'] == 1)
					$title = "Employee List";
				else if($data['uid'] == 2)
					$title = "Candidate List";
				
				
				
					
        $data['qid'] = intval($qid);
        $data['assignid'] = intval($assignid);
        $data['assigneeid']=intval($this->input->post('assigneeid'));
        $data['main']['open_question_list']['right']['text'] = "Previous Question Papers";
        $data['main']['open_question_list']['right']['url'] = site_url("exam/designer");
        $data['main']['open_question_list']['title'] = $title;
        $data['main']['open_question_list']['page'] = $this->load->view("assigneelist", $data, TRUE);

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
						else
						{
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
      printqq($update);
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
$data['exits']=$exits['qDesignerId'];
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


}$data['title']="Upload Questions";

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

}

/* End of file exam.php */
/* Location: ./application/controllers/exam.php */
