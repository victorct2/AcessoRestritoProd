<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FigurinoController extends CI_Controller {

    function __construct() {
		parent:: __construct();

		if(!$this->session->userdata('logged_in')){
			redirect(base_url() . 'Login', 'refresh');
		}
        $grupos = $this->session->userdata('grupos');
        if(in_array("1", $grupos) || in_array("27", $grupos)){             
        }else{
            redirect(base_url() . 'Home', 'refresh');
        }

		$this->load->model('figurinoDao_model');

	}


    public function viewLista($offset=0){

		
		$open['pluginCSS'] = 'fancybox/source/jquery.fancybox.css?v=2.1.7';
        $open['assetsCSS'] = 'figurino/figurino-list.css';
        $this->load->view('include/openDoc',$open);

        $limit = 12;
        $data['listFigurino'] = $this->figurinoDao_model->listarFigurino($limit,$offset);

		/*
		** Paginação
		*/
		$this->load->library('pagination');

		$config['base_url'] = base_url().'FigurinoController/viewLista/';
		$config['total_rows'] =$this->db->get('tb_figurino')->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 3;
		$config['num_links'] = 5;

		$config['first_link'] = 'Primeiro';

		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		
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

		$data['listTipo'] = $this->figurinoDao_model->listarTipo();
		$data['mainNav'] = 'figurinos';
		$data['subMainNav'] = 'listaFigurinos';
		$this->load->view('paginas/figurino/lista',$data);	

		$footer['assetsJsBower'] = 'moment/min/moment.min.js';
		$footer['pluginJS'] = 'fancybox/source/jquery.fancybox.pack.js?v=2.1.7,fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6';
        $footer['assetsJs'] = 'figurino/figurino-home.js';
        $this->load->view('include/footer',$footer);
	}
	
	public function buscar($offset=0){

		
		$open['pluginCSS'] = 'fancybox/source/jquery.fancybox.css?v=2.1.7';
		$open['assetsCSS'] = 'figurino/figurino-list.css';
		$this->load->view('include/openDoc',$open);

		if(empty($_POST)){
			
			$data['descricao'] = $this->session->userdata('descricao');
			$data['idTipofigurino'] = $this->session->userdata('idTipofigurino');
			$data['sexo'] = $this->session->userdata('sexo');				

		}else if($_POST !=''){

			$descricao = $this->input->post('descricao');
			$tipo = $this->input->post('tipo');
			$sexo = $this->input->post('sexo');
					
			/*
			** Salvando o filtro de busca na Sessão pra paginação
			*/
			$filtro_busca = array(
				'descricao'  => $descricao,
				'idTipoFigurino' => $tipo,
				'sexo' =>	$sexo			
			);
			$this->session->set_userdata($filtro_busca);			

			$data['descricao'] = $descricao;	
			$data['idTipofigurino'] = $tipo;	
			$data['sexo'] = $sexo;		
		}	

		$limit = 12;
		$data['listFigurino'] = $this->figurinoDao_model->buscarFigurino($data,$limit,$offset);

		if(count($data['listFigurino'])==0){
			$this->session->set_flashdata('resultado_error','Nenhum figurino encontrado!');
			redirect(base_url() . 'FigurinoController/viewLista','refresh');
		}

		$total_rows = $this->figurinoDao_model->get_rows($data);

		/*
		** Paginação
		*/
		$this->load->library('pagination');

		$config['base_url'] = base_url().'FigurinoController/viewLista/';
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $limit;
		$config['uri_segment'] = 3;
		$config['num_links'] = 5;

		$config['first_link'] = 'Primeiro';

		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		
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

		$data['totalRegistros'] = $total_rows;
		$data['listTipo'] = $this->figurinoDao_model->listarTipo();
		$data['mainNav'] = 'figurinos';
		$data['subMainNav'] = 'listaFigurinos';
		$this->load->view('paginas/figurino/lista',$data);	

		$footer['assetsJsBower'] = 'moment/min/moment.min.js';
		$footer['pluginJS'] = 'fancybox/source/jquery.fancybox.pack.js?v=2.1.7,fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6';
		$footer['assetsJs'] = 'figurino/figurino-home.js';
		$this->load->view('include/footer',$footer);
	}

	
	public function viewCadastro(){

        $open['assetsBower'] = 'bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css,select2/dist/css/select2.min.css';
        $open['pluginCSS'] = 'bootstrap-fileinput/css/fileinput.min.css';
        
        $this->load->view('include/openDoc',$open);
        $data['listTipo'] = $this->figurinoDao_model->listarTipo();
		$data['listSituacao'] = $this->figurinoDao_model->listarSituacao();
		$data['mainNav'] = 'figurinos';
		$data['subMainNav'] = 'cadastroFigurino';
		$this->load->view('paginas/figurino/cadastro',$data);	

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,select2/dist/js/select2.full.min.js,bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js';
        $footer['pluginJS'] = 'input-mask/jquery.inputmask.js,bootstrap-fileinput/js/fileinput.min.js,bootstrap-fileinput/js/fileinput_locale_pt-BR.js';
        $footer['assetsJs'] = 'figurino/figurino-cadastro.js';

		$this->load->view('include/footer',$footer);
	}

    public function cadastrarFigurino(){

        	
		$descricao   = $this->input->post('descricao');
		$imagens = is_array($this->input->post('listaImagem'))? $this->input->post('listaImagem') : null;;
		$idTipoFigurino   = $this->input->post('tipo');
		$sexo   = $this->input->post('sexo');
		$situacao   = $this->input->post('situacao');
						
		$mensagem = array();
		
		if(empty($descricao)){
			$mensagem[] = 'A <b>DESCRIÇÃO</b> do figurino é Obrigatória.';
		}
		
		if(empty($imagens)){
			$mensagem[] = 'A <b>FOTO</b> do figurino é Obrigatória.';
		}
		
		if(empty($idTipoFigurino)){
			$mensagem[] = 'O <b>TIPO</b> do figurino é Obrigatório.';
		}
		
		if(empty($sexo)){
			$mensagem[] = 'O <b>SEXO</b> do figurino é Obrigatório.';
		}

		if(empty($situacao)){
			$mensagem[] = 'A <b>SITUAÇÃO</b> do figurino é Obrigatória.';
		}
		
		
		if (count($mensagem) > 0) {		
			$this->session->set_flashdata('mensagem',$mensagem);	
			redirect(base_url() . 'FigurinoController/viewCadastro','refresh');			
		}		
		else{ 			
			
			/*
			** Armazenando dados do formulário no Array $data
			*/		
			$data['idFigurino'] = null;			
			$data['descricao'] = $descricao;			
			$data['sexo'] = $sexo;	
			$data['idTipoFigurino'] = $idTipoFigurino ; 
			$data['situacaoFigurino_id'] = $situacao ; 
			
			
			if($this->figurinoDao_model->insertFigurino($data)){
				
				$idFigurino = $this->db->insert_id();				
				$tipoFigurino = $this->figurinoDao_model->selectTipoById($idTipoFigurino);						 
		 		$codigo = $sexo . '_' . $tipoFigurino[0]->sigla . $idFigurino;						
				/*
			  	* Foto
			  	*/
				$ext = @end(explode(".",$imagens[0]));
				$foto_banco = $codigo.'.'.$ext;					
				
				if($this->figurinoDao_model->completar_cadastro($codigo,$foto_banco,$idFigurino)){
					chmod('uploadImagens/arquivos/' . $imagens[0], 0777);
					rename('uploadImagens/arquivos/' . $imagens[0],  'uploadImagens/arquivos/' . $foto_banco);
					chmod('uploadImagens/arquivos/' . $foto_banco, 0777); 					
					copy('uploadImagens/arquivos/' . $foto_banco, 'assets/img/figurino/' . $foto_banco);
					unlink('uploadImagens/arquivos/' . $foto_banco);
				}
				
				$this->session->set_flashdata('resultado_ok','figurino cadastrado com sucesso!');			
				redirect(base_url() . 'FigurinoController/viewLista','refresh'); 
			}
			else {
				$this->session->set_flashdata('resultado_error','Erro ao cadastrar o figurino!');			
				redirect(base_url() . 'FigurinoController/viewLista','refresh'); 
			}
			
		}	

    }


	public function viewAlterar($id){

        $open['assetsBower'] = 'bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css,select2/dist/css/select2.min.css';
        $open['pluginCSS'] = 'bootstrap-fileinput/css/fileinput.min.css';
        
        $this->load->view('include/openDoc',$open);
        $data['listTipo'] = $this->figurinoDao_model->listarTipo();
        $data['listSituacao'] = $this->figurinoDao_model->listarSituacao();
		$data['figurino'] = $this->figurinoDao_model->selectFigurinoById($id);
		$this->load->view('paginas/figurino/alterar',$data);	

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,select2/dist/js/select2.full.min.js,bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js';
        $footer['pluginJS'] = 'input-mask/jquery.inputmask.js,bootstrap-fileinput/js/fileinput.min.js,bootstrap-fileinput/js/fileinput_locale_pt-BR.js';
        $footer['assetsJs'] = 'figurino/figurino-cadastro.js';

		$this->load->view('include/footer',$footer);
	}


	public function alterarFigurino(){

        $idFigurino = $this->input->post('idFigurino');
		$descricao   = $this->input->post('descricao');
		$imagens = is_array($this->input->post('listaImagem'))? $this->input->post('listaImagem') : null;;
		$idTipoFigurino   = $this->input->post('tipo');
		$sexo   = $this->input->post('sexo');
		$situacao   = $this->input->post('situacao');
						
		$mensagem = array();
		
		if(empty($descricao)){
			$mensagem[] = 'A <b>DESCRIÇÃO</b> do figurino é Obrigatória.';
		}
				
		if(empty($idTipoFigurino)){
			$mensagem[] = 'O <b>TIPO</b> do figurino é Obrigatório.';
		}
		
		if(empty($sexo)){
			$mensagem[] = 'O <b>SEXO</b> do figurino é Obrigatório.';
		}

		if(empty($situacao)){
			$mensagem[] = 'A <b>SITUAÇÃO</b> do figurino é Obrigatória.';
		}
		
		
		if (count($mensagem) > 0) {		
			$this->session->set_flashdata('mensagem',$mensagem);	
			redirect(base_url() . 'FigurinoController/viewAlterar/'.$idFigurino,'refresh');			
		}		
		else{ 			
			
			/*
			** Armazenando dados do formulário no Array $data
			*/		
			$data['idFigurino'] = $idFigurino;			
			$data['descricao'] = $descricao;			
			$data['sexo'] = $sexo;	
			$data['idTipoFigurino'] = $idTipoFigurino ; 
			$data['situacaoFigurino_id'] = $situacao ; 
			
			
			if($this->figurinoDao_model->updateFigurino($data)){
								
				$tipoFigurino = $this->figurinoDao_model->selectTipoById($idTipoFigurino);						 
		 		$codigo = $sexo . '_' . $tipoFigurino[0]->sigla . $idFigurino;						
				/*
			  	* Foto
			  	*/
				$ext = @end(explode(".",$imagens[0]));
				$foto_banco = $codigo.'.'.$ext;					
				
				if($this->figurinoDao_model->completar_cadastro($codigo,$foto_banco,$idFigurino)){
					chmod('uploadImagens/arquivos/' . $imagens[0], 0777);
					rename('uploadImagens/arquivos/' . $imagens[0],  'uploadImagens/arquivos/' . $foto_banco);
					chmod('uploadImagens/arquivos/' . $foto_banco, 0777); 					
					copy('uploadImagens/arquivos/' . $foto_banco, 'assets/img/figurino/' . $foto_banco);
					unlink('uploadImagens/arquivos/' . $foto_banco);
				}
				
				$this->session->set_flashdata('resultado_ok','figurino alterado com sucesso!');			
				redirect(base_url() . 'FigurinoController/viewLista','refresh'); 
			}
			else {
				$this->session->set_flashdata('resultado_error','Erro ao alterar o figurino!');			
				redirect(base_url() . 'FigurinoController/viewLista','refresh'); 
			}
			
		}	

    }

    function excluirFigurino($idFigurino){			
			
        $dadosFigurino = $this->figurinoDao_model->selectFigurinoById($idFigurino);
        chmod('assets/img/figurino/' . $dadosFigurino[0]->foto,0777);
        @unlink('assets/img/figurino/' . $dadosFigurino[0]->foto);
                    
        if($this->figurinoDao_model->deleteFigurino($idFigurino)){          
            $this->session->set_flashdata('resultado_ok', 'Exclusão de Figurino efetuada com sucesso!');
            redirect(base_url() . 'FigurinoController/viewLista', 'refresh');
        }
        else {
            $this->session->set_flashdata('resultado_error', 'Erro ao Excluir o figurino!');
            redirect(base_url() . 'FigurinoController/viewLista','refresh'); 
        } 
	
	
	}

	function viewLavanderia($idFigurino){

		$open['assetsBower'] = 'bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css';
        $open['pluginCSS'] = '';
		$open['assetsCSS'] = 'figurino/lavanderia.css';
        
        $this->load->view('include/openDoc',$open);
		$data['figurino'] = $this->figurinoDao_model->selectFigurino($idFigurino);		
    
		$data['listSituacao'] = $this->figurinoDao_model->listarSituacao();
		$data['listLavanderia'] = $this->figurinoDao_model->listarServico($idFigurino,'L');
		$this->load->view('paginas/figurino/lavanderia',$data);	

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js';
        $footer['pluginJS'] = 'input-mask/jquery.inputmask.js';
        $footer['assetsJs'] = 'figurino/lavanderia.js';

		$this->load->view('include/footer',$footer);

	}

	function cadastrarLavanderia(){

		$dataSaida   = $this->input->post('dataSaida');
		$idFigurino   = $this->input->post('idFigurino');

		if(empty($dataSaida)){
			$mensagem[] = 'A <b>DATA DE SAÍDA</b>  é Obrigatória.';
		}else if(!validaData($dataSaida)){
			$mensagem[] = 'A <b>DATA DE SAÍDA</b> inválida.';
		}

		if (count($mensagem) > 0) {		
			$this->session->set_flashdata('mensagem',$mensagem);	
			redirect(base_url() . 'FigurinoController/viewLavanderia/'.$idFigurino,'refresh');			
		}		
		else{

			$data['idHistoricoServico'] = null;			
			$data['saidaFigurino'] = converteDataBanco($dataSaida);
			$data['figurino_id'] = $idFigurino ; 
			$data['tipoServico'] = 'L' ; 			
			
			if($this->figurinoDao_model->insertServico($data,$idFigurino)){				
				
				$this->session->set_flashdata('resultado_ok','Saída de Figurino cadastrada com sucesso!');			
				redirect(base_url() . 'FigurinoController/viewLavanderia/'.$idFigurino,'refresh'); 
			}
			else {
				$this->session->set_flashdata('resultado_error','Erro ao cadastrar a saída do figurino!');			
				redirect(base_url() . 'FigurinoController/viewLavanderia/'.$idFigurino,'refresh'); 
			}
			

		}
		
	}

	function devolucaoLavanderia(){

		$idServico = $this->input->post('idServico');
		$idFigurino   = $this->input->post('idFigurino');	
		
		$data['idHistoricoServico'] = $idServico;			
		$data['retornoFigurino'] = date('Y-m-d');
		
		if($this->figurinoDao_model->insertDevolucao($data,$idServico,$idFigurino)){	
			$resposta = array(
				'status' => 'success',
				'mensagem' => 'Devolução efetuada com sucesso!'
			);
			echo json_encode($resposta);			
		}
		else {
			$resposta = array(
				'status' => 'failed',
				'mensagem' => 'Erro ao efetuar a devolução!'
			);
			echo json_encode($resposta);				
		}			
		
	}

	function viewCostureira($idFigurino){

		$open['assetsBower'] = 'bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css';
        $open['pluginCSS'] = '';
		$open['assetsCSS'] = 'figurino/lavanderia.css';
        
        $this->load->view('include/openDoc',$open);
		$data['figurino'] = $this->figurinoDao_model->selectFigurino($idFigurino);
		$data['listSituacao'] = $this->figurinoDao_model->listarSituacao();
		$data['listCostureira'] = $this->figurinoDao_model->listarServico($idFigurino,'C');
		$this->load->view('paginas/figurino/costureira',$data);	

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js';
        $footer['pluginJS'] = 'input-mask/jquery.inputmask.js';
        $footer['assetsJs'] = 'figurino/lavanderia.js';

		$this->load->view('include/footer',$footer);

	}

	function cadastrarCostureira(){

		$dataSaida   = $this->input->post('dataSaida');
		$idFigurino   = $this->input->post('idFigurino');

		if(empty($dataSaida)){
			$mensagem[] = 'A <b>DATA DE SAÍDA</b>  é Obrigatória.';
		}else if(!validaData($dataSaida)){
			$mensagem[] = 'A <b>DATA DE SAÍDA</b> inválida.';
		}

		if (count($mensagem) > 0) {		
			$this->session->set_flashdata('mensagem',$mensagem);	
			redirect(base_url() . 'FigurinoController/viewCostureira/'.$idFigurino,'refresh');			
		}		
		else{

			$data['idHistoricoServico'] = null;			
			$data['saidaFigurino'] = converteDataBanco($dataSaida);
			$data['figurino_id'] = $idFigurino ; 
			$data['tipoServico'] = 'C' ; 			
			
			if($this->figurinoDao_model->insertServico($data,$idFigurino)){				
				
				$this->session->set_flashdata('resultado_ok','Saída de Figurino cadastrada com sucesso!');			
				redirect(base_url() . 'FigurinoController/viewCostureira/'.$idFigurino,'refresh'); 
			}
			else {
				$this->session->set_flashdata('resultado_error','Erro ao cadastrar a saída do figurino!');			
				redirect(base_url() . 'FigurinoController/viewCostureira/'.$idFigurino,'refresh'); 
			}
			

		}
		
	}

	function devolucaoCostureira(){

		$idServico = $this->input->post('idServico');
		$idFigurino   = $this->input->post('idFigurino');	
		
		$data['idHistoricoServico'] = $idServico;			
		$data['retornoFigurino'] = date('Y-m-d');
		
		if($this->figurinoDao_model->insertDevolucao($data,$idServico,$idFigurino)){	
			$resposta = array(
				'status' => 'success',
				'mensagem' => 'Devolução efetuada com sucesso!'
			);
			echo json_encode($resposta);			
		}
		else {
			$resposta = array(
				'status' => 'failed',
				'mensagem' => 'Erro ao efetuar a devolução!'
			);
			echo json_encode($resposta);				
		}			
		
	}

}