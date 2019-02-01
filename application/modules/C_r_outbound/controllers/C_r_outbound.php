<?php
//-----------------------------------------------------------------------------------------------//
defined('BASEPATH') OR exit('No direct script access allowed');
//-----------------------------------------------------------------------------------------------//
class C_r_outbound extends CI_Controller{
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
		$this->load->view('V_r_outbound');
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
					window.location.href = "'.site_url('r_outbound').'";
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
			->setCellValue('B1','Doc ID')
			->setCellValue('C1','Tgl Kirim')
			->setCellValue('D1','Distributor')
			->setCellValue('E1','DN Number')
			->setCellValue('F1','Order No')
			->setCellValue('G1','Truck Type')
			->setCellValue('H1','Ekspedisi')
			->setCellValue('I1','Seal No')
			->setCellValue('J1','Total Qty')
			->setCellValue('K1','');
		//-----------------------------------------------------------------------------------------------//
		$index = 1;
		foreach($table_data_all as $data_row){
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.($index+1),$index)
				->setCellValue('B'.($index+1),$data_row->PTOD_ID)
				->setCellValue('C'.($index+1),$data_row->PTOD_TGL_KIRIM)
				->setCellValue('D'.($index+1),$data_row->DR_ID)
				->setCellValue('E'.($index+1),$data_row->PTOD_DO_NO)
				->setCellValue('F'.($index+1),$data_row->PTOD_ORDER_NO)
				->setCellValue('G'.($index+1),$data_row->PTOD_TRUCK_TYPE)
				->setCellValue('H'.($index+1),$data_row->EI_ID)
				->setCellValue('I'.($index+1),$data_row->PTOD_SEAL_NO)
				->setCellValue('J'.($index+1),$data_row->PTOD_QTY_TOTAL)
				->setCellValue('K'.($index+1),"");
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
	public function detail(){
		$this->load->view('V_r_outbound_detail');
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
}
//-----------------------------------------------------------------------------------------------//
