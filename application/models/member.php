<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Model
{
	
	//Mendapatkan seluruh data members
	//untuk keperluan secara umum
	public function getAllEmailByGroupMembers($groupID){
			$query = $this->db->query("SELECT mb.member_email
					  FROM meeting_groups mg JOIN members mb JOIN group_members gm
					  ON mg.group_id=gm.group_id 
					  AND mb.member_id=gm.member_id
                      WHERE mg.group_id='$groupID");
		return $query->result_array();
	}

	public function getAllMachineByGroupMemberID($groupID){
			$query = $this->db->query("SELECT fm.machine_id, 
						     fm.group_id, 
					         fm.max_id_numbers
					  FROM fingerprint_machine fm 
					  WHERE fm.group_id='$groupID'");
		return $query->result_array();
	}	

	public function getAllNameByGroupMembers($groupID){
		$query = $this->db->query("SELECT mb.member_name
				  FROM meeting_groups mg JOIN members mb JOIN group_members gm
				  ON mg.group_id=gm.group_id 
				  AND mb.member_id=gm.member_id
				  WHERE mg.group_id='$groupID'");
		return $query->result_array();
	}

	public function getMemberNameByID($memberID){
		$query = $this->db->query("SELECT member_name, member_id
				  FROM members
				  WHERE member_id='$memberID'");
		return $query->result_array();
	}

	public function getGroupIDByMemberID($memberID){
		$query = $this->db->query("SELECT mg.group_id, mg.group_name
				  FROM meeting_groups mg JOIN members mb JOIN group_members gm
				  ON mg.group_id=gm.group_id 
				  AND mb.member_id=gm.member_id
				  WHERE mb.member_id='$memberID'");
		return $query->result_array();
	}

} 