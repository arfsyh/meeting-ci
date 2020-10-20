<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Database extends CI_Model{
	
  	

	public function getAllGroup(){
        return $this->db->get('meeting_groups')->result_array();
	}
	public function getAllMeeting(){
		return $this->db->get('meetings')->result_array();
	}

	public function createNewGroup($groupName){
		$this->db->set('group_name', $groupName);
		$this->db->insert('meeting_groups');

	}
	public function addMembertoGroup($memberID, $groupID){

		$this->db->set('member_id', $memberID);
		$this->db->set('group_id', $groupID);
		$this->db->insert('group_members');
	}
	public function getAllGroupMembers(){

		$query = $this->db->query("SELECT meeting_groups.group_name, members.member_name
		FROM meeting_groups JOIN members JOIN group_members
		ON meeting_groups.group_id=group_members.group_id 
		AND members.member_id=group_members.member_id");
			return $query->result_array();
	}
	public function createMeeting($groupID, $meetingName, $meetingDate, $meetingStart, $meetingEnd, $meetingPlace){
		$query = $this->db->query("INSERT INTO meetings (group_id, meeting_name, meeting_date, meeting_start, meeting_end, meeting_place) 
		VALUES ($groupID, '$meetingName', '$meetingDate', '$meetingStart','$meetingEnd', '$meetingPlace')");
			return $query->result_array();
	}
	public function getMeetingbyGroupID($groupID){
		$query = $this->db->query("SELECT mg.group_name, mt.meeting_name, mt.meeting_date, mt.meeting_time, mt.meeting_place 	
		FROM meeting_groups mg JOIN meetings mt
		ON mg.group_id=mt.group_id
		WHERE mg.group_id=$groupID");
		return $query->result_array();
	}
	public function getAllMeetingToday($dateToday){
		$query = $this->db->query("SELECT mg.group_name, mt.meeting_name, mt.meeting_date, 
		mt.meeting_start, mt.meeting_end, mt.meeting_place 
		FROM meeting_groups mg JOIN meetings mt
		ON mg.group_id=mt.group_id
		WHERE mt.meeting_date='$dateToday'");
		return $query->result_array();
	}
	public function getAllMeetingNow($dateToday){
		$query = $this->db->query("SELECT mg.group_name, mt.meeting_name, mt.meeting_date, mt.meeting_start, mt.meeting_end, mt.meeting_place, mt.meeting_id, mg.group_id
		FROM meeting_groups mg 
		JOIN meetings mt
		ON mg.group_id=mt.group_id
		WHERE mt.meeting_date='$dateToday'");
		return $query->result_array();
	}
	public function getAllMeetingThisWeek($dateToday){
		$query = $this->db->query("SELECT mg.group_name, mt.meeting_name, mt.meeting_date, mt.meeting_start, mt.meeting_end, mt.meeting_place, mt.meeting_id, mg.group_id
		FROM meeting_groups mg 
		JOIN meetings mt
		ON mg.group_id=mt.group_id
		WHERE mt.meeting_date='$dateToday'");
		return $query->result_array();
	}
	public function getAllMeetingNowForAttendanceCheck($dateToday, $memberID, $timenow, $meetingAttendanceID){
		$query = $this->db->query("SELECT ma.status, mt.meeting_start, mt.meeting_end, 
		mt.meeting_id, ma.member_id, mt.meeting_date,
		ma.attendance_time, mt.meeting_name, ma.id, ma.status
		FROM meeting_attendance ma 
		JOIN meetings mt
		ON ma.meeting_id=mt.meeting_id
		WHERE ma.member_id='$memberID' 
		AND mt.meeting_date='$dateToday'
		AND mt.meeting_start <= '$timenow'
		AND mt.meeting_end >= '$timenow'
		AND ma.status='Tidak hadir'
		AND ma.id='$meetingAttendanceID'");
		return $query->result_array();
	}
	public function getAllIDMeetingAttendance($dateToday, $memberID, $timenow){
		$query = $this->db->query("SELECT ma.status, mt.meeting_start, mt.meeting_end, 
		mt.meeting_id, ma.member_id, mt.meeting_date,
		ma.attendance_time, mt.meeting_name, ma.id, ma.status
		FROM meeting_attendance ma 
		JOIN meetings mt
		ON ma.meeting_id=mt.meeting_id
		WHERE ma.member_id='$memberID' 
		AND mt.meeting_date='$dateToday'
		AND mt.meeting_start <= '$timenow'
		AND mt.meeting_end >= '$timenow'
		AND ma.status='Tidak hadir'");
		return $query->result_array();

	}
	public function getAllMeetingIDNow($dateToday){
		$query = $this->db->query("SELECT meeting_id
		FROM meetings
		WHERE meeting_date='$dateToday'"); 
		return $query->result_array();
		
	}
	public function getGroupMembers($groupID){
		$query = $this->db->query("SELECT members.member_name, members.member_id, members.member_email
		FROM meeting_groups JOIN members JOIN group_members
		ON meeting_groups.group_id=group_members.group_id 
		AND members.member_id=group_members.member_id
		WHERE meeting_groups.group_id=$groupID");
		return $query->result_array();
	}
	public function createMeetingAttendanceLists($groupID, $meetingID){
		foreach($this->getGroupMembers($groupID) as $c){
			$query = $this->db->query("INSERT INTO meeting_attendance (meeting_id, member_name, member_id)
					 VALUES ('$meetingID','$c[member_name]','$c[member_id]')");
			return $query->result_array();
		}

		}
	public function getMeetingDateStartEnd($meetingID){
		$query = $this->db->query("SELECT meeting_date, meeting_start, meeting_end
		FROM meetings
		WHERE meeting_id = $meetingID");
			return $query->result_array();
	}
	public function checkAttendance($meetingID, $memberID){
		$query = $this->db->query("SELECT status
		FROM meeting_attendance
		WHERE meeting_id = '$meetingID' AND member_id = '$memberID'");
			return $query->result_array();
	}
	public function checkMemberExistorNOT($memberID){
		$query = $this->db->query("SELECT member_id
		FROM members
		WHERE member_id=$memberID");
			return $query->result_array();
	}
	public function fingerPrintAttendance($memberID, $attendanceTime, $meetingID){
		$query = $this->db->query("UPDATE meeting_attendance 
		SET status 			= 'Hadir',
			  attendance_time	= '$attendanceTime'
		WHERE meeting_id = '$meetingID' AND member_id = '$memberID'");
		return $query;
	}

}
?>
