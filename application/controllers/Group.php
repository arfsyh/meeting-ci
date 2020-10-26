<?php defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');


class Group extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Database'); 
		$this->load->model('Meeting'); 
	}

	public function index($id) 
	{
		echo $id;
    }
    public function id($id){
        $data['group_name'] = $this->Database->getAllGroup();
        $data['group'] = $this->Database->getGroupbyID($id);
        $data['member'] = $this->Database->getGroupMembers($id);
        $this->load->view('group', $data);

    }

    public function Marge(){
		$data['group_name'] = $this->Database->getAllGroup();
        $id = $this->input->post('gm');
        $data['name'] = $this->input->post('name');
        $jum = count($id);
		$data['kosong']=array();
		for ($i=0; $i < $jum; $i++) { 
					$data['member']= $this->Database->getGroupMembers($id[$i]);
					$data['kosong'] = array_merge($data['kosong'],$data['member']);
		}
        $this->load->view('marge',$data);

    }
    public function MargeSave(){
        
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
