<?php defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
set_include_path(APPPATH . 'third_party/' . PATH_SEPARATOR .     get_include_path());
require_once APPPATH . 'third_party/vendor/autoload.php';


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
	function getClient()
	{
		

		$KEY_FILE_LOCATION = APPPATH . 'third_party/data/credentials.json';
		$client = new Google_Client();
		$client->setApplicationName('Google Calendar API PHP Quickstart');
		$client->setScopes(Google_Service_Calendar::CALENDAR);
		$credentials = file_get_contents("./assets/data/credentials.json");
		echo $credentials;
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
  
				//pindahkan ke halaman ambil token sambil bawa session
				//header("location:tes_oauth.php");
				$_SESSION['event_group'] = 'Contoh';
				$_SESSION['event_title'] = 'contoh ci';
				$_SESSION['event_place'] = 'jogja';
				$_SESSION['event_start_time'] = '2020-11-01T22:00:00+07:00';
				$_SESSION['event_end_time'] = '2020-11-01T22:00:00+07:00';
				$_SESSION['event_description'] = '';
				
				// Request authorization from the user.
				//$authUrl = $client->createAuthUrl();
				$_SESSION['authURL'] = $client->createAuthUrl();
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

	public function Create(){
		
		$groupID = $this->input->post('event-group');
		$event_title = $this->input->post('event-title');
		$place = $this->input->post('event-place');
		$other = $this->input->post('other');
		if($place==""){
		  $event_place=$other;
		}else{
		  $event_place=$place;
		}
		$event_start_time = $this->input->post('event-start-time');
		$event_end_time = $this->input->post('event-end-time');
		$event_description = $this->input->post('event-description');
	  
		$pisah1  = explode('/',$event_start_time);
		$larik1 = array($pisah1[0],$pisah1[1],$pisah1[2]);
		$satukan1 = implode('-',$larik1);
	  
		$pisah2 = explode('/',$event_end_time);
		$larik2 = array($pisah2[0],$pisah2[1],$pisah2[2]);
		$satukan2 = implode('-',$larik2);
		$eventStartTime = str_replace(" ", "T", $satukan1).":00+07:00";
		$eventEndTime = str_replace(" ", "T", $satukan2).":00+07:00";
		$meetingDate = substr($event_start_time, 0, 10);
		$meetingStart = substr($event_start_time, 11, 5).":00";
		$meetingEnd = substr($event_end_time, 11, 5).":00";
		$email = $this->input->post('member');



			$client = $this->getClient();
			$service = new Google_Service_Calendar($client);

			$data = array(
				'summary' => $event_title,
				'location' => $event_place,
				'sendNotifications' => TRUE,
				'sendUpdates' => TRUE,
				'description' => $event_description,
				'start' => array(
				  'dateTime' => $eventStartTime,
				  'timeZone' => 'Asia/Jakarta',
				),
				'end' => array(
				  'dateTime' => $eventEndTime,
				  'timeZone' => 'Asia/Jakarta',
				),
				'attendees' => $this->database->getAllEmailByGroup($groupID, $email),
				'reminders' => array(
				  'useDefault' => FALSE,
				  'overrides' => array(
					array('method' => 'email', 'minutes' => 24 * 60),
					array('method' => 'popup', 'minutes' => 10),
				  ),
				),
			  );

			$event = new Google_Service_Calendar_Event($data);
			$calendarId = 'primary';
			$event = $service->events->insert($calendarId, $event);
	}

	

	public function aku(){

	}

}