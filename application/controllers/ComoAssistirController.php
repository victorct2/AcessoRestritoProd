<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ComoAssistirController extends CI_Controller {

	function __construct() {
		parent:: __construct();

		if(!$this->session->userdata('logged_in')){
			redirect(base_url() . 'Login', 'refresh');
		}
		$grupos = $this->session->userdata('grupos');
        if(in_array("1", $grupos) || in_array("14", $grupos)){
        }else{
            redirect(base_url() . 'Home', 'refresh');
        }
		$this->load->model('comoAssistirDao_model','comoAssistirDao');
	}

	

	public function viewOutrosCanais(){

		$open['assetsBower'] = 'datatables.net-bs/css/dataTables.bootstrap.min.css';		
        $open['assetsCSS'] = '';
        $this->load->view('include/openDoc',$open);

		$data['mainNav'] = 'comoAssistir';
		$data['subMainNav'] = 'outrosCanais';
		$data['textoOutrosCanais'] = $this->comoAssistirDao->selectTextoOutroCanal();
		$this->load->view('paginas/comoAssistir/outrosCanais/viewOutrosCanais',$data);

		$footer['assetsJsBower'] = 'moment/min/moment.min.js,datatables.net/js/jquery.dataTables.min.js,datatables.net-bs/js/dataTables.bootstrap.min.js,ckeditor/ckeditor.js';        
        $footer['assetsJs'] = 'comoAssistir/outrosCanais/outrosCanais.js';
        $this->load->view('include/footer',$footer);
	}
	
	public function listaOutrosCanaisDataTables(){

        $fetch_data = $this->comoAssistirDao->make_datatables();

        $data = array();
        foreach($fetch_data as $row){			

			$status = '';
            if($row->status == 'S'){
                $status = '<span class="label bg-green">ATIVO</span><br>';
            }else if($row->status == 'N'){
                $status = '<span class="label bg-red">INATIVO</span><br>';
			}
			$btnChamado = '<a id="'.$row->idOutrosCanais.'" data-toggle="modal" data-target="#modal-canal" class="btn btn-app bg-orange"><i class="fa fa-tv"></i> Alterar</a>';


            $sub_array = array();            
            $sub_array[] = $row->idOutrosCanais;
            $sub_array[] = $row->canal;
			$sub_array[] = $row->link;
			$sub_array[] = $status;
			$sub_array[] = $btnChamado.'<a href="'.base_url('ComoAssistirController/apagarCanal/'.$row->idOutrosCanais).'" class="btn btn-app"><i class="fa fa-trash"></i> Excluir</a>';
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $this->comoAssistirDao->get_all_data(),
            "recordsFiltered" => $this->comoAssistirDao->get_filtered_data(),
            "data" => $data
        );
        echo json_encode($output);
    }

	public function alterarTextoOutrosCanais(){

		$idOutrosCanaisTexto = $this->input->post('idOutrosCanaisTexto');
		$texto = $this->input->post('texto');
		$mensagem = array();

		if(empty($texto)){
			$mensagem[] = 'O <b>TEXTO</b> é Obrigatório.';
		}
		if (count($mensagem) > 0) {
			$this->session->set_flashdata('mensagem',$mensagem);
			redirect(base_url() . 'ComoAssistirController/viewOutrosCanais/','refresh');
		}
		else{

			/*
			** Armazenando dados do formulário no Array $data
			*/
			$data['idOutrosCanaisTexto'] = $idOutrosCanaisTexto;
			$data['texto'] = $texto;
		
			if($this->comoAssistirDao->updateOutrosCanaisTexto($data)){				
				$this->session->set_flashdata('resultado_ok','Texto atualizada com sucesso!');
				redirect(base_url() . 'ComoAssistirController/viewOutrosCanais/','refresh');
			}
			else {				
				$this->session->set_flashdata('resultado_error','Erro ao atualizar o texto!');
				redirect(base_url() . 'ComoAssistirController/viewOutrosCanais/','refresh');
			}
		}	
	}

	public function modalCanalCadastro(){			        
		$this->load->view('paginas/comoAssistir/outrosCanais/modalCanalCadastro');							     	
	}
	
	public function modalCanal(){			        
		$idOutrosCanais = $this->input->post('idOutrosCanais');		
		$data['idOutrosCanais'] = $idOutrosCanais;
		$data['canal'] = $this->comoAssistirDao->selectCanalById($idOutrosCanais);	
		$this->load->view('paginas/comoAssistir/outrosCanais/modalCanal',$data);							     	
	}
	

	public function cadastrarCanal(){

		$canal = $this->input->post('canal');
		$link = $this->input->post('link');
		$status = $this->input->post('status');
		$mensagem = array();

		if(empty($canal)){
			$mensagem[] = 'O <b>Nome do Canal</b> é Obrigatório.';
		}
		if (count($mensagem) > 0) {
			$this->session->set_flashdata('mensagem',$mensagem);
			redirect(base_url() . 'ComoAssistirController/viewOutrosCanais/','refresh');
		}
		else{

			/*
			** Armazenando dados do formulário no Array $data
			*/
			$data['idOutrosCanais'] = null;
			$data['canal'] = $canal;
			$data['link'] = $link;
			$data['status'] = $status;
		
			if($this->comoAssistirDao->insertCanal($data)){				
				$this->session->set_flashdata('resultado_ok','Canal cadastrado com sucesso!');
				redirect(base_url() . 'ComoAssistirController/viewOutrosCanais/','refresh');
			}
			else {				
				$this->session->set_flashdata('resultado_error','Erro ao cadastrar o Canal!');
				redirect(base_url() . 'ComoAssistirController/viewOutrosCanais/','refresh');
			}
		}	
	}

	public function alterarCanal(){

		$idOutrosCanais = $this->input->post('idOutrosCanais');
		$canal = $this->input->post('canal');
		$link = $this->input->post('link');
		$status = $this->input->post('status');
		$mensagem = array();

		if(empty($canal)){
			$mensagem[] = 'O <b>Nome Canal</b> é Obrigatório.';
		}
		if (count($mensagem) > 0) {
			$this->session->set_flashdata('mensagem',$mensagem);
			redirect(base_url() . 'ComoAssistirController/viewOutrosCanais/','refresh');
		}
		else{

			/*
			** Armazenando dados do formulário no Array $data
			*/
			$data['idOutrosCanais'] = $idOutrosCanais;
			$data['canal'] = $canal;
			$data['link'] = $link;
			$data['status'] = $status;
		
			if($this->comoAssistirDao->updateCanal($data)){				
				$this->session->set_flashdata('resultado_ok','Canal atualizado com sucesso!');
				redirect(base_url() . 'ComoAssistirController/viewOutrosCanais/','refresh');
			}
			else {				
				$this->session->set_flashdata('resultado_error','Erro ao atualizar o Canal!');
				redirect(base_url() . 'ComoAssistirController/viewOutrosCanais/','refresh');
			}
		}	
	}

	function apagarCanal($id){
		if($this->comoAssistirDao->deleteCanal($id)){				
			$this->session->set_flashdata('resultado_ok','Canal apagado com sucesso!');
			redirect(base_url() . 'ComoAssistirController/viewOutrosCanais/','refresh');
		}
		else {				
			$this->session->set_flashdata('resultado_error','Erro ao apagar o Canal!');
			redirect(base_url() . 'ComoAssistirController/viewOutrosCanais/','refresh');
		}
	}

	/*================= OI TV ======================================*/

	public function viewOiTv(){

		$open['assetsBower'] = '';		
        $open['assetsCSS'] = '';
        $this->load->view('include/openDoc',$open);

		$data['mainNav'] = 'comoAssistir';
		$data['subMainNav'] = 'oiTv';
		$data['textoOiTv'] = $this->comoAssistirDao->selectTextoOiTv();
		$this->load->view('paginas/comoAssistir/oiTv/viewOiTv',$data);

		$footer['assetsJsBower'] = 'ckeditor/ckeditor.js';        
        $footer['assetsJs'] = 'comoAssistir/oiTv/home.js';
        $this->load->view('include/footer',$footer);
	}

	public function alterarTextoOiTv(){

		$idOiTv = $this->input->post('idOiTv');
		$texto = $this->input->post('texto');
		$mensagem = array();


		if(empty($texto)){
			$mensagem[] = 'O <b>TEXTO</b> é Obrigatório.';
		}
		if (count($mensagem) > 0) {
			$this->session->set_flashdata('mensagem',$mensagem);
			redirect(base_url() . 'ComoAssistirController/viewOiTv/','refresh');
		}
		else{

			/*
			** Armazenando dados do formulário no Array $data
			*/
			$data['idOiTv'] = $idOiTv;
			$data['texto'] = $texto;
		
			if($this->comoAssistirDao->updateOiTvTexto($data)){				
				$this->session->set_flashdata('resultado_ok','Texto atualizada com sucesso!');
				redirect(base_url() . 'ComoAssistirController/viewOiTv/','refresh');
			}
			else {				
				$this->session->set_flashdata('resultado_error','Erro ao atualizar o texto!');
				redirect(base_url() . 'ComoAssistirController/viewOiTv/','refresh');
			}
		}	
	}


	/*================= Internet ======================================*/

	public function viewInternet(){

		$open['assetsBower'] = '';		
        $open['assetsCSS'] = '';
        $this->load->view('include/openDoc',$open);

		$data['mainNav'] = 'comoAssistir';
		$data['subMainNav'] = 'internet';
		$data['textoInternet'] = $this->comoAssistirDao->selectTextoInternet();
		$this->load->view('paginas/comoAssistir/internet/viewInternet',$data);

		$footer['assetsJsBower'] = 'ckeditor/ckeditor.js';        
        $footer['assetsJs'] = 'comoAssistir/internet/home.js';
        $this->load->view('include/footer',$footer);
	}

	public function alterarTextoInternet(){

		$idInternet = $this->input->post('idInternet');
		$texto = $this->input->post('texto');
		$mensagem = array();

		if(empty($texto)){
			$mensagem[] = 'O <b>TEXTO</b> é Obrigatório.';
		}
		if (count($mensagem) > 0) {
			$this->session->set_flashdata('mensagem',$mensagem);
			redirect(base_url() . 'ComoAssistirController/viewInternet/','refresh');
		}
		else{

			/*
			** Armazenando dados do formulário no Array $data
			*/
			$data['idInternet'] = $idInternet;
			$data['texto'] = $texto;
		
			if($this->comoAssistirDao->updateInternetTexto($data)){				
				$this->session->set_flashdata('resultado_ok','Texto atualizada com sucesso!');
				redirect(base_url() . 'ComoAssistirController/viewInternet/','refresh');
			}
			else {				
				$this->session->set_flashdata('resultado_error','Erro ao atualizar o texto!');
				redirect(base_url() . 'ComoAssistirController/viewInternet/','refresh');
			}
		}	
	}

	/*================= TV Aberta ======================================*/

	public function viewTvAberta(){

		$open['assetsBower'] = '';		
        $open['assetsCSS'] = '';
        $this->load->view('include/openDoc',$open);

		$data['mainNav'] = 'comoAssistir';
		$data['subMainNav'] = 'tvAberta';
		$data['textoTvAberta'] = $this->comoAssistirDao->selectTextoTvAberta();
		$this->load->view('paginas/comoAssistir/tvAberta/viewTvAberta',$data);

		$footer['assetsJsBower'] = 'ckeditor/ckeditor.js';        
        $footer['assetsJs'] = 'comoAssistir/tvAberta/home.js';
        $this->load->view('include/footer',$footer);
	}

	public function alterarTextoTvAberta(){

		$idTvAberta = $this->input->post('idTvAberta');
		$texto = $this->input->post('texto');
		$mensagem = array();

		if(empty($texto)){
			$mensagem[] = 'O <b>TEXTO</b> é Obrigatório.';
		}
		if (count($mensagem) > 0) {
			$this->session->set_flashdata('mensagem',$mensagem);
			redirect(base_url() . 'ComoAssistirController/viewTvAberta/','refresh');
		}
		else{

			/*
			** Armazenando dados do formulário no Array $data
			*/
			$data['idTvAberta'] = $idTvAberta;
			$data['texto'] = $texto;
		
			if($this->comoAssistirDao->updateTvAbertaTexto($data)){				
				$this->session->set_flashdata('resultado_ok','Texto atualizada com sucesso!');
				redirect(base_url() . 'ComoAssistirController/viewTvAberta/','refresh');
			}
			else {				
				$this->session->set_flashdata('resultado_error','Erro ao atualizar o texto!');
				redirect(base_url() . 'ComoAssistirController/viewTvAberta/','refresh');
			}
		}	
	}
}
