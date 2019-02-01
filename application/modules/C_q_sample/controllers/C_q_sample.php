<?php
//-----------------------------------------------------------------------------------------------//
defined('BASEPATH') or exit('No direct script access allowed');
//-----------------------------------------------------------------------------------------------//
class C_q_sample extends CI_Controller
{
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	public function __construct()
	{
		parent::__construct();

		if ($this->session->userdata('session_mursmedic_status') != "LOGIN") {
			redirect(site_url("index"));
		}
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	public function index()
	{
		$this->load->view('V_q_sample');
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	public function data_download()
	{
		if ($_SERVER['REQUEST_METHOD'] != "POST") {
			echo '
				<script>
					alert("UNKNOWN COMMAND");
					window.location.href = "' . site_url('q_data') . '";
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
			->setCellValue('A1', 'No')
			->setCellValue('B1', 'Doc ID')
			->setCellValue('C1', 'Tgl')
			->setCellValue('D1', 'ID')
			->setCellValue('E1', 'Product Code')
			->setCellValue('F1', 'Label')
			->setCellValue('G1', 'SN / Batch')
			->setCellValue('H1', 'Manufdate')
			->setCellValue('I1', 'Expired Date')
			->setCellValue('J1', 'Qty')
			->setCellValue('K1', 'Status');
		//-----------------------------------------------------------------------------------------------//
		$index = 1;
		foreach ($table_data_all as $data_row) {
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A' . ($index + 1), $index)
				->setCellValue('B' . ($index + 1), $data_row->PTQE_ID)
				->setCellValue('C' . ($index + 1), $data_row->PTQE_DATE)
				->setCellValue('D' . ($index + 1), $data_row->PTQE_GID)
				->setCellValue('E' . ($index + 1), $data_row->PT_ID)
				->setCellValue('F' . ($index + 1), $data_row->PTQE_LABEL)
				->setCellValue('G' . ($index + 1), $data_row->PTQE_NO)
				->setCellValue('H' . ($index + 1), $data_row->PTQE_MANUFDATE)
				->setCellValue('I' . ($index + 1), $data_row->PTQE_EXPIRED)
				->setCellValue('J' . ($index + 1), $data_row->PTQE_QTY)
				->setCellValue('K' . ($index + 1), $data_row->PTQE_STATUS);
			$index++;
		}
		//-----------------------------------------------------------------------------------------------//
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . gmdate("D, d M Y H:i:s") . '.xls"');
		//-----------------------------------------------------------------------------------------------//
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save("php://output");
		//-----------------------------------------------------------------------------------------------//
		exit();
	}

	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
}
//-----------------------------------------------------------------------------------------------//