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
		


		$client = new Google_Client();
		$client->setApplicationName('Google Calendar API PHP Quickstart');
		$client->setScopes(Google_Service_Calendar::CALENDAR);
		$credentials = file_get_contents("./assets/data/credentials.json");
		echo $credentials;
		$client->setAuthConfig($credentials);
		$client->setAccessType('offline');
		$client->setPrompt('select_account consent');
    
		$tokenPath = file_get_contents("./assets/data/token.json");
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
				$_SESSION['event_start_time'] = $_POST['event-start-time'];
				$_SESSION['event_end_time'] = $_POST['event-end-time'];
				$_SESSION['event_description'] = $_POST['event-description'];
				
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
		$client = $this->getClient();
  	$service = new Google_Service_Calendar($client);

  	$data = array(
    'summary' => 'contoh',
    'location' => 'jogja',
    'sendNotifications' => TRUE,
    'sendUpdates' => TRUE,
    'description' => '',
    'start' => array(
      'dateTime' => '2020-11-01T22:00:00+07:00',
      'timeZone' => 'Asia/Jakarta',
    ),
    'end' => array(
      'dateTime' => '2020-11-01T22:00:00+07:00',
      'timeZone' => 'Asia/Jakarta',
    ),
    'attendees' => 'arfyan.vira@gmail.com',
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

}