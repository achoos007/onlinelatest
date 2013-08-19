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
if($roleid==1){
$data['main']['open_question_list']['right']['text'] = "Create Question Papers";
$data['main']['open_question_list']['right']['url'] = site_url("exam/form");
}

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
$this->form_validation->set_rules('title', 'Title', 'required');
$this->form_validation->set_rules('mark', 'Minimum Mark', 'required|integer|max_length[3]');
$this->form_validation->set_rules('duration', 'Duration', 'required|integer');
$this->form_validation->set_rules('alerttime', 'Alert time', 'required|integer');
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
	
	
$data['qid'] = intval($this->input->post('qdesignerid',TRUE));
$update['table'] = 'qdesigner';
$update['data']['title'] = $this->input->post('title');
$update['data']['minMark'] = $this->input->post('mark');
$update['data']['duration'] = $this->input->post('duration');
$update['data']['alertTime'] = $this->input->post('alerttime');
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
$update['data']['msMandatory'] = $this->input->post('ms_3 _count');
$update['data']['tfEasy'] = $this->input->post('yn_0_count');
$update['data']['tfModerate'] = $this->input->post('yn_1_count');
$update['data']['tfTough'] = $this->input->post('yn_2_count');
$update['data']['tfMandatory'] = $this->input->post('yn_3_count');
$update['data']['desEasy'] = $this->input->post('st_0_count');
$update['data']['desModerate'] = $this->input->post('st_1_count');
$update['data']['desTough'] = $this->input->post('st_2_count');
$update['data']['desMandatory'] = $this->input->post('st_0_count');
$update['data']['fileEasy'] = $this->input->post('fu_0_count');
$update['data']['fileModerate'] = $this->input->post('fu_1_count');
$update['data']['fileTough'] = $this->input->post('fu_2_count');
$update['data']['fileMandatory'] = $this->input->post('fu_3_count');
$update['data']['status'] = $this->input->post('status');



if ($data['qid'] > 0) {
$update['where']['qDesignerId'] = $this->input->post('qdesignerid');
if (update($update)) {
print"Data Updated Sucessfully".ready('setTimeout("refreshPage()",1000);');
}
else
print"Error Occured";
}
else {
insert($update);
print "Data Inserted Successfully";
//redirect('exam/designer/', 'refresh');

}
}
}

function delete() {

$qdid = intval($this->input->post('clkid'));
$del['table'] = 'qdesigner';
$del['where']['qDesignerId'] = $qdid;
delete($del);
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
        $data['qid'] = intval($qid);
        $data['assignid'] = intval($assignid);
        $data['assigneeid']=intval($this->input->post('assigneeid'));
        $data['main']['open_question_list']['right']['text'] = "Previous Question Papers";
        $data['main']['open_question_list']['right']['url'] = site_url("exam/designer");
        $data['main']['open_question_list']['title'] = "Employee List";
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
        
        $uid=intval($this->input->post('uid'));
        $userid=intval($this->input->post('clkid'));
        $qid=intval($this->input->post('qid'));
        $entrydate=intval($this->input->post('entrydate'));
         // for getting Question Designer name and User Name
        
        $details['table']='qdesigner';
        $details['where']['qDesignerId']=$qid;
        $details=  getsingle($details);
        //$title=$details['title'];
              
        if($uid==1){
					$user_det['table']='tbl_staffs';
					$user_det['where']['staff_id']=$userid;
				}
				else{
					$user_det['table']='candidate';
					$user_det['where']['candidate_id']=$userid;
					
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
                $update['data']['assign_status']='Inactive';
                $update['data']['entrydate']=$entrydate;
                $result = update($update);
                //print "<b>".$username ."</b>&nbsp; has been removed from <b>".$title."</b> exam";
                if($result){
                $flg=0;
                print $flg;
								}
								else{
									$flg=3;
                print $flg;
								}
            }
            else{
                $update['where']['user_id']=$userid;
                $update['where']['qid']=$qid;
                $update['data']['assign_status']='Active';
                $update['data']['entrydate']=$entrydate;
                $result = update($update);
                //print "<b>".$username."</b>&nbsp; has been sucessfully added to <b>".$title."</b> exam";
                 if($result){
                $flg=1;
                print $flg;
								}
								else{
									$flg=3;
                print $flg;
								}
            }
        }
        
        else {
            $update['data']['user_id']=$userid;
            $update['data']['qid']=$qid;
            $update['data']['assign_status']='Active';
            $update['data']['entrydate']=$entrydate;
            $result = insert($update);
            //print "<b>".$username."</b>&nbsp; has been sucessfully added to <b>".$title."</b> exam";
             if($result){
                $flg=1;
                print $flg;
								}
								else{
									$flg=3;
                print $flg;
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

$qarray['multiple choice single answer']['moderate']=$ques['msModerate'];
$qarray['multiple choice single answer']['easy']=$ques['msEasy'];
$qarray['multiple choice single answer']['tough']=$ques['msTough'];

$qarray['short text']['moderate']=$ques['desModerate'];
$qarray['short text']['easy']=$ques['desEasy'];
$qarray['short text']['tough']=$ques['fileTough'];

$qarray['file upload']['moderate']=$ques['fileModerate'];
$qarray['file upload']['easy']=$ques['fileEasy'];
$qarray['file upload']['tough']=$ques['fileTough'];

$qarray['yes / no']['moderate']=$ques['tfModerate'];
$qarray['yes / no']['easy']=$ques['tfEasy'];
$qarray['yes / no']['tough']=$ques['tfTough'];



$exist['table']='qexam';
$exist['where']['qDesignerId']=$data['examid'];
$exist=getsingle($exist);
$data['exits']=$exits['qDesignerId'];
if(empty($exist)){
foreach($qarray as $type=>$mode){
foreach($mode as $m=>$count){
$query=" select 	* from qBank	where 
questiontype='".$type."' and
level='".$m."'
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
how to check comma separated value in mysql

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
	
	if($cid > 0){
		$update['where']['candidate_id']=$cid;
		if(update($update)){
			print "Data updated successfully";
		}
		else
		print "Error Occured!!!";
	}
	else{
		insert($update);
		print "Data inserted successfully";
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

}

/* End of file exam.php */
/* Location: ./application/controllers/exam.php */
