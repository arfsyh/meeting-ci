<?php defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
set_include_path(APPPATH . 'third_party/' . PATH_SEPARATOR .     get_include_path());
require_once APPPATH . 'third_party/vendor/autoload.php';
use  PHPMailer\PHPMailer\PHPMailer;


class Coba extends CI_Controller {

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

        $this->load->view('coba', $data);
    }
    public function getattendess(){
        $id = $this->input->post('id',TRUE);
        $data = $this->Database->getGroupMembers($id);
        echo json_encode($data);
	}

	public function getAllEmailByGroup($groupID, $email){  
		$arrEmail = array();
		foreach($this->Meeting->getAllEmailByGroupMembers($groupID) as $c){
		  foreach($email as $e){
			if($e == $c['member_email']){
		  $arrEmail[] = array('email' => $c['member_email']);
			}
		  }
		}
		return $arrEmail;
	  }
	
	public function getClient($event_title,$event_place,$eventStartTime,$eventEndTime,$event_description)
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
  
				//pindahkan ke halaman ambil token sambil bawa session
				
				$_SESSION['event_title'] = $event_title;
				$_SESSION['event_place'] = $event_place;
				$_SESSION['event_start_time'] = $eventStartTime;
				$_SESSION['event_end_time'] = $eventEndTime;
				$_SESSION['event_description'] = $event_description;
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

	public function getEmailSelected($groupID){
		$query=$this->db->query("SELECT mb.member_name, mb.member_id, mb.member_email
				  FROM meeting_groups mg JOIN members mb JOIN group_members gm
				  ON mg.group_id=gm.group_id 
				  AND mb.member_id=gm.member_id
				  WHERE mg.group_id='$groupID'");
		return $query->result_array();	  
	  }

	public function createAttendanceLists($groupID, $email){
		foreach($this->getEmailSelected($groupID) as $x){
			foreach($this->Meeting->getMaxRowsAndGroupIDOFMeetings($groupID) as $c){
				foreach($email as $e){
					if($e == $x['member_email']){
					  $query = "INSERT INTO meeting_attendance (meeting_id, member_id, group_id, member_name)
						  VALUES ('$c[meeting_id]','$x[member_id]','$groupID','$x[member_name]')";
					 $this->db->query($query);
					}
				}
				
			}
		}
	}

	public function createMeeting($groupID, $meetingDate, $meetingEnd, $meetingStart, $meetingName, $meetingPlace,$email){
		if($this->Meeting->displayCountSameMeetingSchedule($groupID, $meetingDate, $meetingEnd, $meetingStart)==1){ 
		  echo "<script>alert('Sudah ada meeting yang sama');window.location.href='".base_url('coba')."';</script>" ;
		} else if ($this->Meeting->displayJumOverlapMeetingByDate($groupID, $meetingDate)==0 OR $this->Meeting->displayOverlapMeetingByTime($groupID, $meetingDate, $meetingStart)==0){
		  //echo "Nol" dan "overlap = 0";
		  //echo "\n";
		  
		
		  echo "<script>alert('Berhasil membuat event ".$meetingName."');window.location.href='".base_url()."';</script>" ;
		  
		  $this->Meeting->createNewMeeting($groupID, $meetingName, $meetingDate, $meetingStart, $meetingEnd, $meetingPlace);
		  //redirect(base_url());
		} else {
		  echo "<script>alert('Sori, ada tabrakan jadwal.');window.location.href='".base_url('coba')."';</script>" ;

		}
	  }

	public function Create(){
		
		$groupID = $this->input->post('prodi_name');
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



			$client = $this->getClient($event_title,$event_place,$eventStartTime,$eventEndTime,$event_description);
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
				'attendees' => $this->getAllEmailByGroup($groupID, $email),
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

			$this->createMeeting($groupID, $meetingDate, $meetingEnd, $meetingStart, $event_title, $event_place,$email);
			$this->createAttendanceLists($groupID, $email);
			$this->SendEmail($groupID,$event_title,$place,$event_start_time,$event_end_time,$event_description,$other);
			
	}

	public function Start(){

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

		$groupID = $this->input->post('prodi_name');
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

		
		$this->SendEmail($groupID,$event_title,$place,$event_start_time,$event_end_time,$event_description,$other);
		//$groupID = $this->input->post('prodi_name');
		/*$event_title = $this->input->post('event-title');
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
		$meetingEnd = substr($event_end_time, 11, 5).":00";*/
		//$email = $this->input->post('member');
		//$ambil = $this->getAllEmailByGroup($groupID, $email);
		
		/*echo $groupID;
		echo $event_title;
		echo $event_place;
		echo $event_description;
		echo $eventStartTime;
		echo $eventEndTime;
		echo "<br>";*/
		//var_dump($ambil);

	}
	public function oauth(){
		$data['authURL']= $_SESSION['authURL'];
		$this->load->view('oauth', $data);
	}

	public function getToken()
	{
		$authCode = $this->input->post('authCode');
		$KEY_FILE_LOCATION = APPPATH . 'third_party/data/credentials.json';
		$client = new Google_Client();
		$client->setApplicationName('Google Calendar API PHP Quickstart');
		$client->setScopes(Google_Service_Calendar::CALENDAR);
		$client->setAuthConfig($KEY_FILE_LOCATION);
		$client->setAccessType('offline');
		$client->setPrompt('select_account consent');
  
		// Load previously authorized token from a file, if it exists.
		// The file token.json stores the user's access and refresh tokens, and is
		// created automatically when the authorization flow completes for the first
		// time.
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
  
				// Exchange authorization code for an access token.
			   
				$accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
				$client->setAccessToken($accessToken);
				echo "Token Berhasil";
  
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

	public function SendEmail($groupID,$event_title,$place,$event_start_time,$event_end_time,$event_description,$other){


			
		$groupID = $groupID;
		$event_title = $event_title;
		$place = $place;
		$event_start_time = $event_start_time;
		$event_end_time = $event_end_time;
		$event_description = $event_description;
		$other = $other;

		if($place==""){
			$event_place=$other;
		}else{
			$event_place=$place;
		}
		//mengubah date sesuai format GCalc API
		$eventStartTime = str_replace(" ", "T", $event_start_time).":00+07:00";
		$eventEndTime = str_replace(" ", "T", $event_end_time).":00+07:00";
		//mengubah jadi date saja
		$meetingDate = substr($event_start_time, 0, 10);
		//mengubah jadi time saja
		$meetingStart = substr($event_start_time, 11, 5).":00";
		$meetingEnd = substr($event_end_time, 11, 5).":00";

		$email = $_POST['member'];

				require_once APPPATH . 'third_party/PHPMailer/PHPMailer.php';
				require_once APPPATH . 'third_party/PHPMailer/SMTP.php';
				require_once APPPATH . 'third_party/PHPMailer/Exception.php';

				$mail = new PHPMailer();
				
				//SMTP Settings
				$mail->isSMTP();
				$mail->SMTPAuth = true;
				$mail->SMTPSecure = "ssl";
				$mail->Host = "smtp.gmail.com";
				$mail->Port = 465;
				$mail->isHTML();
				$mail->Username = "dzitnirobi@gmail.com"; //enter you email address
				$mail->Password = 'panembahan1'; //enter you email password
				$mail->setFrom('arfyan.vira@gmail.com');
				$mail->Subject = $event_title;
				$mail->Body = "Mengharap kehadiran untuk ".$event_title." <br>Pada Tanggal : ".$meetingDate."</br> Pukul:".$meetingStart." - ".$meetingEnd;
				foreach($email as $v){
				$mail->addAddress($v);}
				//Email Settings
				$mail->send();
	}

}