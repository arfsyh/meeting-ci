<?php defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
set_include_path(APPPATH . 'third_party/' . PATH_SEPARATOR .     get_include_path());
require_once APPPATH . 'third_party/vendor/autoload.php';


class Event extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Database');
		$this->load->model('Meeting');  
	}

	public function index() 
    {
		
	}
	public function getClient()
	{
		

		$KEY_FILE_LOCATION = APPPATH . 'third_party/data/credentials.json';
		$client = new Google_Client();
		$client->setApplicationName('Google Calendar API PHP Quickstart');
		$client->setScopes(Google_Service_Calendar::CALENDAR);
		$client->setAuthConfig($KEY_FILE_LOCATION);
		$client->setAccessType('offline');
		$client->setPrompt('select_account consent');
    
		$tokenPath = APPPATH . 'third_party/data/token.json';
		if (file_exists($tokenPath)) {
			$accessToken = json_decode(file_get_contents($tokenPath), true);
			$client->setAccessToken($accessToken);
		}
	
		// If there is no previous token or it's expired.
		if ($client->isAccessTokenExpired()) {
			// Refresh the token if possible, else fetch a new one.
			if ($client->getRefreshToken()) {
				$client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
			} else {
  

				$_SESSION['authURL'] = $client->createAuthUrl();
				redirect('coba/oauth',$_SESSION);
				
				// Request authorization from the user.
				//$authUrl = $client->createAuthUrl();
				/*
				printf("Open the following link in your browser:\n%s\n", $authUrl);
				print 'Enter verification code: ';
				$authCode = trim(fgets(STDIN)); */
  
				// Exchange authorization code for an access token.
			   
				$accessToken = $client->fetchAccessTokenWithAuthCode($_SESSION['authCode']);
				$client->setAccessToken($accessToken);
  
				// Check to see if there was an error.
				if (array_key_exists('error', $accessToken)) {
					throw new Exception(join(', ', $accessToken));
				}
			}
			// Save the token to a file.
			if (!file_exists(dirname($tokenPath))) {
				mkdir(dirname($tokenPath), 0700, true);
			}
			file_put_contents($tokenPath, json_encode($client->getAccessToken()));
		}
		return $client;
	}
    public function id($id){
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
        $data['meetings'] = $this->Meeting->getMeeting($id);
        foreach($this->Meeting->getMeeting($id) as $key=> $val){
            $idatt = $val['meeting_id'];
        }
        
        $data['att']= $this->Database->getAttandance($idatt);
        $this->load->view('Event', $data);

	}
	public function tampil($mi){
		foreach($this->Meeting->getMeeting($mi) as $a){
		  $summarry = $a['meeting_name'];
		}
		return $summarry;
	  
	  }
	public function Delete($mi){
		$client = $this->getClient();
		$service = new Google_Service_Calendar($client);

		$events = $service->events->listEvents('primary');



			while(true) {
				foreach ($events->getItems() as $event) {
				if( $event->getSummary() == $this->tampil($mi)){
					$event = $service->events->get('primary', $event->getId());

					$service->events->delete('primary', $event->getId());
			
				}
				}
				$pageToken = $events->getNextPageToken();
				if ($pageToken) {
				$optParams = array('pageToken' => $pageToken);
				$events = $service->events->listEvents('primary', $optParams);
				} else {
				break;
				}
			}
			
	$this->Meeting->DeleteOldAtt($mi);
	$this->Meeting->delMett($mi);
	echo "<script>alert('Event Telah Dihapus.');window.location.href='".Site_url()."';</script>" ;



	}


    public function EditEvent($id){
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
        $data['meetings'] = $this->Meeting->getMeeting($id);
        foreach($this->Meeting->getMeeting($id) as $key=> $val){
			$pisah1  = explode('-',$val['meeting_date']);
			$larik1 = array($pisah1[0],$pisah1[1],$pisah1[2]);
			$satukan1 = implode('/',$larik1);
		}
		$data['tanggal']= $satukan1;
		//var_dump($ate) ;
        $this->load->view('createEvent', $data);

	}
	public function Update(){
		$client = $this->getClient();
		$service = new Google_Service_Calendar($client);
		$events = $service->events->listEvents('primary');
		$mi = $_POST['mi'];

		$this->DeleteOldAtt($mi);
		$groupID = $_POST['prodi_name'];
		$event_title = $_POST['event-title'];
		$event_place = $_POST['place'];
		
		$event_start_time = $_POST['event-start-time'];
		$event_end_time = $_POST['event-end-time'];
		$event_description = $_POST['event-description'];

		$pisah1  = explode('/',$event_start_time);
		$larik1 = array($pisah1[0],$pisah1[1],$pisah1[2]);
		$satukan1 = implode('-',$larik1);

		$pisah2 = explode('/',$event_end_time);
		$larik2 = array($pisah2[0],$pisah2[1],$pisah2[2]);
		$satukan2 = implode('-',$larik2);


		//mengubah date sesuai format GCalc API
		$eventStartTime = str_replace(" ", "T", $satukan1).":00+07:00";
		$eventEndTime = str_replace(" ", "T", $satukan2).":00+07:00";
		//mengubah jadi date saja
		$meetingDate = substr($event_start_time, 0, 10);
		//mengubah jadi time saja
		$meetingStart = substr($event_start_time, 11, 5).":00";
		$meetingEnd = substr($event_end_time, 11, 5).":00";
		$email = $_POST['email'];

		while(true) {
			foreach ($events->getItems() as $event) {
				if( $event->getSummary() == $this->tampil($mi)){
				
				$event = $service->events->get('primary', $event->getId());
				$attendee1 = new Google_Service_Calendar_EventAttendee();
				$attendee1->setResponseStatus('needsAction');
				foreach($email as $v){
				$attendee1->setEmail($v);}
				$attendees = array($attendee1);
				$event->setAttendees($attendees);

				$event->setSummary($event_title);
				$event->setLocation($event_place);

				$start = new Google_Service_Calendar_EventDateTime();
				$start->setDateTime($eventStartTime);  
				$event->setStart($start);
				$end = new Google_Service_Calendar_EventDateTime();
				$end->setDateTime($eventEndTime);  
				$event->setEnd($end);
				$updatedEvent = $service->events->update('primary', $event->getId(), $event);
				echo $updatedEvent->getUpdated();

			}
		}
		$pageToken = $events->getNextPageToken();
		if ($pageToken) {
			$optParams = array('pageToken' => $pageToken);
			$events = $service->events->listEvents('primary', $optParams);
		} else {
			break;
		}
		}
		$this->UpdateMeeting($groupID, $event_title, $meetingDate, $meetingStart, $meetingEnd, $event_place,$mi,$email);

	}

	public function DeleteOldAtt($mi){
		$this->db->query("DELETE FROM meeting_attendance
			WHERE meeting_id='$mi'");
	  }

	  public function UpdateMeeting($groupID, $event_title, $meetingDate, $meetingStart, $meetingEnd, $event_place,$mi,$email){
		$this->db->query("UPDATE meetings
				  SET group_id='$groupID', meeting_name='$event_title', meeting_date='$meetingDate', meeting_start='$meetingStart', meeting_end='$meetingEnd', meeting_place='$event_place'
				  WHERE meeting_id='$mi'");
		//$this->createAttendanceLists($groupID);
		$this->createAttendanceLists($groupID, $email);
	  }

	  public function createAttendanceLists($groupID, $email){
		foreach($this->getEmailSelected($groupID) as $x){
			foreach($this->Meeting->getMaxRowsAndGroupIDOFMeetings($groupID) as $c){
				foreach($email as $e){
					if($e == $x['member_email']){
					  $this->db->query("INSERT INTO meeting_attendance (meeting_id, member_id, group_id, member_name)
						  VALUES ('$c[meeting_id]','$x[member_id]','$groupID','$x[member_name]')");
					 
					}
				}
				
			}
		}	
	}

	public function getEmailSelected($groupID){
		return $this->db->query("SELECT mb.member_name, mb.member_id, mb.member_email
				  FROM meeting_groups mg JOIN members mb JOIN group_members gm
				  ON mg.group_id=gm.group_id 
				  AND mb.member_id=gm.member_id
				  WHERE mg.group_id='$groupID'")->result_array(); 
	  }

	

}