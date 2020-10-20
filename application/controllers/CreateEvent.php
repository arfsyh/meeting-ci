<?php defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');


class CreateEvent extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Database');
		$this->load->model('Meeting');  
	}

	public function index() 
    {
		$jumweek = 0;
        $data = array();
		$dateAttendanceinString = Date("Y-m-d");
		
		$data['group_name'] = $this->Database->getAllGroup();
		$data['meeting_now'] = $this->Database->getAllMeetingNow($dateAttendanceinString);
		$data['jum']= $this->Meeting->displayJumAllMeetingToday($dateAttendanceinString);

		for ($i=1; $i < 8; $i++) {
			
			$date = strtotime($dateAttendanceinString);
			$date = strtotime("+".$i." day", $date);
			$meetingweek = date('Y-m-d', $date);
			$week = $this->Database->getAllMeetingNow($meetingweek);
			$jw = $this->Meeting->displayJumAllMeetingToday($meetingweek);
			$jumweek += $jw;
			foreach($week as $key=> $val){
				if($val['meeting_date']==$meetingweek){
					$data['meeting_week']= $this->Database->getAllMeetingNow($meetingweek);
				}
			}
			
		}
		$data['jumweek']= $jumweek;	

        $this->load->view('createevent', $data);
    }
    public function getattendess(){
        $id = $this->input->post('id',TRUE);
        $data = $this->Database->getGroupMembers($id);
        echo json_encode($data);
    }
}