<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ParceriasInstitucionaisController extends CI_Controller {

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
		$this->load->model('parceriasInstitucionaisDao_model','parceriasInstitucionaisDao');
	}

	

	public function viewLista(){

		$open['assetsBower'] = 'datatables.net-bs/css/dataTables.bootstrap.min.css';				
		$open['pluginCSS'] = 'jqueryUi/jquery-ui.min.css,bootstrap-fileinput/css/fileinput.min.css';
        $this->load->view('include/openDoc',$open);

		$data['mainNav'] = 'parceriasInstitucionais';
		$data['subMainNav'] = 'lista';
		$this->load->view('paginas/parceriasInstitucionais/lista',$data);

		$footer['assetsJsBower'] = 'moment/min/moment.min.js,datatables.net/js/jquery.dataTables.min.js,datatables.net-bs/js/dataTables.bootstrap.min.js,ckeditor/ckeditor.js';                
        $footer['pluginJS'] = 'jqueryUi/jquery-ui.min.js,bootstrap-fileinput/js/fileinput.min.js,bootstrap-fileinput/js/fileinput_locale_pt-BR.js';
        $footer['assetsJs'] = 'parceriasInstitucionais/lista.js';
        $this->load->view('include/footer',$footer);
	}
	
	public function listaParceriasInstitucionaisDataTables(){

        $fetch_data = $this->parceriasInstitucionaisDao->make_datatables();

        $data = array();
        foreach($fetch_data as $row){			

			$status = '';
            if($row->status == 'S'){
                $status = '<span class="label bg-green">ATIVO</span><br>';
            }else if($row->status == 'N'){
                $status = '<span class="label bg-red">INATIVO</span><br>';
			}
			$btnChamado = '<a id="'.$row->idParceirosInstitucionais.'" data-toggle="modal" data-target="#modal-alterarParceiroInstitucional" class="btn btn-app bg-orange"><i class="fa fa-tv"></i> Alterar</a>';


            $sub_array = array();            
            $sub_array[] = '<img src="'.IMAGEM_PARCEIRO_INST.$row->image.'" class="img-rounded  imgList" width="220" height="130" />';
            $sub_array[] = $row->title;
			$sub_array[] = $row->descricao;
			$sub_array[] = $row->link;
			$sub_array[] = $status;
			$sub_array[] = $btnChamado.'<a href="'.base_url('ParceriasInstitucionaisController/apagarParceiroInstitucional/'.$row->idParceirosInstitucionais).'" class="btn btn-app"><i class="fa fa-trash"></i> Excluir</a>';
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $this->parceriasInstitucionaisDao->get_all_data(),
            "recordsFiltered" => $this->parceriasInstitucionaisDao->get_filtered_data(),
            "data" => $data
        );
        echo json_encode($output);
    }


	public function modalCadastroParceiroInstitucional(){
		$this->load->view('paginas/parceriasInstitucionais/modalCadastroParceiroInstitucional');		
	}

	public function cadastrarParceiroInstitucional(){

		$title = $this->input->post('titulo');
		$descricao = $this->input->post('descricao');
		$link = $this->input->post('link');
		$status = $this->input->post('status');
		$imagens = is_array($this->input->post('listaImagem'))? $this->input->post('listaImagem') : null;
		$mensagem = array();
		$friendly_url = getRawUrl($title);

		if(empty($title)){
			$mensagem[] = 'O <b>TÍTULO</b> é Obrigatório.';
		}else{
			$nome_existente = $this->parceriasInstitucionaisDao->verificarParceiroInsitucional($title);
			if (count($nome_existente) > 0){
				$mensagem[] = 'o parceiro <b>'.$title.'</b> já foi cadastrado.';
			}
		}
		if(empty($descricao)){
			$mensagem[] = 'O <b>DESCRIÇÃO</b> é Obrigatório.';
		}
		if(empty($link)){
			$mensagem[] = 'O <b>LINK</b> é Obrigatório.';
		}

		if (count($mensagem) > 0) {
			$this->session->set_flashdata('mensagem',$mensagem);
			redirect(base_url() . 'ParceriasInstitucionaisController/viewLista/','refresh');
		}
		else{

			//@chmod('uploadImagens/arquivos/'.$imagens[0], 0777);
			$novo_nome_imagem = $friendly_url . '.' . @end(explode(".",$imagens[0]));
			rename('uploadImagens/arquivos/'.$imagens[0], 'uploadImagens/arquivos/'.$novo_nome_imagem);

			/*
			** Armazenando dados do formulário no Array $data
			*/
			$data['idParceirosInstitucionais'] = null;
			$data['title'] = $title;
			$data['descricao'] = $descricao;
			$data['image'] = $novo_nome_imagem;
			$data['link'] = $link;
			$data['status'] = $status;
		
			if($this->parceriasInstitucionaisDao->insertParceiroInstitucional($data)){
				if(!empty($novo_nome_imagem)){                  
					copy('uploadImagens/arquivos/'.$novo_nome_imagem, 'assets/img/parceirosInstitucionais/'.$novo_nome_imagem);
					chmod('assets/img/parceirosInstitucionais/'.$novo_nome_imagem, 0777);
					unlink('uploadImagens/arquivos/'.$novo_nome_imagem);
				} 				
				$this->session->set_flashdata('resultado_ok','Parceiro Institucional cadastrado com sucesso!');
				redirect(base_url() . 'ParceriasInstitucionaisController/viewLista/','refresh');
			}
			else {				
				$this->session->set_flashdata('resultado_error','Erro ao cadastrar o Parceiro Institucional!');
				redirect(base_url() . 'ParceriasInstitucionaisController/viewLista/','refresh');
			}
		}	
	}

	public function modalAlterarParceiroInstitucional(){
		$idParceirosInstitucionais = $this->input->post('idParceirosInstitucionais');
        $data['parceiroInstitucional'] = $this->parceriasInstitucionaisDao->selectParceirosInstitucionais($idParceirosInstitucionais);
		$this->load->view('paginas/parceriasInstitucionais/modalAlterarParceiroInstitucional',$data);		
	}

	public function alterarParceiroInstitucional(){

		$idParceirosInstitucionais = $this->input->post('idParceirosInstitucionais');
		$title = $this->input->post('titulo');
		$descricao = $this->input->post('descricao');
		$link = $this->input->post('link');
		$status = $this->input->post('status');
		$imagens = is_array($this->input->post('listaImagem'))? $this->input->post('listaImagem') : null;
		$mensagem = array();
		$friendly_url = getRawUrl($title);

		if(empty($title)){
			$mensagem[] = 'O <b>TÍTULO</b> é Obrigatório.';
		}
		if(empty($descricao)){
			$mensagem[] = 'O <b>DESCRIÇÃO</b> é Obrigatório.';
		}
		if(empty($link)){
			$mensagem[] = 'O <b>LINK</b> é Obrigatório.';
		}

		$nome_existente = $this->parceriasInstitucionaisDao->verificarParceiroInsitucional($title);
		if (count($nome_existente) > 0){
			$mensagem[] = 'o parceiro <b>'.$title.'</b> já foi cadastrado.';
		}

		if (count($mensagem) > 0) {
			$this->session->set_flashdata('mensagem',$mensagem);
			redirect(base_url() . 'ParceriasInstitucionaisController/viewLista/','refresh');
		}
		else{

			chmod('uploadImagens/arquivos/'.$imagens[0], 0777);
			$novo_nome_imagem = $friendly_url . '.' . @end(explode(".",$imagens[0]));
			rename('uploadImagens/arquivos/'.$imagens[0], 'uploadImagens/arquivos/'.$novo_nome_imagem);

			/*
			** Armazenando dados do formulário no Array $data
			*/
			$data['idParceirosInstitucionais'] = $idParceirosInstitucionais;
			$data['title'] = $title;
			$data['descricao'] = $descricao;
			$data['image'] = $novo_nome_imagem;
			$data['link'] = $link;
			$data['status'] = $status;
		
			if($this->parceriasInstitucionaisDao->updateParceiroInstitucional($data)){	
				if(!empty($novo_nome_imagem)){                  
					copy('uploadImagens/arquivos/'.$novo_nome_imagem, 'assets/img/parceirosInstitucionais/'.$novo_nome_imagem);
					chmod('assets/img/parceirosInstitucionais/'.$novo_nome_imagem, 0777);
					unlink('uploadImagens/arquivos/'.$novo_nome_imagem);
				} 			
				$this->session->set_flashdata('resultado_ok','Parceiro Institucional alterado com sucesso!');
				redirect(base_url() . 'ParceriasInstitucionaisController/viewLista/','refresh');
			}
			else {				
				$this->session->set_flashdata('resultado_error','Erro ao alterar o Parceiro Institucional!');
				redirect(base_url() . 'ParceriasInstitucionaisController/viewLista/','refresh');
			}
		}	
	}

	public function apagarParceiroInstitucional($idParceirosInstitucionais){
		if($this->parceriasInstitucionaisDao->deleteParceiroInstitucional($idParceirosInstitucionais)){
			$this->session->set_flashdata('resultado_ok','Parceiro Institucional removido com sucesso!');
			redirect(base_url() . 'ParceriasInstitucionaisController/viewLista/','refresh');
		}else{
			$this->session->set_flashdata('resultado_error','Erro ao remover o Parceiro Institucional!');
			redirect(base_url() . 'ParceriasInstitucionaisController/viewLista/','refresh');
		}
	}

	/*================= Texto ======================================*/

	public function viewTexto(){

		$open['assetsBower'] = '';		
        $open['assetsCSS'] = '';
        $this->load->view('include/openDoc',$open);

		$data['mainNav'] = 'parceriasInstitucionais';
		$data['subMainNav'] = 'texto';
		$data['texto'] = $this->parceriasInstitucionaisDao->selectTexto();
		$this->load->view('paginas/parceriasInstitucionais/viewTexto',$data);

		$footer['assetsJsBower'] = 'ckeditor/ckeditor.js';        
        $footer['assetsJs'] = 'parceriasInstitucionais/texto.js';
        $this->load->view('include/footer',$footer);
	}

	public function alterarTexto(){

		$idParceirosInstitucionaisTexto = $this->input->post('idParceirosInstitucionaisTexto');
		$texto = $this->input->post('texto');
		$mensagem = array();


		if(empty($texto)){
			$mensagem[] = 'O <b>TEXTO</b> é Obrigatório.';
		}
		if (count($mensagem) > 0) {
			$this->session->set_flashdata('mensagem',$mensagem);
			redirect(base_url() . 'ParceriasInstitucionaisController/viewTexto/','refresh');
		}
		else{

			/*
			** Armazenando dados do formulário no Array $data
			*/
			$data['idParceirosInstitucionaisTexto'] = $idParceirosInstitucionaisTexto;
			$data['texto'] = $texto;
		
			if($this->parceriasInstitucionaisDao->updateTexto($data)){				
				$this->session->set_flashdata('resultado_ok','Texto atualizado com sucesso!');
				redirect(base_url() . 'ParceriasInstitucionaisController/viewTexto/','refresh');
			}
			else {				
				$this->session->set_flashdata('resultado_error','Erro ao atualizar o texto!');
				redirect(base_url() . 'ParceriasInstitucionaisController/viewTexto/','refresh');
			}
		}	
	}

}
