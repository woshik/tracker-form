<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Form extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('pdf');
		// loading the suit model	
		$this->load->model('model_form');
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
		$data['scan_your_imei_or_activation_code'] = $this->lang->line('scan_your_imei_or_activation_code');
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
		$data['form_submit_message'] = $this->lang->line('form_submit_message');

		$this->load->view('form', $data);
	}

	public function submit()
	{
		$rootDOC = realpath(__DIR__ . '/../../');

		$validator = array('success' => false, 'messages' => array());

		$validate_data = array(
			array(
				'field' => 'installation_company',
				'label' => 'Installation company',
				'rules' => 'required',
				'errors' => array(
					'required' => $this->lang->line('installation_company') . ' ' . $this->lang->line('is_required')
				)
			),
			array(
				'field' => 'engineer_name',
				'label' => 'Engineer name',
				'rules' => 'required',
				'errors' => array(
					'required' => $this->lang->line('engineer_name') . ' ' . $this->lang->line('is_required')
				)
			),
			array(
				'field' => 'engineer_number',
				'label' => 'Engineer number',
				'rules' => 'required',
				'errors' => array(
					'required' => $this->lang->line('telephone_number_engineer') . ' ' . $this->lang->line('is_required')
				)
			),
			array(
				'field' => 'email_address',
				'label' => 'Email address',
				'rules' => 'required|valid_email',
				'errors' => array(
					'required' => $this->lang->line('email_address') . ' ' . $this->lang->line('is_required'),
					'valid_email' => $this->lang->line('email_address') . $this->lang->line('is_not_valid')
				)
			),
			array(
				'field' => 'email_address_2',
				'label' => 'Email address',
				'rules' => 'valid_email',
				'errors' => array(
					'valid_email' => $this->lang->line('email_address') . ' 2' . $this->lang->line('is_not_valid')
				)
			),
			array(
				'field' => 'company_name',
				'label' => 'Company name',
				'rules' => 'required',
				'errors' => array(
					'required' => $this->lang->line('company_name') . ' ' . $this->lang->line('is_required'),
				)
			),
			array(
				'field' => 'license_plate',
				'label' => 'License plate',
				'rules' => 'required',
				'errors' => array(
					'required' => $this->lang->line('license_plate') . ' ' . $this->lang->line('is_required'),
				)
			),
			array(
				'field' => 'mileage',
				'label' => 'Mileage',
				'rules' => 'required',
				'errors' => array(
					'required' => $this->lang->line('mileage') . ' ' . $this->lang->line('is_required'),
				)
			),
			array(
				'field' => 'imei_code',
				'label' => 'IMEI or Activation code',
				'rules' => 'required',
				'errors' => array(
					'required' => $this->lang->line('imei_or_activation_code') . ' ' . $this->lang->line('is_required'),
				)
			),
			array(
				'field' => 'tracker_placement',
				'label' => 'Tracker placement in vehicle',
				'rules' => 'required',
				'errors' => array(
					'required' => $this->lang->line('tracker_placement_in_vehicle') . ' ' . $this->lang->line('is_required'),
				)
			),
			array(
				'field' => 'start_block',
				'label' => 'Start Block',
				'rules' => 'required|in_list[' . $this->lang->line('yes') . ',' . $this->lang->line('no') . ']',
				'errors' => array(
					'required' => $this->lang->line('start_block') . ' ' . $this->lang->line('is_required'),
					'in_list' => $this->lang->line('start_block') . ' ' . $this->lang->line('is_required')
				)
			)
		);

		$this->form_validation->set_rules($validate_data);
		$this->form_validation->set_error_delimiters('<li>', '</li>');

		$fileUpload = (isset($_FILES['picture_of_imei_code']['name']) && !empty($_FILES['picture_of_imei_code']['name'])) ? true : false;

		if ($this->form_validation->run() === true && $fileUpload) {

			$this->config = require_once($rootDOC . '/config.php');

			$imageSRC = $this->upload();

			if ($imageSRC['picture_of_imei_code']['success']) {
				$fileName = 'IMEI-' . $this->input->post('imei_code') . '-' .  $this->input->post('license_plate') . '-' . $this->input->post('company_name') . '.pdf';
				$pdfPath = $rootDOC . '/upload/pdf/' . $fileName;

				$this->createPDF($imageSRC, $rootDOC, $pdfPath);

				// get email content
				$emailContent = $this->getEmailContent();
				$emailContent['pdf'] = $pdfPath;

				if ($this->model_form->create($emailContent)) {
					$validator['success'] = $this->sendEmail($emailContent);

					$validator['messages'] = $validator['success'] ? $this->lang->line('submit_successful') : $this->lang->line('server_error');
					$validator['success'] ? null : ($validator['error'] = TRUE);

					$validator['success'] = TRUE;
				} else {
					$validator['messages'] = $this->lang->line('server_error');
					$validator['details'] = "database error";
					$validator['error'] = TRUE;
					$validator['success'] = TRUE;
				}
			} else {
				$validator['messages'] = $this->lang->line('server_error');
				$validator['details'] = "image not upload";
				$validator['error'] = TRUE;
				$validator['success'] = TRUE;
			}

			$this->removeImage($imageSRC);
		} else {
			$validator['success'] = false;
			foreach ($_POST as $key => $value) {
				$validator['messages'][$key] = form_error($key);
			}

			$validator['messages']['picture_of_imei_code'] = $fileUpload ? '' : '<li>' . $this->lang->line('upload_jpg_or_png_file') . '</li>';
		}

		echo json_encode($validator);
	}

	private function upload()
	{
		$result_array = array();

		$config['upload_path'] 		= 'upload/picture/';
		$config['allowed_types'] 	= 'jpg|jpeg|JPG|JPEG';
		$config['file_name']		= strtoupper(md5(uniqid(mt_rand(), true)));
		$config['max_size']			= 5000;
		$config['encrypt_name']		= true;

		$this->load->library('upload', $config);

		$file = $_FILES;

		foreach ($file as $key => $value) {

			if (!$this->upload->do_upload($key)) {
				$result_array[$key]['success'] = false;
			} else {
				$uploadedImage = $this->upload->data();

				if ($this->compressImage($uploadedImage['full_path'], $uploadedImage['full_path'], 40)) {
					$result_array[$key]['url'] = $this->upload->data('full_path');
					$result_array[$key]['success'] = true;
				} else {
					$result_array[$key]['success'] = false;
				}
			}
		}

		return $result_array;
	}

	private function compressImage($source, $destination, $quality)
	{
		$info = getimagesize($source);

		if ($info['mime'] == 'image/jpeg')
			$image = imagecreatefromjpeg($source);

		list($width_min, $height_min) = getimagesize($source);

		$newWidth = 350;

		$newHeight = ($height_min / $width_min) * $newWidth;

		$tmp_min = imagecreatetruecolor($newWidth, $newHeight);

		imagecopyresampled($tmp_min, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width_min, $height_min);

		return imagejpeg($image, $destination, $quality) ? TRUE : FALSE;
	}

	private function createPDF($imageSRC, $rootDOC, $pdfPath)
	{
		$imagePath = $rootDOC . "/assets/images/Rental-Tracker-logo.png";

		$pdf = new FPDF("P", "mm", "A4");
		$pdf->AddPage();

		$pdf->Image($imagePath, 80, 10, 50);

		$pdf->Ln(27);

		$pdf->SetFont('Helvetica', 'BU', 18);
		$pdf->Cell(0, 10, ucwords($this->lang->line('installation_form')), 0, 2, 'C');

		$pdf->Ln(4);

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

		$pdf->Cell(60, 7, $this->lang->line('email_address') . " 2", 0, 0);
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

		$pdf->Cell(0, 7,  $this->lang->line('picture_of_imei_code'), 0, 1);
		$pdf->Image($imageSRC['picture_of_imei_code']['url'], 25, null, 0, 60);

		if (isset($imageSRC['picture_of_license_plate']['url'])) {
			$pdf->Ln(3);

			$pdf->Cell(0, 7, $this->lang->line('license_plate_or_chassis_number'), 0, 1);
			$pdf->Image($imageSRC['picture_of_license_plate']['url'], 25, null, 0, 60);
		}

		$pdf->Output('F', $pdfPath);
	}

	private function sendEmail($emailContent)
	{
		$config = array();
		$config['protocol']     	= 'smtp';
		$config['smtp_host']    	= $this->config['smtp_host'];
		$config['smtp_crypto']  	= 'ssl';
		$config['smtp_port']    	= $this->config['smtp_port'];
		$config['smtp_user']    	= $this->config['smtp_user'];
		$config['smtp_pass']    	= $this->config['smtp_pass'];
		$config['mailtype']     	= 'text';
		$config['charset']      	= 'iso-8859-1';
		$config['wordwrap']     	= 'TRUE';
		$config['smtp_keepalive'] 	= TRUE;

		$this->load->library('email', $config);

		$emailAddress = $this->input->post('email_address');

		if (!empty($this->input->post('email_address_2'))) {
			$emailAddress .= ', ' . $this->input->post('email_address_2');
		}

		$this->email->from($this->config['smtp_user'], 'Rental Tracker');
		$this->email->to($emailAddress);
		$this->email->subject($emailContent['subject']);
		$this->email->message($emailContent['body']);
		$this->email->attach($emailContent['pdf']);

		return $this->email->send() ? TRUE : FALSE;
	}

	private function removeImage($imageSRC)
	{
		foreach ($imageSRC as $key => $value) {
			if (isset($value['url'])) {
				unlink($value['url']);
			}
		}
	}

	private function getEmailContent()
	{
		$subject = str_replace("%IMEI%", $this->input->post('imei_code'), $this->lang->line('email_subject'));
		$subject = str_replace("%LICENSE%", $this->input->post('license_plate'), $subject);

		$body = str_replace("(%LANG_installation_company%)", $this->lang->line('installation_company'), $this->lang->line('email_body'));
		$body = str_replace("(%installation_company%)", $this->input->post('installation_company'), $body);

		$body = str_replace("(%LANG_engineer_name%)", $this->lang->line('engineer_name'), $body);
		$body = str_replace("(%engineer_name%)", $this->input->post('engineer_name'), $body);

		$body = str_replace("(%LANG_engineer_number%)", $this->lang->line('telephone_number_engineer'), $body);
		$body = str_replace("(%engineer_number%)", $this->input->post('engineer_number'), $body);

		$body = str_replace("(%LANG_email_address%)", $this->lang->line('email_address'), $body);
		$body = str_replace("(%email_address%)", $this->input->post('email_address'), $body);

		$body = str_replace("(%LANG_email_address_2%)", $this->lang->line('email_address'), $body);
		$body = str_replace("(%email_address_2%)", $this->input->post('email_address_2'), $body);

		$body = str_replace("(%LANG_company_name%)", $this->lang->line('company_name'), $body);
		$body = str_replace("(%company_name%)", $this->input->post('company_name'), $body);

		$body = str_replace("(%LANG_order_number%)", $this->lang->line('order_number'), $body);
		$body = str_replace("(%order_number%)", $this->input->post('order_number'), $body);

		$body = str_replace("(%LANG_license_plate%)", $this->lang->line('license_plate'), $body);
		$body = str_replace("(%license_plate%)", $this->input->post('license_plate'), $body);

		$body = str_replace("(%LANG_mileage%)", $this->lang->line('mileage'), $body);
		$body = str_replace("(%mileage%)", $this->input->post('mileage'), $body);

		$body = str_replace("(%LANG_imei_code%)", $this->lang->line('imei_or_activation_code'), $body);
		$body = str_replace("(%imei_code%)", $this->input->post('imei_code'), $body);

		$body = str_replace("(%LANG_start_block%)", $this->lang->line('start_block'), $body);
		$body = str_replace("(%start_block%)", $this->input->post('start_block'), $body);

		$body = str_replace("(%LANG_tracker_placement%)", $this->lang->line('tracker_placement_in_vehicle'), $body);
		$body = str_replace("(%tracker_placement%)", $this->input->post('tracker_placement'), $body);

		return array(
			'subject' => $subject,
			'body' => $body
		);
	}
}
