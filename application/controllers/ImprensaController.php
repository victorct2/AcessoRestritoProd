<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ImprensaController extends CI_Controller {

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

		$this->load->model('imprensaDao_model','imprensaDao');

	}

	public function viewImprensa(){

		$open['assetsBower'] = '';		
        $open['assetsCSS'] = '';
        $this->load->view('include/openDoc',$open);

		$data['mainNav'] = 'imprensa';
		$data['subMainNav'] = 'imprensa';
		$data['imprensa'] = $this->imprensaDao->selectImprensa();
		$this->load->view('paginas/imprensa/imprensa',$data);

		$footer['assetsJsBower'] = 'ckeditor/ckeditor.js';        
        $footer['assetsJs'] = 'imprensa/imprensa-home.js';
        $this->load->view('include/footer',$footer);
	}
	
	public function alterarImprensa(){
		$idImprensa = $this->input->post('idImprensa');
		$descricaoCompleta = $this->input->post('descricaoCompleta');
		$mensagem = array();

		if(empty($descricaoCompleta)){
			$mensagem[] = 'A <b>DESCRIÇÃO</b> da imprensa é Obrigatória.';
		}
		if (count($mensagem) > 0) {
			$this->session->set_flashdata('mensagem',$mensagem);
			redirect(base_url() . 'ImprensaController/viewImprensa/','refresh');
		}
		else{

			/*
			** Armazenando dados do formulário no Array $data
			*/
			$data['idImprensa'] = $idImprensa;
			$data['descricao'] = $descricaoCompleta;
		
			if($this->imprensaDao->updateImprensa($data)){				
				$this->session->set_flashdata('resultado_ok','Imprensa atualizada com sucesso!');
				redirect(base_url() . 'ImprensaController/viewImprensa/','refresh');
			}
			else {				
				$this->session->set_flashdata('resultado_error','Erro ao atualizar a Imprensa!');
				redirect(base_url() . 'ImprensaController/viewImprensa/','refresh');
			}
		}	
	}

	public function viewApresentadores(){

		$open['assetsBower'] = 'datatables.net-bs/css/dataTables.bootstrap.min.css';		
        $open['assetsCSS'] = '';
        $this->load->view('include/openDoc',$open);

		$data['mainNav'] = 'imprensa';
		$data['subMainNav'] = 'apresentadores';
		$this->load->view('paginas/imprensa/listaApresentadores',$data);

		$footer['assetsJsBower'] = 'moment/min/moment.min.js,datatables.net/js/jquery.dataTables.min.js,datatables.net-bs/js/dataTables.bootstrap.min.js';        
        $footer['assetsJs'] = 'imprensa/list-apresentadores.js';
        $this->load->view('include/footer',$footer);
	}
	
	public function listaApresentadoresDataTables(){

        $fetch_data = $this->imprensaDao->make_datatables();

        $data = array();
        foreach($fetch_data as $row){			

            $sub_array = array();
            $sub_array[] = '<img src="'.base_url().'assets/img/usuarios/apresentador/'.$row->foto .'" class=" imgList" width="204" height="204" />';  
            $sub_array[] = $row->nomeCompleto;
            $sub_array[] = $row->nomeArtistico;
			$sub_array[] = $row->resumoProfissional;
            $sub_array[] = '<a href="'.base_url('ImprensaController/viewAlterarApresentador/'.$row->id).'" class="btn btn-app"><i class="fa fa-edit"></i> Alterar</a>';
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $this->imprensaDao->get_all_data(),
            "recordsFiltered" => $this->imprensaDao->get_filtered_data(),
            "data" => $data
        );
        echo json_encode($output);
	}
	
	public function viewCadastroApresentador(){

        $open['assetsBower'] = 'bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css,select2/dist/css/select2.min.css';
        $open['pluginCSS'] = 'bootstrap-fileinput/css/fileinput.min.css';
        
        $this->load->view('include/openDoc',$open);

		$data['mainNav'] = 'imprensa';
		$data['subMainNav'] = 'apresentadores';
		$this->load->view('paginas/imprensa/cadastrarApresentador',$data);	

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,select2/dist/js/select2.full.min.js,bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js';
        $footer['pluginJS'] = 'input-mask/jquery.inputmask.js,bootstrap-fileinput/js/fileinput.min.js,bootstrap-fileinput/js/fileinput_locale_pt-BR.js';
        $footer['assetsJs'] = 'imprensa/apresentadores-alterar.js';

		$this->load->view('include/footer',$footer);
	}

	function cadastrarApresentador(){

		/*echo '<pre>';
		print_r($_POST);
		echo '</pre>';
		exit();*/
		
		$nomeCompleto = $this->input->post('nomeCompleto');
		$nomeArtistico = $this->input->post('nomeArtistico');
		$resumoProfissional   = $this->input->post('resumoProfissional');
		$situacao   = $this->input->post('situacao');
		$imagens = is_array($this->input->post('listaImagem'))? $this->input->post('listaImagem') : null;
		$friendly_url = getRawUrl($nomeArtistico);
		$mensagem = array();

		if(empty($nomeArtistico)){
			$mensagem[] = 'O <b>Nome Artístico</b> precisa ser informado.';
		}

		if(empty($resumoProfissional)){
			$mensagem[] = 'O <b>Resumo Profissional</b> precisa ser informado.';
		}

		if (count($mensagem) > 0) {
			$this->session->set_flashdata('mensagem',$mensagem);
			redirect(base_url() . 'ImprensaController/viewCadastroApresentador','refresh');
		}else{

			
			@chmod('uploadImagens/arquivos/'.$imagens[0], 0777);
			$novo_nome_imagem = $friendly_url . '.' . @end(explode(".",$imagens[0]));
			@rename( 'uploadImagens/arquivos/'.$imagens[0],  'uploadImagens/arquivos/'.$novo_nome_imagem);
			
			
			$data['nomeCompleto'] = $nomeCompleto;
			$data['nomeArtistico'] = $nomeArtistico;
			$data['resumoProfissional'] = $resumoProfissional;
			$data['foto'] = $novo_nome_imagem;
			$data['situacao'] = $situacao;


			if($this->imprensaDao->insertApresentador($data)){

				
				//unlink('assets/img/usuarios/apresentador/'.$dadosAtuais[0]->imagem);
				copy('uploadImagens/arquivos/'.$novo_nome_imagem, 'assets/img/usuarios/apresentador/'.$novo_nome_imagem);
				chmod('assets/img/usuarios/apresentador/'.$novo_nome_imagem, 0777);
				unlink('uploadImagens/arquivos/'.$novo_nome_imagem);
				
                
				$this->session->set_flashdata('resultado_ok','Apresentador cadastrado com sucesso!');
				redirect(base_url() . 'ImprensaController/viewApresentadores','refresh');
			}
			else {
				$this->session->set_flashdata('resultado_error','Erro ao cadastrar o Apresentador!');
				redirect(base_url() . 'ImprensaController/viewCadastroApresentador','refresh');
			}

			
			

		}
	}


	public function viewAlterarApresentador($id){

        $open['assetsBower'] = 'bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css,select2/dist/css/select2.min.css';
        $open['pluginCSS'] = 'bootstrap-fileinput/css/fileinput.min.css';
        
        $this->load->view('include/openDoc',$open);

		$data['mainNav'] = 'imprensa';
		$data['subMainNav'] = 'apresentadores';
		$data['apresentador']=$this->imprensaDao->selectApresentador($id);
		$this->load->view('paginas/imprensa/alterarApresentador',$data);	

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,select2/dist/js/select2.full.min.js,bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js';
        $footer['pluginJS'] = 'input-mask/jquery.inputmask.js,bootstrap-fileinput/js/fileinput.min.js,bootstrap-fileinput/js/fileinput_locale_pt-BR.js';
        $footer['assetsJs'] = 'imprensa/apresentadores-alterar.js';

		$this->load->view('include/footer',$footer);
	}

	function alterarApresentador(){
	
		$id = $this->input->post('id');
		$nomeCompleto = $this->input->post('nomeCompleto');
		$nomeArtistico = $this->input->post('nomeArtistico');
		$resumoProfissional   = $this->input->post('resumoProfissional');
		$situacao   = $this->input->post('situacao');
		$imagens = is_array($this->input->post('listaImagem'))? $this->input->post('listaImagem') : null;
		$friendly_url = getRawUrl($nomeArtistico);
		$dadosAtuais = $this->imprensaDao->selectApresentador($id);
		$mensagem = array();

		if(empty($nomeArtistico)){
			$mensagem[] = 'O <b>Nome Artístico</b> precisa ser informado.';
		}

		if(empty($resumoProfissional)){
			$mensagem[] = 'O <b>Resumo Profissional</b> precisa ser informado.';
		}

		if (count($mensagem) > 0) {
			$this->session->set_flashdata('mensagem',$mensagem);
			redirect(base_url() . 'ImprensaController/viewAlterarApresentador/'.$id,'refresh');
		}else{

			if(!empty($imagens)){
				@chmod('uploadImagens/arquivos/'.$imagens[0], 0777);
				$novo_nome_imagem = $friendly_url . '.' . @end(explode(".",$imagens[0]));
				@rename( 'uploadImagens/arquivos/'.$imagens[0],  'uploadImagens/arquivos/'.$novo_nome_imagem);
			}else{
				if($nomeArtistico !== $dadosAtuais[0]->nomeArtistico){
					$novo_nome_imagem = $friendly_url . '.' . end(explode(".",$dadosAtuais[0]->foto));
				}else{
					$novo_nome_imagem = $dadosAtuais[0]->foto;
				}
			}

			$data['id'] = $id;
			$data['nomeCompleto'] = $nomeCompleto;
			$data['nomeArtistico'] = $nomeArtistico;
			$data['resumoProfissional'] = $resumoProfissional;
			$data['foto'] = $novo_nome_imagem;
			$data['situacao'] = $situacao;

			if($this->imprensaDao->updateApresentador($data)){

				if(!empty($imagens)){
					@unlink('assets/img/usuarios/apresentador/'.$dadosAtuais[0]->imagem);
					@copy('uploadImagens/arquivos/'.$novo_nome_imagem, 'assets/img/usuarios/apresentador/'.$novo_nome_imagem);
					@chmod('assets/img/usuarios/apresentador/'.$novo_nome_imagem, 0777);
					@unlink('uploadImagens/arquivos/'.$novo_nome_imagem);
				}else{
					rename('assets/img/usuarios/apresentador/'.$dadosAtuais[0]->foto,'assets/img/usuarios/apresentador/'.$novo_nome_imagem);
				}
                
				$this->session->set_flashdata('resultado_ok','Apresentador cadastrado com sucesso!');
				redirect(base_url() . 'ImprensaController/viewApresentadores/'.$id,'refresh');
			}
			else {
				$this->session->set_flashdata('resultado_error','Erro ao cadastrar o Apresentador!');
				redirect(base_url() . 'ImprensaController/viewAlterarApresentador/'.$id,'refresh');
			}

		}
	}
	

}
