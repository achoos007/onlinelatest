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
	 


print_r($data['userid']);


$data['menu']='home';



$this->menu="home";
$this->title="home";


 
$data['main']['dashboard']['title']=	"Dashboard"; 
$data['main']['dashboard']['page']=		$this->load->view("dashboard",$data,TRUE); 





$this->load->view("theme/header",$data);
$this->load->view("theme/index",$data);
$this->load->view("theme/footer",$data);










/*

$this->load->library('calendar', $prefs);
		$this->load->view('header');
		$this->load->view('dashboard');
		$this->load->view('footer');
*/
	}
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
