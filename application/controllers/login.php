<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		
		$this->form_validation->set_rules('username', 'Username', 'required');
    $this->form_validation->set_rules('password', 'Password', 'required|callback_login_check'); 

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('login');
		}
		else{
			redirect('dashboard', 'refresh');
		}
	}
	
	
	//login password checking

	public function login_check($password)
	{

		//Field validation succeeded.  Validate against database		
		$login_flag=FALSE;
		$login_active_flag=FALSE;
		$username = $this->input->post('username');
		
		//query the database
		$sql="SELECT username,password FROM tbl_staffs WHERE username='".$username."' AND PASSWORD='".$password."'";
		$result = $this->login_db->get_results($sql);
		
		$sql="SELECT username,password FROM candidate WHERE username='".$username."' AND PASSWORD='".$password."'";
		$result_cand = $this->login_db->get_results($sql);
				
		if($result)
		{
		  $login_flag=TRUE;
		}
			else if($result_cand)
			{
			 $login_flag=TRUE;
			}
		else
		{
		  $this->form_validation->set_message('login_check', 'Invalid Track Id or password');
		  return FALSE;
		  $login_flag=FALSE;

		}
		
		if($login_flag=TRUE)
		{
			$sql="SELECT staff_id,username,staff_code,roleid,DOJ,first_name,SYSDATE() currentdate FROM tbl_staffs where username='$username' ";
			$result = $this->login_db->get_results($sql);
			
			$sql="SELECT candidate_id,username,roleid,first_name,SYSDATE() currentdate FROM candidate where username='$username' ";
			$result_cand = $this->login_db->get_results($sql);
			if($result)
			{
			  $sess_array = array();
			  foreach($result as $row)
			  {
				  $login_time = $row->currentdate;
			  
				  $sess_array = array(
					  'userid' => $row->staff_id,
					  'username' => $row->username,
					  'dateof_join' => $row->DOJ,
					  'login_time' => $row->currentdate,
					  'name' => $row->first_name,
					  'roleid' => $row->roleid
					);
					$this->session->set_userdata($sess_array);
				
			  }
			  $login_active_flag=TRUE;
			  
			}
			else if($result_cand)
			{
				$sess_array = array();
				foreach($result_cand as $row)
			  {
					$sess_array = array(
					  'userid' => $row->candidate_id,
					  'username' => $row->username,
					  'login_time' => $row->currentdate,
					  'name' => $row->first_name,
					  'roleid' => $row->roleid
					  	);
					$this->session->set_userdata($sess_array);
				}
				$login_active_flag=TRUE;
			}
			
			if($login_active_flag=TRUE)
			{			
			  return TRUE;
			}
			else
			{
			  $this->form_validation->set_message('login_check', 'Invalid Track Id (User is expired / Disabled');
			  return FALSE;
			}			
		}
		
	}	
	
	function main_login($userid=0){
		session_start();
		
		$data['userid'] = $userid;
		
		$sess_array = array();
		
			$sess_array = array(
					  'userid' => $_SESSION['user_id'],
					  'name' => $_SESSION['username'],
					  'roleid' => $_SESSION['roleid']
					  	);
	$this->session->set_userdata($sess_array);
		
		redirect('dashboard', 'refresh');
		
	}
	
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */
