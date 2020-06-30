<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Form extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('pdf');
	}

	public function index()
	{
		$data['title'] = $this->lang->line('title');
		$data['installation_form'] = $this->lang->line('installation_form');
		$data['required'] = $this->lang->line('required');
		$data['installation_company'] = $this->lang->line('installation_company');
		$data['engineer_name'] = $this->lang->line('engineer_name');
		$data['telephone_number_engineer'] = $this->lang->line('telephone_number_engineer');
		$data['email_address'] = $this->lang->line('email_address');
		$data['company_name'] = $this->lang->line('company_name');
		$data['order_number'] = $this->lang->line('order_number');
		$data['license_plate'] = $this->lang->line('license_plate');
		$data['mileage'] = $this->lang->line('mileage');
		$data['type_your_imei_or_activation_code'] = $this->lang->line('type_your_imei_or_activation_code');
		$data['start_block'] = $this->lang->line('start_block');
		$data['yes'] = $this->lang->line('yes');
		$data['no'] = $this->lang->line('no');
		$data['tracker_placement_in_vehicle'] = $this->lang->line('tracker_placement_in_vehicle');
		$data['upload_picture_of_imei_code'] = $this->lang->line('upload_picture_of_imei_code');
		$data['upload_image_of_license_plate_or_chassis_number'] = $this->lang->line('upload_image_of_license_plate_or_chassis_number');
		$data['submit'] = $this->lang->line('submit');
		$data['lang'] = $this->lang->line('lang');
		$data['send_copy_of_installation_form_to_email_address'] = $this->lang->line('send_copy_of_installation_form_to_email_address');
		$data['send_copy_of_installation_form_to_second'] = $this->lang->line('send_copy_of_installation_form_to_second');
		$data['pay_attention'] = $this->lang->line('pay_attention');
		$data['imei_or_activation_code'] = $this->lang->line('imei_or_activation_code');
		$data['important'] = $this->lang->line('important');
		$data['select_bra_qr_scanner'] = $this->lang->line('select_bra_qr_scanner');
		$data['select'] = $this->lang->line('select');

		$this->load->view('form', $data);
	}

	public function submit()
	{

		$rootDOC = realpath(__DIR__ . '/../../');
		$configFile = require_once(__DIR__ . '/../../config.php');

		$validator = array('success' => false, 'messages' => array());

		$validate_data = array(
			array(
				'field' => 'installation_company',
				'label' => 'Installation company',
				'rules' => 'required',
			),
			array(
				'field' => 'engineer_name',
				'label' => 'Engineer name',
				'rules' => 'required',
			),
			array(
				'field' => 'engineer_number',
				'label' => 'Engineer number',
				'rules' => 'required',
			),
			array(
				'field' => 'email_address',
				'label' => 'Email address',
				'rules' => 'required|valid_email',
			),
			array(
				'field' => 'email_address_2',
				'label' => 'Email address',
				'rules' => 'valid_email',
			),
			array(
				'field' => 'company_name',
				'label' => 'Company name',
				'rules' => 'required',
			),
			array(
				'field' => 'license_plate',
				'label' => 'License plate',
				'rules' => 'required',
			),
			array(
				'field' => 'mileage',
				'label' => 'Mileage',
				'rules' => 'required',
			),
			array(
				'field' => 'imei_code',
				'label' => 'IMEI or Activation code',
				'rules' => 'required',
			),
			array(
				'field' => 'tracker_placement',
				'label' => 'Tracker placement in vehicle',
				'rules' => 'required',
			)
		);

		$this->form_validation->set_rules($validate_data);
		$this->form_validation->set_error_delimiters('', '');


		$imageSRC = $this->upload();
		$fileUpload = $this->filevalidation($imageSRC);

		if ($this->form_validation->run() === true && $fileUpload) {
			$this->createPDF($imageSRC, $rootDOC);
			$this->removeImage($imageSRC);
			$validator['success'] = $this->sendEmail($configFile, $rootDOC);

			$validator['messages'] =  $validator['success'] ? $this->lang->line('submit_successful') : $this->lang->line('server_error');

			$filepath = $rootDOC . '/upload/pdf/IMEI-' . $this->input->post('imei_code') . '.pdf';

			$params = array(
				'file' => $rootDOC . '/upload/pdf/IMEI-' . $this->input->post('imei_code') . '.pdf',
				'filename' => 'IMEI-' . $this->input->post('imei_code') . '.pdf',
				'mimetype' => 'application/pdf',
				'data' => chunk_split(base64_encode(file_get_contents($filepath)))
			);

			$this->httpPost($configFile['gscript_URL'], $params);

			$this->removePDF($filepath);

			$validator['success'] = TRUE;
		} else {
			$validator['success'] = false;
			foreach ($_POST as $key => $value) {
				$validator['messages'][$key] = form_error($key);
			}

			foreach ($imageSRC as $key => $value) {

				!$value['success'] && $validator['messages'][$key] = $this->lang->line('upload_jpg_or_png_file') . ' ' . $this->lang->line('is_required');
			}
		}

		echo json_encode($validator);
	}

	private function upload()
	{
		$result_array = array();

		$config['upload_path'] 		= 'upload/picture/';
		$config['allowed_types'] 	= 'jpg|jpeg|png|JPG|JPEG|PNG';
		$config['file_name']		= strtoupper(md5(uniqid(mt_rand(), true)));
		$config['max_size']			= 5000;
		$config['encrypt_name']		= true;

		$this->load->library('upload', $config);

		$file = $_FILES;

		foreach ($file as $key => $value) {

			if ($this->upload->do_upload($key)) {
				$result_array[$key]['url'] = $this->upload->data('full_path');
				$result_array[$key]['success'] = true;
			} else {
				$result_array[$key]['success'] = false;
			}
		}

		return $result_array;
	}

	private function filevalidation($file)
	{
		if (isset($file['picture_of_imei_code'])) {
			if (isset($file['picture_of_imei_code']['success']) && $file['picture_of_imei_code']['success']) {
				if (isset($file['picture_of_license_plate'])) {
					if (isset($file['picture_of_license_plate']['success']) && $file['picture_of_license_plate']['success']) {
						return true;
					}
				}
			}
		}

		return false;
	}

	private function createPDF($imageSRC, $rootDOC)
	{
		$imagePath = $rootDOC . "/assets/images/Rental-Tracker-logo.png";

		$pdf = new FPDF("P", "mm", "A4");
		$pdf->AddPage();

		$pdf->Image($imagePath, 80, 10, 50);

		$pdf->Ln(27);

		$pdf->SetFont('Helvetica', 'BU', 18);
		$pdf->Cell(0, 10, ucwords($this->lang->line('installation_form')), 0, 2, 'C');

		$pdf->Ln(8);

		$pdf->SetFont('Helvetica', '', 12);

		$pdf->Cell(60, 7, $this->lang->line('installation_company'), 0, 0);
		$pdf->Cell(4, 7, ": ", 0, 0);
		$pdf->Cell(0, 7, $this->input->post('installation_company'), 0, 1);

		$pdf->Cell(60, 7, $this->lang->line('engineer_name'), 0, 0);
		$pdf->Cell(4, 7, ": ", 0, 0);
		$pdf->Cell(0, 7, $this->input->post('engineer_name'), 0, 1);

		$pdf->Cell(60, 7, $this->lang->line('telephone_number_engineer'), 0, 0);
		$pdf->Cell(4, 7, ": ", 0, 0);
		$pdf->Cell(0, 7, $this->input->post('engineer_number'), 0, 1);

		$pdf->Cell(60, 7, $this->lang->line('email_address'), 0, 0);
		$pdf->Cell(4, 7, ": ", 0, 0);
		$pdf->Cell(0, 7, $this->input->post('email_address'), 0, 1);

		$pdf->Cell(60, 7, $this->lang->line('email_address') . " 2 : ", 0, 0);
		$pdf->Cell(4, 7, ": ", 0, 0);
		$pdf->Cell(0, 7, $this->input->post('email_address_2'), 0, 1);

		$pdf->Cell(60, 7, $this->lang->line('company_name'), 0, 0);
		$pdf->Cell(4, 7, ": ", 0, 0);
		$pdf->Cell(0, 7, $this->input->post('company_name'), 0, 1);

		$pdf->Cell(60, 7, $this->lang->line('order_number'), 0, 0);
		$pdf->Cell(4, 7, ": ", 0, 0);
		$pdf->Cell(0, 7, $this->input->post('order_number'), 0, 1);

		$pdf->Cell(60, 7, $this->lang->line('license_plate'), 0, 0);
		$pdf->Cell(4, 7, ": ", 0, 0);
		$pdf->Cell(0, 7, $this->input->post('license_plate'), 0, 1);

		$pdf->Cell(60, 7, $this->lang->line('mileage'), 0, 0);
		$pdf->Cell(4, 7, ": ", 0, 0);
		$pdf->Cell(0, 7, $this->input->post('mileage'), 0, 1);

		$pdf->Cell(60, 7, $this->lang->line('imei_or_activation_code'), 0, 0);
		$pdf->Cell(4, 7, ": ", 0, 0);
		$pdf->Cell(0, 7, $this->input->post('imei_code'), 0, 1);

		$pdf->Cell(60, 7, $this->lang->line('start_block'), 0, 0);
		$pdf->Cell(4, 7, ": ", 0, 0);
		$pdf->Cell(0, 7, $this->input->post('start_block'), 0, 1);

		$pdf->Cell(60, 7, $this->lang->line('tracker_placement_in_vehicle'), 0, 0);
		$pdf->Cell(4, 7, ": ", 0, 0);
		$pdf->Cell(0, 7, $this->input->post('tracker_placement'), 0, 1);

		$pdf->Ln(3);

		$pdf->Cell(0, 7,  $this->lang->line('picture_of_imei_code'), 0, 1);
		$pdf->Image($imageSRC['picture_of_imei_code']['url'], 25, null, 100);

		$pdf->Ln(3);

		$pdf->Cell(0, 7, $this->lang->line('license_plate_or_chassis_number'), 0, 1);
		$pdf->Image($imageSRC['picture_of_license_plate']['url'], 25, null, 100);

		return $pdf->Output('F', $rootDOC . '/upload/pdf/IMEI-' . $this->input->post('imei_code') . '.pdf');
	}

	private function sendEmail($configFile, $rootDOC)
	{
		$success = FALSE;

		$config = array();
		$config['protocol']     	= 'smtp';
		$config['smtp_host']    	= $configFile['smtp_host'];
		$config['smtp_crypto']  	= 'ssl';
		$config['smtp_port']    	= $configFile['smtp_port'];
		$config['smtp_user']    	= $configFile['smtp_user'];
		$config['smtp_pass']    	= $configFile['smtp_pass'];
		$config['mailtype']     	= 'text';
		$config['charset']      	= 'iso-8859-1';
		$config['wordwrap']     	= 'TRUE';
		$config['smtp_keepalive'] 	= TRUE;

		$this->load->library('email', $config);

		$emailAddress = $this->input->post('email_address');

		if (!empty($this->input->post('email_address_2'))) {
			$emailAddress .= ', ' . $this->input->post('email_address_2');
		}

		$this->email->from($configFile['smtp_user'], 'Rental Tracker');
		$this->email->to($emailAddress);
		$this->email->subject('IMEI-' . $this->input->post('imei_code'));
		$this->email->attach($rootDOC . '/upload/pdf/IMEI-' . $this->input->post('imei_code') . '.pdf');

		if ($this->email->send(FALSE)) {
			$success = true;
		} else {
			$success = false;
		}

		$this->email->from($configFile['smtp_user'], 'Rental Tracker');
		$this->email->to('info@rentaltracker.nl');
		$this->email->subject('IMEI-' . $this->input->post('imei_code'));
		$this->email->attach($rootDOC . '/upload/pdf/IMEI-' . $this->input->post('imei_code') . '.pdf');


		if ($this->email->send(FALSE)) {
			$success = true;
		} else {
			$success = false;
		}

		return $success;
	}

	private function removeImage($imageSRC)
	{
		foreach ($imageSRC as $key => $value) {
			unlink($value['url']);
		}
	}

	private function removePDF($src)
	{
		unlink($src);
	}

	private function httpPost($url, $data)
	{
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($curl);
		curl_close($curl);
	}
}
