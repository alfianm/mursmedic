<?php
//-----------------------------------------------------------------------------------------------//
defined('BASEPATH') OR exit('No direct script access allowed');
//-----------------------------------------------------------------------------------------------//
class C_menu extends CI_Controller{
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	public function __construct(){
        parent::__construct();
		
		if($this->session->userdata('session_mursmedic_status') != "LOGIN"){
			redirect(site_url("index"));
		}
    }
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	public function index(){
		$this->load->view('V_menu');
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	public function logout(){
		//INSERT LOG
		$data_log = array(
			'LG_ID' => $this->M_library_module->GENERATOR_REFF(),
			'UR_ID' => $this->session->userdata("session_mursmedic_id"),
			'LG_DESC' => "LOGOUT",
			'LG_DATE' => date('Y-m-d H:i:s')
		);
		$is_log = $this->M_library_database->DB_INSERT_DATA_LOG($data_log);
		//-----------------------------------------------------------------------------------------------//
		$this->session->sess_destroy();
		redirect(site_url('index'));
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
}
//-----------------------------------------------------------------------------------------------//