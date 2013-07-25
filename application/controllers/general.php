<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class General extends CI_Controller {
	
	
	
 
	public function index()
	{
		
		
		
	}
	
	function day(){
$this->menu="exam";
$this->title="home";
 
		
	 
	 
	 
	 $data['title']='Tasks';
	 
	 
	 
	 
$this->load->view("theme/header",$data);
$this->load->view("calendar_popup",$data);
$this->load->view("theme/footer",$data);
	}
	
	
	
	
	
	
	
}

/* End of file exam.php */
/* Location: ./application/controllers/exam.php */
