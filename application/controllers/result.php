<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Result extends CI_Controller {
	
	
	
 
public function index()
{
					$this->menu="result";
					$this->title="home";
						 
					$data['main']['result_dashboard']['title']="Result Dashboard";
					$data['main']['result_dashboard']['page']=$this->load->view("result_dashboard",$data,TRUE);
					$this->load->view("theme/header",$data);
					$this->load->view("theme/index",$data);
					$this->load->view("theme/footer",$data);
}
	
	
}

/* End of file exam.php */
/* Location: ./application/controllers/exam.php */
