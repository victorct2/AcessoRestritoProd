<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct() {
		parent:: __construct();

		if(!$this->session->userdata('logged_in')){
			redirect(base_url() . 'Login', 'refresh');
		}

		$this->load->model('videosDao_model');
		$this->load->model('avisosDao_model');
		$this->load->model('relatoriosDao_model');
		$this->load->model('usuariosDao_model');
	}

	
	public function index($offset=0){

		$this->load->view('include/openDoc');

		$limite = 10;

		$data['listaAvisos'] = $this->avisosDao_model->selectAvisos($limite, $offset);
		//$data['totalAcessosOnDemand'] = $this->relatoriosDao_model->totalAcessos();
		//$data['totalDownloadsOnDemand'] = $this->relatoriosDao_model->totalDownloads();

		/*
		** Paginação
		*/
		$this->load->library('pagination');
		
		$config['base_url'] = base_url().'Home/index/';
		$config['total_rows'] =$this->db->get('tbl_avisos')->num_rows();
		$config['per_page'] = $limite;
		$config['uri_segment'] = 3;
		$config['num_links'] = 5;

		$config['first_link'] = 'Primeiro';

		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';

		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

		$config['prev_link'] = '« anterior';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';

		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';

		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';

		$config['next_link'] = 'próximo »';

		$config['last_link'] = 'último';


		$this->pagination->initialize($config);
		$data['paginacao'] = $this->pagination->create_links();

		$data['mainNav'] = 'home';
		$data['subMainNav'] = '';
		$this->load->view('index',$data);	

		$footer['assetsJsBower'] = 'ckeditor/ckeditor.js';
		$footer['assetsJs'] = 'home.js';
		$this->load->view('include/footer',$footer);
	}

	public function carregarTotalAcessosOnDemand(){
		echo json_encode($this->relatoriosDao_model->totalAcessos());
	}

	public function carregarTotalDownloadsOnDemand(){
		echo json_encode($this->relatoriosDao_model->totalDownloads());
	}

    

	//$data['totalAcessosOnDemand'] = $this->relatoriosDao_model->totalAcessos();
		//$data['totalDownloadsOnDemand'] = $this->relatoriosDao_model->totalDownloads();

}
