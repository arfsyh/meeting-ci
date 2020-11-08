<?php defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');


class Group extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Database'); 
		$this->load->model('Meeting'); 
	}

	public function index() 
	{
		
		$data['group_name'] = $this->Database->getAllGroup();

		$data['last']=$this->Database->getLast();
		$this->load->view('creategroup', $data);
    }
    public function id($id){
        $data['group_name'] = $this->Database->getAllGroup();
        $data['group'] = $this->Database->getGroupbyID($id);
        $data['member'] = $this->Database->getGroupMembers($id);
        $this->load->view('group', $data);

	}

	public function MemberId($memberName,$memberEmail){

		$id[]= array();
		for($i=0;$i<count($memberName);$i++){
			$query[] = $this->db->query("SELECT member_id
									FROM members
									WHERE member_name='$memberName[$i]'
									AND member_email='$memberEmail[$i]'");
			$id = array_merge($id,$query);
		}
		return $id;

	}
	public function GroupId($groupName){
		$query = $this->db->query("SELECT group_id
									FROM meeting_groups
									WHERE group_name='$groupName'");
		return $query->result_array();

	}
	
	public function create(){
		$groupID = $this->input->post('GroupId');
		$groupName = $this->input->post('group');
		$MemberName = $this->input->post('name');
		$memberEmail = $this->input->post('email');
		if($MemberName[0]==""){
			$this->db->query("INSERT INTO meeting_groups (group_id,group_name) 
							VALUES ('$groupID','$groupName')");
							echo "<script>alert('Berhasil membuat Group ".$groupName."');window.location.href='".site_url('Group/id/'.$groupID)."';</script>" ;
		}else{
			$this->db->query("INSERT INTO meeting_groups (group_id,group_name) 
							VALUES ('$groupID','$groupName')");

			for($i = 0; $i < count($MemberName);$i++){
				$emailcheck =$this->db->query("SELECT member_email from members where member_name='$MemberName[$i]' and member_email='$memberEmail[$i]'")->result_array();
						
						if(empty($emailcheck)){
							$this->db->query("INSERT INTO members (member_name, member_email) VALUES('$MemberName[$i]','$memberEmail[$i]')");
						}
						
				}
				$id=array();
				for($i=0;$i<count($MemberName);$i++){
					$query = $this->Database->getmemberId($MemberName[$i],$memberEmail[$i]);
					$id = array_merge($id,$query);
				}	
				
				foreach($id as $key=>$val){
					$membergrubcheck = $this->db->query("SELECT member_id from group_members where member_id='$val[member_id]' and group_id='$groupID'")->result_array();
						
					if(empty($membergrubcheck)){
							$this->db->query("INSERT INTO group_members (member_id, group_id)
									VALUES('$val[member_id]','$groupID')");
						}
					
				}
				echo "<script>alert('Berhasil membuat Group ".$groupName."');window.location.href='".site_url('Group/id/'.$groupID)."';</script>" ;

		}

		/*$this->db->query("INSERT INTO meeting_groups (group_id,group_name) 
							VALUES ('$groupID','$groupName')");

			for($i = 0; $i < count($MemberName);$i++){
				$emailcheck =$this->db->query("SELECT member_email from members where member_name='$MemberName[$i]' and member_email='$memberEmail[$i]'")->result_array();
						
						if(empty($emailcheck)){
							$this->db->query("INSERT INTO members (member_name, member_email) VALUES('$MemberName[$i]','$memberEmail[$i]')");
						}
						
				}
				$id=array();
				for($i=0;$i<count($MemberName);$i++){
					$query = $this->Database->getmemberId($MemberName[$i],$memberEmail[$i]);
					$id = array_merge($id,$query);
				}	
				
				foreach($id as $key=>$val){
					$membergrubcheck = $this->db->query("SELECT member_id from group_members where member_id='$val[member_id]' and group_id='$groupID'")->result_array();
						
					if(empty($membergrubcheck)){
							$this->db->query("INSERT INTO group_members (member_id, group_id)
									VALUES('$val[member_id]','$groupID')");
						}
					
				}
		/*for($i = 0; $i < count($MemberName);$i++){
			$this->db->query("INSERT INTO members (member_name, member_email)
							VALUES('$MemberName[$i]','$memberEmail[$i]')");
		}
		$id=array();
		for($i=0;$i<count($MemberName);$i++){
			$query = $this->Database->getmemberId($MemberName[$i],$memberEmail[$i]);
			$id = array_merge($id,$query);
		}

		foreach($id as $v){
			$this->db->query("INSERT INTO group_members (member_id, group_id)
							VALUES('$v[member_id]','$groupID')");
		}*/
		//echo "<script>alert('Berhasil membuat Group ".$groupName."');window.location.href='".base_url()."';</script>" ;
		  
		
	}

    public function Marge(){
		$data['group_name'] = $this->Database->getAllGroup();
		$data['last']=$this->Database->getLast();
		$id = $this->input->post('gm');
        $data['name'] = $this->input->post('name');
        $jum = count($id);
		$data['kosong']=array();
		for ($i=0; $i < $jum; $i++) { 
					$data['member']= $this->Database->getGroupMembers($id[$i]);
					$data['kosong'] = array_merge($data['kosong'],$data['member']);
		}
$asu = 1;
		for ($j = 0; $j<$jum; $j++){
			for($k = 1; $k<$jum;$k++){
				foreach($this->Database->getGroupMembers($id[$j]) as $a){
					foreach($this->Database->getGroupMembers($id[$k]) as $b){
						
						if($a['member_name'] == $b['member_name']){
							
								
							
							
						}
							
					}
				}
			}
			
		}

        $this->load->view('marge',$data);

    }
    public function MargeSave(){
		$groupID = $this->input->post('GroupId');
		$groupName = $this->input->post('gnm');
		$memberId = $this->input->post('check[]');
		

		$this->db->query("INSERT INTO meeting_groups (group_id,group_name) 
							VALUES ('$groupID','$groupName')");

		foreach($memberId as $val){
			$idcheck = $this->db->query("SELECT member_id from group_members where member_id='$val' and group_id='$groupID'")->result_array();
		
			if(empty($idcheck)){
					$this->db->query("INSERT INTO group_members (member_id, group_id)
						VALUES('$val','$groupID')");
				}
				
			}
		echo "<script>alert('Group Berhasil Digabungkan ');window.location.href='".site_url('Group/id/'.$groupID)."';</script>" ;
	
        
	}
	public function AddMember(){
		$groupID = $this->input->post('GroupId');
		$MemberName = $this->input->post('name');
		$memberEmail = $this->input->post('email');


		
		
		for($i = 0; $i < count($MemberName);$i++){
		$emailcheck =$this->db->query("SELECT member_email from members where member_name='$MemberName[$i]' and member_email='$memberEmail[$i]'")->result_array();
				
				if(empty($emailcheck)){
					$this->db->query("INSERT INTO members (member_name, member_email) VALUES('$MemberName[$i]','$memberEmail[$i]')");
				}
				
		}
		
		



		$id=array();
		for($i=0;$i<count($MemberName);$i++){
			$query = $this->Database->getmemberId($MemberName[$i],$memberEmail[$i]);
			$id = array_merge($id,$query);
		}	
		
		foreach($id as $key=>$val){
			$membergrubcheck = $this->db->query("SELECT member_id from group_members where member_id='$val[member_id]' and group_id='$groupID'")->result_array();
				
			if(empty($membergrubcheck)){
					$this->db->query("INSERT INTO group_members (member_id, group_id)
							VALUES('$val[member_id]','$groupID')");
				}
			
		}
		/*foreach($id as $v){

			$this->db->query("INSERT INTO group_members (member_id, group_id)
							VALUES('$v','$groupID')");
		}*/
		echo "<script>alert('Berhasil Menambahkan kedalam Group ');window.location.href='".site_url('Group/id/'.$groupID)."';</script>" ;
	}

	public function Delete(){
		$groupID = $this->input->post('GroupId');
		$memberID = $this->input->post('memberID');

		echo $groupID, $memberID;
		$this->db->query("DELETE FROM group_members WHERE group_id='$groupID' AND member_id='$memberID'");
		
		//$this->db->query("DELETE FROM members WHERE member_id='$memberID'");
		echo "<script>alert('Berhasil Menghapus dari Group ');window.location.href='".site_url('Group/id/'.$groupID)."';</script>" ;

	}
	
	public function DelGroup(){
		$groupID = $this->input->post('GroupId');

		foreach($this->Database->getAllGroupMember() as $x){
			if($x['group_id']== $groupID){
				$this->db->query("DELETE FROM group_members WHERE group_id='$groupID'");
			}


		}
		$this->db->query("DELETE FROM meeting_groups WHERE group_id='$groupID'");
		
		//$this->db->query("DELETE FROM members WHERE member_id='$memberID'");
		echo "<script>alert('Group Berhasil dihapus');window.location.href='".site_url('calendar')."';</script>" ;

	}

	public function EditGroupName(){
		$groupID = $this->input->post('GroupId');
		$name = $this->input->post('name');

		$this->db->query("UPDATE meeting_groups SET group_name = '$name' WHERE group_id='$groupID'");
		redirect(site_url('Group/Id/'.$groupID));
		
		//$this->db->query("DELETE FROM members WHERE member_id='$memberID'");

	}

	public function Editmember(){
		$groupID = $this->input->post('GroupId');
		$id = $this->input->post('id');
		$name = $this->input->post('editname');
		$email = $this->input->post('editemail');

		echo $name,$email;

		$this->db->query("UPDATE members SET member_name = '$name', member_email ='$email' WHERE member_id='$id'");
		redirect(site_url('Group/Id/'.$groupID));
		
		//$this->db->query("DELETE FROM members WHERE member_id='$memberID'");

	}
	/*public function save()
	{
		$response = array();
		$this->form_validation->set_rules('title', 'Title cant be empty ', 'required');
	    if ($this->form_validation->run() == TRUE)
      	{
			$param = $this->input->post();
			$calendar_id = $param['calendar_id'];
			unset($param['calendar_id']);

			if($calendar_id == 0)
			{
		        $param['create_at']   	= date('Y-m-d H:i:s');
		        $insert = $this->modeldb->insert($this->table, $param);

		        if ($insert > 0) 
		        {
		        	$response['status'] = TRUE;
		    		$response['notif']	= 'Success add calendar';
		    		$response['id']		= $insert;
		        }
		        else
		        {
		        	$response['status'] = FALSE;
		    		$response['notif']	= 'Server wrong, please save again';
		        }
			}
			else
			{	
				$where 		= [ 'id'  => $calendar_id];
	            $param['modified_at']   	= date('Y-m-d H:i:s');
	            $update = $this->modeldb->update($this->table, $param, $where);

	            if ($update > 0) 
	            {
	            	$response['status'] = TRUE;
		    		$response['notif']	= 'Success add calendar';
		    		$response['id']		= $calendar_id;
	            }
	            else
		        {
		        	$response['status'] = FALSE;
		    		$response['notif']	= 'Server wrong, please save again';
		        }

			}
	    }
	    else
	    {
	    	$response['status'] = FALSE;
	    	$response['notif']	= validation_errors();
	    }

		echo json_encode($response);
	}

	public function delete()
	{
		$response 		= array();
		$calendar_id 	= $this->input->post('id');
		if(!empty($calendar_id))
		{
			$where = ['id' => $calendar_id];
	        $delete = $this->modeldb->delete($this->table, $where);

	        if ($delete > 0) 
	        {
	        	$response['status'] = TRUE;
	    		$response['notif']	= 'Success delete calendar';
	        }
	        else
	        {
	        	$response['status'] = FALSE;
	    		$response['notif']	= 'Server wrong, please save again';
	        }
		}
		else
		{
			$response['status'] = FALSE;
	    	$response['notif']	= 'Data not found';
		}

		echo json_encode($response);
	}*/

}
