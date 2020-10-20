<?php defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Meeting extends CI_Model
{
	
	public function getJumAllMeetingToday($dateToday){
        
		$query = $this->db->query("SELECT COUNT(mt.meeting_id) AS jumMeeting
				FROM meeting_groups mg 
				JOIN meetings mt
				ON mg.group_id=mt.group_id
				WHERE mt.meeting_date='$dateToday'");
		return $query->result_array();
	}

	/*
	* Mengambil seluruh data meeting hari ini, urut DESC berdasarkan meeting_start
	* 
	*/
	public function getAllMeetingToday($dateToday){
		$query = $this->db->query("SELECT mg.group_name, mt.meeting_name, mt.meeting_date, mt.meeting_id,
						 mt.meeting_start, mt.meeting_end, mt.meeting_place, mg.group_id 
				FROM meeting_groups mg 
				JOIN meetings mt
				ON mg.group_id=mt.group_id
				WHERE mt.meeting_date='$dateToday'
				ORDER BY meeting_start DESC");
		return $query->result_array();
	}

	public function displayJumAllMeetingToday($dateToday){
		foreach($this->getJumAllMeetingToday($dateToday) as $c){
			return $c['jumMeeting'];
		}
	}

	/*
	* Menghitung seluruh meeting hari ini
	* 
	*/
	public function countAllMeetingToday($dateToday){
		$query = $this->db->query("SELECT COUNT(mt.meeting_id) AS jumMeetingToday
				FROM meeting_groups mg 
				JOIN meetings mt
				ON mg.group_id=mt.group_id
				WHERE mt.meeting_date='$dateToday'");
		return $query->result_array();
	}

	public function displayCountAllMeetingToday($dateToday){
		foreach($this->countAllMeetingToday($dateToday) as $c){
			return $c['jumMeetingToday'];
		}
	}

	public function getJumOverlapMeetingByDate($groupID, $meetingDate){
		$query = $this->db->query("SELECT COUNT(meeting_id) AS overlapDate
				  FROM meetings 
				  WHERE group_id='$groupID' AND meeting_date='$meetingDate'");
		return $query->result_array();
	}

	public function displayJumOverlapMeetingByDate($groupID, $meetingDate){
		foreach($this->getJumOverlapMeetingByDate($groupID, $meetingDate) as $c){
			return $c['overlapDate'];
		}
	}

	public function getOverlapMeetingByTime($groupID, $meetingDate){
		$query = $this->db->query("SELECT meeting_start, meeting_end
				  FROM meetings 
				  WHERE group_id='$groupID' AND meeting_date='$meetingDate'");
		return $query->result_array();	
	}

	public function displayOverlapMeetingByTime($groupID, $meetingDate, $meetingStart){
		foreach($this->getOverlapMeetingByTime($groupID, $meetingDate) as $c){
			$meetingstartFromDB = strtotime($c['meeting_start']);
			$meetingendFromDB = strtotime($c['meeting_end']);
			$meetingStartFromUser = strtotime($meetingStart);
			if($meetingStartFromUser >= $meetingstartFromDB AND $meetingStartFromUser <= $meetingendFromDB){
					//echo "Sudah ada meeting. Cari waktu yang lain."; 
					return 1;
				 } else {
					//echo "Silakan buat meeting.";
					return 0;
			}			
		}
	}

	public function getZeroMeeting($groupID, $meetingDate){
		$query = $this->db->query("SELECT COUNT(*) as zero
			   	  FROM meetings 
				  WHERE group_id='$groupID' AND meeting_date='$meetingDate'");
		return $query->result_array();		
	}

	public function displayZeroMeeting($groupID, $meetingDate){
		foreach($this->getZeroMeeting($groupID, $meetingDate) as $xy){
			return $xy['zero'];
		}		
	}

	/*
	*	Menghitung jumlah meeting yang sama Group ID, Tanggal, Start dan End
	*	Berfungsi untuk mendeteksi meeting yang sama
	*/
	public function countSameMeetingSchedule($groupID, $meetingDate, $meetingEnd, $meetingStart){
		$query = $this->db->query("SELECT COUNT(meeting_id) AS jumSameMeeting
				  FROM meetings 
				  WHERE group_id='$groupID' 
				  AND meeting_date='$meetingDate'
				  AND meeting_start='$meetingStart'
				  AND meeting_end='$meetingEnd'");
		return $query->result_array();	
	}

	/*
	*	Menampilkan jumlah meeting yang sama Group ID, Tanggal, Start dan End
	*	Berfungsi untuk mendeteksi meeting yang sama
	*/
	public function displayCountSameMeetingSchedule($groupID, $meetingDate, $meetingEnd, $meetingStart){
		foreach($this->countSameMeetingSchedule($groupID, $meetingDate, $meetingEnd, $meetingStart) as $xy){
			return $xy['jumSameMeeting'];
		}		
	}	

	/*
	* Membuat agenda meeting baru serta membuat daftar hadir
	*/
	public function createNewMeeting($groupID, $meetingName, $meetingDate, $meetingStart, $meetingEnd, $meetingPlace){
		$query = $this->db->query("INSERT INTO meetings (group_id, meeting_name, meeting_date, meeting_start, meeting_end, meeting_place) 
           		  VALUES ($groupID, '$meetingName', '$meetingDate', '$meetingStart','$meetingEnd', '$meetingPlace')");
		return $query;
		sleep(3);
		//$this->createAttendanceLists($groupID);
	}

	/**
	* Note: Belum mempertimbangkan multiple pengundang rapat
	* bisa jadi ID max Meeting bukan dari grup yang sama. Karena ada grup lain yang barusan
	* membuat acara.
	* PROBLEM CONCURRENCY
	* Solusi sementara harus difilter berdasarkan Group ID
	*/

	/* Mengambil ID Meeting/Event terbaru */
	public function getMaxRowsAndGroupIDOFMeetings($groupID){
		$query = $this->db->query("SELECT meeting_id
				  FROM meetings 
				  WHERE group_id = '$groupID'
				  ORDER BY meeting_id DESC LIMIT 1");
		return $query->result_array();
	}

	/* Mengambil data member berdasarkan grup */
	public function getAllGroupMembers($groupID){
		$query = $this->db->query("SELECT mb.member_name, mb.member_id
					  FROM meeting_groups mg JOIN members mb JOIN group_members gm
					  ON mg.group_id=gm.group_id 
					  AND mb.member_id=gm.member_id
					  WHERE mg.group_id='$groupID'");
		return $query->result_array();
	}

	public function getAllEmailByGroupMembers($groupID){
		$query = $this->db->query("SELECT mb.member_email
				  FROM meeting_groups mg JOIN members mb JOIN group_members gm
				  ON mg.group_id=gm.group_id 
				  AND mb.member_id=gm.member_id
				  WHERE mg.group_id='$groupID'");
		return $query->result_array();
	}

	/* 
	*	Membuat daftar hadir berdasarkan anggota grup
	*/
	public function createAttendanceLists($groupID){
		foreach($this->getAllGroupMembers($groupID) as $x){
			foreach($this->getMaxRowsAndGroupIDOFMeetings($groupID) as $c)
            $query = $this->db->query("INSERT INTO meeting_attendance (meeting_id, member_id, group_id, member_name)
						  VALUES ('$c[meeting_id]','$x[member_id]','$groupID','$x[member_name]')");
		return $query;
		}		
	}

	/*
	* Menghitung jumlah anggota grup
	*/
	public function countGroupMember($groupID){
		$query = $this->db->query("SELECT COUNT(id) AS jumMember
				  FROM group_members
				  WHERE group_id='$groupID'");
		return $query->result_array();
	}

	public function displayCountGroupMember($meetingID){
		foreach ($this->countGroupMember($meetingID) as $key) {
			return $key['jumMember'];
		}
	}

	/*
	* Menghitung jumlah kehadiran setiap meeting
	*/
	public function countMeetingAttendance($meetingID){
		$query = $this->db->query("SELECT COUNT(ma.status) AS jumHadir
				  FROM meeting_attendance ma
				  JOIN meetings mt 
				  ON ma.meeting_id=mt.meeting_id 
				  WHERE ma.meeting_id='$meetingID' AND ma.status='Hadir'");
		return $query->result_array();
	}

	public function displayCountMeetingAttendance($meetingID){
		foreach ($this->countMeetingAttendance($meetingID) as $key) {
			return $key['jumHadir'];
		}
	}

	/*
	* Menghitung jumlah meeting tiap hari dalam satu bulan kalendar
	* 
	*/
	public function countEverydayMeetingInMonth($month){
		$query = $this->db->query("SELECT COUNT(mt.meeting_id) AS jumMeetingToday
				FROM meeting_groups mg 
				JOIN meetings mt
				ON mg.group_id=mt.group_id
                WHERE mt.meeting_date='$month'");
                
        return $query->result_array();
    }

}
?>