<?php
//-----------------------------------------------------------------------------------------------//
defined('BASEPATH') OR exit('No direct script access allowed');
//-----------------------------------------------------------------------------------------------//
class C_md_storage extends CI_Controller{
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
		$this->load->view('V_md_storage');
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	public function data_download(){
		if($_SERVER['REQUEST_METHOD']!="POST"){
			echo '
				<script>
					alert("UNKNOWN COMMAND");
					window.location.href = "'.site_url('md_storage').'";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		$table_data_all = unserialize(base64_decode($this->input->post('table_data_all')));
		//var_dump($table_data_all);die();
		//-----------------------------------------------------------------------------------------------//
		$objPHPExcel = new PHPExcel();
		//-----------------------------------------------------------------------------------------------//
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1','No')
			->setCellValue('B1','ID');
		//-----------------------------------------------------------------------------------------------//
		$index = 1;
		foreach($table_data_all as $data_row){
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.($index+1),$index)
				->setCellValue('B'.($index+1),$data_row->SE_ID);
			$index++;
		}
		//-----------------------------------------------------------------------------------------------//
		header("Last-Modified: ".gmdate("D, d M Y H:i:s")."GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0",false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.gmdate("D, d M Y H:i:s").'.xls"');
		//-----------------------------------------------------------------------------------------------//
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
		$objWriter->save("php://output");
		//-----------------------------------------------------------------------------------------------//
		exit();
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	public function data_insert(){
		if($_SERVER['REQUEST_METHOD']!="POST"){
			echo '
				<script>
					alert("UNKNOWN COMMAND");
					window.location.href = "'.site_url('md_storage').'";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		$si_id = trim($this->input->post('si_id'));
		//-----------------------------------------------------------------------------------------------//
		$data_insert = array(
			'SE_ID' => $si_id
		);
		//-----------------------------------------------------------------------------------------------//
		$is_ok = $this->M_library_database->DB_INSERT_DATA_STORAGE($data_insert);
		//-----------------------------------------------------------------------------------------------//
		if($is_ok){
			//INSERT LOG
			$data_log = array(
				'LG_ID' => $this->M_library_module->GENERATOR_REFF(),
				'UR_ID' => $this->session->userdata("session_mursmedic_id"),
				'LG_DESC' => "INSERT STORAGE",
				'LG_DATE' => date('Y-m-d H:i:s')
			);
			$is_log = $this->M_library_database->DB_INSERT_DATA_LOG($data_log);
			//-----------------------------------------------------------------------------------------------//
			echo '
				<script>
					alert("INSERT SUCCESS");
					window.location.href = "'.site_url('md_storage').'";
				</script>
			';
			exit();
		}else{
			echo '
				<script>
					alert("INSERT FAILED, PLEASE TRY AGAIN");
					window.location.href = "'.site_url('md_storage').'";
				</script>
			';
			exit();
		}
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	public function data_update(){
		if($_SERVER['REQUEST_METHOD']!="POST"){
			echo '
				<script>
					alert("UNKNOWN COMMAND");
					window.location.href = "'.site_url('md_storage').'";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		$su_id_lastest = trim($this->input->post('su_id_lastest'));
		$su_id = trim($this->input->post('su_id'));
		//-----------------------------------------------------------------------------------------------//
		$data_update = array(
			'SE_ID' => $su_id
		);
		//-----------------------------------------------------------------------------------------------//
		$is_ok = $this->M_library_database->DB_UPDATE_DATA_STORAGE($su_id_lastest,$data_update);
		//-----------------------------------------------------------------------------------------------//
		if($is_ok){
			//INSERT LOG
			$data_log = array(
				'LG_ID' => $this->M_library_module->GENERATOR_REFF(),
				'UR_ID' => $this->session->userdata("session_mursmedic_id"),
				'LG_DESC' => "UPDATE STORAGE",
				'LG_DATE' => date('Y-m-d H:i:s')
			);
			$is_log = $this->M_library_database->DB_INSERT_DATA_LOG($data_log);
			//-----------------------------------------------------------------------------------------------//
			echo '
				<script>
					alert("UPDATE SUCCESS");
					window.location.href = "'.site_url('md_storage').'";
				</script>
			';
			exit();
		}else{
			echo '
				<script>
					alert("UPDATE FAILED, PLEASE TRY AGAIN");
					window.location.href = "'.site_url('md_storage').'";
				</script>
			';
			exit();
		}
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	public function data_delete(){
		if($_SERVER['REQUEST_METHOD']!="POST"){
			echo '
				<script>
					alert("UNKNOWN COMMAND");
					window.location.href = "'.site_url('md_storage').'";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		$sd_id = trim($this->input->post('sd_id'));
		//-----------------------------------------------------------------------------------------------//
		$is_ok = $this->M_library_database->DB_DELETE_DATA_STORAGE($sd_id);
		//-----------------------------------------------------------------------------------------------//
		if($is_ok){
			//INSERT LOG
			$data_log = array(
				'LG_ID' => $this->M_library_module->GENERATOR_REFF(),
				'UR_ID' => $this->session->userdata("session_mursmedic_id"),
				'LG_DESC' => "DELETE STORAGE",
				'LG_DATE' => date('Y-m-d H:i:s')
			);
			$is_log = $this->M_library_database->DB_INSERT_DATA_LOG($data_log);
			//-----------------------------------------------------------------------------------------------//
			echo '
				<script>
					alert("DELETE SUCCESS");
					window.location.href = "'.site_url('md_storage').'";
				</script>
			';
			exit();
		}else{
			echo '
				<script>
					alert("DELETE FAILED, PLEASE TRY AGAIN");
					window.location.href = "'.site_url('md_storage').'";
				</script>
			';
			exit();
		}
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
}
//-----------------------------------------------------------------------------------------------//
