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
		$this->load->model('noticiasDao_model');
		$this->load->model('AvisosDao_model');
	    $this->load->model('loginDao_model');	
		
		

	}
	public function index($offset=0){
		/* $this->load->model('loginDao_model');	
		$loginUser = $this->loginDao_model->loginUser($data);
		 if($loginUser[0]->password_alterado !='S')  {

		redirect(base_url().'AlterarSenha/alterarSenha','refresh');
	}*/

		$this->load->view('include/openDoc');

		$limite = 8;				
		
		$data['listAvisos'] = $this->AvisosDao_model->selectAllAvisos('',$limite,$offset);
		

		/*
		** Paginação
		*/
		$this->load->library("pagination");
		
		$config['base_url'] = base_url().'Home/index/';
		$config['total_rows'] = $this->AvisosDao_model->countAllAvisos('',$limite,$offset);		
		$config['per_page'] = $limite;
		$config['uri_segment'] = 3;
		$config['num_links'] = 5;

		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] ="</ul>";
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";
		$config['prev_link'] = '« Anterior';		
		$config['next_link'] = 'Próximo »';			
		$config['last_link'] = 'Último'; 
		$config['first_link'] = 'Primeiro';

		$this->pagination->initialize($config);
		$data['paginacao'] = $this->pagination->create_links();	
		$data['logos'] = $this->noticiasDao_model->listarLogos();

		
		$data['mainNav'] = 'home';
		$data['subMainNav'] = '';
		$this->load->view('index',$data);	

		$footer['assetsJsBower'] = 'ckeditor/ckeditor.js';
		$footer['assetsJs'] = 'home.js';
		$this->load->view('include/footer',$footer);
	}

	public function buscar($offset=0){	
		$data['titulo'] = "COOPAS";	
		$limite = 8;   
	$this->load->view('include/openDoc');

	if(empty($_GET)){				
			$dadosBusca = $this->session->userdata('palavraChave');
		
		}else if($_GET !=''){

			if($this->input->get('palavraChave') =='' ){						
				redirect(base_url() . 'Home','refresh'); 
			}							
			$palavraChave =  $this->input->get('palavraChave');		
			
			/*
			** Salvando o filtro de busca na Sessão pra paginação
			*/
			$filtro_busca = array(
				'palavraChave' => $palavraChave			
			);
			$this->session->set_userdata($filtro_busca);
			
			$dadosBusca = $palavraChave;
		
		}		
		$data['palavraChave'] = $dadosBusca;
		$data['listAvisos'] = $this->AvisosDao_model->selectAllAvisos($dadosBusca,$limite,$offset);


		$this->load->library("pagination");

		$config['base_url'] = base_url().'Home/buscar/';
		$config['total_rows'] = $this->AvisosDao_model->countAllAvisos($dadosBusca,$limite,$offset);		
		$config['per_page'] = $limite;
		$config['uri_segment'] = 3;
		$config['num_links'] = 5;

		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] ="</ul>";
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";
		$config['prev_link'] = '« Anterior';		
		$config['next_link'] = 'Próximo »';			
		$config['last_link'] = 'Último';

		$this->pagination->initialize($config);
		$data['paginacao'] = $this->pagination->create_links();	
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


	public function avisoAberto($friendly_url){		
		$this->load->view('include/openDoc');
		$data['avisos'] = $this->AvisosDao_model->selectAvisoByFriendly_url($friendly_url);		
		$data['titulo'] = $data['avisos'][0]->descricao;	
		$data['logos'] = $this->noticiasDao_model->listarLogos();	
		$this->load->view('paginas/noticias/noticia-aberta',$data);
		$this->load->view('include/footer');
		
	}

}
