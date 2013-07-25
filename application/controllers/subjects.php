<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subjects extends CI_Controller {

public function index()
{

$this->menu="subjects";
$this->title="Subjects";

$this->show();
}

function show(){
$data['menu']='subjects';

$this->menu="subjects";
$this->title="Subjects";

$data['main']['subjectList']['title']="Subjects List"; 
$data['main']['subjectList']['right']['url']=site_url("subjects/form"); 
$data['main']['subjectList']['right']['text']='Add New Subject'; 
$data['main']['subjectList']['right']['option']=' data-rel="dialog" '; 
$data['main']['subjectList']['page']=		$this->load->view("subjects",$data,TRUE); 

$this->load->view("theme/header",$data);
$this->load->view("theme/index",$data);
$this->load->view("theme/footer",$data);
}

function form($sid=0){

$this->menu="subjects";
$this->title="Subjects";

$data['menu']='subjects';

$data['subjectid']=intval($sid);


if(intval($data['subjectid'])>0)
$data['btnText']='Edit';
else
$data['btnText']='Add';

$data['menu']='subjects'; 

/*

$data['main']['subjectList']['title']=$data['title']." - Subjects "; 
$data['main']['subjectList']['back']=1; 
$data['main']['subjectList']['right']['url']=site_url("subjects/form"); 
$data['main']['subjectList']['right']['text']='Add New'; 
$data['main']['subjectList']['page']=		$this->load->view("subjectEdit",$data,TRUE); 

*/

$data['title']=$data['btnText']." - Subjects ";  

$this->load->view("theme/header",$data);
$this->load->view("subjectEdit",$data);
$this->load->view("theme/footer",$data);

}

function del($del){
	
	$de['table']='tbl_subject';
	$de['where']['n_subjectid']=intval($del);
	delete($de);
	
}
function edit(){
	$flag=1;
$data['menu']='subjects';
$data['subjectid']=intval($this->input->post('subjectid'));

$this->form_validation->set_rules('name', 'Subject Name', 'required|alpha_dash|callback_subjectname');
			if ($this->form_validation->run() == FALSE)
				{
						echo validation_errors(); 
						$flag=0;
				} 

				if($flag!=0){
						
						$update['table']='tbl_subject';
						$update['data']['c_subject']=$this->input->post('name');
						$update['data']['status']=$this->input->post('status');
						$update['data']['addedby']=$this->session->userdata('userid');
						$update['data']['d_date']=entrydate();
				if( $data['subjectid'] > 0 ){
				$update['where']['n_subjectid']=$this->input->post('subjectid'); 
				if(update($update)){ 
					print " Data Updated Successfully : ".$this->input->post('name').ready('setTimeout("refreshPage()",1000);');
				}
				else
					print" Error occured"; 
				}
				else{
					insert($update);
					print " Data Inserted Successfully : ".$this->input->post('name').ready('setTimeout("refreshPage()",1000);');
				}
			}
}

// for checking the duplication entry of subject

public function subjectname($str){
	
	$subject['table']='tbl_subject';
	$subject['where']['c_subject']=$str;
	
	
	 
$data['subjectid']=intval($this->input->post('subjectid')); 
$subject['where']['n_subjectid !=']=$data['subjectid'];
	
	
	
	
	$subject=getsingle($subject);
	//printqq();
	if(!empty($subject))
	{
	$subjectname=$subject['c_subject'];

	if($str==$subjectname){
		$this->form_validation->set_message('subjectname', $subjectname.' is already exist');
			return FALSE;
		}
		else
		{	
			$this->form_validation->set_message('subjectname',$subjectname.' is available ');
			return TRUE;
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


}

/* End of file subjects.php */
/* Location: ./application/controllers/subjects.php */
