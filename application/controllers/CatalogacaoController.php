<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CatalogacaoController extends CI_Controller {

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
		$this->load->model('revisaoClosedCaptionDao_model','revisaoClosedCaptionDao');
		$this->load->model('fichaConclusaoDao_model','fichaConclusaoDao');
		$this->load->model('catalogacaoDao_model','catalogacaoDao');
		$this->load->model('RevisaoCatalogacaoDao_model','revisaoCatalogacaoDao');
		$this->load->model('usuariosDao_model','usuariosDao');
	}


	function iniciarCatalogacao(){
		$idIngest = $this->input->post('idIngest');
		$idPauta = ($this->input->post('idPauta') != null)? $this->input->post('idPauta') : null;

		$data['idCatalogacao'] = null;
		$data['dataInicioCatalogacao'] = Date("Y-m-d H:i:s");
		$data['usuario_id_catalogacao'] = $this->session->userdata('idUsuario');
		$data['ingest_id'] = $idIngest;
		$data['pauta_id'] = $idPauta;
		if( $this->catalogacaoDao->iniciarCatalogacaoBanco($data)){
		    echo true;
		}else{
			echo false;
		}
	}




	function adicionarCatalogacao(){


		$idCatalogacao = $this->input->post('idCatalogacao');
		$idPauta = ($this->input->post('idPauta') != null)? $this->input->post('idPauta') : null;
		$idIngest = $this->input->post('idIngest');
		$idPrograma =  ($this->input->post('idPrograma') != null)? $this->input->post('idPrograma') : null;
        $idParceiros =  ($this->input->post('idParceiros') != null)? $this->input->post('idParceiros') : null;
        $idIngestParceiro =  ($this->input->post('idIngestParceiro') != null)? $this->input->post('idIngestParceiro') : null;

		$idInterProgramas = ($this->input->post('idInterProgramas') != null)? $this->input->post('idInterProgramas') : null;
		$idIngestInterPrograma = ($this->input->post('idIngestInterPrograma') != null)? $this->input->post('idIngestInterPrograma') : null;

		$idInterProgramaCasa =  ($this->input->post('idInterProgramaCasa') != null)? $this->input->post('idInterProgramaCasa') : null;
        $idIngestInterCasa =  ($this->input->post('idIngestInterCasa') != null)? $this->input->post('idIngestInterCasa') : null;

		$tipoFluxo =  $this->input->post('tipoFluxo');
		$tipoIngest =  $this->input->post('tipoIngest');

		$url = "";
		switch ($tipoIngest) {
			case 'C':
				if($tipoFluxo=='M'){
					$url = 'controlMidiasProgramaCasa/fluxo/'.$idPrograma.'/catalogacao/midias';
				}elseif($tipoFluxo=='B'){
					$url = 'controlMidiasProgramaCasa/fluxo/'.$idPrograma.'/catalogacao/brutas';
				}
				break;
			case 'CH':
				$url = 'controlMidiasChamadas/fluxo/'.$idPrograma.'/catalogacao';
				break;
			case 'CHP':
				$url = 'controlMidiasChamadasParceiros/fluxo/'.$idParceiros.'/catalogacao';
				break;
			case 'P':
				$url = 'MidiasParceirosController/viewfluxoParceiros/'.$idParceiros.'/catalogacao';
				break;
			case 'IC':
				$url = 'controlMidiasInterCasa/fluxo/'.$idInterProgramaCasa.'/catalogacao';
				break;
			case 'IP':
				$url = 'controlMidiasInterParceiros/fluxo/'.$idInterProgramas.'/catalogacao';
				break;

			default:

				break;
		}

		$data['idCatalogacao'] = $idCatalogacao;
		$data['dataFimCatalogacao'] = Date("Y-m-d H:i:s");


		if($this->catalogacaoDao->updateCatalogacao($data,$idIngest)){

			if($tipoIngest == 'P'){
				$this->session->set_flashdata('resultado_ok','Catalogação cadastrada com sucesso!');
			}else{
				$this->session->set_flashdata('resultado_ok','Catalogação cadastrada com sucesso!');
			}
			redirect(base_url() . $url,'refresh');
		}else{
			$this->session->set_flashdata('resultado_error','Erro ao Inserir a Catalogação!');
			redirect(base_url() . $url,'refresh');
		}

	}


	function corrigirCatalogacao(){


		$claquetes = is_array($this->input->post('claquete'))? $this->input->post('claquete'):null;
		$blocos = is_array($this->input->post('bloco'))? $this->input->post('bloco'):null;
		$materias = is_array($this->input->post('materia'))? $this->input->post('materia'): null ;
		$materiasRedacao = is_array($this->input->post('materiaRedacao'))? $this->input->post('materiaRedacao'): null ;
		$chamada = is_array($this->input->post('chamada'))? $this->input->post('chamada'): null ;

		$idIngest = $this->input->post('idIngest');
		$idPauta = ($this->input->post('idPauta') != null)? $this->input->post('idPauta') : null;
		$idPrograma =  ($this->input->post('idPrograma') != null)? $this->input->post('idPrograma') : null;

	    $idParceiros =  ($this->input->post('idParceiros') != null)? $this->input->post('idParceiros') : null;
        $idIngestParceiro =  ($this->input->post('idIngestParceiro') != null)? $this->input->post('idIngestParceiro') : null;

		$idInterProgramas = ($this->input->post('idInterProgramas') != null)? $this->input->post('idInterProgramas') : null;
		$idIngestInterPrograma = ($this->input->post('idIngestInterPrograma') != null)? $this->input->post('idIngestInterPrograma') : null;

		$idInterProgramaCasa =  ($this->input->post('idInterProgramaCasa') != null)? $this->input->post('idInterProgramaCasa') : null;
        $idIngestInterCasa =  ($this->input->post('idIngestInterCasa') != null)? $this->input->post('idIngestInterCasa') : null;

		$tipoFluxo =  $this->input->post('tipoFluxo');
		$tipoIngest =  $this->input->post('tipoIngest');

		$idCatalogacao = $this->input->post('idCatalogacao');

		$problemaClaquete = is_array($this->input->post('claqueteProblema'))? $this->input->post('claqueteProblema') : null;
		$blocoProblema = is_array($this->input->post('blocoProblema') )? $this->input->post('blocoProblema') : null;
		$materiaProblema = is_array($this->input->post('materiaProblema') )? $this->input->post('materiaProblema') : null;
		$materiaRedacaoProblema = is_array($this->input->post('materiaRedacaoProblema') )? $this->input->post('materiaRedacaoProblema') : null;
		$chamadaProblema = is_array($this->input->post('chamadaProblema') )? $this->input->post('chamadaProblema') : null;

		$respostaClaqueteProblema = is_array($this->input->post('respostaClaqueteProblema') )? $this->input->post('respostaClaqueteProblema') : null;
		$respostaBlocoProblema = is_array($this->input->post('respostaBlocoProblema') )? $this->input->post('respostaBlocoProblema') : null;



		$url = "";
		switch ($tipoIngest) {
			case 'C':
				if($tipoFluxo=='M'){
					$url = 'controlMidiasProgramaCasa/fluxo/'.$idPrograma.'/catalogacao/midias';
				}elseif($tipoFluxo=='B'){
					$url = 'controlMidiasProgramaCasa/fluxo/'.$idPrograma.'/catalogacao/brutas';
				}
				break;
			case 'CH':
				$url = 'controlMidiasChamadas/fluxo/'.$idPrograma.'/catalogacao';
				break;
			case 'CHP':
				$url = 'controlMidiasChamadasParceiros/fluxo/'.$idParceiros.'/catalogacao';
				break;
			case 'P':
				$url = 'MidiasParceirosController/viewfluxoParceiros/'.$idParceiros.'/catalogacao';
				break;
			case 'IC':
				$url = 'controlMidiasInterCasa/fluxo/'.$idInterProgramaCasa.'/catalogacao';
				break;
			case 'IP':
				$url = 'controlMidiasInterParceiros/fluxo/'.$idInterProgramas.'/catalogacao';
				break;

			default:

				break;
		}

		$mensagem = array();

		$claquetesAtuais = $this->revisaoCatalogacaoDao->selectClaquetesReprovadasRevisao($idIngest);
		$blocosAtuais = $this->revisaoCatalogacaoDao->selectBlocosReprovadasRevisao($idIngest);

		//$materiasAtuais = $this->dao_revisaocatalogacao_model->selectMateriasReprovadasRevisao($idIngest);



		if(count($claquetes) >0){
			foreach ($claquetes as $key => $c) {
				if($c[0] == ''){
					$mensagem[] = "Por favor, informe a Correção da(s) Claquete(s).";
				}
			}
		}

		if(count($blocos) >0){
			foreach ($blocos as $key => $b) {
				if($b[0] == ''){
					$mensagem[] = "Por favor, informe a Correção do(s) Bloco(s).";
				}
			}
		}

        if($tipoIngest == 'C'){
            if(count($materias) >0){
                foreach ($materias as $key => $m) {
                    if($m[0] == ''){
                        $mensagem[] = "Por favor, informe a Correção da(s) Materia(s).";
                    }
                }
            }
        }

		if($tipoIngest == 'CH' || $tipoIngest == 'CHP'){
            if(count($chamada) >0){
                foreach ($chamada as $key => $ch) {
                    if($ch[0] == ''){
                        $mensagem[] = "Por favor, informe a Correção da(s) Chamada(s).";
                    }
                }
            }
        }

		if(count($mensagem)>0){
			 $this->session->set_flashdata('mensagem',$mensagem);
			 redirect(base_url() . $url,'refresh');
		}else{


			$data['dataFimCatalogacao'] = Date("Y-m-d H:i:s");


			if($this->catalogacaoDao->updateCorrecaoCatalogacao($data,$idIngest,$materias,$materiasRedacao,$claquetes,$blocos,$chamada,$idCatalogacao,
			$tipoIngest,$problemaClaquete,$blocoProblema,$materiaProblema,$materiaRedacaoProblema,$chamadaProblema,$respostaClaqueteProblema,$respostaBlocoProblema)){

				$this->revisaoCatalogacaoDao->atualizaRevisaoCorrigido($idIngest);
				$this->session->set_flashdata('resultado_ok','Catalogação corrigida com sucesso!');
				redirect(base_url() . $url,'refresh');
			}else{
				$this->session->set_flashdata('resultado_error','Erro ao corrigir a Catalogação!');
				redirect(base_url() . $url,'refresh');
			}


		}
	}

	function deleteCatalogacaoParceiro(){
		$idIngest = $this->input->post('idIngest');
		$idCatalogacao = $this->input->post('idCatalogacao');

		if( $this->catalogacaoDao->deleteCatalogacaoParceiro($idIngest,$idCatalogacao)){
		    echo true;
		}else{
			echo false;
		}
	}

	function catalogarClosedCaption(){

		$idCatalogacao = $this->input->post('idCatalogacao');

		$data['idCatalogacao'] = $idCatalogacao;
		$data['dataCatalogacaoClosedCaption'] = Date("Y-m-d H:i:s");

		if($this->catalogacaoDao->updateCatalogacaoClosedCaption($data)){
			echo true;
		}else{
			echo false;
		}

	}

	function corrigirCatalogacaoClosedCaption(){

		$idIngest = $this->input->post('idIngest');
		$idPauta = $this->input->post('idPauta');
		$idPrograma =  ($this->input->post('idPrograma') != null)? $this->input->post('idPrograma') : null;

    	$idParceiros =  ($this->input->post('idParceiros') != null)? $this->input->post('idParceiros') : null;
    	$idIngestParceiro =  ($this->input->post('idIngestParceiro') != null)? $this->input->post('idIngestParceiro') : null;

    	$idInterProgramas =  ($this->input->post('idInterProgramas') != null)? $this->input->post('idInterProgramas') : null;
    	$idIngestInterPrograma =  ($this->input->post('idIngestInterPrograma') != null)? $this->input->post('idIngestInterPrograma') : null;

		$idInterProgramaCasa =  ($this->input->post('idInterProgramaCasa') != null)? $this->input->post('idInterProgramaCasa') : null;
    	$idIngestInterCasa =  ($this->input->post('idIngestInterCasa') != null)? $this->input->post('idIngestInterCasa') : null;

    	$tipoFluxo =  $this->input->post('tipoFluxo');
		$tipoIngest =  $this->input->post('tipoIngest');

		$closedCaption = $this->input->post('closedCaption');
		$idRevisaoCatalogacaoClosedCaptionProblema = $this->input->post('idRevisaoCatalogacaoClosedCaptionProblema');
		$resposta = $this->input->post('resposta');


		$url = "";
		switch ($tipoIngest) {
			case 'C':
				if($tipoFluxo=='M'){
					$url = 'controlMidiasProgramaCasa/fluxo/'.$idPrograma.'/catalogacao/midias';
				}elseif($tipoFluxo=='B'){
					$url = 'controlMidiasProgramaCasa/fluxo/'.$idPrograma.'/catalogacao/brutas';
				}
				break;
			case 'CH':
				$url = 'controlMidiasChamadas/fluxo/'.$idPrograma.'/catalogacao';
				break;
			case 'CHP':
				$url = 'controlMidiasChamadasParceiros/fluxo/'.$idParceiros.'/catalogacao';
				break;
			case 'P':
				$url = 'MidiasParceirosController/viewfluxoParceiros/'.$idParceiros.'/catalogacao';
				break;
			case 'IP':
				$url = 'controlMidiasInterParceiros/fluxo/'.$idInterProgramas.'/catalogacao';
				break;
			case 'IC':
				$url = 'controlMidiasInterCasa/fluxo/'.$idInterProgramaCasa.'/catalogacao';
				break;

			default:

				break;
		}

		$mensagem = array();


		if($closedCaption == ''){
			$mensagem[] = "Por favor, informe a Correção da Catalogação do <b>Closed Caption</>.";
		}


		if(count($mensagem)>0){
			 $this->session->set_flashdata('mensagem',$mensagem);
			 redirect(base_url() . $url,'refresh');
		}else{

			$data['dt_atualiza'] = Date("Y-m-d H:i:s");
			$data['usuario_atualiza'] = $this->session->userdata('idUsuario');

			if($this->catalogacaoDao->updateCorrecaoIngestClosedCaption($data,$idIngest,$idRevisaoCatalogacaoClosedCaptionProblema,$resposta)){

				$this->revisaoClosedCaptionDao->atualizaRevisaoCatalogacaoCorrigido($idIngest);
				$this->session->set_flashdata('resultado_ok','Catalogação de <b>Closed Caption</b> corrigido com sucesso!');
				redirect(base_url() . $url,'refresh');
			}else{
				$this->session->set_flashdata('resultado_error','Erro ao corrigir a Catalogação de <b>Closed Caption</b>!');
				redirect(base_url() . $url,'refresh');
			}


		}
	}

}
