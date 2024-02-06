<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProgramasController extends CI_Controller {

    function __construct() {
		parent:: __construct();

		if(!$this->session->userdata('logged_in')){
			redirect(base_url() . 'Login', 'refresh');
		}
		$grupos = $this->session->userdata('grupos');
        if(in_array("1", $grupos) || in_array("14", $grupos) || in_array("12", $grupos)){             
        }else{
            redirect(base_url() . 'Home', 'refresh');
        }

		$this->load->model('programasDao_model');

	}


    public function viewLista(){

        $open['assetsBower'] = 'bootstrap-daterangepicker/daterangepicker.css,datatables.net-bs/css/dataTables.bootstrap.min.css,select2/dist/css/select2.min.css';   
        $open['assetsCSS'] = 'programas/programas-list.css';
        $this->load->view('include/openDoc',$open);

		$data['mainNav'] = 'programas';
		$data['subMainNav'] = 'listaProgramas';
		$data['listProgramas'] = $this->programasDao_model->listarProgramas();
		$this->load->view('paginas/programas/lista',$data);	

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,bootstrap-daterangepicker/daterangepicker.js,datatables.net/js/jquery.dataTables.min.js,datatables.net-bs/js/dataTables.bootstrap.min.js,select2/dist/js/select2.full.min.js';
        $footer['assetsJs'] = 'programas/programas-home.js';
        $this->load->view('include/footer',$footer);
    }

	public function listaProgramasDataTables(){

        $fetch_data = $this->programasDao_model->make_datatables();
        $data = array();
        foreach($fetch_data as $row){         

            $sigla = '<h4><span class="label bg-navy">'.$row->sigla.'</span></h4>'; 
			$duracao = '<span class="label pull-right bg-teal">'.$row->duracao.'</span><br>'; 
			$situacao = '';
			$ativoNoSite = '';
            if($row->ativo == 'S'){
                $situacao = '<span class="label pull-right bg-green">ATIVO</span><br>'; 
            }else if($row->ativo == 'N'){
                $situacao = '<span class="label pull-right bg-red">INATIVO</span><br>';  
			} 
			if($row->site_novo == 'S'){
                $ativoNoSite = '<span class="label pull-right bg-green">ativo no site</span><br>'; 
            }else if($row->site_novo == 'N'){
                $ativoNoSite = '<span class="label pull-right bg-red">desativado no site</span><br>';  
            }             

            $sub_array = array();  
            $sub_array[] = '<img src="'.IMAGEM_PROGRAMA.$row->imagem.'" class="img-rounded  imgList" />';  
			$sub_array[] = $row->titulo;  
			$sub_array[] = $sigla;  
            $sub_array[] = $row->descricao;   
            $sub_array[] = $ativoNoSite.$duracao.$situacao;
            $sub_array[] = '<a href="'.base_url('ProgramasController/viewAlterar/'.$row->id).'" class="btn btn-app"><i class="fa fa-edit"></i> Alterar</a>
                            <a href="'.base_url('ProgramasController/apagarPrograma/'.$row->id).'" class="btn btn-app"><i class="fa fa-trash"></i> Excluir</a>';  
            
            $data[] = $sub_array;  
        }  
        $output = array(  
            "draw" => intval($_POST["draw"]),  
            "recordsTotal" => $this->programasDao_model->get_all_data(),  
            "recordsFiltered" => $this->programasDao_model->get_filtered_data(),  
            "data" => $data  
        );  
        echo json_encode($output);
    }

	
	public function viewCadastro(){

        $open['assetsBower'] = 'bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css,select2/dist/css/select2.min.css';
		$open['pluginCSS'] = 'bootstrap-fileinput/css/fileinput.min.css';
		$open['assetsCSS'] = 'programas/alterar.css';
        
        $this->load->view('include/openDoc',$open);

		$data['mainNav'] = 'programas';
		$data['subMainNav'] = 'cadastroPrograma';
		$this->load->view('paginas/programas/cadastro',$data);	

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,select2/dist/js/select2.full.min.js,bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js';
        $footer['pluginJS'] = 'input-mask/jquery.inputmask.js,bootstrap-fileinput/js/fileinput.min.js,bootstrap-fileinput/js/fileinput_locale_pt-BR.js';
        $footer['assetsJs'] = 'programas/programas-cadastro.js';

		$this->load->view('include/footer',$footer);
	}

    public function cadastrarPrograma(){
		
        $titulo   = $this->input->post('titulo');
		$descricao   = $this->input->post('descricao');
		$apresentadorPrograma   = $this->input->post('apresentadorPrograma');
		$descricaoApp   = $this->input->post('descricaoApp');
		$temasPossiveis   = $this->input->post('temasPossiveis');
		$publicoAlvo   = $this->input->post('publicoAlvo');
		$horarioInedito   = $this->input->post('horarioInedito');
		$horarioAlternativo   = $this->input->post('horarioAlternativo');
		$anoEstreia   = $this->input->post('anoEstreia');
		$periodicidade   = $this->input->post('periodicidade');
		$duracao   = $this->input->post('duracao');
		$aplicativo   = $this->input->post('aplicativo');
		$situacao   = $this->input->post('situacao');	
		$site_novo = $this->input->post('site_novo');
		$busca_site = $this->input->post('busca_site');
		$sigla = $this->input->post('sigla');
		$canal	= $this->input->post('canal');

		$imagem   = is_array($this->input->post('listaImagem'))? $this->input->post('listaImagem') : null;
		$imagemProgramacao   = is_array($this->input->post('listaImagemProgramacao'))? $this->input->post('listaImagemProgramacao') : null;
		$imagemApp   = is_array($this->input->post('listaImagemApp'))? $this->input->post('listaImagemApp') : null;
		$imagemApresentador   = is_array($this->input->post('listaImagemApresentador'))? $this->input->post('listaImagemApresentador') : null;

        $friendly_url = getRawUrl($titulo);		
        $prefixo = $friendly_url;        
        $sequencia = 1;	        
        $mensagem = array();
        
                
        if(empty($titulo)){
          $mensagem[] = 'O TÍTULO do programa é Obrigatório.';
        }        
                
       
        
        if(empty($situacao)){
            $mensagem[] = 'O SITUAÇÃO do programa é Obrigatória.';
        }

        		
		/**
		 * VERIFICANDO NO BANCO SE EXISTE O TÍTULO A SER CADASTRADO
		 */
		$titulo_atual = $this->programasDao_model->titulo_disponivel($titulo);		
		if (count($titulo_atual) > 0){
			$mensagem[] = 'Nome já cadastrado.';
		}
		
		
		if (count($mensagem) > 0) {		
			$this->session->set_flashdata('mensagem',$mensagem);	
			redirect(base_url() . 'ProgramasController/viewCadastro/','refresh');			
		}		
		else{ 			
			
			$novo_nome_imagem = $friendly_url . '.' . @end(explode(".",$imagem[0]));	
			chmod('uploadImagens/arquivos/'.$imagem[0], 0777);
			rename('uploadImagens/arquivos/'.$imagem[0], 'uploadImagens/arquivos/'.$novo_nome_imagem);
			
			$novo_nome_imagem_prog = 'prog-'.$friendly_url . '.' . @end(explode(".",$imagem[0]));
			chmod('uploadImagens/arquivos/'.$imagemProgramacao[0], 0777);
			rename('uploadImagens/arquivos/'.$imagemProgramacao[0], 'uploadImagens/arquivos/'.$novo_nome_imagem_prog);

			$novo_nome_imagem_app = 'app-'.$friendly_url . '.' . @end(explode(".",$imagem[0]));
			chmod('uploadImagens/arquivos/'.$imagemApp[0], 0777);
			rename('uploadImagens/arquivos/'.$imagemApp[0], 'uploadImagens/arquivos/'.$novo_nome_imagem_app);

			$novo_nome_imagem_apres = 'apres-'.$friendly_url . '.' . @end(explode(".",$imagem[0]));
			chmod('uploadImagens/arquivos/'.$imagemApresentador[0], 0777);
			rename('uploadImagens/arquivos/'.$imagemApresentador[0], 'uploadImagens/arquivos/'.$novo_nome_imagem_apres);
		
			
			/*
			** Armazenando dados do formulário no Array $data
			*/							
			$data['id'] = null;				
			$data['titulo'] = $titulo;
			$data['descricao'] = $descricao;			
			$data['descricaoApp'] = $descricaoApp;			
			$data['duracao'] = $duracao;
			$data['imagem'] = $novo_nome_imagem;
			$data['imgApp'] = $novo_nome_imagem_app;
			$data['imgApresentador'] = $novo_nome_imagem_apres;
			$data['imgNoAr'] = $novo_nome_imagem_prog;
			$data['prefixo'] = $prefixo;	
			$data['sequencia'] = $sequencia;
			$data['friendly_url'] = $friendly_url;
			$data['ordem'] = '';
			$data['tipo'] = '';
			$data['sigla'] = $sigla;
			$data['horarioInedito'] = $horarioInedito;			
			$data['horarioAlternativo'] = $horarioAlternativo;			
			$data['apresentadorPrograma'] = $apresentadorPrograma;			
			$data['temasPossiveis'] = $temasPossiveis;			
			$data['publicoAlvo'] = $publicoAlvo;						
			$data['anoEstreia'] = $anoEstreia;						
			$data['periodicidade'] = $periodicidade;						
			$data['publicoAlvo'] = $publicoAlvo;						
			$data['ativo'] = $situacao;
			$data['aplicativo'] = $aplicativo;
			$data['site_novo'] = $site_novo;
			$data['busca_site'] = $busca_site;
			$data['canal'] = $canal;


												
			if($this->programasDao_model->insertPrograma($data)){
				
				if(!empty($novo_nome_imagem)){					
					copy('uploadImagens/arquivos/' . $novo_nome_imagem, 'assets/img/programas/' . $novo_nome_imagem);
					chmod('assets/img/programas/' . $novo_nome_imagem, 0777);
					unlink('uploadImagens/arquivos/' . $novo_nome_imagem);
				} 
				if(!empty($novo_nome_imagem_prog)){
					copy('uploadImagens/arquivos/' . $novo_nome_imagem_prog, 'assets/img/programas/noAr/' . $novo_nome_imagem_prog);
					chmod('assets/img/programas/noAr/' . $novo_nome_imagem_prog, 0777);
					unlink('uploadImagens/arquivos/' . $novo_nome_imagem_prog);
				}				
				if(!empty($novo_nome_imagem_app)){
					copy('uploadImagens/arquivos/' . $novo_nome_imagem_app, 'assets/img/programas/app/' . $novo_nome_imagem_app);
					chmod('assets/img/programas/app/' . $novo_nome_imagem_app, 0777);
					unlink('uploadImagens/arquivos/' . $novo_nome_imagem_app);
				}
				if(!empty($novo_nome_imagem_apres)){
					copy('uploadImagens/arquivos/' . $novo_nome_imagem_apres, 'assets/img/programas/apresentador/' . $novo_nome_imagem_apres);
					chmod('assets/img/programas/apresentador/' . $novo_nome_imagem_apres, 0777);
					unlink('uploadImagens/arquivos/' . $novo_nome_imagem_apres);
				}		
				$this->session->set_flashdata('resultado_ok','Programa <b>'.$titulo.'</b> foi cadastrado com sucesso!');			
				redirect(base_url() . 'ProgramasController/viewLista','refresh'); 
			}
			else{
				$this->session->set_flashdata('resultado_error','Erro ao cadastrar o Programa!');			
				redirect(base_url() . 'ProgramasController/viewLista','refresh'); 
			}
			
		}	

    }

	public function viewAlterar($idPrograma){

        $open['assetsBower'] = 'bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css,select2/dist/css/select2.min.css';
        $open['pluginCSS'] = 'bootstrap-fileinput/css/fileinput.min.css';
        $open['assetsCSS'] = 'programas/alterar.css';
        $this->load->view('include/openDoc',$open);
		$data['programa'] = $this->programasDao_model->selectProgramaById($idPrograma);
		
		$this->load->view('paginas/programas/alterar',$data);	

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,select2/dist/js/select2.full.min.js,bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js';
        $footer['pluginJS'] = 'input-mask/jquery.inputmask.js,bootstrap-fileinput/js/fileinput.min.js,bootstrap-fileinput/js/fileinput_locale_pt-BR.js';
        $footer['assetsJs'] = 'programas/programas-cadastro.js';

		$this->load->view('include/footer',$footer);
	}


	public function alterarPrograma(){

        
       	$idPrograma   = $this->input->post('idPrograma');
        $titulo   = $this->input->post('titulo');
		$descricao   = $this->input->post('descricao');		
		$apresentadorPrograma   = $this->input->post('apresentadorPrograma');
		$descricaoApp   = $this->input->post('descricaoApp');
		$temasPossiveis   = $this->input->post('temasPossiveis');
		$publicoAlvo   = $this->input->post('publicoAlvo');
		$horarioInedito   = $this->input->post('horarioInedito');
		$horarioAlternativo   = $this->input->post('horarioAlternativo');
		$anoEstreia   = $this->input->post('anoEstreia');
		$periodicidade   = $this->input->post('periodicidade');
		$duracao   = $this->input->post('duracao');
		$aplicativo   = $this->input->post('aplicativo');
		$situacao   = $this->input->post('situacao');
		$site_novo = $this->input->post('site_novo');	
		$busca_site = $this->input->post('busca_site');
		$sigla = $this->input->post('sigla');	
		$canal = $this->input->post('canal');

		$imagem   = is_array($this->input->post('listaImagem'))? $this->input->post('listaImagem') : null;
		$imagemProgramacao   = is_array($this->input->post('listaImagemProgramacao'))? $this->input->post('listaImagemProgramacao') : null;
		$imagemApp   = is_array($this->input->post('listaImagemApp'))? $this->input->post('listaImagemApp') : null;
		$imagemApresentador   = is_array($this->input->post('listaImagemApresentador'))? $this->input->post('listaImagemApresentador') : null;

		

		$dados_atuais = $this->programasDao_model->selectProgramaById($idPrograma);

        $friendly_url = getRawUrl($titulo);		
        $prefixo = $friendly_url; 	        
        $mensagem = array();
        
                
        if(empty($titulo)){
          $mensagem[] = 'O <b>TÍTULO</b> do programa é Obrigatório.';
        }        
           
        
        
        if(empty($situacao)){
            $mensagem[] = 'O <b>SITUAÇÃO</b> do programa é Obrigatória.';
        }

        		
		/**
		 * VERIFICANDO NO BANCO SE EXISTE O TÍTULO A SER CADASTRADO
		 */
		if($titulo != $dados_atuais[0]->titulo){
			$titulo_atual = $this->programasDao_model->titulo_disponivel($titulo);		
			if (count($titulo_atual) > 0){			
				$mensagem[] = 'Nome já cadastrado.';
			}
		}		
		
		if (count($mensagem) > 0) {		
			$this->session->set_flashdata('mensagem',$mensagem);	
			redirect(base_url() . 'ProgramasController/viewAlterar/'.$idPrograma,'refresh');			
		}		
		else{ 	
			
			
			
			if(!empty($imagem)){
				$novo_nome_imagem = $friendly_url . '.' . @end(explode(".",$imagem[0]));	
				chmod('uploadImagens/arquivos/'.$imagem[0], 0777);
				rename('uploadImagens/arquivos/'.$imagem[0], 'uploadImagens/arquivos/'.$novo_nome_imagem);	
			}else{
				if($titulo !== $dados_atuais[0]->titulo){
					$novo_nome_imagem = $friendly_url . '.' . end(explode(".",$dados_atuais[0]->imagem));
				}else{
					$novo_nome_imagem = $dados_atuais[0]->imagem;
				}
				
			}	


			if(!empty($imagemProgramacao)){
				$novo_nome_imagem_prog = 'prog-'.$friendly_url . '.' . @end(explode(".",$imagemProgramacao[0]));
				chmod('uploadImagens/arquivos/'.$imagemProgramacao[0], 0777);
				rename('uploadImagens/arquivos/'.$imagemProgramacao[0], 'uploadImagens/arquivos/'.$novo_nome_imagem_prog);
			}else{
				if($titulo !== $dados_atuais[0]->titulo){
					$novo_nome_imagem_prog = 'prog-'.$friendly_url . '.' . end(explode(".",$dados_atuais[0]->imgNoAr));
				}else{
					$novo_nome_imagem_prog = $dados_atuais[0]->imgNoAr;
				}
				
			}


			if(!empty($imagemApp)){
				$novo_nome_imagem_app = 'app-'.$friendly_url . '.' . @end(explode(".",$imagemApp[0]));
				chmod('uploadImagens/arquivos/'.$imagemApp[0], 0777);
				rename('uploadImagens/arquivos/'.$imagemApp[0], 'uploadImagens/arquivos/'.$novo_nome_imagem_app);
			}else{
				if($titulo !== $dados_atuais[0]->titulo){
					$novo_nome_imagem_app = 'app-'.$friendly_url . '.' . end(explode(".",$dados_atuais[0]->imgApp));
				}else{
					$novo_nome_imagem_app = $dados_atuais[0]->imgApp;
				}
				
			}


			if(!empty($imagemApresentador)){
				$novo_nome_imagem_apres = 'apres-'.$friendly_url . '.' . @end(explode(".",$imagemApresentador[0]));
				chmod('uploadImagens/arquivos/'.$imagemApresentador[0], 0777);
				rename('uploadImagens/arquivos/'.$imagemApresentador[0], 'uploadImagens/arquivos/'.$novo_nome_imagem_apres);
				
			}else{
				if($titulo !== $dados_atuais[0]->titulo){
					$novo_nome_imagem_apres = 'apres-'.$friendly_url . '.' . end(explode(".",$dados_atuais[0]->imgApresentador));
				}else{
					$novo_nome_imagem_apres = $dados_atuais[0]->imgApresentador;
				}
				
			}			
			
			
			/*
			** Armazenando dados do formulário no Array $data
			*/							
			$data['id'] = $idPrograma;				
			$data['titulo'] = $titulo;
			$data['descricao'] = $descricao;			
			$data['descricaoApp'] = $descricaoApp;			
			$data['duracao'] = $duracao;
			$data['imagem'] = $novo_nome_imagem;
			$data['imgApp'] = $novo_nome_imagem_app;
			$data['imgApresentador'] = $novo_nome_imagem_apres;
			$data['imgNoAr'] = $novo_nome_imagem_prog;
			$data['prefixo'] = $prefixo;	
			//$data['sequencia'] = $sequencia;
			$data['friendly_url'] = $friendly_url;
			$data['ordem'] = '';
			$data['tipo'] = '';
			$data['sigla'] = $sigla;
			$data['horarioInedito'] = $horarioInedito;			
			$data['horarioAlternativo'] = $horarioAlternativo;			
			$data['apresentadorPrograma'] = $apresentadorPrograma;			
			$data['temasPossiveis'] = $temasPossiveis;			
			$data['publicoAlvo'] = $publicoAlvo;						
			$data['anoEstreia'] = $anoEstreia;						
			$data['periodicidade'] = $periodicidade;						
			$data['publicoAlvo'] = $publicoAlvo;						
			$data['ativo'] = $situacao;
			$data['aplicativo'] = $aplicativo;
			$data['site_novo'] = $site_novo;
			$data['busca_site'] = $busca_site;
			$data['canal'] = $canal;
			
									
			if($this->programasDao_model->updatePrograma($data)){

				
				if(!empty($imagem)){	
					unlink('assets/img/programas/'.$dados_atuais[0]->imagem); 									
					copy('uploadImagens/arquivos/'.$novo_nome_imagem, 'assets/img/programas/'.$novo_nome_imagem);
					chmod('assets/img/programas/'.$novo_nome_imagem, 0777);
					unlink('uploadImagens/arquivos/'.$novo_nome_imagem); 
				}else{
					rename('assets/img/programas/'.$dados_atuais[0]->imagem,'assets/img/programas/'.$novo_nome_imagem);
				}	

				if(!empty($imagemProgramacao)){
					unlink('assets/img/programas/noAr/'.$dados_atuais[0]->imgNoAr); 
					copy('uploadImagens/arquivos/' . $novo_nome_imagem_prog, 'assets/img/programas/noAr/' . $novo_nome_imagem_prog);
					chmod('assets/img/programas/noAr/' . $novo_nome_imagem_prog, 0777);
					unlink('uploadImagens/arquivos/' . $novo_nome_imagem_prog);
				}else{
					rename('assets/img/programas/noAr/'.$dados_atuais[0]->imgNoAr,'assets/img/programas/noAr/'.$novo_nome_imagem_prog);
				}	

				if(!empty($imagemApp)){
					unlink('assets/img/programas/app/'.$dados_atuais[0]->imgApp); 
					copy('uploadImagens/arquivos/' . $novo_nome_imagem_app, 'assets/img/programas/app/' . $novo_nome_imagem_app);
					chmod('assets/img/programas/app/' . $novo_nome_imagem_app, 0777);
					unlink('uploadImagens/arquivos/' . $novo_nome_imagem_app);
				}else{
					rename('assets/img/programas/app/'.$dados_atuais[0]->imgApp,'assets/img/programas/app/'.$novo_nome_imagem_app);
				}

				if(!empty($imagemApresentador)){
					unlink('assets/img/programas/apresentador/'.$dados_atuais[0]->imgApresentador); 
					copy('uploadImagens/arquivos/' . $novo_nome_imagem_apres, 'assets/img/programas/apresentador/' . $novo_nome_imagem_apres);
					chmod('assets/img/programas/apresentador/' . $novo_nome_imagem_apres, 0777);
					unlink('uploadImagens/arquivos/' . $novo_nome_imagem_apres);
				}else{
					rename('assets/img/programas/apresentador'.$dados_atuais[0]->imgApresentador,'assets/img/programas/apresentador/'.$novo_nome_imagem_apres);
				}

				$this->session->set_flashdata('resultado_ok','Programa <b>'.$titulo.'</b> foi alterado com sucesso!');			
				redirect(base_url() . 'ProgramasController/viewLista','refresh'); 
			}
			else{
				$this->session->set_flashdata('resultado_error','Erro ao alterar o Programa!');			
				redirect(base_url() . 'ProgramasController/viewLista','refresh'); 
			}
			
		}	

    }

	function apagarPrograma($idPrograma){
		$dados_atuais = $this->programasDao_model->selectProgramaById($idPrograma);

		if($this->programasDao_model->deletePrograma($idPrograma)){
			unlink('assets/img/programas/'.$dados_atuais[0]->imagem); 
			unlink('assets/img/programas/noAr/'.$dados_atuais[0]->imgNoAr); 
			unlink('assets/img/programas/app/'.$dados_atuais[0]->imgApp); 
			unlink('assets/img/programas/apresentador/'.$dados_atuais[0]->imgApresentador);
			$this->session->set_flashdata('resultado_ok', 'Programa excluído com sucesso!');
			redirect(base_url() . 'ProgramasController/viewLista', 'refresh');
		}
		else {
			$this->session->set_flashdata('resultado_error', 'Erro ao Excluir o Programa!');
			redirect(base_url() . 'ProgramasController/viewLista','refresh'); 
		} 
	}


}