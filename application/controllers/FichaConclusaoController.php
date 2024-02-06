<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FichaConclusaoController extends CI_Controller {

    function __construct() {
		parent:: __construct();

		if(!$this->session->userdata('logged_in')){
			redirect(base_url() . 'Login', 'refresh');
		}
        $grupos = $this->session->userdata('grupos');
        if(in_array("1", $grupos) || in_array("17", $grupos) || in_array("20", $grupos) || in_array("15", $grupos) || in_array("16", $grupos)
		|| in_array("17", $grupos) || in_array("19", $grupos) || in_array("21", $grupos) || in_array("22", $grupos) || in_array("23", $grupos)
		|| in_array("24", $grupos) || in_array("28", $grupos)){             
        }else{
            redirect(base_url() . 'Home', 'refresh');
        }	
		$this->load->model('parceirosDao_model','parceirosDao');	
		$this->load->model('ingestDao_model','ingestDao');
		$this->load->model('revisaoDao_model','revisaoDao');
		$this->load->model('fichaConclusaoDao_model','fichaConclusaoDao');
		$this->load->model('usuariosDao_model','usuariosDao');
	}


	function cadastrarFichaConclusao(){
				
		$idIngest = $this->input->post('idIngest');		
        $idParceiros =  ($this->input->post('idParceiros') != null)? $this->input->post('idParceiros') : null;
        $idIngestParceiro =  ($this->input->post('idIngestParceiro') != null)? $this->input->post('idIngestParceiro') : null;
		
		$idInterProgramas =  ($this->input->post('idInterProgramas') != null)? $this->input->post('idInterProgramas') : null;
        $idIngestInterPrograma =  ($this->input->post('idIngestInterPrograma') != null)? $this->input->post('idIngestInterPrograma') : null;
		
		$idInterProgramaCasa = ($this->input->post('idInterProgramaCasa') != null)? $this->input->post('idInterProgramaCasa') : null;
		$idIngestInterCasa = ($this->input->post('idIngestInterCasa') != null)? $this->input->post('idIngestInterCasa') : null;
		
		
		$apresentadores = $this->input->post('apresentadores');
		$diretor = $this->input->post('diretor');
		$reporter = $this->input->post('reporter');
		$produtor = $this->input->post('produtor');
		$entrevistados = $this->input->post('entrevistados');
		$convidados = $this->input->post('convidados');
		$tags = $this->input->post('tags');
		$sinopse = $this->input->post('sinopse');
		$observacao = $this->input->post('observacao');
		$dataVeiculacao = $this->input->post('dataVeiculacao');
		$duracaoReal = $this->input->post('duracaoReal');
		$bloco = $this->input->post('bloco');
		
		$tipoFluxo =  $this->input->post('tipoFluxo');
		$tipoIngest =  $this->input->post('tipoIngest');
		$blocoAtual = $this->revisaoDao->selectBlocos($idIngest);
				
		$url = "";
		switch ($tipoIngest) {						
			case 'P':
				$url = 'MidiasParceirosController/viewfluxoParceiros/'.$idParceiros.'/fichaConclusao';
				break;
			case 'IP':
				$url = 'controlMidiasInterParceiros/fluxo/'.$idInterProgramas.'/fichaConclusao';
				break;
			case 'IC':
				$url = 'controlMidiasInterCasa/fluxo/'.$idInterProgramaCasa.'/fichaConclusao';
				break;
			default:				
				break;
		}
		
		$mensagem = array();					
		
		if(empty($tags)){
			$mensagem[] = "Por favor, informe a(s) Tag(s)";
		}		
		if(empty($sinopse)){
			$mensagem[] = "Por favor, informe a(s) Sinopse(s)";
		}

		if(count($bloco) < count($blocoAtual)){
			$mensagem[] = "Por favor, informe a duração dos Blocos";
		}else{
			foreach ($bloco as $key => $b) {
				if($b[0] == "00:00:00;00" || $b[0] == "00:00:00;00"){
					$mensagem[] = "Por favor, informe a duração dos Blocos";
				}
			}
		}
		
				
				
		if(count($mensagem)>0){
			 $this->session->set_flashdata('mensagem',$mensagem);
			 redirect(base_url() . $url,'refresh');
		}else{
						
			$data['idFichaConclusao'] = null;
			$data['apresentador'] = $apresentadores;
			$data['diretor'] = $diretor;
			$data['reporter'] = $reporter;
			$data['produtor'] = $produtor;
			$data['entrevistados'] = $entrevistados;
			$data['convidados'] = $convidados;
			$data['tags'] = $tags;
			$data['sinopse'] = $sinopse;
			$data['observacao'] = $observacao;	
			$data['dataVeiculacao'] = $dataVeiculacao;
			$data['dataFichaConclusao'] = Date('Y-m-d H:i:s');	
			$data['dataFimFichaConclusao'] = Date('Y-m-d H:i:s');		
			$data['usuario_id_fichaConclusao'] = $this->session->userdata('idUsuario');
			$data['ingest_id'] = $idIngest;
			$data['duracaoReal'] = $duracaoReal;
						
			if($this->fichaConclusaoDao->insertFichaConclusao($data,$bloco)){
				if($tipoIngest == 'P'){
					$this->session->set_flashdata('resultado_ok','Ficha de Conclusão cadastrada com sucesso!');
				}else{
					$this->session->set_flashdata('resultado_ok','Ficha de Conclusão cadastrada com sucesso!');					
				}										
				redirect(base_url() . $url,'refresh');
			}else{
				$this->session->set_flashdata('resultado_error','Erro ao Cadastrar a Ficha de Conclusão!');			
				redirect(base_url() . $url,'refresh');
			}
			
			
		}
		
		
	}

	function alterarFichaConclusao(){
							
		$idFichaConclusao = $this->input->post('idFichaConclusao');
		$idIngest = $this->input->post('idIngest');		
        $idParceiros =  ($this->input->post('idParceiros') != null)? $this->input->post('idParceiros') : null;
        $idIngestParceiro =  ($this->input->post('idIngestParceiro') != null)? $this->input->post('idIngestParceiro') : null;
		
		$idInterProgramas =  ($this->input->post('idInterProgramas') != null)? $this->input->post('idInterProgramas') : null;
        $idIngestInterPrograma =  ($this->input->post('idIngestInterPrograma') != null)? $this->input->post('idIngestInterPrograma') : null;
		
		$idInterProgramaCasa = ($this->input->post('idInterProgramaCasa') != null)? $this->input->post('idInterProgramaCasa') : null;
		$idIngestInterCasa = ($this->input->post('idIngestInterCasa') != null)? $this->input->post('idIngestInterCasa') : null;
		
		
		$apresentadores = $this->input->post('apresentadores');
		$diretor = $this->input->post('diretor');
		$reporter = $this->input->post('reporter');
		$produtor = $this->input->post('produtor');
		$entrevistados = $this->input->post('entrevistados');
		$convidados = $this->input->post('convidados');
		$tags = $this->input->post('tags');
		$sinopse = $this->input->post('sinopse');
		$observacao = $this->input->post('observacao');
		$dataVeiculacao = $this->input->post('dataVeiculacao');
		$duracaoReal = $this->input->post('duracaoReal');
		$bloco = $this->input->post('bloco');
		
		$tipoFluxo =  $this->input->post('tipoFluxo');
		$tipoIngest =  $this->input->post('tipoIngest');
		$blocoAtual = $this->revisaoDao->selectBlocos($idIngest);
				
		$url = "";
		switch ($tipoIngest) {						
			case 'P':
				$url = 'MidiasParceirosController/viewfluxoParceiros/'.$idParceiros.'/fichaConclusao';
				break;
			case 'IP':
				$url = 'controlMidiasInterParceiros/fluxo/'.$idInterProgramas.'/fichaConclusao';
				break;
			case 'IC':
				$url = 'controlMidiasInterCasa/fluxo/'.$idInterProgramaCasa.'/fichaConclusao';
				break;
			default:				
				break;
		}
		
		$mensagem = array();					
		
		if(empty($tags)){
			$mensagem[] = "Por favor, informe a(s) Tag(s)";
		}		
		if(empty($sinopse)){
			$mensagem[] = "Por favor, informe a(s) Sinopse(s)";
		}

		if(count($bloco) < count($blocoAtual)){
			$mensagem[] = "Por favor, informe a duração dos Blocos";
		}else{
			foreach ($bloco as $key => $b) {
				if($b[0] == "00:00:00;00" || $b[0] == "00:00:00;00"){
					$mensagem[] = "Por favor, informe a duração dos Blocos";
				}
			}
		}
		
				
				
		if(count($mensagem)>0){
			 $this->session->set_flashdata('mensagem',$mensagem);
			 redirect(base_url() . $url,'refresh');
		}else{
						
			$data['idFichaConclusao'] = $idFichaConclusao;
			$data['apresentador'] = $apresentadores;
			$data['diretor'] = $diretor;
			$data['reporter'] = $reporter;
			$data['produtor'] = $produtor;
			$data['entrevistados'] = $entrevistados;
			$data['convidados'] = $convidados;
			$data['tags'] = $tags;
			$data['sinopse'] = $sinopse;
			$data['observacao'] = $observacao;	
			$data['dataVeiculacao'] = $dataVeiculacao;
			$data['dataFichaConclusao'] = Date('Y-m-d H:i:s');	
			$data['dataFimFichaConclusao'] = Date('Y-m-d H:i:s');		
			$data['usuario_id_fichaConclusao'] = $this->session->userdata('idUsuario');
			$data['ingest_id'] = $idIngest;
			$data['duracaoReal'] = $duracaoReal;			

			
			if($this->fichaConclusaoDao->updateFichaConclusaoParceiros($data,$bloco)){
				if($tipoIngest =='P'){
					$this->session->set_flashdata('resultado_ok','Ficha de Conclusão cadastrada com sucesso!');
				}else{					
					$this->session->set_flashdata('resultado_ok','Ficha de Conclusão cadastrada com sucesso!');						
				}													
				redirect(base_url() . $url,'refresh');
			}else{
				$this->session->set_flashdata('resultado_error','Erro ao Cadastrar a Ficha de Conclusão!');			
				redirect(base_url() . $url,'refresh');
			}
			
			
		}
		
		
	}

	function deleteFichaConclusaoParceiro(){
		$idIngest = $this->input->post('idIngest');
		$idFichaConclusao = $this->input->post('idFichaConclusao');

		if( $this->fichaConclusaoDao->deleteFichaConclusaoParceiro($idIngest,$idFichaConclusao)){
		    echo true;
		}else{
			echo false; 
		}
	}


}