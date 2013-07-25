<?php 

		$data['headermenu']=		$this->load->view("theme/headerMenu",'',TRUE);
		 $data['footermenu']=		$this->load->view("theme/footerMenu",'',TRUE);
		
		

if(!empty($main)){ 
	$page=0;
	foreach($main as $key=>$value){	
		
			$page++; 
 
				
	 
	 
	 
	 
	 
			print "<div data-role='page' id='".$key."'  data-title='".$value['title']." - Leads Management Solution'>";
			print $data['headermenu'];
			print "<div data-role='header' data-theme='b'  data-mini='true'> ";
			if(!empty($value['back']))
			print " <a href='".site_url($this->uri->segment(1))."'  data-rel='back' data-icon='arrow-l'>Go Back</a>";
			print "<h1>".$value['title']." </h1> ";
			
			
			$option=empty($value['right']['option'])? '': $value['right']['option'];
			
			if(!empty($value['right'])){
				
				
				
  print "<a href='".$value['right']['url']."' ".$option." data-mini='true' data-role='button'  class='ui-btn-right' style='width:200px;'>".$value['right']['text']."</a>";
 
//print "<a href='#'   data-role='button'  data-mini='true'  class='ui-btn-right'>saxan</a>";

}



			print " </div> ";
			
			print "<div data-role='content'>			";
			print $value['page'];  
			print "</div>";
					if(  ! empty($value['footermenu'])) 
					{
					print $value['footermenu'];
					} 
					else
					{
					print $data['footermenu'];
					}
				
			print "</div>";
			
			
			
			
 
			}    
			}  // main if loop
	
	   	 
	 ?>

<script type='text/javascript'>
function refreshPage()
{
    jQuery.mobile.changePage(window.location.href, {
        allowSamePageTransition: true,
        transition: 'none',
        reloadPage: true
    });
}
</script>



