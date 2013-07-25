<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>
<?php 
print empty($title)?"Admin":$title;
?>-Examination module :: Genius Group Global
</title>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url("css/onlineexam.css"); ?>" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url("css/exam.css"); ?>" media="screen" />
<script type="text/javascript" src="<?php print base_url("js/jquery.js"); ?>"></script>
<script type="text/javascript" src="<?php print base_url("js/jquery2.js"); ?>"></script> 
</head>
<body onLoad="document.getElementById('username').focus();" >

 
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0"   >
  <tr>
    <td   align="center" bgcolor="#0F4082" >
				<a href="<?php print site_url();?>">
					<img src="<?php echo base_url("images/header.jpg"); ?>" border="0" />
				</a>
    </td>
  </tr>   
  <tr> 
    <td   align="center" valign='middle' >      
     <div style="width:305px; margin:10% auto; border:1px solid #0F4082;padding:50px;background-color:#5E96C4;">
												<div class="error"><?php echo validation_errors(); ?></div>
							<form method="post" action='<?php print site_url('login/');?>' data-ajax='false'>
												<table width="100%" border="0"   height="100%" > 
													<tr> 
													<td >
													<input type="text" placeholder="Username" value="" id="username" name="username"/>
													 </td>  
													</tr>													
													<tr> 
													<td >
													<input type="password" value="" placeholder="Password" id="password" name="password"/>
													 </td>  
													</tr>													
													<tr> 
													<td > 
													<input type="submit" value="Login" data-theme="b" />
													 </td>  
													</tr>
												</table>  
							</form/>
     </div>
</td>
  </tr>
</table>
<div data-role="footer" data-theme="b"  data-position="fixed"> 
	<h4>Genius Group Global</h4> 
</div> 
</body>
</html>

