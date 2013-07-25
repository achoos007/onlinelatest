<?php
Class Login_db extends CI_Model
{
	
	//selecting country names  
	function get_results($sql)
	{
		$query = $this->db->query($sql);

		if($query -> num_rows() >0)
		{
			return $query->result();
			 
		}
		else
		{
			return false;
		}

	}
		
				
	function login_checking($username, $password)
	{
		$this -> db -> select('username,password');
		$this -> db -> from('tbl_staffs');
		$this -> db -> where('username = ' . "'" . $username . "'"); 
		$this -> db -> where('password = ' . "'" . $password . "'"); 
		$this -> db -> limit(1);
		$query = $this -> db -> get();
		$query -> num_rows();

		if($query -> num_rows() == 1)
		{
			return $query->result();
			 
		}
		else
		{
			return false;
		}

	}
	
	//pnid checking
	function login_validation_step2($username)
	{

		$query = $this->db->query("SELECT staff_id,username,staff_code,DOJ,first_name,SYSDATE() currentdate FROM tbl_staffs where username='".$username."'");

		$query -> num_rows();

		if($query -> num_rows() == 1)
		{
			return $query->result();
			 
		}
		else
		{
			return false;
		}

	}	
	function updatetable($query)
	{

			$this->db->trans_begin();
			$this->db->query($query);
			
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
				return FALSE;
			}
			else
			{
				$this->db->trans_commit();
				return TRUE;
			}	

	}	
	
	function get_empusername($empid)
	{

		$query = $this->db->query("SELECT username FROM tbl_staffs where staff_id='".$empid."'");

		$query -> num_rows();

			if($query -> num_rows() >0)
			{	
			   foreach ($query->result() as $row)
			   {
				   $username=$row->username;
			   }
			}
			if(!empty($username)){
				return $username;
			} 
	}	
}
?>
