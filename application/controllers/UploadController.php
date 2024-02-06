<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UploadController extends CI_Controller {

    function __construct() {
		parent:: __construct();

		if(!$this->session->userdata('logged_in')){
			redirect(base_url() . 'HOME', 'refresh');
		}

	}


	function uploadImagens(){

		$this->load->library("upload");
		$this->upload->initialize(array(
			"upload_path" => './uploadImagens/arquivos/',
			'allowed_types' => 'png|jpg|jpeg|png|gif|psd',
			"overwrite" => FALSE,
			"max_filename" => 0,
			"encrypt_name" => TRUE,
		));

		$successful = $this->upload->do_upload('userfile');
		$fileName = '';

		if($successful)
		{
			$data = $this->upload->data();
			$image_file = $data['file_name'];
			$msg = "<p>File: {$image_file}</p>";
			$fileName = $image_file;
			//$this->data_models->update($this->data->INFO, array("image" => $image_file));
		} else {

			$msg = $this->upload->display_errors();
		}

		echo json_encode(['result' => $successful, 'message' => $msg,'file_name'=>$fileName]);

	}

	function uploadImagensMultiple(){

		$this->load->library("upload");
		$this->upload->initialize(array(
			"upload_path" => './uploadImagens/arquivos/',
			'allowed_types' => 'png|jpg|jpeg|png|gif|psd',
			"overwrite" => FALSE,
			"max_filename" => 0,
			"encrypt_name" => TRUE,
			'multi' => 'all'
		));

		$successful = $this->upload->do_upload('userfile');
		$fileName = array();
		$data = array();

		if($successful)
		{
		$data[] = $this->upload->data();
		$resp =  is_array($data);

		if(count($data[0])>6){
			foreach ($data as $key => $value) {
				$fileName[] = $value['file_name'];
			}
		}else{
			foreach ($data as $key => $value) {
				if(count($value)> 1){
					foreach ($value as $file) {
						$fileName[] = $file['file_name'];
					}
				}
			}
		}



		} else {

			$msg = $this->upload->display_errors();
		}

		echo json_encode(['result' => $successful, 'file_name'=>$fileName]);

	}

	function uploadVideos(){

		$this->load->library("upload");
		 $this->upload->initialize(array(
				 "upload_path" => './uploadVideos/arquivos/',
				 'allowed_types' => 'mp4|mov|dif|flv|mkv|wmv|rmvb|vob|mpg|dv|mxf',
				 "overwrite" => FALSE,
				 "max_filename" => 0,
				 "encrypt_name" => TRUE,
		 ));

		 $successful = $this->upload->do_upload('userfile');
		 $fileName = '';

		 if($successful)
		 {
			 $data = $this->upload->data();
			 $image_file = $data['file_name'];
			 $msg = "<p>File: {$image_file}</p>";
			 $fileName = $image_file;
			 //$this->data_models->update($this->data->INFO, array("image" => $image_file));
		 } else {

			 $msg = $this->upload->display_errors();
		 }

		 echo json_encode(['result' => $successful, 'message' => $msg,'file_name'=>$fileName]);
	}

	function uploadArquivos(){

		$this->load->library("upload");
		 $this->upload->initialize(array(
				 "upload_path" => './uploadArquivos/arquivos/',
				 'allowed_types' => 'csv',
				 "overwrite" => FALSE,
				 "max_filename" => 0,
				 "encrypt_name" => TRUE,
		 ));

		 $successful = $this->upload->do_upload('userfile');
		 $fileName = '';

		 if($successful)
		 {
			 $data = $this->upload->data();
			 $image_file = $data['file_name'];
			 $msg = "<p>File: {$image_file}</p>";
			 $fileName = $image_file;
			 //$this->data_models->update($this->data->INFO, array("image" => $image_file));
		 } else {

			 $msg = $this->upload->display_errors();
		 }

		 echo json_encode(['result' => $successful, 'message' => $msg,'file_name'=>$fileName]);

	}

	function uploadClosedCaption(){

		$this->load->library("upload");
		 $this->upload->initialize(array(
				 "upload_path" => './uploadArquivos/arquivos/',
				 'allowed_types' => 'vtt',
				 "overwrite" => FALSE,
				 "max_filename" => 0,
				 "encrypt_name" => TRUE,
		 ));

		 $successful = $this->upload->do_upload('userfile');
		 $fileName = '';

		 if($successful)
		 {
			 $data = $this->upload->data();
			 $image_file = $data['file_name'];
			 $msg = "<p>File: {$image_file}</p>";
			 $fileName = $image_file;
			 //$this->data_models->update($this->data->INFO, array("image" => $image_file));
		 } else {

			 $msg = $this->upload->display_errors();
		 }

		 echo json_encode(['result' => $successful, 'message' => $msg,'file_name'=>$fileName]);

	}

	function uploadPodcast(){

		$this->load->library("upload");
		 $this->upload->initialize(array(
				 "upload_path" => './uploadArquivos/arquivos/',
				 'allowed_types' => '*',
				 "overwrite" => FALSE,
				 "max_filename" => 0,
				 "encrypt_name" => TRUE,
		 ));

		 $successful = $this->upload->do_upload('userfile');
		 $fileName = '';

		 if($successful)
		 {
			 $data = $this->upload->data();
			 $image_file = $data['file_name'];
			 $msg = "<p>File: {$image_file}</p>";
			 $fileName = $image_file;
			 //$this->data_models->update($this->data->INFO, array("image" => $image_file));
		 } else {

			 $msg = $this->upload->display_errors();
		 }

		 echo json_encode(['result' => $successful, 'message' => $msg,'file_name'=>$fileName]);

	}



}
