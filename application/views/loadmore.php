<?php

$this->load->helper('text');

			$list='';

			

			

			

			

			

			

			

	if ($type!='open'){

		

		

			$op['where']['status !=']='open';

		

	}else{

		

			$op['where']['status']='open';

	}

			

			

			

			

			

			

			

			



			



			$op['table']='qBank';



			$op['start']=$this->session->userdata('q_bank_start')+20;



			$op['order']['qBankid']='desc';



			$op =getrecords($op);   



			



			if(!empty($op['result']))



			foreach($op['result'] as $o){  


$question=word_wrap($o['question'],25);
print $question;

				$list .= "






	<li  id='ques_".$o['qBankid']."'>
					<a href='#'  style='padding-top: 0px;padding-bottom: 0px;padding-right: 42px;padding-left: 0px;'   >
									<label style='border-top-width: 0px;margin-top: 0px;border-bottom-width: 0px;margin-bottom: 0px;border-left-width: 0px;border-right-width: 0px;' data-corners='false'>
											<fieldset data-role='controlgroup' >                                                        
													<input type='checkbox' name='checkbox-2b' id='checkbox_".$o['qBankid']."' />                   
													<label for='checkbox-2b' style='border-top-width: 0px;margin-top: 0px;border-bottom-width: 0px;margin-bottom: 0px;border-left-width: 0px;border-right-width: 0px;'>
															<img src='".base_url('images/question.jpg')."' style='float:left;width:80px;height:80px'/>
															<label  style='float:left;padding:10px 0px 0px 10px;'> 
																	<h3>".format($o['question'])."</h3>
																	<p>".$o['questiontype']."</p>
															</label> 
													</label>
											</fieldset> 
									</label>
									</a>
							<a href='".site_url('question/form/'.$o['qBankid'])."'  data-icon='info'  href='".site_url('question/form/'.$o['qBankid'])."' data-rel='dialog' >Delete</a>
			 </li>

";

 





				// <li id='ques_".$o['qBankid']."'>
// 
// 
// 
				// <a href='".site_url('question/form/'.$o['qBankid'])."' data-rel='dialog'   >
// 
// 
// 
				// <h3>".format($o['question'])."</h3>
// 
// 
// 
				// <p>".$o['questiontype']."</p>
// 
// 
// 
				// </a> 
// 
// 
// 
				// </li>
// 
// 
// 
				// ";



			}



		



		



		



		print $list;
		
?>
